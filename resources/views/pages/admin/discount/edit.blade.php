@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Edit Discount</h1>
    <form action="{{ route('discount.update', $item->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="code">Code</label>
            <input type="text" class="form-control" id="code" name="code" value="{{ $item->code }}" required>
        </div>
        <div class="form-group">
            <label for="discount_type">Discount Type</label>
            <select class="form-control" id="discount_type" name="discount_type" required>
                <option value="percentage" id=persen {{ $item->discount_type == 'percentage' ? 'selected' : '' }}>Persentasi (Termasuk ongkir)</option>
                <option value="percentageproduct" id=persen {{ $item->discount_type == 'percentageproduct' ? 'selected' : '' }}>Persentasi (Produk saja)</option>
                <option value="fixed" id="fix" {{ $item->discount_type == 'fixed' ? 'selected' : '' }}>Nominal</option>
                <option value="ongkir" id="ongkir" {{ $item->discount_type == 'ongkir' ? 'selected' : '' }}>Gratis Ongkir</option>
            </select>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description">{{ $item->description }}</textarea>
        </div>
        <div class="form-group">
            <label for="discount_value">Discount Value</label>
            <input type="number" class="form-control" id="discount_value" name="discount_value" step="0.01" value="{{ $item->discount_value }}" required>
        </div>
        <div class="form-group">
            <label for="start_date">Start Date</label>
            <input type="datetime-local" class="form-control" id="start_date" name="start_date" value="{{ $item->start_date ? \Carbon\Carbon::parse($item->start_date)->format('Y-m-d\TH:i') : '' }}">
        </div>
        <div class="form-group">
            <label for="end_date">End Date</label>
            <input type="datetime-local" class="form-control" id="end_date" name="end_date" value="{{ $item->end_date ? \Carbon\Carbon::parse($item->end_date)->format('Y-m-d\TH:i') : '' }}">
        </div>
        <div class="form-group">
            <label for="minimum_purchase">Minimum Purchase</label>
            <input type="number" class="form-control" id="minimum_purchase" name="minimum_purchase" step="0.01" value="{{ $item->minimum_purchase }}">
        </div>
        <div class="form-group">
            <label for="usage_limit">Usage Limit</label>
            <input type="number" class="form-control" id="usage_limit" name="usage_limit" value="{{ $item->usage_limit }}">
        </div>
        <div class="form-group">
            <label for="is_active">Aktif</label>
            <select class="form-control" id="is_active" name="is_active" required>
                <option value="1" {{ $item->is_active ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ !$item->is_active ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update Discount</button>
    </form>
</div>
@endsection
