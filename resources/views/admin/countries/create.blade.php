@extends('layout.master')
@section('title', 'Ajouter un Pays')

@section('main-content')
<div class="container">
    <h1>Ajouter un Pays</h1>
    <form action="{{ route('admin.countries.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="short_name" class="form-label">Nom Court</label>
            <input type="text" class="form-control" id="short_name" name="short_name" required>
        </div>
        <div class="mb-3">
            <label for="country_name" class="form-label">Nom du Pays</label>
            <input type="text" class="form-control" id="country_name" name="country_name" required>
        </div>
        <div class="mb-3">
            <label for="flag" class="form-label">Drapeau</label>
            <input type="file" class="form-control" id="flag" name="flag" accept="image/*">
        </div>
        <div class="mb-3">
            <label for="slug" class="form-label">Slug</label>
            <input type="text" class="form-control" id="slug" name="slug" required>
        </div>
        <div class="mb-3">
            <label for="location_map_url" class="form-label">URL de la Carte</label>
            <input type="text" class="form-control" id="location_map_url" name="location_map_url">
        </div>
        <div class="mb-3">
            <label for="phonecode" class="form-label">Code Téléphonique</label>
            <input type="text" class="form-control" id="phonecode" name="phonecode">
        </div>
        <div class="mb-3">
            <label for="continent" class="form-label">Continent</label>
            <input type="text" class="form-control" id="continent" name="continent">
        </div>
        <button type="submit" class="btn btn-primary">Ajouter Pays</button>
    </form>
</div>
@endsection 