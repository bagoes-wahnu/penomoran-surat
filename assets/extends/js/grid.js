document.title = "Data Nomor Surat - DISHUB Penomoran";
let typeDinas="";
let paramDinas='';

var dttbfilter="";
$(document).ready(function () {
  table();
  //$('#kt_quick_panel_toggle').addClass('active');
  sLoader('sector-penomoran','sector-penomoran',"Unit Kerja")
});

function table() {
  document.getElementById("table-wrapper").innerHTML = ewpTable({
    targetId: "dttb-grid",
    class: "table table-head-custom table-vertical-center",
    column: [
      { name: "Nomor", width: "10" },
      { name: "Tanggal Pembuatan", width: "30" },
      { name: "Tanggal Booking", width: "30" },
      { name: "Nomor Awal", width: "20" },
      { name: "Nomor Akhir", width: "20" },
      { name: "Bidang", width: "20" },
      { name: "Keterangan", width: "20" },
      { name: "", width: "20" },
    ],
  });

  geekDatatables({
    target: "#dttb-grid",
    url: baseUrl + "api/letter-number?"+dttbfilter,
    sorting: [1, "desc"],
    apiKey: "title",
    column: [
      { col: "id", mid: true, mod: {
        aTargets: [0],
        bSortable:false,
        render: function (data, type, full, draw) {
          var row = draw.row;
          var start = draw.settings._iDisplayStart;
          var length = draw.settings._iDisplayLength;

          var counter = start + 1 + row;
          return counter;
        },
      },
    },
      { col: "created_at", mid: true, mod: null },
      { col: "numbers_date", mid: true, mod: null },
      { col: "start_at", mid: true, mod: null },
      { col: "end_in", mid: true, mod: null },
      { col: "sector.name", mid: true, mod: {
        aTargets: [5],
        bSortable:true,
        mRender: function (data, type, full) {
            return full.sector!==null?noNull(full.sector.name):noNull(full.sector);
        },
      }, },
      { col: "id", mid: true, mod: {
        aTargets: [6],
        bSortable:false,
        mRender: function (data, type, full) {
            var html = `
            <p>`+noNull(full.letter_code)+`</p>
            <p class="text-success">`+noNull(full.regarding)+`</p>
            `

            return html;
        },
      }, },
      {
        col: "id",
        mid: true,
        mod: {
          aTargets: [-1],
          bSortable:false,
          mRender: function (data, type, full) {
              var htmlbtn = ``;
            if(full.locked_at==null){
                htmlbtn=`
            <button onclick="edit(` +
            data +
            `)" class="btn btn-sm btn-clean btn-icon" title="Edit">
            <i class="la la-pen"></i></button>

            <button onclick="locked(` +
              data +
              `)" class="btn btn-sm btn-clean btn-icon" title="Kunci">
            <i class="fas fa-unlock-alt"></i></button>
                `
            }else{
                htmlbtn=`
                <button onclick="detail(` +
                data +
                `)" class="btn btn-sm btn-clean btn-icon" title="Detail">
                <i class="fas fa-search-plus"></i></button>
                `
            }
            return htmlbtn;
          },
        },
      },
    ],
  });
}

function filtered(){
    var filters=$('#select-sector-penomoran').val()
    console.log(filters)
    var txt=""
    for(i in filters){
        txt+="sector_id[]="+filters[i]+"&"
    }
    dttbfilter=txt
    console.log(dttbfilter)
    table()
}

// Button Hapus di hide dulu - 11/01/21
//<button onclick="hapus(` +
//   data +
//   `)" class="btn btn-sm btn-clean btn-icon" title="Hapus">
// <i class="la la-trash"></i></button>

function create() {
    paramDinas=''
  var tgl= getToday()
  var stgl = tgl.split("/")
  $("#modal").modal();
  $("#modal #modal-title").text("Buat Nomor Baru");
  $("#modal #modal-title").attr("send", "add");
//   $("#modal #tgl").val(stgl[2]+"-"+stgl[1]+"-"+stgl[0])
    $("#modal .modal-dialog").removeClass("modal-xl")
  $("#modal-body").html(
    `<form id="form-input px-4" style="width: 100%;">
        <div id="warning-modal"></div>
        <input type="hidden" name="id" id="id">
          <div class="form-group">
              <label>Tanggal pembuatan</label>
              <input type="text" class="form-control" readonly="readonly" id="tgl" placeholder="Pilih Tanggal"/>
          </div>
          <div class="form-group">
            <label>Dibuat oleh (Otomatis)</label>
            <input type="hidden" name="created_by" id="created_by">
            <input class="form-control" type="text" placeholder="Cth: Administrator" name="created_by_name" id="created_by_name" value="Administrator" disabled>
        </div>
        <div class="form-group">
            <label for="awal">Nomor Terakhir</label>
            <input class="form-control" type="text" name="terakhir" id="terakhir" placeholder="nomor terakhir" disabled>
        </div>
        <div class="form-group">
            <label for="awal">Nomor awal</label>
            <input class="form-control" type="tel" pattern="\d{10}" class="masked" placeholder="XXXXXXXXXX" name="awal" id="awal" title="nomor awal">
        </div>
        <div class="form-group">
            <label for="akhir">Nomor akhir</label>
            <input class="form-control" type="tel" pattern="\d{10}" class="masked" placeholder="XXXXXXXXXX" name="akhir" id="akhir" title="nomor akhir">
        </div>
        <div class="form-group">
            <label>Kode Surat</label>
            <input class="form-control" type="text" placeholder="cth: KOE-001" name="kode_surat" id="kode_surat" title="kode_surat">
        </div>
        <div class="form-group">
            <label>Tipe Penggunaan</label><br/>
            <button type="button" id="TP2" class="btn btn-outline-primary" onclick="typeDinass('2')">Dinas</button>
            <button type="button" id="TP1" class="btn btn-outline-primary" onclick="typeDinass('1')">Unit Kerja</button>

        </div>
        <div class="form-group d-none" id="form-tp">
            <label>Unit Kerja</label>
            <select class="form-control select2" id="select-sector-penomoran-cr" name="param" style="width:100%"></select>
        </div>
        <div class="form-group">
            <label>Perihal</label>
            <input class="form-control" type="text" placeholder="Masukkan Perihal" name="perihal" id="perihal" title="perihal">
        </div>
      </form>`
  );
    new InputMask({
        masked: "#awal,#akhir"
    });
    $('#tgl').datepicker({
        rtl: KTUtil.isRTL(),
        todayHighlight: true,
        orientation: "bottom left",
        format: 'dd-mm-yyyy' ,
        startDate: new Date() ,
        autoclose:true
    }).on("change", function() {
        if($('#tgl').val()!==''){
            getLastNumber()
        }
      });

  $("#modal-footer").html(
    `
        <button type="button" class="btn btn-light-warning font-weight-bold px-5" data-dismiss="modal" style="border-radius:1.5rem;">Cancel</button>
        <button type="button" class="btn btn-warning font-weight-bold" onclick="simpan()" style="border-radius:1.5rem;">Simpan</button>
    `
  );

  sLoader('sector-penomoran-cr','sector-penomoran',"Unit Kerja")
}

function SlcBtn(id){
    $("#"+id).addClass("btn-primary")
    $("#"+id).removeClass("btn-outline-primary")
}

function notSlcBtn(id){
    $("#"+id).addClass("btn-outline-primary")
    $("#"+id).removeClass("btn-primary")
}

function typeDinass(param){
    typeDinas=param;
    switch(param) {
        case "1":
            $("#form-tp").removeClass("d-none")
            SlcBtn("TP1")
            notSlcBtn("TP2")
            paramDinas=2
            break;
        case "2":
            $("#form-tp").addClass("d-none")
            SlcBtn("TP2")
            notSlcBtn("TP1")
            paramDinas=1
            $('#select-sector-penomoran-cr').val(null).trigger("change")
            $('#select-sector-penomoran-ed').val(null).trigger("change")
            break;
        default:

      }
}

function detail(id) {
    ewpLoadingShow();
    if (id != null) {
      $.ajax({
        type: "GET",
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: baseUrl + "api/letter-number/" + id,
        beforeSend: function (xhr) {
          xhr.setRequestHeader(
            "Authorization",
            "Bearer " + localStorage.getItem("token")
          );
        },
        success: function (response) {
          ewpLoadingHide();
          res = response.data;
          $("#modal").modal();
          $("#modal #modal-title").text("Detail Pemakaian Nomor");
          $("#modal #modal-title").attr("send", "add");
        // console.log(res)
          $("#modal .modal-dialog").addClass("modal-xl")
          $("#modal-body").addClass("row")
          var numInUse=""
          var numNotUse=""
          var numNonEsurat=""
          for (i = 0; i < res.number_use.length; i++){
            var nameUse = noNull(res.number_use[i]["user_name"]);

            if (nameUse == null){
                nameUse = "-";
            }
            numInUse+=`<li class="dual-listbox__item" onclick="detailNomor(`+res.number_use[i]["number"]+`,'`+res.number_use[i]['date_use']+`')" data-id="`+res.number_use[i]["number"]+`">`+res.number_use[i]["number"]+` oleh <span style="color:#3699FF">`+nameUse+`</span></li>`
          }
          for (n = 0; n < res.number_not_use.length; n++){
            numNotUse+=`<li class="dual-listbox__item py-1" onclick="pakaiNomor(`+res.number_not_use[n]+`,'`+id+`')" data-id="`+res.number_not_use[n]+`">`+res.number_not_use[n]+`</li>`
          }
          for (no = 0; no < res.number_use_non_esurat.length; no++){
            // console.log(res.number_use_non_esurat[no])
            // var username = noNull(res.number_use_non_esurat[no]["user_name"]);
            // if (username == null){
            //   username = "-";
            // }
            numNonEsurat+=`<li class="dual-listbox__item py-1" onclick="detailNomorNonEsurat(`+res.number_use_non_esurat[no]["number"]+`,'`+res.number_use_non_esurat[no]['date_use']+`','`+res.number_use_non_esurat[no]['judul']+`','`+res.number_use_non_esurat[no]['keterangan']+`')" data-id="`+res.number_use_non_esurat[no]["number"]+`">`+res.number_use_non_esurat[no]["number"]+`</li>`
          }

          $("#modal-body").html(
            `
          <div class="dual-listbox kt_dual_listbox_1 col-md-3">
            <div class="dual-listbox__container"  style="flex-direction: column;">
              <div class="dual-listbox__title w-100 text-center m-0">Nomor Sudah Dipakai</div>
              <ul class="dual-listbox__available w-100 m-0">
                  `+numInUse+numNonEsurat+`
              </ul>
              </div>
          </div>
          <div class="dual-listbox kt_dual_listbox_1 col-md-3">
            <div class="dual-listbox__container"  style="flex-direction: column;">
              <div class="dual-listbox__title w-100 text-center m-0">Nomor Belum Dipakai</div>
              <ul class="dual-listbox__available w-100 customs-scroll m-0">
                  `+numNotUse+`
              </ul>
              </div>
          </div>
          <div class="border col-md-6 text-center" id="detail-nomor">
            <img class="mt-24" src="`+imgDetail+`"/>
            <p class="font-size-h6">Klik “nomor sudah dipakai” untuk menampilkan <br/>detail surat disini</p>

          </div>
               `
          );
          $("#modal-footer").html(
            `
                <button type="button" class="btn btn-secondary font-weight-bold px-5" data-dismiss="modal" style="border-radius:1.5rem;">Tutup</button>
            `
          );
          //detailNomor()

        },
        error: function (xhr, ajaxOptions, thrownError) {
          ewpLoadingHide();
          handleErrorDetail(xhr);
        },
      });
    }

  }

function detailNomor(num,tgl){
  // console.log('detail');
    if (num != null&&num != tgl) {
        $.ajax({
          type: "GET",
          headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
          },
          url: baseUrl + "api/letter-number/detail-number-use?number="+num+"&date="+tgl,
          beforeSend: function (xhr) {
            xhr.setRequestHeader(
              "Authorization",
              "Bearer " + localStorage.getItem("token")
            );
          },
          success: function (response) {
            ewpLoadingHide();
            res = response.data;

            var nnjudul=res.surat!==null?noNull(res.surat.judul):"-"
            var nnpengirim=res.surat!==null?res.surat.pengirim!==null?noNull(res.surat.pengirim.nama):"-":"-"
            var nntanggal=res.surat!==null?noNull(res.surat.tanggal):"-"
            // console.log(res.surat);
            // console.log(res.surat.link);
            $('#detail-nomor').removeClass("text-center")
            $('#detail-nomor').html(
                `
                <h3 class="my-4">Detail Surat</h3>
                <div class="col-md-12 mt-8 row p-0 font-size-h6">
                    <div class="col-md-6">
                        <p class="my-3">Nomor Surat</p>
                    </div>
                    <div class="col-md-6 text-right font-weight-bolder">
                        <p class="my-3">`+res.number+`</p>
                </div>
                    <div class="col-md-6">
                        <p class="my-3">Tanggal surat</p>
                    </div>
                    <div class="col-md-6 text-right font-weight-bolder"><p class="my-3">`+nntanggal+`</p></div>
                    <div class="col-md-6">
                        <p class="my-3">Judul surat</p>
                    </div>
                    <div class="col-md-6 text-right font-weight-bolder"><p class="my-3">`+nnjudul+`</p></div>
                    <div class="col-md-6">
                        <p class="my-3">Pengirim</p>
                    </div>
                    <div class="col-md-6 text-right font-weight-bolder"><p class="my-3">`+nnpengirim+`</p></div>
                    <div class="col-md-6">
                        <p class="my-3">File surat</p>
                    </div>
                    <div class="col-md-6 text-right font-weight-bolder"><a class="my-3 text-primary" href="`+res.surat.link+`" target="_blank">`+nnjudul+`</a></div>
                </div>
                `
            )

          },
          error: function (xhr, ajaxOptions, thrownError) {
            ewpLoadingHide();
            handleErrorDetail(xhr);
          },
        });
      }

}

function detailNomorNonEsurat(num, tgl, judul, keterangan){
  if (num != null&&judul != null&&keterangan != null) {
      $.ajax({
        type: "GET",
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: baseUrl + "api/number-in-use/"+num,
        beforeSend: function (xhr) {
          xhr.setRequestHeader(
            "Authorization",
            "Bearer " + localStorage.getItem("token")
          );
        },
        success: function (response) {
          ewpLoadingHide();
          res = response.data;

          $('#detail-nomor').removeClass("text-center")
          $('#detail-nomor').html(
              `
              <h3 class="my-4">Detail Surat</h3>
              <div class="col-md-12 mt-5 row p-0 font-size-h6">
                <div class="col-md-6">
                    <p class="my-3">Nomor Surat</p>
                </div>
                <div class="col-md-6 text-right font-weight-bolder mt-3">
                    <span class="my-3">`+num+`</span>
                </div>
                <div class="col-md-6">
                    <p class="my-3">Tanggal Surat</p>
                </div>
                <div class="col-md-6 text-right font-weight-bolder mt-3">
                    <span class="my-3">`+tgl+`</span>
                </div>
                <div class="col-md-6">
                    <p class="my-3">Judul Surat</p>
                </div>
                <div class="col-md-6 text-right font-weight-bolder mt-3">
                    <span class="my-3">`+judul+`</span>
                </div>
                <div class="col-md-6">
                    <p class="my-3">Keterangan</p>
                </div>
                <div class="col-md-6 text-right font-weight-bolder mt-3">
                    <span class="my-3">`+keterangan+`</span>
                </div>
              </div>
              `
          )

        },
        error: function (xhr, ajaxOptions, thrownError) {
          ewpLoadingHide();
          handleErrorDetail(xhr);
        },
      });
    }

}

function pakaiNomor(num, id){
  var today = new Date();
  var date_use = today.getFullYear()+'-'+('0' + (today.getMonth()+1)).slice(-2)+'-'+('0' + today.getDate()).slice(-2);
  // console.log(date_use);
  // console.log(num)
  // if (num != null) {
    $.ajax({
      type: "GET",
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      },
      url: baseUrl + "api/letter-number",
      beforeSend: function (xhr) {
        xhr.setRequestHeader(
          "Authorization",
          "Bearer " + localStorage.getItem("token")
        );
      },
      success: function (response) {
        ewpLoadingHide();
        res = response.data;

        // var nnjudul=res.surat!==null?noNull(res.surat.judul):"-"
        // var nnpengirim=res.surat!==null?res.surat.pengirim!==null?noNull(res.surat.pengirim.nama):"-":"-"
        // var nntanggal=res.surat!==null?noNull(res.surat.tanggal):"-"

        $('#detail-nomor').removeClass("text-center")
        $('#detail-nomor').html(
            `
            <div id="warning-modal"></div>
            <h3 class="my-4">Gunakan Nomor Untuk Surat Offline</h3>
            <div class="text-muted">Silahkan pilih nomor yang belum dipakai lalu lengkapi form berikut</div>
            <div class="col-md-12 mt-5 row p-0 font-size-h6">
              <div class="col-md-6">
                  <p class="my-3">Nomor Surat</p>
              </div>
              <div class="col-md-6 text-right font-weight-bolder mt-3">
                  <span class="my-3">`+num+`</span>
              </div>
                  <input class="form-control col-md-12 mb-5 me-10 fw-bolder text-right" style="border:none" type="hidden" name="number" id="number" title="number" value="`+num+`">
                  <input class="form-control col-md-12 mb-5 me-10 fw-bolder text-right" style="border:none" type="hidden" name="date_use" id="date_use" title="date_use" value="`+date_use+`">
              <div class="col-md-12">
                  <p class="my-3">Judul Surat</p>
              </div>
              <div class="col-md-12">
                  <input class="form-control col-md-12 mb-5 me-10" type="text" placeholder="Masukkan judul surat" name="judul" id="judul" title="judul" required>
              </div>
              <div class="col-md-12">
                  <p class="my-3">Keterangan</p>
              </div>
              <div class="col-md-12">
                  <input class="form-control col-md-12 mb-5 me-10" type="text" placeholder="Masukkan keterangan surat" name="keterangan" id="keterangan" title="keterangan" required>
              </div>
              <div class="col-md-12">
                  <button type="button" class="btn btn-warning font-weight-bold" onclick="tambah(`+id+`)" style="border-radius:1.5rem;">Simpan</button>
              </div>
            </div>
            `
        )

      },
      error: function (xhr, ajaxOptions, thrownError) {
        ewpLoadingHide();
        handleErrorDetail(xhr);
      },
    });
  // }
}

function getToday(){
    var d = new Date();

        var month = d.getMonth()+1;
        var day = d.getDate();

        var dateNow = d.getFullYear() + '/' +
            (month<10 ? '0' : '') + month + '/' +
            (day<10 ? '0' : '') + day;
        return dateNow
}

function warningModal(title,desc){
    $('#warning-modal').append(`
        <div class="alert alert-custom alert-notice alert-light-danger fade show" role="alert">
            <div class="alert-text">
                <h5>`+title+`</h5>
                <span>`+desc+`</span>
            </div>
            <div class="alert-close">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true"><i class="ki ki-close"></i></span>
                </button>
            </div>
        </div>
    `)
}

function edit(id) {
    paramDinas=''
    ewpLoadingShow();
    if (id != null) {
      $.ajax({
        type: "GET",
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: baseUrl + "api/letter-number/" + id,
        beforeSend: function (xhr) {
          xhr.setRequestHeader(
            "Authorization",
            "Bearer " + localStorage.getItem("token")
          );
        },
        success: function (response) {
          ewpLoadingHide();
          res = response.data;
          var scv=res.sector!==null?noNull(res.sector.id):noNull(res.sector)
          var scn=res.sector!==null?noNull(res.sector.name):noNull(res.sector)
          console.log(scv + " - "+ scn)
          // console.log(res.letter_code)
          if (res.letter_code == null) {
            res.letter_code = ""
          }
            $("#modal").modal();
            $("#modal-title").text("Edit Data");
            $("#modal-title").attr("send", "add");
            $("#modal .modal-dialog").removeClass("modal-xl")
            $("#modal-body").html(
            `<form id="form-input px-4" style="width:100%">
                <div id="warning-modal"></div>
                <input type="hidden" name="id" id="id" value="`+id+`">
                    <div class="form-group">
                        <label>Tanggal pembuatan</label>
                        <input type="text" class="form-control" readonly="readonly" id="tgl" placeholder="Pilih Tanggal"  value="`+csDate(res.created_at)+`"/>
                    </div>
                    <div class="form-group">
                    <label>Dibuat oleh (Otomatis)</label>
                    <input type="hidden" name="created_by" id="created_by">
                    <input class="form-control" type="text" placeholder="Cth: Administrator" name="created_by_name" id="created_by_name" value="Administrator" disabled>
                </div>
                <div class="form-group">
                    <label for="awal">Nomor Terakhir</label>
                    <input class="form-control" type="text" name="terakhir" id="terakhir" placeholder="nomor terakhir" disabled>
                </div>
                <div class="form-group">
                    <label>Nomor awal</label>
                    <input class="form-control" type="text" placeholder="XXXXXXXXXX" name="awal" id="awal" value="`+res.start_at+`" title="nomor awal">
                </div>
                <div class="form-group">
                    <label>Nomor akhir</label>
                    <input class="form-control" type="text" placeholder="XXXXXXXXXX" name="akhir" id="akhir" value="`+res.end_in+`" title="nomor akhir">
                </div>
                <div class="form-group">
                    <label>Kode Surat</label>
                    <input class="form-control" type="text" placeholder="cth: KOE-001" name="kode_surat" id="kode_surat" title="kode_surat" value="`+res.letter_code+`">
                </div>
                <div class="form-group">
                    <label>Tipe Penggunaan</label><br/>
                    <button type="button" id="TP2" class="btn btn-outline-primary" onclick="typeDinass('2')">Dinas</button>
                    <button type="button" id="TP1" class="btn btn-outline-primary" onclick="typeDinass('1')">Unit Kerja</button>

                </div>
                <div class="form-group d-none" id="form-tp">
                    <label>Bidang</label>
                    <select class="form-control select2" id="select-sector-penomoran-ed" name="param" style="width:100%">
                        <option selected="selected" value="`+scv+`">`+scn+`</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Perihal</label>
                    <input class="form-control" type="text" placeholder="Masukkan Perihal" name="perihal" id="perihal" value="`+noNullin(res.regarding)+`" title="perihal">
                </div>
                </form>`
            );
            new InputMask({
                masked: "#awal,#akhir"
            });
            $('#tgl').datepicker({
                rtl: KTUtil.isRTL(),
                todayHighlight: true,
                orientation: "bottom left",
                format: 'dd-mm-yyyy',
                startDate: new Date(),
                autoclose:true
            }).on("change", function() {
                if($('#tgl').val()!==''){
                    getLastNumber()
                }
              });
            if(res.sector!==null){
                typeDinass('1')
            }else{
                typeDinass('2')
            }
            $("#modal-footer").html(
            `
            <button type="button" class="btn btn-light-warning font-weight-bold px-5" data-dismiss="modal" style="border-radius:1.5rem;">Cancel</button>
            <button type="button" class="btn btn-warning font-weight-bold" onclick="simpan()" style="border-radius:1.5rem;">Simpan</button>
            `
            );
            getLastNumber()
            sLoader('sector-penomoran-ed','sector-penomoran',"Unit Kerja")
        },
        error: function (xhr, ajaxOptions, thrownError) {
          ewpLoadingHide();
          handleErrorDetail(xhr);
        },
      });
    }

}
function csDate(dt){
    var sDate = dt.split("-")
    var data = sDate[2]+"-"+sDate[1]+"-"+sDate[0]
    return data
}

function getLastNumber() {
    if (id != null) {
      $.ajax({
        type: "GET",
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data:{
            date:$('#tgl').val()
        },
        url: baseUrl + "api/letter-number/get-last-number",
        beforeSend: function (xhr) {
          xhr.setRequestHeader(
            "Authorization",
            "Bearer " + localStorage.getItem("token")
          );
        },
        success: function (response) {
          ewpLoadingHide();
          res = response.data;
           $('#terakhir').val(res);
        },
        error: function (xhr, ajaxOptions, thrownError) {
          ewpLoadingHide();
          handleErrorDetail(xhr);
        },
      });
    }
}

function tambah(id) {
  // var judul = $("judul").required;
  // document.getElementById("judul").innerHTML = judul;
  // console.log(number);
  if($("#judul").val()==""||$("#keterangan").val()==""){
      warningModal("Oppss...","Harap mengisi data dengan lengkap terlebih dahulu.")
  }else{
  ewpLoadingShow();
  
  var tambahNomor = {
      number: $("#number").val(),
      date_use: $("#date_use").val(),
      // user_name: $("#user_name").val(),
      judul: $("#judul").val(),
      keterangan: $("#keterangan").val(),
  };
  // console.log(tambahNomor.number);
  var tipe = "POST";
  var data = tambahNomor;
  var link = baseUrl + "api/number-in-use/number-not-use";
  $.ajax({
      type: "POST",
      dataType: "json",
      data: tambahNomor,
      url: link,
      beforeSend: function (xhr) {
      xhr.setRequestHeader(
          "Authorization",
          "Bearer " + localStorage.getItem("token")
      );
      },
      success: function (response) {
      ewpLoadingHide();
      detail(id);
      Swal.fire("Success!", "Nomor Surat berhasil digunakan.", "success");
      // $("#modal").modal("show");
      // detailNomorNonEsurat(tambahNomor.number, tambahNomor.date_use, tambahNomor.judul, tambahNomor.keterangan);
      // Response.redirect(baseUrl + "api/number-in-use/" + tambahNomor.number);
      // window.location.href = baseUrl + "api/number-in-use/" + tambahNomor.number;
      // window.onload = function() {
      //   location.href = baseUrl + "api/number-in-use/" + tambahNomor.number;
      // }
      // window.history.back()
      // Swal.fire({
      //   title: "Success!",
      //   text: "Nomor Surat berhasil digunakan.",
      //   icon: "success",
      //   showCancelButton: false,
      //   confirmButtonText: `<button onclick="detailNomorNonEsurat(`+tambahNomor.number+`)">OK</button>`
      // });
      table();
      },
  });
  }
}

