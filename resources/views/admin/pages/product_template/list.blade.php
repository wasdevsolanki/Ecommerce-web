@extends('admin.master', ['menu' => 'products', 'submenu' => 'product-template'])
@section('title', isset($title) ? $title : '')
@section('content')

    <div id="table-url" data-url=""></div>
    <div class="row">
        <div class="col-md-12">
            <div class="breadcrumb__content">
                <div class="breadcrumb__content__left">
                    <div class="breadcrumb__title">
                        <h2>Template Management</h2>
                    </div>
                </div>

                <div class="breadcrumb__content__right">
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('Home')}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Template</li>
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
                    <a href="{{route('admin.template.create')}}" class="btn mb-2 brn-sm btn-primary">Add Template</a>
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
                        @foreach( $templates as $template )
                            <tr>
                                <td><img src="{{ asset('uploaded_files/templates/'.$template->image) }}" border="0" width="50" class="img-rounded" align="center" /></td>
                                <td>{{$template->product_type}}</td>

                                <td>
                                    @if( $template->Status == true )
                                        <a class="badge bg-success text-light">Active</a>
                                    @else
                                        <a class="badge bg-danger text-light">InActive</a>
                                    @endif
                                </td>

                                <td>
                                    <div class="action__buttons justify-content-center">
                                        <a href="{{route('admin.template.edit', ['id' => $template->id ])}}" class="btn-action"><i class="fa-solid fa-arrow-pointer"></i> Change Status</a>
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
