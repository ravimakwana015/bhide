<!-- Main Sidebar Container -->
<aside class="main-sidebar elevation-4 sidebar-dark-teal">
    <!-- Brand Logo -->
    <a href="{{ route('admin.home') }}" class="brand-link navbar-teal">
        <img src="{{ asset('public/admin/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
        class="brand-image img-circle elevation-5" style="opacity: 1.8">
        <span class="brand-text font-weight-light">{{ config('app.name', 'Concierge') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('public/admin/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                alt="User Image">
            </div>
            <div class="info">
                <a href="{{ route('admin.details') }}" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('admin.home') }}"
                    class="nav-link @if(\Request::route()->getName()=='admin.home') active @endif">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('companies.index') }}"
                class="nav-link @if(\Request::route()->getName()=='companies.index' || \Request::route()->getName()=='companies.create'  || \Request::route()->getName()=='companies.show') active @endif">
                <i class="nav-icon fas fa-building"></i>
                <p> Companies </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('alluser.index') }}"
            class="nav-link @if(\Request::route()->getName()=='alluser.index') active @endif">
            <i class="nav-icon fas fa-user"></i>
            <p>All Users </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('concierge.index') }}"
        class="nav-link @if(\Request::route()->getName()=='concierge.index') active @endif">
        <i class="nav-icon fas fa-user"></i>
        <p>Concierge User </p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('transaction.index') }}"
    class="nav-link @if(\Request::route()->getName()=='transaction.index') active @endif">
    <i class="nav-icon fas fa-file-invoice-dollar"></i>
    <p> Transactions </p>
</a>
</li>
<li class="nav-item">
    <a href="{{ route('servicecategory.index') }}"
    class="nav-link @if(\Request::route()->getName()=='servicecategory.index') active @endif">
    <i class="nav-icon fab fa-servicestack"></i>
    <p> Services Category </p>
</a>
</li>
<li class="nav-item">
    <a href="{{ route('service.index') }}"
    class="nav-link @if(\Request::route()->getName()=='service.index') active @endif">
    <i class="nav-icon fab fa-servicestack"></i>
    <p> Services </p>
</a>
</li>
<li class="nav-item">
    <a href="{{ route('loyaltystorescategory.index') }}"
    class="nav-link @if(\Request::route()->getName()=='loyaltystorescategory.index') active @endif">
    <i class="nav-icon fas fa-store"></i>
    <p> Loyalty Stores Category</p>
</a>
</li>
<li class="nav-item">
    <a href="{{ route('loyaltystores.index') }}"
    class="nav-link @if(\Request::route()->getName()=='loyaltystores.index') active @endif">
    <i class="nav-icon fas fa-store"></i>
    <p> Loyalty Stores </p>
</a>
</li>
<li class="nav-item">
    <a href="{{ route('parcel.index') }}"
    class="nav-link @if(\Request::route()->getName()=='parcel.index') active @endif">
    <i class="nav-icon fas fa-cube"></i>
    <p> Parcels </p>
</a>
</li>
<li class="nav-item">
    <a href="{{ route('poll.index') }}"
    class="nav-link @if(\Request::route()->getName()=='poll.index') active @endif">
    <i class="nav-icon fas fa-poll"></i>
    <p> Polls </p>
</a>
</li>
<li class="nav-item">
    <a href="{{ route('issue.index') }}"
    class="nav-link @if(\Request::route()->getName()=='issue.index') active @endif">
    <i class="nav-icon fas fa-bug"></i>
    <p> Issues </p>
</a>
</li>
<li class="nav-item">
    <a href="{{ route('facilitie.index') }}"
    class="nav-link @if(\Request::route()->getName()=='facilitie.index') active @endif">
    <i class="nav-icon fas fa-tasks"></i>
    <p> Facilities </p>
</a>
</li>
<li class="nav-item">
    <a href="{{ route('facilitiesoptions.index') }}"
    class="nav-link @if(\Request::route()->getName()=='facilitiesoptions.index') active @endif">
    <i class="nav-icon fas fa-tasks"></i>
    <p> Facilities Options</p>
</a>
</li>
<li class="nav-item">
    <a href="{{ route('agent.index') }}"
    class="nav-link @if(\Request::route()->getName()=='agent.index') active @endif">
    <i class="nav-icon fas fa-user"></i>
    <p> Agents </p>
</a>
</li>
<li class="nav-item">
    <a href="{{ route('advert.index') }}"
    class="nav-link @if(\Request::route()->getName()=='advert.index') active @endif">
    <i class="nav-icon fas fa-ad"></i>
    <p> Adverts </p>
</a>
</li>
<li class="nav-item">
    <a href="{{ route('emergencys.index') }}"
    class="nav-link @if(\Request::route()->getName()=='emergencys.index') active @endif">
    <i class="nav-icon fas fa-plus"></i>
    <p> Emergency Responce </p>
</a>
</li>
<li class="nav-item">
    <a href="{{ route('features.index') }}"
    class="nav-link @if(\Request::route()->getName()=='features.index') active @endif">
    <i class="nav-icon fas fa-anchor"></i>
    <p> Features </p>
</a>
</li>
<li class="nav-header">Reports</li>
<li class="nav-item">
    <a href="{{ route('user.reports') }}" class="nav-link @if(\Request::route()->getName()=='user.reports') active @endif">
        <i class="nav-icon fas fa-cogs"></i>
        <p>Members Reports</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('reportcompany.reports') }}" class="nav-link @if(\Request::route()->getName()=='company.reports') active @endif">
        <i class="nav-icon fas fa-cogs"></i>
        <p>Company Reports</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('reporttransactions.reports') }}" class="nav-link @if(\Request::route()->getName()=='reporttransactions.reports') active @endif">
        <i class="nav-icon fas fa-cogs"></i>
        <p>Transaction Reports</p>
    </a>
</li>
{{-- <li class="nav-item">
    <a href="{{ route('pages.index') }}" class="nav-link @if(\Request::route()->getName()=='pages.index') active @endif">
        <i class="nav-icon fas fa-pager"></i>
        <p>Pages</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('seo.index') }}" class="nav-link @if(\Request::route()->getName()=='seo.index') active @endif">
        <i class="nav-icon fas fa-bullhorn"></i>
        <p>General SEO</p>
    </a>
</li> --}}
<li class="nav-header">Configuration</li>
<li class="nav-item">
    <a href="{{ route('settings.edit',1) }}" class="nav-link @if(\Request::route()->getName()=='settings.edit') active @endif">
        <i class="nav-icon fas fa-cogs"></i>
        <p>Settings</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('pages.index') }}" class="nav-link @if(\Request::route()->getName()=='pages.index') active @endif">
        <i class="nav-icon fas fa-pager"></i>
        <p>Pages</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('seo.index') }}" class="nav-link @if(\Request::route()->getName()=='seo.index') active @endif">
        <i class="nav-icon fas fa-bullhorn"></i>
        <p>General SEO</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('/log-viewer/logs') }}" target="_blank" class="nav-link">
        <i class="nav-icon fas fa-bug"></i>
        <p>Log Viewer</p>
    </a>
</li>
</ul>
</nav>
<!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
</aside>
