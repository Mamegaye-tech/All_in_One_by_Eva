@php
    $field = 'mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-[#780D25] focus:outline-none focus:ring-1 focus:ring-[#780D25]';
    $dispos = $employe->exists ? $employe->disponibilites->keyBy('jour_semaine') : collect();
    $choisis = old('services', $employe->exists ? $employe->services->pluck('id')->all() : []);
@endphp

@csrf
<div class="space-y-8">
    <div>
        <h2 class="mb-3 font-semibold text-[#780D25]">Identité</h2>
        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label class="text-sm font-medium">Prénom *</label>
                <input type="text" name="prenom" value="{{ old('prenom', $employe->prenom) }}" required class="{{ $field }}">
                @error('prenom') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="text-sm font-medium">Nom *</label>
                <input type="text" name="nom" value="{{ old('nom', $employe->nom) }}" required class="{{ $field }}">
                @error('nom') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="text-sm font-medium">Téléphone *</label>
                <input type="tel" name="telephone" value="{{ old('telephone', $employe->telephone ? '+'.$employe->telephone : '') }}" placeholder="77 123 45 67" required class="{{ $field }}">
                @error('telephone') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="text-sm font-medium">Fonction *</label>
                <input type="text" name="fonction" value="{{ old('fonction', $employe->fonction) }}" placeholder="Ex. Coiffeuse" required class="{{ $field }}">
                @error('fonction') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div class="sm:col-span-2">
                <label class="text-sm font-medium">Spécialités</label>
                <input type="text" name="specialites" value="{{ old('specialites', $employe->specialites) }}" placeholder="Ex. tresses, coloration" class="{{ $field }}">
                @error('specialites') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            @can('voirCommissions', App\Models\Employe::class)
                <div>
                    <label class="text-sm font-medium">Taux de commission (%)</label>
                    <input type="number" step="0.01" min="0" max="100" name="taux_commission" value="{{ old('taux_commission', $employe->taux_commission) }}" class="{{ $field }}">
                    @error('taux_commission') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            @endcan
        </div>
    </div>

    <div>
        <h2 class="mb-1 font-semibold text-[#780D25]">Compte de connexion</h2>
        <p class="mb-3 text-xs text-gray-500">Rôle attribué automatiquement : Professionnel(le).</p>
        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label class="text-sm font-medium">E-mail *</label>
                <input type="email" name="email" value="{{ old('email', $employe->user?->email) }}" required class="{{ $field }}">
                @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="text-sm font-medium">Mot de passe {{ $employe->user_id ? '' : '*' }}</label>
                <input type="password" name="password" autocomplete="new-password" class="{{ $field }}">
                @if ($employe->user_id)
                    <p class="mt-1 text-xs text-gray-500">Laissez vide pour ne pas le changer.</p>
                @endif
                @error('password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>

    <div>
        <h2 class="mb-3 font-semibold text-[#780D25]">Prestations proposées</h2>
        <div class="grid gap-2 sm:grid-cols-3">
            @forelse ($services as $service)
                <label class="flex items-center gap-2 text-sm">
                    <input type="checkbox" name="services[]" value="{{ $service->id }}" @checked(in_array($service->id, $choisis))
                           class="rounded border-gray-300 text-[#780D25] focus:ring-[#780D25]">
                    {{ $service->nom }}
                </label>
            @empty
                <p class="text-sm text-gray-500 sm:col-span-3">Aucune prestation enregistrée pour le moment.</p>
            @endforelse
        </div>
        @error('services.*') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <h2 class="mb-3 font-semibold text-[#780D25]">Horaires de travail</h2>
        <div class="space-y-2">
            @foreach (App\Http\Requests\EmployeRequest::JOURS as $n => $label)
                @php $d = $dispos[$n] ?? null; @endphp
                <div class="flex flex-wrap items-center gap-3">
                    <label class="flex w-32 items-center gap-2 text-sm">
                        <input type="checkbox" name="jours[{{ $n }}][actif]" value="1" @checked(old("jours.$n.actif", (bool) $d))
                               class="rounded border-gray-300 text-[#780D25] focus:ring-[#780D25]">
                        {{ $label }}
                    </label>
                    <input type="time" name="jours[{{ $n }}][debut]" value="{{ old("jours.$n.debut", $d ? substr($d->heure_debut, 0, 5) : '09:00') }}"
                           class="rounded-lg border border-gray-300 px-3 py-1.5 text-sm">
                    <span class="text-sm text-gray-500">à</span>
                    <input type="time" name="jours[{{ $n }}][fin]" value="{{ old("jours.$n.fin", $d ? substr($d->heure_fin, 0, 5) : '18:00') }}"
                           class="rounded-lg border border-gray-300 px-3 py-1.5 text-sm">
                    @error("jours.$n.debut") <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                    @error("jours.$n.fin") <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            @endforeach
        </div>
        <p class="mt-2 text-xs text-gray-500">Cochez les jours travaillés. Les jours non cochés sont des jours de repos.</p>
    </div>
</div>

<div class="mt-8 flex gap-3">
    <button type="submit" class="rounded-lg bg-[#780D25] px-5 py-2 text-sm text-white hover:opacity-90">Enregistrer</button>
    <a href="{{ route('employes.index') }}" class="rounded-lg px-5 py-2 text-sm text-gray-600 hover:bg-white">Annuler</a>
</div>