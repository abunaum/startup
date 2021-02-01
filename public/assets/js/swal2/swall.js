// swall sukses
const swall = $('.swall').data('swall');
if (swall) {
    Swal.fire(
        'Mantap !',
        swall,
        'success'
    )
}

// swall error
const error = $('.error').data('error');
if (error) {
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: error
    })
}
$(".tmbl-hps").on('click', function(e) {
    var nama = $(this).data('nama');
    Swal.fire({
        title: 'Anda yakin?',
        text: 'Mau menghapus ' + nama + ' ?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            this.form.submit();
        }
    })
})
$(".tmbl-acc").on('click', function(e) {
    var nama = $(this).data('nama');
    Swal.fire({
        title: 'Anda yakin?',
        text: 'Mau ACC pengajuan @' + nama + ' ?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ACC',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            this.form.submit();
        }
    })
})

$(".tmbl-tolak").on('click', function(e) {
    var nama = $(this).data('nama');
    Swal.fire({
        title: 'Anda yakin?',
        text: 'Mau tolak pengajuan @' + nama + ' ?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Tolak',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            this.form.submit();
        }
    })
})