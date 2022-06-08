<script src="{{ asset('assets/modules/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('assets/modules/popper.js/dist/popper.min.js') }}"></script>
<script src="{{ asset('assets/modules/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/modules/jquery.nicescroll/dist/jquery.nicescroll.min.js') }}"></script>
<script src="{{ asset('assets/modules/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/stisla.js') }}"></script>

<script src="{{ asset('assets/modules/izitoast/dist/js/iziToast.min.js') }}"></script>
@yield('scripts')

<script src="{{ asset('assets/js/scripts.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>
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
    var currentDate = function () {
        let x = new Date();
        let date = x.toDateString() + ', ' + x.toLocaleTimeString();
        return date;
    }
    $('.currentDate').text(currentDate());
</script>

@livewireScripts
@yield('livewire-scripts')
