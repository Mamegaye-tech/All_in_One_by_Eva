<?php

namespace App\Http\Requests;

use App\Services\WhatsAppService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Validator;

class EmployeRequest extends FormRequest
{
    public const JOURS = [
        1 => 'Lundi', 2 => 'Mardi', 3 => 'Mercredi', 4 => 'Jeudi',
        5 => 'Vendredi', 6 => 'Samedi', 7 => 'Dimanche',
    ];

    public function authorize(): bool
    {
        return true; // droits vérifiés dans le contrôleur via EmployePolicy
    }

    public function rules(): array
    {
        $employe = $this->route('employe');
        $whatsapp = app(WhatsAppService::class);

        return [
            'prenom' => ['required', 'string', 'max:100'],
            'nom' => ['required', 'string', 'max:100'],
            'telephone' => ['required', 'string', 'max:30', function ($attribute, $value, $fail) use ($whatsapp) {
                if (! $whatsapp->numeroValide($value)) {
                    $fail('Numéro invalide. Exemple : 77 123 45 67.');
                }
            }],
            'fonction' => ['required', 'string', 'max:255'],
            'specialites' => ['nullable', 'string', 'max:255'],
            'taux_commission' => ['nullable', 'numeric', 'between:0,100'],

            'email' => ['required', 'email', 'max:255',
                Rule::unique('users', 'email')->ignore($employe?->user_id)],
            'password' => [$employe?->user_id ? 'nullable' : 'required', Password::min(8)],

            'services' => ['nullable', 'array'],
            'services.*' => ['integer', 'exists:services,id'],

            'jours' => ['nullable', 'array'],
            'jours.*.actif' => ['nullable', 'boolean'],
            'jours.*.debut' => ['nullable', 'date_format:H:i'],
            'jours.*.fin' => ['nullable', 'date_format:H:i'],
        ];
    }

    public function after(): array
    {
        return [function (Validator $validator) {
            foreach ((array) $this->input('jours', []) as $jour => $j) {
                if (empty($j['actif'])) {
                    continue;
                }

                if (empty($j['debut']) || empty($j['fin'])) {
                    $validator->errors()->add("jours.$jour.debut", 'Renseignez les heures de début et de fin.');
                } elseif ($j['fin'] <= $j['debut']) {
                    $validator->errors()->add("jours.$jour.fin", "L'heure de fin doit être après l'heure de début.");
                }
            }
        }];
    }

    public function attributes(): array
    {
        return [
            'prenom' => 'prénom',
            'telephone' => 'téléphone',
            'specialites' => 'spécialités',
            'taux_commission' => 'taux de commission',
            'email' => 'e-mail',
            'password' => 'mot de passe',
        ];
    }
}