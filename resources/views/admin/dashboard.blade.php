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
                                $paid_orders = App\Models\Order::with('transactions')
                                    ->get()
                                    ->filter(function ($q) {
                                        return $q
                                            ->transactions()
                                            ->latest()
                                            ->first()->status == 1;
                                    });
                            @endphp
                            <h3>${{ $paid_orders->sum('price') - $paid_orders->sum('discount') }}
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

                <section class="col-lg-12 connectedSortable ui-sortable">

                    <div class="card bg-gradient-info">
                        <div class="card-header border-0 ui-sortable-handle">
                            <h3 class="card-title">
                                <i class="fas fa-th mr-1"></i>
                                Sales Graph
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn bg-info btn-sm" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chartjs-size-monitor">
                                <div class="chartjs-size-monitor-expand">
                                    <div class=""></div>
                                </div>
                                <div class="chartjs-size-monitor-shrink">
                                    <div class=""></div>
                                </div>
                            </div>
                            <canvas class="chart chartjs-render-monitor" id="line-chart"
                                style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 368px;"
                                width="368" height="250"></canvas>
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
    <script src="{{asset('admin-panel/dist/js/chartjs.min.js')}}"></script>
    <script>
        var salesGraphChartCanvas = $('#line-chart').get(0).getContext('2d')
        var data = {!! json_encode($data) !!}
      
        var salesGraphChartData = {
          labels: Object.entries(data),
          datasets: [
            {
              label: 'Sale',
              fill: false,
              borderWidth: 2,
              lineTension: 0,
              spanGaps: true,
              borderColor: '#efefef',
              pointRadius: 3,
              pointHoverRadius: 7,
              pointColor: '#efefef',
              pointBackgroundColor: '#efefef',
              data: Object.entries(data).map(item =>  item[1])
            }
          ]
        }
      
        var salesGraphChartOptions = {
          maintainAspectRatio: false,
          responsive: true,
          legend: {
            display: false
          },
          scales: {
            xAxes: [{
              ticks: {
                fontColor: '#efefef'
              },
              gridLines: {
                display: false,
                color: '#efefef',
                drawBorder: false
              }
            }],
            yAxes: [{
              ticks: {
                stepSize: 5000,
                fontColor: '#efefef'
              },
              gridLines: {
                display: true,
                color: '#efefef',
                drawBorder: false
              }
            }]
          }
        }
      
        // This will get the first returned node in the jQuery collection.
        // eslint-disable-next-line no-unused-vars
        var salesGraphChart = new Chart(salesGraphChartCanvas, { // lgtm[js/unused-local-variable]
          type: 'line',
          data: salesGraphChartData,
          options: salesGraphChartOptions
        })
     
    </script>
@endpush
