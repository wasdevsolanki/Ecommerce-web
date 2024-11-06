@extends('admin.master', ['menu' => 'user-activity'])
@section('title', isset($title) ? $title : '')
@section('content')

    <div id="table-url" data-url=""></div>
    <div class="row">
        <div class="col-md-12">
            <div class="breadcrumb__content">
                <div class="breadcrumb__content__left">
                    <div class="breadcrumb__title">
                        <h2>User List</h2>
                    </div>
                </div>
                <div class="breadcrumb__content__right">
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('Home')}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">User List</li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6"></div>
        <div class="col-md-6">
            <select class="form-select mb-2" id="roleFilter">
                <option value="">-- All Roles --</option>
                <option value="Admin">Admin</option>
                <option value="User">User</option>
            </select>
        </div>
        <div class="col-md-12">
            <div class="customers__area bg-style mb-30">
                <div class="customers__table">

                    <table id="AdvertiseTable" class="row-border data-table-filter table-style">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Profile</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $i = 1; @endphp
                        @foreach ($users as $user)
                            <tr>
                                <td>{{$i++}}</td>
                                <td><img
                                            src="{{ is_null($user->image) ? asset(IMG_PROFILE_PIC_PATH.'profile.png') : asset(IMG_PROFILE_PIC_PATH.$user->image) }}"
                                            border="0"
                                            width="50"
                                            class="img-rounded" align="center" />
                                </td>
                                <td><a href="{{ route('admin.users.activity-logs', ['user' => $user]) }}">{{ $user->name }}</a></td>
                                <td>{{$user->email}}</td>
                                <td>
                                    @if($user->is_admin == 0)
                                        <!-- <span class="badge ">User</span> -->
                                        User
                                    @else
                                        <!-- <span class="badge ">Admin</span> -->
                                        Admin
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @push('post_scripts')
        <!-- Page level custom scripts -->


        <script>

            $(document).ready(function() {
                var table = $('#AdvertiseTable').DataTable();

                $('#roleFilter').on('change', function() {
                    table.column(4).search($(this).val()).draw();
                });
            });



        </script>
    @endpush
@endsection
