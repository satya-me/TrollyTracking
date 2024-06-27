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
                            <div class="d-flex align-items-center justify-content-between gap-6">
                                <div>
                                    <form action="{{ route('search-trolly') }}" method="GET">
                                        <div class="d-flex align-items-center justify-content-between gap-2">
                                            <div class="input-group">
                                                <?php $selectedDepartment = isset($_GET['department']) ? $_GET['department'] : ''; ?>

                                                <select class="form-select" id="department" name="department">
                                                    <option value="">Select...</option>
                                                    <option value="RCN RECEVING" <?php echo $selectedDepartment == 'RCN RECEVING' ? 'selected' : ''; ?>>RCN RECEVING</option>
                                                    <option value="RCN GRADING" <?php echo $selectedDepartment == 'RCN GRADING' ? 'selected' : ''; ?>>RCN GRADING</option>
                                                    <option value="RCN BOILING" <?php echo $selectedDepartment == 'RCN BOILING' ? 'selected' : ''; ?>>RCN BOILING</option>
                                                    <option value="SCOOPING" <?php echo $selectedDepartment == 'SCOOPING' ? 'selected' : ''; ?>>SCOOPING</option>
                                                    <option value="BORMA/ DRYING" <?php echo $selectedDepartment == 'BORMA/ DRYING' ? 'selected' : ''; ?>>BORMA/ DRYING</option>
                                                    <option value="PEELING" <?php echo $selectedDepartment == 'PEELING' ? 'selected' : ''; ?>>PEELING</option>
                                                    <option value="SMALL TAIHO" <?php echo $selectedDepartment == 'SMALL TAIHO' ? 'selected' : ''; ?>>SMALL TAIHO</option>
                                                    <option value="MAYUR" <?php echo $selectedDepartment == 'MAYUR' ? 'selected' : ''; ?>>MAYUR</option>
                                                    <option value="HAMSA" <?php echo $selectedDepartment == 'HAMSA' ? 'selected' : ''; ?>>HAMSA</option>
                                                    <option value="WHOLES GRADING" <?php echo $selectedDepartment == 'WHOLES GRADING' ? 'selected' : ''; ?>>WHOLES GRADING
                                                    </option>
                                                    <option value="LW GRADING" <?php echo $selectedDepartment == 'LW GRADING' ? 'selected' : ''; ?>>LW GRADING</option>
                                                    <option value="SHORTING" <?php echo $selectedDepartment == 'SHORTING' ? 'selected' : ''; ?>>SHORTING</option>
                                                    <option value="DP & DS GRADING" <?php echo $selectedDepartment == 'DP & DS GRADING' ? 'selected' : ''; ?>>DP & DS GRADING
                                                    </option>
                                                    <option value="PACKING" <?php echo $selectedDepartment == 'PACKING' ? 'selected' : ''; ?>>PACKING</option>
                                                </select>

                                                <input type="text" class="form-control" name="search_trolly"
                                                    placeholder="Find Trolly" value="<?php echo isset($_GET['search_trolly']) && $_GET['search_trolly'] != '' ? htmlspecialchars($_GET['search_trolly']) : ''; ?>"
                                                    aria-label="Find Trolly">
                                                <button class="btn btn-primary" type="submit"><i
                                                        class="fas fa-search"></i></button>
                                            </div>
                                        </div>
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
                                            <tbody>
                                                @if ($data)
                                                    @foreach ($data as $item)
                                                        <tr>
                                                            <td class="cell">1</td>
                                                            <td class="cell">{{ $item->trolly_name }}</td>
                                                            <td class="cell"><span
                                                                    class="badge bg-success">{{ $item->department }}</span>
                                                            </td>
                                                            <td class="cell">
                                                                {{ App\Models\User::find($item->supervisor)->name }}</td>
                                                            <td class="cell">{{ $item->entry_time }}</td>
                                                            <td class="cell">{{ $item->exit_time }}</td>
                                                            <td class="cell">{{ $item->total_time }}</td>
                                                        </tr>
                                                    @endforeach
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
