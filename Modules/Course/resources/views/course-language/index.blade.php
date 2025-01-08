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
                <div class="text-right">
                    <a href="{{ route('admin.course-language.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i>
                        {{ __('Ajouter nouveau') }}</a>
                </div>
                <div class="row mt-4">
                    {{-- Filtre de recherche --}}
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('admin.course-language.index') }}" method="GET"
                                    onchange="$(this).trigger('submit')" class="form_padding">
                                    <div class="row">
                                        <div class="col-md-3 form-group">
                                            <input type="text" name="keyword" value="{{ request()->get('keyword') }}"
                                                class="form-control" placeholder="{{ __('Rechercher') }}">
                                        </div>


                                        <div class="col-md-3 form-group">
                                            <select name="status" id="status" class="form-control">
                                                <option value="">{{ __('Sélectionner le statut') }}</option>
                                                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>
                                                    {{ __('Actif') }}
                                                </option>
                                                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>
                                                    {{ __('Inactif') }}
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <select name="order_by" id="order_by" class="form-control">
                                                <option value="">{{ __('Trier par') }}</option>
                                                <option value="1" {{ request('order_by') == '1' ? 'selected' : '' }}>
                                                    {{ __('Croissant') }}
                                                </option>
                                                <option value="0" {{ request('order_by') == '0' ? 'selected' : '' }}>
                                                    {{ __('Décroissant') }}
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <select name="par-page" id="par-page" class="form-control">
                                                <option value="">{{ __('Par page') }}</option>
                                                <option value="10" {{ '10' == request('par-page') ? 'selected' : '' }}>
                                                    {{ __('10') }}
                                                </option>
                                                <option value="50" {{ '50' == request('par-page') ? 'selected' : '' }}>
                                                    {{ __('50') }}
                                                </option>
                                                <option value="100"
                                                    {{ '100' == request('par-page') ? 'selected' : '' }}>
                                                    {{ __('100') }}
                                                </option>
                                                <option value="all"
                                                    {{ 'all' == request('par-page') ? 'selected' : '' }}>
                                                    {{ __('Tout') }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive table-invoice">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>{{ __('N°') }}</th>
                                                <th>{{ __('Nom') }}</th>
                                                <th>{{ __('Statut') }}</th>
                                                <th>{{ __('Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($courseLanguages as $index => $language)
                                                <tr>
                                                    <td>{{ ++$index }}</td>
                                                    <td>{{ $language->name }}</td>
                                                    <td>
                                                        <input class="change-status"
                                                            data-url="{{ route('admin.course-language.status-update', $language->id) }}"
                                                            id="status_toggle" type="checkbox"
                                                            {{ $language->status ? 'checked' : '' }} data-toggle="toggle"
                                                            data-on="{{ __('Actif') }}" data-off="{{ __('Inactif') }}"
                                                            data-onstyle="success" data-offstyle="danger">
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('admin.course-language.edit', $language->id) }}"
                                                            class="btn btn-primary btn-sm"><i class="fa fa-edit"
                                                                aria-hidden="true"></i></a>
                                                        <a href="javascript:;" data-toggle="modal"
                                                            data-target="#deleteModal" class="btn btn-danger btn-sm"
                                                            onclick="deleteData({{ $language->id }})"><i
                                                                class="fa fa-trash" aria-hidden="true"></i></a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <x-empty-table :name="__('Langue du cours')" route="admin.course-language.create"
                                                    create="yes" :message="__('Aucune donnée trouvée!')" colspan="4"></x-empty-table>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>

    <x-admin.delete-modal />
    <script>
        "use strict";

        function deleteData(id) {
            $("#deleteForm").attr("action", "{{ url('admin/course-language/') }}" + "/" + id)
        }
    </script>
@endsection
