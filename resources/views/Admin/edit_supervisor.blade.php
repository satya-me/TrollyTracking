@extends('layouts.master')

@section('content')
<div class="container">
    <h2>Edit Supervisor</h2>
    <form action="{{ route('admin.update-supervisor', $supervisor->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $supervisor->name }}" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone" value="{{ $supervisor->phone }}" required>
        </div>
        <div class="form-group">
            <label for="department">Department</label>
            <select class="form-select" name="department" id="department">
                <option value="VILLAGE" {{ $supervisor->department == 'VILLAGE' ? 'selected' : '' }}>VILLAGE</option>
                <option value="OUTSIDE VILLAGE" {{ $supervisor->department == 'OUTSIDE VILLAGE' ? 'selected' : '' }}>OUTSIDE VILLAGE</option>
                <option value="RCN BOILING" {{ $supervisor->department == 'RCN BOILING' ? 'selected' : '' }}>RCN BOILING</option>
                <option value="SCOOPING" {{ $supervisor->department == 'SCOOPING' ? 'selected' : '' }}>SCOOPING</option>
                <option value="BORMA/ DRYING(New)" {{ $supervisor->department == 'BORMA/ DRYING(New)' ? 'selected' : '' }}>BORMA/ DRYING(New)</option>
                <option value="BORMA/ DRYING(Final)" {{ $supervisor->department == 'BORMA/ DRYING(Final)' ? 'selected' : '' }}>BORMA/ DRYING(Final)</option>
                <option value="PEELING" {{ $supervisor->department == 'PEELING' ? 'selected' : '' }}>PEELING</option>
                <option value="SMALL TAIHO" {{ $supervisor->department == 'SMALL TAIHO' ? 'selected' : '' }}>SMALL TAIHO</option>
                <option value="MAYUR" {{ $supervisor->department == 'MAYUR' ? 'selected' : '' }}>MAYUR</option>
                <option value="HAMSA" {{ $supervisor->department == 'HAMSA' ? 'selected' : '' }}>HAMSA</option>
                <option value="WHOLES GRADING" {{ $supervisor->department == 'WHOLES GRADING' ? 'selected' : '' }}>WHOLES GRADING</option>
                <option value="LW GRADING" {{ $supervisor->department == 'LW GRADING' ? 'selected' : '' }}>LW GRADING</option>
                <option value="SHORTING" {{ $supervisor->department == 'SHORTING' ? 'selected' : '' }}>SHORTING</option>
                <option value="DP & DS GRADING" {{ $supervisor->department == 'DP & DS GRADING' ? 'selected' : '' }}>DP & DS GRADING</option>
                <option value="PACKING" {{ $supervisor->department == 'PACKING' ? 'selected' : '' }}>PACKING</option>
                <!-- Add other options here -->
            </select>
        </div>

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" value="{{ $supervisor->email }}" required>
        </div>
        {{-- <div class="form-group">
            <label for="password">Password</label>
            <input type="text" class="form-control" id="password" name="password" placeholder="Leave blank to keep current password">
        </div> --}}
        <button type="submit" class="btn btn-primary">Update Supervisor</button>
    </form>
</div>
@endsection
