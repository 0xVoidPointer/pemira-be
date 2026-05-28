@extends('layouts.admin')
@section('title', 'Edit Calon / Paslon')
@section('content')
<div class="max-w-3xl mx-auto">
    <a href="{{ route('admin.calon.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-indigo-600 mb-6 transition-colors">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
        Kembali
    </a>
    <div class="bg-white rounded-2xl border border-gray-200/60 shadow-sm">
        <div class="px-6 py-5 border-b border-gray-100">
            <h2 class="text-lg font-bold text-gray-900">Edit Calon / Paslon</h2>
            <p class="text-sm text-gray-500 mt-1">Nomor Urut {{ $calon->number }}</p>
        </div>
        <form action="{{ route('admin.calon.update', $calon) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
            @csrf @method('PUT')
            @include('admin.calon._form', ['calon' => $calon])
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.calon.index') }}" class="px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition-colors">Batal</a>
                <button type="submit" class="px-6 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl shadow-lg shadow-indigo-500/20 transition-all duration-300">Perbarui</button>
            </div>
        </form>
    </div>
</div>
@endsection
