@props(['name' => 'password'])

<div class="input-group flex-nowrap">
    <input type="password" id="{{ $name }}" class="form-control" name="{{ $name }}" placeholder="········" />
    <span class="input-group-text" id="togglePassword" style="cursor:pointer;">
        <i class="bi bi-eye-slash"></i>
    </span>
</div>

@push('js')
    <script>
        $(document).ready(function() {
            let showPassword = false;

            $('#togglePassword').on('click', function() {
                showPassword = !showPassword;
                $('#password').attr('type', showPassword ? 'text' : 'password');
                $(this).find('i').toggleClass('bi-eye bi-eye-slash');
            });
        });
    </script>
@endpush
