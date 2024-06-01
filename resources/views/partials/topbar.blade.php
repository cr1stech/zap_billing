<!-- start: header -->
<header class="header">
    <div class="logo-container">
        <a href="#" class="logo">
            <img src="{{ asset('img/logo.png') }}" width="75" height="35" alt="Porto Admin"/>
        </a>

        <div class="d-md-none toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html"
             data-fire-event="sidebar-left-opened">
            <i class="fas fa-bars" aria-label="Toggle sidebar"></i>
        </div>
    </div>

    <!-- start: user box -->
    <div class="header-right">

        <span class="separator"></span>

        <div id="userbox" class="userbox">
            <a href="#" data-bs-toggle="dropdown">
                <figure class="profile-picture">
                    <img src="{{ asset('img/default.webp') }}" alt="Administrador" class="rounded-circle"
                         data-lock-picture="img/default.webp"/>
                </figure>
                <div class="profile-info" data-lock-name="{{ Auth::user()->name }}" data-lock-email="admin@b2.com">
                    <span class="name">{{ Auth::user()->name }}</span>
                    <span class="role">Administrator</span>
                </div>
            </a>
        </div>
    </div>
    <!-- end: search & user box -->
</header>
<!-- end: header -->
