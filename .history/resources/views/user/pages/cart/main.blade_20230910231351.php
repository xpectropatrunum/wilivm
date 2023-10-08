@extends('user.layouts.master')

@section('title', __('admin.dashboard'))


@section('content')


    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Shopping Cart</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    Manage Your Cart
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3">
                            Title
                        </div>
                        <div class="col-lg-3">
                            Cycle
                        </div>
                        <div class="col-lg-3">
                            Price
                        </div>
                        <div class="col-lg-3">
                            Actions
                        </div>
                    </div>
                    <div class="row cart-items-list">

                    </div>
                   
                </div>
            </div>

        </section>
    </div>

@endsection

@push('admin_css')
   
@endpush

@push('admin_js')
    <script>
        cart.forEach((i) => {
            $(".cart-items-list").append(`<div>
            <div class="col-lg-3">
                ${i.title}
            </div>
            <div class="col-lg-3">
                ${i.cycle}
            </div>
            <div class="col-lg-3">
                ${i.price}
            </div>
            <div class="col-lg-3">
                <a href="javascript:{}" class="removeFromCart(${i.id})">
                    <div class="btn btn-outline-primary btn-md">
                        <i class="fa fa-trash"></i>
                        Remove
                    </div>

                </a>
            </div>
        </div>`)

        })
    </script>
@endpush
