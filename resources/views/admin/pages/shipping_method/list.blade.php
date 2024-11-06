@extends('admin.master', ['menu' => 'shipping_method', 'submenu' => 'shipping_method_list'])
@section('title', isset($title) ? $title : '')
@section('content')

    <div id="table-url" data-url=""></div>
    <div class="row">
        <div class="col-md-12">
            <div class="breadcrumb__content">
                <div class="breadcrumb__content__left">
                    <div class="breadcrumb__title">
                        <h2>Shipping Management</h2>
                    </div>
                </div>

                <div class="breadcrumb__content__right">
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('Home')}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Method</li>
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

                    <div class="d-flex justify-content-end mb-2"> <!-- Wrap the button in a container with the 'd-flex' and 'justify-content-end' classes -->
                        <a href="{{ route('admin.method.create') }}" class="btn btn-sm btn-primary"><i class="fa-solid fa-plus"></i> Add Method</a>
                    </div>


                    <table id="AdvertiseTable" class="row-border data-table-filter table-style">
                        <thead>
                        <tr>
                            <th>Template</th>
                            <th>Product Type</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody id="DataProduct">
                        @foreach( $shipping_methods as $method )
                            <tr>
                                <td><img src="{{ asset('uploaded_files/shipping_methods/'.$method->image) }}" border="0" width="50" class="img-rounded" align="center" /></td>
                                <td>{{ $method->name }}</td>

                                <td>
                                    @if( $method->status == true )
                                        <a class="badge bg-success text-light">Active</a>
                                    @else
                                        <a class="badge bg-danger text-light">InActive</a>
                                    @endif
                                </td>

                                <td>
                                    <div class="action__buttons justify-content-center">
                                        <a href="{{route('admin.method.update', ['id' => $method->id ])}}" class="btn-action"><i class="fa-solid fa-arrow-pointer"></i> Change Status</a>
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
