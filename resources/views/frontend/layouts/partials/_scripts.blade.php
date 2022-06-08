@stack('scripts')
<!-- Scripts -->
<!-- JS library -->
<script src="{{ asset('assets/modules/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('assets/modules/izitoast/dist/js/iziToast.min.js') }}"></script>

<!-- Scripts -->
@yield('scripts')
@stack('scripts')
<script type="text/javascript">
    "use strict";
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    @if(session('success'))
    iziToast.success({
        title: 'Success',
        message: '{{ session('success') }}',
        position: 'topRight'
    });
    @endif

    @if(session('error'))
    iziToast.error({
        title: 'Error',
        message: '{{ session('error') }}',
        position: 'topRight'
    });
    @endif
</script>
