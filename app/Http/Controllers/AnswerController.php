<?php

namespace App\Http\Controllers;

use App\Models\Remark;
use App\Models\Answer1;
use App\Models\Question;
use App\Models\FixAnswer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AnswerController extends Controller
{
    // public function tambah (){
    //     return view('/checksheetcasting');
    //     }
    public function store(Request $request)
    {
        // dd($request->answer[122]['image']->getClientOriginalName());

        $name = 'Casting';

        foreach ($request->answer as $question_id => $value) {
            if (isset($value['image'])) {
                $imageName = $name . '-' . now()->format('Y-m-d_H-i-s') . '-' . $value['image']->getClientOriginalName();

                $value['image']->storeAs('images', $imageName, 'public'); // Simpan gambar dengan nama asli ke dalam folder "public/images"

                FixAnswer::create([
                    'auditor_id' => $request->auditor_id,
                    'question_id' => $question_id,
                    'mark' => $value['remark'] ?? 100,
                    'notes' => $value['note'] ?? null,
                    'image' => 'images/' . $imageName, // Simpan nama file gambar di database
                ]);
            } else {
                FixAnswer::create([
                    'auditor_id' => $request->auditor_id,
                    'question_id' => $question_id,
                    'mark' => $value['remark'],
                    'notes' => $value['note'],
                ]);
            }
        }

        return redirect()->to('dashboardcasting');
    }
    public function createImageDirectory()
    {
        Storage::makeDirectory('public/images');
    }

    public function storeMachining(Request $request)
    {

        $name = 'Machining';

        foreach ($request->answer as $question_id => $value) {
            if (isset($value['image'])) {
                $imageName = $name . '-' . now()->format('Y-m-d_H-i-s') . '-' . $value['image']->getClientOriginalName();

                $value['image']->storeAs('images', $imageName, 'public'); // Simpan gambar dengan nama asli ke dalam folder "public/images"

                FixAnswer::create([
                    'auditor_id' => $request->auditor_id,
                    'question_id' => $question_id,
                    'mark' => $value['remark'] ?? 100,
                    'notes' => $value['note'] ?? null,
                    'image' => 'images/' . $imageName, // Simpan nama file gambar di database
                ]);
            } else {
                FixAnswer::create([
                    'auditor_id' => $request->auditor_id,
                    'question_id' => $question_id,
                    'mark' => $value['remark'],
                    'notes' => $value['note'],
                ]);
            }
        }

        return redirect()->to('dashboardmachining');
    }


    public function storePainting(Request $request)
    {

        // dd($request->all());
        $name = 'Painting';

        foreach ($request->answer as $question_id => $value) {
            if (isset($value['image'])) {
                $imageName = $name . '-' . now()->format('Y-m-d_H-i-s') . '-' . $value['image']->getClientOriginalName();

                $value['image']->storeAs('images', $imageName, 'public'); // Simpan gambar dengan nama asli ke dalam folder "public/images"

                FixAnswer::create([
                    'auditor_id' => $request->auditor_id,
                    'question_id' => $question_id,
                    'mark' => $value['remark'] ?? 100,
                    'notes' => $value['note'] ?? null,
                    'image' => 'images/' . $imageName, // Simpan nama file gambar di database
                ]);
            } else {
                FixAnswer::create([
                    'auditor_id' => $request->auditor_id,
                    'question_id' => $question_id,
                    'mark' => $value['remark'],
                    'notes' => $value['note'],
                ]);
            }
        }
        return redirect()->to('dashboard-painting');
    }



    public function storeAssy(Request $request)
    {

        // dd($request->all());
        $name = 'Assy';

        foreach ($request->answer as $question_id => $value) {
            if (isset($value['image'])) {
                $imageName = $name . '-' . now()->format('Y-m-d_H-i-s') . '-' . $value['image']->getClientOriginalName();

                $value['image']->storeAs('images', $imageName, 'public'); // Simpan gambar dengan nama asli ke dalam folder "public/images"


                // dd($value['image']->storeAs('images', $imageName, 'public'));
                FixAnswer::create([
                    'auditor_id' => $request->auditor_id,
                    'question_id' => $question_id,
                    'mark' => $value['remark'] ?? 100,
                    'notes' => $value['note'] ?? null,
                    'image' => 'images/' . $imageName, // Simpan nama file gambar di database
                ]);
            } else {
                FixAnswer::create([
                    'auditor_id' => $request->auditor_id,
                    'question_id' => $question_id,
                    'mark' => $value['remark'],
                    'notes' => $value['note'],
                ]);
            }
        }

        return redirect()->to('dashboard-assy');
    }

    public function storeSupplier(Request $request)
    {

        // dd($request->all());
        foreach ($request->answer as $question_id => $value) {

            if (isset($value['image'])) {

                FixAnswer::create([
                    'auditor_id' => $request->auditor_id,
                    'question_id' => $question_id,
                    'mark' => $value['remark'] ?? 100,
                    'notes' => $value['note'] ?? null,
                    'image' => $value['image']->store('images'),
                ]);
            } else {
                FixAnswer::create([
                    'auditor_id' => $request->auditor_id,
                    'question_id' => $question_id,
                    'mark' => $value['remark'],
                    'notes' => $value['note'],
                ]);
            }
        }

        return redirect()->to('dashboard-supplier');
    }
}


