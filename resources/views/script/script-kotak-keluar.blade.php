<script>
    function deletelmlj(id) {
        swal({
                title: 'Anda yakin?',
                text: 'LMLJ akan dihapus, unit tujuan tidak akan bisa mengakses LMLJ ini!',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: `{{ url('ajax/delete-lmlj') }}` + `/` + id,
                        success: function(res) {
                            swal('LMLJ nomor ' + res.nolmlj + ' berhasil dihapus!', {
                                icon: 'success',
                            });
                            $('#non-aktif-' + id).remove();
                            $('#aksi-' + id).append(`<a id="aktif-${id}" href="#"
                                                                    onclick="turnonlmlj(${id})"
                                                                    class="btn btn-success">Aktifkan
                                                                </a>`);
                            $('#badge-aktif-' + id).remove();
                            $('#status-' + id).append(`<div id="badge-non-aktif-${id}"
                                                                    class="badge badge-danger text-white">
                                                                    Non-Aktif
                                                                </div>`)
                        }
                    });
                } else {
                    // swal('Your imaginary file is safe!');
                }
            });
    }

    function turnonlmlj(id) {
        swal({
                title: 'Anda yakin?',
                text: 'LMLJ akan diaktifkan, unit tujuan akan bisa mengakses LMLJ ini!',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: `{{ url('ajax/turnon-lmlj') }}` + `/` + id,
                        success: function(res) {
                            swal('LMLJ nomor ' + res.nolmlj + ' berhasil diaktifkan!', {
                                icon: 'success',
                            });
                            $('#aktif-' + id).remove();
                            $('#aksi-' + id).append(`<a id="non-aktif-${id}" href="#"
                                                                    onclick="deletelmlj(${id})"
                                                                    class="btn btn-danger">Delete
                                                                </a>`);
                            $('#badge-non-aktif-' + id).remove();
                            $('#status-' + id).append(`<div id="badge-aktif-${id}"
                                                                    class="badge badge-success text-white">
                                                                    Active
                                                                </div>`)
                        }
                    });
                } else {
                    // swal('Your imaginary file is safe!');
                }
            });
    }
    
</script>