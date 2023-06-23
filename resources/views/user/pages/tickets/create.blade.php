@extends('user.layouts.master')

@section('title', 'New Ticket')


@section('content')


    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>New Ticket</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('panel.tickets') }}">Tickets</a></li>
                            <li class="breadcrumb-item active" aria-current="page">New Ticket</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-body pt-4 bg-grey">
                            <div class="chat-content">






                                <form method="POST" action="{{ route('panel.tickets.store') }}"  enctype="multipart/form-data">
                                    @csrf
                                    <div class="align-items-center row">

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label>Title</label>
                                                <input type="text" name="title"
                                                    value="{{ session("wd_data") ? session("wd_data")['wd_title'] : old('title') }}"
                                                    class="form-control" placeholder="Ticket Title">
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label>Department</label>

                                                <select autocomplete="false" name="department" class="form-select">

                                                  

                                                    @if (session("wd_data"))
                                                        <option value="{{ App\Enums\ETicketDepartment::Billing }}">Billing
                                                        </option>
                                                    @else
                                                        @foreach (App\Enums\ETicketDepartment::asSelectArray() as $key => $value)
                                                            <option value="{{ $key }}">{{ $value }}
                                                            </option>
                                                        @endforeach

                                                    @endif


                                                </select>
                                            </div>

                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label>Message</label>
                                                <textarea id="editor" name="message" rows="4" type="text" class="form-control editor" placeholder="Type your message.."></textarea>

                                            </div>
                                        </div>

                                        <div>

                                           <div class="mt-3 mb-3">
                                                <button type="button" class="btn btn-success add-input"
                                                    style="color: white; font-size:18px"><i class="fas fa-plus"
                                                        style="color: green;"></i> <span style="margin-left: 5px">add
                                                        input</span></button>
                                            </div>
            
                                            <div class="custom-file mt-3 mb-3">
                                                <input type="file" class="custom-file-input" name="file[]"
                                                    accept=".jpeg,.jpg,.png,.txt,.pdf">
                                                <label class="custom-file-label" for="customFile">.jpeg,.jpg,.png,.txt,.pdf max
                                                    5MB</label>
                                            </div>
        
                                        </div>

                                        <div class="col-12 mt-2 float-right"
                                            style="
                                        text-align: right;
                                    ">
                                            <button class="btn btn-primary btn">
                                                <i class="bi bi-send-fill"></i>
                                                {{ __('Send') }}
                                            </button>
                                        </div>

                                    </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection

@push('admin_css')
    <link rel="stylesheet" href="{{ asset('assets/extensions/simple-datatables/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/simple-datatables.css') }}">
    <style>
        .chat {
            border-radius: 5px
        }

        .chat.chat-left .chat-message {
            background: #5a8dee !important;
            color: #fff;
            float: left !important
        }

        .chat p {
            margin-bottom: 0
        }


        .chat .chat-message {
            background-color: #fafbfb !important;
            border-radius: .267rem !important;
            box-shadow: 0 2px 6px 0 rgba(0, 0, 0, .3) !important;
            clear: both !important;
            color: #525361;
            float: right !important;
            margin: .2rem 0 1.8rem .2rem !important;
            max-width: calc(100% - 5rem) !important;
            min-width: 200px !important;
            padding: .75rem 1rem 1.2rem 1rem !important;
            position: relative !important;
            text-align: left !important;
            word-break: break-word !important
        }

        .chat .chat-message span {
            color: #7c7c7c;
            position: absolute;
            left: 5px;
            bottom: -1px;
            font-size: 0.8em;
        }

        .chat-left .chat-message span {
            color: white;
            text-align: right;
            position: absolute;
            right: 5px;
            bottom: -1px;
            font-size: 0.8em;
        }
        
        input[type=file]::file-selector-button {
            margin-right: 20px;
            border: none;
            background: #084cdf;
            padding: 10px 20px;
            border-radius: 10px;
            color: #fff;
            cursor: pointer;
            transition: background .2s ease-in-out;
        }

        input[type=file]::file-selector-button:hover {
            background: #0d45a5;
        }
    </style>
@endpush
@push('admin_js')
    <script>
        $(function() {
            $(".add-input").click(() => {
                $temp = `<div class="custom-file mt-3 mb-3">
                <input type="file" name="file[]"  accept=".jpeg,.jpg,.png,.txt,.pdf">
            </div>`;
                if ($(".custom-file").length < 5) {
                    $(".custom-file").parent().append($temp)
                } else {
                    $(".add-input").attr("disabled", "disabled")
                }


            });
        })
    </script>
@endpush


