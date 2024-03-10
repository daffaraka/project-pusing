<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>{{ $judul }} | Dashboard - SB Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    {{-- <link href="/css/styles.css" rel="stylessheet"/> --}}
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.html">Menu</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..."
                    aria-describedby="btnNavbarSearch" />
                <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i
                        class="fas fa-search"></i></button>
            </div>
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Settings</a></li>
                    <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="#!">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        @include('layouts/partials/sidebar')
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Dashboard Audit Machining </h1>
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
                                    <div class="card-body"><canvas id="myBarChart" width="100%"
                                            height="40"></canvas></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Data Audit Machining
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
                                    @foreach ($auditorsMachining as $auditor)
                                        @php
                                            $score = round($auditor->answers->sum('mark') / $totalQuestion, 1);
                                            $rowStyle =
                                                $score > 99
                                                    ? 'background-color: #00FF00;'
                                                    : 'background-color: #FF0000;';
                                        @endphp
                                        <tr style="{{ $rowStyle }}">
                                            <td>{{ $auditor->auditor_name }}</td>
                                            <td>{{ $score }}</td>
                                            <td><a href="{{ route('detailmachining', $auditor->id) }}"
                                                    class="btn btn-primary">Detail</a></td>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="{{ asset('js/datatables-simple-demo.js') }}"></script>

    <script>
        var auditorsData = {!! json_encode($monthlyMachining) !!};
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
                        @foreach ($monthlyMachining as $auditor)
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
</body>

</html>
