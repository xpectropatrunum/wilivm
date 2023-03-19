@extends('admin.layouts.master')

@section('title', 'ticket conversation')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">ticket conversation</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb @if (app()->getLocale() == 'fa') float-sm-left @else float-sm-right @endif">
                <li class="breadcrumb-item"><a href="{{ route('admin.servers.index') }}">List servers</a></li>
                <li class="breadcrumb-item active">ticket conversation</li>
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
                    <h3 class="card-title">Ticket #{{ $ticket->id }}</h3>
                </div>
                <form action="{{ route('admin.tickets.update', $ticket->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">

                            <div class="form-group col-lg-3">
                                <label>Title</label>
                                <input name="title" class="form-control" value="{{ old('title', $ticket->title) }}">
                            </div>
                            <div class="form-group col-lg-3">
                                <label>User</label>
                                <select class="form-control select2" disabled>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            @if ($user->id == old('user_id', $ticket->user_id)) selected @endif>
                                            {{ $user->first_name }} {{ $user->last_name }} - {{ $user->email }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>Department</label>
                                <select class="form-control"  name="department">
                                    @foreach (App\Enums\ETicketDepartment::asSelectArray() as $key => $value)
                                        <option value="{{ $key }}"
                                            @if ($key == old('department', $ticket->department)) selected @endif>
                                            {{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>Status</label>
                                <select name="status" class="form-control select2">
                                    @foreach (config('admin.ticket_status') as $key => $status)
                                        <option value="{{ $key }}"
                                            @if ($key == old('status', "1")) selected @endif>
                                            {{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mesgs w-100" dir="ltr">
                                            <div class="msg_history">

                                                @foreach ($ticket->conversations as $item)
                                                    @if ($item->type == 0)
                                                        <div class="incoming_msg">
                                                            <div class="received_msg">
                                                                <div class="received_withd_msg">
                                                                    {!! $item->message !!}
                                                                    <span class="time_date">{{ $item->created_at }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="outgoing_msg">
                                                            <div class="sent_msg">
                                                                {!! $item->message !!}

                                                                <span class="time_date">{{ $item->created_at }}</span>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach





                                            </div>

                                        </div>
                                    </div>
                                </div>
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
                                <label>Message</label>
                                <textarea name="message" class="form-control editor" rows="10"></textarea>
                               
                            </div>
                            

                        </div>
                    </div>

                    <div class="card-footer text-left">
                        <button type="submit" class="btn btn-primary">{{ __('Send and update ticket') }}</button>
                    </div>
                </form>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection

@push('admin_css')
    <link rel="stylesheet" href="{{ asset('admin-panel/libs/miladi-datepicker/datepicker.min.css') }}">
    <style>
        .inbox_people {
            background: #f8f8f8 none repeat scroll 0 0;
            float: left;
            overflow: hidden;
            width: 40%;
            border-right: 1px solid #c4c4c4;
        }

        .inbox_msg {
            border: 1px solid #c4c4c4;
            clear: both;
            overflow: hidden;
        }

        .top_spac {
            margin: 20px 0 0;
        }


        .recent_heading {
            float: left;
            width: 40%;
        }

        .srch_bar {
            display: inline-block;
            text-align: right;
            width: 60%;
        }

        .headind_srch {
            padding: 10px 29px 10px 20px;
            overflow: hidden;
            border-bottom: 1px solid #c4c4c4;
        }

        .recent_heading h4 {
            color: #05728f;
            font-size: 21px;
            margin: auto;
        }

        .srch_bar input {
            border: 1px solid #cdcdcd;
            border-width: 0 0 1px 0;
            width: 80%;
            padding: 2px 0 4px 6px;
            background: none;
        }

        .srch_bar .input-group-addon button {
            background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
            border: medium none;
            padding: 0;
            color: #707070;
            font-size: 18px;
        }

        .srch_bar .input-group-addon {
            margin: 0 0 0 -27px;
        }

        .chat_ib h5 {
            font-size: 15px;
            color: #464646;
            margin: 0 0 8px 0;
        }

        .chat_ib h5 span {
            font-size: 13px;
            float: right;
        }

        .chat_ib p {
            font-size: 14px;
            color: #989898;
            margin: auto
        }

        .chat_img {
            float: left;
            width: 11%;
        }

        .chat_ib {
            float: left;
            padding: 0 0 0 15px;
            width: 88%;
        }

        .chat_people {
            overflow: hidden;
            clear: both;
        }

        .chat_list {
            border-bottom: 1px solid #c4c4c4;
            margin: 0;
            padding: 18px 16px 10px;
        }

        .inbox_chat {
            height: 550px;
            overflow-y: scroll;
        }

        .active_chat {
            background: #ebebeb;
        }

        .incoming_msg_img {
            display: inline-block;
            width: 6%;
        }

        .received_withd_msg {
            display: inline-block;
            padding: 0 0 0 10px;
            vertical-align: top;
            width: 92%;
            margin-bottom:9px; 
            background: antiquewhite;

        }

        .received_withd_msg p {
            background: #ebebeb none repeat scroll 0 0;
            color: #646464;
            font-size: 14px;
            margin: 0;
            padding: 5px 10px 5px 12px;
            width: 100%;
        }

        .time_date {
            color: #747474;
            display: block;
            font-size: 12px;
            margin: 8px 0 0;
        }

        .received_withd_msg {
            width: 57%;
        }

        .mesgs {
            float: left;
            padding: 30px 15px 0 25px;
            width: 60%;
        }

        .sent_msg p {
            background: #05728f none repeat scroll 0 0;
            font-size: 14px;
            margin: 0;
            color: #fff;
            padding: 5px 10px 5px 12px;
            width: 100%;
        }

        .outgoing_msg {
            overflow: hidden;
            margin: 26px 0 26px;
        }

        .sent_msg {
            float: right;
            width: 46%;
        }

        .input_msg_write input {
            background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
            border: medium none;
            color: #4c4c4c;
            font-size: 15px;
            min-height: 48px;
            width: 100%;
        }

        .type_msg {
            border-top: 1px solid #c4c4c4;
            position: relative;
        }

        .msg_send_btn {
            background: #05728f none repeat scroll 0 0;
            border: medium none;
            border-radius: 50%;
            color: #fff;
            cursor: pointer;
            font-size: 17px;
            height: 33px;
            position: absolute;
            right: 0;
            top: 11px;
            width: 33px;
        }

        .messaging {
            padding: 0 0 50px 0;
        }

        .msg_history {
            height: 516px;
            overflow-y: auto;
        }
    
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
   
    <script src="{{ asset('admin-panel/libs/tree/main.js') }}"></script>
    <script>
        function pasteToMessage(data){
            CKEDITOR.instances.message.setData(data.text)

          

        }
    </script>
@endpush