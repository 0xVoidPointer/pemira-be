<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AuditHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\KategoriRequest;
use App\Models\ElectionCategory;
use App\Models\ElectionPeriod;
use App\Models\Faculty;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class KategoriController extends Controller
{
    public function index(): View
    {
        $kategoris = ElectionCategory::with(['period', 'scopeFaculty'])
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('admin.kategori.index', compact('kategoris'));
    }

    public function create(): View
    {
        $periodes = ElectionPeriod::orderByDesc('year')->get();
        $fakultas = Faculty::orderBy('name')->get();

        return view('admin.kategori.create', compact('periodes', 'fakultas'));
    }

    public function store(KategoriRequest $request): RedirectResponse
    {
        $category = ElectionCategory::create($request->validated());

        AuditHelper::log('CREATE', 'ElectionCategory', $category->id, ['title' => $category->title]);

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori Pemilihan berhasil ditambahkan.');
    }

    public function edit(ElectionCategory $kategori): View
    {
        $periodes = ElectionPeriod::orderByDesc('year')->get();
        $fakultas = Faculty::orderBy('name')->get();

        return view('admin.kategori.edit', compact('kategori', 'periodes', 'fakultas'));
    }

    public function update(KategoriRequest $request, ElectionCategory $kategori): RedirectResponse
    {
        $kategori->update($request->validated());

        AuditHelper::log('UPDATE', 'ElectionCategory', $kategori->id, ['title' => $kategori->title]);

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori Pemilihan berhasil diperbarui.');
    }

    public function destroy(ElectionCategory $kategori): RedirectResponse
    {
        AuditHelper::log('DELETE', 'ElectionCategory', $kategori->id, ['title' => $kategori->title]);

        $kategori->delete();

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori Pemilihan berhasil dihapus.');
    }
}
