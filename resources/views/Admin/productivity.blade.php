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
                                    <input type="text" name="daterange" value="01/01/2024 - 01/15/2025"
                                        class="form-control" />
                                </div>
                                <div>
                                    <select class="form-select ">
                                        <option selected="" value="option-1">RCN RECEVING</option>
                                        <option value="option-2">RCN GRADING</option>
                                        <option value="option-3">RCN BOILING</option>
                                        <option value="option-4">SCOOPING</option>
                                        <option selected="" value="option-5">BORMA/ DRYING</option>
                                        <option value="option-6">PEELING</option>
                                        <option value="option-7">SMALL TAIHO</option>
                                        <option value="option-8">MAYUR</option>
                                        <option selected="" value="option-9">HAMSA</option>
                                        <option value="option-10">WHOLES GRADING</option>
                                        <option value="option-11">LW GRADING</option>
                                        <option value="option-12">SHORTING</option>
                                        <option value="option-13">DP & DS GRADING</option>
                                        <option value="option-14">PACKING</option>


                                    </select>
                                </div>
                                <div>
                                    <form action="{{ route('download-productivity-report') }}" method="GET" onsubmit="setDateRange()" class="mt-2">
                                        <input name="date_range" id="dateInput" type="hidden" value="">
                                        <button class="generate_btn">
                                            <span><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="#fff">
                                                    <path d="m12 16 4-5h-3V4h-2v7H8z" />
                                                    <path d="M20 18H4v-7H2v7c0 1.103.897 2 2 2h16c1.103 0 2-.897 2-2v-7h-2v7z" />
                                                </svg></span>
                                            Download</button>
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
                                            <th class="cell">Trolly Name</th>
                                            <th class="cell">Department</th>
                                            <th class="cell">Supervisor</th>
                                            <th class="cell">Entry Time</th>
                                            <th class="cell">Exit Time</th>
                                            <th class="cell">Total Time</th>


                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="cell">N1</td>
                                            <td class="cell"><span class="badge bg-success">RCN RECEVING</span></td>
                                            <td class="cell">John Sanders</td>
                                            <td class="cell"><span class="cell-data">16 Jun</span><span
                                                    class="note">03:16 AM</span></td>
                                            <td class="cell"><span class="cell-data">16 Jun</span><span
                                                    class="note">04:30 AM</span></td>
                                            <td class="cell"><span class="cell-data">16 Jun</span><span
                                                    class="note">05:16 AM</span></td>

                                        </tr>
                                        <tr>
                                            <td class="cell">N1</td>
                                            <td class="cell"><span class="badge bg-success">RCN RECEVING</span></td>
                                            <td class="cell">John Sanders</td>
                                            <td class="cell"><span class="cell-data">16 Jun</span><span
                                                    class="note">03:16 AM</span></td>
                                            <td class="cell"><span class="cell-data">16 Jun</span><span
                                                    class="note">03:16 AM</span></td>
                                            <td class="cell"><span class="cell-data">16 Jun</span><span
                                                    class="note">03:16 AM</span></td>

                                        </tr>

                                    </tbody>
                                </table>
                            </div><!--//table-responsive-->

                        </div><!--//app-card-body-->
                    </div>
                </div>
            </div><!--//row-->

        </div><!--//container-fluid-->
    </div>
@endsection

@section('js')
    <script src='//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        $(function() {
            $('input[name="daterange"]').daterangepicker({
                opens: 'left'
            }, function(start, end, label) {
                console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end
                    .format('YYYY-MM-DD'));
            });
        });
    </script>
    <script>
        $(function() {
            $('input[name="daterange"]').daterangepicker({
                opens: 'left'
            }, function(start, end, label) {
                document.getElementById('dateInput').value = start.format('MM/DD/YYYY') + ' - ' + end.format('MM/DD/YYYY');
            });
        });

        function setDateRange() {
            const daterange = $('input[name="daterange"]').val();
            document.getElementById('dateInput').value = daterange;
        }
    </script>

@endsection
