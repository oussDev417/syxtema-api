@extends('layout.master')
@section('title', 'Modifier une Catégorie de Service')

@section('main-content')
<div class="container">
    <h1>Modifier une Catégorie de Service</h1>
    <form action="{{ route('admin.service_categories.update', $serviceCategory->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Nom</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $serviceCategory->name }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Mettre à Jour la Catégorie de Service</button>
    </form>
</div>
@endsection 