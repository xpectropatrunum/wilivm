@extends('user.layouts.master')

@section('title', 'My Wallet')


@section('content')


    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>My Wallet</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Wallet</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-lg-6 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Deposit</h4>

                            </a>
                        </div>
                        <div class="card-body">


                            <span style="    margin-top: 0;
                            margin-bottom: 0.5rem;
                            font-weight: 700;
                            line-height: 1.2;
                            color: #25396f;">Balance:</span>
                            <span>${{ auth()->user()->wallet->balance }}</span>

                            <form class="deposit-form mt-3" action="{{ route('panel.wallet.deposit') }}" method="POST">
                                @csrf
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="amount">Amount</label>
                                        <input type="text" class="form-control" name="amount" placeholder="xx.xx">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Payment Method</label>
                                    </div>
                                </div>
                                <div class="col-12">


                                    <div class="col-12">
                                        {{-- <img src="{{ asset('assets/images/logo/perfect-money-logo-vector.svg') }}"
                                            width="150" style="background: #f3f3f3;border-radius: 8px;" /> --}}
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="radio" name="method" id="method3"
                                                checked value="1">
                                            <label class="form-check-label" for="method3">
                                                Perfect Money
                                            </label>
                                        </div>



                                    </div>
                                    @if (env('COINPAYMENTS'))
                                        <div class="col-12">


                                            {{-- <img src="{{ asset('assets/images/logo/cp.svg') }}" width="150"
                                                style="background: #f3f3f3;border-radius: 8px;" /> --}}
                                            <div class="form-check  mt-2">
                                                <input class="form-check-input" type="radio" name="method" id="method2"
                                                    value="2">
                                                <label class="form-check-label" for="method2">
                                                    CoinPayments (Bitcoin, ETH, USDT, more)
                                                </label>
                                            </div>



                                        </div>
                                    @endif

                                </div>
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">
                                        <i class="bi bi-credit-card-2-back-fill"></i>
                                        Pay
                                    </button>
                                </div>


                            </form>


                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Withdraw</h4>

                            </a>
                        </div>
                        <div class="card-body">



                            <form class="withdraw-form mt-3" action="{{ route('panel.wallet.withdraw') }}" method="POST">
                                @csrf
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="cash">Amount</label>
                                        <input type="text" class="form-control" name="cash" placeholder="xx.xx">
                                    </div>
                                </div>


                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">
                                        Submit
                                    </button>
                                </div>


                            </form>


                        </div>
                    </div>
                </div>

                <div class=" col-12">

                    <div class="card ">
                        <div class="card-header">
                            <h4>Wallet transactions history</h4>
                            </a>
                        </div>

                        <div class="card-body">
                            <table class="table table-striped" id="table1">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Change</th>
                                        <th>Action</th>
                                        <th style="width: 10%">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (auth()->user()->wallet->transaction()->where('status', 1)->latest()->get() as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->type == App\Enums\EWalletTransactionType::Minus ? '-' : '+' }}${{ $item->amount }}
                                            </td>
                                            <td>
                                                @if ($item->type == App\Enums\EWalletTransactionType::Refund)
                                                    <div class="badge bg-warning">Refund</div>
                                                @elseif ($item->type == App\Enums\EWalletTransactionType::Add)
                                                    <div class="badge bg-success">Deposit</div>
                                                @elseif ($item->type == App\Enums\EWalletTransactionType::Minus)
                                                    <div class="badge bg-danger">Spend</div>
                                                @endif
                                            </td>
                                            <td>{{ $item->created_at }}</td>


                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>
    <form action="https://perfectmoney.com/api/step1.asp" method="POST" class="pm-form">
        <p>
            <input type="hidden" name="PAYEE_ACCOUNT" value="{{$settings["PERFECTMONEY_ACC"]}}">
            <input type="hidden" name="PAYEE_NAME" value="Wilivm">
            <input type="hidden" name="PAYMENT_AMOUNT" value="">
            <input type="hidden" name="PAYMENT_UNITS" value="USD">
            <input type="hidden" name="STATUS_URL" value="{{ env('APP_URL') . 'api/wallet/perfectmoney' }}">
            <input type="hidden" name="PAYMENT_URL" value="{{ env('APP_URL') . 'wallet/success' }}">
            <input type="hidden" name="NOPAYMENT_URL" value="{{ env('APP_URL') . 'wallet/fail' }}">
            <input type="hidden" name="BAGGAGE_FIELDS" value="ORDER_NUM">
            <input type="hidden" name="NOPAYMENT_URL_METHOD" value="GET">

            <input type="hidden" name="ORDER_NUM" value="">
        </p>
    </form>
    <form class="cp-form" action="https://www.coinpayments.net/index.php" method="post" target="_top">
        <input type="hidden" name="cmd" value="_pay">
        <input type="hidden" name="reset" value="1">
        <input type="hidden" name="merchant" value="{{ $settings['COINPAYMENTS_MERCHANT'] }}">
        <input type="hidden" name="success_url" value="{{ env('APP_URL') . 'wallet/success' }}">
        <input type="hidden" name="cancel_url" value="{{ env('APP_URL') . 'wallet/fail' }}">
        <input type="hidden" name="ipn_url" value="{{ env('APP_URL') . 'api/wallet/coinpayments' }}">
        <input type="hidden" name="email" value="{{ auth()->user()->email }}">
        <input type="hidden" name="currency" value="USD">
        <input type="hidden" name="invoice" value="">
        <input type="hidden" name="want_shipping" value="0">

        <input type="hidden" name="amountf" value="">
        <input type="hidden" name="item_name" value="Charge Wallet">

    </form>
@endsection

@push('admin_css')
    <link rel="stylesheet" href="{{ asset('assets/extensions/simple-datatables/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/simple-datatables.css') }}">
    <style>
        tbody tr.new-message td {
            font-weight: 600
        }
    </style>
@endpush

@push('admin_js')
    <script src="{{ asset('assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/js/pages/simple-datatables.js') }}"></script>
    <script>
        var method = 1;
        $('[name=method]').change(function() {
            method = $(this).val();
        });
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
        $("form.deposit-form").on("submit", function(e) {
            e.preventDefault();
            data = $(this).serialize();
            $.ajax({
                url: $(this).attr('action'),
                type: 'post',
                data: data,
                dataType: 'json',
                beforeSend: function() {
                    // $("#beforeAfterLoading").addClass("spinner-border");
                },
                complete: function() {
                    // $("#beforeAfterLoading").removeClass("spinner-border");
                },
                success: function(res) {
                    if (res.errors) {
                        Toast.fire({
                            icon: 'success',
                            'title': 'Record status successfully changed'
                        })
                    } else {
                        if (method == 1) {
                            $("[name=PAYMENT_AMOUNT]").val(res.amount)
                            $("[name=ORDER_NUM]").val(res.id)
                            $("form.pm-form").submit()
                        } else if (method == 2) {
                            $("[name=amountf]").val(res.amount)
                            $("[name=invoice]").val(res.id)
                            $("form.cp-form").submit()
                        }

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
    </script>
@endpush
