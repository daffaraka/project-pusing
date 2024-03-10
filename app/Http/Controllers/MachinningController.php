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

class MachinningController extends Controller
{
    public function machining(Request $request)
    {
        $judul = "DASHBOARD MACHINING";
        $sectionId = Section::with(['subsections'], ['parts'])->where('part_id', 1)->get()->pluck('id')->toArray();
        $subsectionId = Subsection::whereIn('section_id', $sectionId)->get()->pluck('id')->toArray();
        $questionId = Question::whereIn('subsection_id', $subsectionId)->get()->pluck('id')->toArray();
        $answerId = FixAnswer::whereIn('question_id', $questionId)->get();

        $today = Carbon::now()->today();



        $monthlyMachining = FixAnswer::with(['auditors', 'auditors.answers'])
            ->join('auditors', 'fix_answers.auditor_id', '=', 'auditors.id')
            ->join('questions', 'fix_answers.question_id', '=', 'questions.id')
            ->join('subsections', 'questions.subsection_id', '=', 'subsections.id')
            ->join('sections', 'subsections.section_id', '=', 'sections.id')
            ->selectRaw('auditors.auditor_name, sections.area, COUNT(DISTINCT DATE(fix_answers.created_at)) as total_days_with_audit')
            ->where('sections.area', 'Machining ')
            ->groupBy('auditors.auditor_name', 'sections.area')
            ->get() ;

        // dd($today);
        $auditorsMachining = Auditor::whereHas('answers', function ($query) use ($today) {
            $query->whereDate('created_at', $today);
        })
            ->with(['answers' => function ($query) use ($today) {
                $query->whereDate('created_at', $today)
                    ->whereHas('questions.subsection.sections', function ($query) {
                        $query->where('area', 'Machining');
                    });
            }])
            ->whereHas('answers', function ($query) use ($today) {
                $query->whereDate('created_at', $today)
                    ->whereHas('questions.subsection.sections', function ($query) {
                        $query->where('area', 'Machining');
                    });
                $query->whereDate('created_at', $today);
                // Tambahkan kondisi tambahan ke dalam relasi answers
            })
            ->get();
        // dd($auditorsMachining);

        $mark = FixAnswer::whereHas('questions.subsection.sections', function ($query) {
            $query->where('area', 'Machining');
        })->sum('mark');

        $totalSection = count(Section::whereArea('Machining')->get());


        // dd($auditors);
        $totalQuestion = count(Question::whereIn('subsection_id', [9, 10, 11, 12, 13, 14, 15, 16, 17, 18])->get());

        return view('layouts.machinning.dashboardmachining', compact('sectionId', 'auditorsMachining', 'subsectionId', 'questionId', 'answerId', 'totalSection', 'totalQuestion', 'judul', 'monthlyMachining'));
    }


    public function detailMachiningToday($id)
    {
        $judul = "DETAIL HISTORY AUDIT";
        $today = Carbon::now()->today();
        $auditor = Auditor::find($id);
        // $data = $auditor->answers()->whereDate('created_at',$today)->get();

        $data = Auditor::with(['answers' => function ($query) use ($today) {
            $query->whereDate('created_at', $today)
                ->whereHas('questions.subsection.sections', function ($query) {
                    $query->where('area', 'Machining');
                });
        }, 'answers.questions.subsection.sections'])->find($id);



        $totalQuestion = count(Question::whereIn('subsection_id', [9, 10, 11, 12, 13, 14, 15, 16, 17, 18])->get());
        return view('layouts.machinning.detailmachining', compact('judul', 'data', 'totalQuestion', 'auditor'));
    }

    public function machiningHistory(Request $request)
    {
        $judul = "MACHINING HISTORY";
        $query = FixAnswer::selectRaw('DATE(created_at) as date, auditor_id')
            ->whereHas('auditors', function ($query) {
                $query->whereHas('answers.questions.subsection.sections', function ($query) {
                    $query->where('area', 'Machining');
                });
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


        // dd($data);
        return view('layouts.machinning.machiningHistory', compact('judul', 'data', 'request'));
    }


    public function detailMachiningHistory($date, $id_user)
    {
        $judul = "DETAIL MACHINING HISTORY";

        $auditor = Auditor::find($id_user);
        $data = $auditor->answers()->whereDate('created_at', $date)
            ->whereHas('questions.subsection.sections', function ($query) {
                $query->where('area', 'Machining');
            })->with('questions.subsection.sections')
            ->get();
        return view('layouts.machinning.detailMachiningHistory', compact(['judul', 'data', 'auditor']));
    }
}
