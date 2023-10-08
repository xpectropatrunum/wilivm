@extends('user.layouts.master')

@section('title', 'Invoice')


@section('content')


    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Invoice #{{ $invoice->id }}</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Invoices</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="container">
                    <div class="col-md-12">
                        <div class="invoice" id="printable">

                            <div class="invoice-company text-inverse f-w-600">

                                <span class="pull-right hidden-print">
                                    <a href="javascript:;" onclick="PrintElem('printable')"
                                        class="btn btn-sm btn-white m-b-10 p-l-5"><i
                                            class="fa fa-print t-plus-1 fa-fw fa-lg"></i> Print invoice</a> </span>



                            </div>
                            <div class="invoice-header" style="overflow-y: auto;">
                                <div class="invoice-from"> <small>from</small>
                                    <address class="m-t-5 m-b-5"> <strong class="text-inverse">Wilivm</strong><br>
                                        info@wilivm.com
                                    </address>
                                </div>
                                <div class="invoice-to"> <small>to</small>
                                    <address class="m-t-5 m-b-5"> <strong
                                            class="text-inverse">{{ auth()->user()->company ?: auth()->user()->first_name . ' ' . auth()->user()->last_name }}</strong><br>
                                        {{ auth()->user()->email }}<br>
                                        {{ auth()->user()->country ? auth()->user()->country . ', ' : '' }}
                                        {{ auth()->user()->state ? auth()->user()->state . ', ' : '' }}
                                        {{ auth()->user()->city }}

                                        <br>
                                        {{ auth()->user()->phone }}
                                    </address>
                                </div>
                                <div class="invoice-date"> <small>Invoice / #{{ $invoice->id }}</small>
                                    <div class="date text-inverse m-t-5">
                                        {{ date('M d, Y', strtotime($invoice->created_at)) }}
                                    </div>
                                    <div class="invoice-detail">
                                        @if ($invoice->transactions()->latest()->first()->status == 1)
                                            <span
                                                class="badge bg-success">{{ App\Enums\EInvoiceStatus::getKey($invoice->transactions()->latest()->first()->status) }}</span>
                                        @elseif($invoice->transactions()->latest()->first()->status == 0)
                                            <span
                                                class="badge bg-warning">{{ App\Enums\EInvoiceStatus::getKey($invoice->transactions()->latest()->first()->status) }}</span>
                                        @else
                                            <span
                                                class="badge bg-dark">{{ App\Enums\EInvoiceStatus::getKey($invoice->transactions()->latest()->first()->status) }}</span>
                                        @endif

                                    </div>

                                </div>
                            </div>
                            <div class="invoice-content">
                                <div class="table-responsive">
                                    <table class="table table-invoice">
                                        <thead>
                                            <tr>
                                                <th>SERVICE</th>
                                                <th class="text-center" width="20%">CYCLE</th>
                                                <th class="text-center" width="20%">DUE DATE</th>
                                                <th class="text-right" width="20%">TOTAL</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($invoice->items as $item)
                                                <tr>
                                                    <td> <span class="text-inverse">{{ $item->title }}</span><br>
                                                        <small>#{{ $item->id }} {{ $item->description }} 
                                                        </small>
                                                    </td>
                                                    <td class="text-center">
                                                        {{ App\Enums\ECycle::getKey((int) $item->cycle) }}</td>
                                                    <td class="text-center">{{ MyHelper::due($item) }}</td>
                                                    <td class="text-right">${{ $item->price }}</td>
                                                </tr>
                                            @endforeach

                                            @if ($invoice->title)
                                                <tr>
                                                    <td> <span class="text-inverse">{{ $invoice->title }}</span><br>
                                                        <small>{{ $invoice->description }} 
                                                        </small>
                                                    </td>
                                                    <td class="text-center">
                                                        {{ App\Enums\ECycle::getKey((int) $invoice->cycle) }}</td>
                                                    <td class="text-center">{{ MyHelper::due($invoice) }}</td>
                                                    <td class="text-right">${{ $invoice->price }}</td>
                                                </tr>
                                            @endif


                                        </tbody>
                                    </table>
                                </div>
                                <div class="invoice-price" style="overflow-y: auto;">
                                    <div class="invoice-price-left">
                                        <div class="invoice-price-row">
                                            <div class="sub-price">
                                                <small>SUBTOTAL</small> <span
                                                    class="text-inverse">${{ $invoice->price }}</span>



                                            </div>

                                            <div class="sub-price">
                                                <small>DISCOUNT</small> <span
                                                    class="text-inverse">${{ $invoice->discount }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="invoice-price-right"> <small>TOTAL</small> <span
                                            class="f-w-600">${{ $invoice->price - $invoice->discount }}</span></div>
                                </div>
                                @if (!$invoice->transactions()->latest()->first()->status)
                                    <div class="col-12 d-flex mt-3">
                                        <div class="col-lg-3 col-12">
                                            <div class="form-group">
                                                <label>Coupon Code</label>

                                                <div class="d-flex">
                                                    <input class="form-control" name="code">
                                                    <button type="button" style="margin-left:5px"
                                                        class="btn btn-sm btn-outline-primary off-button">
                                                        Submit
                                                    </button>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-2">


                                        <h5> Payment Method:</h5>


                                        <div class="row">
                                            @if (env('PERFECTMONEY'))
                                                <div class="form-check  col-12">
                                                    <input class="form-check-input" type="radio" name="method"
                                                        id="method__" checked value="1">
                                                    <label class="form-check-label" for="method__">
                                                        Perfect Money
                                                    </label>
                                                </div>
                                            @endif


                                            <div class="form-check  col-12">
                                                <input class="form-check-input" type="radio" id="method_" name="method"
                                                    value="2">
                                                <label class="form-check-label" for="method_">
                                                    Wallet
                                                </label>
                                            </div>

                                            @if (env('COINPAYMENTS'))
                                                <div class="form-check  col-12">
                                                    <input class="form-check-input" type="radio" id="method_2"
                                                        name="method" value="3">
                                                    <label class="form-check-label" for="method_2">
                                                        CoinPayments (Bitcoin, ETH, USDT, more)
                                                    </label>
                                                </div>
                                            @endif


                                        </div>


                                    </div>


                                    <div class="flex mt-2 " dir="rtl">
                                        <button type="submit" class="btn btn-lg btn-success me-1 mb-1 pay-button">
                                            <span class="spinner-form spinner-border spinner-border-sm" role="status"
                                                aria-hidden="true" style="display: none;"> </span>
                                            Pay
                                            <i class="bi bi-credit-card-2-back-fill"></i>

                                        </button>



                                    </div>
                                @else
                                    <div class="col-12 d-flex mt-3">
                                        <div class="col-12">
                                            Paid with
                                            <strong>{{ ucfirst($invoice->transactions()->latest()->first()->method) }}</strong>
                                            at
                                            {{ date('M d, Y',strtotime($invoice->transactions()->latest()->first()->updated_at)) }}<br>
                                            Tx id:
                                            <strong>{{ $invoice->transactions()->latest()->first()->tx_id }}</strong>
                                        </div>
                                    </div>
                                @endif

                            </div>
                            <div class="invoice-note"> * Payment is
                                due within 30 days<br> * If you have any questions concerning this invoice, contact
                                support
                            </div>
                            <div class="invoice-footer">
                                <p class="text-center m-b-5 f-w-600"> THANK YOU FOR YOUR BUSINESS</p>
                                <p class="text-center"> <span class="m-r-10"><i class="fa fa-fw fa-lg fa-envelope"></i>
                                        info@wilivm.com</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>
    <form class="pm-form" action="https://perfectmoney.com/api/step1.asp" method="POST">

        <input type="hidden" name="PAYEE_ACCOUNT" value="{{ $settings['PERFECTMONEY_ACC'] }}">
        <input type="hidden" name="PAYEE_NAME" value="Wilivm">
        <input type="hidden" name="PAYMENT_AMOUNT" value="{{ $invoice->price - $invoice->discount }}">
        <input type="hidden" name="PAYMENT_UNITS" value="USD">
        <input type="hidden" name="STATUS_URL" value="{{ env('APP_URL') . 'api/order/perfectmoney' }}">
        <input type="hidden" name="PAYMENT_URL" value="{{ env('APP_URL') }}invoices/show/{{ $invoice->id }}/success">
        <input type="hidden" name="NOPAYMENT_URL" value="{{ env('APP_URL') }}invoices/show/{{ $invoice->id }}/fail">
        <input type="hidden" name="NOPAYMENT_URL_METHOD" value="GET">
        <input type="hidden" name="BAGGAGE_FIELDS" value="ORDER_NUM">
        <input type="hidden" name="ORDER_NUM" value="{{ $invoice->id }}">
    </form>
    <form class="cp-form" action="https://www.coinpayments.net/index.php" method="post" target="_top">
        <input type="hidden" name="cmd" value="_pay">
        <input type="hidden" name="reset" value="1">
        <input type="hidden" name="merchant" value="{{ $settings['COINPAYMENTS_MERCHANT'] }}">
        <input type="hidden" name="success_url" value="{{ env('APP_URL') }}invoices/show/{{ $invoice->id }}/success">
        <input type="hidden" name="cancel_url" value="{{ env('APP_URL') }}invoices/show/{{ $invoice->id }}/fail' }}">
        <input type="hidden" name="ipn_url" value="{{ env('APP_URL') . 'api/order/coinpayments' }}">
        <input type="hidden" name="email" value="{{ auth()->user()->email }}">
        <input type="hidden" name="currency" value="USD">
        <input type="hidden" name="invoice" value="{{ $invoice->id }}">
        <input type="hidden" name="want_shipping" value="0">
        <input type="hidden" name="amountf" value="{{ $invoice->price - $invoice->discount }}">
        <input type="hidden" name="item_name" value="#{{ $invoice->id }}">

    </form>
@endsection

@push('admin_css')
    <link rel="stylesheet" href="{{ asset('assets/extensions/simple-datatables/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/simple-datatables.css') }}">
@endpush
@push('admin_js')
    <script>
        @if (($status ?? 0) == 'fail')
            Swal.fire({
                icon: "error",
                'title': "The payment was unsuccessful."
            })
        @endif
        @if (($status ?? 0) == 'success')
            Swal.fire({
                icon: "success",
                'title': "Payment was successful."
            })
        @endif
        var method = 1;
        $('[name=method]').change(function() {
            method = $(this).val();
        });
        $(".off-button").click(() => {
            $.ajax({
                url: "{{ route('panel.e-invoices.off', $invoice->id) }}",
                type: 'post',
                data: {
                    "code": $("[name=code]").val(),
                    "_token": "{{ csrf_token() }}",
                },
                dataType: 'json',
                success: function(res) {
                    if (res.success) {

                        Swal.fire({
                            icon: "success",
                            'title': res.message
                        });
                        setTimeout(() => {
                            window.location.href = window.location.href
                        }, 2000)



                    } else {
                        Swal.fire({
                            icon: "error",
                            'title': res.message
                        })

                    }


                },
                error: function(res) {
                    res = JSON.parse(res.responseText)
                    Swal.fire({
                        icon: "error",
                        'title': res.message
                    })

                }
            });
        })

        $(".pay-button").click(() => {
            $.ajax({
                url: "{{ route('panel.e-invoices.pay', $invoice->id) }}",
                type: 'post',
                data: {
                    "method": method,
                    "_token": "{{ csrf_token() }}",
                },
                dataType: 'json',
                beforeSend: () => {
                    $(".spinner-form").show();
                    $(".pay-button").attr("disabled", "disabled");
                },
                complete: () => {
                    $(".spinner-form").hide();
                    $(".pay-button").removeAttr("disabled");

                },
                success: function(res) {
                    if (res.success) {
                        if (res.next == "pm") {
                            $(".pm-form").submit();
                            return;
                        }
                        if (res.next == "cp") {
                            $(".cp-form").submit();
                            return;
                        }
                        if (res.message) {
                            Swal.fire({
                                icon: "success",
                                'title': res.message
                            });
                            setTimeout(() => {
                                window.location.href = "{{ route('panel.services') }}"
                            }, 2000)


                        }
                    } else {
                        Swal.fire({
                            icon: "error",
                            'title': res.message
                        })

                    }


                },
                error: function(res) {
                    res = JSON.parse(res.responseText)
                    Swal.fire({
                        icon: "error",
                        'title': res.message
                    })

                }
            });
        })

        function PrintElem(elem) {
            var mywindow = window.open('', 'PRINT', 'height=400,width=600');

            mywindow.document.write('<html><head><title>' + document.title + '</title>');
            mywindow.document.write('</head><body >');
            mywindow.document.write('<h1>' + document.title + '</h1>');
            mywindow.document.write(document.getElementById(elem).innerHTML);
            mywindow.document.write('</body></html>');

            mywindow.document.close(); // necessary for IE >= 10
            mywindow.focus(); // necessary for IE >= 10*/

            mywindow.print();
            mywindow.close();

            return true;
        }
    </script>
@endpush
