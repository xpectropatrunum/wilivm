@extends('admin.layouts.master')

@section('title', 'Update payment')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">payment #{{ $transaction->id }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb @if (app()->getLocale() == 'fa') float-sm-left @else float-sm-right @endif">
                <li class="breadcrumb-item"><a href="{{ route('admin.payments.index') }}">List payments</a></li>
                <li class="breadcrumb-item active">Update payment</li>
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
                    <h3 class="card-title">Update payment</h3>
                </div>
                <form action="{{ route('admin.payments.update', $transaction->id) }}" method="POST">
                    @csrf
                    @method('put')
                    <div class="card-body">
                        <div class="row">
                           
                            <div class="form-group col-lg-4">
                                <label>Name</label>
                                <input type="text" value="{{ $transaction->order->user->first_name }} {{ $transaction->order->user->last_name }}"
                                    class="form-control" disabled>
                            </div>
                            <div class="form-group col-lg-4">
                                <label>Email</label>
                                <input type="text" value="{{ $transaction->order->user->email }}" class="form-control" disabled>
                            </div>
                            <div class="form-group col-lg-4">
                                <label>Registered Date</label>
                                <input type="text" value="{{ $transaction->order->user->created_at }}" class="form-control" disabled>
                            </div>

                        

                            <div class="w-100"></div>
                           


                          

                           

                          

                           
                            <div class="col-lg-3 col-12">
                                <div class="form-group">
                                    <label>Price</label>
                                    <input class="form-control" name="price" value="{{ $transaction->order->price }}" required>
                                </div>
                            </div>
                              
                            <div class="col-lg-3 col-12">
                                <div class="form-group">
                                    <label>Discount</label>
                                    <input class="form-control" name="discount" value="{{ $transaction->order->discount }}" required>
                                </div>
                            </div>
                           
                            <div class="col-lg-3 col-12">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control form-select">
                                        @foreach (config('admin.user_transaction_status') as $key => $item)
                                            <option @if ($key == $transaction->status) selected @endif
                                                value="{{ $key }}">{{ $item }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer text-center">
                        <button type="submit" class="btn btn-primary">{{ __('admin.update') }}</button>
                    </div>

                </form>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection

@push('admin_css')
    <link rel="stylesheet" href="{{ asset('admin-panel/libs/simplebox/simplebox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-panel/libs/miladi-datepicker/datepicker.min.css') }}">
@endpush

@push('admin_js')
    
@endpush
