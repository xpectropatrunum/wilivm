<!-- Brand Logo -->
<a href="{{ route('admin.dashboard') }}" class="brand-link">
    <img src="{{ asset(config('admin.logo_img')) }}"
         alt="{{ trans(config('admin.logo_img_alt')) }}"
         class="brand-image img-circle elevation-3"
         style="opacity: .8">
    <span class="brand-text font-weight-light">{{ trans(config('admin.logo_title')) }}</span>
</a>
