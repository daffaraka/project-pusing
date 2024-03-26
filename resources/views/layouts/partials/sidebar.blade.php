<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-red" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Audit</div>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#casting"
                    aria-expanded="false" aria-controls="collapseLayouts">
                    Audit Casting
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>

                <div class="collapse" id="casting" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link collapsed dropdown-keep-open" href="{{ url('/checksheetcasting') }}">
                            <i class="fas fa-file-alt"></i>
                            <span style="margin-left: 5px;">Checksheet</span>
                        </a>
                        <a class="nav-link" href="{{ url('/dashboardcasting') }}">
                            <i class="fa-solid fa-chart-line"></i>
                            <span style="margin-left: 5px;">Dashboard</span>
                        </a>

                        <a class="nav-link" href="{{ url('/castinghistory') }}">
                            <i class="fa-solid fa-clock"></i>
                            <span style="margin-left: 5px;">History</span>
                        </a>
                    </nav>
                </div>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#machining"
                    aria-expanded="false" aria-controls="collapseLayouts">
                    {{-- <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div> --}}
                    Audit Machining
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="machining" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ url('/checksheetmachining') }}">
                            <i class="fas fa-file-alt"></i>
                            <span style="margin-left: 5px;">Checksheet</span>
                        </a>
                        <a class="nav-link" href="{{ url('/dashboardmachining') }}">
                            <i class="fa-solid fa-chart-line"></i>
                            <span style="margin-left: 5px;">Dashboard</span>
                        </a>
                        <a class="nav-link" href="{{ url('/machining-history') }}">
                            <i class="fa-solid fa-clock"></i>
                            <span style="margin-left: 5px;">History</span>
                        </a>
                    </nav>
                </div>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#painting"
                    aria-expanded="false" aria-controls="collapseLayouts">
                    {{-- <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div> --}}
                    Audit Painting
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="painting" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ url('/checksheetpainting') }}">
                            <i class="fas fa-file-alt"></i>
                            <span style="margin-left: 5px;">Checksheet</span>
                        </a>
                        <a class="nav-link" href="{{ url('/dashboard-painting') }}">
                            <i class="fa-solid fa-chart-line"></i>
                            <span style="margin-left: 5px;">Dashboard</span>
                        </a>
                        <a class="nav-link" href="{{ url('/painting-history') }}">
                            <i class="fa-solid fa-clock"></i>
                            <span style="margin-left: 5px;">History</span>
                        </a>
                    </nav>
                </div>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#assy"
                    aria-expanded="false" aria-controls="collapseLayouts">
                    Audit Assy
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="assy" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ url('/checksheetassy') }}">
                            <i class="fas fa-file-alt"></i>
                            <span style="margin-left: 5px;">Checksheet</span>
                        </a>
                        <a class="nav-link" href="{{ url('/dashboard-assy') }}">
                            <i class="fa-solid fa-chart-line"></i>
                            <span style="margin-left: 5px;">Dashboard</span>
                        </a>
                        <a class="nav-link" href="{{ url('/assy-history') }}">
                            <i class="fa-solid fa-clock"></i>
                            <span style="margin-left: 5px;">History</span></a>
                    </nav>
                </div>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#supp"
                    aria-expanded="false" aria-controls="collapseLayouts">
                    {{-- <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div> --}}
                    Audit Supplier
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="supp" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ url('/checksheetsupp') }}">
                            <i class="fas fa-file-alt"></i>
                            <span style="margin-left: 5px;">Checksheet</span></a>
                        <a class="nav-link" href="{{ url('/dashboard-supplier') }}">
                            <i class="fa-solid fa-chart-line"></i>
                            <span style="margin-left: 5px;">Dashboard</span></a>
                        <a class="nav-link" href="{{ url('/supplier-history') }}">
                            <i class="fa-solid fa-clock"></i>
                            <span style="margin-left: 5px;">History</span></a>
                    </nav>
                </div>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            Start Bootstrap
        </div>
    </nav>
</div>
