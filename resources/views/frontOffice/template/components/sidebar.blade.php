<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="index3.html" class="brand-link">
        <span class="brand-text font-weight-bold">Departement Front Office</span>
    </a>
    <div class="sidebar">
        @role('reservation')
            @include('frontOffice.template.components.menuInclude.reservation')
        @endrole
        @role('reception')
            @include('frontOffice.template.components.menuInclude.reception')
        @endrole
    </div>
</aside>