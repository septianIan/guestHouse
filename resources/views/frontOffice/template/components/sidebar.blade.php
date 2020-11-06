<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="index3.html" class="brand-link">
        <span class="brand-text font-weight-bold">Departement Front Office</span>
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="/{{ request()->segment(1) }}" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Home
                        </p>
                    </a>
                </li>
                @include('frontOffice.template.components.menuInclude.reservation')
                @include('frontOffice.template.components.menuInclude.reception')
                @include('frontOffice.template.components.menuInclude.fitur')
            <ul>
        </nav>
    </div>
</aside>