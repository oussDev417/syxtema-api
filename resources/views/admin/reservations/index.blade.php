@extends('layout.master')

@section('title', 'Gestion des Réservations')

@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
@endsection

@section('main-content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Réservations</h1>
        <div>
            <a href="{{ route('admin.reservations.statistics') }}" class="btn btn-info me-2">
                <i class="fas fa-chart-bar"></i> Statistiques
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="mb-3">
                <div class="btn-group" role="group">
                    <button type="button" 
                            class="btn btn-outline-primary {{ !request('status') ? 'active' : '' }}"
                            onclick="filterByStatus('')">
                        Tous
                    </button>
                    <button type="button" 
                            class="btn btn-outline-warning {{ request('status') === 'en_attente' ? 'active' : '' }}"
                            onclick="filterByStatus('en_attente')">
                        En attente
                    </button>
                    <button type="button" 
                            class="btn btn-outline-success {{ request('status') === 'approuvé' ? 'active' : '' }}"
                            onclick="filterByStatus('approuvé')">
                        Approuvés
                    </button>
                    <button type="button" 
                            class="btn btn-outline-danger {{ request('status') === 'rejeté' ? 'active' : '' }}"
                            onclick="filterByStatus('rejeté')">
                        Rejetés
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped" id="reservationsTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Client</th>
                            <th>Espace</th>
                            <th>Date début</th>
                            <th>Date fin</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reservations as $reservation)
                            <tr>
                                <td>{{ $reservation->id }}</td>
                                <td>
                                    {{ $reservation->user->first_name }} {{ $reservation->user->last_name }}
                                    <br>
                                    <small class="text-muted">{{ $reservation->user->email }}</small>
                                </td>
                                <td>{{ $reservation->coworking->name }}</td>
                                <td>{{ $reservation->datestart->format('d/m/Y H:i') }}</td>
                                <td>{{ $reservation->dateend->format('d/m/Y H:i') }}</td>
                                <td>
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
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.reservations.show', $reservation) }}" 
                                           class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($reservation->status === 'en_attente')
                                            <button type="button" 
                                                    class="btn btn-sm btn-success"
                                                    onclick="updateStatus('{{ $reservation->id }}', 'approuvé')">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button type="button" 
                                                    class="btn btn-sm btn-danger"
                                                    onclick="updateStatus('{{ $reservation->id }}', 'rejeté')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<!-- DataTables -->
<script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>

<script>
$(document).ready(function() {
    $('#reservationsTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/French.json'
        },
        order: [[0, 'desc']]
    });
});

function filterByStatus(status) {
    const url = new URL(window.location.href);
    if (status) {
        url.searchParams.set('status', status);
    } else {
        url.searchParams.delete('status');
    }
    window.location.href = url.toString();
}

function updateStatus(id, status) {
    if (confirm(`Voulez-vous ${status === 'approuvé' ? 'approuver' : 'rejeter'} cette réservation ?`)) {
        fetch(`/admin/reservations/${id}/status`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Une erreur est survenue');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Une erreur est survenue');
        });
    }
}
</script>
@endsection 