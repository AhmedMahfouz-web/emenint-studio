@extends('layouts.app')

@section('page-content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">تعديل العميل</h2>
                </div>

                <div class="card-body">
                    <form action="{{ route('clients.update', $client) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="code" class="form-label">رمز العميل</label>
                                <input type="text" class="form-control @error('code') is-invalid @enderror"
                                    id="code" name="code" value="{{ old('code', $client->code) }}" required>
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="name" class="form-label">الاسم</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', $client->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label">البريد الالكتروني</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email', $client->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="phone" class="form-label">رقم الهاتف</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                    id="phone" name="phone" value="{{ old('phone', $client->phone) }}" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="address" class="form-label">العنوان</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3"
                                    required>{{ old('address', $client->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <div class="col-md-6">
                                    <label for="country" class="form-label text-dark fw-bold">البلد</label>
                                    <select class="form-select" id="country" name="country" required>
                                        <option value="">اختر البلد</option>
                                        <option {{ $invoice->country == 'United Arab Emirates' ? selected : '' }}
                                            value="United Arab Emirates">الإمارات العربية المتحدة</option>
                                        <option {{ $invoice->country == 'Bahrain' ? selected : '' }} value="Bahrain">البحرين
                                        </option>
                                        <option {{ $invoice->country == 'Egypt' ? selected : '' }} value="Egypt">مصر
                                        </option>
                                        <option {{ $invoice->country == 'Iraq' ? selected : '' }} value="Iraq">العراق
                                        </option>
                                        <option {{ $invoice->country == 'Palestine' ? selected : '' }} value="Palestine">
                                            فلسطين</option>
                                        <option {{ $invoice->country == 'Jordan' ? selected : '' }} value="Jordan">الأردن
                                        </option>
                                        <option {{ $invoice->country == 'Kuwait' ? selected : '' }} value="Kuwait">الكويت
                                        </option>
                                        <option {{ $invoice->country == 'Lebanon' ? selected : '' }} value="Lebanon">لبنان
                                        </option>
                                        <option {{ $invoice->country == 'Libya' ? selected : '' }} value="Libya">ليبيا
                                        </option>
                                        <option {{ $invoice->country == 'Oman' ? selected : '' }} value="Oman">عمان
                                        </option>
                                        <option {{ $invoice->country == 'Qatar' ? selected : '' }} value="Qatar">قطر
                                        </option>
                                        <option {{ $invoice->country == 'Saudi Arabia' ? selected : '' }}
                                            value="Saudi Arabia">السعودية</option>
                                        <option {{ $invoice->country == 'Syria' ? selected : '' }} value="Syria">سوريا
                                        </option>
                                        <option {{ $invoice->country == 'Tunisia' ? selected : '' }} value="Tunisia">تونس
                                        </option>
                                        <option {{ $invoice->country == 'Yemen' ? selected : '' }} value="Yemen">اليمن
                                        </option>
                                    </select>
                                    @error('country')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="{{ route('clients.index') }}" class="btn btn-secondary me-md-2">الغاء</a>
                                <button type="submit" class="btn btn-primary">تحديث العميل</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
