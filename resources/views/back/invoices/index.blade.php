@extends('layouts.app')

@section('page-content')
<div class="container-fluid px-3 px-md-4">
    <div class="card shadow-sm">
        <div class="card-header py-3">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <h2 class="mb-0 fs-3">الفواتير</h2>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('invoices.create') }}" class="btn btn-primary w-100 w-sm-auto">
                        <i class="fas fa-plus me-1"></i> إنشاء فاتورة جديدة
                    </a>
                    <a href="{{ route('invoices.bulk.download') }}" class="btn btn-info w-100 w-sm-auto">
                        <i class="fas fa-download me-1"></i> تحميل مجموعة
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body p-3 p-md-4">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('invoices.index') }}" method="GET" class="mb-4">
                <div class="row g-3">
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="form-group">
                            <label class="form-label">رقم الفاتورة</label>
                            <input type="text" class="form-control" name="search" value="{{ request('search') }}"
                                placeholder="بحث برقم الفاتورة">
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="form-group">
                            <label class="form-label">العميل</label>
                            <select class="form-select select2-searchable" name="client">
                                <option value="">كل العملاء</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}" {{ request('client') == $client->id ? 'selected' : '' }}>
                                        {{ $client->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-2">
                        <div class="form-group">
                            <label class="form-label">الحالة</label>
                            <select class="form-select" name="status">
                                <option value="">كل الحالات</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                                <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>مدفوعة</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>ملغاة</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-2">
                        <div class="form-group">
                            <label class="form-label">من تاريخ</label>
                            <input type="date" class="form-control" name="date_from" value="{{ request('date_from') }}">
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-2">
                        <div class="form-group">
                            <label class="form-label">إلى تاريخ</label>
                            <input type="date" class="form-control" name="date_to" value="{{ request('date_to') }}">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="d-flex flex-wrap gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-1"></i> بحث
                            </button>
                            <a href="{{ route('invoices.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i> إعادة تعيين
                            </a>
                        </div>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>رقم الفاتورة</th>
                            <th>العميل</th>
                            <th>التاريخ</th>
                            <th>المجموع</th>
                            <th>الحالة</th>
                            <th class="text-end" style="min-width: 160px;">العمليات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($invoices as $invoice)
                            <tr>
                                <td>{{ $invoice->id }}</td>
                                <td>{{ $invoice->invoice_number }}</td>
                                <td>{{ $invoice->client->name }}</td>
                                <td>{{ $invoice->invoice_date->format('Y-m-d') }}</td>
                                <td>
                                    {{ number_format($invoice->total, 2) }}
                                    {{ $invoice->currency->symbol ?? $invoice->currency->code }}
                                </td>
                                <td>
                                    @switch($invoice->status)
                                        @case('pending')
                                            <span class="badge bg-warning">قيد الانتظار</span>
                                            @break
                                        @case('paid')
                                            <span class="badge bg-success">مدفوعة</span>
                                            @break
                                        @case('cancelled')
                                            <span class="badge bg-danger">ملغاة</span>
                                            @break
                                    @endswitch
                                </td>
                                <td>
                                    <div class="d-flex gap-2 justify-content-start align-items-center flex-wrap">
                                        <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-sm btn-info" title="عرض">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-sm btn-primary" title="تعديل">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('invoices.download', $invoice) }}" class="btn btn-sm btn-success" title="تحميل">
                                            <i class="fas fa-download"></i>
                                        </a>
                                        <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" class="d-inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد من حذف هذه الفاتورة؟')" title="حذف">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">لا توجد فواتير</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $invoices->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="bulkDownloadModal" tabindex="-1" aria-labelledby="bulkDownloadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bulkDownloadModalLabel">تحميل مجموعة فواتير</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('invoices.bulk.download') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="date_from" class="form-label">من تاريخ</label>
                        <input type="date" class="form-control" id="date_from" name="date_from" required>
                    </div>
                    <div class="mb-3">
                        <label for="date_to" class="form-label">إلى تاريخ</label>
                        <input type="date" class="form-control" id="date_to" name="date_to" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">تحميل</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    @media (max-width: 576px) {
        .table-responsive {
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch;
            margin-bottom: 1rem;
            max-width: 100%;
        }
        
        .table {
            margin-bottom: 0;
        }
        
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 12px;
            margin: 2px;
            min-width: 32px;
        }
        
        .table td, .table th {
            padding: 0.5rem;
            white-space: nowrap;
            vertical-align: middle;
        }
        
        .badge {
            font-size: 11px;
        }

        .d-flex.gap-2 {
            gap: 0.25rem !important;
            justify-content: flex-end !important;
        }

        .table td:last-child {
            padding-right: 0.75rem !important;
        }
        
        /* Hide less important columns on mobile */
        .table td:nth-child(1), /* ID column */
        .table th:nth-child(1),
        .table td:nth-child(4), /* Date column */
        .table th:nth-child(4) {
            display: none;
        }
    }
</style>
@endpush
