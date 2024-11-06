<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>@yield('title') {{__('| '. $allsettings['app_title'])}}</title>
	<meta name="description" content="@yield('description')" />
	<meta name="keywords" content="@yield('keywords')" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="author" content="{{$allsettings['meta_author']}}" />
	<link rel="canonical" href="{{ url()->current() }}" />
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'G-77LELT3KQ5');
	</script>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
	<link rel="canonical" href="{{ url()->current() }}" />
	<script type="text/javascript" src="{{asset('frontend/assets/design/js/fabric.js')}}"></script>
	<script type="text/javascript" src="{{asset('frontend/assets/design/js/tshirtEditor.js')}}"></script>
	<script type="text/javascript" src="{{asset('frontend/assets/design/js/jquery.miniColors.min.js')}}"></script>


	<!-- Le styles -->
	<link type="text/css" rel="stylesheet" href="{{ asset('frontend/assets/design/css/jquery.miniColors.css')}}" />
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
		  integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

	<link rel="stylesheet" href="{{ asset('frontend/assets/design/css/styles.css')}}">


	<!-- icon lib -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

	<!-- icon lib -->

	<script type="text/javascript"></script>

	<!-- Favicon -->
	<link rel="shortcut icon" href="{{asset(IMG_FAVICON_PATH.$allsettings['favicon'])}}" type="image/x-icon">

</head>

<body class="preview" data-spy="scroll" data-target=".subnav" data-offset="80">

<!-- Navbar
    ================================================== -->
<nav class="navbar navbar-expand-lg bg-body-tertiary">
	<div class="container text-center">
		<a class="navbar-brand" href="{{url('/')}}">
			<img src="https://malakofftraders.com/uploaded_files/logo/647f07db4c0871686046683.png" alt="">
		</a>


	</div>
</nav>

<div class="container pt-2 ">
	<nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a class="text-dark fw-bold" style="text-decoration:none" href="{{route('single.product', $slug)}}">Back</a></li>
			<li class="breadcrumb-item active" aria-current="page">{{$title}}</li>
		</ol>
	</nav>
</div>

