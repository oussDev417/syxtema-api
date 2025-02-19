@extends('layout.master')

@section('title')
    Détails du Message #{{ $contact->id }}
@endsection

@section('main-content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="header-title">Message de Contact #{{ $contact->id }}</h4>
                        <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Retour à la liste
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h5 class="text-muted mb-2">Informations de l'expéditeur</h5>
                                <div class="p-3 bg-light rounded">
                                    <p class="mb-2">
                                        <strong>Nom :</strong> {{ $contact->name }}
                                    </p>
                                    <p class="mb-2">
                                        <strong>Email :</strong> 
                                        <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>
                                    </p>
                                    <p class="mb-0">
                                        <strong>Téléphone :</strong> 
                                        @if($contact->phone)
                                            <a href="tel:{{ $contact->phone }}">{{ $contact->phone }}</a>
                                        @else
                                            Non renseigné
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <h5 class="text-muted mb-2">Détails du message</h5>
                                <div class="p-3 bg-light rounded">
                                    <p class="mb-2">
                                        <strong>Date d'envoi :</strong> 
                                        {{ $contact->created_at->format('d/m/Y H:i') }}
                                    </p>
                                    <p class="mb-2">
                                        <strong>Statut :</strong>
                                        @if($contact->is_read)
                                            <span class="badge bg-success">Lu</span>
                                        @else
                                            <span class="badge bg-warning">Non lu</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h5 class="text-muted mb-2">Contenu du message</h5>
                        <div class="p-3 bg-light rounded">
                            {{ $contact->message }}
                        </div>
                    </div>

                    <div class="mt-4 text-end">
                        <form action="{{ route('admin.contacts.destroy', $contact) }}" 
                              method="POST" 
                              class="d-inline"
                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce message ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash me-1"></i> Supprimer le message
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 