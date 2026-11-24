@php
    $champs = [
        'prenom' => ['Prénom', 'text'],
        'nom' => ['Nom', 'text'],
        'telephone' => ['Téléphone', 'text'],
        'fonction' => ['Fonction', 'text'],
        'taux_commission' => ['Taux de commission (%)', 'number'],
    ];
@endphp

@foreach ($champs as $name => [$label, $type])
    <div>
        <label for="{{ $name }}" class="mb-1 block text-sm font-semibold text-[#563b4c]">{{ $label }}</label>
        <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}"
               @if ($type === 'number') step="0.01" min="0" max="100" @endif
               value="{{ old($name, $employe->$name ?? '') }}"
               class="w-full rounded-xl border border-[#e8d7df] px-4 py-3 text-sm focus:border-[#780d25] focus:outline-none">
        @error($name)
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>
@endforeach

<div>
    <label for="specialites" class="mb-1 block text-sm font-semibold text-[#563b4c]">Spécialités</label>
    <textarea id="specialites" name="specialites" rows="3"
              class="w-full rounded-xl border border-[#e8d7df] px-4 py-3 text-sm focus:border-[#780d25] focus:outline-none">{{ old('specialites', $employe->specialites ?? '') }}</textarea>
    @error('specialites')
        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
    @enderror
</div>

<label class="flex items-center gap-2 text-sm font-semibold text-[#563b4c]">
    <input type="hidden" name="is_active" value="0">
    <input type="checkbox" name="is_active" value="1"
           @checked(old('is_active', $employe->is_active ?? true))>
    Membre actif
</label>