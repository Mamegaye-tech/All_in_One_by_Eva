@php
    $field = 'mt-1 block w-full rounded-lg border-gray-300 text-sm focus:border-[#780D25] focus:ring-[#780D25]';
@endphp

@csrf
<div class="grid gap-5 sm:grid-cols-2">
    <div>
        <label class="text-sm font-medium">Prénom *</label>
        <input type="text" name="prenom" value="{{ old('prenom', $client->prenom) }}" required class="{{ $field }}">
        @error('prenom') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="text-sm font-medium">Nom *</label>
        <input type="text" name="nom" value="{{ old('nom', $client->nom) }}" required class="{{ $field }}">
        @error('nom') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="text-sm font-medium">Téléphone *</label>
        <input type="tel" name="telephone" value="{{ old('telephone', $client->telephone ? '+'.$client->telephone : '') }}"
               placeholder="77 123 45 67" required class="{{ $field }}">
        @error('telephone') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="text-sm font-medium">WhatsApp (si différent)</label>
        <input type="tel" name="whatsapp" value="{{ old('whatsapp', $client->whatsapp ? '+'.$client->whatsapp : '') }}" class="{{ $field }}">
        @error('whatsapp') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="text-sm font-medium">E-mail</label>
        <input type="email" name="email" value="{{ old('email', $client->email) }}" class="{{ $field }}">
        @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="text-sm font-medium">Date de naissance</label>
        <input type="date" name="date_naissance" max="{{ now()->toDateString() }}"
               value="{{ old('date_naissance', $client->date_naissance?->format('Y-m-d')) }}" class="{{ $field }}">
        @error('date_naissance') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="text-sm font-medium">Préférence de communication *</label>
        <select name="preference_communication" class="{{ $field }}">
            @foreach (App\Http\Requests\ClientRequest::PREFERENCES as $value => $label)
                <option value="{{ $value }}" @selected(old('preference_communication', $client->preference_communication) === $value)>{{ $label }}</option>
            @endforeach
        </select>
        @error('preference_communication') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="text-sm font-medium">Préférences de prestations</label>
        <input type="text" name="preferences_prestations" value="{{ old('preferences_prestations', $client->preferences_prestations) }}"
               placeholder="Ex. tresses, manucure" class="{{ $field }}">
        @error('preferences_prestations') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
    </div>
    <div class="sm:col-span-2">
        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="consentement_promo" value="1" @checked(old('consentement_promo', $client->consentement_promo))
                   class="rounded border-gray-300 text-[#780D25] focus:ring-[#780D25]">
            Le client accepte de recevoir des messages promotionnels
        </label>
    </div>
    <div class="sm:col-span-2">
        <label class="text-sm font-medium">Notes utiles</label>
        <textarea name="notes" rows="3" class="{{ $field }}">{{ old('notes', $client->notes) }}</textarea>
        @error('notes') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
    </div>
</div>

<div class="mt-6 flex gap-3">
    <button type="submit" class="rounded-lg bg-[#780D25] px-5 py-2 text-sm text-white hover:opacity-90">Enregistrer</button>
    <a href="{{ route('clients.index') }}" class="rounded-lg px-5 py-2 text-sm text-gray-600 hover:bg-white">Annuler</a>
</div>