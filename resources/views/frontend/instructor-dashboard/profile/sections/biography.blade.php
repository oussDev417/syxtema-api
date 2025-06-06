<div class="tab-pane fade show {{ session('profile_tab') == 'bio' ? 'active': '' }}" id="itemFour-tab-pane" role="tabpanel" aria-labelledby="itemFour-tab" tabindex="0">

    <div class="instructor__profile-form-wrap">
        <form action="{{ route('instructor.setting.bio.update') }}" method="POST" enctype="multipart/form-data"
            class="instructor__profile-form">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-12">
                    <div class="form-grp">
                        <label for="designation">{{ __('Poste') }} <code>*</code></label>
                        <input id="designation" name="designation" type="text" value="{{ $user->job_title }}">
                    </div>
                </div>
            </div>
            <div class="form-grp">
                <label for="short-bio">{{ __('Courte biographie') }} <code>*</code></label>
                <textarea id="short-bio" name="short_bio">{{ $user->short_bio }}</textarea>

            </div>
            <div class="form-grp">
                <label for="bio">{{ __('Biographie') }} <code>*</code></label>
                <textarea id="bio" name="bio">{{ $user->bio }}</textarea>
            </div>

            <div class="submit-btn mt-25">
                <button type="submit" class="btn">{{ __('Mettre à jour') }}</button>
            </div>
        </form>
    </div>
</div>
