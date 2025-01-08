@if (Module::isEnabled('Language') && Route::has('admin.course.index'))
    @php
        $pendingCourseCount = \App\Models\Course::where('is_approved', 'pending')->count();
    @endphp
    <li
        class="nav-item dropdown {{ isRoute(['admin.courses.*', 'admin.course-category.*', 'admin.course-filter.*', 'admin.course-language.*', 'admin.course-level.*', 'admin.course-review.*', 'admin.course-delete-request.*', 'admin.course-sub-category.*'], 'active') }}">
        <a href="javascript:void()" class="nav-link has-dropdown"><i
                class="fas fa-graduation-cap"></i><span class="{{ $pendingCourseCount > 0 ? 'beep parent' : '' }}">{{ __('Gestion des cours') }}</span></a>

        <ul class="dropdown-menu">
            <li class="{{ isRoute('admin.courses.*', 'active') }}">
                <a class="nav-link" href="{{ route('admin.courses.index') }}">
                    {{ __('Cours') }}
                    @if ($pendingCourseCount > 0)
                    <small class="badge badge-danger ml-2">{{ $pendingCourseCount }}</small>
                    @endif
                </a>
            </li>
            <li class="{{ isRoute('admin.course-category.*', 'active') }} {{ isRoute('admin.course-sub-category.*', 'active') }}">
                <a class="nav-link" href="{{ route('admin.course-category.index') }}">
                    {{ __('Catégories') }}
                </a>
            </li>

            <li class="{{ isRoute('admin.course-language.*', 'active') }}">
                <a class="nav-link" href="{{ route('admin.course-language.index') }}">
                    {{ __('Langues') }}
                </a>
            </li>

            <li class="{{ isRoute('admin.course-level.*', 'active') }}">
                <a class="nav-link" href="{{ route('admin.course-level.index') }}">
                    {{ __('Niveaux') }}
                </a>
            </li>

            <li class="{{ isRoute('admin.course-review.*', 'active') }}">
                <a class="nav-link" href="{{ route('admin.course-review.index') }}">
                    {{ __('Avis sur les cours') }}
                </a>
            </li>
            <li class="{{ isRoute('admin.course-delete-request.*', 'active') }}">
                <a class="nav-link" href="{{ route('admin.course-delete-request.index') }}">
                    {{ __('Demandes de suppression') }}
                </a>
            </li>
        </ul>
    </li>
@endif
