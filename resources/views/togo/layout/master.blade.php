<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js" data-ng-app="AgaveToGo"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js" data-ng-app="AgaveToGo"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" data-ng-app="AgaveToGo">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <title data-ng-bind="'Agave ToGo | ' + $state.current.data.pageTitle"></title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="/favicon.ico') }}">
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <!--<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />-->
    <!-- <link href="{{ asset('bower_components/googlefonts/css/style.css" rel="stylesheet" type="text/css') }}" /> -->
    <link href="{{ asset('app/css/global.css') }}" id="style_components" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css') }}" />
    <link href="{{ asset('bower_components/agave-fonticons/style.css" rel="stylesheet" type="text/css') }}" />
    <link href="{{ asset('assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css') }}" />
    <link href="{{ asset('assets/global/plugins/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css') }}" />
    <link href="{{ asset('assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css') }}" />
    <link href="{{ asset('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css') }}" />
    <link href="{{ asset('bower_components/angular-ui-select/dist/select.min.css" rel="stylesheet" type="text/css') }}" />
    <link href="{{ asset('bower_components/angular-toastr/dist/angular-toastr.css" rel="stylesheet" type="text/css') }}"/>
    <link href="{{ asset('bower_components/json-formatter/dist/json-formatter.css" rel="stylesheet" type="text/css') }}"/>
    <link href="{{ asset('bower_components/jsoneditor/dist/jsoneditor.min.css" rel="stylesheet" type="text/css') }}"/>
    <link href="{{ asset('bower_components/angular-object-diff/dist/angular-object-diff.css" rel="stylesheet" type="text/css') }}">


    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN DYMANICLY LOADED CSS FILES(all plugin and page related styles must be loaded between GLOBAL and THEME css files ) -->
    <link id="ng_load_plugins_before" />
    <!-- END DYMANICLY LOADED CSS FILES -->
    <!-- BEGIN THEME STYLES -->
    <!-- DOC: To use 'rounded corners' style just load 'components-rounded.css' stylesheet instead of 'components.css' in the below style tag -->
    <link href="{{ asset('assets/global/css/components.css" id="style_components" rel="stylesheet" type="text/css') }}" />
    <link href="{{ asset('assets/global/css/plugins.css" rel="stylesheet" type="text/css') }}" />
    <link href="{{ asset('assets/layouts/layout/css/layout.css" rel="stylesheet" type="text/css') }}" />
    <link href="{{ asset('assets/layouts/layout/css/themes/darkblue.css" rel="stylesheet" type="text/css') }}" id="style_color" />
    <link href="{{ asset('assets/layouts/layout/css/custom.css" rel="stylesheet" type="text/css') }}" />
    <!-- END THEME STYLES -->
