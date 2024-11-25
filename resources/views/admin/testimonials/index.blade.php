@extends('layout.master')
@section('title', 'Événements')
@section('css')

<!-- filepond css -->
<link rel="stylesheet" href="{{asset('assets/vendor/filepond/filepond.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/filepond/image-preview.min.css')}}">
<!-- editor css -->
<link rel="stylesheet" href="{{asset('assets/vendor/trumbowyg/trumbowyg.min.css')}}">
@endsection

@section('main-content')
<div class="container">
    <h1>Témoignages</h1>
    <a href="{{ route('admin.testimonials.create') }}" class="btn btn-success mb-3">Ajouter un Témoignage</a>
    <table id="testimonialsTable" class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Profession</th>
                <th>Message</th>
                <th>Avatar</th>
                <th>Logo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($testimonials as $testimonial)
            <tr>
                <td>{{ $testimonial->id }}</td>
                <td>{{ $testimonial->nom }}</td>
                <td>{{ $testimonial->profession }}</td>
                <td>{{ $testimonial->message }}</td>
                <td>{{ $testimonial->avatar }}</td>
                <td>{{ $testimonial->logo }}</td>
                <td>
                    <form action="{{ route('admin.testimonials.destroy', $testimonial->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <a href="{{ route('admin.testimonials.edit', $testimonial->id) }}" class="btn btn-light-success icon-btn b-r-4">
                            <i class="ti ti-edit text-success"></i>
                        </a>
                        <button type="submit" class="btn btn-light-danger icon-btn b-r-4">
                            <i class="ti ti-trash"></i>
                        </button>
                    </form>
                    <!-- <button type="button" class="btn btn-light-success icon-btn b-r-4" onclick=`alert('ok'); window.location.href="{{ route('admin.testimonials.edit', $testimonial->id) }}" `>
                        <i class="ti ti-edit text-success"></i>
                    </button>
                    <button type="button" class="btn btn-light-danger icon-btn b-r-4 delete-btn" onclick="testimonial.preventDefault(); if(confirm('Êtes-vous sûr de vouloir supprimer ce témoignage ?')) { document.getElementById('delete-form-{{ $testimonial->id }}').submit(); }">
                        <i class="ti ti-trash"></i>
                    </button>
                    <form id="delete-form-{{ $testimonial->id }}" action="{{ route('admin.testimonials.destroy', $testimonial->id) }}" method="POST" style="display:none;">
                        @csrf
                        @method('DELETE')
                    </form> -->
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@section('scripts')
<script>
    $(document).ready(function() {
        $('#testimonialsTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    });
</script>
@endsection
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

<!-- add blog js  -->
<script src="{{asset('assets/js/add_blog.js')}}"></script>
@endsection