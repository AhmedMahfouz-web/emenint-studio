@extends('layouts.app')

@section('page-content')
    {{-- <div class="container-fluid px-3 px-md-4">
        <!-- Summary Statistics -->
        <div class="row g-3 mb-4">
            <div class="col-12 col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-money-bill-wave fs-4 me-2 text-primary"></i>
                            <h5 class="card-title mb-0">إجمالي الإيرادات</h5>
                        </div>
                        <h3 class="mb-3">{{ number_format($stats['total_revenue'], 2) }} ج.م</h3>
                        <div class="progress">
                            <div class="progress-bar bg-primary" role="progressbar"
                                style="width: {{ $stats['revenue_percentage'] }}%;"
                                aria-valuenow="{{ $stats['revenue_percentage'] }}"
                                aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-file-invoice fs-4 me-2 text-info"></i>
                            <h5 class="card-title mb-0">عدد الفواتير</h5>
                        </div>
                        <h3 class="mb-3">{{ $stats['total_invoices'] }}</h3>
                        <div class="progress">
                            <div class="progress-bar bg-info" role="progressbar"
                                style="width: {{ $stats['invoice_percentage'] }}%;"
                                aria-valuenow="{{ $stats['invoice_percentage'] }}"
                                aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-users fs-4 me-2 text-warning"></i>
                            <h5 class="card-title mb-0">عدد العملاء</h5>
                        </div>
                        <h3 class="mb-3">{{ $stats['total_clients'] }}</h3>
                        <div class="progress">
                            <div class="progress-bar bg-warning" role="progressbar"
                                style="width: {{ $stats['client_percentage'] }}%;"
                                aria-valuenow="{{ $stats['client_percentage'] }}"
                                aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts -->
        <div class="row g-3 mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header py-3">
                        <h5 class="mb-0">الإيرادات الشهرية</h5>
                    </div>
                    <div class="card-body p-0 p-md-3">
                        <div class="chart-container" style="position: relative; height:50vh; width:100%">
                            <canvas id="revenueChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <!-- Recent Invoices -->
            <div class="col-12 col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-header py-3">
                        <h5 class="mb-0">أحدث الفواتير</h5>
                    </div>
                    <div class="card-body p-0 p-md-3">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="bg-light">
                                    <tr>
                                        <th>رقم الفاتورة</th>
                                        <th>العميل</th>
                                        <th>التاريخ</th>
                                        <th>المبلغ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentInvoices as $invoice)
                                    <tr>
                                        <td data-label="رقم الفاتورة">{{ $invoice->invoice_number }}</td>
                                        <td data-label="العميل">{{ $invoice->client->name }}</td>
                                        <td data-label="التاريخ">{{ $invoice->invoice_date->format('Y-m-d') }}</td>
                                        <td data-label="المبلغ">{{ number_format($invoice->total, 2) }} ج.م</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top Clients -->
            <div class="col-12 col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-header py-3">
                        <h5 class="mb-0">أفضل العملاء</h5>
                    </div>
                    <div class="card-body p-0 p-md-3">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="bg-light">
                                    <tr>
                                        <th>العميل</th>
                                        <th>عدد الفواتير</th>
                                        <th>إجمالي المبيعات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($topClients as $client)
                                    <tr>
                                        <td data-label="العميل">{{ $client->name }}</td>
                                        <td data-label="عدد الفواتير">{{ $client->invoices_count }}</td>
                                        <td data-label="إجمالي المبيعات">{{ number_format($client->total_revenue, 2) }} ج.م</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media (max-width: 768px) {
            .card {
                margin-bottom: 1rem;
            }

            .table-responsive {
                margin: -1px;
            }

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
                padding: 0.5rem;
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

            .chart-container {
                height: 40vh !important;
            }
        }
    </style>

    <script src="{{ asset('assets/js/chart.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('revenueChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($revenueData['labels']) !!},
                    datasets: [{
                        label: 'الإيرادات الشهرية',
                        data: {!! json_encode($revenueData['values']) !!},
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1,
                        fill: true,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return value.toLocaleString('ar-EG') + ' ج.م';
                                }
                            }
                        }
                    }
                }
            });
        }); --}}
    {{-- </script> --}}
@endsection
