@extends('master')

@section('content')
    <div class="row g-4">

        {{-- Sales --}}
        <div class="col-md-4">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="text-muted mb-0">Sales</h6>
                    <i class="bi bi-cart-check fs-4 text-primary"></i>
                </div>

                <h3 class="fw-bold">{{ $stats['sales']['count'] ?? 0 }}</h3>
                <p>{{ $stats['sales']['growth'] ?? 0 }}%</p>
                <span>{{ $stats['sales']['label'] ?? 'N/A' }}</span>

            </div>
        </div>

        {{-- Revenue --}}
        <div class="col-md-4">
            <div class="stat-card green">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="text-muted mb-0">Revenue</h6>
                    <i class="bi bi-currency-dollar fs-4 text-success"></i>
                </div>

                <h3 class="fw-bold">${{ number_format($stats['revenue']['amount']) }}</h3>

                <p class="small mb-0 text-success">
                    <i class="bi bi-arrow-up"></i>
                    {{ $stats['revenue']['growth'] }}%
                    <span class="text-muted">{{ $stats['revenue']['label'] }}</span>
                </p>
            </div>
        </div>

        {{-- Customers --}}
        <div class="col-md-4">
            <div class="stat-card orange">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="text-muted mb-0">Customers</h6>
                    <i class="bi bi-people fs-4 text-warning"></i>
                </div>

                <h3 class="fw-bold">{{ number_format($stats['customers']['count']) }}</h3>

                <p class="small mb-0 {{ $stats['customers']['growth'] >= 0 ? 'text-success' : 'text-danger' }}">
                    <i class="bi {{ $stats['customers']['growth'] >= 0 ? 'bi-arrow-up' : 'bi-arrow-down' }}"></i>
                    {{ abs($stats['customers']['growth']) }}%
                    <span class="text-muted">{{ $stats['customers']['label'] }}</span>
                </p>
            </div>
        </div>

    </div>
@endsection