<div class="container">
	<form id="myForm" action="{{ route('design.buynow') }}" method="POST" enctype="multipart/form-data">
		@csrf
		<input type="hidden" name="selected_color_id" id="selectedColorId">
		<input type="hidden" name="product_id" value="{{$product->id}}">
		<input type="hidden" name="print_price" value="9.99">
		<input type="file" id="imageInput" name="design_image" style="display: none;">


		<div class="row">
			<div class="col">
				<h3 class="heading py-2 text-center">
					{{$title}}
				</h3>
			</div>
		</div>
		<div class="row">
			<div class="col col-sm-12 col-lg-3 col-xl-3 col-md-12">
				<div class="card">
					<div class="card-body">
						<h6 class="card-title">Product Colors</h6>
						<ul class="nav">
							@foreach($product->colors as $color)
								<li class="color-preview" title="{{$color->id}}" data-color-id="{{$color->ColorCode}}" style="background-color:{{$color->ColorCode}};"></li>
							@endforeach
						</ul>
						<h6 class="card-title mt-5">Design Option</h6>


						<div class="input-group input-group-sm mb-3">
							<input type="text" class="form-control" id="text-string" placeholder="Enter Text" aria-label="Recipient's username" aria-describedby="add-text">
							<button class="btn btn-dark text-light btn-outline-secondary" type="button" id="add-text" title="Add text">Add Text</button>
						</div>

						<h6 class="card-title mt-5">Upload your designs</h6>
						<!-- <input type="file" name="logo" class="" accept="image/*" onchange="handleFileSelect(event)" /> -->
						<div class="mb-3 input-group-sm">
							<input class="form-control" name="logo" type="file" accept="image/*" id="formFile" onchange="handleFileSelect(event)">
						</div>

						<div id="avatarlist">
							<img id="image-preview" class="img-polaroid" alt="Image Preview" style="display: none;" />
						</div>
					</div>
				</div>
			</div>
			<div class="col col-lg-6 col-md-12  col-sm-12">
				<div style="min-height: 32px;">
					<div class="clearfix">
						<div class="btn-group inline pull-left" id="texteditor" style="display:none; float:left">

							<!-- <div class="btn-group">
                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Small button
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a tabindex="-1" href="#" onclick="setFont('Arial');" class="Arial">Arial</a></li>
                                    <li><a tabindex="-1" href="#" onclick="setFont('Helvetica');" class="Helvetica">Helvetica</a></li>
                                </ul>
                            </div> -->

							<button type="button" id="font-family" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-type"></i></button>
							<ul class="dropdown-menu" role="menu" aria-labelledby="font-family-X">
								<li><a tabindex="-1" href="#" onclick="setFont('Arial');" class="Arial dropdown-item">Arial</a></li>
								<li><a tabindex="-1" href="#" onclick="setFont('Helvetica');" class="Helvetica dropdown-item">Helvetica</a></li>
								<li><a tabindex="-1" href="#" onclick="setFont('Myriad Pro');" class="MyriadPro dropdown-item">Myriad Pro</a></li>
								<li><a tabindex="-1" href="#" onclick="setFont('Delicious');" class="Delicious dropdown-item">Delicious</a></li>
								<li><a tabindex="-1" href="#" onclick="setFont('Verdana');" class="Verdana dropdown-item">Verdana</a></li>
								<li><a tabindex="-1" href="#" onclick="setFont('Georgia');" class="Georgia dropdown-item">Georgia</a></li>
								<li><a tabindex="-1" href="#" onclick="setFont('Courier');" class="Courier dropdown-item">Courier</a></li>
								<li><a tabindex="-1" href="#" onclick="setFont('Comic Sans MS');" class="ComicSansMS dropdown-item">Comic Sans MS</a></li>
								<li><a tabindex="-1" href="#" onclick="setFont('Impact');" class="Impact dropdown-item">Impact</a></li>
								<li><a tabindex="-1" href="#" onclick="setFont('Monaco');" class="Monaco dropdown-item">Monaco</a></li>
								<li><a tabindex="-1" href="#" onclick="setFont('Optima');" class="Optima dropdown-item">Optima</a></li>
								<li><a tabindex="-1" href="#" onclick="setFont('Hoefler Text');" class="Hoefler Text dropdown-item">Hoefler Text</a></li>
								<li><a tabindex="-1" href="#" onclick="setFont('Plaster');" class="Plaster dropdown-item">Plaster</a>	</li>
								<li><a tabindex="-1" href="#" onclick="setFont('Engagement');" class="Engagement dropdown-item">Engagement</a></li>
							</ul>

							<button id="text-bold" class="btn" data-original-title="Bold">
								<img src="{{ asset('frontend/assets/design/img/font_bold.png')}}" />
							</button>
							<button id="text-italic" class="btn" data-original-title="Italic">
								<img src="{{ asset('frontend/assets/design/img/font_italic.png')}}" />
							</button>
							<button id="text-strike" class="btn" style=""><img
										src="{{ asset('frontend/assets/design/img/font_strikethrough.png')}}" height="" width=""></button>
							<button id="text-underline" class="btn"  style=""><img
										src="{{ asset('frontend/assets/design/img/font_underline.png')}}"></button>
							<a class="btn" href="#" rel="tooltip" data-placement="top"
							   data-original-title="Font Color"><input type="hidden" id="text-fontcolor"
																	   class="color-picker" size="7" value="#000000"></a>
							<a class="btn" href="#" rel="tooltip" data-placement="top"
							   data-original-title="Font Border Color"><input type="hidden" id="text-strokecolor"
																			  class="color-picker" size="7" value="#000000"></a>
						</div>
						<div class="pull-right" align="" id="imageeditor" style="display:none">
							<div class="btn-group ">
								<!-- <button type="button" class="btn btn-primary" id="bring-to-front" title="Bring to Front">Bring To Front</button>
								<button type="button" class="btn btn-primary" id="send-to-back" title="Send to Back">Send To Back</button>
								<button type="button" id="remove-selected" class="btn btn-primary" title="Delete selected item">Delete </button> -->

								<button type="button" class="btn" id="bring-to-front" ><i class="bi bi-arrow-up-circle-fill"></i></button>
								<button type="button" class="btn" id="send-to-back" ><i class="bi bi-arrow-down-circle-fill"></i></button>
								<button type="button" id="remove-selected" class="btn" ><i class="bi bi-trash3"></i></button>
							</div>
						</div>
					</div>
				</div>
				<div id="shirtDiv" class="page"
					 style="width: 530px; height: 630px; position: relative; background-color: rgb(255, 255, 255);">
					@if(($product->clothing_type) !== null )
						<img id="tshirtFacing" src="{{asset('uploaded_files/templates/'.TemplateDesign($product->clothing_type)->image) }}">
					@else
						<img id="tshirtFacing" src="{{asset('frontend/assets/design/img/crew_front.png')}}">
					@endif

					<div id="drawingArea"
						 style="position: absolute;top: 100px;left: 160px;z-index: 10;width: 200px;height: 400px;">
						<canvas id="tcanvas" width=200 height="400" class="hover"
								style="-webkit-user-select: none;"></canvas>
					</div>
				</div>
			</div>
			<div class="col col-lg-3 col-md-12 col-sm-12">
				<div class="card mb-3">
					<div class="card-body">
						<h6 class="card-title">
							Order
						</h6>

						@foreach($stocks as $stock)
							@foreach($product->sizes as $size)
								@if($stock->size_id == $size->id)
									<div class="input-group input-group-sm mb-1">
										<input 	type="number"
												  aria-label="Sizing example input"
												  id="quantity"
												  class="form-control"
												  name="{{$size->Size}}"
												  min="0"
												  max="{{$stock->quantity}}"
												  onkeydown="handleArrowKeys(event)"
												  oninput="validateInput(this)"
												  placeholder="{{$size->Size}}  Qty:{{$stock->quantity}}"
												  aria-describedby="inputGroup-sizing-sm">
									</div>
								@endif
							@endforeach
						@endforeach
						<span id="limitMessage" style=" display: none;">Limit Exceeded!</span>
						<h6 class="card-title mt-4">
							Select printing Type
						</h6>

						<select class="form-select form-select-sm" name="print_type" aria-label=".form-select-sm example">
							<option value="embroidary">Embroidery</option>
							<option value="digital">Digital Printing</option>
						</select>

						<h6 class="card-title mt-4">
							Special Instruction
						</h6>
						<textarea class="form-control" name="instruction" id="exampleFormControlTextarea1" rows="3"></textarea>
					</div>
				</div>
				<div class="card">
					<div class="card-body">
						<h6>Total Price</h6>


						<div class="container text-center mb-3">
							<div class="row">
								<div class="col"><strong>Print Cost</strong></div>
								<div class="col">$11.99</div>
							</div>
						</div>

						<button type="button" class="btn btn-outline-primary" style="width: 100%;" name="addToTheBag" id="addToTheBag " onclick="captureDiv()">Buy Now</button>
					</div>
				</div>
			</div>

		</div>
	</form>
