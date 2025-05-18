@extends('layout.master')
@section('title', 'Candidatures - ' . $recruitment->title)
@section('page-title', 'Candidatures - ' . $recruitment->title)

@section('main-content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Candidatures - {{ $recruitment->title }}</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nom</th>
                                    <th>Email</th>
                                    <th>Téléphone</th>
                                    <th>CV</th>
                                    <th>Lettre de motivation</th>
                                    <th>Statut</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($applications as $application)
                                <tr>
                                    <td>{{ $application->id }}</td>
                                    <td>{{ $application->name }}</td>
                                    <td>{{ $application->email }}</td>
                                    <td>{{ $application->phone_number }}</td>
                                    <td>
                                        @if($application->cv)
                                        <a href="{{ asset('storage/' . $application->cv) }}" target="_blank" class="btn btn-sm btn-primary">
                                            <i class="fas fa-download"></i> CV
                                        </a>
                                        @endif
                                    </td>
                                    <td>
                                        @if($application->cover_letter)
                                        <a href="{{ asset('storage/' . $application->cover_letter) }}" target="_blank" class="btn btn-sm btn-primary">
                                            <i class="fas fa-download"></i> LM
                                        </a>
                                        @endif
                                    </td>
                                    <td>
                                        <select class="form-select status-select" data-id="{{ $application->id }}">
                                            <option value="pending" {{ $application->status == 'pending' ? 'selected' : '' }}>En attente</option>
                                            <option value="accepted" {{ $application->status == 'accepted' ? 'selected' : '' }}>Acceptée</option>
                                            <option value="rejected" {{ $application->status == 'rejected' ? 'selected' : '' }}>Rejetée</option>
                                        </select>
                                    </td>
                                    <td>{{ $application->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <button type="button" 
                                                class="btn btn-light-danger delete-btn"
                                                data-id="{{ $application->id }}">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Gestion du changement de statut
    $('.status-select').change(function() {
        const id = $(this).data('id');
        const status = $(this).val();
        
        $.ajax({
            url: `/admin/applications/${id}/status`,
            type: 'PUT',
            data: { status },
            success: function(response) {
                toastr.success('Statut mis à jour avec succès');
            },
            error: function() {
                toastr.error('Erreur lors de la mise à jour du statut');
            }
        });
    });

    // Gestion de la suppression
    $('.delete-btn').click(function() {
        const id = $(this).data('id');
        
        if (confirm('Êtes-vous sûr de vouloir supprimer cette candidature ?')) {
            $.ajax({
                url: `/admin/applications/${id}`,
                type: 'DELETE',
                success: function(response) {
                    toastr.success('Candidature supprimée avec succès');
                    location.reload();
                },
                error: function() {
                    toastr.error('Erreur lors de la suppression');
                }
            });
        }
    });
});
</script>
@endpush
@endsection
