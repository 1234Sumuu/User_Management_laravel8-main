@extends('layouts.settings')
@section('content')
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-inner slimscroll">
            <div class="sidebar-menu">
                <ul>
                    <li><a href="{{ route('home') }}"><i class="la la-home"></i> <span>Back to Home</span></a></li>

                </ul>
            </div>
        </div>
    </div>

    <div class="page-wrapper">

        <div class="content container-fluid">

            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Roles & Permissions</h3>
                    </div>
                </div>
            </div>
            {{-- message --}}
            {!! Toastr::message() !!}
            <!-- /Page Header -->
            <div class="row">
                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-3">
                    <a href="#" class="btn btn-primary btn-block" data-toggle="modal" data-target="#add_role"><i class="fa fa-plus"></i> Add Roles</a>
                    <div class="roles-menu">
                        <ul>
                            @foreach ($rolesPermissions as $rolesName )
                            <li class="{{ $loop->first ? 'active' : '' }}">
                                <span hidden class="id">{{ $rolesName->id }}</span>
                                <a class="active" href="javascript:void(0);"><span class="roleNmae">{{ $rolesName->permissions_name }}</span>
                                    <span class="role-action">
                                        <span class="action-circle large rolesUpdate" data-toggle="modal" data-id="'.$rolesName->id.'" data-target="#edit_role">
                                            <i class="material-icons">edit</i>
                                        </span>
                                        <span class="action-circle large delete-btn rolesDelete" data-toggle="modal"  data-id="'.$rolesName->id.'" data-target="#delete_role">
                                            <i class="material-icons">delete</i>
                                        </span>
                                    </span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-9">
                    <h6 class="card-title m-b-20">Module Access</h6>
                    <div class="m-b-30">
                        <ul class="list-group notification-list">
                            <li class="list-group-item">
                                Employee
                                <div class="status-toggle">
                                    <input type="checkbox" id="staff_module" class="check">
                                    <label for="staff_module" class="checktoggle">checkbox</label>
                                </div>
                            </li>

                        </ul>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped custom-table">
                            <thead>
                                <tr>
                                    <th>Module Permission</th>
                                    <th class="text-center">Read</th>
                                    <th class="text-center">Write</th>
                                    <th class="text-center">Create</th>
                                    <th class="text-center">Delete</th>
                                    <th class="text-center">Export</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->

        <!-- Add Role Modal -->
        <div id="add_role" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Role</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('roles/permissions/save') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>Role Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('roleName') is-invalid @enderror" id="roleName" name="roleName" value="{{ old('roleName') }}" placeholder="Enter role name">
                            </div>
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Add Role Modal -->

        <!-- Edit Role Modal -->
        <div id="edit_role" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-md">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Role</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('roles/permissions/update') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <input type="hidden" name="id" id="e_id" value="">
                                <label>Role Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="e_roleNmae" name="roleName" value="">
                            </div>
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Edit Role Modal -->

        <!-- Delete Role Modal -->
        <div class="modal custom-modal fade" id="delete_role" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Delete Role</h3>
                            <p>Are you sure want to delete?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <form action="{{ route('roles/permissions/delete') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" class="e_id" value="">
                                <div class="row">
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-primary continue-btn submit-btn">Delete</button>
                                    </div>
                                    <div class="col-6">
                                        <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Delete Role Modal -->
    </div>
    <!-- /Page Wrapper -->
    @section('script')
    {{-- update js --}}
    <script>
        $(document).on('click','.rolesUpdate',function()
        {
            var _this = $(this).closest("li");;
            $('#e_id').val(_this.find('.id').text());
            $('#e_roleNmae').val(_this.find('.roleNmae').text());
        });
    </script>
    {{-- delete js --}}
    <script>
        $(document).on('click','.rolesDelete',function()
        {
            var _this = $(this).closest("li");
            $('.e_id').val(_this.find('.id').text());
        });
    </script>
    @endsection
@endsection
