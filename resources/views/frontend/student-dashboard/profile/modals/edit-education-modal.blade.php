<div class="modal-header">
  <h5 class="modal-title" id="dynamic-modalLabel">{{ __('Modifier la formation') }}</h5>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
  <form action="{{ route('student.setting.education.update', $education->id) }}" method="POST" class="instructor__profile-form">
    @csrf
    @method('PUT')
    <div class="col-md-12">
      <div class="form-grp">
          <label for="education">{{ __('Formation') }} <code>*</code></label>
          <input id="education" name="education" type="text" value="{{ $education->education }}" required>
          <small>{{ __('Conseil : Décrivez votre diplôme en une ligne') }}</small>
      </div>
    </div>

    <div class="p-2"></div>
    <div class="text-end">
      <button type="submit" class="btn">{{ __('Enregistrer') }}</button>
    </div>
  </form>
</div>
