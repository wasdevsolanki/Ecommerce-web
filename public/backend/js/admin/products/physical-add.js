(function($) {
    "use strict";

    $(".tag_one").select2();
    $(".tag_two").select2();

    $(document).ready(function () {
        var defaultCommission = 25;

        $('#price, #commission').on('keyup', function () {
            var price = parseFloat($('#price').val());
            var commission = parseFloat($('#commission').val() || defaultCommission);
            var commission_price = (price * (commission / 100)) + price;

            var commission_value = commission_price.toFixed(2);
            $('#commission_price').val(commission_value);
        });

        $('#price, #commission').trigger('keyup');
    });

    $('#discount').on('keyup', function () {
        var commission_price = parseFloat($('#commission_price').val());
        var discount = $('#discount').val();
        var discount_price = (commission_price * (100 - discount)) / 100;
        var discount_value = discount_price.toFixed(2);
        $('#discount_price').val(discount_value);
    })

    $('#en-product-name').on('keyup', function() {
        let $this = $(this);
        let str = $this.val().toLowerCase().replace(/[0-9`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi,'-').replace(/ /g, '-');
        $('#en-product-slug').val(str);
    })

    $('#fr-product-name').on('keyup', function() {
        let $this = $(this);
        let str = $this.val().toLowerCase().replace(/[0-9`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi,'-').replace(/ /g, '-');
        $('#fr-product-slug').val(str);
    })
})(jQuery)
