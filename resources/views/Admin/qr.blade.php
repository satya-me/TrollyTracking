@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection


@section('content')
    <div class="app-content pt-3 p-md-3 p-lg-4">
        <div class="container-xl">

            <h1 class="app-page-title">QR CODE GENARATE</h1>

            <div class="row g-4 mb-4">
                <div class="col-12 col-lg-8">
                    <div class="app-card app-card-basic d-flex flex-column align-items-start shadow-sm">
                        <div class="app-card-header p-3 border-bottom-0">
                            <div class="row align-items-center gx-3">
                                <div class="col-auto">
                                    <div class="app-icon-holder">
                                        <iconify-icon icon="bi:receipt" width="30" height="30"
                                            style="color: #15a362"></iconify-icon>
                                    </div><!--//icon-holder-->

                                </div><!--//col-->
                                <div class="col-auto">
                                    <h4 class="app-card-title">Fill this form</h4>
                                </div><!--//col-->
                            </div><!--//row-->
                        </div><!--//app-card-header-->
                        <form class="auth-form login-form is-readonly" action="{{ route('admin.qr.temp') }}" method="POST">
                            @csrf
                            <div class="app-card-body px-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="email mb-3">
                                            <label class="lable_style" for="grade_name">Grade Name</label>
                                            <select class="form-select" name="grade_name" id="grade_name" aria-label="Default select example">
                                                <option value="">Grade Name</option>
                                                @foreach($gradenames as $gradename)
                                                    <option value="{{ $gradename->grade_name }}" {{ request()->input('grade_name') == $gradename->grade_name ? 'selected' : '' }}>{{ $gradename->grade_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="email mb-3">
                                            <label class="lable_style" for="Origin">Origin</label>
                                            <select class="form-select" name="origin" id="Origin" aria-label="Default select example">
                                                <option value="">Select Origin</option>
                                                @foreach($origins as $origin)
                                                    <option value="{{ $origin->origin }}" {{ request()->input('origin') == $origin->origin ? 'selected' : '' }}>{{ $origin->origin }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="email mb-3">
                                            <label class="lable_style" for="BatchNo">Batch No</label>
                                            <input id="BatchNo" name="batch_no" type="text" class="form-control" placeholder="Enter Batch No" required="required" value="{{ $qr->batch_no ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="email mb-3">
                                            <label class="lable_style" for="net_weight">Net Weight</label>
                                            <input id="net_weight" name="net_weight" type="text" class="form-control" placeholder="Enter Net weight Name" required="required" value="{{ $qr->net_weight ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="email mb-3">
                                            <label class="lable_style" for="Gross">Gross Weight</label>
                                            <input id="Gross" name="gross_weight" type="text" class="form-control" placeholder="Enter Gross Weight" required="required" value="{{ $qr->gross_weight ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="email mb-3">
                                            <label class="lable_style" for="lot">Lot No</label>
                                            <input id="lot" name="lot_no" type="text" class="form-control" placeholder="Enter Lot No" required="required" value="{{ $qr->lot_no ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <br>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <button type="button" class="btn-edit js-edit" style="background-color: #FA503C;color: #fff;">Edit</button>
                                            </div>
                                            <div class="col-md-8">
                                                <button type="submit" class="generate_btn">Generate QR</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <br>
                                        <div class="row">
                                            @if (session('message'))
                                                <div class="alert alert-success col-md-12">
                                                    {{ session('message') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div><!--//app-card-->

                </div><!--//col-->

                <div class="col-12 col-lg-4">
                    <div class="app-card app-card-basic d-flex flex-column align-items-start shadow-sm">
                        <div class="app-card-header p-3 border-bottom-0">
                            <div class="row align-items-center gx-3">
                                <div class="col-auto">
                                    <div class="app-icon-holder">
                                        <iconify-icon icon="ph:printer-light" width="30" height="30"
                                            style="color: #15a362"></iconify-icon>
                                    </div><!--//icon-holder-->

                                </div><!--//col-->
                                <div class="col-auto">
                                    <h4 class="app-card-title">Print</h4>
                                </div><!--//col-->
                            </div><!--//row-->
                        </div><!--//app-card-header-->
                        <div class="app-card-body px-4">

                            <div class="QR_img ">
                                <img src="{{ $qr_url }}" alt="" class="img-fluid ">

                            </div>
                        </div><!--//app-card-body-->
                        <div class="app-card-footer p-4 mt-auto">
                            <a class="btn app-btn-primary" href="{{ route('admin.download-qrcode') }}">Download QR</a>
                            <a class="btn app-btn-primary" href="#" onclick="openQRPage()">Sent To Print</a>
                        </div><!--//app-card-footer-->
                    </div><!--//app-card-->
                </div><!--//col-->
            </div><!--//row-->

        </div><!--//container-fluid-->
    </div>
@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        function openQRPage() {
            const qrCodeUrl = "{{ $qr_url }}";
            const newWindow = window.open('', '_blank');
            newWindow.document.write(`
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>QR Code Display</title>
                <style>
                    @media print {
                        body * {
                            visibility: hidden;
                        }
                        #qr-code, #qr-code * {
                            visibility: visible;
                        }
                        #qr-code {
                            position: absolute;
                            left: 0;
                            top: 0;
                            width: 100%;
                            height: 100%;
                            display: flex;
                            justify-content: center;
                            align-items: center;
                        }
                    }
                </style>
            </head>
            <body onload="window.print()">
                <h1>QR Code</h1>
                <img id="qr-code" src="${qrCodeUrl}" alt="QR Code">
            </body>
            </html>
        `);
            newWindow.document.close();
        }
    </script>

    <script>
        $(document).ready(function() {
            $('#grade_name').select2({
                placeholder: "Select Grade Name",
                allowClear: true
            });
        });
    </script>

@endsection
