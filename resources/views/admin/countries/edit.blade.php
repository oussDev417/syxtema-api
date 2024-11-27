@extends('layout.master')
@section('title', 'Modifier un Pays')

@section('main-content')
<div class="container">
    <h1>Modifier un Pays</h1>
    <form action="{{ route('admin.countries.update', $country->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="short_name" class="form-label">Nom Court</label>
            <input type="text" class="form-control" id="short_name" name="short_name" value="{{ $country->short_name }}" required>
        </div>
        <div class="mb-3">
            <label for="country_name" class="form-label">Nom du Pays</label>
            <input type="text" class="form-control" id="country_name" name="country_name" value="{{ $country->country_name }}" required>
        </div>
        <div class="mb-3">
            <label for="flag" class="form-label">Drapeau</label>
            <input type="file" class="form-control" id="flag" name="flag" accept="image/*">
        </div>
        <div class="mb-3">
            <label for="slug" class="form-label">Slug</label>
            <input type="text" class="form-control" id="slug" name="slug" value="{{ $country->slug }}" required>
        </div>
        <div class="mb-3">
            <label for="location_map_url" class="form-label">URL de la Carte</label>
            <input type="text" class="form-control" id="location_map_url" name="location_map_url" value="{{ $country->location_map_url }}">
        </div>
        <div class="mb-3">
            <label for="phonecode" class="form-label">Code Téléphonique</label>
            <input type="text" class="form-control" id="phonecode" name="phonecode" value="{{ $country->phonecode }}">
        </div>
        <div class="mb-3">
            <label for="continent" class="form-label">Continent</label>
            <input type="text" class="form-control" id="continent" name="continent" value="{{ $country->continent }}">
        </div>
        <button type="submit" class="btn btn-primary">Mettre à Jour le Pays</button>
    </form>
</div>
@endsection 