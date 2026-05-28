{{-- Shared form partial for Create/Edit Kategori Pemilihan --}}
@php $k = $kategori ?? null; @endphp

@if($errors->any())
    <div class="p-4 bg-red-50 border border-red-200 rounded-xl">
        <ul class="list-disc list-inside text-sm text-red-600 space-y-1">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
@endif

<div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
    <div class="sm:col-span-2">
        <label for="title" class="block text-sm font-medium text-gray-700 mb-1.5">Judul <span class="text-red-500">*</span></label>
        <input type="text" id="title" name="title" value="{{ old('title', $k?->title) }}" required
               class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow"
               placeholder="Pemilihan Presiden BEM">
    </div>

    <div>
        <label for="period_id" class="block text-sm font-medium text-gray-700 mb-1.5">Periode <span class="text-red-500">*</span></label>
        <select id="period_id" name="period_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white">
            <option value="">Pilih Periode</option>
            @foreach($periodes as $p)
                <option value="{{ $p->id }}" {{ old('period_id', $k?->period_id) === $p->id ? 'selected' : '' }}>{{ $p->name }} ({{ $p->year }})</option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="type" class="block text-sm font-medium text-gray-700 mb-1.5">Tipe <span class="text-red-500">*</span></label>
        <select id="type" name="type" required class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white">
            <option value="PRESIDENT" {{ old('type', $k?->type?->value) === 'PRESIDENT' ? 'selected' : '' }}>Presiden</option>
            <option value="DPM" {{ old('type', $k?->type?->value) === 'DPM' ? 'selected' : '' }}>DPM</option>
            <option value="FACULTY_GOVERNOR" {{ old('type', $k?->type?->value) === 'FACULTY_GOVERNOR' ? 'selected' : '' }}>Gubernur Fakultas</option>
        </select>
    </div>

    <div>
        <label for="scope_faculty_id" class="block text-sm font-medium text-gray-700 mb-1.5">Fakultas (opsional)</label>
        <select id="scope_faculty_id" name="scope_faculty_id" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white">
            <option value="">Semua (Universitas)</option>
            @foreach($fakultas as $f)
                <option value="{{ $f->id }}" {{ old('scope_faculty_id', $k?->scope_faculty_id) === $f->id ? 'selected' : '' }}>{{ $f->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="max_winners" class="block text-sm font-medium text-gray-700 mb-1.5">Maks. Pemenang <span class="text-red-500">*</span></label>
        <input type="number" id="max_winners" name="max_winners" value="{{ old('max_winners', $k?->max_winners ?? 1) }}" required min="1"
               class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow">
    </div>

    <div class="sm:col-span-2">
        <label for="description" class="block text-sm font-medium text-gray-700 mb-1.5">Deskripsi</label>
        <textarea id="description" name="description" rows="3"
                  class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow resize-none"
                  placeholder="Deskripsi kategori pemilihan...">{{ old('description', $k?->description) }}</textarea>
    </div>

    <div>
        <label for="vote_start_at" class="block text-sm font-medium text-gray-700 mb-1.5">Voting Mulai (opsional)</label>
        <input type="datetime-local" id="vote_start_at" name="vote_start_at" value="{{ old('vote_start_at', $k?->vote_start_at?->format('Y-m-d\TH:i')) }}"
               class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow">
    </div>

    <div>
        <label for="vote_end_at" class="block text-sm font-medium text-gray-700 mb-1.5">Voting Selesai (opsional)</label>
        <input type="datetime-local" id="vote_end_at" name="vote_end_at" value="{{ old('vote_end_at', $k?->vote_end_at?->format('Y-m-d\TH:i')) }}"
               class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow">
    </div>
</div>
