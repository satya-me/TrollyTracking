@extends('layouts.master')

@section('css')
@endsection

@section('content')
<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <div class="row g-4 mb-4">
            <div class="col-12 col-lg-12 mt-5">
                <div class="app-card app-card-orders-table shadow-sm mb-5">
                    <div class="app-card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table app-table-hover mb-0 text-left">
                                <thead>
                                    <tr>
                                        <th class="cell">SL no.</th>
                                        <th class="cell">Department</th>
                                        <th class="cell">Opening</th>
                                        <th class="cell">Date</th>
                                        <th class="cell">Get</th>
                                        <th class="cell">Total</th>
                                        <th class="cell">Send</th>
                                        <th class="cell">Backlog</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $sl=1; ?>
                                    @foreach ($data as $index => $item)
                                    <tr>
                                        <td class="cell">{{ $sl++ }}</td>
                                        <td class="cell">{{ $item['place'] }}</td>
                                        <td class="cell">{{ $item['opening'] }}</td>
                                        <td class="cell">{{ now()->format('Y-m-d') }}</td>
                                        <td class="cell">
                                            @foreach ($scans as $scan)
                                                @if ($scan->place == $item['place'] && $scan->quantity > 0)
                                                    {{ '+'.$scan->quantity }} ({{ $scan->department }})<br>
                                                @endif
                                            @endforeach
                                        </td>
                                        <td class="cell">{{ $item['opening'] + $item['get_quantity'] }}</td>
                                        <td class="cell">
                                            @foreach ($scans as $scan)
                                                @if ($scan->department == $item['place'] && $scan->quantity > 0)
                                                    {{ '-'.$scan->quantity }} ({{ $scan->place }})<br>
                                                @endif
                                            @endforeach
                                        </td>
                                        <td class="cell">{{ $item['backlog'] }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{-- <a href="{{ route('update-backlog') }}" class="btn btn-primary mt-3">Update Backlogs</a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
@endsection
