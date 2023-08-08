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
                                            @if ($user->id == old('user_id', request()->id))) selected @endif>
                                            {{ $user->first_name }} {{ $user->last_name }} - {{ $user->email }}</option>
                                    @endforeach
                                </select>
                            </div>
                       

                         




                        
                          

                            <div class="col-lg-3 col-12">

                                <div class="form-group">
                                    <label>Billing Cycle</label>

                                    <select name="cycle"
                                        class="form-select select2">
                                        @foreach (config("admin.cycle") as $key => $item)
                                            <option value="{{ $key }}">{{ $item }}
                                            </option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>

                           
                    
                      

                     
                      
                     

                            

                          
                            <div class="col-lg-3 col-12">
                                <div class="form-group">
                                    <label>Price</label>
                                    <input name="price" class="form-control" value="{{ old("price") }}">
                                </div>
                            </div>
                            <div class="col-lg-3 col-12">
                                <div class="form-group">
                                    <label>Discount</label>
                                    <input name="discount" class="form-control" value="{{ old("discount", 0) }}">
                                </div>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>Title</label>
                                <input name="title" class="form-control" value="{{ old('title') }}">
                            </div>
                            <div class="col-lg-3 col-12">

                                <div class="form-group">
                                    <label>Order</label>

                                    <select name="cycle"
                                        class="form-select select2">
                                        <option value="0">Optional</option>
                                        @foreach ($orders as $item)
                                            <option value="{{ $item->id }}">#{{ $item->id }} {{ $item->user?->email }}
                                            </option>
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
    </div>
@endsection

@push('admin_css')
    <link rel="stylesheet" href="{{ asset('admin-panel/libs/simplebox/simplebox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-panel/libs/miladi-datepicker/datepicker.min.css') }}">
@endpush

@push('admin_js')
    <script>
       
        
    </script>
@endpush
