@if (session('success'))
    <div class="alert alert-success">

        <p>{{ session('success') }}</p>

    </div>
@endif
{{-- @if (session('success'))
    <script>
        new Noty({
            type: "success",
            layout: "topRight",
            text: "{{ session('success') }}",
            timeout: 2000,
            killer: true,
        }).show()
    </script>
@endif --}}

{{--
@if (session('success'))
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: 'success',
            title: '{{ session('success') }}'
        })
    </script>
@endif

@if (session('error'))
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: 'error',
            title: '{{ session('error') }}'
        })
    </script>
@endif --}}
