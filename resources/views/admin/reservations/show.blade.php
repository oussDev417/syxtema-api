@extends('layout.master')

@section('title', 'Détails de la Réservation')

@section('css')
<style>
    .status-badge {
        font-size: 1rem;
        padding: 0.5rem 1rem;
    }
    .timeline {
        border-left: 2px solid #dee2e6;
        padding: 1rem 0;
    }
    .timeline-item {
        position: relative;
        padding-left: 2rem;
        margin-bottom: 1rem;
    }
    .timeline-item::before {
        content: '';
        position: absolute;
        left: -0.5rem;
        top: 0.25rem;
        width: 1rem;
        height: 1rem;
        border-radius: 50%;
        background: #fff;
        border: 2px solid #007bff;
    }
</style>
@endsection

@section('main-content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Détails de la Réservation #{{ $reservation->id }}</h1>
        <div>
            <a href="{{ route('admin.reservations.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Informations de la Réservation</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6>Statut</h6>
                            @php
                                $statusClass = match($reservation->status) {
                                    'en_attente' => 'warning',
                                    'approuvé' => 'success',
                                    'rejeté' => 'danger',
                                    default => 'secondary'
                                };
                            @endphp
                            <span class="badge bg-{{ $statusClass }} status-badge">
                                {{ $reservation->status }}
                            </span>
                        </div>
                        <div class="col-md-6">
                            <h6>Date de création</h6>
                            <p>{{ $reservation->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6>Date de début</h6>
                            <p>{{ $reservation->datestart->format('d/m/Y H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6>Date de fin</h6>
                            <p>{{ $reservation->dateend->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <h6>Message du client</h6>
                        <p class="mb-0">{{ $reservation->message ?: 'Aucun message' }}</p>
                    </div>

                    @if($reservation->status === 'pending')
                        <div class="d-flex gap-2">
                            <button type="button" 
                                    class="btn btn-success"
                                    onclick="updateStatus('{{ $reservation->id }}', 'approuvé')">
                                <i class="fas fa-check"></i> Approuver
                            </button>
                            <button type="button" 
                                    class="btn btn-danger"
                                    onclick="updateStatus('{{ $reservation->id }}', 'rejeté')">
                                <i class="fas fa-times"></i> Rejeter
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Espace de Coworking</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            @if($reservation->coworking->image)
                                <img src="{{ asset('storage/' . $reservation->coworking->image) }}" 
                                     alt="{{ $reservation->coworking->name }}"
                                     class="img-fluid rounded">
                            @endif
                        </div>
                        <div class="col-md-8">
                            <h5>{{ $reservation->coworking->name }}</h5>
                            <p class="text-muted">{{ $reservation->coworking->location }}</p>
                            <div class="mb-2">
                                <strong>Prix :</strong> {{ $reservation->coworking->price }}€/jour
                            </div>
                            <div class="mb-2">
                                <strong>Capacité :</strong> {{ $reservation->coworking->capacity }} personnes
                            </div>
                            <a href="{{ route('admin.coworkings.edit', $reservation->coworking) }}" 
                               class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i> Modifier l'espace
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Informations du Client</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        @if($reservation->user->avatar)
                            <img src="{{ asset('storage/' . $reservation->user->avatar) }}" 
                                 alt="Avatar" 
                                 class="rounded-circle me-2"
                                 style="width: 48px; height: 48px; object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-secondary me-2 d-flex align-items-center justify-content-center"
                                 style="width: 48px; height: 48px;">
                                <i class="fas fa-user text-white"></i>
                            </div>
                        @endif
                        <div>
                            <h6 class="mb-0">{{ $reservation->user->first_name }} {{ $reservation->user->last_name }}</h6>
                            <small class="text-muted">{{ $reservation->user->email }}</small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <h6>Téléphone</h6>
                        <p class="mb-0">{{ $reservation->user->phone ?: 'Non renseigné' }}</p>
                    </div>

                    <div class="mb-3">
                        <h6>Membre depuis</h6>
                        <p class="mb-0">{{ $reservation->user->created_at->format('d/m/Y') }}</p>
                    </div>

                    <a href="" 
                       class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-user"></i> Voir le profil
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Historique</h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <small class="text-muted">{{ $reservation->created_at->format('d/m/Y H:i') }}</small>
                            <p class="mb-0">Réservation créée</p>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
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