@extends('layouts.app')

@section('page-content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">تعديل العملة</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('currencies.update', $currency) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">اسم العملة</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                        id="name" name="name" value="{{ old('name', $currency->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="code" class="form-label">رمز العملة (مثال: USD)</label>
                                    <input type="text" class="form-control @error('code') is-invalid @enderror" 
                                        id="code" name="code" value="{{ old('code', $currency->code) }}" required maxlength="3">
                                    @error('code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="symbol" class="form-label">علامة العملة (مثال: $)</label>
                                    <input type="text" class="form-control @error('symbol') is-invalid @enderror" 
                                        id="symbol" name="symbol" value="{{ old('symbol', $currency->symbol) }}">
                                    @error('symbol')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="exchange_rate" class="form-label">سعر الصرف</label>
                                    <input type="number" step="0.0001" class="form-control @error('exchange_rate') is-invalid @enderror" 
                                        id="exchange_rate" name="exchange_rate" value="{{ old('exchange_rate', $currency->exchange_rate) }}" required>
                                    @error('exchange_rate')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" 
                                            {{ old('is_active', $currency->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">نشط</label>
                                    </div>
                                </div>
                            </div>

                            @if(!$currency->is_default)
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="is_default" name="is_default" value="1" 
                                            {{ old('is_default', $currency->is_default) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_default">تعيين كعملة افتراضية</label>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                            <a href="{{ route('currencies.index') }}" class="btn btn-secondary">رجوع</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
