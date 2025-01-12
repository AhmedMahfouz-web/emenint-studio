@extends('layouts.app')

@section('page-content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">إدارة العملات</h4>
                    <a href="{{ route('currencies.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> إضافة عملة جديدة
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>الاسم</th>
                                    <th>الرمز</th>
                                    <th>العلامة</th>
                                    <th>سعر الصرف</th>
                                    <th>العملة الافتراضية</th>
                                    <th>الحالة</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($currencies as $currency)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $currency->name }}</td>
                                    <td>{{ $currency->code }}</td>
                                    <td>{{ $currency->symbol }}</td>
                                    <td>{{ $currency->exchange_rate }}</td>
                                    <td>
                                        @if($currency->is_default)
                                            <span class="badge bg-success">نعم</span>
                                        @else
                                            <form action="{{ route('currencies.set-default', $currency) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-primary">
                                                    تعيين كافتراضي
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                    <td>
                                        @if($currency->is_active)
                                            <span class="badge bg-success">نشط</span>
                                        @else
                                            <span class="badge bg-danger">غير نشط</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('currencies.edit', $currency) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-edit"></i> تعديل
                                        </a>
                                        @if(!$currency->is_default)
                                            <form action="{{ route('currencies.destroy', $currency) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد من حذف هذه العملة؟')">
                                                    <i class="fas fa-trash"></i> حذف
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">لا توجد عملات مضافة</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
