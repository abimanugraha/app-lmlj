<script>

function test() { 
    
}

function fillfromcomplaint(){
    let complaint = JSON.parse($("#input-complaint").val());
    selected = $('#input-unit-tujuan option:selected').map(function() {
        return {id:this.value, unit:this.text};
    }).get();

    if(complaint ==0){
        selected.forEach(item => {
            $(`#input-masalah-${item.id}`).val('Masukan urain singkat masalah');    
        }); 
        
    }else{
        var no= no_detail - selected.length;
        selected.forEach(item => {
            kurangdetail(item.id, no);
            no++;
        });
        var no=no_detail;
        selected.forEach(item => {
            $('#nocom').val(complaint.nocom);
            $(`#input-masalah-${item.id}`).val('Masalah produk ' + complaint.namaproduk + ' (SC' +complaint.nocom+')');
            tambahdetail(item.id);
            $(`#input-detail-masalah-${item.id}-1`).val(complaint.deskripsi);
            $(`#input-detail-masalah-${item.id}-${no}`).val('Berdasarkan surat complaint NO:'+ complaint.nocom);
            var url = 'http://28.11.5.6/support-user/monitoring-complaint/images/foto/WhatsApp%20Image%202022-08-03%20at%2011.58.00%20AM.jpeg';
            
            no++;
        }); 
    }
}

function validasiEkstensi(id){
    var inputFile = document.getElementById(`customFile-${id}`);
    var pathFile = inputFile.value;
    var ekstensiOk = /(\.jpg|\.jpeg|\.png|\.gif|\.pdf)$/i;
    if(!ekstensiOk.exec(pathFile)){
        inputFile.value = '';
        $(`#customFile-${id}`).attr('class','custom-file-input is-invalid');
        $(`#label-${id}`).html('Choose File');
        return false;
    }else{
        var numFiles = $(`#customFile-${id}`)[0].files.length;
        $(`#customFile-${id}`).attr('class','custom-file-input');
        $(`#label-${id}`).html(numFiles+' file terpilih');
    }
}

function showkomponen() {
    // get id produk
    let produk_id = $("#input-nama-produk").val();
    // get nomor produk and set nomor porduk on view
    if(produk_id>0){
        $("#input-nomor-produk").children().remove();    
        $.ajax({
            url: `{{ url('ajax/produkbyid') }}` + `/` + produk_id,
            success: function(res) {
                $("#input-nomor-produk").append(`<option value="${res.id}">${res.nomor}</option>`)
            }
        });
    }

    // get data unit
    selected = $('#input-unit-tujuan option:selected').map(function() {
        return {id:this.value, unit:this.text};
    }).get();

    // onchange produk set list komponen on view
    selected.forEach(item => {
        $(`#input-nama-komponen-${item.id}`).prop('disabled', true);
        $(`#input-nama-komponen-${item.id}`).children().remove();                
        $(`#input-nama-komponen-${item.id}`).select2();                
    });
    $.ajax({
        url: `{{ url('ajax/komponenbyprodukid') }}` + `/` + produk_id,
        success: function(res) { 
            selected.forEach(item => {
                $(`#input-nama-komponen-${item.id}`).prop('disabled', false);
                $(`#input-nama-komponen-${item.id}`).append(`<option value="">Pilih Komponen</option>`)
                $.each(res, function(index, data) {
                    if(data.status==1){
                        $(`#input-nama-komponen-${item.id}`).append(
                            `<option value="${data.id}">${data.nama} - ${data.nomor}</option>`)                        
                    }
                });                
            });           
        }
    });
}

function shownumberkomponen(id) {
    // get id komponen
    let komponen_id = $(`#input-nama-komponen-${id}`).val();
    // get nomor komponen and set nomor porduk on view
    $(`#input-nomor-komponen-${id}`).children().remove();
    $.ajax({
        url: `{{ url('ajax/komponenbyid') }}` + `/` + komponen_id,
        success: function(res) {
            $(`#input-nomor-komponen-${id}`).append(`<option value="${res.id}">${res.nomor}</option>`)
        }
    });
}

var no_detail = 2;
function tambahdetail(id) {
    $(`#box-detail-masalah-${id}`).append(`
    <div class="d-inline-flex  mb-2" id="div-detail-${id}-${no_detail}">
        <input name="detail[${id}][]" type="text" class="form-control"
            id="input-detail-masalah-${id}-${no_detail}" placeholder="Masukan detail masalah">
        <a class="btn btn-icon btn-danger ml-1 text-white"
            id="btn-tambah-detail-#" onclick="kurangdetail(${id}, ${no_detail})">
            <i class="fas fa-minus mt-2"></i>
        </a>
    </div>`)
    no_detail++;
}

function kurangdetail(id, no){
    $(`#div-detail-${id}-${no}`).remove()
}


