@extends('layouts.master')

@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection

@section('content')
    <div class="app-content pt-3 p-md-3 p-lg-4">
        <div class="container-xl">
            <div class="row g-4 mb-4">
                <div class="col-12 col-lg-12 mt-5">
                    <div class="col-auto">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <h1 class="app-page-title mb">List Of Productivity</h1>
                            <div class="d-flex align-items-center justify-content-between gap-2">
                                <div>
                                    <input type="text" name="daterange" value="" class="form-control" id="daterange" />
                                </div>
                                <div>
                                    <select class="form-select" id="department" name="department">
                                        <option value="RCN RECEVING">RCN RECEVING</option>
                                        <option value="RCN GRADING">RCN GRADING</option>
                                        <option value="RCN BOILING">RCN BOILING</option>
                                        <option value="SCOOPING">SCOOPING</option>
                                        <option value="BORMA/ DRYING">BORMA/ DRYING</option>
                                        <option value="PEELING">PEELING</option>
                                        <option value="SMALL TAIHO">SMALL TAIHO</option>
                                        <option value="MAYUR">MAYUR</option>
                                        <option value="HAMSA">HAMSA</option>
                                        <option value="WHOLES GRADING">WHOLES GRADING</option>
                                        <option value="LW GRADING">LW GRADING</option>
                                        <option value="SHORTING">SHORTING</option>
                                        <option value="DP & DS GRADING">DP & DS GRADING</option>
                                        <option value="PACKING">PACKING</option>
                                    </select>
                                </div>
                                <!-- Form for downloading the report -->
                                <div>
                                    <form action="{{ route('download-productivity-report') }}" method="GET" onsubmit="setDateRange()" class="mt-2">
                                        <input name="date_range" id="dateInput" type="hidden" value="">
                                        <input name="department" id="departmentInput" type="hidden" value="">
                                        <button class="generate_btn">
                                            <span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="#fff">
                                                    <path d="m12 16 4-5h-3V4h-2v7H8z"/>
                                                    <path d="M20 18H4v-7H2v7c0 1.103.897 2 2 2h16c1.103 0 2-.897 2-2v-7h-2v7z"/>
                                                </svg>
                                            </span>
                                            Download
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="app-card app-card-orders-table shadow-sm mb-5">
                        <div class="app-card-body">
                            <div class="table-responsive">
                                <table class="table app-table-hover mb-0 text-left">
                                    <thead>
                                        <tr>
                                            <th class="cell">SL no.</th>
                                            <th class="cell">Trolly Name</th>
                                            <th class="cell">Department</th>
                                            <th class="cell">Supervisor</th>
                                            <th class="cell">Entry Time</th>
                                            <th class="cell">Exit Time</th>
                                            <th class="cell">Total Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td class="cell">{{ $loop->iteration }}</td>
                                                <td class="cell">{{ $item->trolly_name }}</td>
                                                <td class="cell"><span class="badge bg-success">{{ $item->department }}</span></td>
                                                <td class="cell">{{ App\Models\User::find($item->supervisor)->name }}</td>
                                                <td class="cell">{{ $item->entry_time }}</td>
                                                <td class="cell">{{ $item->exit_time }}</td>
                                                <td class="cell">{{ $item->total_time }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        $(function() {
            $('input[name="daterange"]').daterangepicker({
                opens: 'left'
            }, function(start, end, label) {
                $('#dateInput').val(start.format('MM/DD/YYYY') + ' - ' + end.format('MM/DD/YYYY'));
            });
        });

        function setDateRange() {
            const daterange = $('#daterange').val();
            const department = $('#department').val();
            $('#dateInput').val(daterange);
            $('#departmentInput').val(department);
        }
    </script>
@endsection
