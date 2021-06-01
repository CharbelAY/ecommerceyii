$(function () {
    const cartQuantity = $('#cart-quantity');
    console.log("running app.js")
    const $addToCart = $('.btn-add-to-cart');
    $addToCart.click(ev => {
        ev.preventDefault();
        const $this = $(ev.target);
        const id = $this.closest('.product-item').data('key');
        console.log(id);

        $.ajax({
            method: "POST",
            url: $this.attr("href"),
            data: {id},
            success: function () {
                console.log(arguments);
                cartQuantity.text((parseInt(cartQuantity.text()) || 0) + 1);

            }
        });
    });

    const quantityInputs = $('.item-quantity');
    quantityInputs.change(ev => {
        const $this = $(ev.target);
        const newQuantity = $this.val();
        const itemId = $this.closest('tr').data('id');
        console.log(newQuantity);
        $.ajax({
            method: "POST",
            url: $this.closest('tr').data('url'),
            data: {itemId:itemId, quantity:newQuantity},
            success: function (result) {
                cartQuantity.text(result);
            }
        })
    });
});

/*
This is used to get all buttons that have a class btn-add-to-cart and to register click to event callback to them
then getting the closest element to the button that emitted the event and get its id. Its id is set by default by the
grid view widget of yii if you inspect in browser it is called data-key
*/
