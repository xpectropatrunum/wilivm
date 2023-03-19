@extends('admin.layouts.master')

@section('title', 'create new ticket')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">Create new ticket</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb @if (app()->getLocale() == 'fa') float-sm-left @else float-sm-right @endif">
                <li class="breadcrumb-item"><a href="{{ route('admin.tickets.index') }}">List tickets</a></li>
                <li class="breadcrumb-item active">Create new ticket</li>
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
                    <h3 class="card-title">Create new ticket</h3>
                </div>
                <form action="{{ route('admin.tickets.store') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="row">


                            <div class="form-group col-lg-3">
                                <label>Title</label>
                                <input name="title" class="form-control" value="{{ old('title') }}">
                            </div>
                            <div class="form-group col-lg-3">
                                <label>User</label>
                                <select name="user_id" class="form-control select2">
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            @if ($user->id == old('user_id')) selected @endif>
                                            {{ $user->first_name }} {{ $user->last_name }} - {{ $user->email }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>Department</label>
                                <select class="form-control" name="department">
                                    @foreach (App\Enums\ETicketDepartment::asSelectArray() as $key => $value)
                                        <option value="{{ $key }}">
                                            {{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>Status</label>
                                <select name="status" class="form-control select2">
                                    @foreach (config('admin.ticket_status') as $key => $status)
                                        <option value="{{ $key }}"
                                            @if ($key == old('status')) selected @endif>
                                            {{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="hidden" name="type" value="1">
                            <div class="col-12 form-group">
                                <label>Templates</label>
                                <ul role="tree" aria-labelledby="tree_label">
                                    @foreach (App\Models\TicketTemplateType::where('enable', 1)->get() as $item)
                                        <li role="treeitem" aria-expanded="false" aria-selected="false">
                                            <span> {{ $item->name }} </span>
                                            <ul role="group">
                                                @foreach (App\Models\TicketTemplate::where('enable', 1)->get() as $item_)
                                                    @if ($item_->ticket_template_type_id == $item->id)
                                                        <li role="treeitem" onclick="pasteToMessage({{$item_}})" aria-selected="false" class="doc">
                                                           {{$item_->name}}
                                                        </li>
                                                    @endif
                                                @endforeach


                                            </ul>
                                        </li>
                                    @endforeach

                                </ul>


                            </div>
                            <div class="form-group col-lg-12">
                                <label>Initial message</label>
                                <textarea name="message" class="form-control editor" rows="10"></textarea>

                            </div>


                        </div>
                    </div>

                    <div class="card-footer text-center">
                        <button type="submit" class="btn btn-primary">{{ __('admin.add') }}</button>
                    </div>
                </form>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection

@push('admin_css')
    <style>
        ul[role="tree"] {
            margin: 0;
            padding: 0;
            list-style: none;
            font-size: 120%;
        }

        ul[role="tree"] li {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        [role="treeitem"][aria-expanded="false"]+[role="group"] {
            display: none;
        }

        [role="treeitem"][aria-expanded="true"]+[role="group"] {
            display: block;
        }

        [role="treeitem"].doc::before {
            font-family: "Font Awesome 5 Free";
            content: "\f15c";
            display: inline-block;
            padding-right: 2px;
            padding-left: 5px;
            vertical-align: middle;
        }

        [role="treeitem"][aria-expanded="false"]>ul {
            display: none;
        }

        [role="treeitem"][aria-expanded="true"]>ul {
            display: block;
        }

        [role="treeitem"][aria-expanded="false"]>span::before {
            font-family: "Font Awesome 5 Free";
            content: "\f07b";
            display: inline-block;
            padding-right: 3px;
            vertical-align: middle;
            font-weight: 900;
        }

        [role="treeitem"][aria-expanded="true"]>span::before {
            font-family: "Font Awesome 5 Free";
            content: "\f07c";
            display: inline-block;
            padding-right: 3px;
            vertical-align: middle;
            font-weight: 900;
        }

        [role="treeitem"],
        [role="treeitem"] span {
            width: 9em;
            margin: 0;
            padding: 0.125em;
            display: block;
        }

        /* disable default keyboard focus styling for treeitems
                 Keyboard focus is styled with the following CSS */
        [role="treeitem"]:focus {
            outline: 0;
        }

        [role="treeitem"][aria-selected="true"] {
            padding-left: 4px;
            border-left: 5px solid #005a9c;
        }

        [role="treeitem"].focus,
        [role="treeitem"] span.focus {
            border-color: black;
            background-color: #eee;
        }

        [role="treeitem"].hover,
        [role="treeitem"] span:hover {
            padding-left: 4px;
            background-color: #ddd;
            border-left: 5px solid #333;
        }
    </style>
@endpush

@push('admin_js')
    <script src="{{ asset('admin-panel/libs/miladi-datepicker/datepicker.min.js') }}"></script>
    <script src="{{ asset('admin-panel/libs/miladi-datepicker/datepicker.en.js') }}"></script>
    <script src="{{ asset('admin-panel/libs/tree/main.js') }}"></script>
    <script>
        function pasteToMessage(data){
            CKEDITOR.instances.message.setData(data.text)

          

        }
    </script>
@endpush
