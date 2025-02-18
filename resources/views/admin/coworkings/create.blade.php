@extends('layout.master')

@section('title', 'Ajouter un Espace de Coworking')

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
        <h1>Ajouter un Espace de Coworking</h1>
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
            <form action="{{ route('admin.coworkings.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="form-label">Nom de l'espace <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="title" class="form-label">Titre <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title') }}" 
                                   required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="slug" class="form-label">Slug</label>
                    <div class="input-group">
                        <input type="text" 
                                class="form-control @error('slug') is-invalid @enderror" 
                                id="slug" 
                                name="slug"  
                                required>
                        <button type="button" class="btn btn-outline-secondary" id="generateSlug">
                            Générer
                        </button>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="location" class="form-label">Localisation <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('location') is-invalid @enderror" 
                                   id="location" 
                                   name="location" 
                                   value="{{ old('location') }}" 
                                   required>
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="map_url" class="form-label">URL Google Maps</label>
                            <input type="url" 
                                   class="form-control @error('map_url') is-invalid @enderror" 
                                   id="map_url" 
                                   name="map_url" 
                                   value="{{ old('map_url') }}">
                            @error('map_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="price" class="form-label">Prix (FCFA) <span class="text-danger">*</span></label>
                            <input type="number" 
                                   class="form-control @error('price') is-invalid @enderror" 
                                   id="price" 
                                   name="price" 
                                   value="{{ old('price') }}" 
                                   min="0" 
                                   required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="capacity" class="form-label">Capacité (personnes) <span class="text-danger">*</span></label>
                            <input type="number" 
                                   class="form-control @error('capacity') is-invalid @enderror" 
                                   id="capacity" 
                                   name="capacity" 
                                   value="{{ old('capacity') }}" 
                                   min="1" 
                                   required>
                            @error('capacity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control editor @error('description') is-invalid @enderror" 
                              id="description" 
                              name="description" 
                              rows="5">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="advantage" class="form-label">Avantages</label>
                    <textarea class="form-control editor @error('advantage') is-invalid @enderror" 
                              id="advantage" 
                              name="advantage" 
                              rows="5">{{ old('advantage') }}</textarea>
                    @error('advantage')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="status" class="form-label">Statut <span class="text-danger">*</span></label>
                    <select class="form-select @error('status') is-invalid @enderror" 
                            id="status" 
                            name="status" 
                            required>
                        <option value="disponible" {{ old('status') == 'disponible' ? 'selected' : '' }}>Disponible</option>
                        <option value="occupé" {{ old('status') == 'occupé' ? 'selected' : '' }}>Occupé</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-4">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" 
                           class="filepond @error('image') is-invalid @enderror" 
                           name="image" 
                           accept="image/*">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<!-- filepond js -->
<script src="{{ asset('assets/vendor/filepond/filepond.js') }}"></script>
<script src="{{ asset('assets/vendor/filepond/image-preview.min.js') }}"></script>

<!-- editor js -->
<script src="{{ asset('assets/vendor/trumbowyg/trumbowyg.min.js') }}"></script>
<script src="{{ asset('assets/vendor/trumbowyg/langs/fr.min.js') }}"></script>

<script>
    // Initialisation de FilePond
    FilePond.registerPlugin(FilePondPluginImagePreview);
    const inputElement = document.querySelector('input[type="file"]');
    const pond = FilePond.create(inputElement, {
        labelIdle: 'Glissez & déposez votre image ou <span class="filepond--label-action">Parcourir</span>',
        imagePreviewHeight: 170,
        imageCropAspectRatio: '16:9',
        imageResizeTargetWidth: 1200,
        imageResizeTargetHeight: 675,
        stylePanelLayout: 'compact circle',
        styleLoadIndicatorPosition: 'center bottom',
        styleProgressIndicatorPosition: 'right bottom',
        styleButtonRemoveItemPosition: 'left bottom',
        styleButtonProcessItemPosition: 'right bottom',
    });

    // Initialisation de l'éditeur
    $('.editor').trumbowyg({
        lang: 'fr',
        btns: [
            ['viewHTML'],
            ['formatting'],
            ['strong', 'em'],
            ['link'],
            ['unorderedList', 'orderedList'],
            ['removeformat'],
            ['fullscreen']
        ]
    });

    // Générer le slug à partir du titre
    $('#generateSlug').click(function() {
        const title = $('#title').val();
        const slug = title.toLowerCase()
                         .replace(/[^a-z0-9]+/g, '-')
                         .replace(/^-+|-+$/g, '');
        $('#slug').val(slug);
    });
</script>
@endsection 