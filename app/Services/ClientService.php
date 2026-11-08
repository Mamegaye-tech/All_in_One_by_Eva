<?php

namespace App\Services;

use App\Enums\StatutClient;
use App\Models\Client;
use Illuminate\Support\Facades\DB;

class ClientService
{
    public function __construct(private WhatsAppService $whatsapp) {}

    public function create(array $data): Client
    {
        return DB::transaction(function () use ($data) {
            $data = $this->prepare($data);
            $data['date_inscription'] = now()->toDateString();
            $data['statut'] = StatutClient::Actif;

            if ($data['consentement_promo']) {
                $data['consentement_modifie_le'] = now();
            }

            return Client::create($data);
        });
    }

    public function update(Client $client, array $data): Client
    {
        return DB::transaction(function () use ($client, $data) {
            $data = $this->prepare($data);

            if ($client->consentement_promo !== $data['consentement_promo']) {
                $data['consentement_modifie_le'] = now();
            }

            $client->update($data);

            return $client;
        });
    }

    /** Désactive ou réactive un client. Aucune suppression physique. */
    public function toggleStatus(Client $client): Client
    {
        $client->update([
            'statut' => $client->statut === StatutClient::Actif ? StatutClient::Inactif : StatutClient::Actif,
        ]);

        return $client;
    }

    private function prepare(array $data): array
    {
        $data['telephone'] = $this->whatsapp->normaliserNumero($data['telephone']);

        $wa = ! empty($data['whatsapp']) ? $this->whatsapp->normaliserNumero($data['whatsapp']) : null;
        $data['whatsapp'] = ($wa && $wa !== $data['telephone']) ? $wa : null;

        $data['consentement_promo'] = (bool) ($data['consentement_promo'] ?? false);

        return $data;
    }
}