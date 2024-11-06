@extends('admin.master', ['menu' => 'products', 'submenu' => 'product'])
@section('title', isset($title) ? $title : '')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="breadcrumb__content">
                <div class="breadcrumb__content__left">
                    <div class="breadcrumb__title">
                        <h2>{{__('Add Product')}}</h2>
                    </div>
                </div>
                <div class="breadcrumb__content__right">
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('Home')}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{__('Product')}}</li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="gallery__area bg-style">
                <div class="gallery__content">
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-one" role="tabpanel" aria-labelledby="nav-one-tab">
                            <form enctype="multipart/form-data" method="POST" action="{{route('admin.product.store')}}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-vertical__item bg-style">
                                            <div class="item-top mb-30">
                                                <h2>{{langString('en', false).':'}}</h2>
                                            </div>
                                            <input type="hidden" name="product_type" value="{{PRODUCT_PHYSICAL}}">
                                            <div class="input__group mb-25">
                                                <label for="en-product-name">{{ __('Product Name')}}</label>
                                                <input type="text" class="form-control" id="en-product-name" name="en_product_name">
                                            </div>
                                            <div class="input__group mb-25">
                                                <label for="en-product-slug">{{ __('Product Slug')}}</label>
                                                <input type="text" class="form-control" id="en-product-slug" name="en_product_slug">
                                            </div>
                                            <div class="input__group mb-25">
                                                <label for="exampleInputEmail1">{{ __('Brand Name')}}</label>
                                                <select class="form-control" id="en_brand_name" name="en_brand_name">
                                                    <option>{{__('---Select item---')}}</option>
                                                    @foreach(Brnad() as $item)
                                                        <option value="{{$item->id}}">{{$item->en_BrandName}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="input__group mb-25">
                                                <label for="exampleInputEmail1">{{ __('Category Name')}}</label>
                                                <select class="form-control" id="en_category_name" name="en_category_name" onchange="createInputField()">
                                                    <option>{{__('---Select item---')}}</option>
                                                    @foreach(ParentCategory() as $item)
                                                        <option value="{{$item->id}}" data-category="{{$item->en_Category_Name}}">{{$item->en_Category_Name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div id="inputFieldContainer" class="input__group mb-25">

                                            </div>

                                            <div class="input__group mb-25" >
                                                <label for="exampleInputEmail1">{{ __('Item Tag')}}</label>
                                                <select class="form-control" id="item_teg" name="item_teg">
                                                    <option>{{__('---Select item---')}}</option>
                                                    @foreach ($item_tags as $it)
                                                        <option value="{{$it->name}}">{{$it->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="input__group mb-25">
                                                <label for="select2Multiple">{{ __('Product Tag')}}</label>
                                                <select class="select2-multiple form-control tag_two" name="product_tag[]" multiple="multiple">
                                                    @foreach($tags as $tag)
                                                        <option value="{{$tag->name}}" >{{$tag->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>


                                            <div class="input__group mb-25">
                                                <label for="select2Multiple">{{ __('Product Color')}}</label>
                                                <select class="select2-multiple form-control tag_two" name="color[]" multiple="multiple">
                                                    @foreach(productColor() as $item)
                                                        <option value="{{$item->id}}">{{$item->Name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- all product sizes and qty start -->
                                            <div>
                                                <input type="checkbox"   id="select-all-checkbox"><span class="text-dark"> Select All</span>
                                            </div>


                                            <div class="input__group mb-25">
                                                <div class="custom-control custom-switch">
                                                    @foreach(productSize() as $item)
                                                        <input type="checkbox" value="{{$item->id}}" name="{{$item->Size}}" class="checkbox custom-control-input"><span class="text-dark"> {{$item->Size}}</span>
                                                    @endforeach
                                                </div>
                                            </div>

                                            <div id="inputContainer" class="input__group mb-25"></div>

                                            <div class="input__group mb-25">
                                                <label for="exampleInputEmail1">{{ __('Price')}}</label>
                                                <input type="text" class="form-control" id="price" name="price">
                                            </div>

                                            <div class="input__group mb-25">
                                                <label for="exampleInputEmail1">Commission</label>
                                                <input type="text" class="form-control" id="commission" value='25' name="commission">
                                            </div>
                                            <div class="input__group mb-25">
                                                <label for="exampleInputEmail1">Commission Price</label>
                                                <input type="text" class="form-control" id="commission_price" name="commission_price" readonly>
                                            </div>

                                            <div class="input__group mb-25">
                                                <label for="exampleInputEmail1">{{ __('Discount')}}</label>
                                                <input type="text" class="form-control" id="discount" name="discount">
                                            </div>
                                            <div class="input__group mb-25">
                                                <label for="exampleInputEmail1">{{ __('Discount Price')}}</label>
                                                <input type="text" class="form-control" id="discount_price" name="discount_price" readonly>
                                            </div>

                                            <div class="input__group mb-25">
                                                <label for="exampleInputEmail1">{{ __('About')}}</label>
                                                <textarea name="en_about" id="en_about" class="form-control"></textarea>
                                            </div>


                                            <div class="input__group mb-25">
                                                <label for="exampleInputEmail1">{{ __('Description')}}</label>
                                                <textarea name="en_description" id="en_description" class="form-control summernote"></textarea>
                                            </div>

                                            <div class="input__group mb-25">
                                                <label for="exampleInputEmail1">{{ __('ShippingReturn')}}</label>
                                                <textarea name="en_shippingreturn" id="en_shippingreturn" class="form-control summernote"></textarea>
                                            </div>
                                            <div class="input__group mb-25">
                                                <label for="exampleInputEmail1">{{ __('AdditionalInformation')}}</label>
                                                <textarea name="en_additionalinformation" id="en_additionalinformation" class="form-control summernote"></textarea>
                                            </div>
                                            <div class="input__group mb-25">
                                                <label for="exampleInputEmail1">{{ __('Primary Image')}}</label>
                                                <input type="file" class="form-control putImage1"  name="primary_image" id="primary_image">
                                                <img   src="" id="target1"/>
                                            </div>
                                            <div class="input__group mb-25">
                                                <label for="exampleInputEmail1">{{ __('Image 2')}}</label>
                                                <input type="file" class="form-control putImage2"  name="image_two" id="image_two">
                                                <img   src="" id="target2"/>
                                            </div>
                                            <div class="input__group mb-25">
                                                <label for="exampleInputEmail1">{{ __('Image Gallery Image')}}</label>
                                                <input type="file" class="form-control putImage3"  name="image_three" id="image_three">
                                                <img   src="" id="target3"/>
                                            </div>
                                            <div class="input__group mb-25">
                                                <label for="exampleInputEmail1">{{ __('Image 3')}}</label>
                                                <input type="file" class="form-control putImage4"  name="image_four" id="image_four">
                                                <img   src="" id="target4"/>
                                            </div>
                                            <div class="input__group mb-25">
                                                <label for="exampleInputEmail1">{{ __('Image 4')}}</label>
                                                <input type="file" class="form-control putImage5"  name="image_five" id="image_five">
                                                <img   src="" id="target5"/>
                                            </div>

                                            <div class="input__group mb-25">
                                                <label for="exampleInputEmail1">--  Product Image for Design  -- </label>
                                                <input type="file" class="form-control putImage6"  name="design_image" id="design_image">
                                                <img   src="" id="target6"/>
                                            </div>

                                            <div class="input__group mb-25">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox"  value="1" name="status" class="custom-control-input" id="customSwitch1">
                                                    <label class="custom-control-label" for="customSwitch1">{{__('Status')}}</label>
                                                </div>
                                            </div>
                                            <div class="input__group mb-25">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" value="1" name="feature" class="custom-control-input" id="customSwitch2">
                                                    <label class="custom-control-label" for="customSwitch2">{{__('Featured Product')}}</label>
                                                </div>
                                            </div>
                                            <div class="input__group mb-25">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" value="1" name="best_sale" class="custom-control-input" id="customSwitch3">
                                                    <label class="custom-control-label" for="customSwitch3">{{__('Best Selling')}}</label>
                                                </div>
                                            </div>
                                            <div class="input__group mb-25">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" value="1" name="on_sale" class="custom-control-input" id="customSwitch4">
                                                    <label class="custom-control-label" for="customSwitch4">{{__('On Sale')}}</label>
                                                </div>
                                            </div>
                                            <div class="input__group mb-25">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" value="1" name="on_arrival" class="custom-control-input" id="customSwitch5">
                                                    <label class="custom-control-label" for="customSwitch5">{{__('New Arrival')}}</label>
                                                </div>
                                            </div>
                                            <div class="input__button">
                                                <button type="submit" class="btn btn-blue">{{ __('Add')}}</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-vertical__item bg-style">
                                            <div class="item-top mb-30">
                                                <h2>{{langString('fr', false).':'}}</h2>
                                            </div>
                                            <div class="input__group mb-25">
                                                <label for="fr-product-name">{{ __('Product Name')}}</label>
                                                <input type="text" class="form-control" id="fr-product-name" name="fr_product_name">
                                            </div>
                                            <div class="input__group mb-25">
                                                <label for="fr-product-slug">{{ __('Product Slug')}}</label>
                                                <input type="text" class="form-control" id="fr-product-slug" name="fr_product_slug">
                                            </div>
                                            <div class="input__group mb-25">
                                                <label for="exampleInputEmail1">{{ __('About')}}</label>
                                                <textarea name="fr_about" id="fr_about" class="form-control"></textarea>
                                            </div>
                                            <div class="input__group mb-25">
                                                <label for="exampleInputEmail1">{{ __('Description')}}</label>
                                                <textarea name="fr_description" id="fr_description" class="form-control summernote"></textarea>
                                            </div>

                                            <div class="input__group mb-25">
                                                <label for="exampleInputEmail1">{{ __('ShippingReturn')}}</label>
                                                <textarea name="fr_shippingreturn" id="fr_shippingreturn" class="form-control summernote"></textarea>
                                            </div>
                                            <div class="input__group mb-25">
                                                <label for="exampleInputEmail1">{{ __('AdditionalInformation')}}</label>
                                                <textarea name="fr_additionalinformation" id="fr_additionalinformation" class="form-control summernote"></textarea>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @push('post_scripts')
        <script src="{{asset('backend/js/admin/products/physical-add.js')}}"></script>
    @endpush
    @push('post_scripts')
        <!-- script for create input field qty when click checkbox size start -->

        <script>
            // Get the checkboxes and the input container
            var checkboxes = document.getElementsByClassName('checkbox');
            var selectAllCheckbox = document.getElementById('select-all-checkbox');
            var inputContainer = document.getElementById('inputContainer');

            // Add event listener to select all checkbox
            selectAllCheckbox.addEventListener('change', function() {
                // Clear previous inputs
                inputContainer.innerHTML = '';

                // Get selected status of the select all checkbox
                var selectAllChecked = selectAllCheckbox.checked;

                // Set checked status for all checkboxes
                Array.from(checkboxes).forEach(function(checkbox) {
                    checkbox.checked = selectAllChecked;
                });

                // Create input fields for selected checkboxes
                if (selectAllChecked) {
                    Array.from(checkboxes).forEach(function(checkbox) {
                        var input = document.createElement('input');
                        input.type = 'number';
                        input.placeholder = checkbox.name +' Quantity';
                        input.name = 'qtybysize['+checkbox.value+']'; // Use an array-like name for each input
                        inputContainer.appendChild(input);

                    });
                }
            });

            // Add event listener to checkboxes
            Array.from(checkboxes).forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    // Clear previous inputs
                    inputContainer.innerHTML = '';

                    // Get selected checkboxes
                    var selectedCheckboxes = Array.from(checkboxes).filter(function(checkbox) {
                        return checkbox.checked;
                    });
                    // Create input fields for selected checkboxes
                    selectedCheckboxes.forEach(function(checkbox) {
                        var input = document.createElement('input');

                        input.type = 'number';
                        input.name = 'qtybysize['+checkbox.value+']'; // Use an array-like name for each input
                        input.placeholder = checkbox.name +' Quantity';
                        inputContainer.appendChild(input);
                    });

                    // Update select all checkbox status
                    selectAllCheckbox.checked = selectedCheckboxes.length === checkboxes.length;
                });
            });

            function createInputField() {

                var templates = @php echo json_encode(Template()); @endphp;

                var category = document.getElementById('en_category_name').value;
                var selectedOption = document.getElementById('en_category_name').options[document.getElementById('en_category_name').selectedIndex];
                var dataCategory = selectedOption.getAttribute('data-category');
                var inputFieldContainer = document.getElementById('inputFieldContainer');

                // Clear the container
                inputFieldContainer.innerHTML = '';

                if (dataCategory === 'Clothing') {

                    var selectField = document.createElement('select');
                    selectField.name = 'clothing_type';
                    // Iterate through the jsonData and create options for each item
                    templates.forEach(function(item) {
                        var option = document.createElement('option');
                        option.value = item.id; // Set the value of the option to the product_type
                        option.setAttribute('style', 'margin: 2px');
                        option.text = item.product_type; // Display the product_type text in the option
                        selectField.appendChild(option); // Append the option to the select element
                    });

                    inputFieldContainer.appendChild(selectField);
                }
                getChildCategories(category);

                // Function to get child categories using AJAX
                function getChildCategories(category) {
                    fetch(`/admin/category/child/${category}`)
                        .then(response => response.json())
                        .then(data => {

                            if(data !== null && data.length > 0){
                                var selectField = document.createElement('select');
                                selectField.name = 'child_category';

                                data.forEach(function(item) {
                                    var option = document.createElement('option');
                                    option.value = item.id;
                                    option.setAttribute('style', 'margin: 2px');
                                    option.text = item.en_Category_Name; // Display the product_type text in the option
                                    selectField.appendChild(option); // Append the option to the select element
                                });

                                inputFieldContainer.appendChild(selectField);
                            }

                        })
                        .catch(error => console.error(error));
                }
            }

        </script>

        <!-- script for create input field qty when click checkbox size end   -->
    @endpush
@endsection

