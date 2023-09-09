<!-- Right navbar links -->
<ul class="navbar-nav @if (app()->getLocale() == 'fa') mr-auto @else ml-auto @endif">


    <ul class="navbar-nav align-items-center">
        <li class="nav-item dropdown">
   
            <div class="navbar-search-block" style="width: 50vw;">
                <div class="form-inline">
                    <div class="input-group input-group-sm w-100">
                        <input class="form-control form-control-navbar" type="search" name="search" placeholder="Search"
                            aria-label="Search">
                   
                    </div>

                  
                </div>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right dropdown-search" style="left: 0;">

                    <span
                        class="dropdown-item dropdown-header type-more"></span>


                        <div class="search-users"></div>
                        <div class="search-orders"></div>
                        <div class="search-tickets"></div>
              
                  
                </div>
            </div>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="true">
                <i class="far fa-bell"></i>
                <span
                    class="badge badge-warning navbar-badge">{{ auth()->user()->notifications()->where('new', 1)->count() }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
                <span
                    class="dropdown-item dropdown-header">{{ auth()->user()->notifications()->where('new', 1)->count() }}
                    Notifications</span>
                <div class="dropdown-divider"></div>
                <a href="{{ route('admin.tickets.index') }}" class="dropdown-item">
                    <i class="fas fa-envelope mr-2"></i>
                    {{ auth()->user()->notifications()->where(['new' => 1, 'type' => App\Enums\ENotificationType::Ticket])->count() }}
                    new tickets
                    <span
                        class="float-right text-muted text-sm">{{ auth()->user()->notifications()->where(['new' => 1, 'type' => App\Enums\ENotificationType::Ticket])->latest()->first()?->n_time }}</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('admin.requests.all') }}" class="dropdown-item">
                    <i class="fas fa-users mr-2"></i>
                    {{ auth()->user()->notifications()->where(['new' => 1, 'type' => App\Enums\ENotificationType::Requests])->count() }}
                    server requests
                    <span
                        class="float-right text-muted text-sm">{{ auth()->user()->notifications()->where(['new' => 1, 'type' => App\Enums\ENotificationType::Requests])->latest()->first()?->n_time }}</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('admin.orders.index') }}" class="dropdown-item">
                    <i class="fas fa-file mr-2"></i>
                    {{ auth()->user()->notifications()->where(['new' => 1, 'type' => App\Enums\ENotificationType::Deploying])->count() }}
                    new deploying server
                    <span
                        class="float-right text-muted text-sm">{{ auth()->user()->notifications()->where(['new' => 1, 'type' => App\Enums\ENotificationType::Deploying])->latest()->first()?->n_time }}</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('admin.notifications.index') }}" class="dropdown-item dropdown-footer">See All
                    Notifications</a>
            </div>
    </ul>
    <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
            <img src="{{ asset('admin-panel/dist/img/avatar/50.jpg') }}" class="user-image img-circle elevation-2"
                alt="User Image">
            <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
        </a>
        <ul
            class="dropdown-menu dropdown-menu-lg @if (app()->getLocale() == 'fa') dropdown-menu-left @else dropdown-menu-right @endif">
            <!-- User image -->
            <li class="user-header bg-primary">
                <img src="{{ asset('admin-panel/dist/img/avatar/100.jpg') }}" class="img-circle elevation-2"
                    alt="User Image">
                <p>
                    {{ auth()->user()->name }}
                    <small>{{ auth()->user()->getRoleNames()[0] }}</small>
                </p>
            </li>

            <li class="user-footer">
                {{--  <a href="{{ route('admin.profile') }}" class="btn btn-default btn-flat">{{ __('admin.profile') }}</a>  --}}
                <a href="#"
                    onclick="event.preventDefault();document.querySelector('#admin-logout-form').submit();"
                    class="btn btn-default btn-flat @if (app()->getLocale() == 'fa') float-left @else float-right @endif">{{ __('admin.logout') }}</a>
                <form id="admin-logout-form" action="{{ route('admin.logout') }}" method="POST"
                    style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>


    </li>

    </li>
</ul>
