@extends('admin.master_layout')
@section('title')
    <title>{{ __('Langue du cours') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('Langue du cours') }}</h1>
            </div>

            <div class="section-body">
                <a href="{{ route('admin.course-language.index') }}" class="btn btn-primary"><i class="fas fa-list"></i>
                    {{ __('Liste des langues de cours') }}</a>
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('admin.course-language.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">

                                        <div class="form-group col-12">
                                            <label>{{ __('Nom') }} <span class="text-danger">*</span></label>
                                            <input type="text" id="name" class="form-control" name="name">
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-12">
                                            <label>{{ __('Statut') }} <span class="text-danger">*</span></label>
                                            <select name="status" class="form-control">
                                                <option value="1">{{ __('Actif') }}</option>
                                                <option value="0">{{ __('Inactif') }}</option>
                                            </select>
                                            @error('status')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <button class="btn btn-primary">{{ __('Enregistrer') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>
@endsection
