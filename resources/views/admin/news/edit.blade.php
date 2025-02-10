@extends('layout.master')
@section('title', 'Modifier une Actualité')
@section('css')

    <!-- filepond css -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/filepond/filepond.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/filepond/image-preview.min.css') }}">

    <!-- editor css -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/trumbowyg/trumbowyg.min.css') }}">
@endsection

@section('main-content')
    <div class="container-fluid">
        <h1>Modifier une Actualité</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('admin.news.update', $new->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="title" class="form-label">Titre</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ $new->title }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="slug" class="form-label">Slug</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="slug" name="slug" value="{{ $new->slug }}" required>
                        <button type="button" class="btn btn-outline-secondary" id="generateSlug">Générer</button>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="country_id" class="form-label">Pays</label>
                    <select class="form-select" id="country_id" name="country_id" required>
                        <option value="">Sélectionnez un pays</option>
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}" {{ $new->country_id == $country->id ? 'selected' : '' }}>
                                {{ $country->country_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="image" class="form-label">Miniature/Image</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    <div id="thumbnailPreview" class="mt-2">
                        @if($new->image)
                            <img src="{{ asset($new->image) }}" class="img-image" style="max-width: 200px; margin-top: 10px;">
                        @endif
                    </div>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description">{{ $new->description }}</textarea>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="created_by" class="form-label">Auteur</label>
                    <select class="form-select" id="created_by" name="created_by">
                        <option value="1" {{ $new->created_by == 1 ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="status" class="form-label">Statut</label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="1" {{ $new->status == '1' ? 'selected' : '' }}>Actif</option>
                        <option value="0" {{ $new->status == '0' ? 'selected' : '' }}>Inactif</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Modifier</button>
        </form>
    </div>
@endsection

@section('script')
    <!--customizer-->
    <div id="customizer"></div>

    <!-- Trumbowyg js -->
    <script src="{{ asset('assets/vendor/trumbowyg/trumbowyg.min.js') }}"></script>

    <!-- filepond -->
    <script src="{{ asset('assets/vendor/filepond/file-encode.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/filepond/validate-size.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/filepond/validate-type.js') }}"></script>
    <script src="{{ asset('assets/vendor/filepond/exif-orientation.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/filepond/image-preview.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/filepond/filepond.min.js') }}"></script>

    <script>
        // Générer le slug à partir du titre
        document.getElementById('generateSlug').addEventListener('click', function() {
            const title = document.getElementById('title').value;
            const slug = title.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
            document.getElementById('slug').value = slug;
        });

        // Prévisualisation de l'image sélectionnée
        document.getElementById('image').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('thumbnailPreview').innerHTML = `
                        <img src="${e.target.result}" class="img-image" style="max-width: 200px; margin-top: 10px;">
                        <p>${file.name}</p>
                    `;
                };
                reader.readAsDataURL(file);
            }
        });

        // Initialiser l'éditeur pour la description
        $('#description').trumbowyg({
            btns: [
                ['viewHTML'],
                ['undo', 'redo'],
                ['formatting'],
                ['strong', 'em', 'del'],
                ['superscript', 'subscript'],
                ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
                ['unorderedList', 'orderedList'],
                ['horizontalRule'],
                ['removeformat'],
                ['fullscreen']
            ],
        });
    </script>
@endsection
