<?php

namespace App\Models;

use App\Enums\StatutClient;
use App\Enums\StatutRendezVous;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Services\WhatsAppService;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'prenom', 'nom', 'telephone', 'whatsapp', 'email', 'date_naissance', 'date_inscription',
        'preference_communication', 'consentement_promo', 'consentement_modifie_le',
        'preferences_prestations', 'notes', 'statut',
    ];

    protected function casts(): array
    {
        return [
            'date_naissance' => 'date',
            'date_inscription' => 'date',
            'consentement_promo' => 'boolean',
            'consentement_modifie_le' => 'datetime',
            'statut' => StatutClient::class,
        ];
    }

    protected function nomComplet(): Attribute
    {
        return Attribute::get(fn () => "{$this->prenom} {$this->nom}");
    }

    public function rendezVous(): HasMany
    {
        return $this->hasMany(RendezVous::class);
    }

    public function paiements(): HasMany
    {
        return $this->hasMany(Paiement::class);
    }

    public function mouvementsPoints(): HasMany
    {
        return $this->hasMany(MouvementPoints::class);
    }

    public function anniversairesTraites(): HasMany
    {
        return $this->hasMany(AnniversaireTraite::class);
    }

    public function soldePoints(): int
    {
        return (int) $this->mouvementsPoints()->sum('points');
    }

    public function derniereVisite(): ?CarbonInterface
    {
        return $this->rendezVous()
            ->where('statut', StatutRendezVous::Termine)
            ->latest('debut')
            ->first()?->debut;
    }

    public function numeroWhatsApp(): string
    {
        return $this->whatsapp ?: $this->telephone;
    }

        protected function telephoneAffiche(): Attribute
    {
        return Attribute::get(fn () => self::formaterNumero($this->telephone));
    }

    protected function whatsappAffiche(): Attribute
    {
        return Attribute::get(fn () => self::formaterNumero($this->numeroWhatsApp()));
    }

    public static function formaterNumero(?string $numero): string
    {
        if (! $numero) {
            return '';
        }

        if (str_starts_with($numero, '221') && strlen($numero) === 12) {
            $n = substr($numero, 3);

            return '+221 '.substr($n, 0, 2).' '.substr($n, 2, 3).' '.substr($n, 5, 2).' '.substr($n, 7, 2);
        }

        return '+'.$numero;
    }

    /** Lien wa.me (null si le numéro est invalide). L'utilisateur envoie le message lui-même. */
    public function lienWhatsApp(?string $message = null): ?string
    {
        $service = app(WhatsAppService::class);

        if (! $service->numeroValide($this->numeroWhatsApp())) {
            return null;
        }

        return $service->lien($this->numeroWhatsApp(), $message ?? '');
    }

    public function scopeFiltrer(Builder $query, array $filtres): void
    {
        $query->recherche($filtres['q'] ?? null)
            ->when(
                $filtres['statut'] ?? null,
                fn ($q, $statut) => $q->where('statut', $statut),
                fn ($q) => $q->nonArchives()
            )
            ->when(($filtres['consentement'] ?? null) === 'oui', fn ($q) => $q->where('consentement_promo', true))
            ->when(($filtres['consentement'] ?? null) === 'non', fn ($q) => $q->where('consentement_promo', false));
    }
    
    public function scopeRecherche(Builder $query, ?string $terme): void
    {
        $terme = trim((string) $terme);

        if ($terme === '') {
            return;
        }

        $chiffres = preg_replace('/\D/', '', $terme);

        $query->where(function (Builder $q) use ($terme, $chiffres) {
            $q->where('prenom', 'like', "%{$terme}%")
                ->orWhere('nom', 'like', "%{$terme}%");

            if ($chiffres !== '') {
                $q->orWhere('telephone', 'like', "%{$chiffres}%")
                    ->orWhere('whatsapp', 'like', "%{$chiffres}%");
            }
        });
    }

    public function scopeNonArchives(Builder $query): void
    {
        $query->where('statut', '!=', StatutClient::Archive);
    }

    /** Clients dont la dernière prestation terminée date de plus de N semaines. */
    public function scopeInactifsDepuis(Builder $query, int $semaines): void
    {
        $limite = now()->subWeeks($semaines);

        $query->nonArchives()
            ->whereHas('rendezVous', fn (Builder $q) => $q->where('statut', StatutRendezVous::Termine))
            ->whereDoesntHave('rendezVous', fn (Builder $q) => $q
                ->where('statut', StatutRendezVous::Termine)
                ->where('debut', '>=', $limite));
    }
}
