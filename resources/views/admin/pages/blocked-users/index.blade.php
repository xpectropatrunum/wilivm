@extends('admin.layouts.master')

@section('title', 'Blocked Users')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">Blocked Users</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb @if(app()->getLocale() == 'fa') float-sm-left @else float-sm-right @endif">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('admin.dashboard') }}</a></li>
                <li class="breadcrumb-item active">Blocked Users</li>
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
                    <h3 class="card-title">Blocked Users</h3>
                    <a class="btn btn-outline-primary btn-sm mx-3" href="{{ route('admin.blocked_users.create') }}"><i class="fa fa-plus"></i> {{ __('admin.add_new') }}</a>
                </div>
                <div class="card-body p-3">
                    <form class="frm-filter" action="{{ route('admin.blocked_users.index') }}" type="post" autocomplete="off">
                        @csrf

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="input-group input-group-sm" style="width: 195px;">
                               

                                <select name="limit" class="custom-select">
                                    <option value="10" @if($limit == 10) selected @endif>10</option>
                                    <option value="25" @if($limit == 25) selected @endif>25</option>
                                    <option value="50" @if($limit == 50) selected @endif>50</option>
                                    <option value="100" @if($limit == 100) selected @endif>100</option>
                                    <option value="200" @if($limit == 200) selected @endif>200</option>
                                </select>
                            </div>

                            <div class="input-group input-group-sm" style="width: 200px;">
                                <input type="text" name="search" class="form-control" placeholder="{{ __('admin.search') }}..." value="{{ $search }}">

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
                                <th>{{ __('admin.full_name') }}</th>
                                <th>{{ 'Powernation ID' }}</th>
                                <th>{{ 'From' }}</th>
                                <th>{{ 'To' }}</th>
                                <th>{{ __('admin.created_date') }}</th>
                                <th>{{ __('admin.status') }}</th>
                                <th>{{ __('admin.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->user->first_name }} {{ $item->user->last_name }}</td>
                                    <td>{{ $item->user->powernation_id ?? '' }}</td>
                                    <td>{{ (new Shamsi)->jdate($item->from_datetime) }}</td>
                                    <td>{{ (new Shamsi)->jdate($item->to_datetime) }}</td>
                                    <td>{{ (new Shamsi)->jdate($item->created_at) }}</td>
                                    <td>
                                        <div class="form-check">
                                            <input type="checkbox" data-url="{{ route('admin.blocked_users.status',$item->id) }}" data-id="{{ $item->id }}" class="form-check-input changeStatus" id="exampleCheck{{ $item->id }}" @if($item->enable) checked @endif>
                                            <label class="form-check-label" for="exampleCheck{{ $item->id }}"> enable</label>
                                        </div>
                                    </td>
                                    <td class="project-actions">
                                        <a class="btn btn-info btn-sm" href="{{ route('admin.blocked_users.edit',$item->id) }}">
                                            <i class="fas fa-pencil-alt"></i>
                                            {{ __('admin.edit') }}
                                        </a>

                                        <form action="{{ route('admin.blocked_users.destroy',$item->id) }}" class="d-inline-block" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="swalConfirmDelete(this)" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                                {{ __('admin.delete') }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="cart-footer p-3 d-block d-md-flex justify-content-between align-items-center border-top">
                    {{ $items->onEachSide(0)->links('admin.partials.pagination') }}

                    <p class="text-center mb-0">{{ __('admin.display').' '.$items->firstItem().' '.__('admin.to').' '.$items->lastItem().' '.__('admin.from').' '.$items->total().' '.__('admin.rows') }}</p>
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
        $(function (){
            $('.changeStatus').on('change',function (){
                if ($(this).is(':checked'))
                {
                    enable= 1;
                }
                else
                {
                    enable= 0;
                }

                $.ajax({
                    url: $(this).attr('data-url'),
                    type: 'post',
                    data: {
                        'enable': enable,
                        "_token": "{{ csrf_token() }}",
                    },
                    dataType: 'json',
                    beforeSend: function () {
                        // $("#beforeAfterLoading").addClass("spinner-border");
                    },
                    complete: function () {
                        // $("#beforeAfterLoading").removeClass("spinner-border");
                    },
                    success: function (res) {
                        Toast.fire({
                            icon: 'success',
                            'title':'Record status successfully changed'
                        })
                    }
                });
            });
        });
    </script>
@endpush
