@extends('user.layouts.master')

@section('title', __('admin.dashboard'))


@section('content')



    <div class="page-heading">
        <h3>Welcome to Wilivm panel</h3>
    </div>
    <div class="page-content">
        <section class="row">
            @if (!auth()->user()->verified)
                <div class="col-12">
                    <div class="alert alert-warning alert-dismissible show fade">
                        {{ __('admin.verify_message') }} <span><a href="{{ route('panel.resend-email') }}">Resend </a></span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif


            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Services</h4>
                        <div>
                            <a class="text-muted" href="{{ route('panel.services') }}"> view all <i
                                    class="bi bi-chevron-right"></i></a>

                        </div>
                    </div>
                    <div class="card-content pb-4">
                        <div class="recent-message d-flex px-4 py-3">


                            @if (auth()->user()->services()->where('status', '!=', '1')->latest()->take(5)->get()->count() == 0)

                                <div class="name ms-4 w-100">
                                    <div class="mb-1 text-muted" style="text-align: center">You have no service</div>

                                </div>
                            @else
                                <table class="w-100 custom">
                                    <tbody>
                                        @foreach ($services = auth()->user()->services()->where('status', '!=', '1')->latest()->take(5)->get() as $item)
                                            <tr>

                                                <td style="
                                                width: 5%;
                                            ">

                                                    <div class="pb-1">
                                                        <img src="{{ asset('assets/images/servers/' . App\Enums\EServiceIcon::findIcon($item->type) . '.svg') }}"
                                                            style="
                                                        padding:5px;
                                                            background: #f3f3f3;
                                                            border-radius: 5px;
                                                            width: 40px;height:40px">
                                                    </div>

                                                </td>

                                                <td>
                                                    {{ $item->type }}
                                                </td>
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
                                                <td style="text-align: right">
                                                    <a style="
                                                            background: #f3f3f3;
                                                            color: black;
                                                            padding: 2px 5px;
                                                            border-radius: 5px;
                                                        "
                                                        href="{{ route('panel.services.show', $item->id) }}">
                                                        <i class="bi bi-arrow-right"></i>

                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>


                            @endif

                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Recent Notifications</h4>
                        <div>
                            <a class="text-muted" href="{{ route('panel.notifications') }}"> view all <i
                                    class="bi bi-chevron-right"></i></a>

                        </div>
                    </div>
                    <div class="card-content pb-4">
                        <div class="recent-message d-flex px-4 py-3">


                            @if (auth()->user()->notifications()->where('new', 1)->take(5)->count() == 0)

                                <div class="name ms-4 w-100">
                                    <div class="mb-1 text-muted" style="text-align: center">You have no new notification
                                    </div>

                                </div>
                            @else
                                <table class="w-100 custom">
                                    <tbody>
                                        @foreach (auth()->user()->notifications()->where('new', 1)->take(5)->get() as $item)
                                            <tr>

                                                <td >
                                                    @if ($item->type == App\Enums\ENotificationType::Ticket)
                                                        <i class="bi bi-chat-right-text"></i>
                                                    @elseif($item->type == App\Enums\ENotificationType::Deploying || $item->type == App\Enums\ENotificationType::Requests)
                                                        <i class="bi bi-server"></i>
                                                    @else
                                                        <i class="bi bi-bell-fill"></i>
                                                    @endif
                                                </td>

                                                <td>
                                                    <div class="mb-1"
                                                        style="overflow: hidden;
                                                        white-space: nowrap;
                                                        text-overflow: ellipsis;
                                                        max-width: 100px;">
                                                        {{ strip_tags($item->message) }}</div>
                                                </td>
                                                <td style="text-align: right">
                                                    {{ $item->n_time }}
                                                </td>
                                                <td style="text-align: right">
                                                    <a style="
                                                            background: #f3f3f3;
                                                            color: black;
                                                            padding: 2px 5px;
                                                            border-radius: 5px;
                                                        "
                                                        @if ($item->type == App\Enums\ENotificationType::Ticket) href="{{ route('panel.tickets') }}"
                                                        @elseif($item->type == App\Enums\ENotificationType::Deploying || App\Enums\ENotificationType::Requests)
                                                        href="{{ route('panel.services') }}"
                                                        @else
                                                        href="javascript:{}" @endif>
                                                        <i class="bi bi-arrow-right"></i>

                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>


                            @endif

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Invoices</h4>
                        <div>
                            <a class="text-muted" href="{{ route('panel.invoices') }}"> view all <i
                                    class="bi bi-chevron-right"></i></a>

                        </div>
                    </div>
                    <div class="card-content pb-4">
                        <div class="recent-message d-flex px-4 py-3">


                            @if (auth()->user()->orders()->latest()->take(5)->get()->count() == 0
                            
                            && auth()->user()->invoices()->latest()->take(5)->get()->count() == 0)

                                <div class="name ms-4 w-100">
                                    <div class="mb-1 text-muted" style="text-align: center">You have no invoice</div>

                                </div>
                            @else
                                <table class="w-100 custom">
                                    <tbody>
                                        @foreach (auth()->user()->orders()->latest()->take(5)->get() as $item)
                                            <tr>


                                                <td>
                                                    <div style="width:40px;height:40px">
                                                        <i class="bi bi-receipt"
                                                            style="
                                                            background: #f3f3f3;
                                                            border-radius: 5px;
                                                            font-size: 27px;
                                                            padding: 2px 7px;
                                                "></i>
                                                    </div>




                                                </td>


                                                <td>
                                                    <div>
                                                        <strong>
                                                            ${{ $item->price }}
                                                        </strong>
                                                        <div class="text-muted" style="font-size:0.9em">
                                                            Invoice #{{ $item->id }} - Due was
                                                            {{ MyHelper::due($item) }}
                                                        </div>
                                                    </div>
                                                </td>
                                                <td style="text-align:right">
                                                    @if ($item->transactions()->latest()->first()?->status == 1)
                                                        <span class="badge bg-success">Paid</span>
                                                    @else
                                                        <span class="badge bg-warning">Unpaid</span>
                                                    @endif
                                                </td>

                                            </tr>
                                        @endforeach
                                        @foreach (auth()->user()->invoices()->latest()->take(5)->get() as $item)
                                        <tr>


                                            <td>
                                                <div style="width:40px;height:40px">
                                                    <i class="bi bi-receipt"
                                                        style="
                                                        background: #f3f3f3;
                                                        border-radius: 5px;
                                                        font-size: 27px;
                                                        padding: 2px 7px;
                                            "></i>
                                                </div>




                                            </td>


                                            <td>
                                                <div>
                                                    <strong>
                                                        ${{ $item->price }}
                                                    </strong>
                                                    <div class="text-muted" style="font-size:0.9em">
                                                        Invoice #{{ $item->id }} - Due was
                                                        {{ MyHelper::due($item, 1) }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="text-align:right">
                                                @if ($item->transactions()->latest()->first()?->status == 1)
                                                    <span class="badge bg-success">Paid</span>
                                                @else
                                                    <span class="badge bg-warning">Unpaid</span>
                                                @endif
                                            </td>

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>


                            @endif

                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Bulletin</h4>
                        <div>
                            <a class="text-muted" href="{{ route('panel.bulletins') }}"> view all <i
                                    class="bi bi-chevron-right"></i></a>
                        </div>
                    </div>

                    <div class="card-content pb-4">
                        @foreach ($bulletins as $item)
                            <div class="recent-message d-flex px-4 py-3">

                                <div class="avatar avatar-lg">
                                    <i class="bi bi-newspaper"></i>
                                </div>
                                <div class="name ms-4 w-100">

                                    <div> {!! $item->message !!}</div>
                                    <div class="text-muted" style="text-align: right"> {{ $item->created_at }}</div>


                                </div>
                            </div>
                        @endforeach
                        @if ($bulletins->count() == 0)
                            <div class="recent-message d-flex px-4 py-3">

                                <div class="name ms-4 w-100">
                                    <div class="mb-1 text-muted" style="text-align: center">No Data</div>

                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>




      



            {{--  <div class="card">
                            <div class="card-body py-4 px-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-xl">
                                        <img src="assets/images/faces/1.jpg" alt="Face 1">
                                    </div>
                                    <div class="ms-3 name">
                                        <h5 class="font-bold">John Duck</h5>
                                        <h6 class="text-muted mb-0">@johnducky</h6>
                                    </div>
                                </div>
                            </div>
                        </div>  --}}



        </section>
    </div>

@endsection

@push('admin_css')
@endpush

@push('admin_js')
    <script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush
