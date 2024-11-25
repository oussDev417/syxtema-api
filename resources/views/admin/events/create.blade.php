@extends('layout.master')
@section('title', 'Ajouter un Événement')
@section('css')

    <!-- filepond css -->
    <link rel="stylesheet" href="{{asset('assets/vendor/filepond/filepond.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/filepond/image-preview.min.css')}}">

    <!-- editor css -->
    <link rel="stylesheet" href="{{asset('assets/vendor/trumbowyg/trumbowyg.min.css')}}">
@endsection

@section('main-content')
<div class="container-fluid">
    <h1>Ajouter un Événement</h1>
    <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="title" class="form-label">Titre</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="type" class="form-label">Type d'Événement</label>
                <select class="form-select" id="type" name="type" required>
                    <option value="1">À venir</option>
                    <option value="2">En cours</option>
                    <option value="3">Passé</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="event_category_id" class="form-label">Catégorie</label>
                <select class="form-select" id="event_category_id" name="event_category_id" required>
                    <option value="">Sélectionnez une catégorie</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="slug" class="form-label">Slug</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="slug" name="slug" required>
                    <button type="button" class="btn btn-outline-secondary" id="generateSlug">Générer</button>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label for="thumbnail" class="form-label">Miniature</label>
                <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept="image/*">
                <div id="thumbnailPreview" class="mt-2"></div>
            </div>
            <div class="col-md-6 mb-3">
                <label for="start_date" class="form-label">Date de Début</label>
                <input type="date" class="form-control" id="start_date" name="start_date" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="end_date" class="form-label">Date de Fin</label>
                <input type="date" class="form-control" id="end_date" name="end_date" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="location" class="form-label">Lieu</label>
                <input type="text" class="form-control" id="location" name="location" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="price" class="form-label">Prix</label>
                <input type="number" class="form-control" id="price" name="price" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="number_of_ticket" class="form-label">Nombre de Tickets</label>
                <input type="number" class="form-control" id="number_of_ticket" name="number_of_ticket" required>
            </div>
            <div class="col-md-12 mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description"></textarea>
            </div>
            <div class="col-md-6 mb-3">
                <label for="user_id" class="form-label">Utilisateur</label>
                <select class="form-select" id="user_id" name="user_id" required>
                    <!-- Remplir avec les utilisateurs -->
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="status" class="form-label">Statut</label>
                <input type="number" class="form-control" id="status" name="status" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Ajouter Événement</button>
    </form>
</div>
@endsection

@section('script')
    <!--customizer-->
    <div id="customizer"></div>

    <!-- Trumbowyg js -->
    <script src="{{asset('assets/vendor/trumbowyg/trumbowyg.min.js')}}"></script>

    <!-- filepond -->
    <script src="{{asset('assets/vendor/filepond/file-encode.min.js')}}"></script>
    <script src="{{asset('assets/vendor/filepond/validate-size.min.js')}}"></script>
    <script src="{{asset('assets/vendor/filepond/validate-type.js')}}"></script>
    <script src="{{asset('assets/vendor/filepond/exif-orientation.min.js')}}"></script>
    <script src="{{asset('assets/vendor/filepond/image-preview.min.js')}}"></script>
    <script src="{{asset('assets/vendor/filepond/filepond.min.js')}}"></script>

    <!-- add event js -->
    <script src="{{asset('assets/js/add_event.js')}}"></script>

    <script>
        // Générer le slug à partir du titre
        document.getElementById('generateSlug').addEventListener('click', function() {
            const title = document.getElementById('title').value;
            const slug = title.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
            document.getElementById('slug').value = slug;
        });

        // Prévisualisation de l'image sélectionnée
        document.getElementById('thumbnail').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('thumbnailPreview').innerHTML = `
                        <img src="${e.target.result}" class="img-thumbnail" style="max-width: 200px; margin-top: 10px;">
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