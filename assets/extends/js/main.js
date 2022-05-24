jQuery(document).ready(function () {
    $('.user-name').html(localStorage.getItem("username"))
    $('.user-role').html(localStorage.getItem("role"))
  });

$(window).on("resize", function () {
if ($(window).width() <= 1024) {
    $("#kt_body").css('background-size',"auto")
} else {
    $("#kt_body").css('background-size',"contain")
}
});

function gantiPass(){
    $("#modal-pass").modal();
  $("#modal-pass #modal-title").text("Ubah Sandi");
  $("#modal-pass #modal-title").attr("send", "add");
  $("#modal-pass #modal-body").html(
    `<form id="form-input">
        <div class="col-12 mb-5">
        <p class="title mb-2">Sandi Saat ini</p>
        <div class="input-group">
            <input id="inp-eye1" type="password" class="form-control" placeholder="Masukkan Sandi" aria-describedby="basic-addon2" />
            <div class="input-group-append" id="btn-eye1">
                <span class="input-group-text"><i id="i-eye1" class="la la-eye-slash icon-lg"></i></span>
            </div>
        </div>
    </div>
    <div class="col-12 mb-5">
        <p class="title mb-2">Sandi Baru</p>
        <div class="input-group">
            <input id="inp-eye2" type="password" class="form-control" placeholder="Masukkan Sandi" aria-describedby="basic-addon2" />
            <div class="input-group-append" id="btn-eye2">
                <span class="input-group-text"><i id="i-eye2" class="la la-eye-slash icon-lg"></i></span>
            </div>
            
        </div>
        <span class="text-danger" id="lbl-eye2"></span>
    </div>
    <div class="col-12 mb-5">
        <p class="title mb-2">Konfirmasi Sandi Baru</p>
        <div class="input-group">
            <input id="inp-eye3" type="password" class="form-control" placeholder="Masukkan Sandi" aria-describedby="basic-addon2" />
            <div class="input-group-append" id="btn-eye3">
                <span class="input-group-text"><i id="i-eye3" class="la la-eye-slash icon-lg"></i></span>
            </div>
        </div>
    </div>
      </form>`
  );
  $("#modal-pass #modal-footer").html(
    `
        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary font-weight-bold" onclick="simpanPass()">Simpan</button>
    `
  );
  $("#btn-eye1").click(function () {
    let status= $("#inp-eye1").attr("type") =="text"?"password":"text"
    let icondel= $("#inp-eye1").attr("type") =="text"?"la-eye":"la-eye-slash"
    let icons= $("#inp-eye1").attr("type") !=="text"?"la-eye":"la-eye-slash"
    $("#inp-eye1").attr("type",status)
    $("#i-eye1").addClass(icons)
    $("#i-eye1").removeClass(icondel)
});
$("#btn-eye2").click(function () {
   
    let status= $("#inp-eye2").attr("type") =="text"?"password":"text"
    let icondel= $("#inp-eye2").attr("type") =="text"?"la-eye":"la-eye-slash"
    let icons= $("#inp-eye2").attr("type") !=="text"?"la-eye":"la-eye-slash"
    $("#inp-eye2").attr("type",status)
    $("#i-eye2").addClass(icons)
    $("#i-eye2").removeClass(icondel)
});
$("#btn-eye3").click(function () {
    let status= $("#inp-eye3").attr("type") =="text"?"password":"text"
    let icondel= $("#inp-eye3").attr("type") =="text"?"la-eye":"la-eye-slash"
    let icons= $("#inp-eye3").attr("type") !=="text"?"la-eye":"la-eye-slash"
    $("#inp-eye3").attr("type",status)
    $("#i-eye3").addClass(icons)
    $("#i-eye3").removeClass(icondel)
});
}

function simpanPass() {
    
    let newpass= $("#inp-eye2").val()
    if(newpass.length < 8){
        $("#lbl-eye2").html("password baru harus lebih dari 8 digit")
    }else if(newpass!==$("#inp-eye3").val()){
        Swal.fire("Oppss!", "password konfirmasi tidak sama dengan password baru", "warning")
    }else{
    ewpLoadingShow();
    var data = {
        old_pass: $("#inp-eye1").val(),
        new_pass: $("#inp-eye2").val(),
        new_pass_confirmation: $("#inp-eye3").val(),
    };
    var tipe = "POST"
    var link = baseUrl + "api/change-password"
    $.ajax({
        type: tipe,
        dataType: "json",
        data: data,
        url: link,
        headers: {
            "Authorization": "Bearer " + localStorage.getItem("token"),
        },
        success: function (response) {
        ewpLoadingHide();
        
        Swal.fire("Success!", "Password berhasil di ganti.", "success").then(function(result) {
            if (result.value) {
                window.location.href = baseUrl + "/";
            }
        });
        },
        
        error:function(response,statusText,xhr){
            if(xhr=="Unauthorized"){
                window.location.href=baseUrl+"login"
            }else{
                handleError(response);
            }
        }
    });
}
}

function logout(){
    ewpLoadingShow();
    $.ajax({
        url:baseUrl+'api/logout',
        type:'POST',
        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        beforeSend: function (xhr) {
            xhr.setRequestHeader(
            "Authorization",
            "Bearer " + localStorage.getItem("token")
        );
        },
        success:function(msg){
            ewpLoadingHide();
            localStorage.clear()
            window.location.href = baseUrl+"login";
        },
        error:function(msg, status, error){
            ewpLoadingHide();
            if(msg.responseJSON.error){
                var pesan = 'The username or password is incorrect'
            } else if(msg.responseJSON.status){
                var pesan = msg.responseJSON.status.message
            } else {
                var pesan = 'Connection error'
            }
            //ewpLoadingHide();
            swal.fire({
                title: "Oopss...",
                text: pesan,
                icon: "warning"
            });
        }
});
}