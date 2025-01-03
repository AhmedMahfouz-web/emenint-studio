@extends('layouts.app')

@section('page-content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">إضافة عميل جديد</h2>
                </div>

                <div class="card-body">
                    <form action="{{ route('clients.store') }}" method="POST">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="code" class="form-label">كود العميل</label>
                                <input type="text" class="form-control @error('code') is-invalid @enderror"
                                    id="code" name="code" value="{{ old('code') }}" required>
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="name" class="form-label">الاسم</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="company" class="form-label">الشركة</label>
                                <input type="text" class="form-control @error('company') is-invalid @enderror"
                                    id="company" name="company" value="{{ old('company') }}" required>
                                @error('company')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label">البريد الإلكتروني</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="phone" class="form-label">رقم الهاتف</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                    id="phone" name="phone" value="{{ old('phone') }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="address" class="form-label">العنوان</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3"
                                    required>{{ old('address') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="country" class="form-label text-dark fw-bold">البلد</label>
                                <select class="form-select" id="country" name="country" required>
                                    <option value="">اختر البلد</option>
                                    <option value="United Arab Emirates">الإمارات العربية المتحدة</option>
                                    <option value="Bahrain">البحرين</option>
                                    <option value="Egypt">مصر</option>
                                    <option value="Iraq">العراق</option>
                                    <option value="Palestine">فلسطين</option>
                                    <option value="Jordan">الأردن</option>
                                    <option value="Kuwait">الكويت</option>
                                    <option value="Lebanon">لبنان</option>
                                    <option value="Libya">ليبيا</option>
                                    <option value="Oman">عمان</option>
                                    <option value="Qatar">قطر</option>
                                    <option value="Saudi Arabia">السعودية</option>
                                    <option value="Syria">سوريا</option>
                                    <option value="Tunisia">تونس</option>
                                    <option value="Yemen">اليمن</option>
                                </select>
                                @error('country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('clients.index') }}" class="btn btn-secondary me-md-2">إلغاء</a>
                            <button type="submit" class="btn btn-primary">إضافة العميل</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
