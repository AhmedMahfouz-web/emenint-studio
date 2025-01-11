@extends('layouts.app')

@section('page-content')
<div class="container-fluid px-3 px-md-4">
    <div class="card shadow-sm">
        <div class="card-header py-3">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <h2 class="mb-0 fs-3">تفاصيل الفاتورة رقم {{ $invoice->invoice_number }}</h2>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('invoices.download', $invoice) }}" class="btn btn-dark">
                        <i class="fas fa-download me-1"></i> تحميل PDF
                    </a>
                    <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-1"></i> تعديل
                    </a>
                    <a href="{{ route('invoices.index') }}" class="btn btn-primary">
                        <i class="fas fa-list me-1"></i> القائمة
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body p-3 p-md-4">
            <div class="row g-4 mb-4">
                <div class="col-12 col-md-6">
                    <div class="card h-100 border">
                        <div class="card-body">
                            <h6 class="card-title mb-3 fw-bold">معلومات العميل</h6>
                            <div class="d-flex flex-column gap-2">
                                <div class="fw-bold fs-5">{{ $invoice->client->name }}</div>
                                <div><span class="fw-bold">كود العميل:</span> {{ $invoice->client->code }}</div>
                                <div><span class="fw-bold">العنوان:</span> {{ $invoice->client->address }}</div>
                                <div><span class="fw-bold">البريد الإلكتروني:</span> {{ $invoice->client->email }}</div>
                                <div><span class="fw-bold">الهاتف:</span> {{ $invoice->client->phone }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-12 col-md-6">
                    <div class="card h-100 border">
                        <div class="card-body">
                            <h6 class="card-title mb-3 fw-bold">معلومات الفاتورة</h6>
                            <div class="d-flex flex-column gap-2">
                                <div>
                                    <span class="fw-bold">تاريخ الفاتورة:</span> 
                                    {{ $invoice->invoice_date ? ($invoice->invoice_date->format('Y/m/d')) : 'غير محدد' }}
                                </div>
                                <div>
                                    <span class="fw-bold">رقم الفاتورة:</span> 
                                    {{ $invoice->invoice_number }}
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <div class="d-flex justify-content-between">
                                        <span class="fw-bold">طريقة الدفع:</span>
                                        <span>{{ $invoice->payment_method }}</span>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 mb-3">
                                    <div class="d-flex justify-content-between">
                                        <span class="fw-bold">حالة الفاتورة:</span>
                                        <span class="badge {{ $invoice->status == 'paid' ? 'bg-success' : ($invoice->status == 'cancelled' ? 'bg-danger' : 'bg-warning') }}">
                                            {{ $invoice->status == 'pending' ? 'قيد الانتظار' : ($invoice->status == 'paid' ? 'مدفوعة' : 'ملغاة') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="bg-light">
                        <tr>
                            <th>#</th>
                            <th>الكود</th>
                            <th>المنتج</th>
                            <th>الكمية</th>
                            <th>السعر</th>
                            <th>المجموع</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        @if($invoice->items && $invoice->items->isNotEmpty())
                            @foreach($invoice->items as $index => $item)
                            <tr>
                                <td data-label="#">{{ $index + 1 }}</td>
                                <td data-label="الكود">{{ $item->product->code ?? 'غير محدد' }}</td>
                                <td data-label="المنتج">{{ $item->product->name ?? 'غير محدد' }}</td>
                                <td data-label="الكمية">{{ $item->quantity ?? 'غير محدد' }}</td>
                                <td data-label="السعر">{{ number_format($item->price ?? 0, 2) }} ج.م</td>
                                <td data-label="المجموع">{{ number_format($item->total ?? 0, 2) }} ج.م</td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-center">لا توجد عناصر في هذه الفاتورة.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <div class="row justify-content-end mt-4">
                <div class="col-12 col-md-5 col-lg-4">
                    <div class="card border">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="fw-bold">المجموع الفرعي:</span>
                                <span>{{ number_format($invoice->subtotal ?? 0, 2) }} ج.م</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="fw-bold">خصم:</span>
                                <span>{{ number_format($invoice->discount_value ?? 0, 2) }} ج.م</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="fw-bold">الضريبة (14%):</span>
                                <span>{{ number_format($invoice->tax_amount ?? 0, 2) }} ج.م</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <span class="fw-bold fs-5">الإجمالي:</span>
                                <span class="fw-bold fs-5">{{ number_format($invoice->total ?? 0, 2) }} ج.م</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media (max-width: 768px) {
        .table-responsive table {
            border: 0;
        }
        
        .table-responsive table thead {
            display: none;
        }
        
        .table-responsive table tr {
            display: block;
            margin-bottom: 1rem;
            border: 1px solid #ddd;
            border-radius: 0.5rem;
            padding: 1rem;
            background-color: #fff;
        }
        
        .table-responsive table td {
            display: block;
            text-align: right;
            padding: 0.5rem 0;
            border: none;
        }
        
        .table-responsive table td:before {
            content: attr(data-label);
            float: right;
            font-weight: bold;
            margin-left: 0.5rem;
        }
        
        .table-responsive table td:last-child {
            border-bottom: 0;
        }
    }
</style>
@endsection
