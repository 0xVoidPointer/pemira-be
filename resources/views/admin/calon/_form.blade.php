{{-- Shared form partial for Create/Edit Calon --}}
@php $c = $calon ?? null; @endphp

@if($errors->any())
    <div class="p-4 bg-red-50 border border-red-200 rounded-xl">
        <ul class="list-disc list-inside text-sm text-red-600 space-y-1">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
@endif

<div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
    <div>
        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1.5">Kategori Pemilihan <span class="text-red-500">*</span></label>
        <select id="category_id" name="category_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white">
            <option value="">Pilih Kategori</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ old('category_id', $c?->category_id) === $cat->id ? 'selected' : '' }}>
                    {{ $cat->title }} ({{ $cat->scopeFaculty?->name ?? 'Universitas' }})
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="number" class="block text-sm font-medium text-gray-700 mb-1.5">Nomor Urut <span class="text-red-500">*</span></label>
        <input type="number" id="number" name="number" value="{{ old('number', $c?->number) }}" required min="1"
               class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow">
    </div>

    <div>
        <label for="nama_ketua" class="block text-sm font-medium text-gray-700 mb-1.5">Nama Ketua <span class="text-red-500">*</span></label>
        <input type="text" id="nama_ketua" name="nama_ketua" value="{{ old('nama_ketua', $c?->members?->where('role', \App\Enums\CandidateMemberRole::Ketua)->first()?->student?->full_name) }}" required
               class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow"
               placeholder="Nama lengkap ketua">
    </div>

    <div>
        <label for="nama_wakil" class="block text-sm font-medium text-gray-700 mb-1.5">Nama Wakil</label>
        <input type="text" id="nama_wakil" name="nama_wakil" value="{{ old('nama_wakil', $c?->members?->where('role', \App\Enums\CandidateMemberRole::Wakil)->first()?->student?->full_name) }}"
               class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow"
               placeholder="Nama lengkap wakil (opsional)">
    </div>

    <div class="sm:col-span-2">
        <label for="photo" class="block text-sm font-medium text-gray-700 mb-1.5">Foto Paslon</label>
        @if($c?->photo_url)
            <div class="mb-3">
                <img src="{{ asset('storage/' . $c->photo_url) }}" alt="Current photo" class="w-24 h-24 rounded-xl object-cover border-2 border-gray-100">
            </div>
        @endif
        <input type="file" id="photo" name="photo" accept="image/*"
               class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition-colors">
        <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG. Maks: 2MB</p>
    </div>

    <div class="sm:col-span-2">
        <label for="vision" class="block text-sm font-medium text-gray-700 mb-1.5">Visi <span class="text-red-500">*</span></label>
        <textarea id="vision" name="vision" rows="4" required
                  class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow resize-none"
                  placeholder="Visi paslon...">{{ old('vision', $c?->vision) }}</textarea>
    </div>

    <div class="sm:col-span-2">
        <label for="mission" class="block text-sm font-medium text-gray-700 mb-1.5">Misi <span class="text-red-500">*</span></label>
        <textarea id="mission" name="mission" rows="6" required
                  class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow resize-none"
                  placeholder="Misi paslon (bisa berupa poin-poin)...">{{ old('mission', $c?->mission) }}</textarea>
    </div>
</div>
