<script>

    $(document).ready(function () {
        @if(request()->session()->has('info'))
        iziToast.info({
            title: 'Info!',
            message: "{{ request()->session()->get('info') }}",
            position: 'topRight'
        });
        @endif

        @if(request()->session()->has('success'))
            iziToast.success({
                title: 'Success!',
                message: "{{ request()->session()->get('success') }}",
                position: 'topRight'
            });
        @endif

        @if(request()->session()->has('warning'))
            iziToast.warning({
                title: 'Warning!',
                message: "{{ request()->session()->get('warning') }}",
                position: 'topRight'
            });
        @endif

        @if(request()->session()->has('error'))
            iziToast.error({
                title: 'Error!',
                message: "{{ request()->session()->get('error') }}",
                position: 'topRight'
            });
        @endif
    });

</script>