</div>


<!-- /container -->



<!-- Footer ================================================== -->
<!-- <footer class="footer">
    <div class="container">
        <p class="pull-right"><a href="#">Back to top</a></p>
    </div>
</footer> -->
<!-- Footer ================================================== -->


<!-- Placed at the end of the document so the pages load faster -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
		crossorigin="anonymous"></script>
<!-- <script src="js/bootstrap.min.js"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script> -->

<script type="text/javascript">
	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', 'UA-35639689-1']);
	_gaq.push(['_trackPageview']);

	(function () {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();
</script>

<!-- select box clothes types -->
<script>
	function changeImage(select) {
		var selectedOption = select.options[select.selectedIndex];
		var selectedValue = selectedOption.value;
		var selectedText = selectedOption.text;

		var imgElement = document.getElementById("tshirtFacing");
		imgElement.src = selectedValue;

		var captionElement = document.getElementById("caption");
		captionElement.textContent = selectedText;
	}
</script>
<!-- end here clothes type code -->

<!-- image upload start -->
<script>
	$("#addimg").on('click', function () {
		$('#imgInp').click();
	});

	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function (e) {
				$('#avatarlist').append('<img class="img-polaroid"  src="' + e.target.result + '">');
			}

			reader.readAsDataURL(input.files[0]);
		}
	}

	$("#imgInp").change(function () {
		readURL(this);
	});
</script>
<!-- image upload end -->

