@extends('layouts.app')

@section('page-content')
<div class="container-fluid px-3 px-md-4">
    <div class="card shadow-sm">
        <div class="card-header py-3">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <h2 class="mb-0 fs-3">عروض الأسعار</h2>
                <div class="d-flex gap-2">
                    <a href="{{ route('quotations.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> إنشاء عرض سعر جديد
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body p-3 p-md-4">
            <form action="{{ route('quotations.index') }}" method="GET" class="mb-4">
                <div class="row g-3">
                    <div class="col-12 col-md-3">
                        <input type="text" class="form-control" name="search" value="{{ request('search') }}" 
                            placeholder="بحث برقم عرض السعر">
                    </div>
                    <div class="col-12 col-md-3">
                        <select class="form-select select2-searchable" name="client">
                            <option value="">كل العملاء</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}" {{ request('client') == $client->id ? 'selected' : '' }}>
                                    {{ $client->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-2">
                        <select class="form-select" name="status">
                            <option value="">كل الحالات</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>تمت الموافقة</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>مرفوض</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-2">
                        <input type="date" class="form-control" name="date_from" value="{{ request('date_from') }}" 
                            placeholder="من تاريخ">
                    </div>
                    <div class="col-12 col-md-2">
                        <input type="date" class="form-control" name="date_to" value="{{ request('date_to') }}" 
                            placeholder="إلى تاريخ">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-1"></i> بحث
                        </button>
                        <a href="{{ route('quotations.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-1"></i> إعادة تعيين
                        </a>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>رقم عرض السعر</th>
                            <th>العميل</th>
                            <th>التاريخ</th>
                            <th>المجموع</th>
                            <th>الحالة</th>
                            <th>العمليات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($quotations as $quotation)
                            <tr>
                                <td>{{ $quotation->id }}</td>
                                <td>{{ $quotation->quotation_number }}</td>
                                <td>{{ $quotation->client->name }}</td>
                                <td>{{ $quotation->quotation_date->format('Y-m-d') }}</td>
                                <td>{{ number_format($quotation->total, 2) }} {{ $quotation->currancy }}</td>
                                <td>
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
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('quotations.show', $quotation) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('quotations.edit', $quotation) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('quotations.download', $quotation) }}" target="_blank" class="btn btn-sm btn-success">
                                            <i class="fas fa-download"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger" 
                                            onclick="if(confirm('هل أنت متأكد من حذف عرض السعر هذا؟')) document.getElementById('delete-quotation-{{ $quotation->id }}').submit()">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <form id="delete-quotation-{{ $quotation->id }}" 
                                            action="{{ route('quotations.destroy', $quotation) }}" method="POST" class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3 d-block"></i>
                                    لا توجد عروض أسعار
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $quotations->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
