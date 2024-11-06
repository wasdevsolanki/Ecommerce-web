@extends('admin.master', ['menu' => 'api_access', 'submenu' => 'api_list'])
@section('title', isset($title) ? $title : '')
@section('content')

    <div id="table-url" data-url=""></div>
    <div class="row">
        <div class="col-md-12">
            <div class="breadcrumb__content">
                <div class="breadcrumb__content__left">
                    <div class="breadcrumb__title">
                        <h2>API Management</h2>
                    </div>
                </div>

                <!-- <div class="breadcrumb__content__center">
                    <a href="{{route('admin.template.create')}}" class="btn mb-2 brn-sm btn-primary">Add New</a>
                </div> -->

                <div class="breadcrumb__content__right">
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('Home')}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">API List</li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="customers__area bg-style mb-30">
                <div class="customers__table">
                    <table id="AdvertiseTable" class="row-border data-table-filter table-style">
                        <thead>
                        <tr>
                            <th>Assign</th>
                            <th>API Name</th>
                            <th>API URL</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody id="DataProduct">
                        @foreach( $apilist as $api )
                            <tr>
                                <td><strong>{{ $api->assign }}</strong></td>
                                <td>{{ $api->slug }}</td>
                                <td>
                                    @php
                                        $api_url = url('/') . '/api/' . $api->slug . '?api_key=' . $api->api_key . '&api_secret=' . $api->api_secret;
                                    @endphp
                                    {{$api_url}}
                                </td>
                                <td>
                                    @if( $api->status == true )
                                        <a class="badge bg-success text-light">Active</a>
                                    @else
                                        <a class="badge bg-danger text-light">InActive</a>
                                    @endif
                                </td>

                                <td>
                                    <div class="action__buttons">
                                        <a href="{{ route('admin.apiaccess.edit', ['id' => $api->id ]) }}" class="btn-action">Edit</a>
                                    </div>
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
                var table = $('#AdvertiseTable').DataTable({
                });
            });

        </script>
    @endpush
@endsection
