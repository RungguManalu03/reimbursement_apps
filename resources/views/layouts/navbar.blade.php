<div class="app-menu navbar-menu">
    <div class="navbar-brand-box">
        <a href="index-2.html" class="logo logo-dark">
            <span class="logo-lg">
                <img src="{{ asset('assets/images/logo.svg') }}" alt="" width="150">
                <h6>Reimbursement Apps Kasir Pintar</h6>
            </span>
        </a>
        <a href="index-2.html" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('assets/images/logo.svg') }}" alt="" width="150">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('assets/images/logo.svg') }}" alt="" width="150">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                @if (Auth::user()->jabatan == "FINANCE")
                 <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::is('manajemen-reimbursement-finance') ? 'active' : '' }}"
                        href="{{ route('manajemen-reimbursement-finance') }}" role="button">
                        <i class="ri-database-2-line"></i> <span data-key="t-dashboards">Manajemen Reimbursement</span>
                    </a>
                </li>
                @endif
                @if (Auth::user()->jabatan == "DIREKTUR")
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ Request::is('manajemen-user') ? 'active' : '' }}"
                            href="{{ route('manajemen-user') }}" role="button">
                            <i class="ri-user-line"></i> <span data-key="t-dashboards">Manajemen User</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ Request::is('manajemen-reimbursement-direktur') ? 'active' : '' }}"
                            href="{{ route('manajemen-reimbursement-direktur') }}" role="button">
                            <i class="ri-database-2-line"></i> <span data-key="t-dashboards">Manajemen Reimbursement</span>
                        </a>
                    </li>
                @endif
                @if (Auth::user()->jabatan == "STAFF")
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ Request::is('data-pengajuan-reimbursement') ? 'active' : '' }}"
                            href="{{ route('data-pengajuan-reimbursement') }}" role="button">
                            <i class="ri-apps-2-line"></i> <span data-key="t-dashboards">Pengajuan Reimbursement</span>
                        </a>
                    </li>
                </li>
                @endif
            </ul>
        </div>
    </div>
    <div class="sidebar-background"></div>
</div>
<div class="vertical-overlay"></div>
