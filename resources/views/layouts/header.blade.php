<header class="main-header" >
    <!-- Logo -->
    <a href="#" class="logo" style="background-color: #a9fd00">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini" style="color: #000000"><b>DTE</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg" style="color: #000000"><b>Presensi </b>DTE</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" style="background-color: #0a0a0a">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button" style="color: #a9fd00">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{!! asset('images/photo.svg') !!}" class="user-image" alt="User Image">
                        <span class="hidden-xs" style="color: #a9fd00">
                            @if(Auth::user()->user_level==1)
                                {!! $user->dsnNama !!}
                            @else
                                {!! $user->pegNama !!}
                            @endif
                                <span class="caret"></span></span>
                    </a>
                    <ul class="dropdown-menu" style="background-color: #0a0a0a">
                        <!-- User image -->
                        <li class="user-header" style="background-color:#222121">
                            <img src="{!! asset('images/photo.svg') !!}" class="img-circle" alt="User Image">

                            <p>@if(Auth::user()->user_level==1)
                                    {!! $user->dsnNama !!}
                                @else
                                    {!! $user->pegNama !!}
                                @endif
                                <small> @if(Auth::user()->user_level==1)
                                            Dosen
                                        @else
                                            Pegawai
                                        @endif
                                    Departemen {!! $user->prodiNama !!}<br>
                                   Fakultas {!! $user->nama !!}
                                    Universitas Sumatera Utara</small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer" style="background-color: #0a0a0a">
                            <div class="pull-left">
                                <a href="/ubahpassword/{!! auth()->user()->id !!}/edit" class="btn btn-primary btn-flat">Change Password</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{ route('logout') }}" class="btn btn-danger btn-flat" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">Logout</a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>