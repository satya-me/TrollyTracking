@extends('layouts.master')

@section('css')
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
                                                <th class="cell">Created Data</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($qr_latest as $data)
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
                                                    <td class="cell"><img src="https://api.qrserver.com/v1/create-qr-code/?size=400x400&data=$data->grade_name" width="70px", height="70px"></td>
                                                    <td class="cell">{{ $data->created_at }}</td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                    <!-- Add pagination links -->
                                    <div class="pagination d-flex  mt-4">
                                        {{ $qr_latest->links('pagination::bootstrap-5') }}
                                    </div>
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
@endsection
