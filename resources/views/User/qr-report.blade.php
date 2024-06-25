@extends('layouts.user')

@section('css')
@endsection

@section('content')
    <div class="app-content pt-3 p-md-3 p-lg-4">
        <div class="container-xl">
            <div class="row g-4 mb-4">
                <div class="col-12 col-lg-12">
                    <div class="app-card app-card-basic shadow-sm">
                        <div class="app-card-header p-3 border-bottom-0">
                            <div class="row align-items-center gx-3">
                                <div class="table-responsive">
                                    <table class="table app-table-hover mb-0 text-left">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="cell">Grade Name</th>
                                                <th class="cell">Origin</th>
                                                <th class="cell">Batch No</th>
                                                <th class="cell">Net Weight</th>
                                                <th class="cell">Gross Weight</th>
                                                <th class="cell">Lot No</th>
                                                <th class="cell">Created Data</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($qr_latest as $data)
                                                <tr>
                                                    <td class="cell">{{ $data->grade_name }}</td>
                                                    <td class="cell">{{ $data->origin }}</td>
                                                    <td class="cell">{{ $data->batch_no }}</td>
                                                    <td class="cell">{{ $data->net_weight }}</td>
                                                    <td class="cell">{{ $data->gross_weight }}</td>
                                                    <td class="cell">{{ $data->lot_no }}</td>
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
@endsection
