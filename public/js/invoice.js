// Function to get current currency symbol
function getCurrentCurrencySymbol() {
    const currencySelect = document.getElementById('currancy');
    if (!currencySelect) return 'ج.م';

    const selectedOption = currencySelect.options[currencySelect.selectedIndex];
    if (!selectedOption) return 'ج.م';

    return selectedOption.getAttribute('data-symbol') || 'ج.م';
}

// Function to update totals
function updateTotals() {
    let subtotal = 0;
    const currencySymbol = getCurrentCurrencySymbol();

    // Calculate subtotal from each item total
    document.querySelectorAll('.item-total-display').forEach(span => {
        const itemTotal = parseFloat(span.textContent.replace(/[^\d.-]/g, '')) || 0;
        subtotal += itemTotal;
    });

    // Get discount and calculate net before tax
    const discount = parseFloat(document.getElementById('discount').value) || 0;
    const netBeforeTax = subtotal - discount;

    // Calculate tax
    const taxRate = parseFloat(document.getElementById('tax_percentage').value) || 0;
    const taxAmount = (netBeforeTax * taxRate) / 100;

    // Calculate total
    const total = netBeforeTax + taxAmount;

    // Update display values with currency symbol
    document.getElementById('subtotal').textContent = subtotal.toFixed(2) + ' ' + currencySymbol;
    document.getElementById('discount-amount').textContent = discount.toFixed(2) + ' ' + currencySymbol;
    document.getElementById('tax-amount').textContent = taxAmount.toFixed(2) + ' ' + currencySymbol;
    document.getElementById('total').textContent = total.toFixed(2) + ' ' + currencySymbol;
}

// Ensure script only runs once
if (!window.invoiceInitialized) {
    document.addEventListener('DOMContentLoaded', function() {
        // Set initialization flag
        window.invoiceInitialized = true;
        
        // Initialize item counter
        let itemCounter = 0;

        // Initialize Select2
        function initializeSelect2(element) {
            $(element).select2({
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
                placeholder: "اختر المنتج",
                allowClear: true
            });
        }

        // Function to update item total
        function updateItemTotal(row) {
            const quantity = parseFloat(row.querySelector('.quantity').value) || 0;
            const unitPrice = parseFloat(row.querySelector('.unit-price').value) || 0;
            const totalInput = row.querySelector('input[name$="[total]"]');
            const totalDisplay = row.querySelector('.item-total-display');
            const currencySymbol = getCurrentCurrencySymbol();
            
            const total = quantity * unitPrice;
            totalInput.value = total.toFixed(2);
            totalDisplay.textContent = total.toFixed(2) + ' ' + currencySymbol;
            
            updateTotals();
        }

        // Function to initialize item row event listeners
        function initializeItemRow(row) {
            const quantityInput = row.querySelector('.quantity');
            const unitPriceInput = row.querySelector('.unit-price');
            const removeButton = row.querySelector('.remove-item');
            const select = row.querySelector('select.select2-searchable');

            if (quantityInput) {
                quantityInput.addEventListener('input', () => updateItemTotal(row));
            }

            if (unitPriceInput) {
                unitPriceInput.addEventListener('input', () => updateItemTotal(row));
            }

            if (removeButton) {
                removeButton.addEventListener('click', () => {
                    if (document.querySelectorAll('.invoice-item').length > 1) {
                        row.remove();
                        updateTotals();
                    }
                });
            }

            if (select) {
                initializeSelect2(select);
                select.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    if (selectedOption && selectedOption.dataset.unitPrice) {
                        const priceInput = row.querySelector('.unit-price');
                        if (priceInput) {
                            priceInput.value = selectedOption.dataset.unitPrice;
                            updateItemTotal(row);
                        }
                    }
                });
            }

            // Calculate initial total for this row
            updateItemTotal(row);
        }

        // Function to add new item row
        function addItemRow() {
            const tbody = document.querySelector('#invoice-items tbody');
            const newRow = document.createElement('tr');
            newRow.className = 'invoice-item';
            const currencySymbol = getCurrentCurrencySymbol();
            
            newRow.innerHTML = `
                <td data-label="المنتج">
                    <select class="form-select select2-searchable" name="items[${itemCounter}][product_id]" required>
                        ${window.productOptions}
                    </select>
                </td>
                <td data-label="الوصف">
                    <input type="text" class="form-control" name="items[${itemCounter}][description]">
                </td>
                <td data-label="الكمية">
                    <input type="number" class="form-control quantity" name="items[${itemCounter}][quantity]" value="1" min="1" required>
                </td>
                <td data-label="السعر">
                    <input type="number" class="form-control unit-price" name="items[${itemCounter}][unit_price]" value="0.00" min="0" step="0.01" required>
                </td>
                <td data-label="المجموع">
                    <input type="hidden" name="items[${itemCounter}][total]" value="0.00">
                    <span class="item-total-display">0.00 ${currencySymbol}</span>
                </td>
                <td data-label="العمليات">
                    <button type="button" class="btn btn-danger btn-sm remove-item">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;

            tbody.appendChild(newRow);
            initializeItemRow(newRow);
            itemCounter++;
            updateItemTotal(newRow);
        }

        // Initialize existing rows and calculate totals
        document.querySelectorAll('.invoice-item').forEach(row => {
            initializeItemRow(row);
            itemCounter++;
        });

        // Update totals after all rows are initialized
        updateTotals();

        // Add event listener to "Add Item" button
        const addItemButton = document.getElementById('add-item');
        if (addItemButton) {
            // Remove any existing listeners
            const newAddItemButton = addItemButton.cloneNode(true);
            addItemButton.parentNode.replaceChild(newAddItemButton, addItemButton);
            
            newAddItemButton.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                addItemRow();
            });
        }

        // Add event listeners to discount and tax rate inputs
        const discountInput = document.getElementById('discount');
        const taxRateInput = document.getElementById('tax_percentage');
        
        if (discountInput) {
            discountInput.addEventListener('input', updateTotals);
        }
        
        if (taxRateInput) {
            taxRateInput.addEventListener('input', updateTotals);
        }

        // Add event listener for currency change
        const currencySelect = document.getElementById('currancy');
        if (currencySelect) {
            currencySelect.addEventListener('change', function() {
                // Update all item totals with new currency
                document.querySelectorAll('.invoice-item').forEach(row => {
                    updateItemTotal(row);
                });
                // Update main totals
                updateTotals();
            });
        }

        // Initialize with first row if there are no items
        if (!document.querySelector('.invoice-item')) {
            addItemRow();
        }

        // Calculate initial totals
        updateTotals();
    });
}

// Function to show toast
function showToast(message) {
    const toast = document.createElement('div');
    toast.className = 'toast show position-fixed bottom-0 end-0 m-3';
    toast.setAttribute('role', 'alert');
    toast.innerHTML = `
        <div class="toast-header">
            <strong class="me-auto">تنبيه</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body">${message}</div>
    `;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
}

// Initial call to update totals on page load
updateTotals();
