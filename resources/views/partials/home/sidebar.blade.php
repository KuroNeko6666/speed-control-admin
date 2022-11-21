<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SC Admin</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    @foreach ($menus as $menu)
        @if ($menu['sub_menus'] == null)
        <li class="nav-item {{ $menu['active'] ? 'active' : '' }} ">
            <a class="nav-link" href="{{ $menu['path'] }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>{{ $menu['name'] }}</span></a>
        </li>
        @else
        <li class="nav-item {{ $menu['active'] ? 'active' : '' }}">
            <a class="nav-link {{ $menu['active'] ? '' : 'collapsed' }}" href="#" data-toggle="collapse" data-target="#master"
                aria-expanded="true" aria-controls="master">
                <i class="fas fa-fw fa-cog"></i>
                <span>{{ $menu['name'] }}</span>
            </a>
            <div id="master" class="collapse {{ $menu['active'] ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Data {{ $menu['name'] }}</h6>
                    @foreach ($menu['sub_menus'] as $sub_menu)
                        <a class="collapse-item {{ $sub_menu['active'] ? 'active' : '' }}" href="{{ $sub_menu['path'] }}">{{ $sub_menu['name'] }}</a>
                    @endforeach
                </div>
            </div>
        </li>
        @endif
    @endforeach

    {{-- <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>

    <li class="nav-item {{ str_contains($active, 'master') ? 'active' : '' }}">
        <a class="nav-link {{ str_contains($active, 'master') ? '' : 'collapsed' }}" href="#" data-toggle="collapse" data-target="#master"
            aria-expanded="true" aria-controls="master">
            <i class="fas fa-fw fa-cog"></i>
            <span>Master</span>
        </a>
        <div id="master" class="collapse {{ str_contains($active, 'master') ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Data Psikotest :</h6>
                <a class="collapse-item {{ $active == 'master-admin' ? 'active' : '' }}" href="/master/admin">Data Admin</a>
                <a class="collapse-item {{ $active == 'master-user' ? 'active' : '' }}" href="/master/user">Data Pengguna</a>
                <a class="collapse-item {{ $active == 'master-company' ? 'active' : '' }}" href="/master/company">Data Perusahaan</a>
                <a class="collapse-item {{ $active == 'master-psychologist' ? 'active' : '' }}" href="/master/psychologist">Data Psikolog</a>
                <a class="collapse-item {{ $active == 'master-skill' ? 'active' : '' }}" href="/skill/data">Data Kemampuan</a>
            </div>
        </div>
    </li> --}}

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>


</ul>
<!-- End of Sidebar -->
