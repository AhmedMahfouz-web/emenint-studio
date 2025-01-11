@extends('layouts.app')

@section('page-content')
<div class="container-fluid px-3 px-md-4">
    <div class="card shadow-sm">
        <div class="card-header py-3">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <h2 class="mb-0 fs-3">عرض السعر #{{ $quotation->quotation_number }}</h2>
                <div class="d-flex gap-2">
                    <a href="{{ route('quotations.edit', $quotation) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-1"></i> تعديل
                    </a>
                    <a href="{{ route('invoices.create', ['quotation_id' => $quotation->id]) }}" class="btn btn-success">
                        <i class="fas fa-file-invoice me-1"></i> Create Invoice
                    </a>
                    <a href="{{ route('quotations.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-right me-1"></i> عودة لعروض الأسعار
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body p-3 p-md-4">
            <div class="row g-4 mb-4">
                <div class="col-12 col-md-6">
                    <h5 class="fw-bold mb-3">معلومات العميل</h5>
                    <div class="card border">
                        <div class="card-body">
                            <p class="mb-1"><strong>الاسم:</strong> {{ $quotation->client->name }}</p>
                            <p class="mb-1"><strong>الكود:</strong> {{ $quotation->client->code }}</p>
                            <p class="mb-1"><strong>الهاتف:</strong> {{ $quotation->client->phone }}</p>
                            <p class="mb-0"><strong>العنوان:</strong> {{ $quotation->client->address }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <h5 class="fw-bold mb-3">معلومات عرض السعر</h5>
                    <div class="card border">
                        <div class="card-body">
                            <p class="mb-1"><strong>رقم عرض السعر:</strong> {{ $quotation->quotation_number }}</p>
                            <p class="mb-1"><strong>التاريخ:</strong> {{ $quotation->quotation_date->format('Y-m-d') }}</p>
                            <p class="mb-1"><strong>العملة:</strong> {{ $quotation->currancy }}</p>
                            <p class="mb-0">
                                <strong>الحالة:</strong>
                                @switch($quotation->status)
                                    @case('pending')
                                        <span class="badge bg-warning">قيد الانتظار</span>
                                        @break
                                    @case('approved')
                                        <span class="badge bg-success">تمت الموافقة</span>
                                        @break
                                    @case('rejected')
                                        <span class="badge bg-danger">مرفوض</span>
                                        @break
                                @endswitch
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border mb-4">
                <div class="card-header py-3">
                    <h4 class="mb-0 fs-5">بنود عرض السعر</h4>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>المنتج</th>
                                    <th>الوصف</th>
                                    <th>الكمية</th>
                                    <th>السعر</th>
                                    <th>المجموع</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($quotation->items as $item)
                                <tr>
                                    <td>{{ $item->product->name }}</td>
                                    <td>{{ $item->description }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ number_format($item->unit_price, 2) }} {{ $quotation->currancy }}</td>
                                    <td>{{ number_format($item->total, 2) }} {{ $quotation->currancy }}</td>
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
                                <span>{{ number_format($quotation->subtotal, 2) }} {{ $quotation->currancy }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="fw-bold">الخصم:</span>
                                <span>{{ number_format($quotation->discount, 2) }} {{ $quotation->currancy }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="fw-bold">الضريبة:</span>
                                <span>{{ number_format($quotation->tax_amount, 2) }} {{ $quotation->currancy }}</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <span class="fw-bold fs-5">الإجمالي:</span>
                                <span class="fw-bold fs-5">{{ number_format($quotation->total, 2) }} {{ $quotation->currancy }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($quotation->first_note || $quotation->second_note)
            <div class="row g-3">
                @if($quotation->first_note)
                <div class="col-12">
                    <div class="card border">
                        <div class="card-body">
                            <h6 class="fw-bold mb-2">ملاحظات</h6>
                            <p class="mb-0">{{ $quotation->first_note }}</p>
                        </div>
                    </div>
                </div>
                @endif

                @if($quotation->second_note)
                <div class="col-12">
                    <div class="card border">
                        <div class="card-body">
                            <h6 class="fw-bold mb-2">ملاحظات إضافية</h6>
                            <p class="mb-0">{{ $quotation->second_note }}</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
