$("#modal-5").fireModal({
    title: 'Edit Komponen',
    body: $("#modal-login-part"),
    footerClass: 'bg-whitesmoke',
    autoFocus: false,
    onFormSubmit: function(modal, e, form) {
        // Form Data
        let data = $(e.target).serializeArray();
        // console.log(data);
        $.ajax({
            url: `{{ url('ajax/editkomponen') }}` + `/` + data[3].value + `/` + data[1].value,
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
                    $('#nama-komponen').text(data[2].value);
                    $('#nomor-komponen').text(data[4].value);
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
            url: `{{ url('ajax/editproduk') }}` + `/` + data[3].value + `/` + data[1].value,
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
                    $('#nama-komponen').text(data[2].value);
                    $('#nomor-komponen').text(data[4].value);
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




