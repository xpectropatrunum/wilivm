@extends('user.layouts.master')

@section('title', 'New Service')


@section('content')

    <style>
        .card-title {
            font-size: 46px
        }
    </style>

    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Pricing</h3>
                    <p class="text-subtitle text-muted">
                        Present your plans to your users.
                    </p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Pricing
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="pricing">
                        <div class="row align-items-center justify-content-center">
                            @foreach ($prices as $key => $item)
                                <div class="col-lg-6 col-xl-3 p-1">
                                    <div class="card">
                                        <div class="card-header text-center">
                                            <h4 class="card-title" style="font-size:38px!important">{{ $item[0]->type->name }}</h4>

                                        </div>
                                        {{--  <h1 class="price" style="margin-bottom:0">${{ min(array_column($item, 'price')) }}</h1>  --}}
                                        {{--  <p class="text-center" style="margin-bottom:3rem">
                                            Monthly
                                        </p>  --}}
                                        <ul>
                                            <li>
                                                <i class="bi bi-check-circle"></i> Instant Delivery​

                                            </li>
                                            <li>
                                                <i class="bi bi-check-circle"></i>Money-Back Guarantee
                                            </li>
                                            <li>
                                                <i class="bi bi-check-circle"></i>24/7 Support​
                                            </li>

                                        </ul>
                                        <div class="card-footer">
                                            <a href="{{ route('panel.new-service.show', $item[0]->server_type_id) }}">
                                                <button class="btn btn-primary btn-block">
                                                    Show Plans
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
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
