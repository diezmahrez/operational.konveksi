<script src="{{ url('/js/index.js')}}"></script>

<script>
    function confirmation() {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "Deleted!",
                    text: "Your file has been deleted.",
                    icon: "success"
                });
            }
        });
    }
</script>

@if(session('primary'))
<script>
    Swal.fire({
        icon: "success",
        title: "Berhasil Menyimpan Data",
        showConfirmButton: false,
        timer: 1500
    });
</script>
@endif
@if(session('danger'))
<script>
    Swal.fire({
        icon: "error",
        title: "{{ session('danger') }}",
        showConfirmButton: false,
        timer: 1500
    });
</script>
@endif
@if(session('success'))
<script>
    Swal.fire({
        icon: "success",
        title: "{{ session('success') }}",
        showConfirmButton: false,
        timer: 1500
    });
</script>
@endif