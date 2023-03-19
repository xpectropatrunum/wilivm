@extends('user.layouts.master')

@section('title', "Notifications")


@section('content')


    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Notifications</h3>
                    <p class="text-subtitle text-muted">Text here ...</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Notifications</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    All of your notifications.
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
            
                                <th>Message</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (auth()->user()->notifications()->latest()->get() as $key => $item)
                            <tr   @if($item->new == 1)  class="new-message" @endif>
                                <td>{!! $item->message !!}</td>
                                <td>{{ $item->n_time }}</td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </section>
    </div>

@endsection

@push('admin_css')
    <link rel="stylesheet" href="{{ asset('assets/extensions/simple-datatables/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/simple-datatables.css') }}">
    <style>
        tbody tr.new-message td{
            font-weight: 600
    
        }
    </style>
@endpush

@push('admin_js')
    <script src="{{ asset('assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/js/pages/simple-datatables.js') }}"></script>
@endpush
