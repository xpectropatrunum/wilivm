@extends('admin.layouts.master')

@section('title', 'users')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">users</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb @if (app()->getLocale() == 'fa') float-sm-left @else float-sm-right @endif">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('admin.dashboard') }}</a>
                </li>
                <li class="breadcrumb-item active">users</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <!-- Default box -->
            <div class="card">
                <div class="card-header d-flex align-items-center px-3">
                    <h3 class="card-title">users</h3>

                </div>

                <div class="px-3 mt-2"> <a href="{{ route('admin.users.excel') }}"><button
                            type="button" class="btn btn-primary">{{ __('Download Excel') }}</button></a>
                </div>
                <div class="card-body p-3">
                    <form class="frm-filter" action="{{ route('admin.users.index') }}" type="post" autocomplete="off">
                        @csrf

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="input-group input-group-sm" style="width: 70px;">
                                <select name="limit" class="custom-select">
                                    <option value="10" @if ($limit == 10) selected @endif>10</option>
                                    <option value="25" @if ($limit == 25) selected @endif>25</option>
                                    <option value="50" @if ($limit == 50) selected @endif>50</option>
                                    <option value="100" @if ($limit == 100) selected @endif>100</option>
                                    <option value="200" @if ($limit == 200) selected @endif>200</option>
                                </select>
                            </div>

                            <div class="input-group input-group-sm" style="width: 200px;">
                                <input type="text" name="search" class="form-control"
                                    placeholder="{{ __('admin.search') }}..." value="{{ $search }}">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mb-0 text-nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Fullname</th>
                                    <th>Email</th>
                                    <th>Verified</th>
                                    <th>Enabled</th>
                                    <th>Created time</th>
                                    <th>Actions</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>
                                            <a href="{{route('admin.users.show', $item->id)}}">{{ $item->first_name }} {{ $item->last_name }}</a>
                                        </td>
                                        <td>{{ $item->email }}</td>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox"
                                                    data-url="{{ route('admin.users.verify', $item->id) }}"
                                                    data-id="{{ $item->id }}" class="form-check-input changeStatus3"
                                                    id="exampleCheck{{ $item->id }}"
                                                    @if ($item->verified) checked @endif>
                                                <label class="form-check-label" for="exampleCheck{{ $item->id }}">
                                                    enable</label>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox"
                                                    data-url="{{ route('admin.users.status', $item->id) }}"
                                                    data-id="{{ $item->id }}" class="form-check-input changeStatus2"
                                                    id="exampleCheck2{{ $item->id }}"
                                                    @if ($item->status) checked @endif>
                                                <label class="form-check-label" for="exampleCheck2{{ $item->id }}">
                                                    enable</label>
                                            </div>
                                        </td>

                                        <td>{{ $item->created_at }}</td>
                                        <td class="project-actions">
                                            <a class="btn btn-info btn-sm"
                                                href="{{ route('admin.users.edit', $item->id) }}">
                                                <i class="fas fa-pen"></i>
                                                {{ __('Edit') }}
                                            </a>

                                            <form action="{{ route('admin.users.destroy', $item->id) }}"
                                                class="d-inline-block" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="swalConfirmDelete(this, title='Are you sure?', text='All the tickets, orders, services and notifications that is related to user will be deleted')"
                                                    class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                    {{ __('admin.delete') }}
                                                </button>
                                            </form>
                                            <a target="_blank" class="btn btn-outline-warning btn-sm"
                                                href="{{ route('admin.users.login', $item->id) }}">
                                                {{ __('Login') }}
                                            </a>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="cart-footer p-3 d-block d-md-flex justify-content-between align-items-center border-top">
                    {{ $items->onEachSide(0)->links('admin.partials.pagination') }}

                    <p class="text-center mb-0">
                        {{ __('admin.display') . ' ' . $items->firstItem() . ' ' . __('admin.to') . ' ' . $items->lastItem() . ' ' . __('admin.from') . ' ' . $items->total() . ' ' . __('admin.rows') }}
                    </p>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection

@push('admin_css')
@endpush

@push('admin_js')
    <script>
        $(function() {

            $('.changeStatus2').on('change', function() {
                id = $(this).attr('data-id');

                if ($(this).is(':checked')) {
                    enable = 1;
                } else {
                    enable = 0;
                }

                $.ajax({
                    url: $(this).attr('data-url'),
                    type: 'post',
                    data: {
                        'status': enable,
                        "_token": "{{ csrf_token() }}",
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        // $("#beforeAfterLoading").addClass("spinner-border");
                    },
                    complete: function() {
                        // $("#beforeAfterLoading").removeClass("spinner-border");
                    },
                    success: function(res) {
                        Toast.fire({
                            icon: 'success',
                            'title': 'Record status successfully changed'
                        })
                    }
                });
            });
            $('.changeStatus3').on('change', function() {
                id = $(this).attr('data-id');

                if ($(this).is(':checked')) {
                    enable = 1;
                } else {
                    enable = 0;
                }

                $.ajax({
                    url: $(this).attr('data-url'),
                    type: 'post',
                    data: {
                        'verified': enable,
                        "_token": "{{ csrf_token() }}",
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        // $("#beforeAfterLoading").addClass("spinner-border");
                    },
                    complete: function() {
                        // $("#beforeAfterLoading").removeClass("spinner-border");
                    },
                    success: function(res) {
                        Toast.fire({
                            icon: 'success',
                            'title': 'Record status successfully changed'
                        })
                    }
                });
            });
        });
    </script>
@endpush
