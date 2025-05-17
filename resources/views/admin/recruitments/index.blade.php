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
                                    <th>Date limite</th>
                                    <th>Candidatures</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recruitments as $recruitment)
                                    <tr>
                                        <td>{{ $recruitment->title }}</td>
                                        <td>{{ $recruitment->country->name }}</td>
                                        <td>{{ $recruitment->deadline->format('d/m/Y') }}</td>
                                        <td>{{ $recruitment->applications_count ?? 0 }}</td>
                                        <td>
                                            <a href="{{ route('admin.recruitments.edit', $recruitment->id) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.recruitments.destroy', $recruitment->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette offre ?')">
                                                    <i class="fas fa-trash"></i>
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
