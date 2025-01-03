import jQuery from 'jquery';
import select2 from 'select2';
import 'select2/dist/css/select2.css';
import 'select2/dist/js/select2.full.js';
import Toastify from 'toastify-js';
import 'toastify-js/src/toastify.css';

// Ensure jQuery is globally available
window.$ = window.jQuery = jQuery;

// Initialize select2
select2(window.jQuery);

// Only initialize once
if (!window.invoiceInitialized) {
    window.invoiceInitialized = true;

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Select2
        initializeSelect2();

        // Initialize item counter
        let itemCounter = 1;

        // Function to update totals
        function updateTotals() {
            let subtotal = 0;

            // Calculate subtotal from each item total
            document.querySelectorAll('.item-total').forEach(input => {
                const itemTotal = parseFloat(input.value) || 0; // Ensure we parse the value correctly
                subtotal += itemTotal;
            });

            // Get discount and calculate net before tax
            const discount = parseFloat(document.getElementById('discount').value) || 0;
            const netBeforeTax = subtotal - discount;

            // Calculate tax
            const taxRate = parseFloat(document.getElementById('tax-rate').value) || 0;
            const taxAmount = (netBeforeTax * taxRate) / 100;

            // Calculate total
            const total = netBeforeTax + taxAmount;

            // Update display values with currency
            document.getElementById('subtotal-display').textContent = subtotal.toFixed(2) + ' ج.م';
            document.getElementById('discount-display').textContent = discount.toFixed(2) + ' ج.م';
            document.getElementById('tax-amount-display').textContent = taxAmount.toFixed(2) + ' ج.م';
            document.getElementById('total-display').textContent = total.toFixed(2) + ' ج.م';

            // Update hidden inputs
            document.getElementById('subtotal-input').value = subtotal.toFixed(2);
            document.getElementById('tax-input').value = taxAmount.toFixed(2);
            document.getElementById('total-input').value = total.toFixed(2);
        }

        // Function to add item event listeners
        function addItemEventListeners(item) {
                const productSelect = item.querySelector('.product-select');
    const quantityInput = item.querySelector('input[name*="[quantity]"]'); // Select quantity input
    const unitPriceInput = item.querySelector('.unit-price');
    const itemTotalInput = item.querySelector('.item-total');
    const removeButton = item.querySelector('.remove-item');


            // Product selection
            jQuery(productSelect).on('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const price = parseFloat(selectedOption.dataset.price) || 0; // Ensure price is parsed correctly
        unitPriceInput.value = price.toFixed(2); // Set unit price
        updateItemTotal(item); // Update item total
    });


            // Quantity change
            quantityInput.addEventListener('input', function() {
        if (this.value < 1) this.value = 1; // Ensure quantity is at least 1
        updateItemTotal(item); // Update item total
            });

            // Unit price change
    unitPriceInput.addEventListener('input', function() {
        updateItemTotal(item); // Update item total when unit price changes
    });


            // Remove item
            if (removeButton) {
                removeButton.addEventListener('click', function() {
                    if (document.querySelectorAll('.invoice-item').length > 1) {
                        item.remove();
                        updateTotals(); // Recalculate totals after removing an item
                    }
                });
            }
        }

        // Function to update item total
       function updateItemTotal(item) {
    const quantity = parseFloat(item.querySelector('input[name*="[quantity]"]').value) || 0; // Get quantity
    const unitPrice = parseFloat(item.querySelector('.unit-price').value) || 0; // Get unit price
    const itemTotal = quantity * unitPrice; // Calculate item total
    item.querySelector('.item-total').value = itemTotal.toFixed(2); // Set item total
    console.log(`Quantity: ${quantity}, Unit Price: ${unitPrice}, Item Total: ${itemTotal.toFixed(2)}`); // Debugging log
    updateTotals(); // Recalculate totals after updating item total
}

        // Add new item row
        const addItemButton = document.getElementById('add-item');
        if (addItemButton) {
            addItemButton.addEventListener('click', function() {
                // Disable the button to prevent multiple clicks
                addItemButton.disabled = true;

                const itemsContainer = document.getElementById('invoice-items');
                const newItem = document.querySelector('.invoice-item').cloneNode(true);

                // Update names and clear values
                const inputs = newItem.querySelectorAll('input, select');
                inputs.forEach(input => {
                    if (input.name) {
                        input.name = input.name.replace(/\[\d+\]/, `[${itemCounter}]`); // Update index in name
                    }
                    if (input.type !== 'button') {
                        input.value = input.type === 'number' ? '1' : ''; // Reset values
                    }
                });

                // Remove any existing select2 instances
                jQuery(newItem).find('.select2-container').remove();

                // Add event listeners to new elements
                addItemEventListeners(newItem);

                // Append the new item
                itemsContainer.appendChild(newItem);

                // Re-initialize Select2 on the new select input
                jQuery(newItem).find('.select2-searchable').select2({
                    theme: 'bootstrap-5',
                    dir: 'rtl',
                    width: '100%',
                    language: {
                        noResults: function() {
                            return "لا توجد نتائج";
                        },
                        searching: function() {
                            return "جاري البحث...";
                        }
                    },
                    placeholder: "اختر أو ابحث...",
                    allowClear: true
                });

                // Recalculate totals after adding a new item
                updateTotals();

                itemCounter++;

                // Re-enable the button after a short delay
                setTimeout(() => {
                    addItemButton.disabled = false;
                }, 100); // Adjust the delay as needed
            });
        }

        // Add event listeners to initial row
        document.querySelectorAll('.invoice-item').forEach(addItemEventListeners);

        // Add event listeners to tax rate and discount inputs
        document.getElementById('tax-rate')?.addEventListener('input', updateTotals);
        document.getElementById('discount')?.addEventListener('input', updateTotals);
    });
}


function showToast(message) {
    Toastify({
        text: message,
        duration: 3000, // Duration in milliseconds
        gravity: "top", // `top` or `bottom`
        position: 'right', // `left`, `center` or `right`
        backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
        stopOnFocus: true, // Prevents dismissing of toast on hover
    }).showToast();
}

function initializeSelect2(container = document) {
    const config = {
        theme: 'bootstrap-5',
        dir: 'rtl',
        width: '100%',
        language: {
            noResults: function() {
                return "لا توجد نتائج";
            },
            searching: function() {
                return "جاري البحث...";
            }
        },
        placeholder: "اختر أو ابحث...",
        allowClear: true
    };

    // Initialize client select
    if (container === document) {
        jQuery('.select2-searchable').select2({
            ...config,
            matcher: function(params, data) {
                // If there are no search terms, return all of the data
                if (jQuery.trim(params.term) === '') {
                    return data;
                }

                // Do not display the item if there is no 'text' property
                if (typeof data.text === 'undefined') {
                    return null;
                }

                const term = params.term.toLowerCase();
                const text = data.text.toLowerCase();

                // Check if the text contains the term
                if (text.indexOf(term) > -1) {
                    return data;
                }

                // Return `null` if the term should not be displayed
                return null;
            }
        });
    }
}

// Initial call to update totals on page load
updateTotals();
