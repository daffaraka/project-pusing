<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-red" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                {{-- <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link" href="index.html">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a> --}}
                <div class="sb-sidenav-menu-heading">Audit</div>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#casting" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Audit Casting
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="casting" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{url('/checksheetcasting')}}">Checksheet</a>
                        {{-- <a class="nav-link" href="{{url('/datacasting')}}">Data</a> --}}
                        <a class="nav-link" href="{{url('/dashboardcasting')}}">Dashboard</a>
                        <a class="nav-link" href="{{url('/castinghistory')}}">History</a>

                    </nav>
                </div>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#machining" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Audit Machining
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="machining" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{url('/checksheetmachining')}}">Checksheet</a>
                        {{-- <a class="nav-link" href="{{url('/datamachining')}}">Data</a> --}}
                        <a class="nav-link" href="{{url('/dashboardmachining')}}">Dashboard</a>
                        <a class="nav-link" href="{{url('/machining-history')}}">History</a>
                    </nav>
                </div>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#painting" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Audit Painting
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="painting" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{url('/checksheetpainting')}}">Checksheet</a>
                        {{-- <a class="nav-link" href="{{url('/datapainting')}}">Data</a> --}}
                        <a class="nav-link" href="{{url('/dashboard-painting')}}">Dashboard</a>
                        <a class="nav-link" href="{{url('/painting-history')}}">History</a>

                    </nav>
                </div>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#assy" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Audit Assy
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="assy" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{url('/checksheetassy')}}">Checksheet</a>
                        {{-- <a class="nav-link" href="{{url('/dataassy')}}">Data</a> --}}
                        <a class="nav-link" href="{{url('/dashboard-assy')}}">Dashboard</a>
                        <a class="nav-link" href="{{url('/assy-history')}}">History</a>


                    </nav>
                </div>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#supp" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Audit Supplier
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="supp" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{url('/checksheetsupp')}}">Checksheet</a>
                        <a class="nav-link" href="{{url('/dashboard-supplier')}}">Dashboard</a>
                        <a class="nav-link" href="{{url('/supplier-history')}}">History</a>

                    </nav>
                </div>
                {{-- <div class="sb-sidenav-menu-heading">Addons</div>
                <a class="nav-link" href="charts.html">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                    Charts
                </a>
                <a class="nav-link" href="tables.html">
                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                    Tables
                </a> --}}
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            Start Bootstrap
        </div>
    </nav>
</div>
