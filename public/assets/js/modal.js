if ($('#listkotakmasuk').children().length > 0) {
    $('#beep').addClass('beep');
}

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

$('#modal-5').click(function(){
    //Some code
    $('#modal-input-nama-komponen').select2({
        dropdownParent: $('#modal-parent-komponen')
    });
});

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
                $("#modal-input-produk-masalah").append(
                    `<option value="${data.id}">${data.nama} - ${data.nomor}</option>`)
            });
        }
    });
    $('#modal-input-produk-masalah').select2({
        dropdownParent: $('#modal-parent-produk')
    });
});




$("#modal-7").fireModal({
    title: 'Edit Tembusan',
    body: $("#modal-tembusan"),
    footerClass: 'bg-whitesmoke',
    autoFocus: false,
    onFormSubmit: function(modal, e, form) {
        // Form Data
        let data = $(e.target).serializeArray();
        var tembusan = ['0'];
        var lmlj_id = data[0].value;
        if(data.length > 1){
            tembusan.pop();
            for (let i = 1; i < data.length; i++) {
                tembusan.push(data[i].value);
            }
        }
        // console.log(tembusan);
        $.ajax({
            url: window.location.origin + `/app-lmlj/ajax/edittembusan/` + lmlj_id+ `/` + tembusan.toString(),
            success: function(res) {
                // DO AJAX HERE
                // console.log(res);
                let fake_ajax = setTimeout(function() {
                    form.stopProgress();
                    modal.find('.modal-body').prepend(
                        '<div id="success-alert" class="alert alert-success"><button class="close" data-dismiss="alert"><span>×</span></button>List tembusan berhasil diubah.</div>'
                    )
                    window.setTimeout(function() {
                        $("#success-alert").alert('close');
                    }, 1500);

                    $(".list-cc").remove();
                    if(res[0] !=0){
                        $.each(res, function(index, data) {                        
                            $('#label-list-cc').after(`<div class="row mb-1">
                                <div class="col">
                                    <p class="text-dark list-cc"><i class="fas fa-caret-right"></i>
                                        ${data}
                                    </p>
                                </div>
                            </div>`)
                        });
                    }


                    clearInterval(fake_ajax);                
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

$('#modal-7').click(function(){
    //Some code
    var masalah_id = $('#modal-masalah-id').val();
    $.ajax({
        url: window.location.origin+`/app-lmlj/ajax/getunittembusan/` + masalah_id,
        contentType: 'application/json',
        dataType: 'json',
        success: function(res) {        
            $.each(res, function(index, data) {
                $("#modal-input-tembusan").append(
                    `<option id="modal-option-tembusan-${data.id}" value="${data.id}">${data.unit}</option>`)
            });
            var array;
            if($('#list-tembusan').length != 0){
                array = JSON.parse($('#list-tembusan').val());
                array.forEach(item => {
                    $(`#modal-option-tembusan-${item.unit_id}`).attr("selected", "selected");
                });
            }
            
        }
    });
});








