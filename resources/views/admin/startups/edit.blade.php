@extends('layout.master')
@section('title', 'Modifier une Startup')
@section('css')
    <!-- editor css -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/trumbowyg/trumbowyg.min.css') }}">
@endsection

@section('main-content')
    <div class="container">
        <h1>Modifier une Startup</h1>
        <form action="{{ route('admin.startups.update', $startup->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Nom</label>
                    <input type="text" class="form-control" id="name" name="name"
                        value="{{ $startup->name }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="slug" class="form-label">Slug</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="slug" name="slug"
                            value="{{ $startup->slug }}" required>
                        <button type="button" class="btn btn-outline-secondary" id="generateSlug">Générer</button>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="secteur" class="form-label">Secteur</label>
                    <input type="text" class="form-control" id="secteur" name="secteur" value="{{ $service->secteur }}">
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description">{{ $startup->description }}</textarea>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </form>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/vendor/trumbowyg/trumbowyg.min.js') }}"></script>
    <script>
        // Générer le slug à partir du titre
        document.getElementById('generateSlug').addEventListener('click', function() {
            const name = document.getElementById('name').value;
            const slug = name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
            document.getElementById('slug').value = slug;
        });
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