</head>
<!-- END HEAD -->
<body ng-controller="AppController" class="page-header-fixed page-sidebar-closed-hide-logo page-on-load" ng-class="{'page-content-white': settings.layout.pageContentWhite,'page-container-bg-solid': settings.layout.pageBodySolid, 'page-sidebar-closed': settings.layout.pageSidebarClosed}">
    <!-- BEGIN PAGE SPINNER -->
    <div ng-spinner-bar class="page-spinner-bar">
        <!-- <div class="bounce1"></div>
        <div class="bounce2"></div>
        <div class="bounce3"></div> -->
    </div>
    <!-- END PAGE SPINNER -->
    <!-- BEGIN HEADER -->
    <div data-ng-include="'tpl/header.html'" data-ng-controller="HeaderController" class="page-header navbar navbar-fixed-top"> </div>
    <!-- END HEADER -->
    <div class="clearfix"> </div>
    <!-- BEGIN CONTAINER -->
    <div class="page-container">
        <!-- BEGIN SIDEBAR -->
        <div data-ng-include="'tpl/sidebar.html'" data-ng-controller="SidebarController" class="page-sidebar-wrapper"> </div>
        <!-- END SIDEBAR -->
        <!-- BEGIN CONTENT -->
        <div class="page-content-wrapper">
            <div class="page-content">
                <!-- BEGIN STYLE CUSTOMIZER(optional) -->
                <div data-ng-include="'tpl/theme-panel.html'" data-ng-controller="ThemePanelController" class="theme-panel hidden-xs hidden-sm"> </div>
                <!-- END STYLE CUSTOMIZER -->
                <!-- BEGIN ACTUAL CONTENT -->
                <div ui-view class="fade-in-up"> </div>
                <!-- END ACTUAL CONTENT -->
            </div>
        </div>
        <!-- END CONTENT -->
        <!-- BEGIN QUICK SIDEBAR -->
        <a href="javascript:;" class="page-quick-sidebar-toggler">
            <i class="icon-login"></i>
        </a>
        <div data-ng-include="'tpl/quick-sidebar.html'" data-ng-controller="QuickSidebarController" class="page-quick-sidebar-wrapper"></div>
        <!-- END QUICK SIDEBAR -->
    </div>
    <!-- END CONTAINER -->
    <!-- BEGIN FOOTER -->
    <div data-ng-include="'tpl/footer.html'" data-ng-controller="FooterController" class="page-footer"> </div>
    <!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
    <!-- END FOOTER -->

    <!--[if lt IE 9]>
    <script src="{{ asset('assets/global/plugins/respond.min.js') }}"></script>
    <script src="{{ asset('assets/global/plugins/excanvas.min.js') }}"></script>
    <script src="{{ asset('assets/global/plugins/ie8.fix.min.js') }}"></script>
    <![endif]-->
    <script src="{{ asset('assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('bower_components/bootstrap-modal/js/bootstrap-modal.js') }}" type="text/javascript"></script>
    <script src="{{ asset('bower_components/bootstrap-modal/js/bootstrap-modalmanager.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js') }}" type="text/javascript"></script>

    <script src="{{ asset('bower_components/bootstrap-table/dist/bootstrap-table.min.js') }}" type="text/javascript"></script>

    <script src="{{ asset('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('bower_components/jquery.blockui/index.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/jquery.cokie.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/uniform/jquery.uniform.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('bower_components/codemirror/lib/codemirror.js') }}" type="text/javascript"></script>
    <script src="{{ asset('bower_components/underscore/underscore-min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('bower_components/socket.io/socket.io.min.js') }}"></script>
    <script src="{{ asset('bower_components/laravel-echo/echo.min.js') }}"></script>

    <!-- <script src="{{ asset('bower_components/angular-file-upload/dist/angular-file-upload.min.js') }}" type="text/javascript"></script> -->


    <!-- END CORE JQUERY PLUGINS -->
    <!-- BEGIN CORE ANGULARJS PLUGINS -->
    <script src="{{ asset('bower_components/angular/angular.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/angularjs/angular-touch.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/angularjs/angular-cookies.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('bower_components/ng-file-upload/ng-file-upload.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('bower_components/checklist-model/checklist-model.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/angularjs/plugins/angular-ui-router.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/oclazyload/js/ocLazyLoad.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/angularjs/plugins/ui-bootstrap-tpls.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('bower_components/angular-translate/angular-translate.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('bower_components/angular-translate-handler-log/angular-translate-handler-log.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('bower_components/angular-translate-loader-partial/angular-translate-loader-partial.min.js') }}"></script>
    <script src="{{ asset('bower_components/angular-translate-storage-local/angular-translate-storage-cookie.min.js') }}"></script>

    <script src="{{ asset('bower_components/angular-sanitize/angular-sanitize.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('bower_components/oauth-ng/dist/oauth-ng.js') }}" type="text/javascript"></script>
    <script src="{{ asset('bower_components/ngstorage/ngStorage.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('bower_components/angular-md5/angular-md5.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('bower_components/moment/min/moment-with-locales.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('bower_components/angular-moment/angular-moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('bower_components/angular-cache/dist/angular-cache.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('bower_components/angular-utils-pagination/dirPagination.js') }}" type="text/javascript"></script>
    <script src="{{ asset('bower_components/angular-toastr/dist/angular-toastr.tpls.js') }}" type="text/javascript"></script>
    <script src="{{ asset('bower_components/json-formatter/dist/json-formatter.js') }}"></script>
    <script src="{{ asset('bower_components/angular-poller/angular-poller.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('bower_components/clipboard/dist/clipboard.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('bower_components/ngclipboard/dist/ngclipboard.min.js') }}" type="text/javascript"></script>

    <script type="text/javascript" src="{{ asset('bower_components/tv4/tv4.js') }}"></script>
    <script type="text/javascript" src="{{ asset('bower_components/angular-ui-select/dist/select.js') }}"></script>
    <script type="text/javascript" src="{{ asset('bower_components/objectpath/lib/ObjectPath.js') }}"></script>
    <script type="text/javascript" src="{{ asset('bower_components/angular-schema-form/dist/schema-form.js') }}"></script>
    <script type="text/javascript" src="{{ asset('bower_components/angular-schema-form/dist/bootstrap-decorator.js') }}"></script>
    <script type="text/javascript" src="{{ asset('bower_components/angular-schema-form-ui-select/angular-underscore.js') }}"></script>
    <script type="text/javascript" src="{{ asset('bower_components/angular-schema-form-ui-select/bootstrap-ui-select.min.js') }}"></script>


    <script type="text/javascript" src="{{ asset('app/js/services/WizardHandler.js') }}"></script>
    <script type="text/javascript" src="{{ asset('bower_components/jsoneditor/dist/jsoneditor.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('app/js/directives/ng-jsoneditor.js') }}"></script>
    <script src="{{ asset('bower_components/angular-object-diff/dist/angular-object-diff.js') }}" type="text/javascript"></script>

    <script type="text/javascript" src="{{ asset('bower_components/moment/min/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('bower_components/moment/min/locales.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('bower_components/humanize-duration/humanize-duration.js') }}"></script>

    <script src="{{ asset('app/js/services/commons.js') }}" type="text/javascript"></script>
    <script src="{{ asset('app/js/services/Tags.js') }}" type="text/javascript"></script>
    <script src="{{ asset('app/js/services/Jira.js') }}" type="text/javascript"></script>
    <script src="{{ asset('app/js/services/ChangelogParser.js') }}" type="text/javascript"></script>
    <script src="{{ asset('app/js/services/ActionsService.js') }}"></script>
    <script src="{{ asset('app/js/services/ActionsBulkService.js') }}"></script>
    <script src="{{ asset('app/js/services/PermissionsService.js') }}"></script>
    <script src="{{ asset('app/js/services/RolesService.js') }}"></script>
    <script src="{{ asset('app/js/services/MessageService.js') }}"></script>
    <script src="{{ asset('app/js/services/PreferencesService.js') }}"></script>
    <script src="{{ asset('app/js/services/TranslationsFactory.js') }}"></script>
    <!-- END CORE ANGULARJS PLUGINS -->

    <!-- BEGIN APP LEVEL JQUERY SCRIPTS -->
    <script src="{{ asset('assets/global/scripts/app.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/layouts/layout/scripts/layout.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/layouts/global/scripts/quick-sidebar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/layouts/layout/scripts/demo.js') }}" type="text/javascript"></script>
    <!-- END APP LEVEL JQUERY SCRIPTS -->

    <!-- BEGIN Agave SDK Includes -->
    <script src="{{ asset('bower_components/agave-angularjs-sdk/agave-angularjs-sdk.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('bower_components/angular-filebrowser/dist/agave-angular-filemanager.min.js') }}" type="text/javascript"></script>
    <!-- END JAVASCRIPTS -->

    <!-- BEGIN APP LEVEL ANGULARJS SCRIPTS -->
    <script src="{{ asset('app/js/main.js') }}" type="text/javascript"></script>

    <!--<script src="{{ asset('app/js/config.constant.js') }}"></script>-->
    <script src="{{ asset('app/js/config.env.js') }}"></script>
    <!--<script src="{{ asset('app/js/config.layout.js') }}"></script>-->
    <!--<script src="{{ asset('app/js/routes.js') }}"></script>-->
    <script src="{{ asset('app/js/filters/filters.js') }}" type="text/javascript"></script>
    <script src="{{ asset('app/js/directives/global.js') }}" type="text/javascript"></script>
    <script src="{{ asset('app/js/directives/TagsModal.js') }}" type="text/javascript"></script>
    <script src="{{ asset('app/js/directives/UserLookup.js') }}" type="text/javascript"></script>
    <script src="{{ asset('app/js/directives/QueryBuilder.js') }}" type="text/javascript"></script>
    <script src="{{ asset('app/js/controllers/base-directory-controller.js') }}" type="text/javascript"></script>
    <script src="{{ asset('app/js/controllers/base-resource-controller.js') }}" type="text/javascript"></script>
    <!-- END APP LEVEL ANGULARJS SCRIPTS -->
@yield('script')
</body>

</html>