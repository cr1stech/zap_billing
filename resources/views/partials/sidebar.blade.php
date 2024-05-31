<!-- start: sidebar -->
<aside id="sidebar-left" class="sidebar-left">

    <div class="sidebar-header">
        <div class="sidebar-title">
            Navigation
        </div>
        <div class="sidebar-toggle d-none d-md-block" data-toggle-class="sidebar-left-collapsed"
             data-target="html" data-fire-event="sidebar-left-toggle">
            <i class="fas fa-bars" aria-label="Toggle sidebar"></i>
        </div>
    </div>

    <div class="nano">
        <div class="nano-content">
            <nav id="menu" class="nav-main" role="navigation">
                <ul class="nav nav-main">

                    <hr class="separator"/>

                    <li class="{{ request()->routeIs('dashboard') ? 'nav-active' : '' }}">
                        <a class="nav-link" href="{{ route('dashboard') }}">
                            <i class="bx bx-home-alt" aria-hidden="true"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <hr class="separator"/>

                    <li class="{{ request()->routeIs('clients.index') ? 'nav-active' : '' }}">
                        <a class="nav-link" href="{{ route('clients.index') }}">
                            <i class="bx bx-home-alt" aria-hidden="true"></i>
                            <span>Clientes</span>
                        </a>
                    </li>

                    <li class="{{ request()->routeIs('client-accounts.index') ? 'nav-active' : '' }}">
                        <a class="nav-link" href="{{ route('client-accounts.index') }}">
                            <i class="bx bx-home-alt" aria-hidden="true"></i>
                            <span>Contas</span>
                        </a>
                    </li>

                </ul>
            </nav>

            <hr class="separator"/>
        </div>

    </div>

</aside>
<!-- end: sidebar -->
