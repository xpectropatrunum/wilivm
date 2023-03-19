@extends('user.layouts.master')

@section('title', 'Affiliate')


@section('content')


    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Affiliate</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Affiliate</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">

            <div class="row">
                <div class="col-md-6 col-12 p-3 ">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4>Account Status</h4>

                        </div>
                        <div class="card-body">
                            <table class="w-100"
                                style="border-collapse: separate;
                            border-spacing: 6px;">
                                <tbody>
                                    <tr>
                                        <th>Your Affiliate Code </th>
                                        <td>{{ auth()->user()->affiliate_code }}</td>
                                    </tr>
                                    <tr>
                                        <th>Registered Users </th>
                                        <td>{{ auth()->user()->childrens()->count() }}</td>
                                    </tr>
                                  
                                </tbody>

                            </table>

                        </div>
                    </div>

                </div>




            </div>

        </section>
    </div>

@endsection

@push('admin_css')
    <style>
        table tbody td:nth-child(2) {
            text-align: right
        }
    </style>
@endpush
@push('admin_js')
@endpush