function getunittembusan() {
    var unit_id = [];
    selected = $('#input-unit-tujuan option:selected').map(function() {
        return {id:this.value, unit:this.text};
    }).get();
    if (selected.length ==0) {
        $("#input-tembusan").prop('disabled', true);
        $("#input-complaint").prop('disabled', true);
        $("#input-nama-produk").prop('disabled', true);
        $("#form-masalah").children().remove();  
        $('#button-kirim-lmlj').children().remove();          
    }else{ 
        $("#form-masalah").children().remove();
        $("#button-kirim-lmlj").children().remove();
        if (selected.length==1) {
            $('#button-kirim-lmlj').append(`<div class="col-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group float-right mt-3">
                                            <button type="submit" class="btn btn-primary">Kirim</button>
                                        </div>
                                    </div>
                                </div>
                            </div>`)            
        }else{
            $('#button-kirim-lmlj').append(`<div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group float-right mt-3">
                                            <button type="submit" class="btn btn-primary">Kirim</button>
                                        </div>
                                    </div>
                                </div>
                            </div>`)  
        }
        selected.forEach(item => {
            unit_id.push(item.id);
            $('#form-masalah').append(`
                            <div class="card-item">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6 style="min-height: 100%" class="text-primary">Unit ${item.unit}</h6>
                                            <div class="form-row mt-3">
                                                <div class="form-group col-md-12">
                                                    <label for="input-nama-komponen-${item.id}">Komponen</label>
                                                    <select class="form-control select2"
                                                        name="komponen_id[${item.id}]" id="input-nama-komponen-${item.id}"
                                                        onchange="shownumberkomponen(${item.id})">
                                                        <option value="" selected>Pilih Komponen</option>
                                                    </select>
                                                </div>                                                
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-12">
                                                    <label for="input-no-lmlj">Uraian Singkat </label>
                                                    <input type="text"
                                                        class="form-control" id="input-masalah-${item.id}"
                                                        name="masalah[${item.id}]" placeholder="Uraian singkat masalah" required>
                                                </div>
                                            </div>
                                            <div class="form-group d-flex flex-column" id="box-detail-masalah-${item.id}">
                                                <label for="input-detail-masalah">Detail Masalah</label>
                                                <div class="d-inline-flex mb-2">
                                                    <input name="detail[${item.id}][]" type="text" class="form-control"
                                                        id="input-detail-masalah-${item.id}-1" placeholder="Masukan detail masalah">
                                                    <a class="btn btn-icon btn-primary ml-1 text-white"
                                                        id="btn-tambah-detail-${item.id}" onclick="tambahdetail(${item.id})">
                                                        <i class="fas fa-plus mt-2"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input-nilai-tambah">Nilai Tambah</label>
                                                <input type="text" class="form-control" id="input-nilai-tambah-${item.id}"
                                                    name="nilai_tambah[${item.id}]" placeholder="Masukan nilai tambah">
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label for="input-urgensi">Urgensi</label><br>
                                                    <div class="selectgroup">
                                                        <label class="selectgroup-item">
                                                            <input type="radio" name="urgensi[${item.id}]" value="1"
                                                                class="selectgroup-input" checked="">
                                                            <span class="selectgroup-button">3</span>
                                                        </label>
                                                        <label class="selectgroup-item">
                                                            <input type="radio" name="urgensi[${item.id}]" value="2"
                                                                class="selectgroup-input">
                                                            <span class="selectgroup-button">7</span>
                                                        </label>
                                                        <label class="selectgroup-item">
                                                            <input type="radio" name="urgensi[${item.id}]" value="3"
                                                                class="selectgroup-input">
                                                            <span class="selectgroup-button">14</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-8">
                                                    <label for="input-foto-video">Foto/Video</label>
                                                    <div class="custom-file">
                                                        <input type="file"
                                                            class="custom-file-input"
                                                            name="media_${item.id}[]" id="customFile-${item.id}" multiple onchange="validasiEkstensi(${item.id})">
                                                        <label class="custom-file-label" id="label-${item.id}" for="customFile-${item.id}">Choose
                                                            file</label>
                                                        <div class="invalid-feedback mt-2">
                                                            File tidak dapat diupload!
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            `)
        });

        let unit_user = {{ $user->unit->id }};
        let data = {unit_id};
        $("#input-tembusan").children().remove();
        $("#input-tembusan").prop('disabled', false);
        $("#input-complaint").prop('disabled', false);
        $("#input-nama-produk").prop('disabled', false);
        $.ajax({
            url: `{{ url('ajax/unittembusan') }}` + `/` + unit_user,
            contentType: 'application/json',
            dataType: 'json',
            data: data,
            success: function(res) {
                $.each(res, function(index, data) {
                    $("#input-tembusan").append(
                        `<option value="${data.id}">${data.unit}</option>`)
                });
            }
        });
    }
    
}
</script>