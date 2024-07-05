@extends('layouts.master')

@section('css')
@endsection

@section('content')
    <div class="row m-2">

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
                            <h4 class="app-card-title">Add Grade_Name</h4>
                        </div>
                    </div>
                </div>
                <form class="auth-form login-form is-readonly" action="{{ route('admin.add_grade') }}" method="POST">
                    @csrf
                    <div class="app-card-body px-4">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="email mb-3">
                                    <label class="lable_style" for="name">Grade Name</label>
                                    <input id="grade_name" name="grade_name" type="text" class="form-control"
                                        placeholder="Enter Name" required="required">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <br>
                                <div class="mt-2">
                                    <button type="submit" class="generate_btn">Add grade</button>
                                </div>
                            </div>
                        </div>
                    </div>
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
                </form>
                <div class="col-12 col-lg-12 mt-5">
                    <div class="col-auto">
                        <h6 class="app-page-title mb">Grade Names</h6>
                    </div>
                    <div class="app-card app-card-orders-table shadow-sm mb-5">
                        <div class="app-card-body">
                            <div class="table-responsive">
                                <table class="table app-table-hover mb-0 text-left">
                                    <thead>
                                        <tr>
                                            <th class="cell">Sl No</th>
                                            <th class="cell">Grade Name</th>
                                            <th class="cell">Action</th>
                                        </tr>
                                    </thead>
                                    <?php $sl = 1; ?>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td class="cell">{{ $sl++ }}</td>
                                                <td class="cell">{{ $item->grade_name }}</td>
                                                <td class="cell">
                                                    <form id="delete-form-{{ $item->id }}"
                                                        action="{{ route('admin.delete_grade', $item->id) }}" method="POST"
                                                        style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn-sm app-btn-secondary"
                                                            onclick="confirmDeletion(event, 'delete-form-{{ $item->id }}')">Delete</button>
                                                    </form>
                                                    <button type="button" class="btn-sm app-btn-secondary editGradeModal"
                                                        data-id="{{ $item->id }}" data-grade="{{ $item->grade_name }}"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editGradeModal">Edit</button>
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

        <!-- Edit Grade Modal -->
        <div class="modal fade" id="editGradeModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form class="modal-content" method="POST" action="{{ route('admin.update_grade') }}" id="editForm">
                    @csrf
                    {{-- @method('PUT') --}}
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Grade Name</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_grade_name" class="form-label">Grade Name</label>
                            <input type="text" class="form-control" id="edit_grade_name" name="grade_name" required>
                        </div>
                        <input type="hidden" id="grade_id" name="grade_id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>



        <div class="col-12 col-lg-6">
            <div class="app-card app-card-basic d-flex flex-column align-items-start shadow-sm">
                <div class="app-card-header p-3 border-bottom-0">
                    <div class="row align-items-center gx-3">
                        <div class="col-auto">
                            <div class="app-icon-holder">
                                <iconify-icon icon="material-symbols:supervisor-account-outline" width="30"
                                    height="30" style="color: #15a362;" class="" id="user-dropdown-toggle"
                                    data-bs-toggle="dropdown" role="button" aria-expanded="false"></iconify-icon>
                            </div>
                        </div>
                        <div class="col-auto">
                            <h4 class="app-card-title">Add Origin</h4>
                        </div>
                    </div>
                </div>
                <form class="auth-form login-form is-readonly" action="{{ route('admin.add_origin') }}" method="POST">
                    @csrf
                    <div class="app-card-body px-4">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="email mb-3">
                                    <label class="lable_style" for="name">Origin</label>
                                    <input id="origin" name="origin" type="text" class="form-control"
                                        placeholder="Enter Origin" required="required">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <br>
                                <div class="mt-2">
                                    <button type="submit" class="generate_btn">Add Origin</button>
                                </div>
                            </div>
                        </div>
                    </div>
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
                </form>

                <div class="col-12 col-lg-12 mt-5">
                    <div class="col-auto">
                        <h6 class="app-page-title mb">Origin Names</h6>
                    </div>
                    <div class="app-card app-card-orders-table shadow-sm mb-5">
                        <div class="app-card-body">
                            <div class="table-responsive">
                                <table class="table app-table-hover mb-0 text-left">
                                    <thead>
                                        <tr>
                                            <th class="cell">Sl No</th>
                                            <th class="cell">Origin</th>
                                            <th class="cell">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dataorigin as $item)
                                            <tr>
                                                <td class="cell">{{ $loop->iteration }}</td>
                                                <td class="cell">{{ $item->origin }}</td>
                                                <td class="cell">
                                                    <form id="delete-form-{{ $item->id }}"
                                                        action="{{ route('admin.delete_origin', $item->id) }}"
                                                        method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn-sm app-btn-secondary"
                                                            onclick="confirmDeletion(event, 'delete-form-{{ $item->id }}')">Delete</button>
                                                    </form>
                                                    <button type="button"
                                                        class="btn-sm app-btn-secondary editOriginModal"
                                                        data-id="{{ $item->id }}" data-origin="{{ $item->origin }}"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editOriginModal">Edit</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Edit Modal -->
                <div class="modal fade" id="editOriginModal" tabindex="-1" aria-labelledby="editModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">Edit Origin</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form id="editForm" method="POST" action="{{ route('admin.update_origin') }}">
                                @csrf
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="editOrigin" class="form-label">Origin</label>
                                        <input type="text" class="form-control" id="editOrigin" value=""
                                            name="origin" required>
                                        <input type="hidden" name="origin_id" id="origin_id">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


            </div>
        </div>

    </div>
@endsection

@section('js')

    {{-- grade name --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editButtons = document.querySelectorAll('.editGradeModal');
            const editForm = document.getElementById('editForm');
            const gradeIdInput = document.getElementById('grade_id');

            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const gradeId = this.getAttribute('data-id');
                    const gradeName = this.getAttribute('data-grade');
                    document.getElementById('edit_grade_name').value = gradeName;
                    gradeIdInput.value = gradeId; // Set the grade_id value

                    //editForm.action = `/admin/update_grade/${gradeId}`;
                });
            });
        });
    </script>

    {{-- origin --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editButtons = document.querySelectorAll('.editOriginModal');
            const editForm = document.getElementById('editForm');
            const originIdInput = document.getElementById('origin_id');

            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const originId = this.getAttribute('data-id');
                    const originName = this.getAttribute('data-origin');
                    document.getElementById('editOrigin').value = originName;
                    originIdInput.value = originId; // Set the origin_id value

                    //editForm.action = `/admin/update_origin/${originId}`; // Set the form action dynamically
                });
            });
        });
    </script>
@endsection
