@extends('layouts.master')

@section('css')
@endsection

@section('content')
<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <div class="row g-4 mb-4">
            <div class="col-12 col-lg-5">
                <div class="app-card app-card-basic d-flex flex-column align-items-start shadow-sm">
                    <div class="app-card-header p-3 border-bottom-0">
                        <div class="row align-items-center gx-3">
                            <div class="col-auto">
                                <div class="app-icon-holder">
                                    <iconify-icon icon="material-symbols:supervisor-account-outline" width="30" height="30"
                                        style="color: #15a362;" class="" id="user-dropdown-toggle"
                                        data-bs-toggle="dropdown" role="button" aria-expanded="false"></iconify-icon>
                                </div>
                            </div>
                            <div class="col-auto">
                                <h4 class="app-card-title">Add Department Opening</h4>
                            </div>
                        </div>
                    </div>
                    <form class="auth-form login-form" action="{{ route('openings.store') }}" method="POST">
                        @csrf
                        <div class="app-card-body px-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="lable_style" for="department">Department</label>
                                    <select class="form-select" name="department">
                                        <option value="">Select</option>
                                        <option value="VILLAGE">VILLAGE</option>
                                        <option value="RCN BOILING">RCN BOILING</option>
                                        <option value="SCOOPING">SCOOPING</option>
                                        <option value="BORMA/ DRYING(New)">BORMA/ DRYING(New)</option>
                                        <option value="BORMA/ DRYING(Final)">BORMA/ DRYING(Final)</option>
                                        <option value="PEELING">PEELING</option>
                                        <option value="SMALL TAIHO">SMALL TAIHO</option>
                                        <option value="MAYUR">MAYUR</option>
                                        <option value="HAMSA">HAMSA</option>
                                        <option value="WHOLES GRADING">WHOLES GRADING</option>
                                        <option value="LW GRADING">LW GRADING</option>
                                        <option value="SHORTING">SHORTING</option>
                                        <option value="DP & DS GRADING">DP & DS GRADING</option>
                                        <option value="PACKING">PACKING</option>
                                        <option value="OUTSIDE VILLAGE">OUTSIDE VILLAGE</option>
                                    </select>
                                </div>
                                <label class="lable_style" for="opening">Opening</label>
                                <input id="opening" name="opening" type="text" class="form-control"
                                    placeholder="Enter opening" required="required">
                            </div>
                            <div class="col-md-6">
                                <br>
                                <div class="mt-2">
                                    <button type="submit" class="generate_btn">Add Opening</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-12 col-lg-12 mt-5">
                <div class="col-auto">
                    <h6 class="app-page-title mb">Department Openings</h6>
                </div>
                <div class="app-card app-card-orders-table shadow-sm mb-5">
                    <div class="app-card-body">
                        <div class="table-responsive">
                            <table class="table app-table-hover mb-0 text-left">
                                <thead>
                                    <tr>
                                        <th class="cell">Sl No</th>
                                        <th class="cell">Department</th>
                                        <th class="cell">Opening</th>
                                        <th class="cell">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($openings as $index => $opening)
                                    <tr>
                                        <td class="cell">{{ $index + 1 }}</td>
                                        <td class="cell">{{ $opening->department }}</td>
                                        <td class="cell">{{ $opening->opening }}</td>
                                        <td class="cell">
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editGradeModal" data-id="{{ $opening->id }}" data-department="{{ $opening->department }}" data-opening="{{ $opening->opening }}">
                                                Edit
                                            </button>
                                            <form action="{{ route('openings.destroy', $opening->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </td>
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

<!-- Edit Grade Modal -->
<div class="modal fade" id="editGradeModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" method="POST" id="editForm">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Opening</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="lable_style" for="department">Department</label>
                    <select class="form-select" name="department" id="editDepartment">
                        <option value="">Select</option>
                        <option value="VILLAGE">VILLAGE</option>
                        <option value="RCN BOILING">RCN BOILING</option>
                        <option value="SCOOPING">SCOOPING</option>
                        <option value="BORMA/ DRYING(New)">BORMA/ DRYING(New)</option>
                        <option value="BORMA/ DRYING(Final)">BORMA/ DRYING(Final)</option>
                        <option value="PEELING">PEELING</option>
                        <option value="SMALL TAIHO">SMALL TAIHO</option>
                        <option value="MAYUR">MAYUR</option>
                        <option value="HAMSA">HAMSA</option>
                        <option value="WHOLES GRADING">WHOLES GRADING</option>
                        <option value="LW GRADING">LW GRADING</option>
                        <option value="SHORTING">SHORTING</option>
                        <option value="DP & DS GRADING">DP & DS GRADING</option>
                        <option value="PACKING">PACKING</option>
                        <option value="OUTSIDE VILLAGE">OUTSIDE VILLAGE</option>
                    </select>
                </div>
                <label class="lable_style" for="opening">Opening</label>
                <input id="editOpening" name="opening" type="text" class="form-control" placeholder="Enter opening" required="required">
                <input type="hidden" id="grade_id" name="grade_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('js')
<script>
    $('#editGradeModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var department = button.data('department');
        var opening = button.data('opening');
        var modal = $(this);
        modal.find('#editForm').attr('action', '/openings/' + id);
        modal.find('#editDepartment').val(department);
        modal.find('#editOpening').val(opening);
        modal.find('#grade_id').val(id);
    });
</script>
@endsection
