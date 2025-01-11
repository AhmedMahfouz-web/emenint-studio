@extends('layouts.app')

@section('page-content')
    <div class="container-fluid px-3 px-md-4">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                            <h2 class="h4 mb-0">المنتجات</h2>
                            <div class="d-flex gap-2">
                                <a href="{{ route('products.create') }}" class="btn btn-primary btn-lg w-100 w-md-auto">إضافة منتج جديد</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-3">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <!-- Search Form -->
                        <form action="{{ route('products.index') }}" method="GET" class="mb-4">
                            <div class="row g-2">
                                <div class="col-12 col-md-4">
                                    <label class="form-label d-md-none">بحث</label>
                                    <input type="text" name="search" class="form-control form-control-lg" 
                                        placeholder="بحث بالاسم أو الكود" value="{{ request('search') }}">
                                </div>
                                <div class="col-12 col-md-2">
                                    <label class="form-label d-md-none">&nbsp;</label>
                                    <button type="submit" class="btn btn-primary btn-lg w-100">بحث</button>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead class="bg-light">
                                    <tr>
                                        <th>كود المنتج</th>
                                        <th>الاسم</th>
                                        <th>الوصف</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td data-label="كود المنتج">{{ $product->code }}</td>
                                            <td data-label="الاسم">{{ $product->name }}</td>
                                            <td data-label="الوصف">{{ Str::limit($product->description, 100) }}</td>
                                            <td data-label="الإجراءات">
                                                <div class="btn-group-vertical btn-group-sm d-md-inline-flex">
                                                    <a href="{{ route('products.show', $product) }}"
                                                        class="btn btn-info">عرض</a>
                                                    <a href="{{ route('products.edit', $product) }}"
                                                        class="btn btn-warning">تعديل</a>
                                                    <form action="{{ route('products.destroy', $product) }}" method="POST"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger"
                                                            onclick="return confirm('هل أنت متأكد من حذف هذا المنتج؟')">حذف</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            {{ $products->links() }}
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
                padding: 0.5rem;
                border: none;
                word-break: break-word;
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

            .btn-group-vertical {
                display: flex;
                gap: 0.5rem;
            }

            .btn-group-vertical .btn {
                width: 100%;
            }

            .w-md-auto {
                width: 100% !important;
            }
        }
    </style>
@endsection
