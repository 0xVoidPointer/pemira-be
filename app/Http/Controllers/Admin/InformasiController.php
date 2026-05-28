<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AuditHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\InformasiRequest;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class InformasiController extends Controller
{
    /**
     * Setting keys used for Informasi Lainnya.
     */
    private const KEYS = [
        'kata_sambutan',
        'peraturan_pemira',
        'pemaparan_singkat',
        'hotline',
    ];

    /**
     * Show Informasi form.
     */
    public function index(): View
    {
        $settings = Setting::getMany(self::KEYS);

        return view('admin.informasi.index', compact('settings'));
    }

    /**
     * Update Informasi settings.
     */
    public function update(InformasiRequest $request): RedirectResponse
    {
        $data = $request->validated();

        foreach (self::KEYS as $key) {
            Setting::setValue($key, $data[$key] ?? null);
        }

        AuditHelper::log('UPDATE', 'Setting', null, ['keys' => self::KEYS]);

        return redirect()->route('admin.informasi.index')
            ->with('success', 'Informasi berhasil diperbarui.');
    }
}
