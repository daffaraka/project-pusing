<?php

use Carbon\Carbon;
use App\Models\Part;
use App\Models\Answer1;
use App\Models\Auditor;
use App\Models\Section;
use App\Models\Question;
use App\Models\FixAnswer;
use App\Models\Subsection;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\AssyController;
use App\Http\Controllers\AuditorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MachinningController;
use App\Http\Controllers\PaintingController;
use App\Http\Controllers\SuppAnswerController;
use App\Http\Controllers\SupplierController;

Route::get('/', function () {
    // dd("NYANT");
    return view('welcome');
});

Route::get('/template', function () {
    $judul = "DASHBOARD";
    return view('layouts.template', compact('judul'));
});


// Route::get('/answercontroller/tambah','AnswerController@tambah');
Route::post('/answer/store', [AnswerController::class, 'store'])->name('answer.store'); // For View Login Page
Route::post('/suppanswer/store', [SuppAnswerController::class, 'store'])->name('suppanswer.store'); // For View Login Page
// Route::post('/dashboa/store', [SectionController::class, 'store'])->name('section.store'); // For View Login Page


Route::get('/get-auditor-level/{auditor_id}', function ($auditor_id) {
    $auditors = Auditor::find($auditor_id);
    if ($auditors) {
        return response()->json([$auditors->auditor_level]);
    } else {
        return response()->json(['error' => 'Auditor not found'], 404);
    }
})->name('getAuditorLevel');


Route::get('/checksheetassy', function () {
    $judul = "CHECKSHEET Assy";
    $sections = Section::with(['subsections'], ['parts'])->where('area', 'Assy')->get();
    $auditors = Auditor::all();

    return view('checksheetassy', compact('judul', 'sections', 'auditors'));
});


///////// Casting
Route::get('/dashboardcasting', [DashboardController::class, 'casting']);
Route::get('/checksheetcasting', function () {
    $judul = "CHECKSHEET CASTING";
    $today = Carbon::today();
    $sections = Section::with(['subsections'], ['parts'])->where('area', 'Casting HPDC')->get();

    $auditors = Auditor::whereDoesntHave('answers', function ($query) use ($today) {
        $query->whereDate('created_at', $today)
            ->whereHas('questions.subsection.sections', function ($query) {
                $query->where('area', 'Casting HPDC');
            });
        })->get();

    // dd($today,$auditors);
    // dd(count($auditors));
    return view('layouts.casting.checksheetcasting', compact('judul', 'sections', 'auditors'));
});
Route::get('/castinghistory', [DashboardController::class, 'castingHistory'])->name('castingHistory');
Route::get('/detailcasting/{id}', [DashboardController::class, 'detailCastingToday'])->name('detailCasting');
Route::get('/casting-history/detail/{date}/{id_user}',[DashboardController::class,'detailCastingHistory'])->name('detailCastingHistory');


/////////// Machining
Route::get('/dashboardmachining', [MachinningController::class, 'machining']);
Route::get('/checksheetmachining', function () {
    $judul = "CHECKSHEET MACHINING";
    $today = Carbon::today();
    $sections = Section::with(['subsections.questions'], ['parts'])->where('area', 'Machining')->get();
    $auditors = Auditor::whereDoesntHave('answers', function ($query) use ($today) {
        $query->whereDate('created_at', $today)
            ->whereHas('questions.subsection.sections', function ($query) {
                $query->where('area', 'Machining');
            });
    })->get();

    return view('layouts.machinning.checksheetmachining', compact('judul', 'sections', 'auditors'));
});
Route::post('/answer/storeMachining', [AnswerController::class, 'storeMachining'])->name('answer.storeMachining'); // For View Login Page
Route::get('/machining-history', [MachinningController::class, 'machiningHistory'])->name('machininggHistory');
Route::get('/detail-machining/{id}', [MachinningController::class, 'detailMachiningToday'])->name('detailmachining');
Route::get('/machining-history/detail/{date}/{id_user}',[MachinningController::class,'detailMachiningHistory'])->name('detailMachininggHistory');



//////// Painting

Route::get('/checksheetpainting', function () {
    $judul = "CHECKSHEET PAINTING";
    $today = Carbon::today();
    $sections = Section::with(['subsections'], ['parts'])->where('area', 'Painting')->get();

    $auditors = Auditor::whereDoesntHave('answers', function ($query) use ($today) {
        $query->whereDate('created_at', $today)
            ->whereHas('questions.subsection.sections', function ($query) {
                $query->where('area', 'Painting');
            });
    })->get();
    return view('layouts.painting.checksheetpainting', compact('judul', 'sections', 'auditors'));
});
Route::get('/dashboard-painting', [PaintingController::class, 'painting']);
Route::post('/answer/store-painting', [AnswerController::class, 'storePainting'])->name('answer.storePainting'); // For View Login Page
Route::get('/painting-history', [PaintingController::class, 'paintingHistory'])->name('paintingHistory');
Route::get('/detail-painting/{id}', [PaintingController::class, 'detailPaintingToday'])->name('detailPainting');
Route::get('/painting-history/detail/{date}/{id_user}',[PaintingController::class,'detailPaintingHistory'])->name('detailPaintingHistory');


