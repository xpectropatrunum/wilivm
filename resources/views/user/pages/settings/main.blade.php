@extends('user.layouts.master')

@section('title', 'Settings')


@section('content')



    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Settings</h3>
                    <p class="text-subtitle text-muted">Text here ...</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Settings</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h4 class="card-title">Personal information</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form" method="POST" action="{{ route('panel.settings.store') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-3 col-12">
                                            <div class="form-group">
                                                <label for="first-name-column">First Name *</label>
                                                <input type="text" name="first_name" required
                                                    value="{{ auth()->user()->first_name }}" id="first-name-column"
                                                    class="form-control" placeholder="First Name">
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-12">
                                            <div class="form-group">
                                                <label for="last-name-column">Last Name *</label>
                                                <input type="text" name="last_name" required
                                                    value="{{ auth()->user()->last_name }}" id="last-name-column"
                                                    class="form-control" placeholder="Last Name">
                                            </div>
                                        </div>

                                        <div class="col-md-3 col-12">
                                            <div class="form-group">
                                                <label for="email-id-column">Email *</label>
                                                <input type="email" id="email-id-column"
                                                    @if (auth()->user()->verified) disabled @endif required
                                                    name="email" value="{{ auth()->user()->email }}" class="form-control"
                                                    placeholder="Email">
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-12">
                                            <div class="form-group">
                                                <label for="phone-column">Phone</label>
                                                <input type="number" id="phone-column" name="phone"
                                                    value="{{ auth()->user()->phone }}" class="form-control"
                                                    placeholder="Phone with country code">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="company-column">Company</label>
                                                <input type="text" id="company-column" name="company"
                                                    value="{{ auth()->user()->company }}" class="form-control"
                                                    placeholder="Company">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label>Country</label>

                                                <select autocomplete="false" name="country" class="choices form-select">
                                                    @foreach ($countries as $item)
                                                        <option @if (auth()->user()->country == $item->name) selected @endif
                                                            value="{{ $item->name }}">{{ $item->name }}
                                                        </option>
                                                    @endforeach

                                                </select>
                                            </div>


                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label>State</label>

                                                <select autocomplete="false" name="state" class="choices form-select">


                                                </select>
                                            </div>


                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="country-floating">City</label>
                                                <input type="text" id="city-floating" name="city"
                                                    value="{{ auth()->user()->city }}" class="form-control"
                                                    placeholder="City">
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-12">
                                            <div class="form-group">
                                                <label for="country-floating">Address</label>
                                                <input type="text" id="address-floating" name="address"
                                                    value="{{ auth()->user()->address }}" class="form-control"
                                                    placeholder="Full address">
                                            </div>
                                        </div>

                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-1 mb-1">
                                                Apply Changes
                                            </button>

                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h4 class="card-title">2-Factor Authentication</h4>
                            <p class="text-subtitle text-muted">Improve your account security using google authenticator.</p>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form" method="POST" action="{{ route('panel.settings.2fa') }}">
                                    @csrf
                                  
                                    <div class="row">
                                        @if (auth()->user()->google2fa_secret)
                                        {!! $QR_Image ?? session('QR_Image') !!}
                                            <div class="col-12 d-flex justify-content-end">
                                                <button type="submit" class="btn btn-danger me-1 mb-1">
                                                    Disable
                                                </button>

                                            </div>
                                        @else
                                            <div class="col-12 d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary me-1 mb-1">
                                                    Enable
                                                </button>

                                            </div>
                                        @endif



                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h4 class="card-title">Security</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form" method="POST" action="{{ route('panel.settings.security') }}">
                                    @csrf
                                    <div class="row">
                                        @if (auth()->user()->password)
                                            <div class="col-md-4 col-12">
                                                <div class="form-group">
                                                    <label for="old_password">Old password</label>
                                                    <input type="password" name="old_password" required
                                                        class="form-control" placeholder="">
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-12">
                                                <div class="form-group">
                                                    <label for="new_password">New password</label>
                                                    <input type="password" name="new_password" required
                                                        class="form-control" placeholder="">
                                                </div>
                                            </div>


                                            <div class="col-md-4 col-12">
                                                <div class="form-group">
                                                    <label for="confirm_password">Password Confirmation</label>
                                                    <input type="password" name="confirm_password" required
                                                        class="form-control" placeholder="">
                                                </div>
                                            </div>
                                        @else
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="new_password">New password</label>
                                                    <input type="password" name="new_password" required
                                                        class="form-control" placeholder="">
                                                </div>
                                            </div>


                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="confirm_password">Password Confirmation</label>
                                                    <input type="password" name="confirm_password" required
                                                        class="form-control" placeholder="">
                                                </div>
                                            </div>
                                        @endif



                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-1 mb-1">
                                                Apply Changes
                                            </button>

                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection


@push('admin_css')
    <link rel="stylesheet" href="{{ asset('assets/css/main/choices.css') }}">
@endpush
@push('admin_js')
    <script src="{{ asset('assets/extensions/choices/main.js') }}"></script>
    <script>
        let countries = {!! json_encode($countries) !!}
        let selected_states = countries.find(item => item.name == "{{ auth()->user()->country ?? 'Afghanistan' }}").states
            .map(item => {
                return {
                    value: item.name,
                    label: item.name
                }
            });

        let country = new Choices("[name=country]");
        let state = new Choices("[name=state]", {
            choices: selected_states,
            editItems: true
        });


        $("[name=country]").change(function() {
            selected_states = []
            let states = countries.find(item => item.name == $(this).val()).states.map((item, index) => {
                selected_states.push({
                    value: item.name,
                    label: item.name,
                    selected: "{{ auth()->user()->state }}" == item.name ? true : (index == 0 ?
                        true : false),
                })
            })
            state.clearStore()
            state.setChoices(selected_states);
        })
    </script>
@endpush
