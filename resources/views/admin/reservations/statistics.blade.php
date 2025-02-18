@extends('layout.master')

@section('title', 'Statistiques des Réservations')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/vendor/chart.js/Chart.min.css') }}">
<style>
    .stat-card {
        border-radius: 8px;
        transition: transform 0.2s;
    }
    .stat-card:hover {
        transform: translateY(-5px);
    }
    .stat-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
    }
</style>
@endsection

@section('main-content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Statistiques des Réservations</h1>
        <div>
            <a href="{{ route('admin.reservations.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>
    </div>

    <!-- Cartes de statistiques -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card stat-card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50">Total</h6>
                            <h2 class="mb-0">{{ $stats['total'] }}</h2>
                        </div>
                        <div class="stat-icon bg-primary-dark">
                            <i class="fas fa-calendar fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50">Approuvées</h6>
                            <h2 class="mb-0">{{ $stats['approved'] }}</h2>
                        </div>
                        <div class="stat-icon bg-success-dark">
                            <i class="fas fa-check fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50">En attente</h6>
                            <h2 class="mb-0">{{ $stats['pending'] }}</h2>
                        </div>
                        <div class="stat-icon bg-warning-dark">
                            <i class="fas fa-clock fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card bg-danger text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50">Rejetées</h6>
                            <h2 class="mb-0">{{ $stats['rejected'] }}</h2>
                        </div>
                        <div class="stat-icon bg-danger-dark">
                            <i class="fas fa-times fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Graphique des réservations mensuelles -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Évolution des réservations</h5>
                </div>
                <div class="card-body">
                    <canvas id="monthlyChart" height="300"></canvas>
                </div>
            </div>
        </div>

        <!-- Réservations récentes -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Réservations récentes</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @foreach($stats['recent'] as $reservation)
                            <div class="list-group-item px-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">{{ $reservation->user->first_name }} {{ $reservation->user->last_name }}</h6>
                                        <small class="text-muted">
                                            {{ $reservation->coworking->name }}
                                        </small>
                                    </div>
                                    <div>
                                        @php
                                            $statusClass = match($reservation->status) {
                                                'en_attente' => 'warning',
                                                'approuvé' => 'success',
                                                'rejeté' => 'danger',
                                                default => 'secondary'
                                            };
                                        @endphp
                                        <span class="badge bg-{{ $statusClass }}">
                                            {{ $reservation->status }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('assets/vendor/chart.js/Chart.min.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const monthlyData = @json($stats['monthly']);
    const labels = monthlyData.map(item => {
        const date = new Date(item.year, item.month - 1);
        return date.toLocaleDateString('fr-FR', { month: 'short', year: 'numeric' });
    });
    const data = monthlyData.map(item => item.total);

    new Chart(document.getElementById('monthlyChart'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Nombre de réservations',
                data: data,
                fill: false,
                borderColor: '#3b7ddd',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
});
</script>
@endsection 