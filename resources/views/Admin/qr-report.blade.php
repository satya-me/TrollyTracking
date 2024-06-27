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


                            <div class="col-3 col-lg-3">
                                <div class="mb-3 ">
                                    <form id="statusForm" class="p-2" action="{{ route('admin.qrcode-report') }}"
                                        method="GET">
                                        <select class="form-select " name="status" id="statusSelect"
                                            aria-label="Default select example">
                                            <option selected>Open this select menu</option>
                                            <option value="Production">Production</option>
                                            <option value="Dispatched">Dispatched</option>
                                        </select>
                                    </form>
                                </div>
                            </div>

                            <div class="col-3 col-lg-3">
                                <form id="dateRangeForm" action="{{ route('admin.qrcode-report') }}" method="GET"
                                    class="p-2">
                                    <div class="date_filter mb-3">
                                        <input type="text" id="date_range" class="form-control" name="date_range"
                                            value="<?php echo isset($_GET['date_range']) && $_GET['date_range'] != '' ? htmlspecialchars($_GET['date_range']) : ''; ?>" />
                                    </div>
                                </form>
                            </div>

                            <div class="col-3 col-lg-2">
                                <form action="{{ route('download-qr-report') }}" method="GET" onsubmit="setDateRange()"
                                    class="mt-2">
                                    <input name="date_range" id="dateInput" type="hidden" value="">
                                    <button class="generate_btn">
                                        <span><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15"
                                                viewBox="0 0 24 24" fill="#fff">
                                                <path d="m12 16 4-5h-3V4h-2v7H8z" />
                                                <path
                                                    d="M20 18H4v-7H2v7c0 1.103.897 2 2 2h16c1.103 0 2-.897 2-2v-7h-2v7z" />
                                            </svg></span>
                                        Download</button>
                                </form>
                            </div>

                            <div class="col-3 col-lg-4 mt-2 ">
                                <form action="{{ route('admin.qrcode-report') }}" method="get">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="search_item"
                                                placeholder="Grade or Batch or Lot" value="<?php echo isset($_GET['search_item']) && $_GET['search_item'] != '' ? htmlspecialchars($_GET['search_item']) : ''; ?>" required>
                                        </div>
                                        <div class="col-md-4">
                                            <button type="submit" class="generate_btn">Find</button>
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
                                                            class="badge {{ $data->dispatch_status == 'Production' ? 'bg-danger' : 'bg-success' }}">{{ $data->dispatch_status }}</span>
                                                    </td>
                                                    <td class="cell">{{ $data->grade_name }}</td>
                                                    <td class="cell">{{ $data->origin }}</td>
                                                    <td class="cell">{{ $data->batch_no }}</td>
                                                    <td class="cell">{{ $data->net_weight }}</td>
                                                    <td class="cell">{{ $data->gross_weight }}</td>
                                                    <td class="cell">{{ $data->lot_no }}</td>
                                                    <td class="cell">
                                                        <a href="#" class="view-qr"
                                                            data-qr="https://api.qrserver.com/v1/create-qr-code/?size=400x400&data={{ $QR_DATA }}">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    </td>
                                                    <td class="cell">{{ $data->created_at }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <!-- Add pagination links -->
                                    <div class="pagination d-flex mt-4">
                                        {{ $qr_latest->links('pagination::bootstrap-5') }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal for viewing QR code -->
                        <div class="modal fade" id="qrModal" tabindex="-1" role="dialog" aria-labelledby="qrModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="qrModalLabel">QR Code</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <img id="qrModalImage" src="" alt="QR Code"
                                            style="max-width: 100%; height: 250px;">
                                    </div>
                                    <div class="modal-footer">
                                        <a id="downloadQR" class="btn btn-primary" href="#"
                                            download="qrcode.png">Download</a>
                                        <button id="printQR" type="button" class="btn btn-success">Print</button>
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                    </div>

                                    <img id="qrModalImage" src="data:image/png;base64,..." style="display:none;" />

                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script> --}}
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
        $(document).ready(function() {
            $('.view-qr').click(function(event) {
                event.preventDefault();
                var qrSrc = $(this).data('qr');
                $('#qrModalImage').attr('src', qrSrc);
                $('#qrModal').modal('show');
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Function to handle downloading the QR code image
            $('#downloadQR').click(function() {
                // Get the src attribute of the QR code image
                var qrImageUrl = $('#qrModalImage').attr('src');

                // Create an anchor element to trigger download
                var downloadLink = document.createElement('a');
                downloadLink.href = qrImageUrl;
                downloadLink.download =
                    'qr_code.png'; // File name to download as (you can change the extension based on the image type)
                document.body.appendChild(downloadLink);
                downloadLink.click();
                document.body.removeChild(downloadLink);
            });

            // Function to handle printing the QR code image
            $('#printQR').click(function() {
                // Get the QR code image element
                var qrImage = document.getElementById('qrModalImage');

                // Create a new window to print the QR code
                var printWindow = window.open('', '_blank');
                printWindow.document.open();
                printWindow.document.write(
                    '<html><head><title>Print QR Code</title></head><body style="text-align:center;">');
                printWindow.document.write('<img src="' + qrImage.src +
                    '" style="max-width:100%; height:auto;">');
                printWindow.document.write('</body></html>');
                printWindow.document.close();
                printWindow.print();
                printWindow.close();
            });
        });
    </script>
@endsection
