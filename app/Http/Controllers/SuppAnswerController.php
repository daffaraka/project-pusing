<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Answer1;
use App\Models\SuppAnswer;
use App\Models\Remark;

class SuppAnswerController extends Controller
{
    // public function tambah (){
    //     return view('/checksheetcasting');
    //     }
    public function store(Request $request)
    {

        // dd($request->all());
        foreach ($request->answer as $question_id => $value) {
            if (isset($value['image'])) {
                $imageName = $value['image']->getClientOriginalName(); // Dapatkan nama file asli

                $value['image']->storeAs('images', $imageName, 'public');

                SuppAnswer::create([
                    'auditor_id' => $request->auditor_id,
                    'question_id' => $question_id,
                    'line' => $request->line,
                    'vendor' => $request->vendor,
                    'mark' => $value['remark'] ?? 100,
                    'notes' => $value['note'] ?? null,
                    'image' => 'images/' . $imageName,
                    // ])
                ]);
            } else {
                SuppAnswer::create([
                    'auditor_id' => $request->auditor_id,
                    'question_id' => $question_id,
                    'line' => $request->line,
                    'vendor' => $request->vendor,
                    'mark' => $value['remark'],
                    'notes' => $value['note'],
                ]);
            }
        }
        return redirect()->to('dashboard-supplier');
    }
    public function createImageDirectory()
    {
        Storage::makeDirectory('public/images');
    }
}
   
