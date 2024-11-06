(function($) {
    "use strict";

    $(".tag_one").select2();
    $(".tag_two").select2();

    // $('#discount').on('keyup', function () {
    //     var price = $('#price').val();
    //     var discount = $('#discount').val();
    //     var discount_price = (price * (100 - discount)) / 100;
    //     $('#discount_price').val(discount_price);
    // })

    $(document).ready(function () {
        var defaultCommission = 0;

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



})(jQuery)
