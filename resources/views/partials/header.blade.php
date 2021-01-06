<form class="form-inline mr-auto">
    <ul class="navbar-nav mr-3">
        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>

    </ul>
</form>

<ul class="navbar-nav navbar-right">
    <li class="dropdown">
        <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <img alt="image" src="{{ url('images/avatar.png') }}" class="rounded-circle mr-1">
            <div class="d-sm-none d-lg-inline-block">Hi, {{ auth()->user()->name }}</div>
        </a>
        <div class="dropdown-menu dropdown-menu-right">

            <a href="{{ route('users.show',base64_encode(auth()->user()->id)) }}" class="dropdown-item has-icon">
                <i class="fa fa-cogs"></i> Change Password
            </a>

            <div class="dropdown-divider"></div>
            {{ Form::open(['url' => 'logout']) }}
                <button class="dropdown-item has-icon text-danger d-flex align-items-center">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </button>
            {{ Form::close() }}
        </div>
    </li>
</ul>
