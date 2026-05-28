{{-- Shared form partial for Create/Edit Fakultas --}}
@php $f = $fakultas ?? null; @endphp

@if($errors->any())
    <div class="p-4 bg-red-50 border border-red-200 rounded-xl">
        <ul class="list-disc list-inside text-sm text-red-600 space-y-1">
            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </div>
@endif

<div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
    <div>
        <label for="code" class="block text-sm font-medium text-gray-700 mb-1.5">Kode Fakultas <span class="text-red-500">*</span></label>
        <input type="text" id="code" name="code" value="{{ old('code', $f?->code) }}" required maxlength="20"
               class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow"
               placeholder="FT">
    </div>

    <div>
        <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Nama Fakultas <span class="text-red-500">*</span></label>
        <input type="text" id="name" name="name" value="{{ old('name', $f?->name) }}" required
               class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow"
               placeholder="Fakultas Teknik">
    </div>

    <div>
        <label for="dean_name" class="block text-sm font-medium text-gray-700 mb-1.5">Nama Dekan</label>
        <input type="text" id="dean_name" name="dean_name" value="{{ old('dean_name', $f?->dean_name) }}"
               class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow"
               placeholder="Prof. Dr. ...">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1.5">Status</label>
        <label class="inline-flex items-center gap-2 cursor-pointer">
            <input type="hidden" name="is_active" value="0">
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $f?->is_active ?? true) ? 'checked' : '' }}
                   class="w-5 h-5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
            <span class="text-sm text-gray-600">Aktif</span>
        </label>
    </div>
</div>
