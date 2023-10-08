@extends('user.layouts.master')

@section('title', 'Invoices')


@section('content')


    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Invoices</h3>
                    <p class="text-subtitle text-muted">Text here ...</p>
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
                <div class="card-header">
                    Manage your invoices.
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Cycle</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                            @php
                                dd($item->transactions);
                            @endphp
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ isset($item->items) ? "--": $item->service->type}}</td>
                                    <td>{{ App\Enums\ECycle::getKey((int)$item->cycle) }}</td>
                                    <td>${{ $item->price - $item->discount }}</td>
                                    <td>
                                        @if ($item->transactions()->latest()->first()->status == 1)
                                            <span
                                                class="badge bg-success">{{ App\Enums\EInvoiceStatus::getKey($item->transactions()->latest()->first()->status) }}</span>
                                        @elseif($item->transactions()->latest()->first()->status == 0)
                                            <span
                                                class="badge bg-warning">{{ App\Enums\EInvoiceStatus::getKey($item->transactions()->latest()->first()->status) }}</span>
                                        @else
                                            <span
                                                class="badge bg-dark">{{ App\Enums\EInvoiceStatus::getKey($item->transactions()->latest()->first()->status) }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>
                                        
                                        <a href="{{ route('panel.'.($item->id < 699999 ? "e-":"").'invoices.show', $item->id) }}"
                                            class="btn btn-success">Show</a>






                                    </td>
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
@endpush

@push('admin_js')
    <script src="{{ asset('assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/js/pages/simple-datatables.js') }}"></script>
@endpush
