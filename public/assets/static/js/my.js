// Sweet Alert
$(document).ready(function () {
    const berhasil = $(".flash-data").data("berhasil");
    const gagal = $(".flash-data").data("gagal");

    const Toast = Swal.mixin({
        toast: true,
        position: "top",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener("mouseenter", Swal.stopTimer);
            toast.addEventListener("mouseleave", Swal.resumeTimer);
        },
    });

    if (berhasil) {
        Toast.fire({
            icon: "success",
            title: berhasil,
        });
    }
    if (gagal) {
        Toast.fire({
            icon: "error",
            title: gagal,
        });
    }
});

// Alert Delete
$(document).on("click", ".btn-delete", function () {
    var form = $(this).closest("form");
    var url = form.attr("action");

    Swal.fire({
        title: "Apakah Anda yakin?",
        text: "Data ini akan dihapus secara permanen!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, hapus!",
    }).then((result) => {
        if (result.isConfirmed) {
            form.attr("action", url);
            form.submit();
        }
    });
});
