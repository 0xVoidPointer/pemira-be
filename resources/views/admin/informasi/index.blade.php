@extends('layouts.admin')
@section('title', 'Informasi Lainnya')
@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <h1 class="text-xl font-bold text-gray-900">Informasi Lainnya</h1>
        <p class="text-sm text-gray-500 mt-1">Kelola informasi umum Pemira: sambutan, peraturan, pemaparan, dan kontak</p>
    </div>

    <div class="bg-white rounded-2xl border border-gray-200/60 shadow-sm">
        <form action="{{ route('admin.informasi.update') }}" method="POST" class="p-6 space-y-6">
            @csrf @method('PUT')

            @if($errors->any())
                <div class="p-4 bg-red-50 border border-red-200 rounded-xl">
                    <ul class="list-disc list-inside text-sm text-red-600 space-y-1">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
            @endif

            <!-- Kata Sambutan -->
            <div>
                <label for="kata_sambutan" class="block text-sm font-medium text-gray-700 mb-1.5">
                    Kata Sambutan Ketua KPUR
                </label>
                <textarea id="kata_sambutan" name="kata_sambutan" rows="5"
                          class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow resize-none"
                          placeholder="Tuliskan kata sambutan dari Ketua KPUR...">{{ old('kata_sambutan', $settings['kata_sambutan']) }}</textarea>
            </div>

            <!-- Peraturan Pemira -->
            <div>
                <label for="peraturan_pemira" class="block text-sm font-medium text-gray-700 mb-1.5">
                    Peraturan Pemira
                </label>
                <textarea id="peraturan_pemira" name="peraturan_pemira" rows="8"
                          class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow resize-none"
                          placeholder="Tuliskan peraturan pemira...">{{ old('peraturan_pemira', $settings['peraturan_pemira']) }}</textarea>
            </div>

            <!-- Pemaparan Singkat -->
            <div>
                <label for="pemaparan_singkat" class="block text-sm font-medium text-gray-700 mb-1.5">
                    Pemaparan Singkat
                </label>
                <textarea id="pemaparan_singkat" name="pemaparan_singkat" rows="4"
                          class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow resize-none"
                          placeholder="Pemaparan singkat tentang Pemira...">{{ old('pemaparan_singkat', $settings['pemaparan_singkat']) }}</textarea>
            </div>

            <!-- Hotline -->
            <div>
                <label for="hotline" class="block text-sm font-medium text-gray-700 mb-1.5">
                    Hotline / Kontak Pengaduan
                </label>
                <input type="text" id="hotline" name="hotline" value="{{ old('hotline', $settings['hotline']) }}"
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow"
                       placeholder="Contoh: 0812-3456-7890 / pengaduan@pemira.id">
            </div>

            <div class="flex items-center justify-end pt-4 border-t border-gray-100">
                <button type="submit" class="px-6 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 rounded-xl shadow-lg shadow-indigo-500/20 transition-all duration-300">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
