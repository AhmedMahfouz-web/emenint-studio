@extends('layouts.app')
@section('page-content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2 class="mb-0">تعديل الفاتورة رقم {{ $invoice->invoice_number }}</h2>
                    <a href="{{ route('invoices.index') }}" class="btn btn-secondary">عودة للفواتير</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('invoices.update', $invoice) }}" method="POST" id="invoiceForm">
                        @csrf
                        @method('PUT')

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="client_id" class="form-label">العميل</label>
                                    <select class="form-select @error('client_id') is-invalid @enderror" id="client_id"
                                        name="client_id" required>
                                        <option value="">حدد العميل</option>
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->id }}"
                                                {{ old('client_id', $invoice->client_id) == $client->id ? 'selected' : '' }}>
                                                {{ $client->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('client_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="invoice_date" class="form-label">تاريخ الفاتورة</label>
                                    <input type="date" class="form-control @error('invoice_date') is-invalid @enderror"
                                        id="invoice_date" name="invoice_date"
                                        value="{{ old('invoice_date', $invoice->invoice_date->format('Y-m-d')) }}" required>
                                    @error('invoice_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="mb-3">
                                    <label class="form-label text-dark fw-bold">نسبة الضريبة</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control @error('tax-rate') is-invalid @enderror"
                                            id="tax-rate" name="tax-rate" value="14" min="0" max="100">
                                        <span class="input-group-text">%</span>
                                    </div>
                                    @error('tax-rate')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="mb-3">
                                    <label class="form-label text-dark fw-bold">الخصم</label>
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
                        </div>

                        <div class="card mb-4">
                            <div class="card-header">
                                <h4 class="mb-0">عناصر الفاتورة</h4>
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
                                        <div class="col-md-2">
                                            <label class="form-label">الكمية</label>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">سعر المنتج</label>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">المجموع</label>
                                        </div>
                                    </div>
                                    @foreach ($invoice->items as $index => $item)
                                        <div class="invoice-item row mb-2">
                                            <div class="col-md-4">
                                                <select class="form-select product-select"
                                                    name="items[{{ $index }}][product_id]" required>
                                                    <option value="">حدد المنتج</option>
                                                    @foreach ($products as $product)
                                                        <option value="{{ $product->id }}"
                                                            data-price="{{ $product->unit_price }}"
                                                            {{ $item->product_id == $product->id ? 'selected' : '' }}>
                                                            {{ $product->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" class="form-control quantity"
                                                    name="items[{{ $index }}][descreption]"
                                                    value="{{ $item->descreption }}" required>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="number" class="form-control quantity"
                                                    name="items[{{ $index }}][quantity]"
                                                    value="{{ $item->quantity }}" min="1" required>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="number" class="form-control unit-price" step="0.01"
                                                    value="{{ $item->price }}" readonly>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="number" class="form-control item-total" step="0.01"
                                                    value="{{ $item->total }}" readonly>
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button" class="btn btn-danger remove-item">حذف</button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <button type="button" class="btn btn-success mt-2" id="add-item">إضافة عنصر</button>
                            </div>
                        </div>

                        <div class="row justify-content-end mb-4">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>المجموع الفرعي:</span>
                                            <span id="subtotal">{{ number_format($invoice->subtotal, 2) }} ج.م</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>خصم :</span>
                                            <span id="tax">{{ number_format($invoice->discount, 2) }} ج.م</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>ضريبة ({{ $invoice->tax_rate }}%):</span>
                                            <span id="tax">{{ number_format($invoice->tax_amount, 2) }} ج.م</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <strong>المجموع:</strong>
                                            <strong id="total">{{ number_format($invoice->total, 2) }} ج.م</strong>
                                        </div>
                                        <input type="hidden" name="subtotal" id="subtotal-input"
                                            value="{{ $invoice->subtotal }}">
                                        <input type="hidden" name="tax_amount" id="tax-input"
                                            value="{{ $invoice->tax_amount }}">
                                        <input type="hidden" name="total" id="total-input"
                                            value="{{ $invoice->total }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">ملاحظات</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="first_note" rows="3">{{ empty(old('first_note')) ? $invoice->first_note : old('first_note') }}</textarea>
                            @error('first_note')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <label for="notes" class="form-label">ملاحظات</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="second_note"
                                rows="3">{{ empty(old('second_note')) ? $invoice->second_note : old('second_note') }} }}</textarea>
                            @error('second_note')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('invoices.index') }}" class="btn btn-secondary me-md-2">إلغاء</a>
                            <button type="submit" class="btn btn-primary">تحديث الفاتورة</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@section('scripts')
    <script src="{{ asset('js/invoice.js') }}"></script>
@endsection

@endsection
