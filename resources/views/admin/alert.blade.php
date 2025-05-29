{{-- Bắt lỗi Validation --}}
{{-- @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif --}}
{{-- Bắt lỗi ->with và lỗi Session::flash --}}
@if (Session::has('error'))
    <div class="alert alert-danger">
        {{ Session::get('error') }}
    </div>
@endif


@if (Session::has('success'))
    <div class="alert alert-success">
        {{ Session::get('success') }}
    </div>
@endif

{{-- 
@if (Session::has('success') || Session::has('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (Session::has('success'))
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: "{{ Session::get('success') }}",
                    timer: 1500,
                    showConfirmButton: false,
                });
            @endif

            @if (Session::has('error'))
                Swal.fire({
                    icon: "error",
                    title: "Fail",
                    text: "{{ Session::get('error') }}",
                    timer: 1500,
                    showConfirmButton: false,
                });
            @endif
        });
    </script>
@endif --}}
