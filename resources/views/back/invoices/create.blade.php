@extends('layouts.app')

@section('page-content')
    <div class="container py-4">
        <h2 class="mb-4 text-center text-dark fw-bold">إنشاء فاتورة جديدة</h2>
        <form action="{{ route('invoices.store') }}" method="POST" id="invoiceForm">
            @csrf

            <div class="mb-4">
                <label for="client_id" class="form-label text-dark fw-bold">العميل</label>

                <select class="form-select select2-searchable product-select" name="client_id" required>
                    <option value="">اختر المنتج</option>
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}" data-code="{{ $client->code }}" ">
                                                                                                                                                        {{ $client->code }} - {{ $client->name }}
                                                                                                                                                    </option>
     @endforeach
                </select>
                @error('client_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class=" row mb-4">
                <div class="col-md-6">
                    <label for="invoice_date" class="form-label text-dark fw-bold">تاريخ الفاتورة</label>
                    <input type="date" class="form-control @error('invoice_date') is-invalid @enderror" id="invoice_date"
                        name="invoice_date" required>
                    @error('invoice_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="currency" class="form-label text-dark fw-bold">العملة</label>
                    <select class="form-select" id="currancy" name="currancy" required>
                        <option value="EGP">EGP</option>
                        <option value="$">$</option>
                    </select>
                    @error('currancy')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="form-label text-dark fw-bold">نسبة الضريبة</label>
                    <div class="input-group">
                        <input type="number" class="form-control @error('tax-rate') is-invalid @enderror" id="tax-rate"
                            name="tax-rate" value="0" min="0" max="100">
                        <span class="input-group-text">%</span>
                    </div>
                    @error('tax-rate')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label text-dark fw-bold">الخصم</label>
                    <div class="input-group">
                        <input type="number" class="form-control @error('discount') is-invalid @enderror" id="discount"
                            name="discount" value="0" min="0" step="0.01">
                        <span class="input-group-text">ج.م</span>
                    </div>
                    @error('discount')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h4 class="mb-0">بنود الفاتورة</h4>
                </div>
                <div class="card-body">
                    <div id="invoice-items">
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <label class="form-label">المنتج</label>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">الوصف</label>
                            </div>
                            <div class="col-md-1">
                                <label class="form-label">الكمية</label>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">السعر</label>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">المجموع</label>
                            </div>
                            <div class="col-md-1">
                                <label class="form-label">العمليات</label>
                            </div>
                        </div>
                        <div class="invoice-item row mb-2">
                            <div class="col-md-4">
                                <select class="form-select select2-searchable product-select" name="items[0][product_id]"
                                    required>
                                    <option value="">اختر المنتج</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}" data-code="{{ $product->code }}"
                                            data-price="{{ $product->price }}">
                                            {{ $product->code }} - {{ $product->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control quantity" name="items[0][descreption]"
                                    placeholder="اكتب وصف..." required>
                            </div>
                            <div class="col-md-1">
                                <input type="number" class="form-control quantity" name="items[0][quantity]" value="1"
                                    min="1" required>
                            </div>
                            <div class="col-md-2">
                                <input type="number" class="form-control unit-price" name="items[0][price]" step="0.01">
                            </div>
                            <div class="col-md-2">
                                <input type="number" class="form-control item-total" step="0.01" readonly>
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-danger remove-item">حذف</button>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-success mt-2" id="add-item">إضافة بند</button>
                </div>
            </div>

            <div class="row justify-content-end mb-4">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <strong>المجموع الفرعي:</strong>
                                </div>
                                <div class="col-6 text-end">
                                    <span id="subtotal-display">0.00 ج.م</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <strong>الخصم:</strong>
                                </div>
                                <div class="col-6 text-end">
                                    <span id="discount-display">0.00 ج.م</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <strong>قيمة الضريبة:</strong>
                                </div>
                                <div class="col-6 text-end">
                                    <span id="tax-amount-display">0.00 ج.م</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <strong>الإجمالي:</strong>
                                </div>
                                <div class="col-6 text-end">
                                    <span id="total-display">0.00 ج.م</span>
                                </div>
                            </div>
                            <input type="hidden" name="subtotal" id="subtotal-input" value="0.00">
                            <input type="hidden" name="tax_amount" id="tax-input" value="0.00">
                            <input type="hidden" name="total" id="total-input" value="0.00">
                        </div>
                    </div>
                </div>

                <div class="md-3">
                    <label for="payment_method" class="form-label text-dark fw-bold">طريقة الدفع</label>
                    <select class="form-select" id="payment_method" name="payment_method" required>
                        <option value="Cash">Cash</option>
                        <option value="Western Union">Western Union</option>
                        <option value="Instapay">Instapay</option>
                    </select>
                    @error('payment_method')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="notes" class="form-label">ملاحظات</label>
                <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="first_note" rows="4">{{ empty(old('first_note'))
                    ? 'Kindly Note that all pricing, denominated in USD currency, is structured into two payment installments. The initial payment amounts to 70% of the total cost, and the final 30% payment is to be made upon receiving the completed work. ** We offer a guarantee that this work will be accessible with lifetime access upon request. Quotation avaliable for one week'
                    : old('first_note') }}</textarea>
                @error('first_note')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <label for="notes" class="form-label">ملاحظات</label>
                <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="second_note"
                    rows="4">{{ empty(old('second_note'))
                        ? 'If you have any inquiries concerning pricing details, please don\'t hesitate to reach out to us. We would be delighted to provide further clarification and ensure a more precise understanding, even if it\'s solely for the purpose of clarity. Your trust from the outset is greatly appreciated, and We’re here to assist you. Thank you'
                        : old('second_note') }} }}</textarea>
                @error('second_note')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary">حفظ الفاتورة</button>
                <a href="{{ route('invoices.index') }}" class="btn btn-secondary">عودة للفواتير</a>
            </div>
        </form>
    </div>

@section('scripts')
    @vite(['resources/js/invoice.js'])
@endsection

@if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @foreach ($errors->all() as $error)
                showToast("{{ $error }}");
                console.log("{{ $error }}");
            @endforeach
        });
    </script>
@endif
@endsection
