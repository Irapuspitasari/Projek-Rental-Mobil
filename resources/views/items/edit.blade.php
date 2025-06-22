@extends('layouts2.app')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4><i class="fas fa-edit me-2"></i> Edit Item</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('items.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nama Item</label>
                                <input type="text" name="name" class="form-control" value="{{ $item->name }}" required>
                            </div>
                            <br>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Foto (Multiple)</label>
                                @if($item->photos)
                                    <div class="d-flex flex-wrap gap-2 mb-2">
                                        @foreach(json_decode($item->photos) as $photo)
                                            <img src="{{ asset('storage/'.$photo) }}" width="80" class="img-thumbnail">
                                        @endforeach
                                    </div>
                                @endif
                                <input type="file" name="photos[]" class="form-control" multiple>
                                <small class="text-muted">Maksimal 5 foto, format JPG/PNG (maks 2MB per foto)</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Type</label>
                                <select name="type_id" class="form-select" required>
                                    @foreach($types as $type)
                                        <option value="{{ $type->id }}" {{ $item->type_id == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Brand</label>
                                <select name="brand_id" class="form-select" required>
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ $item->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Harga</label>
                                <input type="number" name="price" class="form-control" value="{{ $item->price }}" required>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">Fitur</label>
                                <textarea name="features" class="form-control" rows="3" placeholder="Masukkan fitur-fitur item...">{{ $item->features }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('items.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
