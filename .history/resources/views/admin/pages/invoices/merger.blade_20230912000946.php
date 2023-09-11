@extends('admin.layouts.master')

@section('title', 'Merge invoice')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">Merge invoice</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb @if (app()->getLocale() == 'fa') float-sm-left @else float-sm-right @endif">
                <li class="breadcrumb-item"><a href="{{ route('admin.invoices.index') }}">List invoices</a></li>
                <li class="breadcrumb-item active">Merge invoice</li>
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
                <form action="{{ route('admin.invoices.doMerge') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">






                            <div class="form-group col-lg-4">
                                <label>User</label>
                                <select name="user_id" class="form-control select2">
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            @if ($user->id == old('user_id', request()->id)) ) selected @endif>
                                            {{ $user->first_name }} {{ $user->last_name }} - {{ $user->email }}</option>
                                    @endforeach
                                </select>
                            </div>
                         

                            <div class="form-group col-lg-4"> 

                                <select name="invoice_id" class="form-select select2" multiple>
                                    @foreach ($users[0]->invoices as $invoice)
                                        <option value="{{ $invoice->id }}">#{{ $invoice->id }}</option>
                                    @endforeach
        
                                </select>
                          
                            </div>





                           





                       



                        </div>
                    </div>
                    <div class="card-footer text-left">
                        <button type="submit" class="btn btn-primary">Merge</button>
                    </div>

                </form>



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
        const invoices = {!! json_encode($invoices) !!};
        $(() => {





            $("[name=user_id]").change(function() {
                $user_id = $("[name=user_id]").val()
                $("[name=invoice_id]").html(``)

                invoices.filter(i => i.user_id == $user_id).map(i => {
                    $("[name=invoice_id]").append(`<option value="${i.id}">#${i.id}</option>`)
                })

            })
        })
    </script>
@endpush
