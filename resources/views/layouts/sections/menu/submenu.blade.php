@foreach ($menu as $submenu)
@php
$activeClass = null;
$currentRouteName = Route::currentRouteName();
// Pastikan slug adalah string sebelum dibandingkan
if (isset($submenu->slug) && is_string($submenu->slug) && $currentRouteName === $submenu->slug) {
$activeClass = 'active';
}
@endphp

<li class="menu-item {{$activeClass}}">
    <a href="{{ isset($submenu->url) ? (isset($submenu->target) && !empty($submenu->target) ? $submenu->url : url($submenu->url)) : 'javascript:void(0);' }}" class="{{ isset($submenu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}" @if (isset($submenu->target) and !empty($submenu->target)) target="_blank" @endif>
        @isset($submenu->icon)
        <i class="menu-icon {{ is_string($submenu->icon) ? $submenu->icon : '' }}"></i>
        @endisset
        <div>{{ isset($submenu->name) ? (is_string($submenu->name) ? __($submenu->name) : '') : '' }}</div>
        @isset($submenu->badge)
        <div class="badge {{ (isset($submenu->badgeClass) && is_string($submenu->badgeClass)) ? $submenu->badgeClass : 'bg-label-primary' }} rounded-pill ms-auto">{{ is_string($submenu->badge) ? $submenu->badge : '' }}</div>
        @endisset
    </a>

    @isset($submenu->submenu)
    @include('layouts.sections.menu.submenu',['menu' => $submenu->submenu])
    @endisset
</li>
@endforeach