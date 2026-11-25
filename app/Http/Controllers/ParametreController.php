<?php

namespace App\Http\Controllers;

use App\Enums\Permission;
use App\Enums\TypeMessage;
use App\Models\ModeleMessage;
use App\Models\ParametreSalon;
use Illuminate\Http\Request;

class ParametreController extends Controller
{
    private const CLES_SALON = ['salon_nom', 'salon_telephone', 'salon_adresse', 'salon_horaires'];

    /** Variables reconnues par WhatsAppService::remplir(). */
    public const VARIABLES = ['Prénom', 'date', 'heure', 'prestation'];

    private const MODELES_DEFAUT = [
        'anniversaire' => "Bonjour [Prénom] ! Toute l'équipe d'All in One by Eva te souhaite un merveilleux anniversaire. Pour célébrer cette journée spéciale, nous serions ravis de t'accueillir à nouveau au salon. À très bientôt !",
        'promotion' => "Bonjour [Prénom] ! All in One by Eva a une nouvelle offre beauté à te faire découvrir. Contacte-nous pour connaître les détails et réserver ton prochain moment de bien-être.",
        'rappel_rdv' => "Bonjour [Prénom] ! Nous te rappelons ton rendez-vous chez All in One by Eva prévu le [date] à [heure] pour [prestation]. Nous avons hâte de t'accueillir.",
        'fidelisation' => "Bonjour [Prénom] ! Cela fait quelque temps que nous ne t'avons pas accueilli chez All in One by Eva. Nous serions heureux de te retrouver pour un nouveau moment de détente et de beauté.",
    ];

    public function index(Request $request)
    {
        $this->autoriser();

        $onglet = in_array($request->query('onglet'), ['salon', 'messages', 'regles'], true)
            ? $request->query('onglet')
            : 'salon';

        $salon = collect(self::CLES_SALON)
            ->mapWithKeys(fn ($cle) => [$cle => (string) ParametreSalon::get($cle, '')]);

        $modeles = ModeleMessage::all()->keyBy(fn ($m) => $m->type->value);

        return view('parametres.index', [
            'onglet' => $onglet,
            'salon' => $salon,
            'modeles' => $modeles,
            'defauts' => self::MODELES_DEFAUT,
            'variables' => self::VARIABLES,
            'regles' => [
                'pause_minutes' => ParametreSalon::get('pause_minutes', 0),
                'fidelite_fcfa_par_point' => ParametreSalon::get('fidelite_fcfa_par_point', 1000),
                'inactivite_semaines' => ParametreSalon::get('inactivite_semaines', 6),
                'offre_anniversaire' => (string) ParametreSalon::get('offre_anniversaire', ''),
            ],
        ]);
    }

    public function updateSalon(Request $request)
    {
        $this->autoriser();

        $data = $request->validate([
            'salon_nom' => ['required', 'string', 'max:150'],
            'salon_telephone' => ['nullable', 'string', 'max:30'],
            'salon_adresse' => ['nullable', 'string', 'max:255'],
            'salon_horaires' => ['nullable', 'string', 'max:500'],
        ], [], [
            'salon_nom' => 'nom du salon',
            'salon_telephone' => 'téléphone',
            'salon_adresse' => 'adresse',
            'salon_horaires' => "horaires d'ouverture",
        ]);

        foreach (self::CLES_SALON as $cle) {
            ParametreSalon::set($cle, $data[$cle] ?? '');
        }

        return redirect()->route('parametres.index', ['onglet' => 'salon'])
            ->with('success', 'Informations du salon enregistrées.');
    }

    public function updateMessages(Request $request)
    {
        $this->autoriser();

        $data = $request->validate([
            'modeles' => ['required', 'array'],
            'modeles.*.titre' => ['required', 'string', 'max:100'],
            'modeles.*.contenu' => ['required', 'string', 'max:1000', function ($attribute, $value, $fail) {
                preg_match_all('/\[([^\]]+)\]/', $value, $m);
                $inconnues = array_diff($m[1], self::VARIABLES);

                if ($inconnues) {
                    $fail('Variable inconnue : [' . implode('], [', $inconnues) . ']. Variables permises : ['
                        . implode('], [', self::VARIABLES) . '].');
                }
            }],
        ], [], [
            'modeles.*.titre' => 'titre',
            'modeles.*.contenu' => 'message',
        ]);

        foreach (TypeMessage::cases() as $type) {
            if (! isset($data['modeles'][$type->value])) {
                continue;
            }

            ModeleMessage::updateOrCreate(
                ['type' => $type->value],
                [
                    'titre' => $data['modeles'][$type->value]['titre'],
                    'contenu' => $data['modeles'][$type->value]['contenu'],
                ]
            );
        }

        return redirect()->route('parametres.index', ['onglet' => 'messages'])
            ->with('success', 'Modèles de messages enregistrés.');
    }

    public function updateRegles(Request $request)
    {
        $this->autoriser();

        $data = $request->validate([
            'pause_minutes' => ['required', 'integer', 'between:0,120'],
            'fidelite_fcfa_par_point' => ['required', 'integer', 'min:1'],
            'inactivite_semaines' => ['required', 'integer', 'between:1,52'],
            'offre_anniversaire' => ['nullable', 'string', 'max:255'],
        ], [], [
            'pause_minutes' => 'pause entre prestations',
            'fidelite_fcfa_par_point' => 'FCFA par point',
            'inactivite_semaines' => "semaines d'inactivité",
            'offre_anniversaire' => "offre d'anniversaire",
        ]);

        foreach ($data as $cle => $valeur) {
            ParametreSalon::set($cle, $valeur);
        }

        return redirect()->route('parametres.index', ['onglet' => 'regles'])
            ->with('success', 'Règles du salon enregistrées.');
    }

    private function autoriser(): void
    {
        $user = auth()->user();

        abort_unless($user->isAdmin() || $user->hasPermission(Permission::ParametresGerer), 403);
    }
}
