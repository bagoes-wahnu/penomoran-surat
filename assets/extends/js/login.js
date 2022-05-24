document.title = "Login - DISHUB Penomoran";

$(document).ready(function(){
    $('#loginBtn').on('click', function(){
        if($('[name="user"]').val() == '' || $('[name="password"]').val() == ''){
            Swal.fire('Error', 'Kolom Username dan Password tidak boleh kosong!', 'error')
        }else{
            login()
        }
    })
   
})

  $('#psw').on('keypress', function(){
      
        if (event.key === 'Enter' || event.keyCode === 13) {
        $('#loginBtn').click()
    }
});

function login(){
    ewpLoadingShow();
    $.ajax({
        url:baseUrl+'api/login',
        type:'POST',
        data:{
            username:$('[name="user"]').val(),
            password:$('[name="password"]').val()
        },
        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        beforeSend:function(){
            ////ewpLoadingShow();
        },
        success:function(msg){
            //ewpLoadingHide();
            var res = msg
            $(function() {
                //$.session.set('token', response.access_token);
                    if (typeof(Storage) !== "undefined") {
                    localStorage.setItem("token", res.access_token);
                    localStorage.setItem("username", res.user.username);
                    
                } else {
                    console.log("Sorry, your browser does not support Web Storage...");
                }
            });
            Swal.fire({
                title: 'Halo '+res.user.username,
                text: 'Selamat datang kembali',
                icon: 'success'
            }).then(
                (value) => {
                    window.location.href = baseUrl+"data-penomoran";
                }
              );
            
            ewpLoadingHide();
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
            ////ewpLoadingHide();
            swal.fire({
                title: "Oopss...",
                text: pesan,
                icon: "warning"
            });
        }
    });
}

var staticToken = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9"

function resetPass(){
    ewpLoadingShow();
    if($("#username").val()==''){
        ewpLoadingHide();
        swal.fire({
            title: "Opps..",
            text: 'Harap isikan username',
            icon: "warning"
        })
    }else{
    $.ajax({
        url:urlApi+'checkIdUser',
        type:'POST',
        data:{username:$("#username").val()},
        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        beforeSend: function (xhr) {
            xhr.setRequestHeader(
                "Authorization",
                "Bearer " + staticToken
            );
            },
        success:function(msg){
            ewpLoadingHide();
            var res = msg.user_data
            $.ajax({
                url:urlApi+"resetPassword/" + res[0].tdup_id,
                type:'POST',
               
                headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                beforeSend: function (xhr) {
                    xhr.setRequestHeader(
                        "Authorization",
                        "Bearer " + staticToken
                    );
                    },
                success:function(msg){
                    ewpLoadingHide();
                    var res = msg
                    swal.fire({
                        title: "Success",
                        text: 'Password berhasi di reset ke settingan default : dinpar1927',
                        icon: "success"
                    }).then(
                        (value) => {
                            window.location.href = baseUrl+"login";
                        }
                      );
                },
                error:function(msg, status, error){
                    ewpLoadingHide();
                    if(msg.responseJSON.code){
                        var pesan = 'The username is incorrect'
                    } else if(msg.responseJSON.status){
                        var pesan = msg.responseJSON.status.message
                    } else {
                        var pesan = 'Connection error'
                    }
                    
                    swal.fire({
                        title: "Oopss...",
                        text: pesan,
                        icon: "warning"
                    });
                }
            });
        },
        error:function(msg, status, error){
            
            ewpLoadingHide();
            if(msg.responseJSON.code==401){
                var pesan = 'User tidak terdaftar'
            }  else {
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
}