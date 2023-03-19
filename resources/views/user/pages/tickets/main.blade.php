@extends('user.layouts.master')

@section('title', "Tickets")


@section('content')


    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Tickets</h3>
                    <p class="text-subtitle text-muted">Text here ...</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tickets</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    Manage your services.

                    <a class="btn btn-primary btn-sm" style="float:right"
                    href="{{ route('panel.tickets.create') }}">
                    <i class="bi bi-plus-lg"></i>
                    {{ __('New Ticket') }}
                </a>


                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Department</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (auth()->user()->tickets()->latest()->get() as $key => $item)
                            <tr  @if($item->new == 1)  class="new-message" @endif>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->title }}</td>
                                <td>{{ App\Enums\ETicketDepartment::getKey($item->department) }}</td>
                                <td>


                                    @if ($item->status == 0)
                                        <div class="badge bg-warning">Customer reply</div>
                                    @elseif ($item->status == 1)
                                        <div class="badge bg-success">Answered</div>
                                    @elseif ($item->status == 2)
                                        <div class="badge bg-dark">Closed</div>
                                    @elseif ($item->status == 3)
                                        <div class="badge bg-info">In proccess</div>
                                    @endif

                                </td>
                                <td>{{ $item->created_at }}</td>
                                <td class="project-actions">
                                    <a class="btn btn-secondary btn-sm"
                                        href="{{ route('panel.tickets.show', $item->id) }}">
                                        <i class="bi bi-envelope-fill"></i>
                                        {{ __('Messages') }}
                                    </a>

                                    <a class="btn btn-info btn-sm"
                                    href="{{ route('panel.tickets.close', $item->id) }}">
                                    <i class="bi bi-x"></i>
                                    {{ __('Close') }}
                                </a>
                                   
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
