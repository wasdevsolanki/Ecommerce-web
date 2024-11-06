@extends('front.layouts.master')
@section('title', isset($title) ? $title : 'Home')
@section('description', isset($description) ? $description : '')
@section('keywords', isset($keywords) ? $keywords : '')
@section('content')


    <div class="slider-container">

        @php $i=1;  @endphp
        @foreach($sliders as $slider)
            <img src="{{asset(SliderImage().$slider->Background_Image)}}" alt="Slide {{$i}}">
        @endforeach
    </div>

    <div class="brads-area pt-3 pb-0">
        <div class="slider-controls">
            <!-- Dots will be dynamically added here -->
        </div>
    </div>
    <!-- hero-section area end here  -->

    <!-- brads area start here  -->
    <div class="brads-area">
        <div class="container">
            <div class="brads-slide">
                @foreach($brands as $brand)
                    <div class="sigle-brad">
                        <img src="{{asset(BrandImage().$brand->BrandImage)}}" alt="brad image" style="transition: transform 0.3s ease;" onmouseover="this.style.transform='scale(1.2)';" onmouseout="this.style.transform='scale(1)';" />
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- brads area start here  -->

    <!-- Popular Categories area start here  -->
    <div class="popular-categories-area section-bg section-top pb-30">
        <div class="container">
            <div class="section-header-area">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="sub-title">{{langConverter(siteContentHomePage('many_goods')->en_Title,siteContentHomePage('many_goods')->fr_Title)}}</h3>
                        <h2 class="section-title">{{langConverter(siteContentHomePage('many_goods')->en_Description_One,siteContentHomePage('many_goods')->fr_Description_One)}}</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                @foreach(Category_Des_Icon() as $item)
                    <div class="col-lg-6 col-md-6">
                        <a class="single-categorie" href="{{route('category.product.find',$item->en_Category_Name)}}">
                            <div class="categorie-wrap">
                                <div class="categorie-icon">
                                    <i class="{{$item->Category_Icon}}"></i>
                                </div>
                                <div class="categorie-info">
                                    <h3 class="categorie-name">{{langConverter($item->en_Category_Name,$item->fr_Category_Name)}}</h3>
                                    <h4 class="categorie-subtitle">{{ langConverter($item->en_Description,$item->fr_Description) }}</h4>
                                </div>
                            </div>
                            <i class="arrow flaticon-right-arrow"></i>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Featured Products area start here  -->
    <div class="featured-productss-area section-top pb-30">
        <div class="container">
            <div class="section-header-area">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="sub-title">{{langConverter(siteContentHomePage('products')->en_Title,siteContentHomePage('products')->fr_Title)}}</h3>
                        <h2 class="section-title">{{langConverter(siteContentHomePage('products')->en_Description_One,siteContentHomePage('products')->fr_Description_One)}}</h2>
                    </div>
                    <div class="col-md-6 align-self-end text-md-end">
                        <a href="{{route('all.product')}}" class="see-btn">{{__('See All')}}</a>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach($products->take(6) as $product)
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <div class="single-grid-product">
                            <div class="product-top">
                                <a href="{{route('single.product',$product->en_Product_Slug)}}"><img class="product-thumbnal" src="{{asset(ProductImage().$product->Primary_Image)}}" alt="{{__('product')}}" /></a>
                                <div class="product-flags">
                                    @if($product->ItemTag)
                                        <span class="product-flag sale">{{$product->ItemTag}}</span>
                                    @endif
                                    @if($product->Discount && $product->Discount > 0 )
                                        <span class="product-flag discount">{{ __('-')}}{{$product->Discount}}</span>
                                    @endif
                                </div>

                            </div>
                            <div class="product-info text-center">
                                @foreach($product->product_tags as $ppt)
                                    <h4 class="product-catagory">{{$ppt->tag}}</h4>
                                @endforeach
                                <input type="hidden" name="quantity" value="1" id="product_quantity">
                                <h3 class="product-name"><a class="product-link" href="{{route('single.product',$product->en_Product_Slug)}}">{{langConverter($product->en_Product_Name,$product->fr_Product_Name)}}</a></h3>
                                <!-- This is server side code. User can not modify it. -->
                                {!!  productReview($product->id) !!}
                                <div class="product-price">
                                    @if($product->Discount > 0)
                                        <span class="regular-price">{{currencySymbol()[currency()]}}{{currencyConverter($product->Price)}}</span>
                                    @endif
                                    <span class="price">{{currencySymbol()[currency()]}}{{currencyConverter($product->Discount_Price)}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
    <!-- Featured Products area end here  -->


    <!-- Clothing Product area end   -->
    <div class="trending-products-area section-top section-bg pb-100">
        <div class="container">
            <div class="section-header-area">
                <div class="row">
                    <div class="col-lg-4">
                        <h3 class="sub-title">{{langConverter(siteContentHomePage('popular_products')->en_Title,siteContentHomePage('popular_products')->fr_Title)}}</h3>
                        <h2 class="section-title">Clothing Products</h2>
                    </div>
                    <label class="col-lg-4 d-flex align-item-center justify-content-end fs-3" for="BrandSelect">Select Brand</label>
                    <div class="col-lg-4  align-items-center">
                        <div class="primary-tabs">

                            <div class="form-group">
                                <!-- <label for="BrandSelect">Select Category:</label> -->
                                <select class="form-select form-select-lg" id="BrandSelect">
                                    <option value="99">Select an option</option>
                                    @foreach(BrandCloth() as $item)
                                        <option value="{{$item->id}}" name="brand_id">{{$item->en_BrandName}}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div id="TrendingProductsContent">
                <div class="row" id="brand-products">

                </div>
            </div>

        </div>

    </div>
    <!-- Clothing Products area end here  -->


    <!-- Beauty Product area start -->

    <!-- Clothing Product area end   -->
    <div class="trending-products-area section-top pb-100">
        <div class="container">
            <div class="section-header-area">
                <div class="row">
                    <div class="col-lg-4">
                        <h3 class="sub-title">{{langConverter(siteContentHomePage('popular_products')->en_Title,siteContentHomePage('popular_products')->fr_Title)}}</h3>
                        <h2 class="section-title">Beauty Products</h2>
                    </div>
                    <label class="col-lg-4 d-flex align-item-center justify-content-end fs-3" for="BrandBeautySelect">Select Brand</label>
                    <div class="col-lg-4  align-items-center">
                        <div class="primary-tabs">

                            <div class="form-group">
                                <!-- <label for="BrandSelect">Select Category:</label> -->
                                <select class="form-select form-select-lg" id="BrandBeautySelect">
                                    <option value="99">Select an option</option>
                                    @foreach(BrandBeauty() as $item)
                                        <option value="{{$item->id}}" name="brand_id">{{$item->en_BrandName}}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div id="TrendingProductsContent">
                <div class="row" id="brand-beauty-products">

                </div>
            </div>

        </div>

    </div>
    <!-- Clothing Products area end here  -->

    <!-- Pet Supplies Product area end   -->
    <div class="trending-products-area section-top pb-100">
        <div class="container">
            <div class="section-header-area">
                <div class="row">
                    <div class="col-lg-4">
                        <h3 class="sub-title">{{langConverter(siteContentHomePage('popular_products')->en_Title,siteContentHomePage('popular_products')->fr_Title)}}</h3>
                        <h2 class="section-title">Pet Supplies</h2>
                    </div>
                    <label class="col-lg-4 d-flex align-item-center justify-content-end fs-3" for="BrandBeautySelect">Select Brand</label>
                    <div class="col-lg-4  align-items-center">
                        <div class="primary-tabs">

                            <div class="form-group">

                                <select class="form-select form-select-lg" id="BrandPetSelect">
                                    <option value="defaultPetId">All</option>
                                    @php $petBrands = []; @endphp
                                    @foreach(PetSupplies() as $item)
                                        <option value="{{$item->id}}" name="brand_id">{{$item->en_BrandName}}</option>
                                        @php $petBrands [] = $item->id; @endphp
                                    @endforeach
                                </select>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div id="TrendingProductsContent">
                <div class="row" id="brand-pet-products">

                </div>
            </div>
        </div>
    </div>
    <!-- Pet Supplies Products area end here  -->


    <!-- product banenr area start here  -->
    <div class="product-banner pb-100">
        <div class="container">
            <div class="row">
                @foreach($promotion as $promo)
                    <div class="col-md-5">
                        <a href="#" class="single-banner"><img class="banner-image" src="{{asset(PromotionImage().$promo->Image_One)}}" alt="product-banner" /></a>
                    </div>
                    <div class="col-md-7">
                        <a href="#" class="single-banner"><img class="banner-image" src="{{asset(PromotionImage().$promo->Image_Two)}}" alt="product-banner" /></a>
                    </div>
            </div>
            @endforeach
        </div>
    </div>
    <!-- product banner area end here  -->

    <!-- Testimonial ara start here  -->
    <div class="testimonial-area section section-bg">
        <div class="container">
            <div class="section-header-area text-center">
                <h3 class="sub-title">{{__('Testimonial')}}</h3>
                <h2 class="section-title">{{__('What People Are')}} <br />{{__('Saying About Ourself')}}</h2>
            </div>
            <div class="testimonial-slide-top">

                <!-- Testimonial authors Float Images Start -->
                @foreach ($testimonial as $test)
                    @if ($loop->iteration == 1)
                        <img src="{{asset(IMG_TESTIMONIAL.$test->Image)}}" alt="img" class="testimonial-float-img testimonial-left-1 position-absolute">
                    @elseif ($loop->iteration == 2)
                        <img src="{{asset(IMG_TESTIMONIAL.$test->Image)}}" alt="img" class="testimonial-float-img testimonial-left-2 position-absolute">
                    @elseif ($loop->iteration == 3)
                        <img src="{{asset(IMG_TESTIMONIAL.$test->Image)}}" alt="img" class="testimonial-float-img testimonial-left-3 position-absolute">
                    @elseif ($loop->iteration == 4)
                        <img src="{{asset(IMG_TESTIMONIAL.$test->Image)}}" alt="img" class="testimonial-float-img testimonial-left-4 position-absolute">
                    @elseif ($loop->iteration == 5)
                        <img src="{{asset(IMG_TESTIMONIAL.$test->Image)}}" alt="img" class="testimonial-float-img testimonial-right-1 position-absolute">
                    @elseif ($loop->iteration == 6)
                        <img src="{{asset(IMG_TESTIMONIAL.$test->Image)}}" alt="img" class="testimonial-float-img testimonial-right-2 position-absolute">
                    @elseif ($loop->iteration == 7)
                        <img src="{{asset(IMG_TESTIMONIAL.$test->Image)}}" alt="img" class="testimonial-float-img testimonial-right-3 position-absolute">
                    @elseif ($loop->iteration == 8)
                        <img src="{{asset(IMG_TESTIMONIAL.$test->Image)}}" alt="img" class="testimonial-float-img testimonial-right-4 position-absolute">
                    @endif
                @endforeach
                <!-- Testimonial authors Float Images End -->

                <img class="shape-image" src="{{asset('frontend/assets/images/shape.png')}}" alt="shape" />
                <div class="testimonial-image-slide">
                    @foreach ($testimonial as $test)
                        <div class="signle-testimonial-image"><img class="testimonial-image" src="{{asset(IMG_TESTIMONIAL.$test->Image)}}" alt="testimonal-image" /></div>
                    @endforeach
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="testimonail-slide">
                        @foreach ($testimonial as $test)
                            <div class="single-testimonial">
                                <p class="testimonial-text">{{ langConverter($test->en_Description,$test->fr_Description) }}</p>
                                <h3 class="testimonial-title">{{$test->Name}}</h3>
                                <ul class="review-area">
                                    <li><i class="flaticon-star"></i></li>
                                    <li class="{{$test->star == 1 ? 'inactive' : ''}}"><i class="flaticon-star"></i></li>
                                    <li class="{{$test->star == 1 || $test->star == 2 ? 'inactive' : ''}}"><i class="flaticon-star"></i></li>
                                    <li class="{{$test->star == 1 || $test->star == 2 || $test->star == 3 ? 'inactive' : ''}}"><i class="flaticon-star"></i></li>
                                    <li class="{{$test->star == 1 || $test->star == 2 || $test->star == 3 || $test->star == 4 ? 'inactive' : ''}}"><i class="flaticon-star"></i></li>
                                </ul>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial ara end here  -->
@endsection

@section('subscribe_pop_up_modal')
    @if(!session()->has('dontshoW'))
        <!-- Page Load Popup Modal End -->
        <div class="modal fade bd-example-modal-lg theme-modal" id="popUpModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body modal1 modal-bg">
                        <div class="row">
                            <div class="col-12">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-7 col-md-12">
                                        <div class="offer_modal_left">
                                            <img src="{{asset(IMG_LOGO_PATH.$allsettings['main_logo'])}}" alt="logo">
                                            <h3>{{__('SUBSCRIBE TO NEWSLETTER')}}</h3>
                                            <p class="m-0">{{__('Subscribe to the Malakoff Traders mailing list to receive updates on new arrivals, special offers and our promotions.')}}</p>

                                            <form id="subscribe_form" name="subscribe_form" >
                                                @csrf
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control subscribeModal" name="subscribeval" id="subscribeval" placeholder="{{__('Your email')}}">
                                                    <div class="input-group-append">
                                                        <button class="theme-btn-one btn-black-overlay btn_sm border-0 subscribeModal" id="subscribeModal">
                                                            {{__('Subscribe')}}</button>
                                                    </div>
                                                </div>
                                                <div class="check_boxed_modal">
                                                    <input type="checkbox" id="doNotShowModel" name="dontshowmodal" value="dont_show">
                                                    <label for="vehicle1">{{__("Don't show this popup again")}}</label>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-md-12">
                                        <div class="offer_modal_img d-none d-lg-flex">
                                            <img src="{{asset('/uploaded_files/slider/648824cc7bc081686643916.jpg')}}" alt="img">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- Page Load Popup Modal End -->
    <div id="DoNotSubscribe" data-url="{{ route('do.not.subscribe') }}"></div>
    <div id="SubscribeStore" data-url="{{route('admin.subscribe.store')}}"></div>

    @push('post_script')
        <script>
            // Code by Wasdev DZN Solution --------------------
            $(document).ready(function() {

                $('#BrandSelect').change(function() {
                    var selectedBrand = $(this).val();

                    fetchProducts(selectedBrand);
                });

                // Get the select box element
                var selectBox = document.getElementById("BrandSelect");
                // Get the selected value
                const selectedValue = selectBox.value;

                // Check if the selected value is "default"
                if (selectedValue === "99") {

                    // Get all the options in the select box
                    var options = selectBox.options;

                    // Sort the options in ascending order based on their text
                    var sortedOptions = Array.from(options).sort(function(a, b) {
                        return a.text.localeCompare(b.text);
                    });

                    // Set the value of the select box to the first option (default category)
                    sortedOptions[0].selected = true;

                    // Set your default value for the AJAX request
                    var selectedBrand = sortedOptions[0].value;
                    fetchProducts(selectedBrand);

                }


                function fetchProducts(BrandId) {

                    $.ajax({
                        url: '{{ route("get-products") }}',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        method: 'POST',
                        data: {
                            brand: BrandId
                        },
                        success: function(response) {
                            var resultContainer = $('#brand-products');
                            resultContainer.empty(); // Clear existing content
                            var products = response.brands;

                            products.forEach(function(product) {

                                resultContainer.append('<div class="col-lg-2 col-md-4 col-sm-6"><div class="single-grid-product"><div class="product-top"> <a href="/product/single/'+product.en_Product_Slug+'"><img class="product-thumbnal" src="{{ asset('/uploaded_files/product_image/')}}/'+product.Primary_Image+'" alt=""/></a> <div class="product-flags">    @if('+ product.ItemTag +')<span class="product-flag sale">'+ product.ItemTag + '</span> @endif @if($product->Discount && $product->Discount > 0 ) <span class="product-flag discount">{{ __('-')}}' + product.Discount +'</span> @endif @if(' + product.Discount + ') @endif </div>  </div> <div class="product-info text-center">  @foreach($product->product_tags as $pptn) <h4 class="product-catagory">{{$pptn->tag}}</h4> @endforeach <input type="hidden" name="quantity" value="1" id="product_quantity"> <h3 class="product-name"><a class="product-link" href="{{route('single.product',$product->en_Product_Slug)}}">' + product.en_Product_Name + '</a></h3> <div class="product-price">@if($product->Discount > 0)<span class="regular-price">{{currencySymbol()[currency()]}} ' + product.Price + '</span>@endif<span class="price">{{currencySymbol()[currency()]}} '+ product.Discount_Price + '</span> </div> </div> </div></div>');
                            });

                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        }
                    });
                }
            });

            $(document).ready(function() {

                $('#BrandBeautySelect').change(function() {
                    var selectedBrand = $(this).val();
                    fetchBeautyProducts(selectedBrand);
                });

                // Get the select box element
                var selectBox = document.getElementById("BrandBeautySelect");
                const selectedValue = selectBox.value;

                // Check if the selected value is "default"
                if (selectedValue === "99") {

                    // Get all the options in the select box
                    var options = selectBox.options;

                    // Sort the options in ascending order based on their text
                    var sortedOptions = Array.from(options).sort(function(a, b) {
                        return a.text.localeCompare(b.text);
                    });

                    // Set the value of the select box to the first option (default category)
                    sortedOptions[0].selected = true;

                    // Set your default value for the AJAX request
                    var selectedBrand = sortedOptions[0].value;
                    fetchBeautyProducts(selectedBrand);

                }

                function fetchBeautyProducts(BrandId) {

                    $.ajax({
                        url: '{{ route("get-products") }}',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        method: 'POST',
                        data: {
                            brand: BrandId
                        },
                        success: function(response) {
                            var resultContainer = $('#brand-beauty-products');
                            resultContainer.empty(); // Clear existing content
                            var products = response.brands;

                            products.forEach(function(product) {

                                resultContainer.append('<div class="col-lg-2 col-md-4 col-sm-6"><div class="single-grid-product"><div class="product-top"> <a href="/product/single/'+product.en_Product_Slug+'"><img class="product-thumbnal" src="{{ asset('/uploaded_files/product_image/')}}/'+product.Primary_Image+'" alt=""/></a> <div class="product-flags">    @if('+ product.ItemTag +')<span class="product-flag sale">'+ product.ItemTag + '</span> @endif @if($product->Discount && $product->Discount > 0 ) <span class="product-flag discount">{{ __('-')}}' + product.Discount +'</span> @endif @if(' + product.Discount + ') @endif </div>  </div> <div class="product-info text-center">  @foreach($product->product_tags as $pptn) <h4 class="product-catagory">{{$pptn->tag}}</h4> @endforeach <input type="hidden" name="quantity" value="1" id="product_quantity"> <h3 class="product-name"><a class="product-link" href="{{route('single.product',$product->en_Product_Slug)}}">' + product.en_Product_Name + '</a></h3> <div class="product-price">@if($product->Discount > 0)<span class="regular-price">{{currencySymbol()[currency()]}} ' + product.Price + '</span>@endif<span class="price">{{currencySymbol()[currency()]}} '+ product.Discount_Price + '</span> </div> </div> </div></div>');
                            });

                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        }
                    });
                }
            });

            $(document).ready(function() {

                $('#BrandPetSelect').change(function() {
                    var selectedPetBrand = $(this).val();
                    if( selectedPetBrand == "defaultPetId" ){
                        @php $jsPetBrands = json_encode($petBrands); @endphp
                        var selectedPetBrand = <?php echo $jsPetBrands; ?>;
                    }
                    fetchPetProducts(selectedPetBrand);
                });

                // Get the select box element
                var selectBoxPet = document.getElementById("BrandPetSelect");
                const selectedPetValue = selectBoxPet.value;

                // Check if the selected value is "default"
                if (selectedPetValue === "defaultPetId") {
                    @php $jsPetBrands = json_encode($petBrands); @endphp
                    var Brands = <?php echo $jsPetBrands; ?>;
                    fetchPetProducts(Brands);
                }

                function fetchPetProducts(BrandId) {

                    $.ajax({
                        url: '{{ route("fetch.pet.products") }}',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        method: 'POST',
                        data: {
                            brand: BrandId
                        },
                        success: function(response) {
                            var resultContainer = $('#brand-pet-products');
                            resultContainer.empty();
                            var products = response.brands;

                            products.forEach(function(product) {

                                resultContainer.append('<div class="col-lg-2 col-md-4 col-sm-6"><div class="single-grid-product"><div class="product-top"> <a href="/product/single/'+product.en_Product_Slug+'"><img class="product-thumbnal" src="{{ asset('/uploaded_files/product_image/')}}/'+product.Primary_Image+'" alt=""/></a> <div class="product-flags">    @if('+ product.ItemTag +')<span class="product-flag sale">'+ product.ItemTag + '</span> @endif @if($product->Discount && $product->Discount > 0 ) <span class="product-flag discount">{{ __('-')}}' + product.Discount +'</span> @endif @if(' + product.Discount + ') @endif </div>  </div> <div class="product-info text-center">  @foreach($product->product_tags as $pptn) <h4 class="product-catagory">{{$pptn->tag}}</h4> @endforeach <input type="hidden" name="quantity" value="1" id="product_quantity"> <h3 class="product-name"><a class="product-link" href="{{route('single.product',$product->en_Product_Slug)}}">' + product.en_Product_Name + '</a></h3> <div class="product-price">@if($product->Discount > 0)<span class="regular-price">{{currencySymbol()[currency()]}} ' + product.Price + '</span>@endif<span class="price">{{currencySymbol()[currency()]}} '+ product.Discount_Price + '</span> </div> </div> </div></div>');
                            });

                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        }
                    });
                }
            });
        </script>
    @endpush()
    @php $jsCategories = json_encode($categories); @endphp
    @push('post_script')
        <script>

            var categories = <?php echo $jsCategories; ?>;

            // Function to populate products in the specified category
            function populateProducts(categoryId) {
                var categories = <?php echo $jsCategories; ?>;

                var productsDiv = document.getElementById('product-container');
                var products = categories[categoryId].products;

                var productsHTML = '';
                products.forEach(function(product) {
                    productsHTML += '<div class="col-md-4 mb-2 pl-1 pr-0"><a href="/product/single/'+product.en_Product_Slug+'"><div class="card text-bg-dark"><img src="{{ asset('/uploaded_files/product_image/')}}/'+product.Primary_Image+'" class="card-img" style="height:20vh; object-fit:cover;" alt="..."><div class="card-img-overlay"><h5 class="card-title">' + product.en_Product_Name + '</h5></div></div></a></div>';
                });

                productsDiv.innerHTML = productsHTML;
            }

            // Event listener for category hover
            var categories = document.querySelectorAll('.mega-menu-items');
            categories.forEach(function(category) {
                category.addEventListener('mouseover', function() {
                    var categoryId = this.getAttribute('data-category');
                    populateProducts(categoryId);
                });
            });


            document.addEventListener('DOMContentLoaded', function() {
                const sliderContainer = document.querySelector('.slider-container');
                const slides = Array.from(sliderContainer.querySelectorAll('img'));
                const dotsContainer = document.querySelector('.slider-controls');

                let currentIndex = 0;
                const totalSlides = slides.length;
                let slideInterval;

                function showSlide(index) {
                    currentIndex = (index + totalSlides) % totalSlides;
                    slides.forEach(function(slide, i) {
                        if (i === currentIndex) {
                            slide.classList.add('active');
                        } else {
                            slide.classList.remove('active');
                        }
                    });

                    // Update active dot
                    const dots = Array.from(dotsContainer.querySelectorAll('button'));
                    dots.forEach((dot, i) => {
                        dot.classList.toggle('active', i === currentIndex);
                    });
                }

                function startAutoSlide() {
                    slideInterval = setInterval(function() {
                        currentIndex++;
                        showSlide(currentIndex);
                    }, 7000);
                }

                function stopAutoSlide() {
                    clearInterval(slideInterval);
                }

                // Create dots based on the number of slides
                for (let i = 0; i < totalSlides; i++) {
                    const dot = document.createElement('button');
                    dot.addEventListener('click', function() {
                        // stopAutoSlide();
                        showSlide(i);
                    });
                    dotsContainer.appendChild(dot);
                }

                sliderContainer.addEventListener('mouseenter', stopAutoSlide);
                sliderContainer.addEventListener('mouseleave', startAutoSlide);

                showSlide(currentIndex);
                startAutoSlide();
            });

        </script>
    @endpush()
    @push('post_script')
        <script src="{{asset('frontend/assets/js/pages/home.js')}}"></script>
    @endpush()
@endsection
