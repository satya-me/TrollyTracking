@extends('layouts.master')

@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection

@section('content')
    <div class="app-content pt-3 p-md-3 p-lg-4">
        <div class="container-xl">
            <div class="row g-4 mb-4">
                <div class="row g-4 mb-4">
                    <div class="col-12 col-lg-12">
                            <div class="app-card app-card-basic shadow-sm">
                                <div class="row m-2">

                                    <div class="col-3 col-lg-3">
                                        <form id="dateRangeForm" action="{{ route('productivity-report') }}" method="GET"
                                            class="p-2">
                                            <div class="date_filter mb-3">
                                                <input type="text" id="date_range" class="form-control" name="date_range"
                                                    value="<?php echo isset($_GET['date_range']) && $_GET['date_range'] != '' ? htmlspecialchars($_GET['date_range']) : ''; ?>" />
                                            </div>
                                        </form>
                                    </div>

                                    <div class="col-3 col-lg-2">
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
                                                <?php
                                                    $sl=1;
                                                ?>
                                                <tbody>
                                                    @foreach ($data as $item)
                                                        <?php
                                                            $supervisor = App\Models\User::where('id', $item->supervisor)->first();
                                                        ?>

                                                        <tr>
                                                            <td class="cell">{{$sl++}}</</td>
                                                            <td class="cell">{{ $item->trolly_name }}</td>
                                                            <td class="cell"><span class="badge bg-success">{{ $item->department}}</span></td>
                                                            <td class="cell">{{ $supervisor->name}}</td>
                                                            <td class="cell">{{ $item->entry_time}}</td>
                                                            <td class="cell">{{ $item->exit_time}}</td>
                                                            <td class="cell">{{ $item->total_time}}</td>

                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div><!--//table-responsive-->

                                    </div><!--//app-card-body-->
                                </div>
                            </div>
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

    {{-- date range --}}
    <script type="text/javascript">
        $(function() {
            $('#date_range').daterangepicker({
                locale: {
                    format: 'MM/DD/YYYY'
                },
                autoUpdateInput: false
            });

            $('#date_range').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
            });

            $('#date_range').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
        });
    </script>
    {{-- <script>
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
    </script> --}}
@endsection
