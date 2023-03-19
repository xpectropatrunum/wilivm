@extends('user.layouts.master')

@section('title', $prices[0]->type->name)


@section('content')


    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Pricing</h3>
                    <p class="text-subtitle text-muted">
                        {{ $prices[0]->type->name }} plans
                    </p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('panel.new-service') }}">Plans</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ $prices[0]->type->name }}
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-12 col-md-10 offset-md-1">
                    <div class="pricing">
                        <div class="row align-items-center justify-content-center">
                            @foreach ($prices as $key => $item)
                                @if ($key == 2)
                                    <div class="col-lg-6 col-xl-3 p-1 position-relative z-1">
                                        <div class="card card-highlighted shadow-lg">
                                            <div class="card-header text-center">
                                                <h4 class="card-title">{{ $item->plan->name }}</h4>
                                                <p></p>
                                            </div>
                                            <h1 class="price text-white" style="margin-bottom:0">${{ $item->price }}</h1>
                                            <p class="text-center text-white" style="margin-bottom:3rem">
                                                Monthly
                                            </p>
                                            <ul>
                                                <li>
                                                    <i class="bi bi-check-circle"></i>RAM {{ $item->ram }}
                                                </li>
                                                <li>
                                                    <i class="bi bi-check-circle"></i>CPU {{ $item->cpu }}
                                                </li>
                                                <li>
                                                    <i class="bi bi-check-circle"></i>Storage {{ $item->storage }}
                                                </li>
                                                <li>
                                                    <i class="bi bi-check-circle"></i>Bandwith {{ $item->bandwith }}
                                                </li>
                                                <li>
                                                    <i
                                                        class="bi bi-check-circle"></i>{{ count($item->os()->where('enabled', 1)->get()) }}
                                                    Operating systems</i>
                                                </li>
                                                <li>
                                                    <i
                                                        class="bi bi-check-circle"></i>{{ count($item->locations()->where('enabled', 1)->get()) }}
                                                    Locations</i>
                                                </li>

                                            </ul>
                                            <div class="card-footer">
                                                <a
                                                    href="{{ route('panel.new-service.make', [$item->server_type_id, $item->server_plan_id]) }}">

                                                    <button class="btn btn-outline-white btn-block">
                                                        Order Now
                                                    </button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-lg-6 col-xl-3 p-1">
                                        <div class="card">
                                            <div class="card-header text-center">
                                                <h4 class="card-title">{{ $item->plan->name }}</h4>

                                            </div>
                                            <h1 class="price" style="margin-bottom:0">${{ $item->price }}</h1>
                                            <p class="text-center" style="margin-bottom:3rem">
                                                Monthly
                                            </p>
                                            <ul>
                                                <li>
                                                    <i class="bi bi-check-circle"></i>RAM {{ $item->ram }}
                                                </li>
                                                <li>
                                                    <i class="bi bi-check-circle"></i>CPU {{ $item->cpu }}
                                                </li>
                                                <li>
                                                    <i class="bi bi-check-circle"></i>Storage {{ $item->storage }}
                                                </li>
                                                <li>
                                                    <i class="bi bi-check-circle"></i>Bandwith {{ $item->bandwith }}
                                                </li>
                                                <li>
                                                    <i
                                                        class="bi bi-check-circle"></i>{{ count($item->os()->where('enabled', 1)->get()) }}
                                                    Operating systems</i>
                                                </li>
                                                <li>
                                                    <i
                                                        class="bi bi-check-circle"></i>{{ count($item->locations()->where('enabled', 1)->get()) }}
                                                    Locations</i>
                                                </li>
                                            </ul>
                                            <div class="card-footer">
                                                <a
                                                    href="{{ route('panel.new-service.make', [$item->server_type_id, $item->server_plan_id]) }}">
                                                    <button class="btn btn-primary btn-block">
                                                        Order Now
                                                    </button></a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach




                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('admin_css')
    <link rel="stylesheet" href="{{ asset('assets/extensions/simple-datatables/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/simple-datatables.css') }}">
@endpush

@push('admin_js')
    <script src="{{ asset('assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/js/pages/simple-datatables.js') }}"></script>
@endpush
