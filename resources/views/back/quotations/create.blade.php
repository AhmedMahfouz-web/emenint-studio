@extends('layouts.app')

@section('page-content')
<div class="container-fluid px-3 px-md-4">
    <div class="card shadow-sm">
        <div class="card-header py-3">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <h2 class="mb-0 fs-3">إنشاء عرض سعر جديد</h2>
                <a href="{{ route('quotations.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-right me-1"></i> عودة لعروض الأسعار
                </a>
            </div>
        </div>

        <div class="card-body p-3 p-md-4">
            <form action="{{ route('quotations.store') }}" method="POST" id="quotationForm">
                @csrf

                <div class="row g-4 mb-4">
                    <div class="col-12">
                        <label for="client_id" class="form-label fw-bold">العميل</label>
                        <select class="form-select select2-searchable" name="client_id" required>
                            <option value="">اختر العميل</option>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}" data-code="{{ $client->code }}">
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
                            id="quotation_date" name="quotation_date" value="{{ date('Y-m-d') }}" required>
                        @error('quotation_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="currency" class="form-label fw-bold">العملة</label>
                        <select class="form-select" id="currancy" name="currancy" required>
                            <option value="USD">USD</option>
                            <option value="EGP">EGP</option>
                            <option value="EUR">EUR</option>
                        </select>
                        @error('currancy')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-bold">نسبة الضريبة</label>
                        <div class="input-group">
                            <input type="number" class="form-control @error('tax_percentage') is-invalid @enderror"
                                id="tax_percentage" name="tax_percentage" value="0" min="0" max="100">
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
                                id="discount" name="discount" value="0" min="0" step="0.01">
                            <span class="input-group-text">ج.م</span>
                        </div>
                        @error('discount')
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
                                    <!-- Items will be added here dynamically -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <template id="item-template">
                    <tr class="invoice-item">
                        <td data-label="المنتج">
                            <select class="form-select select2-searchable" name="items[{index}][product_id]" required>
                                <option value="">اختر المنتج</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}"
                                        data-unit-price="{{ $product->unit_price }}"
                                        data-code="{{ $product->code }}">
                                        {{ $product->code }} - {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td data-label="الوصف">
                            <input type="text" class="form-control" name="items[{index}][description]">
                        </td>
                        <td data-label="الكمية">
                            <input type="number" class="form-control quantity" name="items[{index}][quantity]" value="1" min="1" required>
                        </td>
                        <td data-label="السعر">
                            <input type="number" class="form-control unit-price" name="items[{index}][unit_price]" min="0" step="0.01" required>
                        </td>
                        <td data-label="المجموع">
                            <input type="hidden" name="items[{index}][total]" value="0.00">
                            <span class="item-total-display">0.00</span>
                        </td>
                        <td data-label="العمليات">
                            <button type="button" class="btn btn-danger btn-sm remove-item">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </template>

                <div class="row justify-content-end mb-4">
                    <div class="col-12 col-md-5 col-lg-4">
                        <div class="card border">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="fw-bold">المجموع الفرعي:</span>
                                    <span id="subtotal">0.00 ج.م</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="fw-bold">الخصم:</span>
                                    <span id="discount-amount">0.00 ج.م</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="fw-bold">الضريبة:</span>
                                    <span id="tax-amount">0.00 ج.م</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <span class="fw-bold fs-5">الإجمالي:</span>
                                    <span class="fw-bold fs-5" id="total">0.00 ج.م</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-12">
                        <label class="form-label fw-bold">Notes</label>
                        <textarea class="form-control" name="first_note" rows="3">Kindly Note that all pricing, denominated in USD currency, is structured into two payment installments. The initial payment amounts to 70% of the total cost, and the final 30% payment is to be made upon receiving the completed work. ** We offer a guarantee that this work will be accessible with lifetime access upon request. Quotation avaliable for one week</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold">Additional Notes</label>
                        <textarea class="form-control" name="second_note" rows="3">If you have any inquiries concerning pricing details, please don't hesitate to reach out to us. We would be delighted to provide further clarification and ensure a more precise understanding, even if it's solely for the purpose of clarity. Your trust from the outset is greatly appreciated, and We're here to assist you. Thank you</textarea>
                    </div>
                </div>

                <div class="d-flex gap-2 justify-content-end">
                    <button type="button" class="btn btn-secondary" onclick="window.history.back()">إلغاء</button>
                    <button type="submit" class="btn btn-primary">حفظ عرض السعر</button>
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
    // Product options for dynamic rows
    window.productOptions = `
        <option value="">اختر المنتج</option>
        @foreach($products as $product)
            <option value="{{ $product->id }}"
                data-unit-price="{{ $product->unit_price }}"
                data-code="{{ $product->code }}">
                {{ $product->code }} - {{ $product->name }}
            </option>
        @endforeach
    `;
</script>
<script src="{{ asset('js/invoice.js') }}" defer></script>
@endpush
@endsection
