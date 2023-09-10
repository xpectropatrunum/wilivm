@extends('admin.layouts.master')

@section('title', 'New invoice')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">new invoice</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb @if (app()->getLocale() == 'fa') float-sm-left @else float-sm-right @endif">
                <li class="breadcrumb-item"><a href="{{ route('admin.invoices.index') }}">List invoices</a></li>
                <li class="breadcrumb-item active">New invoice</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create invoice</h3>
                </div>
                <form action="{{ route('admin.invoices.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">


                            <div class="form-group col-lg-3">
                                <label>User</label>
                                <select name="user_id" class="form-control select2">
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            @if ($user->id == old('user_id', request()->id)) ) selected @endif>
                                            {{ $user->first_name }} {{ $user->last_name }} - {{ $user->email }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="hidden" name="id" value="{{ $next_id }}">










                            <div class="col-lg-3 col-12">

                                <div class="form-group">
                                    <label>Billing Cycle</label>

                                    <select name="cycle" class="form-select select2">
                                        @foreach (config('admin.cycle') as $key => $item)
                                            <option value="{{ $key }}">{{ $item }}
                                            </option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>












                            <div class="col-lg-3 col-12">
                                <div class="form-group">
                                    <label>Price</label>
                                    <input name="price" class="form-control" value="{{ old('price') }}">
                                </div>
                            </div>
                            <div class="col-lg-3 col-12">
                                <div class="form-group">
                                    <label>Discount</label>
                                    <input name="discount" class="form-control" value="{{ old('discount', 0) }}">
                                </div>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>Title</label>
                                <input name="title" class="form-control" value="{{ old('title') }}">
                            </div>
                            <div class="col-lg-3 col-12">

                                <div class="form-group">
                                    <label>Order</label>

                                    <select name="order_id" class="form-select select2">
                                        <option value="0">Optional</option>
                                        @foreach ($users[0]->orders as $order)
                                            <option value="{{ $order->id }}">#{{ $order->id }}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Description</label>
                                <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                            </div>

                            <div class="form-group col-lg-3">
                                <label>Inform user via email</label>
                                <div class="form-check">
                                    <input type="checkbox" name="inform" class="form-check-input" value="1">
                                    <label class="form-check-label" for="exampleCheck2"> Yes</label>
                                </div>
                            </div>



                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer text-left">
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>

                </form>



                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>


        <div class="col-12">
            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Invoice items</h3>
                </div>

                <div class="col-12 mt-2">

                    <div>
                        <button type="button" class="btn btn-primary btn-icon-text add-variable">
                            Add item
                            <i class="btn-icon-append" data-feather="plus"></i>
                        </button>
                    </div>

                    <div class="table variants-table mt-2">

                        <div>
                            <div class="row w-100">
                                <div class="col-lg-3">Title</div>
                                <div class="col-lg-2">Order</div>
                                <div class="col-lg-2">Cycle</div>
                                <div class="col-lg-2">Price</div>
                                <div class="col-lg-3">Actions</div>

                            </div>
                        </div>

                        <div class="variables-tbody">

                            @foreach ($invoice->items ?? [] as $item)
                                <form class="row w-100">
                                    <div class="col-lg-3">{{ $item->title }}</div>
                                    <div class="col-lg-2">#{{ $item->order_id }}</div>
                                    <div class="col-lg-2">{{ config('admin.cycle')[$item->cycle] }}</div>
                                    <div class="col-lg-2">{{ number_format($item->price) }}</div>
                                    <div class="col-lg-3">
                                        <a data-url="{{ route('admin.invoices.items.remove', $item->id) }}">
                                            <button type="button" class="btn btn-danger">Remove</button>
                                        </a>
                                    </div>
                                </form>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('admin_css')
    <link rel="stylesheet" href="{{ asset('admin-panel/libs/simplebox/simplebox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-panel/libs/miladi-datepicker/datepicker.min.css') }}">
@endpush

@push('admin_js')
    <script>
        const orders = {!! json_encode($orders) !!};
        $(() => {




            $(".add-variable").click(function() {
                $(".variables-tbody").append(`
                <form class="row">
                    <div class="col-lg-3"><input type="text" placeholder="upgrade" name="title" class="form-control"
                        autocomplete="off"></div>
                     <div class="col-lg-2"> 

                        <select name="order_id" class="form-select select2">
                            <option value="0">Optional</option>
                            @foreach ($users[0]->orders as $order)
                                <option value="{{ $order->id }}">#{{ $order->id }}</option>
                            @endforeach

                        </select>
                  
                    </div>
                    <div class="col-lg-2">
                        <select name="cycle" class="form-select select2">
                        @foreach (config('admin.cycle') as $key => $item)
                            <option value="{{ $key }}">{{ $item }}
                            </option>
                        @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2"><input type="text" placeholder="14.99" name="price" class="form-control"
                        autocomplete="off">
                    </div>
                   
                    <div class="col-lg-3">
                        <a data-url="{{ route('admin.invoices.items.add', $next_id) }}">
                            <button type="button" class="btn btn-success">Submit</button>
                        </a>

                        <a data-url="{{ route('admin.invoices.items.remove', $next_id) }}">
                            <button type="button" class="btn btn-danger remove-pre-form">Remove</button>
                        </a>
                    </div>

                </form>
                `)
                $(".select2").select2()



            })

            $('body').on('click', '.variables-tbody a', function(e) {
                url = $(this).attr("data-url")
                if (url) {
                    oldForm = $(this).parent().parent()

                    e.preventDefault();
                    var formData = new FormData($(this).parent().parent()[0]);

                    $.ajax({
                        url: url,
                        type: 'post',

                        data: formData,
                        dataType: 'json',
                        cache: false,
                        contentType: false,
                        processData: false,
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        success: function(res) {
                            if (res) {
                                if (res.id) {
                                    $(oldForm).html("")
                                    $(".variables-tbody").append(` <form class="row w-100">
                                        <div class="col-lg-3">${res.title}</div>
                                        <div class="col-lg-2">#${res.order_id}</div>
                                        <div class="col-lg-2">${res.cycle}</div>
                                        <div class="col-lg-2">${res.price}</div>
                                        <div class="col-lg-3">
                                            <a data-url="/admin/invoices/items/remove/${res.id}">
                                                <button type="button" class="btn btn-danger">Remove</button>
                                            </a>
                                        </div>
                                    </form>`)
                                } else if (res === 1) {
                                    $(oldForm).html("")
                                }
                            } else {

                            }

                        },
                        error: function(res) {
                            //Toast.fire({
                            //  icon: 'error',
                            //title: res.responseJSON.message,
                            //})

                        }


                    });

                }

            })
            $('body').on('click', '.remove-pre-form', function() {
                $(this).parent().parent().parent().html("")
            });
            $("[name=user_id]").change(function() {
                $user_id = $("[name=user_id]").val()
                $("[name=order_id]").html(``)
                $("[name=order_id]").append(`<option value="0">Optional</option>`)

                orders.filter(i => i.user_id == $user_id).map(i => {
                    $("[name=order_id]").append(`<option value="${i.id}">#${i.id}</option>`)
                })

            })
        })
    </script>
@endpush
