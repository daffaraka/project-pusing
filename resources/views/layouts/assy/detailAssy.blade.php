@extends('layouts.template')
@section('content')
    <main class="my-5">
        <div class="container-fluid px-4">




            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Data Detail Audit Assy
                </div>
                <div class="card-body">
                    <h4 class="fw-bold">Auditor Data</h4>

                    <div class="my-3">
                        <div class="table-responsive">
                            <table class="table table-primary table-bordered w-75">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">Date</th>
                                        <th scope="col">Auditor Name</th>
                                        <th scope="col">Auditor Level</th>
                                        <th scope="col">Today audited</th>
                                        <th scope="col">Audit Score</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="">
                                        <td>{{ Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}</td>
                                        <td scope="row">{{ $auditor->auditor_name }}</td>
                                        <td>{{ $auditor->auditor_level }}</td>
                                        <td>{{ count($auditor->answers) }}</td>
                                        <td>{{ round($auditor->answers->sum('mark') / $totalQuestion, 1) }}</td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>

                    <hr>
                    <h4 class="fw-bold">Audit Data</h4>
                    <table id="datatablesSimple" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Question</th>
                                <th>Remark</th>
                                <th>Note</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $previousSubsectionTitle = ''; @endphp
                            @foreach ($data->answers as $answer)
                                @if ($answer->questions->type != 'image')
                                    @if ($previousSubsectionTitle != $answer->questions->subsection->title)
                                        <tr>
                                            <td colspan="4" style="font-weight: bold;">
                                                {{ $answer->questions->subsection->title }}
                                            </td>
                                        </tr>
                                        @php $previousSubsectionTitle = $answer->questions->subsection->title; @endphp
                                    @endif
                                @endif
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $answer->questions->question }}</td>
                                    <td>
                                        @if ($answer->questions->type != 'image')
                                            {{ $answer->mark }}
                                        @else
                                            @if ($answer->image)
                                                <a href="{{ asset('storage/' . $answer->image) }}"
                                                    data-lightbox="answer-images">
                                                    <img src="{{ asset('storage/' . $answer->image) }}"
                                                        style="max-width: 95px; max-height: 95px; cursor: pointer;"
                                                        alt="Answer Image" class="img-fluid zoomable-image">
                                                </a>
                                            @endif
                                        @endif
                                    </td>
                                    <td>{{ $answer->notes ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>
@endsection
