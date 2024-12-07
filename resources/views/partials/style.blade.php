{{-- Default --}}
<link href="{{ asset('vendors/dropzone/dropzone.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/prism/prism-okaidia.css') }}" rel="stylesheet">
{{-- <link rel="preconnect" href="https://fonts.googleapis.com/">
<link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin=""> --}}
<link href="{{ asset('assets/css/font/Nunito+Sans.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/simplebar/simplebar.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/css/unicons.iconscout/line.css') }}">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/prism/prism-okaidia.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/theme.min.css') }}" type="text/css" rel="stylesheet" id="style-default">
<link href="assets/css/theme.min.css') }}" type="text/css" rel="stylesheet" id="style-default">
<link href="{{ asset('assets/css/user-rtl.min.css') }}" type="text/css" rel="stylesheet" id="user-style-rtl">
<link href="{{ asset('assets/css/user.min.css') }}" type="text/css" rel="stylesheet" id="user-style-default">


<style>
    .validation-error {
        width: 100%;
        margin-top: .25rem;
        font-size: 75%;
        color: var(--phoenix-form-invalid-color);
    }

    .color-success {
        color: var(--phoenix-success-dark) !important;
    }
</style>

{{-- push js on header --}}
@stack('headScripts')
{{-- head js --}}
<script>
    var phoenixIsRTL = window.config.config.phoenixIsRTL;
    if (phoenixIsRTL) {
        var linkDefault = document.getElementById('style-default');
        var userLinkDefault = document.getElementById('user-style-default');
        linkDefault.setAttribute('disabled', true);
        userLinkDefault.setAttribute('disabled', true);
        document.querySelector('html').setAttribute('dir', 'rtl');
    } else {
        var linkRTL = document.getElementById('style-rtl');
        var userLinkRTL = document.getElementById('user-style-rtl');
        linkRTL.setAttribute('disabled', true);
        userLinkRTL.setAttribute('disabled', true);
    }
</script>


<link href="{{ asset('vendors/leaflet/leaflet.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/leaflet.markercluster/MarkerCluster.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/leaflet.markercluster/MarkerCluster.Default.css') }}" rel="stylesheet">


{{-- development ................................................. --}}
{{-- toastr --}}
<link rel="stylesheet" href="{{ asset('assets/dev/css/toastr.css') }}">
{{-- push --}}
</script>


{{-- dropify --}}
<link rel="stylesheet" href="{{asset('assets/custom/css/dropify.min.css')}}">

@stack('styles')
