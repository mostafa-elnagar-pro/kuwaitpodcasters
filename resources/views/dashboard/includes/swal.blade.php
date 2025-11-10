<script>
    function sweetAlert(type, message, time = 3000, dir = 'rtl') {
        toastr[type](`${message}`, `${type}`, {
            timeOut: time,
            rtl: dir
        });
    }

    toastr.options = {
        "positionClass": "toast-top-left"
    };
</script>
@if (session('success'))
    <script>
        toastr.success(@json(session('success')))
    </script>
@elseif(session('error'))
    <script>
        toastr.error(@json(session('error')))
    </script>
    {{-- @elseif(session('warning'))
    <script>
        toastr.warning(@json(session('warning')))
    </script>
@elseif(session('info'))
    <script>
        toastr.info(@json(session('info')))
    </script> --}}
@endif

@if (session('noPackageErr'))
    <script>
        Swal.fire({
            title: "{{ __('app.error') }}",
            text: @json(session('noPackageErr')),
            icon: 'warning',
        }).then(() => {
            location.reload()
        })
    </script>
@endif

@if ($errors->any())
    @foreach ($errors->all() as $error)
        <script>
            toastr.error(@json($error))
        </script>
    @endforeach
@endif
