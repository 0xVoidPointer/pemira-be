<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AuditHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FakultasRequest;
use App\Models\Faculty;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FakultasController extends Controller
{
    public function index(): View
    {
        $fakultas = Faculty::orderBy('name')->paginate(10);

        return view('admin.fakultas.index', compact('fakultas'));
    }

    public function create(): View
    {
        return view('admin.fakultas.create');
    }

    public function store(FakultasRequest $request): RedirectResponse
    {
        $faculty = Faculty::create($request->validated());

        AuditHelper::log('CREATE', 'Faculty', $faculty->id, ['name' => $faculty->name]);

        return redirect()->route('admin.fakultas.index')
            ->with('success', 'Fakultas berhasil ditambahkan.');
    }

    public function edit(Faculty $fakulta): View
    {
        return view('admin.fakultas.edit', ['fakultas' => $fakulta]);
    }

    public function update(FakultasRequest $request, Faculty $fakulta): RedirectResponse
    {
        $fakulta->update($request->validated());

        AuditHelper::log('UPDATE', 'Faculty', $fakulta->id, ['name' => $fakulta->name]);

        return redirect()->route('admin.fakultas.index')
            ->with('success', 'Fakultas berhasil diperbarui.');
    }

    public function destroy(Faculty $fakulta): RedirectResponse
    {
        AuditHelper::log('DELETE', 'Faculty', $fakulta->id, ['name' => $fakulta->name]);

        $fakulta->delete();

        return redirect()->route('admin.fakultas.index')
            ->with('success', 'Fakultas berhasil dihapus.');
    }
}
