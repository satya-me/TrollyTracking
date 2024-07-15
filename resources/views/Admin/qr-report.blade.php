@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
@endsection

@section('content')
    <div class="app-content pt-3 p-md-3 p-lg-4">
        <div class="container-xl">
            <div class="row g-4 mb-4">
                <div class="col-12 col-lg-12">
                    <div class="app-card app-card-basic shadow-sm">
                        <div class="row m-2">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3 ">
                                        <?php
                                        // Get the status from the GET request
                                        $status = isset($_GET['status']) ? $_GET['status'] : '';
                                        ?>

                                        <form id="statusForm" class="p-2" action="{{ route('admin.qrcode-report') }}"
                                            method="GET">
                                            <select class="form-select" name="status" id="statusSelect"
                                                aria-label="Default select example">
                                                <option value="" <?php echo $status == '' ? 'selected' : ''; ?>>Status</option>
                                                <option value="In_Stock" <?php echo $status == 'In_Stock' ? 'selected' : ''; ?>>In Stock</option>
                                                <option value="In_Stock" <?php echo $status == 'In_Stock' ? 'selected' : ''; ?>>In Hand</option>
                                                <option value="Dispatched" <?php echo $status == 'Dispatched' ? 'selected' : ''; ?>>Dispatched</option>
                                            </select>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <form id="qrReportForm" class="p-2" action="{{ route('download-qr-report') }}"
                                method="GET">
                                <div class="row">
                                    <input type="hidden" name="status" value=<?php echo $status; ?>>
                                    <div class="col-md-3">
                                        <div class="date_filter mb-3">
                                            <input type="text" id="date_range" class="form-control" name="date_range"
                                                value="{{ request()->input('date_range', '') }}" />
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div class="row">
                                <div class="col-md-2">
                                    <input name="date_range" id="dateInput" type="hidden" value="">
                                    <button id="downloadButton" class="generate_btn">
                                        <span><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15"
                                                viewBox="0 0 24 24" fill="#fff">
                                                <path d="m12 16 4-5h-3V4h-2v7H8z" />
                                                <path
                                                    d="M20 18H4v-7H2v7c0 1.103.897 2 2 2h16c1.103 0 2-.897 2-2v-7h-2v7z" />
                                            </svg></span>
                                        Download
                                    </button>
                                </div>
                            </div>

                            <br>
                            <div class="row m-2">
                                <form id="filterForm" class="p-2" action="{{ route('admin.qrcode-search') }}"
                                    method="GET">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <input type="text" id="date_range_filter" class="form-control"
                                                    name="date_range" value="{{ request('date_range', '') }}"
                                                    placeholder="Date Range" />
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <select id="grade_name_filter" name="grade_name" class="form-select">
                                                    <option value="">Select Grade Name</option>
                                                    @foreach ($gradenames as $gradename)
                                                        <option value="{{ $gradename->grade_name }}"
                                                            {{ request('grade_name') == $gradename->grade_name ? 'selected' : '' }}>
                                                            {{ $gradename->grade_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <input type="text" id="batch" class="form-control"
                                                    name="batch_no" value="{{ request('batch_no', '') }}"
                                                    placeholder="Batch No" />
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <input type="text" id="lot" class="form-control" name="lot_no"
                                                    value="{{ request('lot_no', '') }}" placeholder="Lot No" />
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <select id="status_filter" name="dispatch_status" class="form-select">
                                                    <option value="">Select Status</option>
                                                    <option value="In_Stock"
                                                        {{ request('dispatch_status') == 'In_Stock' ? 'selected' : '' }}>In
                                                        Hand</option>
                                                    <option value="In_Stock" <?php echo $status == 'In_Stock' ? 'selected' : ''; ?>>In Hand</option>
                                                    <option value="Dispatched"
                                                        {{ request('dispatch_status') == 'Dispatched' ? 'selected' : '' }}>
                                                        Dispatched</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-primary">Find</button>
                                        </div>
                                    </div>
                                </form>
                            </div>


                            <!-- New section for downloading the Excel file -->
                            <div class="col-3 col-lg-4 mt-2 ">
                                <form action="{{ route('download-qr-report-grade') }}" method="get">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <select id="grade_name" name="grade_name" class="form-select ">
                                                <option value="">Grade Name</option>
                                                @foreach ($gradenames as $gradename)
                                                    <option value="{{ $gradename->grade_name }}"
                                                        {{ request()->input('grade_name') == $gradename->grade_name ? 'selected' : '' }}>
                                                        {{ $gradename->grade_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-5">
                                            <button type="submit" class="generate_btn">Download</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>


                        <div class="app-card-header p-3 border-bottom-0">
                            <div class="row align-items-center gx-3">
                                <div class="table-responsive">
                                    <table class="table app-table-hover mb-0 text-left">
                                        <thead style="background-color: #edfdf6 !important;">
                                            <tr>
                                                <th class="cell">Dispatch Status</th>
                                                <th class="cell">Grade Name</th>
                                                <th class="cell">Origin</th>
                                                <th class="cell">Batch No</th>
                                                <th class="cell">Net Weight</th>
                                                <th class="cell">Gross Weight</th>
                                                <th class="cell">Lot No</th>
                                                <th class="cell">QR Image</th>
                                                <th class="cell">Created Date</th>
                                                <th class="cell">Dispatch Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($qr_latest as $data)
                                                @php
                                                    $QR_DATA = json_encode([
                                                        'id' => $data->id,
                                                        'dispatch_status' => $data->dispatch_status,
                                                        'grade_name' => $data->grade_name,
                                                        'origin' => $data->origin,
                                                        'batch_no' => $data->batch_no,
                                                        'net_weight' => $data->net_weight,
                                                        'gross_weight' => $data->gross_weight,
                                                        'lot_no' => $data->lot_no,
                                                    ]);
                                                @endphp
                                                <tr>
                                                    <td class="cell"><span
                                                            class="badge {{ $data->dispatch_status == 'In_Stock' ? 'bg-danger' : 'bg-success' }}">{{ $data->dispatch_status }}</span>
                                                    </td>
                                                    <td class="cell">{{ $data->grade_name }}</td>
                                                    <td class="cell">{{ $data->origin }}</td>
                                                    <td class="cell">{{ $data->batch_no }}</td>
                                                    <td class="cell">{{ $data->net_weight }}</td>
                                                    <td class="cell">{{ $data->gross_weight }}</td>
                                                    <td class="cell">{{ $data->lot_no }}</td>
                                                    <td class="cell">
                                                        <a href="#" class="view-qr" data-id="{{ $data->id }}"
                                                            data-qr="https://api.qrserver.com/v1/create-qr-code/?size=400x400&data={{ $QR_DATA }}">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    </td>
                                                    <td class="cell">{{ $data->created_at }}</td>
                                                    <td class="cell">
                                                        {{ $data->dispatch_status == 'Dispatched' ? $data->updated_at : '' }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <!-- Add pagination links -->
                                    <div class="pagination d-flex mt-4">
                                        {{ $qr_latest->links('pagination::bootstrap-5') }}

                                    </div>

                                    <!-- Display total count below the table -->
                                    <div class="row mt-3 text-right px-5">
                                        <p><b>Total Records = </b>{{ $totalCount }}</p>
                                        <p><b>Total Dispatch = </b>{{ $dispatchedCount }}</p>
                                        <p><b>Total InHand = </b>{{ $inhand }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Modal for viewing QR code -->
    <!-- Modal -->
    <div class="modal fade" id="qrModal" tabindex="-1" aria-labelledby="qrModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="qrModalLabel">QR Code</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="qrImage" src="" alt="QR Code" style="max-width: 100%; height: 250px;">
                    <input type="hidden" id="qrDataId" value="">
                </div>
                <div class="modal-footer">
                    <a id="downloadQR" class="btn btn-primary" href="#">Download</a>
                    <button id="printQR" type="button" class="btn btn-success">Print</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    {{-- date range filter --}}
    <script>
        $(function() {
            $('input[name="date_range"]').daterangepicker();

            $('input[name="date_range"]').on('apply.daterangepicker', function(ev, picker) {
                $('#dateRangeForm').submit();
            });

            $('#statusSelect').on('change', function() {
                $('#statusForm').submit();
            });
        });
    </script>

    <script>
        function setDateRange() {
            var dateRangeValue = document.getElementById('date_range').value;
            document.getElementById('dateInput').value = dateRangeValue;
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.view-qr').forEach(function(element) {
                element.addEventListener('click', function(event) {
                    event.preventDefault();
                    const qrUrl = this.getAttribute('data-qr');
                    const dataId = this.getAttribute('data-id');
                    console.log({
                        qrUrl,
                        dataId
                    });

                    document.getElementById('qrImage').src = qrUrl;
                    document.getElementById('qrDataId').value = dataId;

                    // Update the download button link
                    const downloadLink = document.getElementById('downloadQR');
                    downloadLink.href = `/admin/get-qr-image/${dataId}`;

                    const qrModal = new bootstrap.Modal(document.getElementById('qrModal'));
                    qrModal.show();
                });
            });
            document.getElementById('printQR').addEventListener('click', function() {
                // function openQRPage() {
                const qrUrl = document.getElementById('qrImage').src;

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
                                    <img id="qr-code" src="${qrUrl}" alt="QR Code">

                                </body>

                                </html>
                                `);
                newWindow.document.close();
                // }
            });
        });
    </script>

    <script>
        $(function() {
            $('input[name="grade_name"]').gradenamepicker();

            $('input[name="grade_name"]').on('apply.gradenamepicker', function(ev, picker) {
                $('#gradeNameForm').submit();
            });
        });
    </script>

    <script>
        $(function() {
            // $('input[name="grade_name"]').gradenamepicker();

            // $('input[name="grade_name"]').on('apply.gradenamepicker', function(ev, picker) {
            //     $('#originForm').submit();
            // });
            $("#downloadButton").click(function() {
                // Your code here
                $('#qrReportForm').submit();
            });
            $("#findButton").click(function() {
                // Your code here
                $('#qrReportForm').submit();
            });
        });
    </script>
    {{-- <script>
        $(function() {
            $("#downloadButton").click(function(){
                $('#qrReportForm').submit();
            });
            $("#findButton").click(function(){
                $('#qrReportForm').submit();
            });
        });
    </script> --}}
@endsection
