@extends('admin.layouts.master')

@section('title', 'bank & payment & delivery')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">bank & payment & delivery</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb @if(app()->getLocale() == 'fa') float-sm-left @else float-sm-right @endif">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('admin.dashboard') }}</a></li>
                <li class="breadcrumb-item active">bank & payment & delivery</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0">Bank</h5>
                </div>
                <form action="{{ route('admin.settings.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="type" value="bank">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Merchand ID Bank</label>
                            <input type="text" value="{{ old('merchand_id',$items['merchand_id'] ?? '') }}" name="settings[merchand_id]" class="form-control @error('merchand_id') is-invalid @enderror">
                        </div>
                        <div class="form-group">
                            <label>Dollar to Rial</label>
                            <input type="text" value="{{ old('currency_exchange_amount',$items['currency_exchange_amount'] ?? '') }}" name="settings[currency_exchange_amount]" class="form-control @error('currency_exchange_amount') is-invalid @enderror">
                        </div>
                        <div class="form-group">
                            <label>Bank Name</label>
                            <input type="text" value="{{ old('bank_name',$items['bank_name'] ?? '') }}" name="settings[bank_name]" class="form-control @error('bank_name') is-invalid @enderror">
                        </div>
                        <div class="form-group">
                            <label>Bank Url</label>
                            <input type="text" value="{{ old('bank_url',$items['bank_url'] ?? '') }}" name="settings[bank_url]" class="form-control @error('bank_url') is-invalid @enderror">
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">{{ __('admin.apply').' '.__('admin.changes') }}</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0">Delivery Options</h5>
                </div>
                <form action="{{ route('admin.settings.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="type" value="delivery_options">
                    <div class="card-body">
                        <div class="form-group">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th class="td-title">Title</th>
                                        <th class="td-title">Default</th>
                                        <th class="td-delete">Status</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <tr>
                                        <td>
                                            <input type="text" class="form-control" name="settings[home][title]" value="{{ old('settings[home][title]',$items['home']['title'] ?? '') }}">
                                        </td>
                                        <td>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="hidden" name="settings[home][default]" value="0">
                                                    <input type="checkbox" name="settings[home][default]" value="1" @if(old('settings[home][default]',$items['home']['default'] ?? '')) checked @endif> Yes
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="hidden" name="settings[home][status]" value="0">
                                                    <input type="checkbox" name="settings[home][status]" value="1" @if(old('settings[home][status]',$items['home']['status'] ?? '')) checked @endif> Enable
                                                </label>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <input type="text" class="form-control" name="settings[store][title]" value="{{ old('settings[store][title]',$items['store']['title'] ?? '') }}">
                                        </td>
                                        <td>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="hidden" name="settings[store][default]" value="0">
                                                    <input type="checkbox" name="settings[store][default]" value="1" @if(old('settings[store][default]',$items['store']['default'] ?? '')) checked @endif> Yes
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="hidden" name="settings[store][status]" value="0">
                                                    <input type="checkbox" name="settings[store][status]" value="1" @if(old('settings[store][status]',$items['store']['status'] ?? '')) checked @endif> Enable
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">{{ __('admin.apply').' '.__('admin.changes') }}</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0">Payment Method</h5>
                </div>
                <form action="{{ route('admin.settings.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="type" value="payment_methods">
                    <div class="card-body">
                        <div class="form-group">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th class="td-title">Title</th>
                                        <th class="td-title">Country</th>
                                        <th>Default</th>
                                        <th class="td-delete">Status</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <tr>
                                        <td>
                                            <input type="text" class="form-control" name="settings[iranian_bank][title]" value="{{ old('settings[iranian_bank][title]',$items['iranian_bank']['title'] ?? '') }}">
                                        </td>
                                        <td>
                                            <select name="settings[iranian_bank][countries][]" multiple class="form-control select2">
                                                @foreach($countries as $key=>$type)
                                                    <option value="{{ $key }}" @if(in_array($key,$items['iranian_bank']['countries'] ?? [])) selected @endif>{{ $type }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="hidden" name="settings[iranian_bank][default]" value="0">
                                                    <input type="checkbox" name="settings[iranian_bank][default]" value="1" @if(old('settings[iranian_bank][default]',$items['iranian_bank']['default'] ?? '')) checked @endif> Yes
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="hidden" name="settings[iranian_bank][status]" value="0">
                                                    <input type="checkbox" name="settings[iranian_bank][status]" value="1" @if(old('settings[iranian_bank][status]',$items['iranian_bank']['status'] ?? '')) checked @endif> Enable
                                                </label>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <input type="text" class="form-control" name="settings[credit_card][title]" value="{{ old('settings[credit_card][title]',$items['credit_card']['title'] ?? '') }}">
                                        </td>
                                        <td>
                                            <select name="settings[credit_card][countries][]" multiple class="form-control select2">
                                                @foreach($countries as $key=>$type)
                                                    <option value="{{ $key }}" @if(in_array($key,$items['credit_card']['countries'] ?? [])) selected @endif>{{ $type }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="hidden" name="settings[credit_card][default]" value="0">
                                                    <input type="checkbox" name="settings[credit_card][default]" value="1" @if(old('settings[credit_card][default]',$items['credit_card']['default'] ?? '')) checked @endif> Yes
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="hidden" name="settings[credit_card][status]" value="0">
                                                    <input type="checkbox" name="settings[credit_card][status]" value="1" @if(old('settings[credit_card][status]',$items['credit_card']['status'] ?? '')) checked @endif> Enable
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">{{ __('admin.apply').' '.__('admin.changes') }}</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0">Delivery Method</h5>
                </div>
                <form action="{{ route('admin.settings.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="type" value="delivery_methods">
                    <div class="card-body">
                        <div class="form-group">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th class="td-title">Title</th>
                                        <th class="td-title">Amount</th>
                                        <th class="td-title">Country</th>
                                        <th>Default</th>
                                        <th class="td-delete">Status</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <tr>
                                        <td>
                                            <input type="text" class="form-control" name="settings[iranian_post][title]" value="{{ old('settings[iranian_post][title]',$items['iranian_post']['title'] ?? '') }}">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="settings[iranian_post][amount]" value="{{ old('settings[iranian_post][amount]',$items['iranian_post']['amount'] ?? '') }}">
                                        </td>
                                        <td>
                                            <select name="settings[iranian_post][countries][]" multiple class="form-control select2">
                                                @foreach($countries as $key=>$type)
                                                    <option value="{{ $key }}" @if(in_array($key,$items['iranian_post']['countries'] ?? [])) selected @endif>{{ $type }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="hidden" name="settings[iranian_post][default]" value="0">
                                                    <input type="checkbox" name="settings[iranian_post][default]" value="1" @if(old('settings[iranian_post][default]',$items['iranian_post']['default'] ?? '')) checked @endif> Yes
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="hidden" name="settings[iranian_post][status]" value="0">
                                                    <input type="checkbox" name="settings[iranian_post][status]" value="1" @if(old('settings[iranian_post][status]',$items['iranian_post']['status'] ?? '')) checked @endif> Enable
                                                </label>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <input type="text" class="form-control" name="settings[business][title]" value="{{ old('settings[business][title]',$items['business']['title'] ?? '') }}">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="settings[business][amount]" value="{{ old('settings[business][amount]',$items['business']['amount'] ?? '') }}">
                                        </td>
                                        <td>
                                            <select name="settings[business][countries][]" multiple class="form-control select2">
                                                @foreach($countries as $key=>$type)
                                                    <option value="{{ $key }}" @if(in_array($key,$items['business']['countries'] ?? [])) selected @endif>{{ $type }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="hidden" name="settings[business][default]" value="0">
                                                    <input type="checkbox" name="settings[business][default]" value="1" @if(old('settings[business][default]',$items['business']['default'] ?? '')) checked @endif> Yes
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="hidden" name="settings[business][status]" value="0">
                                                    <input type="checkbox" name="settings[business][status]" value="1" @if(old('settings[business][status]',$items['business']['status'] ?? '')) checked @endif> Enable
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">{{ __('admin.apply').' '.__('admin.changes') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('admin_css')

@endpush

@push('admin_js')

@endpush
