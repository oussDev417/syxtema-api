<div class="dashboard__review-table">
    <div class="dashboard__nav-wrap">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button
                    class="nav-link navigation-btn {{ request('step') == 1 || Route::is('admin.courses.create') || Route::is('admin.courses.edit-view') ? 'active' : '' }}"
                    id="itemOne-tab" data-step="1">{{ __('Informations de base') }}</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link navigation-btn {{ request('step') == 2 ? 'active' : '' }}" id="itemTwo-tab"
                    data-step="2">{{ __('Plus d\'informations') }}</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link navigation-btn {{ request('step') == 3 ? 'active' : '' }}" id="itemThree-tab"
                    data-step="3">{{ __('Contenu du cours') }}</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link navigation-btn {{ request('step') == 4 ? 'active' : '' }}" id="itemFour-tab"
                    data-step="4">{{ __('Terminer') }}</button>
            </li>
        </ul>
    </div>
</div>
