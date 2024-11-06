@extends('admin.master', ['menu' => 'stock'])
@section('title', isset($title) ? $title : '')
@section('content')

    <div id="table-url" data-url=""></div>
    <div class="row">
        <div class="col-md-12">
            <div class="breadcrumb__content">
                <div class="breadcrumb__content__left">
                    <div class="breadcrumb__title">
                        <h2>Stock Management</h2>
                    </div> 
                </div>
                <div class="breadcrumb__content__right">
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('Home')}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Stock</li>
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

                        <div class="dataTables_filter">
                            <select name="category_id" id="category_id" class="form-control">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->en_Category_Name }}</option>
                                @endforeach
                            </select>
                        </div>

                    <table id="AdvertiseTable" class="row-border data-table-filter table-style">
                        <thead>

                        <tr>
                            <th>Image</th>
                            <th>Product</th>
                            <th>Sizes</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody id="DataProduct">
                            @foreach ($products as $product)
                            <tr>
                        
                                <td><img src="{{asset(ProductImage().$product->Primary_Image)}}" border="0" width="50" class="img-rounded" align="center" /></td>
                                <td>{{ $product->en_Product_Name }}</td>
                                <td>    
                                    <table class="table table-bordered ">
                                        <thead>
                                            <tr>
                                                @foreach($product->sizes as $size)
                                                    <th>{{$size->Size}}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                @foreach($product->stocks as $stock)
                                                    <td style="min-width: -webkit-fill-available;">{{$stock->quantity}}</td>
                                                @endforeach 
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td style="min-width: -webkit-fill-available;">{{ $product->Quantity}}</td>
                                <td>
                                    <div class="action__buttons">
                                        <a href="{{route('admin.stock.edit', ['id' => $product->id])}}" class="btn-action"><i class="fa-solid fa-pen-to-square"></i></a>
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

    $(document).ready(function() {
        $('#category_id').change(function() {
            var selectedCategory = $(this).val();
            console.log(selectedCategory);
            fetchProducts(selectedCategory);
        });


        function fetchProducts(categoryId) {
            $.ajax({
                url: '{{ route("admin.get-products") }}',
                
                method: 'POST',
                data: {
                    category: categoryId,
                    _token: '{!! csrf_token() !!}'
                },
                success: function(response) {
                    // displayProducts(response.categories);
                    console.log(response.products);
                    var resultContainer = $('#DataProduct');
                    resultContainer.empty(); // Clear existing content
                    var products = response.products;

                    products.forEach(function(product) {
                        var i = '<td><img src="/uploaded_files/product_image/'+product.Primary_Image+'" border="0" width="50" class="img-rounded" align="center" /></td>';
                        var row = '<tr>'+i+'<td>' + product.en_Product_Name + '</td><td><table class="table table-bordered"><thead><tr>';

                        product.sizes.forEach(function(size) {
                            row += '<th>' + size.Size + '</th>';
                        });

                        row += '</tr></thead><tbody><tr>';
                        
                        product.stocks.forEach(function(stock) {
                            row += '<td style="min-width: -webkit-fill-available;">' + stock.quantity + '</td>';
                        });
                        
                        
                        row += '</tr></tbody>';

                        row += '</table>';
                        var opt = "{{route('admin.stock.edit', ['id' => "+product.id+"])}}";
                        row += '<td style="min-width: -webkit-fill-available;">'+product.Quantity+'</td>'
                        row += '<td><div class="action__buttons"> <a href="/admin/stock/edit/'+product.id+'" class="btn-action"><i class="fa-solid fa-pen-to-square"></i></a> </div><td>';
                        row += '</td></tr>';
                        resultContainer.append(row);
                    });


                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        }

    });

</script>
    @endpush
@endsection
