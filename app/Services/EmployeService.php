<?php

namespace App\Services;

use App\Enums\Role as RoleEnum;
use App\Models\Employe;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class EmployeService
{
    public function __construct(private WhatsAppService $whatsapp) {}

    public function create(array $data): Employe
    {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => "{$data['prenom']} {$data['nom']}",
                'email' => $data['email'],
                'password' => $data['password'],
                'role_id' => Role::where('name', RoleEnum::Professionnel->value)->firstOrFail()->id,
                'is_active' => true,
            ]);

            $employe = Employe::create($this->attributs($data) + ['user_id' => $user->id, 'is_active' => true]);

            $this->synchroniser($employe, $data);

            return $employe;
        });
    }

    public function update(Employe $employe, array $data): Employe
    {
        return DB::transaction(function () use ($employe, $data) {
            $employe->update($this->attributs($data));

            if ($employe->user) {
                $employe->user->name = "{$data['prenom']} {$data['nom']}";
                $employe->user->email = $data['email'];
                if (! empty($data['password'])) {
                    $employe->user->password = $data['password'];
                }
                $employe->user->save();
            } else {
                // Fiche existante sans compte : on en crée un
                $user = User::create([
                    'name' => "{$data['prenom']} {$data['nom']}",
                    'email' => $data['email'],
                    'password' => $data['password'],
                    'role_id' => Role::where('name', RoleEnum::Professionnel->value)->firstOrFail()->id,
                    'is_active' => $employe->is_active,
                ]);
                $employe->update(['user_id' => $user->id]);
            }

            $this->synchroniser($employe, $data);

            return $employe;
        });
    }

    /** Désactive ou réactive la fiche ET le compte de connexion. Aucune suppression. */
    public function toggleStatus(Employe $employe): Employe
    {
        return DB::transaction(function () use ($employe) {
            $actif = ! $employe->is_active;

            $employe->update(['is_active' => $actif]);
            $employe->user?->update(['is_active' => $actif]);

            return $employe;
        });
    }

    private function attributs(array $data): array
    {
        $attributs = [
            'prenom' => $data['prenom'],
            'nom' => $data['nom'],
            'telephone' => $this->whatsapp->normaliserNumero($data['telephone']),
            'fonction' => $data['fonction'],
            'specialites' => $data['specialites'] ?? null,
        ];

        // Présent seulement si l'utilisateur a le droit de le modifier
        if (array_key_exists('taux_commission', $data)) {
            $attributs['taux_commission'] = $data['taux_commission'];
        }

        return $attributs;
    }

    private function synchroniser(Employe $employe, array $data): void
    {
        $employe->services()->sync($data['services'] ?? []);

        $employe->disponibilites()->delete();

        foreach (range(1, 7) as $jour) {
            $j = $data['jours'][$jour] ?? null;

            if (! empty($j['actif']) && ! empty($j['debut']) && ! empty($j['fin'])) {
                $employe->disponibilites()->create([
                    'jour_semaine' => $jour,
                    'heure_debut' => $j['debut'],
                    'heure_fin' => $j['fin'],
                ]);
            }
        }
    }
}