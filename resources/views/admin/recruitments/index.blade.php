@extends('layout.master')

@section('title', 'Liste des recrutements')

@section('main-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Recrutements</h4>
                    <div class="page-title-right">
                        <a href="{{ route('admin.recruitments.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Nouvelle offre
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered dt-responsive nowrap">
                            <thead>
                                <tr>
                                    <th>Titre</th>
                                    <th>Pays</th>
                                    <th>Date limite</th>                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recruitments as $recruitment)
                                    <tr>
                                        <td>{{ $recruitment->title }}</td>
                                        <td>{{ $recruitment->country->name }}</td>
                                        <td>{{ $recruitment->deadline->format('d/m/Y') }}</td>
                                        <td>
                                            @if($recruitment->is_expired)
                                                <span class="badge bg-danger">Expirée</span>
                                            @else
                                                <span class="badge bg-success">En cours</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.applications.index', $recruitment->id) }}" class="btn btn-sm btn-primary" title="Voir les candidatures">
                                                <i class="fas fa-users"></i>
                                                <span class="badge bg-white text-primary">{{ $recruitment->applications_count }}</span>
                                            </a>
                                            <button type="button" 
                                                class="btn btn-light-info"
                                                onclick="window.location='{{ route('admin.recruitments.edit', $recruitment->id) }}'">
                                                <i class="ti ti-edit"></i>
                                            </button>
                                            <form action="{{ route('admin.recruitments.destroy', $recruitment->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" 
                                                    class="btn btn-light-danger delete-btn"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette offre ?')"
                                                    data-id="{{ $recruitment->id }}">
                                                    <i class="ti ti-trash"></i>
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
    </div>
@endsection
