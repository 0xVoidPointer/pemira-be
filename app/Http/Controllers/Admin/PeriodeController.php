<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AuditHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PeriodeRequest;
use App\Models\ElectionPeriod;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PeriodeController extends Controller
{
    public function index(): View
    {
        $periodes = ElectionPeriod::orderByDesc('year')->paginate(10);

        return view('admin.periode.index', compact('periodes'));
    }

    public function create(): View
    {
        return view('admin.periode.create');
    }

    public function store(PeriodeRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['theme_config'] = $data['theme_config'] ?? '{}';
        $data['created_by'] = auth('admin')->id();

        $period = ElectionPeriod::create($data);

        AuditHelper::log('CREATE', 'ElectionPeriod', $period->id, ['name' => $period->name]);

        return redirect()->route('admin.periode.index')
            ->with('success', 'Periode berhasil ditambahkan.');
    }

    public function edit(ElectionPeriod $periode): View
    {
        return view('admin.periode.edit', compact('periode'));
    }

    public function update(PeriodeRequest $request, ElectionPeriod $periode): RedirectResponse
    {
        $periode->update($request->validated());

        AuditHelper::log('UPDATE', 'ElectionPeriod', $periode->id, ['name' => $periode->name]);

        return redirect()->route('admin.periode.index')
            ->with('success', 'Periode berhasil diperbarui.');
    }

    public function destroy(ElectionPeriod $periode): RedirectResponse
    {
        AuditHelper::log('DELETE', 'ElectionPeriod', $periode->id, ['name' => $periode->name]);

        $periode->delete();

        return redirect()->route('admin.periode.index')
            ->with('success', 'Periode berhasil dihapus.');
    }
}
