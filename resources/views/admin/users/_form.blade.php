{{-- Shared form partial for Create/Edit Admin User --}}
@php $u = $user ?? null; @endphp

@if($errors->any())
    <div class="p-4 bg-red-50 border border-red-200 rounded-xl">
        <ul class="list-disc list-inside text-sm text-red-600 space-y-1">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
@endif

<div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
    <div class="sm:col-span-2">
        <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Nama <span class="text-red-500">*</span></label>
        <input type="text" id="name" name="name" value="{{ old('name', $u?->name) }}" required
               class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow"
               placeholder="Nama lengkap">
    </div>

    <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email <span class="text-red-500">*</span></label>
        <input type="email" id="email" name="email" value="{{ old('email', $u?->email) }}" required
               class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow"
               placeholder="admin@pemira.id">
    </div>

    <div>
        <label for="role" class="block text-sm font-medium text-gray-700 mb-1.5">Role <span class="text-red-500">*</span></label>
        <select id="role" name="role" required class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white">
            <option value="ADMIN" {{ old('role', $u?->role?->value) === 'ADMIN' ? 'selected' : '' }}>Admin</option>
            <option value="SUPER_ADMIN" {{ old('role', $u?->role?->value) === 'SUPER_ADMIN' ? 'selected' : '' }}>Super Admin</option>
        </select>
    </div>

    <div class="sm:col-span-2">
        <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">
            Password
            @if($u) <span class="text-gray-400 font-normal">(kosongkan jika tidak ingin mengubah)</span> @else <span class="text-red-500">*</span> @endif
        </label>
        <input type="password" id="password" name="password" {{ $u ? '' : 'required' }} minlength="8"
               class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow"
               placeholder="Minimal 8 karakter">
    </div>
</div>
