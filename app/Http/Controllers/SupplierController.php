<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Auditor;
use App\Models\Section;
use App\Models\Question;
use App\Models\Subsection;
use App\Models\SuppAnswer;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    public function supplier(Request $request)
    {
        $judul = "DASHBOARD Supplier";
        $sectionId = Section::with(['subsections'], ['parts'])->where('part_id', 1)->get()->pluck('id')->toArray();
        $subsectionId = Subsection::whereIn('section_id', $sectionId)->get()->pluck('id')->toArray();
        $questionId = Question::whereIn('subsection_id', $subsectionId)->get()->pluck('id')->toArray();
        $answerId = SuppAnswer::whereIn('question_id', $questionId)->get();

        $today = Carbon::now()->today();

        // dd($today);


        $monthlySupplier = SuppAnswer::with(['auditors', 'auditors.answers'])
            ->join('auditors', 'supp_answer.auditor_id', '=', 'auditors.id')
            ->join('questions', 'supp_answer.question_id', '=', 'questions.id')
            ->join('subsections', 'questions.subsection_id', '=', 'subsections.id')
            ->join('sections', 'subsections.section_id', '=', 'sections.id')
            ->selectRaw('auditors.auditor_name, sections.area, COUNT(DISTINCT DATE(supp_answer.created_at)) as total_days_with_audit')
            ->where('sections.area', 'Supplier ')
            ->groupBy('auditors.auditor_name', 'sections.area')
            ->get();


        $auditorsSupplier = Auditor::whereHas('supp_answers', function ($query) use ($today) {
            $query->whereDate('created_at', $today);
        })
            ->with(['supp_answers' => function ($query) use ($today) {
                $query->whereDate('created_at', $today)
                    ->whereHas('questions.subsection.sections', function ($query) {
                        $query->where('area', 'Supplier');
                    });
            }])
            ->whereHas('supp_answers', function ($query) use ($today) {
                $query->whereDate('created_at', $today)
                    ->whereHas('questions.subsection.sections', function ($query) {
                        $query->where('area', 'Supplier');
                    });
                $query->whereDate('created_at', $today);
                // Tambahkan kondisi tambahan ke dalam relasi answers
            })->with('supp_answers.questions.subsection.sections.parts')
            ->get();


        $mark = SuppAnswer::whereHas('questions.subsection.sections', function ($query) {
            $query->where('area', 'Supplier');
        })->sum('mark');

        $totalSection = count(Section::whereArea('Supplier')->get());
        $totalQuestion = count(Question::whereIn('subsection_id', [23, 24])->get());


        // dd($totalQuestion);
        // dd($auditorsSupplier[1]->supp_answers->sum('mark') / $totalQuestion);

        return view('layouts.supplier.dashboardSupplier', compact('sectionId', 'auditorsSupplier', 'subsectionId', 'questionId', 'answerId', 'totalSection', 'totalQuestion', 'judul', 'monthlySupplier'));
    }


    public function detailSupplierToday($id)
    {
        $judul = "DETAIL HISTORY AUDIT Supplier";
        $today = Carbon::now()->today();
        $auditor = Auditor::find($id);
        // $data = $auditor->answers()->whereDate('created_at',$today)->get();

        $data = Auditor::with(['supp_answers' => function ($query) use ($today) {
            $query->whereDate('created_at', $today)
                ->whereHas('questions.subsection.sections', function ($query) {
                    $query->where('area', 'Supplier');
                });
        }, 'supp_answers.questions.subsection.sections'])->find($id);



        $totalQuestion = count(Question::whereIn('subsection_id', [23, 24])->get());
        return view('layouts.supplier.detailSupplier', compact('judul', 'data', 'totalQuestion', 'auditor'));
    }

    public function SupplierHistory(Request $request)
    {
        $judul = "Supplier HISTORY";
        $query = SuppAnswer::selectRaw('DATE(created_at) as date, auditor_id')
            ->whereHas('questions.subsection.sections', function ($query) {
                $query->where('area', 'Supplier');
            });

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }


        $query->orderByDesc('created_at');

        $data = $query->get()->groupBy('date')->map(function ($items) {
            return [
                'date' => $items->first()->date,
                'auditors' => $items->pluck('auditors')->unique(),
            ];
        });

        return view('layouts.supplier.SupplierHistory', compact('judul', 'data', 'request'));
    }
}
