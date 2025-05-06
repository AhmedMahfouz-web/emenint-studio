// invoice.js - Robust dynamic calculation for invoices and quotations
$(document).ready(function() {
    // Get currency symbol from the selected currency
    function getCurrentCurrencySymbol() {
        var selectedCurrency = $('#currancy option:selected');
        return selectedCurrency.data('symbol') || 'ج.م';
    }

    // Update currency symbol displays when currency changes
    $('#currancy').on('change', function() {
        var symbol = getCurrentCurrencySymbol();
        $('.currency-symbol').text(symbol);
        updateTotals(); // Refresh totals with new currency symbol
    });

    function updateItemTotal(row) {
        console.log('Updating item total for row:', row);
        var quantity = parseFloat($(row).find('.quantity').val()) || 0;
        var unitPrice = parseFloat($(row).find('.unit-price').val()) || 0;
        var total = quantity * unitPrice;
        console.log('Quantity:', quantity, 'Unit Price:', unitPrice, 'Total:', total);
        
        $(row).find('.item-total-display').text(total.toFixed(2));
        $(row).find('input[name*="[total]"]').val(total.toFixed(2));
        updateTotals();
    }

    function updateTotals() {
        var subtotal = 0;
        var currencySymbol = getCurrentCurrencySymbol();
        
        // Calculate subtotal from each item
        $('.invoice-item').each(function() {
            var quantity = parseFloat($(this).find('.quantity').val()) || 0;
            var unitPrice = parseFloat($(this).find('.unit-price').val()) || 0;
            var itemTotal = quantity * unitPrice;
            subtotal += itemTotal;
        });
        
        console.log('Calculated subtotal:', subtotal);
        
        $('#subtotal').text(subtotal.toFixed(2) + ' ' + currencySymbol);
        
        var discount = parseFloat($('#discount').val()) || 0;
        $('#discount-amount').text(discount.toFixed(2) + ' ' + currencySymbol);
        
        var netBeforeTax = subtotal - discount;
        var taxRate = parseFloat($('#tax_percentage').val()) || 0;
        var taxAmount = netBeforeTax * (taxRate / 100);
        
        $('#tax-amount').text(taxAmount.toFixed(2) + ' ' + currencySymbol);
        
        var total = netBeforeTax + taxAmount;
        $('#total').text(total.toFixed(2) + ' ' + currencySymbol);
        
        console.log('Final total:', total);
    }

    function initializeItemRow(row) {
        console.log('Initializing row:', row);
        
        // Store the currently selected value before initializing Select2
        var select = $(row).find('select[name*="[product_id]"]');
        var selectedValue = select.val();
        var selectedText = select.find('option:selected').text();
        console.log('Selected value before init:', selectedValue, 'text:', selectedText);
        
        // Initialize Select2 for the product dropdown
        select.select2({
            width: '100%',
            dir: 'rtl',
            dropdownParent: $(row).closest('table'),
            templateResult: formatProduct,
            templateSelection: formatProductSelection
        });
        
        // Make sure the selected value is preserved after initialization
        if (selectedValue && selectedValue !== '') {
            select.val(selectedValue).trigger('change.select2');
        }
        
        // Product selection change handler
        select.off('change').on('change', function() {
            var selectedOption = $(this).find('option:selected');
            var price = selectedOption.data('unit-price') || 0;
            console.log('Selected product with price:', price);
            $(row).find('.unit-price').val(price);
            updateItemTotal(row);
        });
        
        // On page load: if a product is already selected, set unit price
        var selectedOption = select.find('option:selected');
        if (selectedOption.length && selectedOption.val()) {
            var price = selectedOption.data('unit-price') || 0;
            console.log('Initial product selected with price:', price);
            $(row).find('.unit-price').val(price);
        }
        
        // Listeners for quantity/unit price changes
        $(row).find('.quantity, .unit-price').off('input').on('input', function() {
            updateItemTotal(row);
        });
        
        // Remove row button handler
        $(row).find('.remove-item').off('click').on('click', function() {
            $(row).remove();
            updateTotals();
        });
        
        // Initial calculation for this row
        updateItemTotal(row);
    }
    
    // Format product options in the dropdown
    function formatProduct(product) {
        if (!product.id) {
            return product.text;
        }
        return $('<span>' + product.text + '</span>');
    }
    
    // Format the selected product in the select box
    function formatProductSelection(product) {
        if (!product.id) {
            return product.text;
        }
        return product.text;
    }

    // Initialize all existing rows on page load
    $('#invoice-items tbody .invoice-item').each(function() {
        initializeItemRow(this);
    });

    // Add new item row button handler
    $('#add-item').on('click', function() {
        var index = $('#invoice-items tbody .invoice-item').length;
        var template = $('#item-template').html().replace(/{index}/g, index);
        var $row = $(template);
        $('#invoice-items tbody').append($row);
        initializeItemRow($row);
    });

    // Listen for discount/tax changes
    $('#discount, #tax_percentage').on('input', function() {
        updateTotals();
    });

    // Initial totals calculation
    updateTotals();
    
    // Fallback: ensure totals are recalculated on form submit
    const invoiceForm = $('#invoiceForm, #quotationForm');
    if (invoiceForm.length) {
        invoiceForm.on('submit', function(e) {
            updateTotals();
            // Check if total is 0 and show a warning
            const totalText = $('#total').text() || '';
            if (parseFloat(totalText.replace(/[^\d.-]/g, '')) === 0) {
                alert('⚠️ الإجمالي صفر. يرجى التأكد من إدخال الكميات والأسعار بشكل صحيح.');
                // Optionally prevent submit:
                // e.preventDefault();
            }
        });
    }
});
