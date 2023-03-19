<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-legacy" data-widget="treeview" role="menu"
            data-accordion="false">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}"
                    class="nav-link {{ request()->routeIs(['admin.dashboard', 'admin.']) ? 'active' : '' }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        {{ __('admin.dashboard') }}
                    </p>
                </a>
            </li>
            @role('admin')
                <li class="nav-item has-treeview {{ request()->routeIs(['admin.users.*', 'admin.blocked-users.*']) ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Users
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview {{ request()->routeIs(['admin.users.*']) ? 'd-block' : 'display-none' }}">

                        <li class="nav-item">
                            <a href="{{ route('admin.users.index') }}"
                                class="nav-link {{ request()->routeIs(['admin.users.index']) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('admin.all') }} users</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.users.create') }}"
                                class="nav-link {{ request()->routeIs(['admin.users.create']) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('admin.add') }} user</p>
                            </a>
                        </li>   
                        <li class="nav-item">
                            <a href="{{ route('admin.blocked-users.index') }}"
                                class="nav-link {{ request()->routeIs(['admin.blocked-users.*']) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('admin.all') }} blocked users</p>
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item has-treeview {{ request()->routeIs(['admin.admins.*']) ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user-secret"></i>
                        <p>
                            Admins
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview {{ request()->routeIs(['admin.admins.*']) ? 'd-block' : 'display-none' }}">

                        <li class="nav-item">
                            <a href="{{ route('admin.admins.index') }}"
                                class="nav-link {{ request()->routeIs(['admin.admins.index']) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('admin.all') }} admins</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.admins.create') }}"
                                class="nav-link {{ request()->routeIs(['admin.admins.create']) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('admin.add') }} admin</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-item has-treeview {{ request()->routeIs(['admin.permissions.*']) ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-key"></i>
                        <p>
                            Permissions
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul
                        class="nav nav-treeview {{ request()->routeIs(['admin.permissions.*']) ? 'd-block' : 'display-none' }}">

                        <li class="nav-item">
                            <a href="{{ route('admin.permissions.index') }}"
                                class="nav-link {{ request()->routeIs(['admin.permissions.index']) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('admin.all') }} permissions</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.permissions.create') }}"
                                class="nav-link {{ request()->routeIs(['admin.permissions.create']) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('admin.add') . ' ' . __('admin.new') }}</p>
                            </a>
                        </li>



                    </ul>
                </li>
                <li class="nav-item has-treeview {{ request()->routeIs(['admin.roles.*']) ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tasks"></i>
                        <p>
                            Roles
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview {{ request()->routeIs(['admin.roles.*']) ? 'd-block' : 'display-none' }}">

                        <li class="nav-item">
                            <a href="{{ route('admin.roles.index') }}"
                                class="nav-link {{ request()->routeIs(['admin.roles.index']) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('admin.all') }} roles</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.roles.create') }}"
                                class="nav-link {{ request()->routeIs(['admin.roles.create']) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('admin.add') . ' ' . __('admin.new') }}</p>
                            </a>
                        </li>



                    </ul>
                </li>
                <li class="nav-item has-treeview {{ request()->routeIs(['admin.emails.*']) ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-envelope"></i>
                        <p>
                            Emails
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview {{ request()->routeIs(['admin.emails.*']) ? 'd-block' : 'display-none' }}">

                        <li class="nav-item">
                            <a href="{{ route('admin.emails.index') }}"
                                class="nav-link {{ request()->routeIs(['admin.emails.index']) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('admin.all') }} emails</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.emails.create') }}"
                                class="nav-link {{ request()->routeIs(['admin.emails.create']) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('admin.add') }} email</p>
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item has-treeview {{ request()->routeIs(['admin.notifications.*']) ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-bell"></i>
                        <p>
                            Notifications
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul
                        class="nav nav-treeview {{ request()->routeIs(['admin.notifications.*']) ? 'd-block' : 'display-none' }}">

                        <li class="nav-item">
                            <a href="{{ route('admin.notifications.index') }}"
                                class="nav-link {{ request()->routeIs(['admin.notifications.index']) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('admin.all') }} notifications</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.notifications.create') }}"
                                class="nav-link {{ request()->routeIs(['admin.notifications.create']) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Send notification</p>
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item has-treeview {{ request()->routeIs(['admin.bulletins.*']) ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-newspaper"></i>
                        <p>
                            Bulletin
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul
                        class="nav nav-treeview {{ request()->routeIs(['admin.bulletins.*']) ? 'd-block' : 'display-none' }}">

                        <li class="nav-item">
                            <a href="{{ route('admin.bulletins.index') }}"
                                class="nav-link {{ request()->routeIs(['admin.bulletins.index']) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('admin.all') }} messages</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.bulletins.create') }}"
                                class="nav-link {{ request()->routeIs(['admin.bulletins.create']) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>New message</p>
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item has-treeview {{ request()->routeIs(['admin.off-codes.*']) ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-percent"></i>
                        <p>
                            Off codes
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul
                        class="nav nav-treeview {{ request()->routeIs(['admin.off-codes.*']) ? 'd-block' : 'display-none' }}">

                        <li class="nav-item">
                            <a href="{{ route('admin.off-codes.index') }}"
                                class="nav-link {{ request()->routeIs(['admin.off-codes.index']) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('admin.all') }} off codes</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.off-codes.create') }}"
                                class="nav-link {{ request()->routeIs(['admin.off-codes.create']) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('admin.add') }} new</p>
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item has-treeview {{ request()->routeIs(['admin.logs.*']) ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-history"></i>
                        <p>
                            Logs
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul
                        class="nav nav-treeview {{ request()->routeIs(['admin.logs.*']) ? 'd-block' : 'display-none' }}">

                        <li class="nav-item">
                            <a href="{{ route('admin.logs.index') }}"
                                class="nav-link {{ request()->routeIs(['admin.logs.index']) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('admin.all') }} logs</p>
                            </a>
                        </li>
                        

                    </ul>
                </li>
            @endrole
            @hasanyrole(['admin', 'support'])
                <li class="nav-item has-treeview {{ request()->routeIs(['admin.tickets.*']) ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-ticket-alt"></i>
                        <p>
                            Tickets
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul
                        class="nav nav-treeview {{ request()->routeIs(['admin.tickets.*', 'admin.ticket-template-types.*', 'admin.ticket-templates.*']) ? 'd-block' : 'display-none' }}">

                        <li class="nav-item">
                            <a href="{{ route('admin.tickets.index') }}"
                                class="nav-link {{ request()->routeIs(['admin.tickets.index']) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('admin.all') }} tickets</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.tickets.create') }}"
                                class="nav-link {{ request()->routeIs(['admin.tickets.create']) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Create ticket</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.ticket-templates.index') }}"
                                class="nav-link {{ request()->routeIs(['admin.ticket-templates.*']) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('admin.all') }} ticket templates</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.ticket-template-types.index') }}"
                                class="nav-link {{ request()->routeIs(['admin.ticket-template-types.*']) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('admin.all') }} ticket template types</p>
                            </a>
                        </li>

                    </ul>
                </li>
            @endhasanyrole
            @hasanyrole(['admin', 'sale'])
                <li class="nav-item has-treeview {{ request()->routeIs(['admin.orders.*']) ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>
                            Orders
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul
                        class="nav nav-treeview {{ request()->routeIs(['admin.orders.*']) ? 'd-block' : 'display-none' }}">

                        <li class="nav-item">
                            <a href="{{ route('admin.orders.index') }}"
                                class="nav-link {{ request()->routeIs(['admin.orders.index']) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('admin.all') }} orders</p>
                            </a>
                        </li>


                    </ul>
                </li>
                <li class="nav-item has-treeview {{ request()->routeIs(['admin.labels.*']) ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tag"></i>
                        <p>
                            Order labels
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul
                        class="nav nav-treeview {{ request()->routeIs(['admin.labels.*']) ? 'd-block' : 'display-none' }}">

                        <li class="nav-item">
                            <a href="{{ route('admin.labels.index') }}"
                                class="nav-link {{ request()->routeIs(['admin.labels.index']) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('admin.all') }} labels</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.labels.create') }}"
                                class="nav-link {{ request()->routeIs(['admin.labels.create']) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('admin.add') }} labels</p>
                            </a>
                        </li>


                    </ul>
                </li>

                <li class="nav-item has-treeview {{ request()->routeIs(['admin.labels.*']) ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-file-signature"></i>
                        <p>
                            Service Requests
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul
                        class="nav nav-treeview {{ request()->routeIs(['admin.requests.*']) ? 'd-block' : 'display-none' }}">

                        <li class="nav-item">
                            <a href="{{ route('admin.requests.all') }}"
                                class="nav-link {{ request()->routeIs(['admin.requests.all']) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('admin.all') }} requests</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.requests.index') }}"
                                class="nav-link {{ request()->routeIs(['admin.requests.index']) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('admin.all') }} request types</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="mt-4  nav-item has-treeview {{ request()->routeIs(['admin.servers.*']) ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-server"></i>
                        <p>
                            Servers
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul
                        class="nav nav-treeview {{ request()->routeIs(['admin.servers.*']) ? 'd-block' : 'display-none' }}">

                        <li class="nav-item">
                            <a href="{{ route('admin.servers.index') }}"
                                class="nav-link {{ request()->routeIs(['admin.servers.index']) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('admin.all') }} servers</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.servers.create') }}"
                                class="nav-link {{ request()->routeIs(['admin.servers.create']) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('admin.add') }} server</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="pl-3 nav-item has-treeview {{ request()->routeIs(['admin.os.*']) ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-desktop"></i>
                        <p>
                            Operating systems
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview {{ request()->routeIs(['admin.os.*']) ? 'd-block' : 'display-none' }}">

                        <li class="nav-item">
                            <a href="{{ route('admin.os.index') }}"
                                class="nav-link {{ request()->routeIs(['admin.os.index']) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('admin.all') }} os</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.os.create') }}"
                                class="nav-link {{ request()->routeIs(['admin.os.create']) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('admin.add') }} os</p>
                            </a>
                        </li>

                    </ul>
                </li>


                <li
                    class="pl-3 nav-item has-treeview {{ request()->routeIs(['admin.locations.*']) ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-map-marker"></i>
                        <p>
                            Locations
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul
                        class="nav nav-treeview {{ request()->routeIs(['admin.locations.*']) ? 'd-block' : 'display-none' }}">

                        <li class="nav-item">
                            <a href="{{ route('admin.locations.index') }}"
                                class="nav-link {{ request()->routeIs(['admin.locations.index']) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('admin.all') }} locations</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.locations.create') }}"
                                class="nav-link {{ request()->routeIs(['admin.locations.create']) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('admin.add') }} location</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class=" pl-3 nav-item has-treeview {{ request()->routeIs(['admin.types.*']) ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-file"></i>
                        <p>
                            Server Types
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul
                        class="nav nav-treeview {{ request()->routeIs(['admin.types.*']) ? 'd-block' : 'display-none' }}">

                        <li class="nav-item">
                            <a href="{{ route('admin.types.index') }}"
                                class="nav-link {{ request()->routeIs(['admin.types.index']) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('admin.all') }} types</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.types.create') }}"
                                class="nav-link {{ request()->routeIs(['admin.types.create']) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('admin.add') }} type</p>
                            </a>
                        </li>

                    </ul>
                </li>


                <li class="pl-3 nav-item has-treeview {{ request()->routeIs(['admin.plans.*']) ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tasks"></i>
                        <p>
                            Server Plans
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul
                        class="nav nav-treeview {{ request()->routeIs(['admin.plans.*']) ? 'd-block' : 'display-none' }}">

                        <li class="nav-item">
                            <a href="{{ route('admin.plans.index') }}"
                                class="nav-link {{ request()->routeIs(['admin.plans.index']) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('admin.all') }} plans</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.plans.create') }}"
                                class="nav-link {{ request()->routeIs(['admin.plans.create']) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('admin.add') }} plan</p>
                            </a>
                        </li>

                    </ul>
                </li>
            @endhasanyrole


        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
