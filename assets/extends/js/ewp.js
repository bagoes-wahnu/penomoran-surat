var loadingClass = 'ewp-loading'

var ewpLoadingShow = function(){
    var loadingDiv = document.createElement('div')
    loadingDiv.className = loadingClass
    $('body').append(loadingDiv)
}

var ewpLoadingHide = function(){
    $('.' + loadingClass).hide()
}

var ewpNumberOnly = function(target){
    $(target).keydown(function (e) {
    	
        if($(target).val().match(/\./g) == null){
        	if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
	            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
	            (e.keyCode >= 35 && e.keyCode <= 40)) {
	                return;
	            }	
        } else {
        	if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 ||
	            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
	            (e.keyCode >= 35 && e.keyCode <= 40)) {
	                return;
	            }
        }
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
}

var ewpIntegerOnly = function(target){
    $(target).keydown(function (e) {
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 ||
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                return;
            }
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
}

var ewpNumberDots = function(target){
	$(target).autoNumeric({
	    aSep:'.',
	    dGroup:'3',
	    aDec:',',
	    vMin:'0',
	    vMax:'9999999999999.99',
	    mDec:'2'
	});
}

function ewpFormatDots(bilangan, decimal = false){
	if(bilangan != null){
		var pecah_uang = bilangan.split(".");

		if(pecah_uang.length == 1){
			bilangan = pecah_uang[0];
			uang2 = '';
		}else{
			bilangan = pecah_uang[0];
			uang2 = pecah_uang[1];
		}

		var nilai_bilangan = "";
		var jumlah_angka = bilangan.length;

		while(jumlah_angka > 3){
			nilai_bilangan = "."+bilangan.substr(-3)+ nilai_bilangan;
			sisa_nilai = bilangan.length - 3;
			bilangan = bilangan.substr(0,sisa_nilai);
			jumlah_angka = bilangan.length;
		}

		if(decimal == true){
			if(pecah_uang.length == 1){
				nilai_bilangan = bilangan + nilai_bilangan + ",00";
			}else{
				nilai_bilangan = bilangan + nilai_bilangan + "," + uang2;
			}
		}else{
			if(pecah_uang.length == 1){
				nilai_bilangan = bilangan + nilai_bilangan;
			}else{
				nilai_bilangan = bilangan + nilai_bilangan;
			}
		}

		return nilai_bilangan;
	}else{
		return bilangan;
	}
}

var handleError = function(response){
    if(response.code == 500){
        Swal.fire('Oopss...', 'Internal Server Error', 'error')
        return false
    }

    if(response.code == 404){
        Swal.fire('Oopss...', 'URL Not Found', 'error')
        return false
    }

    if(response.code == 405){
        Swal.fire('Oopss...', 'Method Not Allowed Http Exception', 'error')
        return false
    }

    Swal.fire("Oopps...", response.message, "error")
}

var handleErrorXML = function(response){
    var res = response.responseJSON.errors
	var html = ''
	$.each(res, function (index, value) {
	html += value+'<br>'
	})
	Swal.fire('Oopss...', html, 'error')
}

var handleErrorDetail = function(response, url ='dashboard') {
	let res = response.responseJSON
	let code = response.status

	if(code == 403) {
		window.location.href = baseUrl+'permission';
	} else if(code == 401) {
        localStorage.setItem("token", "");
        window.location.href = baseUrl+'login';
	} else {
		Swal.fire({
			title: "Oopss...",
			icon: "error",
			text: "Terjadi kesalahan koneksi",
			showCancelButton: false,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Ok",
		}).then((result) => {
			if (result.value) {
				//window.location.href = baseUrl+url;
                window.reload()
			}
		});
	}
}

$(document).ready(function(){
	// ewpNumberDots('.number-dots')
	// ewpNumberOnly('.number-only')
})

function noNull(target){
    var res=target!==null?target:"-"
    return res
}

function noNullin(target){
    var res=target!==null?target:""
    return res
}

function sLoader(nama,url, ph) {
    $("#select-"+nama).select2({
      allowClear: true,
      placeholder: "Pilih "+ph,
      ajax: {
        url: baseUrl + "api/"+url+"/select-list",
        dataType: "json",
        type: "GET",
        quietMillis: 50,
        headers: {
            "Authorization" : "Bearer "+localStorage.getItem('token'),
        },
        data: function (term) {
          return {
            active_only:1,
            search:term.term,
          };
        },
        processResults: function (data) {
          return {
            results: $.map(data.data, function (item) {
              return {
                text: item.name,
                id: item.id,
              };
            }),
          };
        },
      },
    });
  }