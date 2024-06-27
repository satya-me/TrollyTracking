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
                        <form action="{{ route('search-trolly') }}" method="GET">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="search" placeholder="Find Trolly" aria-label="Find Trolly">
                                <button class="btn btn-primary" type="submit">Search</button>
                            </div>
                        </form>
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
                                            @if ($data)
                                                <tr>
                                                    <td class="cell">1</td>
                                                    <td class="cell">{{ $data->trolly_name }}</td>
                                                    <td class="cell"><span class="badge bg-success">{{ $data->department }}</span></td>
                                                    <td class="cell">{{ App\Models\User::find($data->supervisor)->name }}</td>
                                                    <td class="cell">{{ $data->entry_time }}</td>
                                                    <td class="cell">{{ $data->exit_time }}</td>
                                                    <td class="cell">{{ $data->total_time }}</td>
                                                </tr>
                                            @else
                                                <tr>
                                                    <td colspan="7" class="cell">No data found</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
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
