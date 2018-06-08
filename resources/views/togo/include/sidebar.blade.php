@verbatim
<div class="page-sidebar navbar-collapse collapse">
    <!-- BEGIN SIDEBAR MENU -->
    <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
    <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
    <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
    <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200"
        ng-class="{'page-sidebar-menu-closed': settings.layout.pageSidebarClosed}">
        <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
        <li class="sidebar-search-wrapper hide">
            <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
            <!-- DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box -->
            <!-- DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box -->
            <form class="sidebar-search sidebar-search-bordered" action="#" method="POST">
                <a href="javascript:;" class="remove">
                    <i class="fa fa-close"></i>
                </a>
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search...">
                    <span class="input-group-btn">
                        <a href="javascript:;" class="btn submit">
                            <i class="fa fa-magnifier"></i>
                        </a>
                    </span>
                </div>
            </form>
            <!-- END RESPONSIVE QUICK SEARCH FORM -->
        </li>
        <li class="start nav-item">
            <a href="#/dashboard">
                <i class="fa fa-home"></i>
                <span class="title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#/apps">
                <i class="fa fa-code"></i>
                <span class="title">Apps</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#/library">
                <i class="fa fa-book"></i>
                <span class="title">Libraries</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#/data/explorer/">
                <i class="fa fa-database"></i>
                <span class="title">Data</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#/jobs">
                <i class="fa fa-rocket"></i>
                <span class="title">Jobs</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="fa fa-pencil-square-o"></i>
                <span class="title">Metadata</span>
                <span class="arrow "></span>
            </a>
            <ul class="sub-menu">
                <li>
                    <a href="#/meta">
                        <i class="fa fa-search"></i> Meta
                    </a>
                </li>
                <li>
                    <a href="#/meta/schema">
                        <i class="fa fa-bars"></i> Schemas
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#/monitors">
                <i class="fa fa-television"></i>
                <span class="title">Monitors</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="fa fa-bell"></i>
                <span class="title">Notifications</span>
                <span class="arrow "></span>
            </a>
            <ul class="sub-menu">
                <li>
                    <a href="#/notifications/alerts">
                        <i class="fa fa-search"></i> Alerts
                    </a>
                </li>
                <li>
                    <a href="#/notifications/manager">
                        <i class="fa fa-bars"></i> Subscriptions
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#/systems">
                <i class="fa fa-server"></i>
                <span class="title">Systems</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#/tags" id="sidebar_menu_link_tags">
                <i class="fa fa-tags"></i>
                <span class="title">Tags</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#/uuids" id="sidebar_menu_link_uuids">
                <i class="fa fa-search"></i>
                <span class="title">UUIDs</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="https://agaveapi.slack.com" id="sidebar_menu_link_community">
                <i class="fa fa-group"></i>
                <span class="title">Community</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="https://github.com/agaveplatform/agave-togo-laravel/issues" id="sidebar_menu_link_feedback">
                <i class="fa fa-comment-o"></i>
                <span class="title">Feedback</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ tenant.supportUrl }}" id="sidebar_menu_link_support">
                <i class="fa fa-support"></i>
                <span class="title">Support</span>
            </a>
        </li>
    </ul>
    <!-- END SIDEBAR MENU -->
</div>
@endverbatim