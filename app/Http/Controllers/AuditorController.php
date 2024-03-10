<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auditor;
use App\Models\Answer;

class AuditorController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'auditor_name' => 'required|string',
            'auditor_level' => 'required|string',
        ]);

        $auditor = Auditor::create([
            'auditor_name' => $request->auditor_name,
            'auditor_level' => $request->auditor_level,
        ]);

        // Simpan auditor_id ke tabel answers
        Answer::create([
            'auditor_id' => $auditor->id,
            // Tambahkan kolom-kolom lain yang sesuai
        ]);

        return redirect()->back()->with('success', 'Auditor created successfully.');
    }
}
