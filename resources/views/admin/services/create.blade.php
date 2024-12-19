@extends('layout.master')
@section('title', 'Ajouter un Service')
@section('css')
    <!-- editor css -->
    <link rel="stylesheet" href="{{asset('assets/vendor/trumbowyg/trumbowyg.min.css')}}">
@endsection

@section('main-content')
<div class="container">
    <h1>Ajouter un Service</h1>
    <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="service_category_id" class="form-label">Catégorie de Service</label>
            <select class="form-select" id="service_category_id" name="service_category_id" required>
                <option value="">Sélectionnez une catégorie</option>
                @foreach($serviceCategories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="departement_id" class="form-label">Département</label>
            <select class="form-select" id="departement_id" name="departement_id" required>
                <option value="">Sélectionnez un département</option>
                @foreach($departements as $departement)
                    <option value="{{ $departement->id }}">{{ $departement->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Nom</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
        </div>
        <div class="mb-3">
            <label for="secteur" class="form-label">Secteur</label>
            <input type="text" class="form-control" id="secteur" name="secteur">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Ajouter Service</button>
    </form>
</div>
@endsection

@section('script')
    <script src="{{asset('assets/vendor/trumbowyg/trumbowyg.min.js')}}"></script>
    <script>
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