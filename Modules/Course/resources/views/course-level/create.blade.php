@extends('admin.master_layout')
@section('title')
    <title>{{ __('Liste des niveaux de cours') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('Liste des niveaux de cours') }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{ __('Tableau de bord') }}</a>
                    </div>
                    <div class="breadcrumb-item active"><a
                            href="{{ route('admin.course-level.index') }}">{{ __('Liste des niveaux de cours') }}</a>
                    </div>
                    <div class="breadcrumb-item">{{ __('Ajouter un niveau') }}</div>
                </div>
            </div>
            <div class="section-body">
                <div class="mt-4 row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h4>{{ __('Ajouter un niveau') }}</h4>
                                <div>
                                    <a href="{{ route('admin.course-level.index') }}" class="btn btn-primary"><i
                                            class="fa fa-arrow-left"></i>{{ __('Retour') }}</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.course-level.store') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-8 offset-md-2">
                                            <div class="form-group">
                                                <label for="name">{{ __('Nom') }}<span
                                                        class="text-danger">*</span></label>
                                                <input type="text" id="name" name="name"
                                                    value="{{ old('name') }}" placeholder="{{ __('Entrer le nom') }}"
                                                    class="form-control">
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-8 offset-md-2">
                                            <div class="form-group">
                                                <label for="slug">{{ __('Slug') }}<span
                                                        class="text-danger">*</span></label>
                                                <input type="text" id="slug" name="slug"
                                                    value="{{ old('slug') }}" placeholder="{{ __('Entrer le slug') }}"
                                                    class="form-control">
                                                @error('slug')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-8 offset-md-2">
                                            <div class="form-group">
                                                <label for="status">{{ __('Statut') }}<span
                                                        class="text-danger">*</span></label>
                                                <select class="form-control" name="status">
                                                    <option value="1">{{ __('Actif') }}</option>
                                                    <option value="0">{{ __('Inactif') }}</option>
                                                </select>
                                                @error('status')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="text-center offset-md-2 col-md-8">
                                            <x-admin.save-button :text="__('Enregistrer')">
                                            </x-admin.save-button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('js')
    <script>
        'use strict';
        $(function() {
            const $name = $("#name"),
                $slug = $("#slug");

            $name.on("keyup", function(e) {
                $slug.val(convertToSlug($name.val()));
            });

            function convertToSlug(text) {
                return text
                    .toLowerCase()
                    .replace(/[^a-z\s-]/g, "") // Supprime tous les caractères non-mot (sauf -)
                    .replace(/\s+/g, "-") // Remplace les espaces par des -
                    .replace(/-+/g, "-"); // Remplace plusieurs - par un seul -
            }
        });
    </script>
@endpush
