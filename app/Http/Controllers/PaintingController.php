<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Auditor;
use App\Models\Section;
use App\Models\Question;
use App\Models\FixAnswer;
use App\Models\Subsection;
use Illuminate\Http\Request;

class PaintingController extends Controller
{
    public function painting(Request $request)
    {

        $judul = "DASHBOARD CHECKSHEET PAINTING";
        $sectionId = Section::with(['subsections'], ['parts'])->where('part_id', 1)->get()->pluck('id')->toArray();
        $subsectionId = Subsection::whereIn('section_id', $sectionId)->get()->pluck('id')->toArray();
        $questionId = Question::whereIn('subsection_id', $subsectionId)->get()->pluck('id')->toArray();
        $answerId = FixAnswer::whereIn('question_id', $questionId)->get();

        $today = Carbon::now()->today();



        $monthlyPainting = FixAnswer::with(['auditors', 'auditors.answers'])
            ->join('auditors', 'fix_answers.auditor_id', '=', 'auditors.id')
            ->join('questions', 'fix_answers.question_id', '=', 'questions.id')
            ->join('subsections', 'questions.subsection_id', '=', 'subsections.id')
            ->join('sections', 'subsections.section_id', '=', 'sections.id')
            ->selectRaw('auditors.auditor_name, sections.area, COUNT(DISTINCT DATE(fix_answers.created_at)) as total_days_with_audit')
            ->where('sections.area', 'Painting ')
            ->groupBy('auditors.auditor_name', 'sections.area')
            ->get();

        $auditorsPainting = Auditor::whereHas('answers', function ($query) use ($today) {
            $query->whereDate('created_at', $today);
        })
            ->with(['answers' => function ($query) use ($today) {
                $query->whereDate('created_at', $today)
                    ->whereHas('questions.subsection.sections', function ($query) {
                        $query->where('area', 'Painting');
                    });
            }])
            ->whereHas('answers', function ($query) use ($today) {
                $query->whereDate('created_at', $today)
                    ->whereHas('questions.subsection.sections', function ($query) {
                        $query->where('area', 'Painting');
                    });
                $query->whereDate('created_at', $today);

                // Tambahkan kondisi tambahan ke dalam relasi answers
            })
            ->get();

        $mark = FixAnswer::whereHas('questions.subsection.sections', function ($query) {
            $query->where('area', 'Painting');
        })->sum('mark');

        $totalSection = count(Section::whereArea('Painting')->get());
        $totalQuestion = count(Question::whereIn('subsection_id', [19, 20, 21, 22])->get());
        return view('layouts.painting.dashboardpainting', compact('sectionId', 'auditorsPainting', 'subsectionId', 'questionId', 'answerId', 'totalSection', 'totalQuestion', 'judul', 'monthlyPainting'));
    }


    public function detailPaintingToday($id)
    {
        $judul = "DETAIL HISTORY AUDIT PAINTING";

        $today = Carbon::now()->today();

        $auditor = Auditor::find($id);
        $data = Auditor::with(['answers' => function ($query) use ($today) {
            $query->whereDate('created_at', $today)
                ->whereHas('questions.subsection.sections', function ($query) {
                    $query->where('area', 'Painting');
                });
        }, 'answers.questions.subsection.sections'])->find($id);


        // dd($data);
        $totalQuestion = count(Question::whereIn('subsection_id', [19, 20, 21, 22])->get());

        return view('layouts.painting.detailpainting', compact('judul', 'data', 'totalQuestion', 'auditor'));
    }

    public function paintingHistory(Request $request)
    {
        $judul = "CHECKSHEET PAINTING HISTORY";
        $query = FixAnswer::selectRaw('DATE(created_at) as date, auditor_id')
            ->whereHas('questions.subsection.sections', function ($query) {
                $query->where('area', 'Painting');
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

        return view('layouts.painting.paintinghistory', compact('judul', 'data', 'request'));
    }


    public function detailPaintingHistory($date, $id_user)
    {
        $judul = "DETAIL PAINTING HISTORY";

        $auditor = Auditor::find($id_user);
        $data = $auditor->answers()->whereDate('created_at', $date)
            ->whereHas('questions.subsection.sections', function ($query) {
                $query->where('area', 'Painting');
            })->with('questions.subsection.sections')
            ->get();
        return view('layouts.machinning.detailMachiningHistory', compact(['judul', 'data', 'auditor']));
    }
}
