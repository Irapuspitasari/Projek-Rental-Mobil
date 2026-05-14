@extends('layouts2.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row gy-4">
        <!-- Welcome Card -->
        <div class="col-md-12 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-1">Welcome back, {{ auth()->user()->name }}! 👋</h5>
                    <p class="mb-4">Here's what's happening with your rental business today.</p>
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="badge bg-label-primary p-2 rounded">
                            <i class="fas fa-car fa-lg"></i>
                        </div>
                        <h4 class="text-primary mb-0">{{ $totalCars }} Cars</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Overview -->
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0">Business Overview</h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="avatar me-3">
                                    <div class="avatar-initial bg-primary rounded shadow-sm">
                                        <i class="fas fa-calendar-check"></i>
                                    </div>
                                </div>
                                <div>
                                    <p class="mb-0 text-muted small">Bookings</p>
                                    <h5 class="mb-0">{{ number_format($totalBookings) }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="avatar me-3">
                                    <div class="avatar-initial bg-success rounded shadow-sm">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                                <div>
                                    <p class="mb-0 text-muted small">Customers</p>
                                    <h5 class="mb-0">{{ number_format($totalUsers) }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="avatar me-3">
                                    <div class="avatar-initial bg-warning rounded shadow-sm">
                                        <i class="fas fa-car-side"></i>
                                    </div>
                                </div>
                                <div>
                                    <p class="mb-0 text-muted small">Cars</p>
                                    <h5 class="mb-0">{{ number_format($totalCars) }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="avatar me-3">
                                    <div class="avatar-initial bg-info rounded shadow-sm">
                                        <i class="fas fa-money-bill-wave"></i>
                                    </div>
                                </div>
                                <div>
                                    <p class="mb-0 text-muted small">Revenue</p>
                                    <h5 class="mb-0">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue Chart -->
        <div class="col-12 col-xl-8">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0">Revenue Overview (Last 6 Months)</h5>
                </div>
                <div class="card-body">
                    <div id="revenueChart" style="min-height: 350px;"></div>
                </div>
            </div>
        </div>

        <!-- Booking Status Distribution -->
        <div class="col-12 col-xl-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0">Booking Status</h5>
                </div>
                <div class="card-body">
                    <div id="statusDistributionChart"></div>
                    <div class="mt-4">
                        @foreach($statusCounts as $status)
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="d-flex align-items-center">
                                <span class="badge badge-dot me-2 {{ $status->status === 'Completed' ? 'bg-success' : ($status->status === 'Pending' ? 'bg-warning' : ($status->status === 'Cancelled' ? 'bg-danger' : 'bg-primary')) }}"></span>
                                <span>{{ $status->status }}</span>
                            </div>
                            <span class="fw-semibold">{{ $status->count }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Bookings Table -->
        <div class="col-12 col-xl-8">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0">Recent Bookings</h5>
                    <a href="{{ route('bookings.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Customer</th>
                                <th>Car</th>
                                <th>Date Range</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentBookings as $booking)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm me-2">
                                            <span class="avatar-initial rounded-circle bg-label-primary">{{ strtoupper(substr($booking->name, 0, 1)) }}</span>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 small">{{ $booking->name }}</h6>
                                            <small class="text-muted">{{ $booking->city }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-car text-primary me-2"></i>
                                        <span class="small">{{ $booking->item->name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <small>{{ $booking->start_date->format('d M') }} - {{ $booking->end_date->format('d M') }}</small>
                                </td>
                                <td>
                                    @php
                                        $statusClass = match($booking->status) {
                                            'Pending' => 'bg-label-warning',
                                            'Confirmed' => 'bg-label-info',
                                            'On Rent' => 'bg-label-primary',
                                            'Completed' => 'bg-label-success',
                                            'Cancelled' => 'bg-label-danger',
                                            default => 'bg-label-secondary',
                                        };
                                    @endphp
                                    <span class="badge {{ $statusClass }} rounded-pill small">{{ $booking->status }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('bookings.show', $booking->slug) }}" class="btn btn-icon btn-sm btn-text-secondary rounded-pill">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">No recent bookings found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Top Rated Cars -->
        <div class="col-12 col-xl-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0">Top Rated Cars</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        @forelse($topCars as $car)
                        <li class="d-flex mb-4 pb-1 align-items-center">
                            <div class="avatar flex-shrink-0 me-3">
                                <div class="avatar-initial bg-label-primary rounded">
                                    <i class="fas fa-car"></i>
                                </div>
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0">{{ $car->name }}</h6>
                                    <small class="text-muted">{{ $car->type->name ?? 'Car' }}</small>
                                </div>
                                <div class="user-progress d-flex align-items-center gap-1">
                                    <h6 class="mb-0 text-warning">{{ number_format($car->reviews_avg_star, 1) }}</h6>
                                    <i class="fas fa-star text-warning small"></i>
                                    <small class="text-muted">({{ $car->reviews_count }})</small>
                                </div>
                            </div>
                        </li>
                        @empty
                        <li class="text-center py-4 text-muted">No reviews yet.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Quick Actions</h5>
                    <div class="row g-3">
                        <div class="col-6 col-md-3">
                            <a href="{{ route('items.create') }}" class="btn btn-outline-primary w-100 p-4 d-flex flex-column align-items-center">
                                <i class="fas fa-plus-circle fa-2x mb-2"></i>
                                <span>Add New Car</span>
                            </a>
                        </div>
                        <div class="col-6 col-md-3">
                            <a href="{{ route('bookings.create') }}" class="btn btn-outline-info w-100 p-4 d-flex flex-column align-items-center">
                                <i class="fas fa-calendar-plus fa-2x mb-2"></i>
                                <span>New Booking</span>
                            </a>
                        </div>
                        <div class="col-6 col-md-3">
                            <a href="{{ route('reports.bookings') }}" class="btn btn-outline-success w-100 p-4 d-flex flex-column align-items-center">
                                <i class="fas fa-file-invoice fa-2x mb-2"></i>
                                <span>View Reports</span>
                            </a>
                        </div>
                        <div class="col-6 col-md-3">
                            <a href="{{ route('users.index') }}" class="btn btn-outline-warning w-100 p-4 d-flex flex-column align-items-center">
                                <i class="fas fa-user-cog fa-2x mb-2"></i>
                                <span>Manage Users</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Revenue Chart
        var revenueOptions = {
            series: [{
                name: 'Revenue',
                data: @json($chartData['data'])
            }],
            chart: {
                height: 350,
                type: 'area',
                toolbar: { show: false },
                fontFamily: 'Inter, sans-serif'
            },
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 3 },
            colors: ['#666cff'],
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.5,
                    opacityTo: 0.1,
                    stops: [0, 90, 100]
                }
            },
            xaxis: {
                categories: @json($chartData['labels']),
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: {
                labels: {
                    formatter: function (value) {
                        return "Rp " + value.toLocaleString();
                    }
                }
            },
            grid: {
                borderColor: '#e0e0e0',
                strokeDashArray: 5,
                xaxis: { lines: { show: true } },
                yaxis: { lines: { show: true } }
            }
        };

        var revenueChart = new ApexCharts(document.querySelector("#revenueChart"), revenueOptions);
        revenueChart.render();

        // Status Distribution Chart
        var statusOptions = {
            series: @json($statusCounts->pluck('count')),
            chart: {
                type: 'donut',
                height: 250,
            },
            labels: @json($statusCounts->pluck('status')),
            colors: ['#666cff', '#4caf50', '#ff9800', '#f44336', '#03a9f4'],
            legend: { show: false },
            dataLabels: { enabled: false },
            plotOptions: {
                pie: {
                    donut: {
                        size: '75%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Total',
                                formatter: function (w) {
                                    return w.globals.seriesTotals.reduce((a, b) => a + b, 0)
                                }
                            }
                        }
                    }
                }
            }
        };

        var statusChart = new ApexCharts(document.querySelector("#statusDistributionChart"), statusOptions);
        statusChart.render();
    });
</script>
@endsection
