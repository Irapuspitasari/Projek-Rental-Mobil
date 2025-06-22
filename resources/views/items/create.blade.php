@extends('layouts2.app')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4><i class="fas fa-plus-circle me-2"></i> Tambah Item Baru</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nama Item</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <br>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Foto (Multiple)</label>
                                <input type="file" name="photos[]" class="form-control" multiple>
                                <small class="text-muted">Maksimal 5 foto, format JPG/PNG (maks 2MB per foto)</small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Type</label>
                                <select name="type_id" class="form-select" required>
                                    <option value="">Pilih Type</option>
                                    @foreach($types as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Brand</label>
                                <select name="brand_id" class="form-select" required>
                                    <option value="">Pilih Brand</option>
                                    @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Harga</label>
                                <input type="number" name="price" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">Fitur</label>
                                <textarea name="features" class="form-control" rows="3"
                                    placeholder="Masukkan fitur-fitur item..."></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('items.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
