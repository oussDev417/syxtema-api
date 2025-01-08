<div class="tab-pane fade show {{ session('profile_tab') == 'password' ? 'active' : '' }}" id="itemTwo-tab-pane" role="tabpanel"
    aria-labelledby="itemTwo-tab" tabindex="0">
    <div class="instructor__profile-form-wrap">
        <form action="{{ route('student.setting.password.update') }}" method="POST" class="instructor__profile-form">
          @csrf
          @method('PUT')
            <div class="form-grp">
                <label for="currentpassword">{{ __('Mot de passe actuel') }} <code>*</code></label>
                <input id="currentpassword" type="password" name="current_password" placeholder="{{ __('Mot de passe actuel') }}">
            </div>
            <div class="form-grp">
                <label for="newpassword">{{ __('Nouveau mot de passe') }} <code>*</code></label>
                <input id="newpassword" type="password" name="password" placeholder="{{ __('Nouveau mot de passe') }}">

            </div>
            <div class="form-grp">
                <label for="repassword">{{ __('Confirmer le nouveau mot de passe') }} <code>*</code></label>
                <input id="repassword" type="password" name="password_confirmation" placeholder="{{ __('Confirmer le nouveau mot de passe') }}">

            </div>
            <div class="submit-btn mt-25">
                <button type="submit" class="btn">{{ __('Mettre à jour le mot de passe') }}</button>
            </div>
        </form>
    </div>
</div>
