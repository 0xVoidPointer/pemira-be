{{-- Shared form partial for Create/Edit Periode --}}
@php $p = $periode ?? null; @endphp

{{-- Validation Errors --}}
@if($errors->any())
    <div class="p-4 bg-red-50 border border-red-200 rounded-xl">
        <ul class="list-disc list-inside text-sm text-red-600 space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
    <div class="sm:col-span-2">
        <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Nama Periode <span class="text-red-500">*</span></label>
        <input type="text" id="name" name="name" value="{{ old('name', $p?->name) }}" required
               class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow"
               placeholder="Pemira 2026">
    </div>

    <div>
        <label for="year" class="block text-sm font-medium text-gray-700 mb-1.5">Tahun <span class="text-red-500">*</span></label>
        <input type="number" id="year" name="year" value="{{ old('year', $p?->year ?? date('Y')) }}" required min="2020" max="2099"
               class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow">
    </div>

    <div>
        <label for="status" class="block text-sm font-medium text-gray-700 mb-1.5">Status <span class="text-red-500">*</span></label>
        <select id="status" name="status" required
                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow bg-white">
            <option value="DRAFT" {{ old('status', $p?->status?->value) === 'DRAFT' ? 'selected' : '' }}>Draft</option>
            <option value="VOTING" {{ old('status', $p?->status?->value) === 'VOTING' ? 'selected' : '' }}>Voting (Aktif)</option>
            <option value="DONE" {{ old('status', $p?->status?->value) === 'DONE' ? 'selected' : '' }}>Selesai</option>
        </select>
    </div>

    <div>
        <label for="reg_start_at" class="block text-sm font-medium text-gray-700 mb-1.5">Registrasi Mulai <span class="text-red-500">*</span></label>
        <input type="datetime-local" id="reg_start_at" name="reg_start_at" required
               value="{{ old('reg_start_at', $p?->reg_start_at?->format('Y-m-d\TH:i')) }}"
               class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow">
    </div>

    <div>
        <label for="reg_end_at" class="block text-sm font-medium text-gray-700 mb-1.5">Registrasi Selesai <span class="text-red-500">*</span></label>
        <input type="datetime-local" id="reg_end_at" name="reg_end_at" required
               value="{{ old('reg_end_at', $p?->reg_end_at?->format('Y-m-d\TH:i')) }}"
               class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow">
    </div>

    <div>
        <label for="vote_start_at" class="block text-sm font-medium text-gray-700 mb-1.5">Voting Mulai <span class="text-red-500">*</span></label>
        <input type="datetime-local" id="vote_start_at" name="vote_start_at" required
               value="{{ old('vote_start_at', $p?->vote_start_at?->format('Y-m-d\TH:i')) }}"
               class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow">
    </div>

    <div>
        <label for="vote_end_at" class="block text-sm font-medium text-gray-700 mb-1.5">Voting Selesai <span class="text-red-500">*</span></label>
        <input type="datetime-local" id="vote_end_at" name="vote_end_at" required
               value="{{ old('vote_end_at', $p?->vote_end_at?->format('Y-m-d\TH:i')) }}"
               class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow">
    </div>
</div>
