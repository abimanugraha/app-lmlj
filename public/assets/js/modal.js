$("#modal-5").fireModal({
    title: 'Edit Komponen',
    body: $("#modal-komponen"),
    footerClass: 'bg-whitesmoke',
    autoFocus: false,
    onFormSubmit: function(modal, e, form) {
        // Form Data
        let data = $(e.target).serializeArray();
        $.ajax({
            url: window.location.origin + `/app-lmlj/ajax/editkomponen` + `/` + data[1].value + `/` + data[0].value,
            success: function(res) {
                // DO AJAX HERE
                let fake_ajax = setTimeout(function() {
                    form.stopProgress();
                    modal.find('.modal-body').prepend(
                        '<div id="success-alert" class="alert alert-success"><button class="close" data-dismiss="alert"><span>×</span></button>Komponen berhasil diubah.</div>'
                    )
                    window.setTimeout(function() {
                        $("#success-alert").alert('close');
                    }, 1500);

                    clearInterval(fake_ajax);
                    $('#nama-komponen').text(res.nama);
                    $('#nomor-komponen').text(res.nomor);
                }, 1000);
            }
        });
        e.preventDefault();
    },
    shown: function(modal, form) {
        // console.log(form)
    },
    buttons: [{
        text: 'Simpan',
        submit: true,
        class: 'btn btn-primary btn-shadow',
        handler: function(modal) {}
    }]
});
if ($('#listkotakmasuk').children().length > 0) {
    $('#beep').addClass('beep');
}


$("#modal-6").fireModal({
    title: 'Edit Produk',
    body: $("#modal-produk"),
    footerClass: 'bg-whitesmoke',
    autoFocus: false,
    onFormSubmit: function(modal, e, form) {
        // Form Data
        let data = $(e.target).serializeArray();
        // console.log(data);
        $.ajax({
            url: window.location.origin + `/app-lmlj/ajax/editproduk/` + data[1].value + `/` + data[0].value,
            success: function(res) {
                // DO AJAX HERE
                let fake_ajax = setTimeout(function() {
                    form.stopProgress();
                    modal.find('.modal-body').prepend(
                        '<div id="success-alert" class="alert alert-success"><button class="close" data-dismiss="alert"><span>×</span></button>Komponen berhasil diubah.</div>'
                    )
                    window.setTimeout(function() {
                        $("#success-alert").alert('close');
                    }, 1500);

                    clearInterval(fake_ajax);
                    $('#nama-produk').text(res.nama);
                    $('#nomor-produk').text(res.nomor);
                }, 1000);
            }
        });
        e.preventDefault();
    },
    shown: function(modal, form) {
        // console.log(form)
    },
    buttons: [{
        text: 'Simpan',
        submit: true,
        class: 'btn btn-primary btn-shadow',
        handler: function(modal) {}
    }]
});

$('#modal-6').click(function(){
    //Some code
    $.ajax({
        url: window.location.origin+`/app-lmlj/ajax/getproduk`,
        contentType: 'application/json',
        dataType: 'json',
        success: function(res) {
            $.each(res, function(index, data) {
                $("#modal-input-produk").append(
                    `<option value="${data.id}">${data.nama} - ${data.nomor}</option>`)
            });
        }
    });
});




