@extends('admin.master', ['menu' => 'stock'])
@section('title', isset($title) ? $title : '')
@section('content')

    <div>
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800 text-light">{{ __('Edit Product')}}</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="{{route('admin.dashboard')}}">{{ __('Home')}}</a></li>
                <li class="breadcrumb-item text-light" aria-current="page">{{ __('Product Edit')}}</li>
            </ol>
        </div> 
        <div>
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <!-- Form Basic -->

                    <div class="card mb-4">
                        <div class="tab-content slider-page-form" id="pills-tabContent">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-dark">{{$product->en_Product_Name}}</h6>
                            </div>
                            <div class="card-body ">
                                <form enctype="multipart/form-data" method="POST" action="{{route('admin.stock.update')}}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$product->id}}">
                                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                        
                                        @foreach($stock as $item)
                                        <div class="input-group input-group-sm mb-3">
                                            <span class="input-group-text" id="inputGroup-sizing-sm">{{$item->sizes[0]['Size']}}</span>
                                            <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name="{{$item->id}}" value="{{$item->quantity}}">
                                        </div>
                                        @endforeach


                                        <button type="submit" class="btn btn-primary mt-3">{{ __('Update')}}</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection
