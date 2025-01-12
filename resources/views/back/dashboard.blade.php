@extends('layouts.app')

@section('page-content')
<div class="container-fluid px-3 px-md-4">
    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-lg bg-primary bg-opacity-10 rounded-circle">
                                <i class="fas fa-users fa-lg text-primary"></i>
                            </div>
                        </div>
                        <div>
                            <h6 class="card-subtitle mb-1 text-muted">إجمالي العملاء</h6>
                            <h2 class="card-title mb-0">{{ number_format($totalClients) }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-lg bg-success bg-opacity-10 rounded-circle">
                                <i class="fas fa-box fa-lg text-success"></i>
                            </div>
                        </div>
                        <div>
                            <h6 class="card-subtitle mb-1 text-muted">إجمالي المنتجات</h6>
                            <h2 class="card-title mb-0">{{ number_format($totalProducts) }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-lg bg-info bg-opacity-10 rounded-circle">
                                <i class="fas fa-file-alt fa-lg text-info"></i>
                            </div>
                        </div>
                        <div>
                            <h6 class="card-subtitle mb-1 text-muted">عروض الأسعار</h6>
                            <h2 class="card-title mb-0">{{ number_format($totalQuotations) }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-lg bg-warning bg-opacity-10 rounded-circle">
                                <i class="fas fa-file-invoice fa-lg text-warning"></i>
                            </div>
                        </div>
                        <div>
                            <h6 class="card-subtitle mb-1 text-muted">الفواتير</h6>
                            <h2 class="card-title mb-0">{{ number_format($totalInvoices) }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Revenue Cards -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title mb-4">إيرادات الشهر الحالي</h5>

                    <div class="mb-4">
                        <h6 class="text-success mb-3">الفواتير المدفوعة</h6>
                        @foreach($monthlyRevenue['paid'] as $paid)
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span>{{ $paid['currency'] }}</span>
                                <span class="text-success">{{ number_format($paid['amount']) }}</span>
                                <span class="badge bg-success">{{ $paid['count'] }} فواتير</span>
                            </div>
                        @endforeach
                    </div>

                    <div>
                        <h6 class="text-warning mb-3">الفواتير المعلقة</h6>
                        @foreach($monthlyRevenue['pending'] as $pending)
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span>{{ $pending['currency'] }}</span>
                                <span class="text-warning">{{ number_format($pending['amount']) }}</span>
                                <span class="badge bg-warning">{{ $pending['count'] }} فواتير</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title mb-4">إيرادات السنة الحالية</h5>

                    <div class="mb-4">
                        <h6 class="text-success mb-3">الفواتير المدفوعة</h6>
                        @foreach($yearlyRevenue['paid'] as $paid)
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span>{{ $paid['currency'] }}</span>
                                <span class="text-success">{{ number_format($paid['amount']) }}</span>
                                <span class="badge bg-success">{{ $paid['count'] }} فواتير</span>
                            </div>
                        @endforeach
                    </div>

                    <div>
                        <h6 class="text-warning mb-3">الفواتير المعلقة</h6>
                        @foreach($yearlyRevenue['pending'] as $pending)
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span>{{ $pending['currency'] }}</span>
                                <span class="text-warning">{{ number_format($pending['amount']) }}</span>
                                <span class="badge bg-warning">{{ $pending['count'] }} فواتير</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-4">إيرادات الشهرية</h5>
                    <canvas id="revenueChart" height="75"></canvas>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title mb-4">حالة الفواتير</h5>
                    <div style="height: 75px; position: relative;">
                        <canvas id="invoiceStatusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity Row -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">أحدث الفواتير</h5>
                        <a href="{{ route('invoices.index') }}" class="btn btn-sm btn-link">عرض الكل</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>رقم الفاتورة</th>
                                <th>العميل</th>
                                <th>تاريخ الفاتورة</th>
                                <th>المبلغ</th>
                                <th>العملة</th>
                                <th>الحالة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentInvoices as $invoice)
                            <tr>
                                <td>
                                    <a href="{{ route('invoices.show', $invoice) }}" class="text-decoration-none">
                                        {{ $invoice->invoice_number }}
                                    </a>
                                </td>
                                <td>{{ $invoice->client->name }}</td>
                                <td>{{ $invoice->invoice_date->format('Y-m-d') }}</td>
                                <td>
                                    {{ number_format($invoice->total, 2) }}
                                    {{ $invoice->currency->symbol ?? $invoice->currency->code }}
                                </td>
                                <td>
                                    @if($invoice->status === 'paid')
                                        <span class="badge bg-success">مدفوعة</span>
                                    @elseif($invoice->status === 'pending')
                                        <span class="badge bg-warning">قيد الانتظار</span>
                                    @else
                                        <span class="badge bg-danger">ملغاة</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-3">لا توجد فواتير حديثة</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">أحدث عروض الأسعار</h5>
                        <a href="{{ route('quotations.index') }}" class="btn btn-sm btn-link">عرض الكل</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>رقم العرض</th>
                                <th>العميل</th>
                                <th>المبلغ</th>
                                <th>الحالة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentQuotations as $quotation)
                            <tr>
                                <td>{{ $quotation->quotation_number }}</td>
                                <td>{{ $quotation->client->name }}</td>
                                <td>{{ number_format($quotation->total_amount, 2) }} ريال</td>
                                <td>
                                    <span class="badge bg-{{ $quotation->status === 'approved' ? 'success' : ($quotation->status === 'pending' ? 'warning' : 'danger') }}">
                                        {{ $quotation->status === 'approved' ? 'تمت الموافقة' : ($quotation->status === 'pending' ? 'قيد الانتظار' : 'مرفوض') }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Clients -->
    <div class="row g-3">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0">أفضل العملاء</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>العميل</th>
                                <th>إجمالي المبيعات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topClients as $index => $client)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $client->client->name }}</td>
                                <td>{{ number_format($client->total, 2) }} ريال</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.avatar {
    width: 3rem;
    height: 3rem;
    display: flex;
    align-items: center;
    justify-content: center;
}
.avatar-lg {
    width: 3.5rem;
    height: 3.5rem;
}
.avatar-xl {
    width: 4rem;
    height: 4rem;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Revenue Chart
    const ctx = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: @json($chartData),
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return new Intl.NumberFormat().format(value);
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += new Intl.NumberFormat().format(context.raw);
                            return label;
                        }
                    }
                }
            }
        }
    });

    // Invoice Status Chart
    const invoiceStatusCtx = document.getElementById('invoiceStatusChart').getContext('2d');
    new Chart(invoiceStatusCtx, {
        type: 'doughnut',
        data: @json($invoiceStatusChart),
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        boxWidth: 12,
                        font: {
                            size: 12
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.raw || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = Math.round((value / total) * 100);
                            return `${label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush
