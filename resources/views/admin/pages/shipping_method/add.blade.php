@extends('admin.master', ['menu' => 'products', 'submenu' => 'product-template'])
@section('title', isset($title) ? $title : '')
@section('content')

    <div>
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800 text-light">Add New Method</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="{{route('admin.dashboard')}}">{{ __('Home')}}</a></li>
                <li class="breadcrumb-item text-light" aria-current="page">Add Method</li>
            </ol>
        </div>
        <div>
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <!-- Form Basic -->

                    <div class="card mb-4">
                        <div class="tab-content slider-page-form" id="pills-tabContent">
                            <div class="card-header mb-2 py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-dark">Method information</h6>
                            </div>
                            <div class="card-body mb-5">
                                <form enctype="multipart/form-data" method="POST" action="{{route('admin.method.store')}}">
                                    @csrf

                                    <div class="tab-pane mb-3 fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">

                                        <div class="input__group mb-25">
                                            <label for="fr-product-name">Name</label>
                                            <input type="text" class="form-control" id="fr-product-name" name="name">
                                        </div>

                                        <div class="input__group mb-25">
                                            <label for="fr-product-name">Tracking URL</label>
                                            <input type="text" class="form-control" id="fr-product-name" name="url">
                                        </div>

                                        <div class="input__group mb-25">
                                            <label for="exampleInputEmail1">Logo Image</label>
                                            <input type="file" class="form-control putImage1"  name="image" id="primary_image">
                                            <img   src="" id="target1"/>
                                        </div>

                                        <button type="submit" class="btn btn-primary mt-3">{{ __('Add')}}</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

@endsection
