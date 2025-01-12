@extends('layouts.app')

@section('page-content')
<div class="container-fluid px-3 px-md-4">
    <div class="card shadow-sm">
        <div class="card-header py-3">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <h2 class="mb-0 fs-3">تعديل الفاتورة رقم {{ $invoice->invoice_number }}</h2>
                <a href="{{ route('invoices.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-right me-1"></i> عودة للفواتير
                </a>
            </div>
        </div>

        <div class="card-body p-3 p-md-4">
            <form action="{{ route('invoices.update', $invoice) }}" method="POST" id="invoiceForm">
                @csrf
                @method('PUT')

                <div class="row g-4 mb-4">
                    <div class="col-12">
                        <label for="client_id" class="form-label fw-bold">العميل</label>
                        <select class="form-select select2-searchable" name="client_id" required>
                            <option value="">اختر العميل</option>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}"
                                    {{ old('client_id', $invoice->client_id) == $client->id ? 'selected' : '' }}
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
                        <label for="invoice_date" class="form-label fw-bold">تاريخ الفاتورة</label>
                        <input type="date" class="form-control @error('invoice_date') is-invalid @enderror"
                            id="invoice_date" name="invoice_date"
                            value="{{ old('invoice_date', $invoice->invoice_date->format('Y-m-d')) }}" required>
                        @error('invoice_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="currency" class="form-label fw-bold">العملة</label>
                        <select class="form-select" id="currancy" name="currancy" required>
                            <option value="EGP" {{ $invoice->currancy == 'EGP' ? 'selected' : '' }}>EGP</option>
                            <option value="$" {{ $invoice->currancy == '$' ? 'selected' : '' }}>$</option>
                        </select>
                        @error('currancy')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-bold">Payment Method</label>
                        <select class="form-select" id="payment_method" name="payment_method" required>
                            <option value="Cash" {{ $invoice->payment_method == 'Cash' ? 'selected' : '' }}>Cash</option>
                            <option value="Western Union" {{ $invoice->payment_method == 'Western Union' ? 'selected' : '' }}>Western Union</option>
                            <option value="Instapay" {{ $invoice->payment_method == 'Instapay' ? 'selected' : '' }}>Instapay</option>
                        </select>
                        @error('payment_method')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-bold">حالة الفاتورة</label>
                        <select class="form-select" name="status" required>
                            <option value="pending" {{ $invoice->status == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                            <option value="paid" {{ $invoice->status == 'paid' ? 'selected' : '' }}>مدفوعة</option>
                            <option value="cancelled" {{ $invoice->status == 'cancelled' ? 'selected' : '' }}>ملغاة</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-bold">نسبة الضريبة</label>
                        <div class="input-group">
                            <input type="number" class="form-control @error('tax-rate') is-invalid @enderror"
                                id="tax-rate" name="tax-rate" value="{{ old('tax-rate', $invoice->tax_rate) }}"
                                min="0" max="100">
                            <span class="input-group-text">%</span>
                        </div>
                        @error('tax-rate')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-bold">الخصم</label>
                        <div class="input-group">
                            <input type="number" class="form-control @error('discount') is-invalid @enderror"
                                id="discount" name="discount" value="{{ old('discount', $invoice->discount) }}"
                                min="0" step="0.01">
                            <span class="input-group-text">ج.م</span>
                        </div>
                        @error('discount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-12">
                        <label class="form-label fw-bold">Notes</label>
                        <textarea class="form-control" name="first_note" rows="3">{{ $invoice->first_note ?? 'Kindly Note that all pricing, denominated in USD currency, is structured into two payment installments. The initial payment amounts to 70% of the total cost, and the final 30% payment is to be made upon receiving the completed work. ** We offer a guarantee that this work will be accessible with lifetime access upon request. Quotation avaliable for one week' }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold">Additional Notes</label>
                        <textarea class="form-control" name="second_note" rows="3">{{ $invoice->second_note ?? 'If you have any inquiries concerning pricing details, please don't hesitate to reach out to us. We would be delighted to provide further clarification and ensure a more precise understanding, even if it's solely for the purpose of clarity. Your trust from the outset is greatly appreciated, and We're here to assist you. Thank you' }}</textarea>
                    </div>
                </div>

                <div class="card border mb-4">
                    <div class="card-header py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0 fs-5">بنود الفاتورة</h4>
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
                                    @foreach($invoice->items as $item)
                                    <tr class="invoice-item">
                                        <td data-label="المنتج">
                                            <select class="form-select select2-searchable" name="items[{{ $loop->index }}][product_id]" required>
                                                <option value="">اختر المنتج</option>
                                                @foreach($products as $product)
                                                    <option value="{{ $product->id }}"
                                                        {{ $item->product_id == $product->id ? 'selected' : '' }}
                                                        data-price="{{ $product->price }}"
                                                        data-code="{{ $product->code }}">
                                                        {{ $product->code }} - {{ $product->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td data-label="الوصف">
                                            <input type="text" class="form-control description"
                                                name="items[{{ $loop->index }}][description]"
                                                value="{{ $item->description }}">
                                        </td>
                                        <td data-label="الكمية">
                                            <input type="number" class="form-control quantity"
                                                name="items[{{ $loop->index }}][quantity]"
                                                value="{{ $item->quantity }}" min="1" required>
                                        </td>
                                        <td data-label="السعر">
                                            <input type="number" class="form-control unit-price"
                                                name="items[{{ $loop->index }}][unit_price]"
                                                value="{{ $item->price }}" min="0" step="0.01" required>
                                        </td>
                                        <td data-label="المجموع">
                                            <input type="hidden" name="items[{{ $loop->index }}][total]" value="{{ $item->total }}">
                                            <span class="item-total-display">{{ number_format($item->total, 2) }} ج.م</span>
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
                                    <span id="subtotal">{{ number_format($invoice->subtotal, 2) }} ج.م</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="fw-bold">الخصم:</span>
                                    <span id="discount-amount">{{ number_format($invoice->discount_value, 2) }} ج.م</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="fw-bold">الضريبة:</span>
                                    <span id="tax-amount">{{ number_format($invoice->tax_amount, 2) }} ج.م</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <span class="fw-bold">المجموع:</span>
                                    <span id="total">{{ number_format($invoice->total, 2) }} ج.م</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2 justify-content-end">
                    <button type="button" class="btn btn-secondary" onclick="window.history.back()">إلغاء</button>
                    <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    @media (max-width: 768px) {
        .table-responsive {
            margin: -1px;
        }

        .table-responsive table {
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
        }

        .select2-container {
            width: 100% !important;
        }
    }
</style>

@push('scripts')
    <script>
        console.log('Edit invoice page loaded');
    </script>
    <script src="{{ asset('js/invoice.js') }}" defer></script>
@endpush

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@endsection
