@extends('layouts.etudiant.app')

@section('title', 'Messages')

@push('styles')
        <!-- Theme CSS -->
        <link rel="stylesheet" href="{{ asset('css/theme.bundle.css') }}" id="stylesheetLTR">
        <link rel="stylesheet" href="{{ asset('css/theme.rtl.bundle.css') }}" id="stylesheetRTL">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700;800&display=swap">
        <link rel="stylesheet" media="print" onload="this.onload=null;this.removeAttribute('media');" href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700;800&display=swap">

<!-- Select2 pour les sélections multiples -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

<style>
    .container-fluid {
        height: calc(100vh - 60px);
    }
    .flex-md-grow-1 {
        flex-grow: 1;
    }
    .h-100 {
        height: 100%;
    }
    .min-vh-50 {
        min-height: 50vh;
    }
    .min-vh-md-25 {
        min-height: 25vh;
    }
    .typing:after {
        content: '';
        width: 6px;
        height: 6px;
        background-color: currentColor;
        display: inline-block;
        animation: typing 1.5s infinite;
        border-radius: 50%;
        margin-left: 0.25rem;
        margin-right: 0.25rem;
        vertical-align: middle;
    }
    @keyframes typing {
        0% { opacity: 0.3; }
        50% { opacity: 1; }
        100% { opacity: 0.3; }
    }
    .avatar-xs {
        width: 32px;
        height: 32px;
    }
    .avatar-sm {
        width: 40px;
        height: 40px;
    }
    .avatar-circle {
        border-radius: 50%;
    }
    .bg-light-green {
        background-color: rgba(42, 180, 111, 0.08);
    }
    .avatar-title {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        background-color: #6c757d;
        color: #fff;
        font-weight: 600;
        text-transform: uppercase;
    }
    .avatar-online:after {
        content: '';
        position: absolute;
        bottom: 0;
        right: 0;
        width: 25%;
        height: 25%;
        background-color: #2ab46f;
        border: 2px solid #fff;
        border-radius: 50%;
    }
    .w-40px {
        width: 40px;
    }
    .w-50px {
        width: 50px;
    }
    .h-40px {
        height: 40px;
    }
    .h-50px {
        height: 50px;
    }
    .scroll-shadow {
        background:
            /* Shadow Cover TOP */
            linear-gradient(white 30%, rgba(255, 255, 255, 0)) center top,
            /* Shadow Cover BOTTOM */
            linear-gradient(rgba(255, 255, 255, 0), white 70%) center bottom,
            /* Shadow TOP */
            radial-gradient(farthest-side at 50% 0, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0)) center top,
            /* Shadow BOTTOM */
            radial-gradient(farthest-side at 50% 100%, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0)) center bottom;
        background-repeat: no-repeat;
        background-size: 100% 40px, 100% 40px, 100% 14px, 100% 14px;
        background-attachment: local, local, scroll, scroll;
    }
    .avatar-group .avatar:not(:first-child) {
        margin-left: -0.5rem;
    }
    .avatar-group {
        display: flex;
    }
    .text-bg-primary-soft {
        background-color: rgba(13, 110, 253, 0.2);
        color: #0d6efd;
    }
    .text-bg-success-soft {
        background-color: rgba(25, 135, 84, 0.2);
        color: #198754;
    }
    .text-bg-danger-soft {
        background-color: rgba(220, 53, 69, 0.2);
        color: #dc3545;
    }
    .text-bg-info-soft {
        background-color: rgba(13, 202, 240, 0.2);
        color: #0dcaf0;
    }
    .text-bg-warning-soft {
        background-color: rgba(255, 193, 7, 0.2);
        color: #ffc107;
    }
    .text-bg-dark-soft {
        background-color: rgba(33, 37, 41, 0.2);
        color: #212529;
    }
</style>
@endpush

@section('content')
    @livewire('messaging.main-component')
@endsection

@push('scripts')
<!-- jQuery (nécessaire pour Select2) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Select2 pour les sélections multiples -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            // Theme switcher
            let themeSwitcher = document.getElementById('themeSwitcher');

            const getPreferredTheme = () => {
                if (localStorage.getItem('theme') != null) {
                    return localStorage.getItem('theme');
                }
                return document.documentElement.dataset.theme;
    };

            const setTheme = function(theme) {
                if (theme === 'auto' && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                    document.documentElement.dataset.theme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
                } else {
                    document.documentElement.dataset.theme = theme;
                }
                localStorage.setItem('theme', theme);
            };

            const showActiveTheme = theme => {
                const activeBtn = document.querySelector(`[data-theme-value="${theme}"]`);
                document.querySelectorAll('[data-theme-value]').forEach(element => {
                    element.classList.remove('active');
        });
                activeBtn && activeBtn.classList.add('active');

                // Set button if demo mode is enabled
                document.querySelectorAll('[data-theme-control="theme"]').forEach(element => {
                    if (element.value == theme) {
                        element.checked = true;
                    }
        });
    };

            function reloadPage() {
                window.location = window.location.pathname;
            }

            setTheme(getPreferredTheme());

            if (typeof themeSwitcher != 'undefined') {
                window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
                    if (localStorage.getItem('theme') != null) {
                        if (localStorage.getItem('theme') == 'auto') {
                            reloadPage();
                        }
                    }
        });

                window.addEventListener('load', () => {
                    showActiveTheme(getPreferredTheme());

                    document.querySelectorAll('[data-theme-value]').forEach(element => {
                        element.addEventListener('click', () => {
                            const theme = element.getAttribute('data-theme-value');
                            localStorage.setItem('theme', theme);
                            reloadPage();
                })
            })
        });
            }
        </script>

        <!-- Theme JS -->
<script src="{{ asset('js/theme.bundle.js') }}"></script>
@endpush
