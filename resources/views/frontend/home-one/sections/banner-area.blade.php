<section class="banner-area banner-bg tg-motion-effects" data-background="{{ manageAssetImage('uploads/homepages/main/hero_bg.png', $hero->hero_background) }}">
    <div class="container">
        <div class="row justify-content-between align-items-start">
            <div class="col-xl-5 col-lg-6">
                <div class="banner__content">
                    <h3 class="title tg-svg" data-aos="fade-right" data-aos-delay="400">
                        {!! clean(processText($hero->translation?->title)) !!}
                    </h3>
                    <p data-aos="fade-right" data-aos-delay="600">{!! clean(processText($hero->translation?->sub_title)) !!}</p>
                    <div class="banner__btn-two aos-init aos-animate mt-4" data-aos="fade-right" data-aos-delay="600">
                        @if ($hero->translation?->action_button_text != null)
                        <a href="{{ $hero->action_button_url }}" class="btn arrow-btn">{{ $hero->translation?->action_button_text }} <img src="{{ asset('frontend/img/icons/right_arrow.svg') }}" alt="img" class="injectable"></a>
                        @endif
                        @if ($hero->translation?->video_button_text != null)
                        <a href="{{ $hero->video_button_url }}" class="play-btn popup-video"><i class="fas fa-play"></i> {!! clean(processText($hero->translation?->video_button_text)) !!}</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="banner__images">
                    <img src="{{ manageAssetImage('uploads/homepages/main/banner_img.png', $hero->banner_image) }}" alt="img" class="main-img">
                    <div class="shape big-shape" data-aos="fade-up-right" data-aos-delay="600">
                        <img src="{{  manageAssetImage('uploads/homepages/main/banner_bg.png', $hero->banner_background) }}" alt="shape" class="tg-motion-effects1">
                    </div>
                    <img src="{{ asset('frontend/img/banner/bg_dots.svg') }}" alt="shape"
                        class="shape bg-dots rotateme">
                    <img src="{{ asset('frontend/img/banner/banner_shape02.png') }}" alt="shape"
                        class="shape small-shape tg-motion-effects3">

                    <div class="about__enrolled students aos-init aos-animate" data-aos="fade-right"
                        data-aos-delay="200">
                        <p class="title"><span>{{ $hero->translation?->total_student }}</span>
                            {{ __('Enrolled Students') }}</p>
                        <img src="{{ asset($hero->enroll_students_image) }}" alt="img">
                    </div>
                    <div class="banner__student instructor aos-init aos-animate" data-aos="fade-left"
                        data-aos-delay="200">
                        <div class="icon">
                            <img src="{{ asset('frontend/img/banner/h2_banner_icon.svg') }}" alt="img"
                                class="injectable">
                        </div>
                        <div class="content">
                            <span>{{ __('Total Instructors') }}</span>
                            <h4 class="title">{{ $hero->translation?->total_instructor }}</h4>
                        </div>
                    </div>
                    <div class="banner__author">
                        <img src="{{ asset('frontend/img/banner/banner_shape02.svg') }}" alt="shape"
                            class="arrow-shape tg-motion-effects3">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <img src="{{ asset('frontend/img/banner/banner_shape01.svg') }}" alt="shape" class="line-shape"
        data-aos="fade-right" data-aos-delay="1600">
</section>
