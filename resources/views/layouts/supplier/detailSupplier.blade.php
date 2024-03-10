@extends('layouts.template')
@section('content')
    <main class="my-5">
        <div class="container-fluid px-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Data Detail Audit Supplier
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
                                        <th scope="col">Part Name</th>
                                        <th scope="col">Today audited</th>
                                        <th scope="col">Audit Score</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="">
                                        <td>{{ Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}</td>
                                        <td scope="row">{{ $auditor->auditor_name }}</td>
                                        <td>{{ $auditor->auditor_level }}</td>
                                        <td>{{ $auditor->supp_answers[0]->questions->subsection->sections->parts->part_name }}
                                        </td>
                                        <td>{{ count($data->supp_answers) }}</td>
                                        <td>{{ round($data->supp_answers->sum('mark') / $totalQuestion, 1) }}</td>

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
                                <th>Line</th>
                                <th>Vendor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $previousSubsectionTitle = ''; @endphp
                            @foreach ($data->supp_answers as $supp_answers)
                                @if ($supp_answers->questions->type != 'image')
                                    @if ($previousSubsectionTitle != $supp_answers->questions->subsection->title)
                                        <tr>
                                            <td colspan="4" style="font-weight: bold;">
                                                {{ $supp_answers->questions->subsection->title }}
                                            </td>
                                        </tr>
                                        @php $previousSubsectionTitle = $supp_answers->questions->subsection->title; @endphp
                                    @endif
                                @endif
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $supp_answers->questions->question }}</td>
                                    <td>
                                        @if ($supp_answers->questions->type != 'image')
                                            {{ $supp_answers->mark }}
                                        @else
                                            @if ($supp_answers->image)
                                                <a href="{{ asset('storage/' . $supp_answers->image) }}"
                                                    data-lightbox="answer-images">
                                                    <img src="{{ asset('storage/' . $supp_answers->image) }}"
                                                        style="max-width: 95px; max-height: 95px; cursor: pointer;"
                                                        alt="Answer Image">
                                                </a>
                                            @endif
                                        @endif
                                    </td>
                                    <td>{{ $supp_answers->notes ?? '-' }}</td>
                                    <td>{{ $supp_answers->line ?? '-' }}</td>
                                    <td>{{ $supp_answers->vendor ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>
@endsection
<script src="path/to/lightbox.js"></script>
<script>
    lightbox.option({
        'resizeDuration': 200,
        'wrapAround': true,
        'showImageNumberLabel': false,
        'showDownloadButton': true,
        'downloadButtonText': 'Download'
    });
</script>
