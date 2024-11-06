@extends('admin.master', ['menu' => 'api_access', 'submenu' => 'create-api'])
@section('title', isset($title) ? $title : '')
@section('content')

    <div>
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800 text-light">Assign API</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="{{route('admin.dashboard')}}">{{ __('Home')}}</a></li>
                <li class="breadcrumb-item text-light" aria-current="page">Assign API</li>
            </ol>
        </div>
        <div>
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <!-- Form Basic -->

                    <div class="card mb-4">
                        <div class="tab-content slider-page-form" id="pills-tabContent">
                            <div class="card-header mb-2 py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-dark">API information</h6>
                            </div>
                            <div class="card-body mb-5">
                                <form enctype="multipart/form-data" id="myForm" method="POST" action="{{route('admin.apiaccess.store')}}">
                                    @csrf

                                    <div class="tab-pane mb-3 fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">

                                        <div class="input__group mb-25">
                                            <label for="exampleInputEmail1">Select API</label>
                                            <select class="form-control" id="en_brand_name" name="slug">
                                                <option>{{__('---Select item---')}}</option>
                                                <option value="product">Products</option>
                                                <option value="order">Orders</option>
                                                <option value="sale">Sales</option>
                                                <option value="stock">Stock</option>
                                                <option value="stock">Purchase</option>
                                                <option value="stock">Stock</option>
                                            </select>
                                        </div>

                                        <div class="input__group mb-25">
                                            <label for="fr-product-name">Assign To</label>
                                            <input type="text" class="form-control" placeholder="Company Name, User etc" id="fr-product-name" name="assign">
                                        </div>

                                        <label class="mb-2 text-dark" for="randomStringInputkey">API Key</label>
                                        <div class=" input-group mb-3">
                                            <input type="text" class="form-control" name="api_key" id="randomStringInputkey" readonly aria-describedby="generateBtnkey">
                                            <button class="btn btn-light border" id="generateBtnkey"><i class="fa-solid fa-rotate-right"></i></button>
                                        </div>

                                        <label class="mb-2 text-dark" for="randomStringInputsecret">Secret Key</label>
                                        <div class=" input-group mb-3">
                                            <input type="text" class="form-control" name="api_secret" id="randomStringInputsecret" readonly aria-describedby="generateBtnsecret">
                                            <button class="btn btn-light border" id="generateBtnsecret"><i class="fa-solid fa-rotate-right"></i></button>
                                        </div>

                                        <button type="submit" class="btn btn-primary mt-3">Assign</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <script>
            function generateRandomString(length) {
                const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
                let result = "";
                for (let i = 0; i < length; i++) {
                    const randomIndex = Math.floor(Math.random() * charset.length);
                    result += charset.charAt(randomIndex);
                }
                return result;
            }

            document.getElementById("generateBtnkey").addEventListener("click", function(event) {
                event.preventDefault();
                const randomString = generateRandomString(30); // Change the number to adjust the length of the random string
                document.getElementById("randomStringInputkey").value = randomString;
            });

            document.getElementById("generateBtnsecret").addEventListener("click", function(event) {
                event.preventDefault();
                const randomString = generateRandomString(40); // Change the number to adjust the length of the random string
                document.getElementById("randomStringInputsecret").value = randomString;
            });
        </script>




@endsection
