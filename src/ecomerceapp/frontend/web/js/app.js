$(function () {
    console.log("running app.js")
    const $addToCart = $('.btn-add-to-cart');
    $addToCart.click(ev => {
        const $this = $(ev.target);
        const id = $this.closest('.product-item').data('key');
        console.log(id);
    });
});

/*
This is used to get all buttons that have a class btn-add-to-cart and to register click to event callback to them
then getting the closest element to the button that emitted the event and get its id. Its id is set by default by the
grid view widget of yii if you inspect in browser it is called data-key
*/
