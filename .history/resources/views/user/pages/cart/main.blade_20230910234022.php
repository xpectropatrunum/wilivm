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
                    <div class="row cart-header">
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
                    <div class="cart-items-list">

                    </div>

                </div>
                <div class="mt-2 col-12 d-flex justify-content-end align-items-center action-section">
                    <strong class="mx-4">Total: <span class="final-price px-2">$</span></strong>
                    <button class="btn btn-success me-1 mb-1 make-order">
                        Submit
                    </button>
                    <button class="btn btn-outline-primary me-1 mb-1 add-new-service">
                        Submit
                    </button>

                </div>
            </div>

        </section>
    </div>

@endsection

@push('admin_css')
@endpush

@push('admin_js')
    <script>
        if (cart.length == 0) {
            $(".cart-header").html(`
            <div class="col-12 text-center">
                Your cart is empty
            </div>`)
            $(".action-section").hide()
        }
        cart.forEach((i) => {
            $(".cart-items-list").append(`<div class="row my-1">
            <div class="col-lg-3">
                ${i.title}
            </div>
            <div class="col-lg-3">
                ${i.cycle_text}
            </div>
            <div class="col-lg-3">
                ${i.price}
            </div>
            <div class="col-lg-3">
                <a href="javascript:{}" onclick="removeRow(this, ${i.id})">
                    <div class="btn btn-outline-primary btn-sm">
                        <i class="fa fa-trash"></i>
                        Remove
                    </div>

                </a>
            </div>
        </div>`)

        })

        function removeRow(item, id) {
            removeFromCart(id);
            $(item).parent().parent().html("")
            if (cart.length == 0) {
                $(".cart-header").html(`
                <div class="col-12 text-center">
                    Your cart is empty
                </div>`)
                $(".action-section").hide()

            }
        }
    </script>
@endpush
