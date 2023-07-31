@extends('admin.layouts.master')

@section('title', 'Manage user')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">Manage user</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb @if (app()->getLocale() == 'fa') float-sm-left @else float-sm-right @endif">
                <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">List users</a></li>
                <li class="breadcrumb-item active">Manage user</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <!-- Default box -->
            <div class="card">
                <div class="card-header p-0 border-bottom-0">
                    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="custom-tabs-basic-tab" data-toggle="pill"
                                href="#custom-basic-home" role="tab" aria-controls="custom-basic-home"
                                aria-selected="true">Summary</a>
                        </li>


                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-gallery-tab" data-toggle="pill" href="#custom-gallery"
                                role="tab" aria-controls="custom-gallery" aria-selected="false">Orders</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-invoice-tab" data-toggle="pill" href="#custom-invoice"
                                role="tab" aria-controls="custom-invoice" aria-selected="false">Invoices</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-tickets-tab" data-toggle="pill" href="#custom-tickets"
                                role="tab" aria-controls="custom-tickets" aria-selected="false">Tickets</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-emails-tab" data-toggle="pill" href="#custom-emails"
                                role="tab" aria-controls="custom-emails" aria-selected="false">Emails</a>
                        </li>

                    </ul>
                </div>



                <div class="tab-content card-body" id="custom-tabs-four-tabContent">
                    <div class="tab-pane fade show active" id="custom-basic-home" role="tabpanel"
                        aria-labelledby="custom-tabs-basic-tab">

                        <div class="row p-3">


                            <div class="col-12 p-2 col-lg-4  ">

                                <div class="card bg-silk ">
                                    <div class="pt-3 pl-3">
                                        <h6>Basic Info</h6>
                                    </div>
                                    <div class="card-body">



                                        <div class="">
                                            <strong>FullName: </strong> {{ $user->first_name }} {{ $user->last_name }}
                                        </div>
                                        <div class="">
                                            <strong>Email: </strong> {{ $user->email }}
                                        </div>
                                        <div class="">
                                            <strong>Company: </strong> {{ $user->company }}
                                        </div>
                                        <div class="">
                                            <strong>Wallet Balance: </strong> ${{ $user->wallet->balance }}
                                        </div>

                                        <div>
                                            <strong>Phone: </strong> {{ $user->phone }}
                                        </div>
                                        <a target="_blank" class="btn btn-outline-info btn-sm mt-1"
                                            href="{{ route('admin.users.edit', $user->id) }}">
                                            <i class="fas  fa-pen"></i> {{ __('Edit') }}
                                        </a>
                                    </div>
                                </div>

                                <div class="card bg-silk mt-2">
                                    <div class="pt-3 pl-3">
                                        <h6>Address</h6>
                                    </div>
                                    <div class="card-body">




                                        <div class="">
                                            <strong>Country: </strong> {{ $user->country }}
                                        </div>
                                        <div class="">
                                            <strong>State: </strong> {{ $user->state }}
                                        </div>
                                        <div class="">
                                            <strong>City: </strong> {{ $user->city }}
                                        </div>
                                        <div>
                                            <strong>Address: </strong> {{ $user->address }}
                                        </div>
                                        <a target="_blank" class="btn btn-outline-info btn-sm mt-1"
                                            href="{{ route('admin.users.edit', $user->id) }}">
                                            <i class="fas  fa-pen"></i> {{ __('Edit') }}
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 p-2 col-lg-4 ">
                                <div class="card  bg-silk ">
                                    <div class="pt-3 pl-3">
                                        <h6>Login as Client</h6>
                                    </div>
                                    <div class="card-body">
                                        Log into <strong>{{ $user->email }}</strong> <br>
                                        <a target="_blank" class="btn btn-outline-danger btn-sm mt-1"
                                            href="{{ route('admin.users.login', $user->id) }}">
                                            <i class="fas  fa-sign-in-alt"></i> {{ __('Login') }}
                                        </a>
                                    </div>

                                </div>
                                <div class="card  bg-silk mt-2">
                                    <div class="pt-3 pl-3">
                                        <h6>Recent Emails</h6>
                                    </div>
                                    <div class="card-body">

                                        @php
                                            $items = $user
                                                ->emails()
                                                ->latest()
                                                ->take(5)
                                                ->get();
                                        @endphp
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered mb-0 text-nowrap">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Subject</th>

                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach ($items as $item)
                                                        <tr>
                                                            <td>{{ $item->created_at }}</td>


                                                            <td><a data-toggle="modal" href="#myModal"
                                                                    onclick="openModal(`{!! $item->content !!}`)">{{ $item->title }}</a>
                                                            </td>





                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>

                                </div>
                            </div>
                            <div class="col-12 p-2 col-lg-4 ">
                                <div class="card  bg-silk ">
                                    <div class="pt-3 pl-3">
                                        <h6>Tools</h6>
                                    </div>
                                    <div class="card-body">

                                        <a target="_blank" class="mt-1"
                                            href="{{ route('admin.invoices.create', ['id' => $user->id]) }}">
                                            <i class="fas fa-coins"></i> {{ __('Create Invoice') }}
                                        </a>
                                        <br>

                                        <a target="_blank" class="mt-1"
                                            href="{{ route('admin.orders.create_for_user', $user->id) }}">
                                            <i class="fas fa-shopping-cart"></i> {{ __('Create Order') }}
                                            <br>

                                            <a target="_blank" class="mt-1"
                                                href="{{ route('admin.tickets.create', ['id' => $user->id]) }}">
                                                <i class="fas fa-ticket-alt"></i> {{ __('Create Ticket') }}
                                            </a>
                                    </div>

                                </div>
                                <div class="card  bg-silk mt-2">
                                    <div class="pt-3 pl-3">
                                        <h6>Tickets (waiting for action)</h6>
                                    </div>
                                    <div class="card-body">

                                        @php
                                            $items = $user
                                                ->tickets()
                                                ->where('status', 0)
                                                ->latest()
                                                ->take(5)
                                                ->get();
                                        @endphp
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered mb-0 text-nowrap">
                                                <thead>
                                                    <tr>
                                                        <th>Subject</th>
                                                        <th>Status</th>
                                                        <th>Date</th>

                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach ($items as $item)
                                                        <tr>
                                                            <td><a target="_blank"
                                                                    href="{{ route('admin.tickets.show', $item->id) }}">{{ $item->title }}</a>
                                                            </td>
                                                            <td>


                                                                @if ($item->status == 0)
                                                                    <div class="badge badge-warning">Customer reply</div>
                                                                @elseif ($item->status == 1)
                                                                    <div class="badge badge-success">Answered</div>
                                                                @elseif ($item->status == 2)
                                                                    <div class="badge badge-dark">Closed</div>
                                                                @elseif ($item->status == 3)
                                                                    <div class="badge badge-info">In proccess</div>
                                                                @endif

                                                            </td>
                                                            <td>{{ $item->updated_at }}</td>





                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>


                    <div class="tab-pane fade" id="custom-gallery" role="tabpanel"
                        aria-labelledby="custom-tabs-basic-tab">
                        <div class="mb-2"> <a target="_blank" class="btn btn-outline-danger btn-sm  mt-1"
                                href="{{ route('admin.orders.create_for_user', $user->id) }}">
                                {{ __('New Order') }}
                            </a></div>
                        @php
                            $items = $user
                                ->orders()
                                ->latest()
                                ->get();
                        @endphp
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered mb-0 text-nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Service</th>
                                        <th>Type</th>
                                        <th>Plan</th>
                                        <th>Os</th>
                                        <th>Location</th>
                                        <th>Cycle</th>
                                        <th>{{ __('admin.created_date') }}</th>
                                        <th>Expires At</th>
                                        <th>Transaction Status</th>
                                        <th>Service Status</th>
                                        <th>Actions</th>

                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($items as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td><a href="{{ route('admin.orders.edit', $item->id) }}">
                                                    {{ $item->service->plan }}

                                                </a></td>
                                            <td>{{ $item->service->type }}</td>
                                            <td>{{ $item->service->plan }}</td>
                                            <td>{{ $item->service->os_->name }}</td>
                                            <td>{{ $item->service->location_->name }}</td>
                                            <td>{{ $item->cycle }} Months</td>
                                            <td>{{ $item->created_at }}</td>
                                            <td>{{ date('Y-m-d H:i', $item->expires_at) }}</td>
                                            <td>


                                                @if ($item->transactions()->latest()->first()?->status == 1)
                                                    <div class="badge badge-success">Paid</div>
                                                @else
                                                    <div class="badge badge-warning">Unpaid</div>
                                                @endif

                                            </td>
                                            <td>


                                                @if ($item->service->status == 2)
                                                    <span class="badge bg-success">Active</span>
                                                @elseif ($item->service->status == 5)
                                                    <span class="badge bg-warning">Proccessing</span>
                                                @elseif ($item->service->status == 3)
                                                    <span class="badge bg-danger">Expired</span>
                                                @elseif ($item->service->status == 4)
                                                    <span class="badge bg-danger">Canceled</span>
                                                @elseif ($item->service->status == 7)
                                                    <span class="badge bg-danger">Suspended</span>
                                                @elseif ($item->service->status == 6)
                                                    <span class="badge bg-danger">Suspended</span>
                                                @else
                                                    <span class="badge bg-warning">not set</span>
                                                @endif

                                            </td>
                                            <td class="project-actions">
                                                <a href="{{ route('admin.orders.edit', $item->id) }}">

                                                    <button type="button" class="btn btn-primary btn-sm">
                                                        <i class="fas fa-pen"></i>
                                                        Edit
                                                    </button>
                                                </a>

                                                <form action="{{ route('admin.orders.destroy', $item->id) }}"
                                                    class="d-inline-block" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="swalConfirmDelete(this)"
                                                        class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash"></i>
                                                        {{ __('admin.delete') }}
                                                    </button>
                                                </form>


                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="custom-invoice" role="tabpanel"
                        aria-labelledby="custom-tabs-basic-tab">
                        <div class="mb-2"> <a target="_blank" class="btn btn-outline-danger btn-sm  mt-1"
                                href="{{ route('admin.invoices.create', ['id' => $user->id]) }}">
                                {{ __('New Invoice') }}
                            </a></div>
                        @php
                            $items = $user
                                ->invoices()
                                ->latest()
                                ->get();
                        @endphp
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered mb-0 text-nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Cycle</th>
                                        <th>{{ __('admin.created_date') }}</th>
                                        <th>Expires At</th>
                                        <th>Transaction Status</th>
                                        <th>Actions</th>

                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($items as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>

                                            <td>{{ $item->title }}</td>
                                            <td>{{ $item->description }}</td>
                                            <td>{{ $item->cycle }} Months</td>
                                            <td>{{ $item->created_at }}</td>
                                            <td>{{ date('Y-m-d H:i', $item->expires_at) }}</td>
                                            <td>


                                                @if ($item->transactions()->latest()->first()->status == 1)
                                                    <div class="badge badge-success">Paid</div>
                                                @else
                                                    <div class="badge badge-warning">Unpaid</div>
                                                @endif

                                            </td>

                                            <td class="project-actions">
                                                <a href="{{ route('admin.invoices.edit', $item->id) }}">

                                                    <button type="button" class="btn btn-primary btn-sm">
                                                        <i class="fas fa-pen"></i>
                                                        Edit
                                                    </button>
                                                </a>

                                                <form action="{{ route('admin.invoices.destroy', $item->id) }}"
                                                    class="d-inline-block" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="swalConfirmDelete(this)"
                                                        class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash"></i>
                                                        {{ __('admin.delete') }}
                                                    </button>
                                                </form>


                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="custom-emails" role="tabpanel"
                        aria-labelledby="custom-tabs-emails-tab">
                        <div class="mb-2"> <a class="btn btn-outline-danger btn-sm  mt-1" data-toggle="modal"
                                href="#send-modal">Send Email</a></div>
                        @php
                            $items = $user
                                ->emails()
                                ->latest()
                                ->get();
                        @endphp
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered mb-0 text-nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Subject</th>
                                        <th>Actions</th>

                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($items as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->created_at }}</td>


                                            <td><a data-toggle="modal" href="#myModal"
                                                    onclick="openModal(`{!! $item->content !!}`)">{{ $item->title }}</a>
                                            </td>



                                            <td class="project-actions">


                                                <form action="{{ route('admin.sent-emails.destroy', $item->id) }}"
                                                    class="d-inline-block" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="swalConfirmDelete(this)"
                                                        class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash"></i>
                                                        {{ __('admin.delete') }}
                                                    </button>
                                                </form>


                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="custom-tickets" role="tabpanel" aria-labelledby="tickets">
                        <div class="mb-2"> <a target="_blank" class="btn btn-outline-danger btn-sm  mt-1"
                                href="{{ route('admin.tickets.create', ['id' => $user->id]) }}">
                                {{ __('New Ticket') }}
                            </a></div>
                        @php
                            $items = $user
                                ->tickets()
                                ->latest()
                                ->get();
                        @endphp
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered mb-0 text-nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>User</th>
                                        <th>Title</th>
                                        <th>Department</th>
                                        <th>Status</th>
                                        <th>Created time</th>
                                        <th>Actions</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($items as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td><a href="{{ route('admin.users.index', ['search' => $item->user->email]) }}"
                                                    target="_blank">{{ $item->user->email }}</a></td>

                                            <td>{{ $item->title }}</td>
                                            <td>{{ App\Enums\ETicketDepartment::getKey($item->department) }}</td>
                                            <td>


                                                @if ($item->status == 0)
                                                    <div class="badge badge-warning">Customer reply</div>
                                                @elseif ($item->status == 1)
                                                    <div class="badge badge-success">Answered</div>
                                                @elseif ($item->status == 2)
                                                    <div class="badge badge-dark">Closed</div>
                                                @elseif ($item->status == 3)
                                                    <div class="badge badge-info">In proccess</div>
                                                @endif

                                            </td>
                                            <td>{{ $item->updated_at }}</td>
                                            <td class="project-actions">
                                                <a class="btn btn-info btn-sm"
                                                    href="{{ route('admin.tickets.show', $item->id) }}">
                                                    <i class="fas fa-eye"></i>
                                                    {{ __('Show') }}
                                                </a>
                                                <form action="{{ route('admin.tickets.destroy', $item->id) }}"
                                                    class="d-inline-block" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="swalConfirmDelete(this)"
                                                        class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash"></i>
                                                        {{ __('admin.delete') }}
                                                    </button>
                                                </form>
                                            </td>


                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="modal" id="send-modal">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content" action="{{ route('admin.users.send-email', $user->id) }}" method="POST">

                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">Send Email</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">




                        <div class="form-group col-12">
                            <label>Subject</label>
                            <input type="text" name="subject" class="form-control" required>
                        </div>
                        <div class="form-group col-12">
                            <label>Title of box</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="form-group col-12">
                            <label>Content</label>
                            <textarea rows="3" name="content" class="form-control" required></textarea>
                        </div>
                    </div>


                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Send</button>
                </div>

            </form>
        </div>
    </div>
    <div class="modal" id="myModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Email Content</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">

                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('admin_css')
    <link rel="stylesheet" href="{{ asset('admin-panel/libs/miladi-datepicker/datepicker.min.css') }}">
    <style>
        .bg-silk {
            background: #dce7ff;
            color: rgb(34, 34, 34)
        }
    </style>
@endpush

@push('admin_js')
    <script src="{{ asset('admin-panel/libs/miladi-datepicker/datepicker.min.js') }}"></script>
    <script src="{{ asset('admin-panel/libs/miladi-datepicker/datepicker.en.js') }}"></script>
    <script>
        let openModal = (data) => {
            $(".modal-body").html(data)
        }
    </script>
@endpush
