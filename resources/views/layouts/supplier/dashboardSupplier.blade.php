@extends('layouts.template')
@section('content')
    <main>
        <div class="container-fluid px-4">
            {{-- <h1 class="mt-4">{{ $judul }} </h1> --}}
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Grafik Achievement</li>
            </ol>
            <div class="row">
                <div class="row">
                    <div class="col-xl-8">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-chart-bar me-1"></i>
                                Target Achievement 80%
                            </div>
                            <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Data Audit Supplier
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead class="table-secondary">
                            <tr>
                                <th>Auditor Name</th>
                                <th>Part Name</th>
                                <th>Score</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($auditorsSupplier as $auditor)
                                @php
                                    if ($auditor->supp_answers[0]->questions->subsection->sections->part_id == 9) {
                                        $score = round($auditor->supp_answers->sum('mark') / $totalQuestion1, 1);
                                    } elseif (
                                        $auditor->supp_answers[0]->questions->subsection->sections->part_id == 10
                                    ) {
                                        $score = round($auditor->supp_answers->sum('mark') / $totalQuestion2, 1);
                                    } elseif (
                                        $auditor->supp_answers[0]->questions->subsection->sections->part_id == 11
                                    ) {
                                        $score = round($auditor->supp_answers->sum('mark') / $totalQuestion3, 1);
                                    } elseif (
                                        $auditor->supp_answers[0]->questions->subsection->sections->part_id == 4
                                    ) {
                                        $score = round($auditor->supp_answers->sum('mark') / $totalQuestion4, 1);
                                    } elseif (
                                        $auditor->supp_answers[0]->questions->subsection->sections->part_id == 12
                                    ) {
                                        $score = round($auditor->supp_answers->sum('mark') / $totalQuestion5, 1);
                                    } else {
                                        // Tambahkan tindakan yang sesuai jika part_id tidak cocok dengan kondisi di atas
                                    }

                                    $rowStyle =
                                        $score > 99 ? 'background-color: #7FFF7F;' : 'background-color: #FF0000;';
                                @endphp
                                <tr style="{{ $rowStyle }}">
                                    <td>{{ $auditor->auditor_name }}</td>
                                    <td>{{ $auditor->supp_answers[0]->questions->subsection->sections->parts->part_name }}
                                    </td>
                                    <td>{{ $score }}</td>
                                    <td><a href="{{ route('detailSupplier', $auditor->id) }}"
                                            class="btn btn-primary">Detail</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    <footer class="py-4 bg-light mt-auto">
        <div class="container-fluid px-4">
            <div class="d-flex align-items-center justify-content-between small">
                <div class="text-muted">Copyright &copy; Your Website 2023</div>
                <div>
                    <a href="#">Privacy Policy</a>
                    &middot;
                    <a href="#">Terms &amp; Conditions</a>
                </div>
            </div>
        </div>
    </footer>
    </div>
    </div>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="{{ asset('js/datatables-simple-demo.js') }}"></script>

    <script>
        var auditorsData = {!! json_encode($monthlySupplier) !!};
        var auditorNames = [];
        var auditorData = [];

        auditorsData.forEach(function(auditor) {
            auditorNames.push(auditor.auditor_name);
            auditorData.push(auditor.data);

        });

        var ctx = document.getElementById("myBarChart");
        var myLineChart = new Chart(ctx, {
            type: "bar",
            data: {
                labels: auditorNames,
                datasets: [{
                    label: "Jumlah Audit",
                    backgroundColor: "rgba(2,117,216,1)",
                    borderColor: "rgba(2,117,216,1)",
                    data: [
                        @foreach ($monthlySupplier as $auditor)
                            {{ $auditor->total_days_with_audit }},
                        @endforeach
                    ],

                }, ],

            },
            options: {
                scales: {
                    xAxes: [{
                        time: {
                            unit: "month",
                        },
                        gridLines: {
                            display: false,
                        },
                        ticks: {
                            maxTicksLimit: 6,
                        },
                        barThickness: 50
                    }, ],
                    yAxes: [{
                        ticks: {
                            min: 0,
                            max: 20,
                            stepSize: 2,

                        },
                        gridLines: {
                            display: true,
                        },
                    }, ],
                },
                legend: {
                    display: false,
                },
            },
        });
    </script>
@endpush
