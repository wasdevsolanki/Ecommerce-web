(function ($) {
    "use strict";

    let sizeid;
    let _token= $('meta[name="csrf-token"]').attr('content')
    $(document).ready(function() {
        //size value
        $('.activeSize').on('click',function (){
            $(this).addClass('active').siblings().removeClass('active');
            sizeid = $(this).attr("data-size");
        });
    });
    //buy now
    $('.buyNow').on('click',function (){
        let product_id = $(this).attr("data-id");
        let quantity = $('#productQuantity').val();
        let colorSelector = document.querySelector('input[name="productColor"]:checked');

        let color;
        let size;

        if (colorSelector) {
            color = colorSelector.value
        } else {
            color = null;
        }
        if (sizeid) {
            size = sizeid
        } else {
            size = null;
        }
        $.ajax({
            url: $('#AddToCartIntoSession').data('url'),
            method: "POST",
            data:{
                product_id:product_id,
                quantity:quantity,
                color_id:color,
                size_id:size,
                _token: _token,
            },
            success:function (data){
                $('.totalCountItem').html(data[0]);
                $('.totalAmount').html(data[1]);
                window.location.href = '/checkout'
            },
            error: function() {
                // Display an error message
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })
                Toast.fire({
                    icon: 'warning',
                    title: 'Please First Add Item in Cart!'
                })

            }
        });
    });

})(jQuery)
