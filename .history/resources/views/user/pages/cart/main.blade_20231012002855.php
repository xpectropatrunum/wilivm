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
                    <div class="row cart-header" style="font-weight: 900;">
                        <div class="col-lg-3">
                            Title
                        </div>
                        <div class="col-lg-2">
                            Cycle
                        </div>
                        <div class="col-lg-2">
                            Count
                        </div>
                        <div class="col-lg-2">
                            Price
                        </div>

                        <div class="col-lg-3">
                            Actions
                        </div>
                    </div>
                    <div class="cart-items-list">

                    </div>

                </div>
                <div class="m-4 justify-content-end align-items-center action-section" style="display: flex">
                    <strong class="mx-4">Total: $<span class="final-price pr-2"></span></strong>

                    <button class="btn btn-outline-primary me-1 mb-1 add-new-service">
                        Continue Shopping
                    </button>
                    <button class="btn btn-success me-1 mb-1 make-order">
                        Checkout
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
        $(".add-new-service").click(() => {
            window.location.href = "/new-service"
        })

        $(".make-order").click(function() {
            $.ajax({
                type: "POST",
                url: "{{ route('panel.checkout') }}",
                data: JSON.stringify(cart),
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function(data) {
                    if (data.success) {
                        emptyCart()
                        window.location.href = data.url
                    }
                },
                error: function(errMsg) {
                    Swal.fire({
                        icon: "error",
                        'title': "Something went wrong! try again later"
                    })
                }
            });
        })
        var total = 0;
        cart.forEach((i) => {
            total += i.price * i.count
            $(".cart-items-list").append(`<div class="row my-1">
            <div class="col-lg-3">
                ${i.title}
            </div>
            <div class="col-lg-2">
                ${i.cycle_text}
            </div>
            <div class="col-lg-2">
               <span> ${i.count}</span>
             
               <span>
                <a href="javascript:{}" onclick="minusRow(this, ${i.id})">
                    <div class="btn btn-outline-primary btn-sm">
                        <i class="fa fa-minus"></i>
                    </div>
                </a>
               </span>
               <span>
                <a href="javascript:{}" onclick="addRow(this, '${i.id}')">
                    <div class="btn btn-outline-primary btn-sm">
                        <i class="fa fa-plus"></i>
                    </div>
                </a>
               </span>
            </div>
            <div class="col-lg-2">
                $${i.price}
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
        $(".final-price").text(Math.round(total * 100) / 100)

        function removeRow(item, id) {
            removeFromCart(id);
            $(item).parent().parent().html("")

            total = 0;
            cart.forEach((i) => {
                total += i.price * i.count
            })
            $(".final-price").text(Math.round(total * 100) / 100)


            if (cart.length == 0) {
                $(".cart-header").html(`
                <div class="col-12 text-center">
                    Your cart is empty
                </div>`)
                $(".action-section").hide()

            }
        }
        function addRow(item, id) {
            plusToCart(id);

            total = 0;
            cart.forEach((i) => {
                total += i.price * i.count
            })
            $(".final-price").text(Math.round(total * 100) / 100)


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
