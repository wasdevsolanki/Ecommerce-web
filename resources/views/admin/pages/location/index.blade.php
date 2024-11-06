@extends('admin.master', ['menu' => 'admins', 'submenu' => 'location'])
@section('title', isset($title) ? $title : '')
@section('content')


    <div class="row">
        <div class="col-md-12">
            <div class="breadcrumb__content">
                <div class="breadcrumb__content__left">
                    <div class="breadcrumb__title">
                        <h2>Login Access Locations</h2>
                    </div>
                </div>
                <div class="breadcrumb__content__right">
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('Home')}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{__('Roles')}}</li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="customers__area bg-style mb-30">
                <div class="item-title">
                    <div class="col-xs-6">
                        <a href="{{route('admin.locationCreate')}}" class="btn btn-md btn-info">Add Location</a>
                    </div>
                </div>

                <div class="customers__table">
                    <table id="LocationTable" class="row-border data-table-filter table-style">
                        <thead>
                        <tr>
                            <th>City</th>
                            <th>Country Code</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach( $locations as $location)
                            <tr>
                                <td>{{ $location->city }}</td>
                                <td>{{ $location->countryCode }}</td>
                                <td>
                                    @if( $location->status == 1 )
                                        <span class="badge bg-secondary text-light ">Active</span>
                                    @else
                                        <span class="badge bg-danger text-light ">InActive</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.location.update', $location->id )}}" class="mx-3"><i class="fa fa-arrow-down" aria-hidden="true"></i></a>
                                    <a href="{{ route('admin.location.delete', $location->id )}}"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--Row-->
    @push('post_scripts')
        <script>
            $(document).ready(function() {
                var table = $('#LocationTable').DataTable({
                });
            });
        </script>
    @endpush
@endsection
