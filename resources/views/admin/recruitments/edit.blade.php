@extends('layout.master')

@section('title', 'Modifier une offre de recrutement')

@section('main-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Modifier l'offre de recrutement</h4>
                    <div class="page-title-right">
                        <a href="{{ route('admin.recruitments.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Retour
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.recruitments.update', $recruitment->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="country_id" class="form-label">Pays</label>
                                <select name="country_id" id="country_id" class="form-control @error('country_id') is-invalid @enderror" required>
                                    <option value="">Sélectionnez un pays</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}" {{ old('country_id', $recruitment->country_id) == $country->id ? 'selected' : '' }}>
                                            {{ $country->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('country_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="title" class="form-label">Titre</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                       id="title" name="title" value="{{ old('title', $recruitment->title) }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="5" required>{{ old('description', $recruitment->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="file_pdf" class="form-label">Fichier PDF (optionnel)</label>
                                @if($recruitment->file_pdf)
                                    <div class="mb-2">
                                        <a href="{{ Storage::url($recruitment->file_pdf) }}" target="_blank" class="btn btn-sm btn-info">
                                            <i class="fas fa-file-pdf"></i> Voir le fichier actuel
                                        </a>
                                    </div>
                                @endif
                                <input type="file" class="form-control @error('file_pdf') is-invalid @enderror" 
                                       id="file_pdf" name="file_pdf" accept=".pdf">
                                <small class="form-text text-muted">Laissez vide pour conserver le fichier actuel</small>
                                @error('file_pdf')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="deadline" class="form-label">Date limite</label>
                                <input type="date" class="form-control @error('deadline') is-invalid @enderror" 
                                       id="deadline" name="deadline" value="{{ old('deadline', $recruitment->deadline->format('Y-m-d')) }}" required>
                                @error('deadline')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Mettre à jour l'offre</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if($recruitment->applications->count() > 0)
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Candidatures reçues</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Email</th>
                                        <th>Téléphone</th>
                                        <th>Date</th>
                                        <th>Documents</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recruitment->applications as $application)
                                        <tr>
                                            <td>{{ $application->name }}</td>
                                            <td>{{ $application->email }}</td>
                                            <td>{{ $application->phone_number }}</td>
                                            <td>{{ $application->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                @if($application->cv)
                                                    <a href="{{ Storage::url($application->cv) }}" target="_blank" class="btn btn-sm btn-info">
                                                        <i class="fas fa-file"></i> CV
                                                    </a>
                                                @endif
                                                @if($application->cover_letter)
                                                    <a href="{{ Storage::url($application->cover_letter) }}" target="_blank" class="btn btn-sm btn-info">
                                                        <i class="fas fa-file-alt"></i> Lettre
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        // Initialiser l'éditeur de texte riche pour la description si nécessaire
        $(document).ready(function() {
            if (typeof CKEDITOR !== 'undefined') {
                CKEDITOR.replace('description');
            }
        });
    </script>
@endpush
