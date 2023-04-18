@extends('user.layouts.master')

@section('title', __('admin.dashboard'))


@section('content')


    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Services</h3>
                    <p class="text-subtitle text-muted">Text here ...</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Services</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    Manage your services.
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Type</th>
                                <th>Plan</th>
                                <th>Location</th>
                                <th>Os</th>
                                <th>Status</th>
                                <th>Due Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (auth()->user()->services()->where('status', '!=', '1')->latest()->get() as $key => $item)
                                @php
                                    
                                    if ($item->status == \App\Enums\EServiceType::Deploying) {
                                        $minutes_past = $item->order ? round((time() - strtotime($item->order->updated_at)) / 60) : 24 * 60;
                                        if ($minutes_past >= 24 * 60) {
                                            $item->status = \App\Enums\EServiceType::Cancelled;
                                            $item->save();
                                        }
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item->type }}</td>
                                    <td>{{ $item->plan }}</td>
                                    <td>{{ $item->location_->name }}</td>
                                    <td>{{ $item->os_->name }}</td>
                                    <td>
                                        @if ($item->status == 2)
                                            <span
                                                class="badge bg-success">{{ App\Enums\EServiceType::getKey($item->status) }}</span>
                                        @elseif ($item->status == 5)
                                            <span
                                                class="badge bg-warning">{{ App\Enums\EServiceType::getKey($item->status) }}</span>
                                        @elseif ($item->status == 3)
                                            <span
                                                class="badge bg-danger">{{ App\Enums\EServiceType::getKey($item->status) }}</span>
                                        @elseif ($item->status == 4)
                                            <span
                                                class="badge bg-danger">{{ App\Enums\EServiceType::getKey($item->status) }}</span>
                                        @endif
                                    </td>
                                    <td>{{ MyHelper::due($item->order) }}</td>
                                    <td> <a href="{{ route('panel.services.show', $item->id) }}"
                                            class="btn btn-outline-primary">
                                            {{--  <i class="bi bi-speedometer"></i>  --}}

                                            Manage Service</a>
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
