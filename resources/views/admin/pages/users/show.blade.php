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
                <div class="card-header"
                    style="
                display: flex;
                align-items: center;
            ">
                    <h3 class="card-title">General</h3>

                </div>
                <div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3 col-12">
                                <strong>FullName: </strong> {{ $user->first_name }} {{ $user->last_name }}
                            </div>
                            <div class="col-lg-3 col-12">
                                <strong>Email: </strong> {{ $user->email }} 
                            </div>
                            <div class="col-lg-3 col-12">
                                <strong>Wallet Balance: </strong> ${{ $user->wallet->balance }} 
                            </div>
                            <div class="col-lg-3 col-12">
                                <strong>Country: </strong> {{ $user->country }} 
                            </div>
                            <div class="col-lg-3 col-12">
                                <strong>State: </strong> {{ $user->state }} 
                            </div>
                            <div class="col-lg-3 col-12">
                                <strong>City: </strong> {{ $user->city }} 
                            </div>
                            <div class="col-lg-6 col-12">
                                <strong>Address: </strong> {{ $user->address }} 
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-lg-3 col-12"> <a target="_blank" class="btn btn-outline-warning btn-sm mt-1"
                                    href="{{ route('admin.users.login', $user->id) }}">
                                    {{ __('Login') }}
                                </a></div>
                            <div class="col-lg-3 col-12"> <a target="_blank" class="btn btn-outline-danger btn-sm  mt-1"
                                    href="{{ route('admin.orders.create_for_user', $user->id) }}">
                                    {{ __('New Order') }}
                                </a></div>




                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-items-center px-3">
                    <h3 class="card-title">Orders</h3>

                </div>


                <div class="card-body p-3">

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
                                    <th>User</th>
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
                                    @php
                                        if ($item->service->status == \App\Enums\EServiceType::Deploying) {
                                            $minutes_past = $item->service->order ? round((time() - strtotime($item->service->order->updated_at)) / 60) : 24 * 60;
                                            if ($minutes_past >= 24 * 60) {
                                                $item->service->status = \App\Enums\EServiceType::Cancelled;
                                                $item->service->save();
                                            }
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td><a href="/admin/users?search={{ $item->user?->email }}"
                                                target="_blank">{{ $item->user?->email }}</a></td>
                                        <td>{{ $item->service->type }}</td>
                                        <td>{{ $item->service->plan }}</td>
                                        <td>{{ $item->service->os_->name }}</td>
                                        <td>{{ $item->service->location_->name }}</td>
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
                                        <td>


                                            @if ($item->service->status == 2)
                                                <span class="badge bg-success">Active</span>
                                            @elseif ($item->service->status == 5)
                                                <span class="badge bg-warning">Proccessing</span>
                                            @elseif ($item->service->status == 3)
                                                <span class="badge bg-danger">Expired</span>
                                            @elseif ($item->service->status == 4)
                                                <span class="badge bg-danger">Canceled</span>
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

            </div>
        </div>
    </div>
@endsection

@push('admin_css')
    <link rel="stylesheet" href="{{ asset('admin-panel/libs/miladi-datepicker/datepicker.min.css') }}">
@endpush

@push('admin_js')
    <script src="{{ asset('admin-panel/libs/miladi-datepicker/datepicker.min.js') }}"></script>
    <script src="{{ asset('admin-panel/libs/miladi-datepicker/datepicker.en.js') }}"></script>
@endpush
