@extends('admin.master')
@section('title', isset($title) ? $title : '')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="breadcrumb__content">
                <div class="breadcrumb__content__left">
                    <div class="breadcrumb__title">
                        <h2>Order Details</h2>
                    </div>
                </div>
                <div class="breadcrumb__content__right">
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('Home')}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Design Product</li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="customers__area bg-style mb-30">

            <div class="card" >
                <div class="row g-0">
                    <div class="col-md-4">
                    <img src="{{ asset('/uploaded_files/design/'.$design->design_image) }}" class="img-fluid rounded-start" alt="...">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->en_Product_Name }}</h5>
                            <p class="card-text"><strong>Special Instruction</strong></br>{{ $design->instruction ?? '- Special Instruction is not available -' }}</p>

                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td class="text-center border fw-bold">Color</td>
                                            @isset($color->ColorCode)
                                            <td class="text-center border" style="background-color: {{ $color->ColorCode }};"> &nbsp;&nbsp;</td>
                                            @else
                                            <td class="text-center border">Not Selected</td>
                                            @endisset
                                            <td class="text-right border-0 fw-bold" style="text-align: right;">Print Type</td>
                                            <td class="text-center border">{{ $design->print_type }}</td>                        
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-4">
                                <table class="table table-bordered table-responsive">
                                    <thead>
                                        <tr>
                                            <th class="text-center" scope="col">Size</th>
                                            <th scope="col">Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($sizes as $key => $value)
                                            @isset($value)
                                            <tr>
                                                <td class="text-center bg-light">{{ $key }}</td>
                                                <td>{{ $value }}</td>
                                            </tr>
                                            @endisset
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- <div class="col"><img src="http://127.0.0.1:8000/uploaded_files/design/1687769460.png" alt=""></div> -->

                            <div class="container">
                                <div class="row">
                                            <hr>
                                    <div class="col-md-4">
                                        
                                        <div class="gallery-item">
                                            <img src="{{ asset('/uploaded_files/design/logo/'.$design->uploaded_image) }}" alt="Image 1" onclick="showImage('{{ asset('/uploaded_files/design/logo/'.$design->uploaded_image) }}')">
                                            <a class="btn btn-sm btn-primary" onclick="downloadImage('{{ asset('/uploaded_files/design/logo/'.$design->uploaded_image) }}')">Download</a>
                                        </div>
                                        </table>
                                        
                                    </div>

                                    <!-- Add more gallery items as needed -->
                                </div>
                                </div>

                                <div id="overlay" onclick="hideImage()">
                                <img id="overlay-image" src="" class="img-fluid">
                            </div>

                            <p class="card-text"><small class="text-muted">{{ $order_details->created_at->format('Y-m-d H:i:s') }}</small></p>
                        </div>
                    </div>
                </div>
            </div>

            </div>
        </div>
    </div>

    <script>
        function showImage(imageSrc) {
            var overlay = document.getElementById("overlay");
            var overlayImage = document.getElementById("overlay-image");
                console.log("Hi");

            overlay.style.display = "block";
            overlayImage.src = imageSrc;
            }

            function hideImage() {
            var overlay = document.getElementById("overlay");
            overlay.style.display = "none";
            }

            function downloadImage(imageSrc) {
            var link = document.createElement("a");
                console.log(link);
            link.href = imageSrc;
            link.download = imageSrc.split("/").pop();
            link.click();
        }

    </script>

    @push('post_scripts')
        <script src="{{asset('backend/js/admin/datatables/orders.js')}}"></script>
        <!-- Page level custom scripts -->
    @endpush
@endsection
