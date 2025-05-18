@extends('layout.master')

@section('title', 'Créer une offre de recrutement')

@section('css')
<!-- filepond css -->
<link rel="stylesheet" href="{{ asset('assets/vendor/filepond/filepond.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/filepond/image-preview.min.css') }}">

<!-- editor css -->
<link rel="stylesheet" href="{{ asset('assets/vendor/trumbowyg/trumbowyg.min.css') }}">
@endsection
@section('main-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Nouvelle offre de recrutement</h4>
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
                        <form action="{{ route('admin.recruitments.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="country_id" class="form-label">Pays</label>
                                <select name="country_id" id="country_id" class="form-control @error('country_id') is-invalid @enderror" required>
                                    <option value="">Sélectionnez un pays</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>
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
                                       id="title" name="title" value="{{ old('title') }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="file_pdf" class="form-label">Fichier PDF (optionnel)</label>
                                <input type="file" class="form-control @error('file_pdf') is-invalid @enderror" 
                                       id="file_pdf" name="file_pdf" accept=".pdf">
                                @error('file_pdf')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="deadline" class="form-label">Date limite</label>
                                <input type="date" class="form-control @error('deadline') is-invalid @enderror" 
                                       id="deadline" name="deadline" value="{{ old('deadline') }}" required>
                                @error('deadline')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Créer l'offre</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
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
    });    // Initialisation de l'éditeur
    $('#description').trumbowyg({
        lang: 'fr',
        btns: [
            ['viewHTML'],
            ['undo', 'redo'],
            ['formatting'],
            ['strong', 'em', 'del'],
            ['superscript', 'subscript'],
            ['link'],
            ['insertImage'],
            ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
            ['unorderedList', 'orderedList'],
            ['removeformat'],
            ['fullscreen']
        ],
        autogrow: true
    });
</script>
@endsection
