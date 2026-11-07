<?php

namespace App\Http\Requests;

use App\Models\Client;
use App\Services\WhatsAppService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClientRequest extends FormRequest
{
    public const PREFERENCES = [
        'whatsapp' => 'WhatsApp',
        'appel' => 'Appel',
        'sms' => 'SMS',
        'email' => 'E-mail',
    ];

    public function authorize(): bool
    {
        return true; // droits vérifiés dans le contrôleur via ClientPolicy
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['consentement_promo' => $this->boolean('consentement_promo')]);
    }

    public function rules(): array
    {
        $whatsapp = app(WhatsAppService::class);

        return [
            'prenom' => ['required', 'string', 'max:100'],
            'nom' => ['required', 'string', 'max:100'],
            'telephone' => ['required', 'string', 'max:30', function ($attribute, $value, $fail) use ($whatsapp) {
                if (! $whatsapp->numeroValide($value)) {
                    return $fail('Numéro invalide. Exemple : 77 123 45 67 ou +221 77 123 45 67.');
                }

                $existant = Client::where('telephone', $whatsapp->normaliserNumero($value))
                    ->when($this->route('client'), fn ($q, $client) => $q->whereKeyNot($client->id))
                    ->first();

                if ($existant) {
                    $fail("Ce numéro est déjà enregistré pour {$existant->nom_complet}.");
                }
            }],
            'whatsapp' => ['nullable', 'string', 'max:30', function ($attribute, $value, $fail) use ($whatsapp) {
                if ($value && ! $whatsapp->numeroValide($value)) {
                    $fail('Numéro WhatsApp invalide.');
                }
            }],
            'email' => ['nullable', 'email', 'max:255'],
            'date_naissance' => ['nullable', 'date', 'before_or_equal:today'],
            'preference_communication' => ['required', Rule::in(array_keys(self::PREFERENCES))],
            'consentement_promo' => ['boolean'],
            'preferences_prestations' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ];
    }

    public function attributes(): array
    {
        return [
            'prenom' => 'prénom',
            'telephone' => 'téléphone',
            'date_naissance' => 'date de naissance',
            'preference_communication' => 'préférence de communication',
            'preferences_prestations' => 'préférences de prestations',
        ];
    }
}