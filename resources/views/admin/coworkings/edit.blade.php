@extends('layout.master')

@section('title', 'Modifier un Espace de Coworking')

@section('css')
<!-- filepond css -->
<link rel="stylesheet" href="{{ asset('assets/vendor/filepond/filepond.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/filepond/image-preview.min.css') }}">

<!-- editor css -->
<link rel="stylesheet" href="{{ asset('assets/vendor/trumbowyg/trumbowyg.min.css') }}">
@endsection

@section('main-content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Modifier un Espace de Coworking</h1>
        <a href="{{ route('admin.coworkings.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Retour à la liste
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.coworkings.update', $coworking) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Nom</label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $coworking->name) }}" 
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="title" class="form-label">Titre</label>
                        <input type="text" 
                               class="form-control @error('title') is-invalid @enderror" 
                               id="title" 
                               name="title" 
                               value="{{ old('title', $coworking->title) }}" 
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <div class="input-group">
                            <input type="text" 
                                   class="form-control @error('slug') is-invalid @enderror" 
                                   id="slug" 
                                   name="slug" 
                                   value="{{ old('slug', $coworking->slug) }}" 
                                   required>
                            <button type="button" class="btn btn-outline-secondary" id="generateSlug">
                                Générer
                            </button>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="location" class="form-label">Localisation</label>
                        <input type="text" 
                               class="form-control @error('location') is-invalid @enderror" 
                               id="location" 
                               name="location" 
                               value="{{ old('location', $coworking->location) }}" 
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="price" class="form-label">Prix (FCFA)</label>
                        <input type="number" 
                               class="form-control @error('price') is-invalid @enderror" 
                               id="price" 
                               name="price" 
                               value="{{ old('price', $coworking->price) }}" 
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="capacity" class="form-label">Capacité</label>
                        <input type="number" 
                               class="form-control @error('capacity') is-invalid @enderror" 
                               id="capacity" 
                               name="capacity" 
                               value="{{ old('capacity', $coworking->capacity) }}" 
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="map_url" class="form-label">URL Google Maps</label>
                        <input type="url" 
                               class="form-control @error('map_url') is-invalid @enderror" 
                               id="map_url" 
                               name="map_url" 
                               value="{{ old('map_url', $coworking->map_url) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Statut</label>
                        <select class="form-select @error('status') is-invalid @enderror" 
                                id="status" 
                                name="status" 
                                required>
                            <option value="disponible" {{ old('status', $coworking->status) === 'disponible' ? 'selected' : '' }}>
                                Disponible
                            </option>
                            <option value="occupé" {{ old('status', $coworking->status) === 'occupé' ? 'selected' : '' }}>
                                Occupé
                            </option>
                        </select>
                    </div>

                    <div class="col-12 mb-3">
                        <label for="advantage" class="form-label">Avantages</label>
                        <textarea class="form-control @error('advantage') is-invalid @enderror" 
                                  id="advantage" 
                                  name="advantage" 
                                  rows="3">{{ old('advantage', $coworking->advantage) }}</textarea>
                    </div>

                    <div class="col-12 mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" 
                                  name="description" 
                                  rows="5">{{ old('description', $coworking->description) }}</textarea>
                    </div>

                    <div class="col-12 mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" 
                               class="form-control @error('image') is-invalid @enderror" 
                               id="image" 
                               name="image" 
                               accept="image/*">
                        @if($coworking->image)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $coworking->image->path) }}" 
                                     alt="{{ $coworking->name }}" 
                                     class="img-thumbnail" 
                                     style="max-width: 200px;">
                            </div>
                        @endif
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.coworkings.index') }}" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<!-- filepond -->
<script src="{{ asset('assets/vendor/filepond/file-encode.min.js') }}"></script>
<script src="{{ asset('assets/vendor/filepond/validate-size.min.js') }}"></script>
<script src="{{ asset('assets/vendor/filepond/validate-type.js') }}"></script>
<script src="{{ asset('assets/vendor/filepond/image-preview.min.js') }}"></script>
<script src="{{ asset('assets/vendor/filepond/filepond.min.js') }}"></script>

<!-- editor -->
<script src="{{ asset('assets/vendor/trumbowyg/trumbowyg.min.js') }}"></script>

<script>
$(document).ready(function() {
    // Initialiser l'éditeur pour la description
    $('#description').trumbowyg({
        btns: [
            ['viewHTML'],
            ['undo', 'redo'],
            ['formatting'],
            ['strong', 'em', 'del'],
            ['superscript', 'subscript'],
            ['link'],
            ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
            ['unorderedList', 'orderedList'],
            ['horizontalRule'],
            ['removeformat'],
            ['fullscreen']
        ],
        lang: 'fr'
    });

    // Générer le slug à partir du titre
    $('#generateSlug').click(function() {
        const title = $('#title').val();
        const slug = title.toLowerCase()
                         .replace(/[^a-z0-9]+/g, '-')
                         .replace(/^-+|-+$/g, '');
        $('#slug').val(slug);
    });
});
</script>
@endsection 