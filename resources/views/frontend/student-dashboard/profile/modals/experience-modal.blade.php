<div class="modal-header">
  <h5 class="modal-title" id="dynamic-modalLabel">{{ __('Ajouter une expérience') }}</h5>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
  <form action="{{ route('student.setting.experience.store') }}" method="POST" class="instructor__profile-form">
    @csrf
    <div class="col-md-12">
      <div class="form-grp">
          <label for="company">{{ __('Entreprise') }} <code>*</code></label>
          <input id="company" name="company" type="text" value="" required>
      </div>
    </div>

    <div class="col-md-12">
      <div class="form-grp">
          <label for="position">{{ __('Poste') }} <code>*</code></label>
          <input id="position" name="position" type="text" value="" required>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <div class="form-grp">
            <label for="start_date">{{ __('Date de début') }} <code>*</code></label>
            <input id="start_date" name="start_date" type="text" value="" required class="datepicker">
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-grp">
            <label for="end_date">{{ __('Date de fin') }} <code>*</code></label>
            <input id="end_date" name="end_date" type="text" value="" required class="datepicker">
        </div>
      </div>

    </div>
    <div class="p-2"></div>
    <div class="text-end">
      <button type="submit" class="btn">{{ __('Enregistrer') }}</button>
    </div>
  </form>
</div>