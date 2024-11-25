@extends('layout.master')
@section('title', 'Liste des témoignages')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/datatables.min.css') }}">
@endsection

@section('main-content')
    <div class="container">
        <h1>Liste des Témoignages</h1>
        <a href="{{ route('admin.testimonials.create') }}" class="btn btn-success mb-3">Ajouter un Témoignage</a>
        <table id="testimonialsTable" class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Profession</th>
                    <th>Message</th>
                    <th>Avatar</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($testimonials as $testimonial)
                    <tr>
                        <td>{{ $testimonial->id }}</td>
                        <td>{{ $testimonial->nom }}</td>
                        <td>{{ $testimonial->profession }}</td>
                        <td>{{ $testimonial->message }}</td>
                        <td><img src="{{ asset('storage/' . $testimonial->avatar) }}" alt="" style="height:3em;"></td>
                        <td>
                            <a href="{{ route('admin.testimonials.edit', $testimonial->id) }}"
                                class="btn btn-light-success">
                                <i class="ti ti-edit"></i>
                            </a>
                            <form action="{{ route('admin.testimonials.destroy', $testimonial->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce témoignage ?')"
                                    class="btn btn-light-danger">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/vendor/datatables/datatables.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#testimonialsTable').DataTable();
        });
    </script>
@endsection
