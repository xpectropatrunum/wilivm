@extends('admin.layouts.master')

@section('title', 'همکاران گذر')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">{{ __('همکاران') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb @if(app()->getLocale() == 'fa') float-sm-left @else float-sm-right @endif">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('admin.dashboard') }}</a></li>
                <li class="breadcrumb-item active">{{ __('همکاران') }}</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline">
                <div class="card-header d-flex align-items-center px-3">
                    <h5 class="m-0">لیست همکاران گذر</h5>
                    <button class="btn btn-outline-primary btn-sm mx-3 btn-add-partner"><i class="fa fa-plus"></i> {{ __('admin.insert') }}</button>
                </div>
                <form action="{{ route('admin.settings.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="type" value="partners">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>لوگو (150 * 150 transparent)</th>
                                    <th>عنوان</th>
                                    <th>آدرس url</th>
                                    <th>وضعیت</th>
                                    <th></th>
                                </tr>
                                </thead>

                                <tbody class="list-partner">
                                @if(!empty($partners))
                                @foreach($partners as $i=>$partner)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <input type="hidden" name="settings[{{ $partner['name'] }}][image]" value="{{ $partner['value']['image'] }}">
                                            <img class="ml-2 img-fluid img-rounded pic-preview bg-light" src="{{ asset('storage/partners/'.$partner['value']['image']) }}" width="100" height="100">

                                            <input type="file" name="settings[{{ $partner['name'] }}][image]" onchange="readURL(this)" class="form-control-file">
                                        </div>
                                    </td>
                                    <td>
                                        <input type="text" value="{{ old("settings[{$partner['name']}][title]",isset($partner['value']['title']) ? $partner['value']['title'] : '') }}" name="settings[{{$partner['name']}}][title]" class="form-control @error("settings[{$partner['name']}][title]") is-invalid @enderror">
                                    </td>
                                    <td>
                                        <input dir="ltr" type="text" value="{{ old("settings[{$partner['name']}][url]",isset($partner['value']['url']) ? $partner['value']['url'] : '') }}" name="settings[{{$partner['name']}}][url]" class="form-control @error("settings[{$partner['name']}][url]") is-invalid @enderror">
                                    </td>
                                    <td>
                                        <div class="form-check">
                                            <input type="checkbox" name="settings[{{$partner['name']}}][enable]" class="form-check-input" value="1" id="exampleCheck{{ $partner['name'] }}" {{ old("settings[{$partner['name']}][enable]",!empty($partner['value']['enable']) ? $partner['value']['enable'] : '') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="exampleCheck{{ $partner['name'] }}">فعال</label>
                                        </div>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.settings.destroy',$partner['id']) }}" class="d-inline-block" method="POST">
                                            @csrf
                                            <button type="submit" onclick="swalConfirmDelete(this)" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                                حذف
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">ثبت تغیرات</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <template id="partner-item">
        <tr>
            <td>
                <div class="d-flex align-items-center">
                    <input type="hidden" name="settings[counter][image]">
                    <img class="ml-2 img-fluid img-rounded pic-preview bg-light" width="100" height="100">

                    <input type="file" name="settings[counter][image]" onchange="readURL(this)" class="form-control-file">
                </div>
            </td>
            <td>
                <input type="text" name="settings[counter][title]" class="form-control @error("settings[counter][title]") is-invalid @enderror">
            </td>
            <td>
                <input dir="ltr" type="text" name="settings[counter][url]" class="form-control @error("settings[counter][url]") is-invalid @enderror">
            </td>
            <td>
                <div class="form-check">
                    <input type="checkbox" name="settings[counter][enable]" class="form-check-input" value="1" id="exampleCheckcounter" {{ old("settings[counter][enable]",!empty($partners['counter']['enable']) ? $partners['counter']['enable'] : '') ? 'checked' : '' }}>
                    <label class="form-check-label" for="exampleCheckcounter">فعال</label>
                </div>
            </td>
            <td>
                <button class="btn btn-danger btn-sm btn-remove-partner">&times;</button>
            </td>
        </tr>
    </template>
@endsection

@push('admin_css')
    <style>
        .pic-preview
        {
            width: 100px;
            height: 100px;
            object-fit: cover;
        }

        td
        {
            vertical-align: middle !important;
        }
    </style>
@endpush

@push('admin_js')
    <script>
        $(function (){
            var counter='{{ $counter }}';
            $('.btn-add-partner').on('click',function (){
                $item= $('#partner-item').html();
                $item= $item.replace(/counter/g,++ counter);

                $('.list-partner').append($item);
            });

            $('body').on('click','.btn-remove-partner',function () {
                $(this).closest('tr').remove();
            })
        });
    </script>
@endpush
