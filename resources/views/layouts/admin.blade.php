<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Ebenezer') }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('bower_components/Ionicons/css/ionicons.min.css')}}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css')}}">
    <!-- Material Design -->
    <link rel="stylesheet" href="{{ asset('dist/css/bootstrap-material-design.min.css')}}">
    <link rel="stylesheet" href="{{ asset('dist/css/ripples.min.css')}}">
    <link rel="stylesheet" href="{{ asset('dist/css/MaterialAdminLTE.min.css')}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('dist/css/skins/all-md-skins.min.css')}}">
    <!-- Morris chart -->
    <link rel="stylesheet" href="{{ asset('bower_components/morris.js/morris.css')}}">
    <!-- jvectormap -->
    <link rel="stylesheet" href="{{ asset('bower_components/jvectormap/jquery-jvectormap.css')}}">
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
    <link href="{{asset('plugins/pnotify/dist/pnotify.css')}}" rel="stylesheet">
    <link href="{{asset('plugins/pnotify/dist/pnotify.buttons.css')}}" rel="stylesheet">
    <link href="{{asset('plugins/pnotify/dist/pnotify.nonblock.css')}}" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        <header class="main-header">
            <!-- Logo -->
            <a href="{{route('inicio')}}" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini">C<b>E</b>Z</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg">Colegio<b>{{ config('app.name') }}</b></span>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>

                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!--Messages: style can be found in dropdown.less
                                                    <li class="dropdown messages-menu">
                                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                            <i class="fa fa-envelope-o"></i>
                                                            <span class="label label-success">4</span>
                                                        </a>
                                                        <ul class="dropdown-menu">
                                                            <li class="header">You have 4 messages</li>
                                                            <li>
                                                                 inner menu: contains the actual data
                                                                <ul class="menu">
                                                                    <li> start message
                                                                        <a href="#">
                                                                            <div class="pull-left">
                                                                                <img src="dist/img/avatar.jpg" class="img-circle" alt="User Image">
                                                                            </div>
                                                                            <h4>
                                                                                Support Team
                                                                                <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                                                            </h4>
                                                                            <p>Why not buy a new awesome theme?</p>
                                                                        </a>
                                                                    </li>
                                                                     end message
                                                                    <li>
                                                                        <a href="#">
                                                                            <div class="pull-left">
                                                                                <img src="dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                                                                            </div>
                                                                            <h4>
                                                                                AdminLTE Design Team
                                                                                <small><i class="fa fa-clock-o"></i> 2 hours</small>
                                                                            </h4>
                                                                            <p>Why not buy a new awesome theme?</p>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#">
                                                                            <div class="pull-left">
                                                                                <img src="dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                                                                            </div>
                                                                            <h4>
                                                                                Developers
                                                                                <small><i class="fa fa-clock-o"></i> Today</small>
                                                                            </h4>
                                                                            <p>Why not buy a new awesome theme?</p>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#">
                                                                            <div class="pull-left">
                                                                                <img src="dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                                                                            </div>
                                                                            <h4>
                                                                                Sales Department
                                                                                <small><i class="fa fa-clock-o"></i> Yesterday</small>
                                                                            </h4>
                                                                            <p>Why not buy a new awesome theme?</p>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#">
                                                                            <div class="pull-left">
                                                                                <img src="dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                                                                            </div>
                                                                            <h4>
                                                                                Reviewers
                                                                                <small><i class="fa fa-clock-o"></i> 2 days</small>
                                                                            </h4>
                                                                            <p>Why not buy a new awesome theme?</p>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                            <li class="footer"><a href="#">See All Messages</a></li>
                                                        </ul>
                                                    </li>
                                                     Notifications: style can be found in dropdown.less
                                                    <li class="dropdown notifications-menu">
                                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                            <i class="fa fa-bell-o"></i>
                                                            <span class="label label-warning">10</span>
                                                        </a>
                                                        <ul class="dropdown-menu">
                                                            <li class="header">You have 10 notifications</li>
                                                            <li>
                                                                 inner menu: contains the actual data
                                                                <ul class="menu">
                                                                    <li>
                                                                        <a href="#">
                                                                            <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#">
                                                                            <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
                                                                            page and may cause design problems
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#">
                                                                            <i class="fa fa-users text-red"></i> 5 new members joined
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#">
                                                                            <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#">
                                                                            <i class="fa fa-user text-red"></i> You changed your username
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                            <li class="footer"><a href="#">View all</a></li>
                                                        </ul>
                                                    </li>
                                                     Tasks: style can be found in dropdown.less
                                                    <li class="dropdown tasks-menu">
                                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                            <i class="fa fa-flag-o"></i>
                                                            <span class="label label-danger">9</span>
                                                        </a>
                                                        <ul class="dropdown-menu">
                                                            <li class="header">You have 9 tasks</li>
                                                            <li>
                                                                 inner menu: contains the actual data
                                                                <ul class="menu">
                                                                    <li> Task item
                                                                        <a href="#">
                                                                            <h3>
                                                                                Design some buttons
                                                                                <small class="pull-right">20%</small>
                                                                            </h3>
                                                                            <div class="progress xs">
                                                                                <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar"
                                                                                     aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                                                    <span class="sr-only">20% Complete</span>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                     end task item
                                                                    <li> Task item
                                                                        <a href="#">
                                                                            <h3>
                                                                                Create a nice theme
                                                                                <small class="pull-right">40%</small>
                                                                            </h3>
                                                                            <div class="progress xs">
                                                                                <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar"
                                                                                     aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                                                    <span class="sr-only">40% Complete</span>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                     end task item
                                                                    <li> Task item
                                                                        <a href="#">
                                                                            <h3>
                                                                                Some task I need to do
                                                                                <small class="pull-right">60%</small>
                                                                            </h3>
                                                                            <div class="progress xs">
                                                                                <div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar"
                                                                                     aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                                                    <span class="sr-only">60% Complete</span>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                     end task item
                                                                    <li> Task item
                                                                        <a href="#">
                                                                            <h3>
                                                                                Make beautiful transitions
                                                                                <small class="pull-right">80%</small>
                                                                            </h3>
                                                                            <div class="progress xs">
                                                                                <div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar"
                                                                                     aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                                                    <span class="sr-only">80% Complete</span>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                     end task item
                                                                </ul>
                                                            </li>
                                                            <li class="footer">
                                                                <a href="#">View all tasks</a>
                                                            </li>
                                                        </ul>
                                                    </li>-->
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="{{ asset('dist/img/avatar.jpg')}}" class="user-image" alt="User Image">
                                <span class="hidden-xs">{{Auth::user()->nombres." ".Auth::user()->apellidos}}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header">
                                    <img src="{{ asset('dist/img/avatar.jpg')}}" class="img-circle" alt="User Image">

                                    <p>
                                        {{Auth::user()->nombres." ".Auth::user()->apellidos}}
                                        <small>{{session('ROL')}}</small>
                                    </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        @if(session()->exists('MOD_INICIO'))
                                        <a href="{{route('inicio')}}" class="btn btn-default btn-flat">Inicio</a>
                                        @endif
                                    </div>
                                    <div class="pull-right">
                                        <a class="btn btn-default btn-flat" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                       document.getElementById('logout-form').submit();">
                                            Salir
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <!-- Control Sidebar Toggle Button -->
                        <!--                            <li>
                                                        <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                                                    </li>-->
                    </ul>
                </div>
            </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- Sidebar user panel -->
                <div class="user-panel">
                    <div class="pull-left image">
                        <img src="{{ asset('dist/img/avatar.jpg')}}" class="img-circle" alt="User Image">
                    </div>
                    <div class="pull-left info">
                        <p>{{Auth::user()->nombres." ".Auth::user()->apellidos}}</p>
                        <a href="#"><i class="fa fa-circle text-success"></i> {{session('ROL')}}</a>
                    </div>
                </div>
                <!--                     search form
                                    <form action="#" method="get" class="sidebar-form">
                                        <div class="input-group">
                                            <input type="text" name="q" class="form-control" placeholder="Search...">
                                            <span class="input-group-btn">
                                                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </form>
                                     /.search form -->
                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu" data-widget="tree">
                    <li class="header">
                        <h4>MEN?? PRINCIPAL</h4>
                    </li>
                    @if(session()->exists('MOD_INICIO'))
                    @if($location=='home')
                    <li class="active"><a href="{{route('inicio')}}"><i class="fa fa-home"></i> <span>Inicio</span></a>
                    </li>
                    @else
                    <li><a href="{{route('inicio')}}"><i class="fa fa-home"></i> <span>Inicio</span></a></li>
                    @endif
                    @endif
                    @if(session()->exists('MOD_USUARIOS'))
                    @if($location=='usuarios')
                    <li class="active"><a href="{{route('menu.usuarios')}}"><i class="fa fa-users"></i> <span>Seguridad & Usuarios</span></a>
                    </li>
                    @else
                    <li><a href="{{route('menu.usuarios')}}"><i class="fa fa-users"></i>
                            <span>Seguridad & Usuarios</span></a></li>
                    @endif
                    @endif
                    @if(session()->exists('MOD_ADMISIONES'))
                    @if($location=='admisiones')
                    <li class="active"><a href="{{route('menu.admisiones')}}"><i class="fa fa-check-circle-o"></i>
                            <span>Admisiones</span></a></li>
                    @else
                    <li><a href="{{route('menu.admisiones')}}"><i class="fa fa-check-circle-o"></i>
                            <span>Admisiones</span></a></li>
                    @endif
                    @endif
                    @if(session()->exists('MOD_MATRICULA'))
                    @if($location=='matricula')
                    <li class="active"><a href="{{route('menu.matricula')}}"><i class="fa fa-tasks"></i> <span>Matr??cula</span></a>
                    </li>
                    @else
                    <li><a href="{{route('menu.matricula')}}"><i class="fa fa-tasks"></i> <span>Matr??cula</span></a>
                    </li>
                    @endif
                    @endif
                    @if(session()->exists('MOD_PANEL-ACUDIENTE'))
                    @if($location=='inscripcion')
                    <li class="active"><a href="{{route('menu.inscripcion')}}"><i class="fa fa-edit"></i> <span>Inscripci??n</span></a>
                    </li>
                    @else
                    <li><a href="{{route('menu.inscripcion')}}"><i class="fa fa-edit"></i> <span>Inscripci??n</span></a>
                    </li>
                    @endif
                    @endif
                    @if(session()->exists('MOD_ACADEMICO'))
                    @if($location=='academico')
                    <li class="active"><a href="{{route('menu.academico')}}"><i class="fa fa-book"></i> <span>Acad??mico</span></a>
                    </li>
                    @else
                    <li><a href="{{route('menu.academico')}}"><i class="fa fa-book"></i> <span>Acad??mico</span></a>
                    </li>
                    @endif
                    @endif
                    @if(session()->exists('MOD_ACADEMICO-DOCENTE'))
                    @if($location=='academicodocente')
                    <li class="active"><a href="{{route('menu.academicodocente')}}"><i class="fa fa-book"></i> <span>Acad??mico</span></a>
                    </li>
                    @else
                    <li><a href="{{route('menu.academicodocente')}}"><i class="fa fa-book"></i> <span>Acad??mico</span></a>
                    </li>
                    @endif
                    @endif
                    @if(session()->exists('MOD_DOCUMENTAL'))
                    @if($location=='documental')
                    <li class="active"><a href="{{route('menu.documental')}}"><i class="fa fa-folder"></i> <span>Documental</span></a>
                    </li>
                    @else
                    <li><a href="{{route('menu.documental')}}"><i class="fa fa-folder"></i>
                            <span>Documental</span></a></li>
                    @endif
                    @endif
                    @if(session()->exists('MOD_PANEL-DOCENTE'))
                    @if($location=='aulavirtual')
                    <li class="active"><a href="{{route('menu.aulavirtual')}}"><i class="fa fa-vimeo"></i> <span>Aula Virtual</span></a>
                    </li>
                    @else
                    <li><a href="{{route('menu.aulavirtual')}}"><i class="fa fa-vimeo"></i>
                            <span>Aula Virtual</span></a></li>
                    @endif
                    @endif
                    @if(session()->exists('MOD_PANEL-ESTUDIANTE'))
                    @if($location=='aulavirtual')
                    <li class="active"><a href="{{route('menu.aulavirtual')}}"><i class="fa fa-vimeo"></i> <span>Aula Virtual</span></a>
                    </li>
                    @else
                    <li><a href="{{route('menu.aulavirtual')}}"><i class="fa fa-vimeo"></i>
                            <span>Aula Virtual</span></a></li>
                    @endif
                    @endif
                    @if(session()->exists('MOD_ACADEMICO-ESTUDIANTE'))
                    @if($location=='academico_e_a')
                    <li class="active"><a href="{{route('menu.academicoestudiante')}}"><i class="fa fa-book"></i>
                            <span>Acad??mico</span></a></li>
                    @else
                    <li><a href="{{route('menu.academicoestudiante')}}"><i class="fa fa-book"></i>
                            <span>Acad??mico</span></a></li>
                    @endif
                    @endif
                    @if(session()->exists('MOD_ACADEMICO-ACUDIENTE'))
                    @if($location=='academicoacudiente')
                    <li class="active"><a href="{{route('menu.academicoacudiente')}}"><i class="fa fa-book"></i>
                            <span>Acad??mico</span></a></li>
                    @else
                    <li><a href="{{route('menu.academicoacudiente')}}"><i class="fa fa-book"></i>
                            <span>Acad??mico</span></a></li>
                    @endif
                    @endif
                    @if(session()->exists('MOD_REPORTES'))
                    @if($location=='reportes')
                    <li class="active"><a href="{{route('menu.reportes')}}"><i class="fa fa-file-pdf-o"></i>
                            <span>Reportes</span></a></li>
                    @else
                    <li><a href="{{route('menu.reportes')}}"><i class="fa fa-book"></i>
                            <span>Reportes</span></a></li>
                    @endif
                    @endif
                    <!--                        <li class="treeview">
                                                    <a href="#">
                                                        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                                                        <span class="pull-right-container">
                                                            <i class="fa fa-angle-left pull-right"></i>
                                                        </span>
                                                    </a>
                                                    <ul class="treeview-menu">
                                                        <li class="active"><a href="index.html"><i class="fa fa-circle-o"></i> Dashboard v1</a></li>
                                                        <li><a href="index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>
                                                    </ul>
                                                </li>
                                                <li>
                                                    <a href="pages/calendar.html">
                                                        <i class="fa fa-calendar"></i> <span>Calendar</span>
                                                        <span class="pull-right-container">
                                                            <small class="label pull-right bg-red">3</small>
                                                            <small class="label pull-right bg-blue">17</small>
                                                        </span>
                                                    </a>
                                                </li>
                                                <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
                                                                                                                                                        <li>                                                                                                                                                <a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>-->
                    <li>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form2').submit();">
                            <i class="fa fa-sign-out"></i> <span>Salir</span>
                        </a>
                        <form id="logout-form2" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                @yield('breadcrumb')
            </section>
            <!-- Main content -->
            <section class="content">
                @include('flash::message')
                @yield('content')
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>Version</b> 1.0
            </div>
            <strong>Copyright &copy; 2019 <a href="{{ config('app.url') }}">Colegio <b>Ebenezer</b></a>.</strong> Todos los
            derechos reservados.
        </footer>

        <!--             Control Sidebar
                    <aside class="control-sidebar control-sidebar-dark">
                         Create the tabs
                        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
                            <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
                            <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
                        </ul>
                         Tab panes
                        <div class="tab-content">
                             Home tab content
                            <div class="tab-pane" id="control-sidebar-home-tab">
                                <h3 class="control-sidebar-heading">Recent Activity</h3>
                                <ul class="control-sidebar-menu">
                                    <li>
                                        <a href="javascript:void(0)">
                                            <i class="menu-icon fa fa-birthday-cake bg-red"></i>

                                            <div class="menu-info">
                                                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                                                <p>Will be 23 on April 24th</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">
                                            <i class="menu-icon fa fa-user bg-yellow"></i>

                                            <div class="menu-info">
                                                <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                                                <p>New phone +1(800)555-1234</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">
                                            <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

                                            <div class="menu-info">
                                                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                                                <p>nora@example.com</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">
                                            <i class="menu-icon fa fa-file-code-o bg-green"></i>

                                            <div class="menu-info">
                                                <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                                                <p>Execution time 5 seconds</p>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                                 /.control-sidebar-menu

                                <h3 class="control-sidebar-heading">Tasks Progress</h3>
                                <ul class="control-sidebar-menu">
                                    <li>
                                        <a href="javascript:void(0)">
                                            <h4 class="control-sidebar-subheading">
                                                Custom Template Design
                                                <span class="label label-danger pull-right">70%</span>
                                            </h4>

                                            <div class="progress progress-xxs">
                                                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">
                                            <h4 class="control-sidebar-subheading">
                                                Update Resume
                                                <span class="label label-success pull-right">95%</span>
                                            </h4>

                                            <div class="progress progress-xxs">
                                                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">
                                            <h4 class="control-sidebar-subheading">
                                                Laravel Integration
                                                <span class="label label-warning pull-right">50%</span>
                                            </h4>

                                            <div class="progress progress-xxs">
                                                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">
                                            <h4 class="control-sidebar-subheading">
                                                Back End Framework
                                                <span class="label label-primary pull-right">68%</span>
                                            </h4>

                                            <div class="progress progress-xxs">
                                                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                                 /.control-sidebar-menu

                            </div>
                             /.tab-pane
                             Stats tab content
                            <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
                             /.tab-pane
                             Settings tab content
                            <div class="tab-pane" id="control-sidebar-settings-tab">
                                <form method="post">
                                    <h3 class="control-sidebar-heading">General Settings</h3>

                                    <div class="form-group">
                                        <label class="control-sidebar-subheading">
                                            Report panel usage
                                            <input type="checkbox" class="pull-right" checked>
                                        </label>

                                        <p>
                                            Some information about this general settings option
                                        </p>
                                    </div>
                                     /.form-group

                                    <div class="form-group">
                                        <label class="control-sidebar-subheading">
                                            Allow mail redirect
                                            <input type="checkbox" class="pull-right" checked>
                                        </label>

                                        <p>
                                            Other sets of options are available
                                        </p>
                                    </div>
                                     /.form-group

                                    <div class="form-group">
                                        <label class="control-sidebar-subheading">
                                            Expose author name in posts
                                            <input type="checkbox" class="pull-right" checked>
                                        </label>

                                        <p>
                                            Allow the user to show his name in blog posts
                                        </p>
                                    </div>
                                     /.form-group

                                    <h3 class="control-sidebar-heading">Chat Settings</h3>

                                    <div class="form-group">
                                        <label class="control-sidebar-subheading">
                                            Show me as online
                                            <input type="checkbox" class="pull-right" checked>
                                        </label>
                                    </div>
                                     /.form-group

                                    <div class="form-group">
                                        <label class="control-sidebar-subheading">
                                            Turn off notifications
                                            <input type="checkbox" class="pull-right">
                                        </label>
                                    </div>
                                     /.form-group

                                    <div class="form-group">
                                        <label class="control-sidebar-subheading">
                                            Delete chat history
                                            <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
                                        </label>
                                    </div>
                                     /.form-group
                                </form>
                            </div>
                             /.tab-pane
                        </div>
                    </aside>
                     /.control-sidebar -->
        <!-- Add the sidebar's background. This div must be placed
             immediately after the control sidebar -->
        <div class="control-sidebar-bg"></div>
    </div>
    <!-- ./wrapper -->

    <!-- jQuery 3 -->
    <script src="{{ asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('bower_components/jquery-ui/jquery-ui.min.js')}}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <!-- Material Design -->
    <script src="{{ asset('dist/js/material.min.js')}}"></script>
    <script src="{{ asset('dist/js/ripples.min.js')}}"></script>
    <script>
        $.material.init();
    </script>
    <!-- Morris.js charts -->
    <script src="{{ asset('bower_components/raphael/raphael.min.js')}}"></script>
    <script src="{{ asset('bower_components/morris.js/morris.min.js')}}"></script>
    <!-- Sparkline -->
    <script src="{{ asset('bower_components/jquery-sparkline/dist/jquery.sparkline.min.js')}}"></script>
    <!-- jvectormap -->
    <script src="{{ asset('plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
    <script src="{{ asset('plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('bower_components/jquery-knob/dist/jquery.knob.min.js')}}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('bower_components/moment/min/moment.min.js')}}"></script>
    <script src="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
    <!-- datepicker -->
    <script src="{{ asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="{{ asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
    <!-- DataTables -->
    <script src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    <!-- Slimscroll -->
    <script src="{{ asset('bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
    <!-- FastClick -->
    <script src="{{ asset('bower_components/fastclick/lib/fastclick.js')}}"></script>
    <script src="{{ asset('plugins/pnotify/dist/pnotify.js')}}"></script>
    <script src="{{ asset('plugins/pnotify/dist/pnotify.buttons.js')}}"></script>
    <script src="{{ asset('plugins/pnotify/dist/pnotify.nonblock.js')}}"></script>
    <!-- Select2 -->
    <script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js')}}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ asset('dist/js/pages/dashboard.js')}}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('dist/js/demo.js')}}"></script>
    <!-- CK Editor -->
    <script src="{{ asset('bower_components/ckeditor/ckeditor.js')}}"></script>
    <script type="text/javascript">
        var url = "<?php echo config('app.url'); ?>/";

        function notify(title, text, type) {
            new PNotify({
                title: title,
                text: text,
                type: type,
                styling: 'bootstrap3'
            });
        }
    </script>
    @yield('script')
</body>

</html>