<script>
	// function captureDiv() {
	// 	const div = document.getElementById('shirtDiv');
	// 	// Use html2canvas to capture the div section
	// 	html2canvas(div)
	// 		.then(function (canvas) {
	// 		// Convert the canvas to a data URL
	// 		const dataURL = canvas.toDataURL('image/png');

	// 		// Create a temporary link element
	// 		const link = document.createElement('a');
	// 		link.href = dataURL;
	// 		// link.download = 'div_section.png';

	// 		// Programmatically click the link to trigger the download
	// 		link.click();
	// 	});
	// }

	// 		function captureDiv() {
	//   const div = document.getElementById('shirtDiv');
	//   // Use html2canvas to capture the div section
	//   html2canvas(div).then(function (canvas) {
	//     // Convert the canvas to a Blob object
	//     canvas.toBlob(function (blob) {
	//       // Create a File object from the Blob
	//       const file = new File([blob], 'div_section.png', { type: 'image/png' });

	//       // Create a new DataTransfer object
	//       const dataTransfer = new DataTransfer();

	//       // Add the File object to the DataTransfer object
	//       dataTransfer.items.add(file);

	//       // Get the input file element
	//       const inputFile = document.getElementById('imageInput');

	//       // Clear existing files from the input
	//       inputFile.value = '';

	//       // Set the DataTransfer object as the value of the input file element
	//       inputFile.files = dataTransfer.files;

	//       // Trigger a change event on the input file element to update its value
	//       const event = new Event('change', { bubbles: true });
	//       inputFile.dispatchEvent(event);

	//       // Delay form submission to ensure file is properly added to the input
	//       setTimeout(function() {
	//         // Submit the form
	//         document.getElementById('myForm').submit();
	//       }, 100);
	//     });
	//   });
	// }

	function captureDiv() {
		const div = document.getElementById('shirtDiv');
		// Use html2canvas to capture the div section
		html2canvas(div).then(function (canvas) {
			// Convert the canvas to a Blob object
			canvas.toBlob(function (blob) {
				// Create a File object from the Blob
				const file = new File([blob], 'div_section.png', { type: 'image/png' });

				// Create a new DataTransfer object
				const dataTransfer = new DataTransfer();

				// Add the File object to the DataTransfer object
				dataTransfer.items.add(file);

				// Get the input file element
				const inputFile = document.getElementById('imageInput');

				// Clear existing files from the input
				inputFile.value = '';

				// Set the DataTransfer object as the value of the input file element
				inputFile.files = dataTransfer.files;

				// Trigger a change event on the input file element to update its value
				const event = new Event('change', { bubbles: true });
				inputFile.dispatchEvent(event);

				// Read the Blob data as a Data URL
				const reader = new FileReader();
				reader.onload = function () {
					// Get the Data URL result
					const dataUrl = reader.result;

					// Create a new image element
					const image = new Image();
					image.onload = function () {
						// Delay form submission to ensure the image is loaded properly
						setTimeout(function () {
							// Submit the form
							document.getElementById('myForm').submit();
						}, 100);
					};
					image.src = dataUrl;
				};
				reader.readAsDataURL(blob);
			});
		});
	}

	//upload image to design
	function handleFileSelect(event) {
		var file = event.target.files[0];
		var reader = new FileReader();

		reader.onload = function (event) {
			var img = new Image();
			img.onload = function () {
				var canvas = document.getElementById('tcanvas');
				var ctx = canvas.getContext('2d');
				//   canvas.width = img.width;
				//   canvas.height = img.height;
				ctx.drawImage(img, 0, 0, img.width, img.height);
			};
			img.src = event.target.result;

			var imagePreview = document.getElementById('image-preview');
			imagePreview.src = event.target.result;
			imagePreview.style.display = 'block';
			imagePreview.style.pointer = 'cursor';
			imagePreview.style.width = '90px';

		};

		reader.readAsDataURL(file);
	}

	// product size limit by quantity
	function handleArrowKeys(event) {
		if (event.key === 'ArrowUp' || event.key === 'ArrowDown') {
			event.preventDefault(); // Prevent manual input
		}
	}

	function validateInput(input) {
		const value = parseInt(input.value);
		const limitMessage = document.getElementById('limitMessage');

		if (isNaN(value) || value < parseInt(input.min) || value > parseInt(input.max)) {
			input.value = ''; // Clear invalid value
			limitMessage.style.display = 'block'; // Hide the message for invalid input
		} else if (value > parseInt(input.max)) {
			limitMessage.style.display = 'block'; // Show the message for limit exceed
		} else {
			limitMessage.style.display = 'none'; // Hide the message when within limit
		}
	}

	// color picked and add in form
	$('.color-preview').on('click', function () {
		var colorId = $(this).data('color-id');
		$('#selectedColorId').val(colorId);
	});

	document.addEventListener('DOMContentLoaded', function() {
		const yourButton = document.getElementById('addToTheBag');

		yourButton.addEventListener('click', function(event) {
			event.preventDefault(); // Prevent form submission

			// Handle button click event here
			// You can perform any desired actions or submit the form programmatically using JavaScript
		});
	});

</script>
<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
</body>


</html>