@extends('admin.master', ['menu' => 'products', 'submenu' => 'product'])
@section('title', isset($title) ? $title : '')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="breadcrumb__content">
                <div class="breadcrumb__content__left">
                    <div class="breadcrumb__title">
                        <h2>{{__('Edit Product')}}</h2>
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
                            <form enctype="multipart/form-data" method="POST" action="{{route('admin.product.update')}}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-vertical__item bg-style">
                                            <div class="item-top mb-30">
                                                <h2>{{langString('en', false).':'}}</h2>
                                            </div>
                                            <input type="hidden" name="product_type" value="{{PRODUCT_PHYSICAL}}">
                                            <input type="hidden" name="id" value="{{$product->id}}">
                                            <div class="input__group mb-25">
                                                <label for="exampleInputEmail1">{{ __('Product Name')}}</label>
                                                <input type="text" class="form-control" id="en_product_name" name="en_product_name" value="{{$product->en_Product_Name}}">
                                            </div>
                                            <div class="input__group mb-25">
                                                <label for="exampleInputEmail1">{{ __('Brand Name')}}</label>
                                                <select class="form-control" id="en_brand_name" name="en_brand_name">
                                                    <option value="">{{__('---SELECT A BRAND---')}}</option>
                                                    @foreach(Brnad() as $item)
                                                        <option value="{{$item->id}}" {{$item->id == $product->Brand_Id ? 'selected' : ''}}>{{$item->en_BrandName}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="input__group mb-25">
                                                <label for="exampleInputEmail1">{{ __('Category Name')}}</label>
                                                <select class="form-control" id="en_category_name" name="en_category_name" onchange="createInputField()" >
                                                    <option value="">{{__('---SELECT A CATEGORY---')}}</option>
                                                    @foreach(Category() as $item)
                                                        <option value="{{$item->id}}" @if($item->parent_id != null) ParentId="{{$item->parent_id}}" @endif   data-category="{{$item->en_Category_Name}}" {{$item->id == $product->Category_Id ? 'selected' : ''}} >
                                                            {{$item->en_Category_Name}}
                                                            @if($item->parent_id != null)
                                                                <small title="{{ParentCategoryName($item->parent_id)->en_Category_Name}}">
                                                                    > {{ParentCategoryName($item->parent_id)->en_Category_Name}}
                                                                </small>
                                                            @endif
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div id="inputFieldContainer" class="input__group mb-25">

                                            </div>

                                            <div class="input__group mb-25">
                                                <label for="exampleInputEmail1">{{ __('Item Tag')}}</label>
                                                <select class="form-control" id="item_teg" name="item_teg">
                                                    <option>{{__('---Select item---')}} ></option>
                                                    @foreach ($item_tags as $it)
                                                        <option value="{{$it->name}}" {{$it->name == $product->ItemTag ? 'selected' : ''}}>{{$it->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="input__group mb-25">
                                                <label for="select2Multiple">{{ __('Product Tag')}}</label>
                                                <select class="select2-multiple form-control tag_two" name="product_tag[]" multiple="multiple">
                                                    <option value="">{{__('---SELECT A PRODUCT TAG---')}}</option>
                                                    @foreach($tags as $tag)
                                                        <option value="{{$tag->name}}" {{selectProductTag($tag->name, $product->id)}}>{{$tag->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="input__group mb-25">
                                                <label for="select2Multiple">{{ __('Product Color')}}</label>
                                                <select class="select2-multiple form-control tag_two" name="color[]" multiple="multiple">
                                                    @foreach($colors as $item)
                                                        <option value="{{$item->id}}" {{colorSelected($product->id, $item->id) == 1 ? 'selected' : ''}}>{{$item->Name}}</option >
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- <div class="input__group mb-25">
                                                <label for="select2Multiple">{{ __('Product Size')}}</label>
                                                <select class="select2-multiple form-control tag_one" name="size[]" multiple="multiple">
                                                    @foreach($sizes as $item)
                                                <option value="{{$item->id}}" {{sizeSelected($product->id, $item->id) == 1 ? 'selected' : ''}}>{{$item->Size}}</option >
                                                    @endforeach
                                            </select>
                                        </div>

                                        <div class="input__group mb-25">
                                            <label for="exampleInputEmail1">{{ __('Quantity')}}</label>
                                                <input type="text" class="form-control" id="qty" name="qty" value="{{$product->Quantity}}">
                                            </div> -->
                                            <div class="input__group mb-25">
                                                <div class="custom-control custom-switch">
                                                    @php
                                                        $select_sizes=[];
                                                        $product_stock = productStock($product->id);
                                                    @endphp
                                                    @foreach(productSize() as $item)
                                                        <input type="checkbox" value="{{$item->id}}" name="{{$item->Size}}" class="checkbox custom-control-input"  @if(in_array($item->id, json_decode(productSizeStock($product->id) ))) checked @endif ><span class="text-dark"> {{$item->Size}}</span>
                                                        @if(in_array($item->id, json_decode(productSizeStock($product->id) ))) @php $select_sizes[] = $item->id @endphp @endif
                                                    @endforeach
                                                </div>
                                            </div>

                                            <div id="inputContainer" class="input__group mb-25"></div>


                                            <div class="input__group mb-25">
                                                <label for="exampleInputEmail1">Commission</label>
                                                <input type="text" class="form-control" id="commission" value='0' name="commission">
                                            </div>
                                            <div class="input__group mb-25">
                                                <label for="exampleInputEmail1">Commission Price</label>
                                                <input type="text" class="form-control" id="commission_price" name="commission_price" readonly>
                                            </div>


                                            <div class="input__group mb-25">
                                                <label for="exampleInputEmail1">{{ __('Price')}}</label>
                                                <input type="text" class="form-control" id="price" name="price" value="{{$product->Price}}">
                                            </div>

                                            <div class="input__group mb-25">
                                                <label for="exampleInputEmail1">{{ __('Discount')}}</label>
                                                <input type="text" class="form-control" id="discount" name="discount" value="{{$product->Discount}}">
                                            </div>
                                            <div class="input__group mb-25">
                                                <label for="exampleInputEmail1">{{ __('Discount Price')}}</label>
                                                <input type="text" class="form-control" value="{{$product->Discount_Price}}" id="discount_price" name="discount_price" readonly>
                                            </div>

                                            <div class="input__group mb-25">
                                                <label for="exampleInputEmail1">{{ __('About')}}</label>
                                                <textarea name="en_about" id="en_about" class="form-control">{!! $product->en_About !!}</textarea>
                                            </div>

                                            <div class="input__group mb-25">
                                                <label for="exampleInputEmail1">{{ __('Description')}}</label>
                                                <textarea name="en_description" id="en_description" class="form-control summernote">{!! $product->en_Description !!}</textarea>
                                            </div>

                                            <div class="input__group mb-25">
                                                <label for="exampleInputEmail1">{{ __('ShippingReturn')}}</label>
                                                <textarea name="en_shippingreturn" id="en_shippingreturn" class="form-control summernote">{!! $product->en_ShippingReturn !!}</textarea>
                                            </div>
                                            <div class="input__group mb-25">
                                                <label for="exampleInputEmail1">{{ __('AdditionalInformation')}}</label>
                                                <textarea name="en_additionalinformation" id="en_additionalinformation" class="form-control summernote">{!! $product->en_AdditionalInformation !!}</textarea>
                                            </div>
                                            <div class="input__group mb-25">
                                                <label for="exampleInputEmail1">{{ __('Primary Image')}}</label>
                                                <input type="file" class="form-control putImage1"  name="primary_image" id="primary_image">
                                                <img class="admin_image"  src="{{asset(ProductImage().$product->Primary_Image)}}" id="target1"/>
                                            </div>
                                            <div class="input__group mb-25">
                                                <label for="exampleInputEmail1">{{ __('Image 2')}}</label>
                                                <input type="file" class="form-control putImage2"  name="image_two" id="image_two">
                                                <img   class="admin_image"  src="{{asset(ProductImage().$product->Image2)}}" id="target2"/>
                                            </div>
                                            <div class="input__group mb-25">
                                                <label for="exampleInputEmail1">{{ __('Image Gallery Image')}}</label>
                                                <input type="file" class="form-control putImage3"  name="image_three" id="image_three">
                                                <img   class="admin_image"  src="{{asset(ProductImage().$product->Image3)}}" id="target3"/>
                                            </div>
                                            <div class="input__group mb-25">
                                                <label for="exampleInputEmail1">{{ __('Image 3')}}</label>
                                                <input type="file" class="form-control putImage4"  name="image_four" id="image_four">
                                                <img   class="admin_image"  src="{{asset(ProductImage().$product->Image4)}}" id="target4"/>
                                            </div>
                                            <div class="input__group mb-25">
                                                <label for="exampleInputEmail1">{{ __('Image 4')}}</label>
                                                <input type="file" class="form-control putImage5"  name="image_five" id="image_five">
                                                <img   class="admin_image"  src="{{asset(ProductImage().$product->Image5)}}" id="target5"/>
                                            </div>

                                            <div class="input__group mb-25">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox"  value="1" {{$product->Status == 1 ? 'checked' : ''}} name="status" class="custom-control-input" id="customSwitch1">
                                                    <label class="custom-control-label" for="customSwitch1">{{ __('Status')}}</label>
                                                </div>
                                            </div>
                                            <div class="input__group mb-25">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" value="1" {{$product->Featured_Product == 1 ? 'checked' : ''}} name="feature" class="custom-control-input" id="customSwitch2">
                                                    <label class="custom-control-label" for="customSwitch2">{{ __('Featured Product')}}</label>
                                                </div>
                                            </div>
                                            <div class="input__group mb-25">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" value="1" {{$product->Best_Selling == 1 ? 'checked' : ''}} name="best_sale" class="custom-control-input" id="customSwitch3">
                                                    <label class="custom-control-label" for="customSwitch3">{{ __('Best Selling')}}</label>
                                                </div>
                                            </div>
                                            <div class="input__group mb-25">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" value="1" {{$product->On_Sale == 1 ? 'checked' : ''}} name="on_sale" class="custom-control-input" id="customSwitch4">
                                                    <label class="custom-control-label" for="customSwitch4">{{ __('On Sale')}}</label>
                                                </div>
                                            </div>
                                            <div class="input__group mb-25">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" value="1" {{$product->New_Arrival == 1 ? 'checked' : ''}} name="on_arrival" class="custom-control-input" id="customSwitch5">
                                                    <label class="custom-control-label" for="customSwitch5">{{ __('New Arrival')}}</label>
                                                </div>
                                            </div>
                                            <div class="input__button">
                                                <button type="submit" class="btn btn-blue">{{ __('Update')}}</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-vertical__item bg-style">
                                            <div class="item-top mb-30">
                                                <h2>{{langString('fr', false).':'}}</h2>
                                            </div>
                                            <div class="input__group mb-25">
                                                <label for="exampleInputEmail1">{{ __('Product Name')}}</label>
                                                <input type="text" class="form-control" id="fr_product_name" value="{{$product->fr_Product_Name}}" name="fr_product_name">
                                            </div>
                                            <div class="input__group mb-25">
                                                <label for="exampleInputEmail1">{{ __('About')}}</label>
                                                <textarea name="fr_about" id="fr_about" class="form-control">{!! $product->fr_About !!}</textarea>
                                            </div>
                                            <div class="input__group mb-25">
                                                <label for="exampleInputEmail1">{{ __('Description')}}</label>
                                                <textarea name="fr_description" id="fr_description" class="form-control summernote">{!! $product->fr_Description !!}</textarea>
                                            </div>
                                            <div class="input__group mb-25">
                                                <label for="exampleInputEmail1">{{ __('ShippingReturn')}}</label>
                                                <textarea name="fr_shippingreturn" id="fr_shippingreturn" class="form-control summernote">{!! $product->fr_ShippingReturn !!}</textarea>
                                            </div>
                                            <div class="input__group mb-25">
                                                <label for="exampleInputEmail1">{{ __('AdditionalInformation')}}</label>
                                                <textarea name="fr_additionalinformation" id="fr_additionalinformation" class="form-control summernote">{!! $product->fr_AdditionalInformation !!}</textarea>
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
        <script src="{{asset('backend/js/admin/products/physical-edit.js')}}"></script>

        <script>

            var ProductStock = @php echo json_encode($product_stock); @endphp;
            var checkboxes = document.getElementsByClassName('checkbox');
            var selectAllCheckbox = document.getElementById('select-all-checkbox');
            var inputContainer = document.getElementById('inputContainer');

            // Function to find the product stock quantity based on size_id
            function findStockQuantity(sizeId) {
                var foundStock = ProductStock.find(function(item) {
                    return item.size_id === sizeId;
                });

                return foundStock ? foundStock.quantity : '';
            }

            // Function to create input fields for selected checkboxes
            function createInputFields() {
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
                    input.name = 'qtybysize[' + checkbox.value + ']';
                    input.placeholder = checkbox.name + ' Quantity';
                    input.value = findStockQuantity(parseInt(checkbox.value)); // Set the input value based on the stock data
                    inputContainer.appendChild(input);
                });
            }

            // Create input fields for initially checked checkboxes
            createInputFields();

            // Event listener for checkboxes
            Array.from(checkboxes).forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    createInputFields();
                });
            });

            // // Event listener for select all checkbox
            // selectAllCheckbox.addEventListener('change', function() {
            //     Array.from(checkboxes).forEach(function(checkbox) {
            //         checkbox.checked = selectAllCheckbox.checked;
            //     });
            //     createInputFields();
            // });

            // size by quantity  end



            var category = document.getElementById('en_category_name').value;
            if(category){
                createInputField();
                function createInputField() {
                    var templates = @php echo json_encode(Template()); @endphp;
                    var SelectedTemplate = @php echo json_encode(TemplateDesign($product->clothing_type)); @endphp;
                    var category = document.getElementById('en_category_name').value;
                    var selectedOption = document.getElementById('en_category_name').options[document.getElementById('en_category_name').selectedIndex];
                    var dataCategory = selectedOption.getAttribute('data-category');
                    var inputFieldContainer = document.getElementById('inputFieldContainer');

                    var ParentId = selectedOption.getAttribute('ParentId');

                    // Clear the container
                    inputFieldContainer.innerHTML = '';

                    if (dataCategory === 'Clothing' || ParentId == 6) {

                        var selectField = document.createElement('select');
                        selectField.name = 'clothing_type';
                        // Iterate through the jsonData and create options for each item
                        templates.forEach(function(item) {
                            var option = document.createElement('option');
                            option.value = item.id; // Set the value of the option to the product_type
                            option.setAttribute('style', 'margin: 2px');
                            option.text = item.product_type; // Display the product_type text in the option

                            // // Check if the current item is the selected option
                            if (SelectedTemplate && item.id === SelectedTemplate.id) {
                                option.selected = true; // Set the selected attribute for the selected option
                            }

                            selectField.appendChild(option); // Append the option to the select element
                        });

                        inputFieldContainer.appendChild(selectField);
                    }

                }
            }
        </script>

    @endpush
@endsection
