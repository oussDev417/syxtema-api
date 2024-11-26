@extends('layout.master')
@section('title', 'Ajouter un membre')
@section('css')

<!-- filepond css -->
<link rel="stylesheet" href="{{asset('assets/vendor/filepond/filepond.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/filepond/image-preview.min.css')}}">

<!-- editor css -->
<link rel="stylesheet" href="{{asset('assets/vendor/trumbowyg/trumbowyg.min.css')}}">
@endsection

@section('main-content')
<div class="container-fluid">
    <h1>Ajouter un membre</h1>
    <form action="{{ route('admin.teams.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" class="form-control" id="nom" name="nom" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="profession" class="form-label">Profession</label>
                <input type="text" class="form-control" id="profession" name="profession" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="facebook_url" class="form-label">Facebook</label>
                <input type="text" class="form-control" id="facebook_url" name="facebook_url" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="linkedin_url" class="form-label">Linkedin</label>
                <input type="text" class="form-control" id="linkedin_url" name="linkedin_url" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="avatar" class="form-label">Avatar</label>
                <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*">
                <div id="avatarPreview" class="mt-2"></div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Ajouter</button>
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
    // Prévisualisation des images sélectionnées
    document.getElementById('avatar').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatarPreview').innerHTML = `
                        <img src="${e.target.result}" class="img-avatar" style="max-width: 200px; margin-top: 10px;">
                        <p>${file.name}</p>
                    `;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection