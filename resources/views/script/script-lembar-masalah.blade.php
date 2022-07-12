<script>
    function showkomponen() {
    // get id produk
    let produk_id = $("#input-nama-produk").val();
    // get nomor produk and set nomor porduk on view
    $("#input-nomor-produk").children().remove();
    $.ajax({
        url: `{{ url('ajax/produkbyid') }}` + `/` + produk_id,
        success: function(res) {
            $("#input-nomor-produk").append(`<option value="${res.id}">${res.nomor}</option>`)
        }
    });

    // onchange produk set list komponen on view
    $("#input-nama-komponen").prop('disabled', true);
    $("#input-nama-komponen").children().remove();
    $.ajax({
        url: `{{ url('ajax/komponenbyprodukid') }}` + `/` + produk_id,
        success: function(res) {
            $("#input-nama-komponen").prop('disabled', false);
            $("#input-nama-komponen").append(`<option value="">Pilih Komponen</option>`)
            $.each(res, function(index, data) {
                $("#input-nama-komponen").append(
                    `<option value="${data.id}">${data.nama}</option>`)
            });
        }
    });
}

function shownumberkomponen() {
    // get id komponen
    let komponen_id = $("#input-nama-komponen").val();
    // get nomor komponen and set nomor porduk on view
    $("#input-nomor-komponen").children().remove();
    $.ajax({
        url: `{{ url('ajax/komponenbyid') }}` + `/` + komponen_id,
        success: function(res) {
            $("#input-nomor-komponen").append(`<option value="${res.id}">${res.nomor}</option>`)
        }
    });
}


function getunittembusan() {

    selected = $('#input-unit-tujuan option:selected').map(function() {
        return this.value;
    }).get();
    // console.log(selected[0]);
    if (selected.length ==0) {
        $("#form-masalah").children().remove();            
    }else{
        $("#form-masalah").children().remove();
        selected.forEach(item => {
            $('#form-masalah').append(`
                            <div class="card-item">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6 style="min-height: 100%" class="text-primary">Unit Tujuan</h6>
                                            <div class="form-row mt-3">
                                                <div class="form-group col-md-6">
                                                    <label for="input-nama-komponen">Nama Komponen</label>
                                                    <select
                                                        class="form-control select2 @error('komponen_id') is-invalid @enderror"
                                                        name="komponen_id[]" id="input-nama-komponen" disabled
                                                        onchange="shownumberkomponen()">
                                                        <option value="" selected>Pilih Komponen</option>
                                                    </select>
                                                    @error('komponen_id')
                                                        <div class="invalid-feedback mt-2">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="input-nomor-komponen">Nomor Komponen</label>
                                                    <select class="form-control select2" name="" disabled
                                                        id="input-nomor-komponen">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-12">
                                                    <label for="input-no-lmlj">Uraian Singkat </label>
                                                    <input type="text"
                                                        class="form-control @error('masalah') is-invalid @enderror"
                                                        name="masalah[]" placeholder="Uraian singkat masalah">
                                                    @error('masalah')
                                                        <div class="invalid-feedback mt-2">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group d-flex flex-column">
                                                <label for="input-detail-masalah">Detail Masalah</label>
                                                <div class="d-inline-flex mb-2">
                                                    <input name="detail[]" type="text" class="form-control"
                                                        id="input-detail-masalah" placeholder="Masukan detail masalah">
                                                    <a class="btn btn-icon btn-primary ml-1 text-white"
                                                        id="btn-tambah-detail-1" onclick="tampildetail(1)">
                                                        <i class="fas fa-plus mt-2"></i>
                                                    </a>
                                                </div>
                                                <div style="display: none;" class="mb-2" id="div-detail-2">
                                                    <input disabled name="detail[]" type="text" class="form-control"
                                                        id="input-detail-masalah-2" placeholder="Masukan detail masalah">
                                                    <a class="btn btn-icon btn-danger ml-1 text-white"
                                                        id="btn-tambah-detail-2" onclick="tampildetail(2)">
                                                        <i class="fas fa-minus mt-2"></i>
                                                    </a>
                                                </div>
                                                <div style="display: none;" class="mb-2" id="div-detail-3">
                                                    <input disabled name="detail[]" type="text" class="form-control"
                                                        id="input-detail-masalah-3" placeholder="Masukan detail masalah">
                                                    <a class="btn btn-icon btn-danger ml-1 text-white"
                                                        id="btn-tambah-detail-3" onclick="tampildetail(3)">
                                                        <i class="fas fa-minus mt-2"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input-nilai-tambah">Nilai Tambah</label>
                                                <input type="text" class="form-control" id="input-nilai-tambah"
                                                    name="nilai_tambah" placeholder="Masukan nilai tambah">
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label for="input-urgensi">Urgensi</label><br>
                                                    <div class="selectgroup">
                                                        <label class="selectgroup-item" id="input-urgensi">
                                                            <input type="radio" name="urgensi" value="1"
                                                                class="selectgroup-input" checked="">
                                                            <span class="selectgroup-button">3</span>
                                                        </label>
                                                        <label class="selectgroup-item">
                                                            <input type="radio" name="urgensi" value="2"
                                                                class="selectgroup-input">
                                                            <span class="selectgroup-button">7</span>
                                                        </label>
                                                        <label class="selectgroup-item">
                                                            <input type="radio" name="urgensi" value="3"
                                                                class="selectgroup-input">
                                                            <span class="selectgroup-button">14</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-8">
                                                    <label for="input-foto-video">Foto/Video</label>
                                                    <div class="custom-file">
                                                        <input type="file"
                                                            class="custom-file-input @error('media.*') is-invalid @enderror"
                                                            name="media[]" id="customFile" multiple>
                                                        <label class="custom-file-label" for="customFile">Choose
                                                            file</label>
                                                        @error('media.*')
                                                            <div class="invalid-feedback mt-2">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            `)
        });

    }

    // console.log(selected.length);
    // selected.forEach(item => {
    //     console.log(item);
    // });
    // let unit_user = {{ $user->unit->id }};
    // $("#input-tembusan").children().remove();
    // $("#input-tembusan").prop('disabled', false);
    // $.ajax({
    //     url: `{{ url('ajax/unittembusan') }}` + `/` + unit_user + `/` + unit_id,
    //     success: function(res) {
    //         $.each(res, function(index, data) {
    //             $("#input-tembusan").append(
    //                 `<option value="${data.id}">${data.unit}</option>`)
    //         });
    //     }
    // });
}
</script>