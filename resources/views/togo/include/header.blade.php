<!-- BEGIN HEADER INNER -->
<div class="page-header-inner">
    <!-- BEGIN LOGO -->
    <div class="page-logo">
        <a href="#">
            <img src="{{ URL::asset('assets/layouts/layout/img/logo-big.png') }}" alt="logo" class="logo-default"/> </a>
        <div class="menu-toggler sidebar-toggler">
            <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
        </div>
    </div>
    <!-- END LOGO -->
    <!-- BEGIN HEADER SEARCH BOX -->
    <!-- DOC: Apply "search-form-expanded" right after the "search-form" class to have half expanded search box -->
    <form class="search-form" action="#" method="GET">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Search..." name="query">
            <span class="input-group-btn">
                <a href="javascript:;" class="btn submit">
                    <i class="icon-magnifier"></i>
                </a>
            </span>
        </div>
    </form>
    <!-- END HEADER SEARCH BOX -->
    <!-- BEGIN RESPONSIVE MENU TOGGLER -->
    <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse"
       data-target=".navbar-collapse"> </a>
    <!-- END RESPONSIVE MENU TOGGLER -->
    <!-- BEGIN TOP NAVIGATION MENU -->
    <div class="top-menu">
        <ul class="nav navbar-nav pull-right">
            @verbatim
                <li class="dropdown dropdown-extended dropdown-status" id="header_status_bar">
                    <a href="#" class="dropdown-toggle" dropdown-menu-hover data-toggle="dropdown"
                       data-close-others="true">
                        <i class="icon fa fa-sliders"></i>
                        <span ng-if="platformStatus.statusCode == 400"
                              class="badge badge-warning"> {{ platformStatus.issues.length }} </span>
                        <span ng-if="platformStatus.statusCode > 400"
                              class="badge badge-danger"> {{ platformStatus.issues.length }} </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="external">
                            <h3><span class="bold">{{ platformStatus.issues.length }} active</span> service outage(s)
                            </h3>
                            <a href="http://status.agaveapi.co/">view all</a>
                        </li>
                        <li>
                            <ul class="dropdown-menu-list scroller" style="height: 275px;" data-handle-color="#637283">
                                <li ng-repeat="platformIssue in platformStatus.issues">
                                    <a href="http://status.agaveapi.co/" title="{{platformIssue.status}}">
                                        <span class="uptime">{{ platformIssue.updated | amDurationFormat : 'minute' }}</span>
                                        <span class="details">
                                        <span ng-if="platformIssue.statusCode == 400"
                                              class="label label-sm label-icon label-warning">
                                            <i class="fa fa-exclamation-triangle"></i>
                                        </span>
                                        <span ng-if="platformIssue.statusCode != 400"
                                              class="label label-sm label-icon label-danger">
                                            <i class="fa fa-exclamation-triangle"></i>
                                        </span>
                                            {{ platformIssue.component }}
                                    </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="external">
                            <h3>
                                <span class="bold">last check at {{ lastStatusCheckedAt | amDateFormat:'h:mm:ss a' }}</span>
                            </h3>
                            <a ng-click="toggleStatusCheck()" href="#">
                                <span ng-if="statusCheckEnabled" class="fa fa-pause">pause</span>
                                <span ng-if="!statusCheckEnabled" class="fa fa-play">resume</span>
                            </a>
                        </li>
                    </ul>
                </li>
        @endverbatim
        <!-- END TODO DROPDOWN -->
            <!-- BEGIN LANGUAGE BAR -->
            <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
            <li class="dropdown dropdown-language hide">
                <a href="#" class="dropdown-toggle" dropdown-menu-hover data-toggle="dropdown" data-close-others="true">
                    <img alt="" src="{{ URL::asset('assets/global/img/flags/us.png') }}">
                    <span class="langname"> EN </span>
                    <i class="fa fa-angle-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-default">
                    <li class="active">
                        <a href="#">
                            <img alt="" src="{{ URL::asset('assets/global/img/flags/us.png') }}"> English </a>
                    </li>
                    <li>
                        <a href="#">
                            <img alt="" src="{{ URL::asset('assets/global/img/flags/de.png') }}"> German </a>
                    </li>
                    <li>
                        <a href="#">
                            <img alt="" src="{{ URL::asset('assets/global/img/flags/ru.png') }}"> Russian </a>
                    </li>
                    <li>
                        <a href="#">
                            <img alt="" src="{{ URL::asset('assets/global/img/flags/fr.png') }}"> French </a>
                    </li>
                </ul>
            </li>
            <!-- END LANGUAGE BAR -->
            <!-- BEGIN USER LOGIN DROPDOWN -->
            <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
            <li class="dropdown dropdown-user">
                <a href="#" class="dropdown-toggle" dropdown-menu-hover data-toggle="dropdown" data-close-others="true">
                    <img alt="" class="img-circle" ng-src="{{ gravatar()->get($user->email) }}"/>
                    <span class="username username-hide-on-mobile"> {{ $user->name }} </span>
                    <i class="fa fa-angle-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-default">
                    <li class="tenant-badge">
                        <a href="{{ URL::route("frontend.contact") }}">
                            <span class="logo">
                                <img ng-src="{{ URL::asset('img/tenants/' . env('AGAVE_TENANT') . '.png') }}">
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="#/profile/me/account">
                            <i class="icon-user"></i> My Profile </a>
                    </li>
                    <li>
                        <a href="{{ URL::route('frontend.auth.logout') }}">
                            <i class="icon-key"></i> Log Out
                        </a>
                    </li>
                </ul>
            </li>
            <!-- END USER LOGIN DROPDOWN -->
            <!-- BEGIN QUICK SIDEBAR TOGGLER -->
            <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
            <li class="dropdown dropdown-quick-sidebar-toggler">
                <a href="javascript:;" class="dropdown-toggle">
                    <i class="icon-logout"></i>
                </a>
            </li>
            <!-- END QUICK SIDEBAR TOGGLER -->
        </ul>
    </div>
    <!-- END TOP NAVIGATION MENU -->
</div>
<!-- END HEADER INNER -->
