@extends('layouts2.app')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4><i class="fas fa-car me-2"></i> Data Items</h4>
                <a href="{{ route('items.create') }}" class="btn btn-primary mb-3">
                    Tambah Item
                </a>
            </div>
            <div class="card-body" style="overflow-x:auto;">
                @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <table id="res-config" class="display table table-striped table-hover dt-responsive nowrap"
                    style="width: 100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Foto</th>
                            <th>Nama</th>
                            <th>Type</th>
                            <th>Brand</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach ($items as $item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>
                                @if($item->photos)
                                <div class="stacked-photos" style="position: relative; width: 80px; height: 80px;">
                                    @foreach(json_decode($item->photos) as $index => $photo)
                                    <div class="stacked-photo" style="
                                                position: absolute;
                                                top: {{ $index * 5 }}px;
                                                left: {{ $index * 5 }}px;
                                                width: 80px;
                                                height: 80px;
                                                border: 1px solid #ddd;
                                                border-radius: 4px;
                                                overflow: hidden;
                                                z-index: {{ count(json_decode($item->photos)) - $index }};
                                                box-shadow: 0 1px 3px rgba(0,0,0,0.1);
                                                background: white;
                                            ">
                                        <img src="{{ asset('storage/'.$photo) }}"
                                            style="width: 100%; height: 100%; object-fit: cover;"
                                            alt="Photo {{ $index + 1 }}"
                                            title="{{ $item->name }} - Photo {{ $index + 1 }}">
                                    </div>
                                    @endforeach
                                    <div class="photo-count" style="
                                            position: absolute;
                                            bottom: -5px;
                                            right: -5px;
                                            background: #007bff;
                                            color: white;
                                            border-radius: 50%;
                                            width: 20px;
                                            height: 20px;
                                            display: flex;
                                            align-items: center;
                                            justify-content: center;
                                            font-size: 10px;
                                            z-index: 10;
                                        ">
                                        {{ count(json_decode($item->photos)) }}
                                    </div>
                                </div>
                                @else
                                <div
                                    style="width: 50px; height: 50px; background: #f8f9fa; display: flex; align-items: center; justify-content: center; border-radius: 4px;">
                                    <i class="fas fa-image text-muted"></i>
                                </div>
                                @endif
                            </td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->type->name }}</td>
                            <td>{{ $item->brand->name }}</td>
                            <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td>
                                <!-- Show Button -->
                                <a href="{{ route('items.show', $item->slug) }}" class="btn btn-info btn-sm"
                                    title="Detail">
                                    <i class="fa fa-eye"></i> &nbsp;<span class="d-none d-sm-inline">Show</span>
                                </a>

                                <!-- Edit Button -->
                                <a href="{{ route('items.edit', $item->id) }}" class="btn btn-warning btn-sm"
                                    title="Edit">
                                    <i class="fa fa-pencil-alt"></i> &nbsp;<span class="d-none d-sm-inline">Edit</span>
                                </a>

                                <!-- Delete Button -->
                                <form action="{{ route('items.destroy', $item->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button onclick="return confirm('Hapus item ini?')" class="btn btn-danger btn-sm"
                                        title="Delete">
                                        <i class="fa fa-trash-alt"></i> &nbsp;<span class="d-none d-sm-inline">Hapus</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .stacked-photos:hover .stacked-photo {
        transform: translateX(5px);
    }

    .stacked-photo {
        transition: transform 0.2s ease;
    }

    .stacked-photo:hover {
        transform: translateX(10px) !important;
        z-index: 10 !important;
    }
</style>
@endsection
