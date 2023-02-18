$(function () {

    const $addToCart = $('.btn-add-to-cart');

    const $cartQuantity = $('#cart-quantity');

    $addToCart.click(ev => {
        ev.preventDefault();
        const $this = $(ev.target);
        const id = $this.closest('.product-item').data('key');

        $.ajax({
            method: 'POST',
            url: $this.attr('href'),
            data: {id},
            success: function () {
                $cartQuantity.text(parseInt($cartQuantity.text() || 0) + 1)
                console.log(arguments)
            }
        })
    })
});