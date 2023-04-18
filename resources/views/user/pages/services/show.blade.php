@extends('user.layouts.master')

@section('title', 'Service Information')


@section('content')


    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Service #{{ $service->id }}</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('panel.services') }}">Services</a></li>
                            <li class="breadcrumb-item active" aria-current="page">My Service</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">

            <div class="row">
                <div class="col-md-6 col-12 p-3 ">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4>Server Information</h4>
                            <div>
                                @if ($service->status == 2)
                                    <span
                                        class="badge bg-success">{{ App\Enums\EServiceType::getKey($service->status) }}</span>
                                @elseif ($service->status == 5)
                                    <span
                                        class="badge bg-warning">{{ App\Enums\EServiceType::getKey($service->status) }}</span>
                                @elseif ($service->status == 3)
                                    <span
                                        class="badge bg-danger">{{ App\Enums\EServiceType::getKey($service->status) }}</span>
                                @elseif ($service->status == 4)
                                    <span
                                        class="badge bg-danger">{{ App\Enums\EServiceType::getKey($service->status) }}</span>
                                @endif

                            </div>

                        </div>
                        <div class="card-body">
                            <table class="w-100" style="border-collapse: separate;
                            border-spacing: 6px;">
                                <tbody>
                                    <tr>
                                        <th>Type</th>
                                        <td>{{ $service->type }}</td>
                                    </tr>
                                    <tr>
                                        <th>Plan</th>
                                        <td>{{ $service->plan }}</td>
                                    </tr>
                                    <tr>
                                        <th>Location</th>
                                        <td>{{ $service->location_->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Os</th>
                                        <td>{{ $service->os_->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Ram</th>
                                        <td>{{ $service->ram }}</td>
                                    </tr>
                                    <tr>
                                        <th>Cpu</th>
                                        <td>{{ $service->cpu }}</td>
                                    </tr>
                                    <tr>
                                        <th>Storage</th>
                                        <td>{{ $service->storage }}</td>
                                    </tr>
                                    <tr>
                                        <th>Bandwith</th>
                                        <td>{{ $service->bandwith }}</td>
                                    </tr>

                                    <tr>
                                        <th>IP</th>
                                        <td>{{ $service->ip }}</td>
                                    </tr>
                                    <tr>
                                        <th>Username</th>
                                        <td>{{ $service->username }}</td>
                                    </tr>
                                    <tr>
                                        <th>Password</th>
                                        <td>Emailed</td>
                                    </tr>
                                </tbody>

                            </table>
                          
                        </div>
                    </div>

                </div>
                <div class="col-md-6 col-12 p-3">


                    @if ($service->status == App\Enums\EServiceType::Deploying)

                        <div class="card">
                            <div class="card-header">
                                <h4>Deploying Server</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 text-left">
                                        @foreach (config('admin.deploying_status') as $item)
                                            @php
                                                $minutes_past = $service->order ? round((time() - strtotime($service->order->updated_at)) / 60) : 1000;
                                            @endphp
                                            @if ($minutes_past <= $item->time)
                                                {{ $item->status }} ({{ $item->progress }}%)
                                                <div class="progress progress-primary mb-4 mt-1">
                                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                                                        style="width: {{ $item->progress }}%"
                                                        aria-valuenow="{{ $item->progress }}" aria-valuemin="0"
                                                        aria-valuemax="100">
                                                    </div>
                                                </div>
                                                @break
                                            @endif
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif


                    <div class="card">
                        <div class="card-header">
                            <h4>Tools</h4>
                        </div>

                        @if ($service->status == App\Enums\EServiceType::Active)


                            <div class="card-body">
                                <div class="row">
                                    @foreach (App\Models\Request::all() as $item)
                                        <div class="col-6 text-center">
                                            @if (str_contains(strtolower($item->name), 'install'))
                                                <div class="dropdown">
                                                    <button class="btn btn-outline-primary btn-lg mb-4" type="button"
                                                        id="dropdownMenuButton" data-bs-toggle="dropdown"
                                                        style="min-width: 150px" aria-haspopup="true" aria-expanded="false">
                                                        <i class="bi bi-sliders2"></i> {{ $item->name }}
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        @foreach ($service->os_parent()->get() as $item_)
                                                            <a class="dropdown-item"
                                                                href="{{ route('panel.services.request', ['service' => $service->id, 'request' => $item->id, 'note' => $item_->name]) }}">{{ $item_->name }}</a>
                                                        @endforeach

                                                    </div>
                                                </div>
                                            @else
                                                <a href="{{ route('panel.services.request', ['service' => $service->id, 'request' => $item->id]) }}"
                                                    class="btn btn-outline-primary btn-lg mb-4" style="min-width: 150px">
                                                    @if (str_contains(strtolower($item->name), 'off'))
                                                        <i class="bi bi-power"></i>
                                                    @elseif (str_contains(strtolower($item->name), 'on'))
                                                        <i class="bi bi-play-circle"></i>
                                                    @elseif (str_contains(strtolower($item->name), 'reboot'))
                                                        <i class="bi bi-bootstrap-reboot"></i>
                                                    @endif

                                                    {{ $item->name }}

                                                </a>
                                            @endif



                                        </div>
                                    @endforeach

                                </div>


                            </div>
                        @endif
                    </div>


                    @if ($service->status != App\Enums\EServiceType::Deploying)

                    <div class="card">
                        <div class="card-header">
                            <h4>Renewal</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 text-left">
                                    Your service will expire at {{MyHelper::due($service->order)}}. You could renew it before expiration.
                                    <div class="dropdown mt-2 text-right" > 
                                        <button class="btn btn-outline-primary btn mb-2" style="float:right" type="button"
                                            id="dropdownMenuButton" data-bs-toggle="dropdown" style="min-width: 150px"
                                            aria-haspopup="true" aria-expanded="false">
                                            Renew
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            @foreach (config('admin.cycle') as $key => $item)
                                                <a class="dropdown-item"
                                                    href="{{ route('panel.services.renew', ['service' => $service->id, 'cycle' => $key]) }}">{{ $item }}</a>
                                            @endforeach
    
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                </div>

            </div>
    </div>

    </section>
    </div>

@endsection

@push('admin_css')
    <style>
        table tbody td:nth-child(2) {
            text-align: right
        }
    </style>
@endpush
@push('admin_js')
@endpush
