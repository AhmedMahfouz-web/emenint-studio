@extends('layouts.app')

@section('page-content')
<div class="container-fluid px-3 px-md-4">
    <div class="card shadow-sm">
        <div class="card-header py-3">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <h2 class="mb-0 fs-3">تعديل عرض السعر #{{ $quotation->quotation_number }}</h2>
                <a href="{{ route('quotations.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-right me-1"></i> عودة لعروض الأسعار
                </a>
            </div>
        </div>

        <div class="card-body p-3 p-md-4">
            <form action="{{ route('quotations.update', $quotation) }}" method="POST" id="quotationForm">
                @csrf
                @method('PUT')

                <div class="row g-4 mb-4">
                    <div class="col-12">
                        <label for="client_id" class="form-label fw-bold">العميل</label>
                        <select class="form-select select2-searchable" name="client_id" required>
                            <option value="">اختر العميل</option>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}" 
                                    {{ $quotation->client_id == $client->id ? 'selected' : '' }}
                                    data-code="{{ $client->code }}">
                                    {{ $client->code }} - {{ $client->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('client_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="quotation_date" class="form-label fw-bold">تاريخ عرض السعر</label>
                        <input type="date" class="form-control @error('quotation_date') is-invalid @enderror"
                            id="quotation_date" name="quotation_date" value="{{ $quotation->quotation_date->format('Y-m-d') }}" required>
                        @error('quotation_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="currancy" class="form-label fw-bold">العملة</label>
                        <select class="form-select" name="currency_id" id="currancy" required>
                            @foreach($currencies as $currency)
                                <option value="{{ $currency->id }}" 
                                    {{ old('currency_id', $quotation->currency_id) == $currency->id ? 'selected' : '' }}
                                    data-symbol="{{ $currency->symbol }}">
                                    {{ $currency->code }} - {{ $currency->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('currency_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-bold">نسبة الضريبة</label>
                        <div class="input-group">
                            <input type="number" class="form-control @error('tax_percentage') is-invalid @enderror"
                                id="tax_percentage" name="tax_percentage" 
                                value="{{ old('tax_percentage', $quotation->tax_percentage) }}" 
                                min="0" max="100">
                            <span class="input-group-text">%</span>
                        </div>
                        @error('tax_percentage')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-bold">الخصم</label>
                        <div class="input-group">
                            <input type="number" class="form-control @error('discount') is-invalid @enderror"
                                id="discount" name="discount" 
                                value="{{ old('discount', $quotation->discount) }}" 
                                min="0" step="0.01">
                            <span class="input-group-text currency-symbol">{{ $quotation->currency->symbol }}</span>
                        </div>
                        @error('discount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-bold">حالة عرض السعر</label>
                        <select class="form-select" name="status" required>
                            <option value="pending" {{ old('status', $quotation->status) == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                            <option value="accepted" {{ old('status', $quotation->status) == 'accepted' ? 'selected' : '' }}>مقبول</option>
                            <option value="rejected" {{ old('status', $quotation->status) == 'rejected' ? 'selected' : '' }}>مرفوض</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="card border mb-4">
                    <div class="card-header py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0 fs-5">بنود عرض السعر</h4>
                            <button type="button" class="btn btn-primary" id="add-item">
                                <i class="fas fa-plus me-1"></i> إضافة بند
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table mb-0" id="invoice-items">
                                <thead class="bg-light">
                                    <tr>
                                        <th>المنتج</th>
                                        <th>الوصف</th>
                                        <th>الكمية</th>
                                        <th>السعر</th>
                                        <th>المجموع</th>
                                        <th>العمليات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($quotation->items as $item)
                                    <tr class="invoice-item">
                                        <td data-label="المنتج">
                                            <select class="form-select select2-searchable" name="items[{{ $loop->index }}][product_id]" required>
                                                <option value="">اختر المنتج</option>
                                                @foreach($products as $product)
                                                    <option value="{{ $product->id }}" 
                                                        {{ $item->product_id == $product->id ? 'selected' : '' }}
                                                        data-unit-price="{{ $product->price }}"
                                                        data-code="{{ $product->code }}">
                                                        {{ $product->code }} - {{ $product->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td data-label="الوصف">
                                            <input type="text" class="form-control" name="items[{{ $loop->index }}][description]" 
                                                value="{{ $item->description }}">
                                        </td>
                                        <td data-label="الكمية">
                                            <input type="number" class="form-control quantity" name="items[{{ $loop->index }}][quantity]" 
                                                value="{{ $item->quantity }}" min="1" required>
                                        </td>
                                        <td data-label="السعر">
                                            <input type="number" class="form-control unit-price" name="items[{{ $loop->index }}][unit_price]" 
                                                value="{{ $item->unit_price }}" min="0" step="0.01" required>
                                        </td>
                                        <td data-label="المجموع">
                                            <input type="hidden" name="items[{{ $loop->index }}][total]" value="{{ $item->total }}">
                                            <span class="item-total-display">{{ number_format($item->total, 2) }} {{ $quotation->currency->symbol }}</span>
                                        </td>
                                        <td data-label="العمليات">
                                            <button type="button" class="btn btn-danger btn-sm remove-item">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-end mb-4">
                    <div class="col-12 col-md-5 col-lg-4">
                        <div class="card border">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="fw-bold">المجموع الفرعي:</span>
                                    <span id="subtotal">{{ number_format($quotation->subtotal, 2) }} {{ $quotation->currency->symbol }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="fw-bold">الخصم:</span>
                                    <span id="discount-amount">{{ number_format($quotation->discount, 2) }} {{ $quotation->currency->symbol }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="fw-bold">الضريبة:</span>
                                    <span id="tax-amount">{{ number_format($quotation->tax_amount, 2) }} {{ $quotation->currency->symbol }}</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <span class="fw-bold fs-5">الإجمالي:</span>
                                    <span class="fw-bold fs-5" id="total">{{ number_format($quotation->total, 2) }} {{ $quotation->currency->symbol }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-12">
                        <label class="form-label fw-bold">Notes</label>
                        <textarea class="form-control" name="first_note" rows="3">{{ $quotation->first_note ?? 'Kindly Note that all pricing, denominated in USD currency, is structured into two payment installments. The initial payment amounts to 70% of the total cost, and the final 30% payment is to be made upon receiving the completed work. ** We offer a guarantee that this work will be accessible with lifetime access upon request. Quotation avaliable for one week' }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold">Additional Notes</label>
                        <textarea class="form-control" name="second_note" rows="3">{{ $quotation->second_note ?? 'If you have any inquiries concerning pricing details, please don\'t hesitate to reach out to us. We would be delighted to provide further clarification and ensure a more precise understanding, even if it\'s solely for the purpose of clarity. Your trust from the outset is greatly appreciated, and We\'re here to assist you. Thank you' }}</textarea>
                    </div>
                </div>

                <div class="d-flex gap-2 justify-content-end">
                    <button type="button" class="btn btn-secondary" onclick="window.history.back()">إلغاء</button>
                    <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    @media (max-width: 768px) {
        .table-responsive {
            border: 0;
        }

        .table-responsive table thead {
            display: none;
        }

        .table-responsive table tbody tr {
            display: grid;
            grid-template-columns: 1fr;
            gap: 0.5rem;
            margin-bottom: 1rem;
            padding: 1rem;
            border: 1px solid #ddd;
            border-radius: 0.5rem;
            background-color: #fff;
        }

        .table-responsive table td {
            display: grid;
            grid-template-columns: 1fr 2fr;
            align-items: center;
            padding: 0.5rem;
            border: none;
        }

        .table-responsive table td::before {
            content: attr(data-label);
            font-weight: bold;
            margin-left: 0.5rem;
        }

        .select2-container {
            width: 100% !important;
        }

        .form-control {
            width: 100%;
        }

        .btn {
            width: 100%;
            margin-top: 0.5rem;
        }

        .card-body {
            padding: 1rem !important;
        }

        .invoice-item {
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
    }
</style>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize currency symbols
        function updateCurrencySymbols() {
            const currencySelect = document.getElementById('currancy');
            if (!currencySelect) return;

            const selectedOption = currencySelect.options[currencySelect.selectedIndex];
            if (!selectedOption) return;

            const symbol = selectedOption.getAttribute('data-symbol') || 'ج.م';
            document.querySelectorAll('.currency-symbol').forEach(span => {
                span.textContent = symbol;
            });

            // Update totals with new currency
            if (typeof updateTotals === 'function') {
                updateTotals();
            }
        }

        // Add event listener for currency change
        const currencySelect = document.getElementById('currancy');
        if (currencySelect) {
            currencySelect.addEventListener('change', updateCurrencySymbols);
            // Initial update
            updateCurrencySymbols();
        }
    });
</script>
@endpush
@endsection
