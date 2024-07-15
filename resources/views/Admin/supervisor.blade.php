@extends('layouts.master')

@section('css')
@endsection

@section('content')
<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <div class="row g-4 mb-4">
            <div class="col-lg-4">
                <img src="{{ asset('assets/img/6255497.png') }}" alt="" class="img-fluid">
            </div>
            <div class="col-12 col-lg-8">
                <div class="app-card app-card-basic d-flex flex-column align-items-start shadow-sm">
                    <div class="app-card-header p-3 border-bottom-0">
                        <div class="row align-items-center gx-3">
                            <div class="col-auto">
                                <div class="app-icon-holder">
                                    <iconify-icon icon="material-symbols:supervisor-account-outline" width="30"
                                        height="30" style="color: #15a362; " class="" id="user-dropdown-toggle"
                                        data-bs-toggle="dropdown" role="button" aria-expanded="false"></iconify-icon>
                                </div>
                            </div>
                            <div class="col-auto">
                                <h4 class="app-card-title">Add Supervisor</h4>
                            </div>
                        </div>
                    </div>
                    <form class="auth-form login-form is-readonly" action="{{ route('admin.add-supervisor') }}" method="POST">
                        @csrf
                        <div class="app-card-body px-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="email mb-3">
                                        <label class="lable_style" for="name"> Name</label>
                                        <input id="name" name="name" type="text" class="form-control"
                                            placeholder="Enter Name" required="required">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="email mb-3">
                                        <label class="lable_style" for="Origin">Phone</label>
                                        <input id="phone" name="phone" type="text" class="form-control"
                                            placeholder="Enter Phone No" required="required">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="lable_style" for="Origin">Department</label>
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
                                <div class="col-md-6">
                                    <div class="email mb-3">
                                        <label class="lable_style" for="netwt">Username <small
                                                style="color: #ea5a5a">Eg: utsab@payaldealers.in</small></label>
                                        <input id="username" name="username" type="text" class="form-control"
                                            placeholder="Enter Username" required="required">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="email mb-3">
                                        <label class="lable_style" for="netwt">Password Create</label>
                                        <input id="password" name="password" type="text" class="form-control"
                                            placeholder="Enter Password" required="required">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <br>
                                    <div class="mt-2">
                                        <button type="submit" class="generate_btn">Add Supervisor</button>
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
                </div>
            </div>
            <div class="col-12 col-lg-12 mt-5">
                <div class="col-auto">
                    <h1 class="app-page-title mb">List Of Supervisor</h1>
                </div>
                <div class="app-card app-card-orders-table shadow-sm mb-5">
                    <div class="app-card-body">
                        <div class="table-responsive">
                            <table class="table app-table-hover mb-0 text-left">
                                <thead>
                                    <tr>
                                        <th class="cell">Sl No</th>
                                        <th class="cell">Name</th>
                                        <th class="cell">Phone</th>
                                        <th class="cell">Department</th>
                                        <th class="cell">Username</th>
                                        <th class="cell">Password</th>
                                        <th class="cell">Action</th>
                                    </tr>
                                </thead>
                                <?php
                                    $sl=1;
                                ?>
                                <tbody>
                                    @foreach ($allSupervisor as $item)
                                        <tr>
                                            <td class="cell">{{$sl++}}</td>
                                            <td class="cell">{{ $item->name }}</td>
                                            <td class="cell data">{{ $item->email }}</td>
                                            <td class="cell"><span class="badge bg-success">{{ $item->department }}</span></td>
                                            <td class="cell data">{{ $item->name }}</td>
                                            <td class="cell data">{{ $item->temp_password }}</td>
                                            <td class="cell">
                                                <form id="delete-form-{{ $item->id }}" action="{{ route('admin.delete-supervisor', $item->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-sm app-btn-secondary" onclick="confirmDeletion(event, 'delete-form-{{ $item->id }}')">Remove</button>
                                                </form>
                                                <a class="btn-sm app-btn-secondary edit" data-id="{{ $item->id }}" data-name="{{ $item->name }}" data-phone="{{ $item->phone }}" data-department="{{ $item->department }}" data-username="{{ $item->email }}" data-bs-toggle="modal" data-bs-target="#exampleModal">Edit</a>
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

<!-- Edit Supervisor Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Supervisor</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="edit-form" action="{{ route('admin.update-supervisor') }}" method="POST">
                        @csrf
                        <input type="hidden" id="edit-id" name="id" >
                        <div class="row">
                            <div class="col-md-12">
                                <div class="email mb-3">
                                    <label class="lable_style" for="edit-name"> Name</label>
                                    <input id="edit-name" name="name" type="text" class="form-control" placeholder="Enter Name" required="required">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="email mb-3">
                                    <label class="lable_style" for="edit-phone">Phone</label>
                                    <input id="edit-phone" name="phone" type="number" class="form-control" placeholder="Enter Phone No" required="required">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="lable_style" for="edit-department">Department</label>
                                <select class="form-select" name="department" id="edit-department">
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
                            <div class="col-md-12">
                                <div class="email mb-3">
                                    <label class="lable_style" for="edit-username">Username <small style="color: #ea5a5a">Eg: utsab@payaldealers.in</small></label>
                                    <input id="edit-username" name="username" type="text" class="form-control" placeholder="Enter Username" required="required">
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="generate_btn">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.edit').forEach(button => {
                button.addEventListener('click', function () {
                    const id = this.getAttribute('data-id');
                    const name = this.getAttribute('data-name');
                    const phone = this.getAttribute('data-phone');
                    const department = this.getAttribute('data-department');
                    const username = this.getAttribute('data-username');

                    // const editForm = document.getElementById('edit-form');
                    // editForm.action = '/admin/update/supervisor/' + id;

                    document.getElementById('edit-id').value = id;
                    document.getElementById('edit-name').value = name;
                    document.getElementById('edit-phone').value = phone;
                    document.getElementById('edit-department').value = department;
                    document.getElementById('edit-username').value = username;
                });
            });
        });

        function confirmDeletion(event, formId) {
            event.preventDefault();
            if (confirm('Are you sure you want to delete this supervisor?')) {
                document.getElementById(formId).submit();
            }
        }
    </script>
@endsection

@section('scripts')
@endsection
