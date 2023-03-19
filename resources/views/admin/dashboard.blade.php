@extends('admin.layouts.master')

@section('title', __('admin.dashboard'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">{{ __('admin.dashboard') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb @if (app()->getLocale() == 'fa') float-sm-left @else float-sm-right @endif">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('admin.home') }}</a></li>
                <li class="breadcrumb-item active">{{ __('admin.dashboard') }}</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')

    @if (auth()->user()->hasRole('admin'))
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-3 col-6">

                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ App\Models\Order::count() }}</h3>
                            <p>Orders</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{ route('admin.orders.index') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">

                    <div class="small-box bg-success">
                        <div class="inner">
                            @php
                                $paid_orders = App\Models\Order::with('transactions')->get()->filter(function ($q) {
                                    return $q->transactions()->latest()->first()->status == 1;
                                });
                            @endphp
                            <h3>${{ ($paid_orders->sum('price') - $paid_orders->sum('discount')) }}
                            </h3>
                            <p>Sales</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">

                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ App\Models\User::count() }}</h3>
                            <p>User Registrations</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person
                            "></i>
                        </div>
                        <a href="{{ route('admin.users.index') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">

                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ App\Models\User::where('verified', 1)->count() }}</h3>
                            <p>Verified Users</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-checkmark-circled
                            "></i>
                        </div>

                        <a href="{{ route('admin.users.index') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

            </div>


            <div class="row">

                <section class="col-lg-7 connectedSortable ui-sortable">

                    <div class="card">
                        <div class="card-header ui-sortable-handle" style="cursor: move;">
                            <h3 class="card-title">
                                <i class="fas fa-chart-pie mr-1"></i>
                                Sales
                            </h3>
                            <div class="card-tools">
                                <ul class="nav nav-pills ml-auto">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#revenue-chart" data-toggle="tab">Area</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#sales-chart" data-toggle="tab">Donut</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="tab-content p-0">

                                <div class="chart tab-pane active" id="revenue-chart"
                                    style="position: relative; height: 300px;">
                                    <div class="chartjs-size-monitor">
                                        <div class="chartjs-size-monitor-expand">
                                            <div class=""></div>
                                        </div>
                                        <div class="chartjs-size-monitor-shrink">
                                            <div class=""></div>
                                        </div>
                                    </div>
                                    <canvas id="revenue-chart-canvas" height="787"
                                        style="height: 300px; display: block; width: 341px;" width="895"
                                        class="chartjs-render-monitor"></canvas>
                                </div>
                                <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;">
                                    <canvas id="sales-chart-canvas" height="0"
                                        style="height: 0px; display: block; width: 0px;" class="chartjs-render-monitor"
                                        width="0"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>




                </section>




            </div>

        </div>
    @endif


@endsection

@push('admin_css')
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
@endpush

@push('admin_js')
    <script src="https://unpkg.com/ionicons@latest/dist/ionicons.js"></script>
@endpush
