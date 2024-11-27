@extends('layout.master')
@section('title', 'Ajouter une Catégorie de Service')

@section('main-content')
<div class="container">
    <h1>Ajouter une Catégorie de Service</h1>
    <form action="{{ route('admin.service_categories.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nom</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <button type="submit" class="btn btn-primary">Ajouter Catégorie de Service</button>
    </form>
</div>
@endsection 