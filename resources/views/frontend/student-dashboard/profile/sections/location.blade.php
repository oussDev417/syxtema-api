<div class="tab-pane fade show {{ session('profile_tab') == 'location' ? 'active' : '' }}" id="itemSix-tab-pane"
    role="tabpanel" aria-labelledby="itemSix-tab" tabindex="0">
    <div class="instructor__profile-form-wrap">
        <form action="{{ route('student.setting.address.update') }}" method="POST" class="instructor__profile-form">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-4">
                    <div class="form-grp">
                        <label for="country">{{ __('Pays') }} <code>*</code></label>
                        <select name="country" id="country" class="country form-select">
                            <option value="">{{ __('Sélectionner') }}</option>
                            @foreach (countries() as $country)
                            <option @selected($user->country_id == $country->id) value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach

                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-grp">
                        <label for="state">{{ __('État/Région') }}</label>
                        <input type="text" class="form-control" name="state" id="state" value="{{ $user->state }}"> 
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-grp">
                        <label for="city">{{ __('Ville') }}</label>
                        <input type="text" class="form-control" name="city" id="city" value="{{ $user->city }}">
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-grp">
                        <label for="address">{{ __('Adresse') }}</label>
                        <input id="address" value="{{ $user->address }}" type="address" name="address" placeholder="{{ __('Adresse') }}">
                    </div>
                </div>

            </div>
            <div class="submit-btn mt-25">
                <button type="submit" class="btn">{{ __('Mettre à jour la localisation') }}</button>
            </div>
        </form>
    </div>
</div>
