<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use App\Models\Auditor;
use App\Models\Section;
use App\Models\Question;
use App\Models\FixAnswer;
use App\Models\Subsection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssyController extends Controller
{
    public function assy(Request $request)
    {
        $judul = "DASHBOARD ASSY";
        $sectionId = Section::with(['subsections'], ['parts'])->where('part_id', 1)->get()->pluck('id')->toArray();
        $subsectionId = Subsection::whereIn('section_id', $sectionId)->get()->pluck('id')->toArray();
        $questionId = Question::whereIn('subsection_id', $subsectionId)->get()->pluck('id')->toArray();
        $answerId = FixAnswer::whereIn('question_id', $questionId)->get();

        $today = Carbon::now()->today();


        $monthlyAssy = FixAnswer::with(['auditors', 'auditors.answers'])
            ->join('auditors', 'fix_answers.auditor_id', '=', 'auditors.id')
            ->join('questions', 'fix_answers.question_id', '=', 'questions.id')
            ->join('subsections', 'questions.subsection_id', '=', 'subsections.id')
            ->join('sections', 'subsections.section_id', '=', 'sections.id')
            ->selectRaw('auditors.auditor_name, sections.area, COUNT(DISTINCT DATE(fix_answers.created_at)) as total_days_with_audit')
            ->where('sections.area', 'Assy')
            ->groupBy('auditors.auditor_name', 'sections.area')
            ->get();

        // dd($today);
        $auditorsAssy = Auditor::whereHas('answers', function ($query) use ($today) {
            $query->whereDate('created_at', $today);
        })
            ->with(['answers' => function ($query) use ($today) {
                $query->whereDate('created_at', $today)
                    ->whereHas('questions.subsection.sections', function ($query) {
                        $query->where('area', 'Assy');
                    });
            }])
            ->whereHas('answers', function ($query) use ($today) {
                $query->whereDate('created_at', $today)
                    ->whereHas('questions.subsection.sections', function ($query) {
                        $query->where('area', 'Assy');
                    });
                $query->whereDate('created_at', $today);
                // Tambahkan kondisi tambahan ke dalam relasi answers
            })
            ->get();
        // dd($auditorsAssy);


        // dd($auditorsAssy);
        $mark = FixAnswer::whereHas('questions.subsection.sections', function ($query) {
            $query->where('area', 'Assy');
        })->sum('mark');

        $totalSection = count(Section::whereArea('Assy')->get());


        // dd($auditors);
        $totalQuestion = count(Question::whereIn('subsection_id', [23, 24])->get());

        return view('layouts.assy.dashboardassy', compact('sectionId', 'auditorsAssy', 'subsectionId', 'questionId', 'answerId', 'totalSection', 'totalQuestion', 'judul', 'monthlyAssy'));
    }


    public function detailAssyToday($id)
    {
        $judul = "DETAIL AUDIT ASSY";
        $today = Carbon::now()->today();
        $auditor = Auditor::find($id);
        // $data = $auditor->answers()->whereDate('created_at',$today)->get();

        $data = Auditor::with(['answers' => function ($query) use ($today) {
            $query->whereDate('created_at', $today)
                ->whereHas('questions.subsection.sections', function ($query) {
                    $query->where('area', 'Assy');
                });
        }, 'answers.questions.subsection.sections'])->find($id);



        $totalQuestion = count(Question::whereIn('subsection_id', [23, 24])->get());
        return view('layouts.assy.detailAssy', compact('judul', 'data', 'totalQuestion', 'auditor'));
    }

    public function AssyHistory(Request $request)
    {
        $judul = "CHECKSHEET ASSY HISTORY";
        $query = FixAnswer::selectRaw('DATE(created_at) as date, auditor_id')
            ->whereHas('questions.subsection.sections', function ($query) {
                $query->where('area', 'Assy');
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
        return view('layouts.assy.AssyHistory', compact('judul', 'data', 'request'));
    }


    public function detailAssyHistory($date, $id_user)
    {
        $judul = "DETAIL ASSY HISTORY";

        $auditor = Auditor::find($id_user);
        $data = $auditor->answers()->whereDate('created_at', $date)
            ->whereHas('questions.subsection.sections', function ($query) {
                $query->where('area', 'Assy');
            })->with('questions.subsection.sections')
            ->get();
        return view('layouts.assy.detailAssyHistory', compact(['judul', 'data', 'auditor']));
    }
}
