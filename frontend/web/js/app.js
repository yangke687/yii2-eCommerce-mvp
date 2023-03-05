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
    });

    // change chart item quantity
    const $itemQuantities = $('.chart-item-quantity');

    $itemQuantities.change(evt => {
        const $this = $(evt.target);
        const id = $this.closest('tr').data('product_id');
        const quantity = parseInt($this.val());

        $.ajax({
            method: 'POST',
            url: $this.closest('tr').data('url'),
            data: {product_id: id, quantity},
            success: (totalQuantity) => {
                $cartQuantity.text(parseInt(totalQuantity));
                const price = parseFloat($this.parent().prev('td').text());
                const totalPrice = price * quantity
                $this.parent().next('td').text(totalPrice);
            }
        })
    });
});