@extends('layouts2.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">


            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-award me-2"></i> Data Booking</h4>
                    <a href="{{ route('bookings.create') }}" class="btn btn-primary mb-3">
                        Tambah Booking
                    </a>
                </div>
                <div class="card-body" style="overflow-x:auto;">
                    <div class="table-responsive">
                        <table id="res-config" class="display table table-striped table-hover dt-responsive nowrap"
                            style="width:100%">
                            <thead class="table-light">
                                <tr>
                                    <th>Kode Booking</th>
                                    <th>Nama Penyewa</th>
                                    <th>Item</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Durasi</th>
                                    <th>Total Harga</th>
                                    <th>Status</th>
                                    <th>Pembayaran</th>
                                    <th>Denda</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bookings as $booking)
                                <tr>
                                    <td class="text-center">{{ $booking->slug }}</td>
                                    <td>{{ $booking->name }}</td>
                                    <td>{{ $booking->item->name }}</td>
                                    <td>{{ $booking->start_date->format('d M Y') }}</td>
                                    <td>{{ $booking->end_date->format('d M Y') }}</td>
                                    <td>{{ $booking->duration_days }} hari</td>
                                    <td>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge rounded-pill
                                                @if($booking->status == 'Pending') bg-warning text-dark
                                                @elseif($booking->status == 'Confirmed') bg-primary
                                                @elseif($booking->status == 'On Rent') bg-info
                                                @elseif($booking->status == 'Completed') bg-success
                                                @elseif($booking->status == 'Cancelled') bg-danger
                                                @endif">
                                            {{ $booking->status }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($booking->payment)
                                        <span class="badge rounded-pill
                                            @if($booking->payment->status == 'Paid') bg-success
                                            @elseif($booking->payment->status == 'Pending') bg-warning text-dark
                                            @elseif($booking->payment->status == 'Failed') bg-danger
                                            @elseif($booking->payment->status == 'Expired') bg-secondary
                                            @endif">
                                            {{ $booking->payment->status }}
                                        </span>
                                        @else
                                        <span class="badge rounded-pill bg-light text-dark">Belum Bayar</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($booking->is_overtime == 1)
                                        <span class="badge rounded-pill bg-danger">Denda</span>
                                        @else
                                        <span class="badge rounded-pill bg-secondary">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('bookings.show', $booking->slug) }}"
                                                class="btn btn-sm btn-info mx-1" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            @if($booking->status == 'Pending')
                                            <a href="{{ route('bookings.edit', $booking->slug) }}"
                                                class="btn btn-sm btn-warning mx-1" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @endif

                                            @if($booking->status == 'Confirmed')
                                            <form action="{{ route('bookings.on-rent', $booking->slug) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-primary mx-1"
                                                    title="Mark as On Rent"
                                                    onclick="return confirm('Are you sure you want to mark this booking as On Rent?')">
                                                    <i class="fas fa-car"></i>
                                                </button>
                                            </form>
                                            @endif

                                            @if($booking->status == 'On Rent')
                                            <div class="modal fade" id="completeBookingModal" tabindex="-1"
                                                aria-labelledby="completeBookingModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form action="{{ route('bookings.complete', $booking->slug) }}"
                                                            method="POST">
                                                            @csrf
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="completeBookingModalLabel">
                                                                    Complete Booking</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="actual_end_date"
                                                                        class="form-label">Actual End Date &
                                                                        Time</label>
                                                                    <input type="datetime-local" class="form-control"
                                                                        id="actual_end_date" name="actual_end_date"
                                                                        required>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-primary">Complete
                                                                    Booking</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <button type="button" class="btn btn-sm btn-success mx-1"
                                                title="Mark as Completed" data-bs-toggle="modal"
                                                data-bs-target="#completeBookingModal">
                                                <i class="fas fa-check-circle"></i>
                                            </button>
                                            @endif

                                            @if(in_array($booking->status, ['Pending', 'Cancelled']))
                                            <form action="{{ route('bookings.destroy', $booking->slug) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger mx-1" title="Delete"
                                                    onclick="return confirm('Are you sure you want to delete this booking?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                            @endif

                                            @if(in_array($booking->status, ['Pending', 'Confirmed']))
                                            <form action="{{ route('bookings.cancel', $booking->slug) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-secondary mx-1"
                                                    title="Cancel"
                                                    onclick="return confirm('Are you sure you want to cancel this booking?')">
                                                    <i class="fas fa-times-circle"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
{{--
                    <div class="d-flex justify-content-center mt-3">
                        {{ $bookings->links() }}
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
<style>
    .badge {
        font-size: 0.85em;
        padding: 0.5em 0.75em;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.02);
    }

    .page-title-box {
        padding: 1.5rem 0;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
<script>
    $(document).ready(function() {
        $('#res-config').DataTable({
            responsive: true,
            dom: '<"top"lf>rt<"bottom"ip><"clear">',
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data per halaman",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Selanjutnya",
                    previous: "Sebelumnya"
                }
            }
        });
    });
</script>
@endpush
