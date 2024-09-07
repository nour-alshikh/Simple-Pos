$(document).ready(function () {
    //##################### ADD PRODUCT
    $(".add-product-btn").on('click', function (e) {
        e.preventDefault();

        let name = $(this).data('name')
        let id = $(this).data('id')
        let price = $.number($(this).data('price'), 2)

        $(this).removeClass('btn-success').addClass('btn-default disabled')

        let html = `
                    <tr>
                        <td></td>
                        <td>${name}</td>
                        <td><input type="number" name="products[${id}][quantity]" data-unit-price="${price}" class="form-control product-quantity" min="1" value="1" /></td>
                        <td>${price}</td>
                        <td class="product_price">${price}</td>
                        <td><button class="btn btn-danger remove-product-btn" data-id="${id}"><i class="fa fa-trash"></i></button></button></td>

                    </tr>
        `
        $('.order-list').append(html)


        //    Calculate total price
        calculateTotalPrice()
    })
    $("body").on('click', ".disabled", function (e) {
        e.preventDefault()
    })


    //##################### REMOVE PRODUCT
    $("body").on('click', ".remove-product-btn", function (e) {
        e.preventDefault()

        let id = $(this).data('id')

        $(this).closest("tr").remove();
        $("#product-" + id).removeClass('btn-default disabled').addClass('btn-success');

        //    Calculate total price
        calculateTotalPrice()
    })


    //##################### CHANGE QUANTITY
    $("body").on('change', ".product-quantity", function () {
        let quantity = Number($(this).val())
        let productPrice = parseFloat($(this).data('unit-price').replace(/,/g, ""))

        let total = $.number((quantity * productPrice), 2)

        $(this).closest('tr').find('.product_price').html(total)
        $('.total-price').html(total)
        calculateTotalPrice()
    })

    $('.order-products').on("click", function (e) {
        e.preventDefault()

        $("#loading").css('display', 'block')

        let url = $(this).data('url')

        console.log(url);

        $.ajax({
            url,
            method: "GET",
            success: function (response) {
                $("#loading").css('display', 'none')
                $("#order-products-list").empty()
                $("#order-products-list").append(response)
            }

        })
    })

    // print order products

    $(document).on('click', '#print-btn', function () {

        $('#print-area').printThis();

    })

})


function calculateTotalPrice() {
    let total = 0;

    $('.order-list .product_price').each(function () {
        total += parseFloat($(this).html().replace(/,/g, ""))
    })

    $('.total-price').html($.number(total, 2))

    $('#total_price').val($.number(total, 2));

    if (total > 0) {
        $('#add-order-btn').removeClass('disabled')
    } else {
        $('#add-order-btn').addClass('disabled')

    }
}

