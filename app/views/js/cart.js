// Configurations
const taxRate = 0.21;
const fadeTime = 300;

// DOM Elements
const $cartSubtotal = $('#cart-subtotal');
const $cartTax = $('#cart-tax');
const $cartTotal = $('#cart-total');
const $checkout = $('.checkout');
const $totalsValue = $('.totals-value');
const $inputTotal = $('#input-total');

// Initial Setup
$(document).ready(() => {
    bindEvents();
    recalculateCart();
});

/* Bind Event Listeners */
function bindEvents() {
    // Quantity change event
    $('.product-quantity input').on('change', function() {
        updateQuantity($(this));
    });

    // Remove item event
    $('.product-removal button').on('click', function() {
        removeItem($(this));
    });
}

/* Recalculate Cart */
function recalculateCart() {
    const subtotal = calculateSubtotal();
    const tax = subtotal * taxRate;
    const total = subtotal + tax;

    updateCartDisplay(subtotal, tax, total);
    toggleCheckoutButton(total);
}

/* Calculate Subtotal */
function calculateSubtotal() {
    let subtotal = 0;

    $('.product').each(function () {
        const productPrice = parseFloat($(this).find('.product-line-price').text());
        subtotal += productPrice;
    });

    return subtotal;
}

/* Update Cart Totals Display */
function updateCartDisplay(subtotal, tax, total) {
    $totalsValue.fadeOut(fadeTime, function() {
        $cartSubtotal.html(subtotal.toFixed(2));
        $cartTax.html(tax.toFixed(2));
        $cartTotal.html(total.toFixed(2));

        // Update input field
        $inputTotal.val(42); // You can dynamically calculate this value if needed

        $totalsValue.fadeIn(fadeTime);
    });
}

/* Toggle Checkout Button */
function toggleCheckoutButton(total) {
    if (total === 0) {
        $checkout.fadeOut(fadeTime);
    } else {
        $checkout.fadeIn(fadeTime);
    }
}

/* Update Product Quantity */
function updateQuantity($quantityInput) {
    const $productRow = $quantityInput.closest('.product');
    const price = parseFloat($productRow.find('.product-price').text());
    const quantity = $quantityInput.val();
    const linePrice = price * quantity;

    updateLinePrice($productRow, linePrice);
}

/* Update Line Price */
function updateLinePrice($productRow, linePrice) {
    const $linePrice = $productRow.find('.product-line-price');

    $linePrice.fadeOut(fadeTime, function() {
        $linePrice.text(linePrice.toFixed(2));
        recalculateCart();
        $linePrice.fadeIn(fadeTime);
    });
}

/* Remove Item from Cart */
function removeItem($removeButton) {
    const $productRow = $removeButton.closest('.product');

    $productRow.slideUp(fadeTime, function() {
        $productRow.remove();
        recalculateCart();
    });
}