/////// Assy
Route::get('/dashboardassy', function () {

    // dd("masuk");
    return view('dashboardassy');
});
Route::get('/checksheetassy', function () {
    $judul = "CHECKSHEET ASSY";
    $today = Carbon::today();
    $sections = Section::with(['subsections'], ['parts'])->where('area', 'assy')->get();

    $auditors = Auditor::whereDoesntHave('answers', function ($query) use ($today) {
        $query->whereDate('created_at', $today)
            ->whereHas('questions.subsection.sections', function ($query) {
                $query->where('area', 'Assy');
            });
    })->get();
    return view('layouts.assy.checksheetassy', compact('judul', 'sections', 'auditors'));
});
Route::get('/dashboard-assy', [AssyController::class, 'assy']);
Route::post('/answer/store-assy', [AnswerController::class, 'storeAssy'])->name('answer.storeAssy'); // For View Login Page
Route::get('/assy-history', [AssyController::class, 'assyHistory'])->name('assyHistory');
Route::get('/detail-assy/{id}', [AssyController::class, 'detailAssyToday'])->name('detailAssy');
Route::get('/assy-history/detail/{date}/{id_user}',[AssyController::class,'detailAssyHistory'])->name('detailAssyHistory');



/////////////// Supplier
Route::get('/checksheetsupp', function () {
    $judul = "CHECKSHEET SUPPLIER";
    $today = Carbon::today();
    $sections = Section::with(['subsections'], ['parts'])->where('area', 'Supplier')->get();

    $auditors = Auditor::whereDoesntHave('answers', function ($query) use ($today) {
        $query->whereDate('created_at', $today)
            ->whereHas('questions.subsection.sections', function ($query) {
                $query->where('area', 'Supplier');
            });
    })->get();
    return view('checksheetsupp', compact('judul', 'sections', 'auditors'));
});

Route::get('/dashboard-supplier', [SupplierController::class, 'supplier']);
Route::post('/answer/store-supplier', [AnswerController::class, 'storeSupplier'])->name('answer.storeSupplier'); // For View Login Page
Route::get('/supplier-history', [SupplierController::class, 'supplierHistory'])->name('supplierHistory');
Route::get('/detail-supplier/{id}', [SupplierController::class, 'detailSupplierToday'])->name('detailSupplier');

Route::get('/basestator', function () {
    $judul = "CHECKSHEET SUPPLIER";
    $sections = Section::with(['subsections'], ['parts'])->where('id', 12)->get();
    $today = Carbon::today();
    $auditors = Auditor::whereDoesntHave('supp_answers', function ($query) use ($today) {
        $query->whereDate('created_at', $today)
            ->whereHas('questions.subsection.sections', function ($query) {
                $query->where('id', '12');
            });
    })->get();


    // dd($sections);
    return view('basestator', compact('judul', 'sections', 'auditors'));
});
Route::get('/k1aa', function () {
    $judul = "CHECKSHEET SUPPLIER";


    $sections = Section::with(['subsections'], ['parts'])
        ->where('id', '14')->get();

    $today = Carbon::today();
    $auditors = Auditor::whereDoesntHave('supp_answers', function ($query) use ($today) {
        $query->whereDate('created_at', $today)
            ->whereHas('questions.subsection.sections', function ($query) {
                $query->where('id', '14');
            });
    })->get();

    return view('k1aa', compact('judul', 'sections', 'auditors'));
});
Route::get('/k2fa', function () {
    $judul = "CHECKSHEET SUPPLIER";
    $sections = Section::with(['subsections'], ['parts'])
        ->where('id', '13')->get();

    $today = Carbon::today();
    $auditors = Auditor::whereDoesntHave('supp_answers', function ($query) use ($today) {
        $query->whereDate('created_at', $today)
            ->whereHas('questions.subsection.sections', function ($query) {
                $query->where('id', '13');
            });
    })->get();

    return view('k1aa', compact('judul', 'sections', 'auditors'));
});
Route::get('/railrear', function () {
    $judul = "CHECKSHEET SUPPLIER";
    $sections = Section::with(['subsections'], ['parts'])
        ->where('id', '15')->get();

    $today = Carbon::today();
    $auditors = Auditor::whereDoesntHave('supp_answers', function ($query) use ($today) {
        $query->whereDate('created_at', $today)
            ->whereHas('questions.subsection.sections', function ($query) {
                $query->where('id', '15');
            });
    })->get();

    return view('k1aa', compact('judul', 'sections', 'auditors'));
});
Route::get('/oilpump', function () {
    $judul = "CHECKSHEET SUPPLIER";
    $sections = Section::with(['subsections'], ['parts'])
        ->where('id', '16')->get();

    $today = Carbon::today();
    $auditors = Auditor::whereDoesntHave('supp_answers', function ($query) use ($today) {
        $query->whereDate('created_at', $today)
            ->whereHas('questions.subsection.sections', function ($query) {
                $query->where('id', '16');
            });
    })->get();

    return view('k1aa', compact('judul', 'sections', 'auditors'));
});


Route::post('/auditors', [AuditorController::class, 'store'])->name('auditors.store');
