@extends('user.layouts.master')

@section('title', 'Make order')


@section('content')


    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Make order</h3>
                    <p class="text-subtitle text-muted">
                        {{ $plan->type->name }} {{ $plan->plan->name }}
                    </p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('panel.new-service') }}">Plans</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Make order
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="row">
                <section id="basic-vertical-layouts">
                    <div class="row match-height">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Vertical Form</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="form form-vertical" action="{{route('panel.new-service.submit', [$plan->server_type_id, $plan->server_plan_id])}}" method="POST">
                                            @csrf
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-lg-4 col-12">
                                                        <div class="form-group">
                                                            <label>Type</label>
                                                            <input class="form-control" value="{{ $plan->type->name }}"
                                                                disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-12">
                                                        <div class="form-group">
                                                            <label>Plan</label>
                                                            <input class="form-control" value="{{ $plan->plan->name }}"
                                                                disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-12">
                                                        <div class="form-group">
                                                            <label>Ram</label>
                                                            <input class="form-control" value="{{ $plan->ram }}"
                                                                disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-12">
                                                        <div class="form-group">
                                                            <label>Cpu</label>
                                                            <input class="form-control" value="{{ $plan->cpu }}"
                                                                disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-12">
                                                        <div class="form-group">
                                                            <label>Storage</label>
                                                            <input class="form-control" value="{{ $plan->storage }}"
                                                                disabled>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4 col-12">
                                                        <div class="form-group">
                                                            <label>Bandwith</label>
                                                            <input class="form-control" value="{{ $plan->bandwith }}"
                                                                disabled>
                                                        </div>
                                                    </div>


                                                    <div class="col-lg-4 col-12">

                                                        <div class="form-group">
                                                            <label>Location</label>

                                                            <select autocomplete="false" name="location"
                                                                class="choices form-select">
                                                                @foreach ($plan->locations()->where('enabled', 1)->get() as $item)
                                                                    <option value="{{ $item->id }}">{{ $item->name }}
                                                                    </option>
                                                                @endforeach

                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-12">

                                                        <div class="form-group">
                                                            <label>Os</label>

                                                            <select autocomplete="chrome-off" name="os"
                                                                class="choices form-select">
                                                                @foreach ($plan->os()->where('enabled', 1)->get() as $item)
                                                                    <option value="{{ $item->id }}">{{ $item->name }}
                                                                    </option>
                                                                @endforeach

                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-12">

                                                        <div class="form-group">
                                                            <label>Billing Cycle</label>

                                                            <select name="cycle"
                                                                class="form-select">
                                                                @foreach (config("admin.cycle") as $key => $item)
                                                                    <option value="{{ $key }}">{{ $item }}
                                                                    </option>
                                                                @endforeach

                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="mt-2 col-12 d-flex justify-content-end align-items-center">
                                                        <strong class="mx-4">Price: <span class="final-price px-2">${{$plan->price}}</span></strong>
                                                        <button type="submit" class="btn btn-success me-1 mb-1 add-to-cart">
                                                            Add to Cart
                                                        </button>
                                                      
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </section>
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
        let prices = {!! json_encode($plan->locations) !!};
        let choices = document.querySelectorAll(".choices")
        let initChoice
        for (let i = 0; i < choices.length; i++) {

            initChoice = new Choices(choices[i], {

                searchEnabled: false
            })


        }
        var base_price = {{$plan->price}};
        var add = 0;
        var final_price = base_price;

        $(".add-to-cart").click(function(){
            $item = {

                id: "{{ $plan->type->id }}/{{ $plan->plan->id }}/" + $("[name=location]").val() + "/" + $("[name=cycle]").val(),
                price: $(".final-price").text().replace("$", ""),
                location: $("[name=location]").val(),
                cycle: $("[name=cycle]").val(),
                cycle_text: $("[name=cycle] option:selected").text().trim(),
                title: "{{ $plan->type->name }} {{ $plan->plan->name }}",
                type: "{{ $plan->type->id }}",
                plan: "{{ $plan->plan->id }}",
            }
            addToCart($item)
            window.location.href = "/cart"
        })
        $("[name=location]").change(function(){
            id =  $(this).val()
            $add = parseInt(prices.find(item => item.id == id).price)
            add = $add
            final_price = (add + base_price)* $("[name=cycle]").val();

            $(".final-price").html(`$${final_price}`)
        })
        $("[name=cycle]").change(function(){
            id =  $(this).val()
            final_price = (add + base_price)* id;

            $(".final-price").html(`$${final_price}`)
        })
    </script>
@endpush
