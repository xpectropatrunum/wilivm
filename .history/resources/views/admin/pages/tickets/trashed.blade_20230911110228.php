@extends('admin.layouts.master')

@section('title', 'tickets')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">tickets</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb @if (app()->getLocale() == 'fa') float-sm-left @else float-sm-right @endif">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('admin.dashboard') }}</a>
                </li>
                <li class="breadcrumb-item active">tickets</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <!-- Default box -->
            <div class="card">

                <div class="card-header d-flex align-items-center px-3" style="justify-content: space-between;">
                    <h3 class="card-title">tickets</h3>

                    <a href="{{route("admin.tickets.trashed")}}"><button type="button" class="btn btn-outline-primary"> Trashed ({{$trashed}})</button></a>
                </div>


                   

       
                <div class="card-body p-3">
                    <form class="frm-filter" action="{{ route('admin.tickets.index') }}" type="post" autocomplete="off">
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
                                    <th>User</th>
                                    <th>Title</th>
                                    <th>Department</th>
                                    <th>Status</th>
                                    <th>Created time</th>
                                    <th>Actions</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td><a href="{{ route('admin.users.index', ['search' => $item->user->email]) }}"
                                                target="_blank">{{ $item->user->email }}</a></td>

                                        <td>{{ $item->title }}</td>
                                        <td>{{ App\Enums\ETicketDepartment::getKey($item->department) }}</td>
                                        <td>


                                            @if ($item->status == 0)
                                                <div class="badge badge-warning">Customer reply</div>
                                            @elseif ($item->status == 1)
                                                <div class="badge badge-success">Answered</div>
                                            @elseif ($item->status == 2)
                                                <div class="badge badge-dark">Closed</div>
                                            @elseif ($item->status == 3)
                                                <div class="badge badge-info">In proccess</div>
                                            @endif

                                        </td>
                                        <td>{{ $item->updated_at }}</td>
                                        <td class="project-actions">
                                            <a class="btn btn-info btn-sm"
                                                href="{{ route('admin.tickets.show', $item->id) }}">
                                                <i class="fas fa-eye"></i>
                                                {{ __('Show') }}
                                            </a>
                                            <form action="{{ route('admin.tickets.destroy', $item->id) }}"
                                                class="d-inline-block" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="swalConfirmDelete(this)"
                                                    class="btn btn-danger btn-sm">
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
@endpush