function simpan() {
if($("#awal").val()==""||$("#akhir").val()==""||$("#tgl").val()==""){
    warningModal("Oppss...","Harap mengisi data dengan lengkap terlebih dahulu.")
}else{
ewpLoadingShow();

var dataTambah = {
    start_at: $("#awal").val(),
    end_in: $("#akhir").val(),
    letter_code: $("#kode_surat").val(),
    regarding: $("#perihal").val(),
    date: $("#tgl").val(),
    sector_id:$("#select-sector-penomoran-cr").val(),
    type:paramDinas
};

var dataEdit = {
    start_at: $("#awal").val(),
    end_in: $("#akhir").val(),
    letter_code: $("#kode_surat").val(),
    regarding: $("#perihal").val(),
    date:$('#tgl').val(),
    sector_id:$("#select-sector-penomoran-ed").val(),
    type:paramDinas
};

var tipe = $("#id").val() == "" ? "POST" : "PUT";
var data = $("#id").val() == "" ? dataTambah : dataEdit;
var link =
    $("#id").val() == ""
    ? baseUrl + "api/letter-number"
    : baseUrl + "api/letter-number/" + $("#id").val();
$.ajax({
    type: tipe,
    dataType: "json",
    data: data,
    url: link,
    beforeSend: function (xhr) {
    xhr.setRequestHeader(
        "Authorization",
        "Bearer " + localStorage.getItem("token")
    );
    },
    success: function (response) {
    ewpLoadingHide();
    $("#modal").modal("hide");
    Swal.fire("Success!", $("#id").val() == "" ? "Nomor surat berhasil dibuat." : "Nomor surat berhasil dirubah.", "success");
    table();
    },
    error: function (response) {
    ewpLoadingHide();
    if(response.responseJSON.status.code==500){
        warningModal("Opps...","Silahkan coba lagi")
    }else if(response.responseJSON.status.code==400){
      warningModal("Maaf, Nomor sudah ada!", response.responseJSON.status.message+", silahkan menggunakan nomor lain.")
    }else{
        handleError(response);
    }
    },
});
}
}

function hapus(id){
    Swal.fire({
        title: "Apakah anda yakin?",
        text: "Anda tidak dapat mengembalikan data yang sudah di hapus!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Ya, Hapus!"
    }).then(function(result) {
        if (result.value) {
            ajaxHapus(id)
        }
    });
}

function locked(id){
    Swal.fire({
        title: "Kunci nomor ini!",
        text: "Anda tidak dapat mengubah lagi data pada nomor ini!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Ya, Kunci!"
    }).then(function(result) {
        if (result.value) {
            ajaxLocked(id)
        }
    });
}

function ajaxHapus(id) {
    $.ajax({
      type: "DELETE",
      headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
      beforeSend: function (xhr) {
        xhr.setRequestHeader(
          "Authorization",
          "Bearer " + localStorage.getItem("token")
        );
      },
      data: {
      },
      url: baseUrl+"api/letter-number/" + id,
      success: function (response) {
        Swal.fire("Success","Nomor surat berhasil dihapus!","success");
        table();
      },
      error: function (response) {
        handleError(response);
      },
    });
  }

function ajaxLocked(id) {
$.ajax({
    type: "PATCH",
    headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
    beforeSend: function (xhr) {
    xhr.setRequestHeader(
        "Authorization",
        "Bearer " + localStorage.getItem("token")
    );
    },
    data: {
    },
    url: baseUrl+"api/letter-number/" + id,
    success: function (response) {
    Swal.fire("Success","Nomor surat berhasil dikunci!","success");
    table();
    },
    error: function (response) {
    handleError(response);
    },
});
}
