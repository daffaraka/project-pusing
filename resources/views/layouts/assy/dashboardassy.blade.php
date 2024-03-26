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
                                Daily Target Achievement
                            </div>
                            <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="row">
                <div class="col-xl-8">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-bar me-1"></i>
                            Weekly Target Achievement
                        </div>
                        <div class="card-body"><canvas id="myWeeklyBarChart" width="100%" height="40"></canvas></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-8">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-bar me-1"></i>
                            Monthly Target Achievement
                        </div>
                        <div class="card-body"><canvas id="myMonthlyBarChart" width="100%" height="40"></canvas></div>
                    </div>
                </div>
            </div> --}}
            <a href="{{ url('/checksheetassy') }}" class="btn btn-outline-primary">+ CHECKSHEET</a>
            <a href="{{ url('/assy-history') }}" class="btn btn-outline-secondary">HISTORY</a>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Data Audit Assy
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead class="table-secondary">
                            <tr>
                                <th>Auditor Name</th>
                                <th>Score</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($auditorsAssy as $auditor)
                                @php
                                    $score = round($auditor->answers->sum('mark') / $totalQuestion, 1);
                                    $rowStyle =
                                        $score > 99 ? 'background-color: #7FFF7F;' : 'background-color: #FF0000;';

                                @endphp
                                <tr style="{{ $rowStyle }}">
                                    <td>{{ $auditor->auditor_name }}</td>
                                    {{-- <td>Casting</td> --}}
                                    <td>{{ $score }}</td>
                                    <td><a href="{{ route('detailAssy', $auditor->id) }}" class="btn btn-primary">Detail</a>
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
    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

    {{--  grafik harian --}}
    <script>
        var auditorsData = {!! json_encode($monthlyAssy) !!};
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
                        @foreach ($monthlyAssy as $auditor)
                            {{ $auditor->total_days_with_audit }},
                        @endforeach
                    ],
                }],
            },
            options: {
                plugins: {
                    datalabels: {
                        color: 'black', // warna teks label
                        font: {
                            weight: 'bold' // ketebalan teks label
                        },
                        formatter: function(value, context) {
                            return value; // formatter untuk menampilkan nilai
                        }
                    }
                },
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
                        barThickness: 30
                    }],
                    yAxes: [{
                        ticks: {
                            min: 0,
                            max: 20,
                            stepSize: 2,
                        },
                        gridLines: {
                            display: true,
                        },
                    }],
                },
                legend: {
                    display: false,
                },
            },
        });
    </script>

    {{-- grafik mingguan --}}
    {{-- <script>
        var weeklyAuditorsData = {!! json_encode($weeklyAssy) !!};
        var auditorNames = [];
        var auditorWeeklyData = [];

        weeklyAuditorsData.forEach(function(auditor) {
            auditorNames.push(auditor.auditor_name);
            auditorWeeklyData.push(auditor.total_week_with_audit);
        });

        var ctxWeekly = document.getElementById("myWeeklyBarChart");
        var myWeeklyBarChart = new Chart(ctxWeekly, {
            type: "bar",
            data: {
                labels: auditorNames,
                datasets: [{
                    label: "Weekly Audit Count",
                    backgroundColor: "rgba(2,117,216,1)",
                    borderColor: "rgba(2,117,216,1)",
                    data: [
                        @foreach ($monthlyAssy as $auditor)
                            {{ $auditor->total_week_with_audit }},
                        @endforeach
                    ],

                }, ],

            },
            options: {
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: false,
                        },
                        ticks: {
                            maxTicksLimit: 6,
                        },
                        barThickness: 50
                    }],
                    yAxes: [{
                        ticks: {
                            min: 0,
                            max: 4,
                            stepSize: 1,
                            callback: function(value, index, values) {
                                switch (value) {
                                    case 1:
                                        return 'Minggu 1';
                                    case 2:
                                        return 'Minggu 2';
                                    case 3:
                                        return 'Minggu 3';
                                    case 4:
                                        return 'Minggu 4';
                                    default:
                                        return value;
                                }
                            }
                        },
                        gridLines: {
                            display: true,
                        },
                    }],
                },
                legend: {
                    display: false,
                },
            },
        });
    </script> --}}


    {{-- <script>
        var monthlyAuditorsData = <?php echo json_encode($bulanAssy); ?>;
        var auditorNames = [];
        var auditorMonthlyData = [];

        // Mengisi array dengan data yang diperoleh dari backend
        for (var i = 0; i < monthlyAuditorsData.length; i++) {
            auditorNames.push(monthlyAuditorsData[i].auditor_name);
            auditorMonthlyData.push(monthlyAuditorsData[i].total_bulan_with_audit);
        }

        var ctxMonthly = document.getElementById("myMonthlyBarChart");
        var myMonthlyBarChart = new Chart(ctxMonthly, {
            type: "bar",
            data: {
                labels: auditorNames,
                datasets: [{
                    label: "Monthly Audit Count",
                    backgroundColor: "rgba(2,117,216,1)",
                    borderColor: "rgba(2,117,216,1)",
                    data: auditorMonthlyData,
                }],
            },
            options: {
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: false,
                        },
                        ticks: {
                            maxTicksLimit: 6,
                        },
                        barThickness: 30
                    }],
                    yAxes: [{
                        ticks: {
                            min: 0,
                            max: 12,
                            stepSize: 1,
                        },
                        gridLines: {
                            display: true,
                        },
                    }],
                },
                legend: {
                    display: false,
                },
            },
        });
    </script> --}}
@endpush
