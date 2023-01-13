<!-- Right navbar links -->
<ul class="navbar-nav @if(app()->getLocale() == 'fa') mr-auto @else ml-auto @endif">
    <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
            <img src="{{ asset('admin-panel/dist/img/avatar/50.jpg') }}" class="user-image img-circle elevation-2" alt="User Image">
            <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg @if(app()->getLocale() == 'fa') dropdown-menu-left @else dropdown-menu-right @endif">
            <!-- User image -->
            <li class="user-header bg-primary">
                <img src="{{ asset('admin-panel/dist/img/avatar/100.jpg') }}" class="img-circle elevation-2" alt="User Image">
                <p>
                    {{ auth()->user()->name }}
                    <small>{{ 'Manager' }}</small>
                </p>
            </li>
            {{--<li class="user-body">
                <div class="row">
                    <div class="col-4 text-center">
                        <a href="#">Followers</a>
                    </div>
                    <div class="col-4 text-center">
                        <a href="#">Sales</a>
                    </div>
                    <div class="col-4 text-center">
                        <a href="#">Friends</a>
                    </div>
                </div>
            </li>--}}
            <li class="user-footer">
                {{--  <a href="{{ route('admin.profile') }}" class="btn btn-default btn-flat">{{ __('admin.profile') }}</a>  --}}
                <a href="#" onclick="event.preventDefault();document.querySelector('#admin-logout-form').submit();" class="btn btn-default btn-flat @if(app()->getLocale() == 'fa') float-left @else float-right @endif">{{ __('admin.logout') }}</a>
                <form id="admin-logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </li>
</ul>
