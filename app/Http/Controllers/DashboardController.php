<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Part;
use App\Models\Answer;
use App\Models\Auditor;
use App\Models\Section;
use App\Models\Question;
use App\Models\FixAnswer;
use App\Models\Subsection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function casting(Request $request)
    {

        $judul = "DASHBOARD CHECKSHEET CASTING";
        $sectionId = Section::with(['subsections'], ['parts'])->where('part_id', 1)->get()->pluck('id')->toArray();
        $subsectionId = Subsection::whereIn('section_id', $sectionId)->get()->pluck('id')->toArray();
        $questionId = Question::whereIn('subsection_id', $subsectionId)->get()->pluck('id')->toArray();
        $answerId = FixAnswer::whereIn('question_id', $questionId)->get();

        $today = Carbon::now()->today();

        $monthlyCasting = FixAnswer::with(['auditors', 'auditors.answers'])
            ->join('auditors', 'fix_answers.auditor_id', '=', 'auditors.id')
            ->join('questions', 'fix_answers.question_id', '=', 'questions.id')
            ->join('subsections', 'questions.subsection_id', '=', 'subsections.id')
            ->join('sections', 'subsections.section_id', '=', 'sections.id')
            ->selectRaw('auditors.auditor_name, sections.area, COUNT(DISTINCT DATE(fix_answers.created_at)) as total_days_with_audit')
            ->where('sections.area', 'Casting HPDC')
            ->groupBy('auditors.auditor_name', 'sections.area')
            ->get();


        // dd($monthlyCasting);

        // dd($monthlyCasting);
        $auditorsCasting = Auditor::whereHas('answers', function ($query) use ($today) {
            $query->whereDate('created_at', $today);
        })
            ->with(['answers' => function ($query) use ($today) {
                $query->whereDate('created_at', $today)
                    ->whereHas('questions.subsection.sections', function ($query) {
                        $query->where('area', 'Casting HPDC');
                    });
            }])
            ->whereHas('answers', function ($query) use ($today) {
                $query->whereDate('created_at', $today)
                    ->whereHas('questions.subsection.sections', function ($query) {
                        $query->where('area', 'Casting HPDC');
                    });
                $query->whereDate('created_at', $today);

                // Tambahkan kondisi tambahan ke dalam relasi answers
            })
            ->get();

        $mark = FixAnswer::whereHas('questions.subsection.sections', function ($query) {
            $query->where('area', 'Casting HPDC');
        })->sum('mark');


        $totalSection = count(Section::whereArea('Casting HPDC')->get());
        $totalQuestion = count(Question::whereIn('subsection_id', [1, 2, 3, 4, 5, 6, 7, 8])->get());
        return view('layouts.casting.dashboardcasting', compact('sectionId', 'auditorsCasting', 'subsectionId', 'questionId', 'answerId', 'totalSection', 'totalQuestion', 'judul', 'monthlyCasting'));
    }


    public function detailCastingToday($id)
    {
        $judul = "DETAIL HISTORY AUDIT";

        $today = Carbon::now()->today();

        $auditor = Auditor::find($id);
        $data = $auditor->answers()->whereDate('created_at', $today)->get();
        $totalQuestion = count(Question::whereIn('subsection_id', [1, 2, 3, 4, 5, 6, 7, 8])->get());

        return view('layouts.casting.detailcasting', compact('judul', 'data', 'totalQuestion', 'auditor'));
    }

    public function castingHistory(Request $request)
    {
        $judul = "CHECKSHEET CASTING HISTORY";
        $query = FixAnswer::selectRaw('DATE(created_at) as date, auditor_id')
            ->whereHas('auditors', function ($query) {
                $query->whereHas('answers.questions.subsection.sections', function ($query) {
                    $query->where('area', 'Casting HPDC');
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


        return view('layouts.casting.castinghistory', compact('judul', 'data', 'request'));
    }


    public function detailCastingHistory($date, $id_user)
    {
        $judul = "DETAIL CASTING HISTORY";

        // dd([$date,$id_user]);
        $auditor = Auditor::find($id_user);
        $data = $auditor->answers()->whereDate('created_at', $date)
            ->whereHas('questions.subsection.sections', function ($query) {
                $query->where('area', 'Casting HPDC');
            })->with('questions.subsection.sections')
            ->get();



        // dd($data);
        return view('layouts.casting.detailCastingHistory', compact(['judul', 'data', 'auditor']));
    }
}
