@extends('layout.master')

@section('title', 'Gestion des Espaces de Coworking')

@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
@endsection

@section('main-content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Espaces de Coworking</h1>
        <a href="{{ route('admin.coworkings.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Ajouter un espace
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="coworkingsTable">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Nom</th>
                            <th>Titre</th>
                            <th>Localisation</th>
                            <th>Prix</th>
                            <th>Capacité</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($coworkings as $coworking)
                            <tr>
                                <td>
                                    @if($coworking->image)
                                        <img src="{{ asset('storage/' . $coworking->image->path) }}" 
                                             alt="{{ $coworking->name }}" 
                                             class="img-thumbnail" 
                                             style="max-width: 50px;">
                                    @else
                                        <span class="text-muted">Aucune image</span>
                                    @endif
                                </td>
                                <td>{{ $coworking->name }}</td>
                                <td>{{ $coworking->title }}</td>
                                <td>{{ $coworking->location }}</td>
                                <td>{{ number_format($coworking->price, 0, ',', ' ') }} FCFA</td>
                                <td>{{ $coworking->capacity }} personnes</td>
                                <td>
                                    <span class="badge bg-{{ $coworking->status === 'disponible' ? 'success' : 'danger' }}">
                                        {{ $coworking->status }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.coworkings.edit', $coworking) }}" 
                                           class="btn btn-light-success">
                                            <i class="ti ti-edit"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-light-{{ $coworking->status === 'disponible' ? 'warning' : 'success' }}"
                                                onclick="toggleStatus('{{ $coworking->id }}')">
                                            <i class="ti ti-exchange"></i>
                                        </button>
                                        <button type="button" 
                                                class="btn btn-light-danger"
                                                onclick="confirmDelete('{{ $coworking->id }}')">
                                            <i class="ti ti-trash"></i>
                                        </button>
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

<!-- Modal de confirmation de suppression -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmer la suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Êtes-vous sûr de vouloir supprimer cet espace de coworking ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form id="deleteForm" method="POST" style="display: inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
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
    $('#coworkingsTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/French.json'
        }
    });
});

function confirmDelete(id) {
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    const form = document.getElementById('deleteForm');
    form.action = `/admin/coworkings/${id}`;
    modal.show();
}

function toggleStatus(id) {
    if (confirm('Voulez-vous changer le statut de cet espace ?')) {
        fetch(`/admin/coworkings/${id}/toggle-status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
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