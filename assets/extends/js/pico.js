var ewpTable = function (data) {
  if (data === "undefined") {
    console.log("missing param");
  } else {
    var el_id = data["targetId"] !== "undefined" ? data["targetId"] : "";
    var el_class = data["class"] !== "undefined" ? data["class"] : "";
    var column = data["column"] !== "undefined" ? data["column"] : "";
    var setFooter = data["footer"] !== "undefined" ? data["footer"] : false;

    var thead = "";
    var tfoot = "";

    if (column !== "undefined") {
      for (i = 0; i < column.length; i++) {
        var width =
          column[i]["width"] !== "undefined" ? column[i]["width"] : "";
        var icon = column[i]["icon"] !== "undefined" ? column[i]["icon"] : "";
        var name = column[i]["name"] !== "undefined" ? column[i]["name"] : "";

        thead +=
          '<th width="' +
          width +
          '%"><i class="' +
          icon +
          '"></i>&nbsp; ' +
          name +
          "</th>";
        tfoot +=
          '<th width="' +
          width +
          '%"><i class="' +
          icon +
          '"></i>&nbsp; ' +
          name +
          "</th>";
      }
    }

    var html =
      '<table class="' +
      el_class +
      '" id="' +
      el_id +
      '" data-ride="datatables" style="width: 100%;">' +
      "<thead><tr>" +
      thead +
      "</tr></thead>" +
      "<tbody><tr><td>&nbsp;</td></tr></tbody>" +
      (setFooter == true ? "<tfoot><tr>" + tfoot + "</tr></tfoot>" : "") +
      "</table>";

    return html;
  }
};

var ewpDatatables = function (data) {
  let dTable,
    column = [],
    modColumn = [],
    isServerSide = data.serverSide ? data.serverSide : true;

  for (var i = 0; i < data.column.length; i++) {
    // Menggambar Kolom
    column.push({ mData: data.column[i]["col"] });

    // Modifikasi kolom
    if (data.column[i]["mod"] != null) {
      modColumn.push(data.column[i]["mod"]);
    }
  }

  $(data.target).each(function () {
    dTable = $(this).dataTable({
      bDestroy: true,
      processing: true,
      serverSide: isServerSide,
      ajax: {
        url: data.url,
        type: "POST",
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        dataSrc: function (json) {
          json.draw = $('[name="draw"]').val();
          json.recordsTotal = json.data.meta.total;
          json.recordsFiltered = json.data.meta.total;
          return json.data[data.apiKey];
        },
      },
      sPaginationType: "full_numbers",
      dom:
        "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-4'f><'col-sm-12 col-md-2 text-center'<'btn_search mt-2 mb-3'>>>" +
        "<'row'<'col-md-12'tr>>" +
        "<'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'p>>",
      aoColumns: column,
      aaSorting: [data.sorting],
      lengthMenu: [10, 25, 50, 75, 100],
      pageLength: 10,
      aoColumnDefs: modColumn,
      fnDrawCallback: function (oSettings) {
        $("tbody tr").each(function () {
          $('[data-toggle="tooltip"]').tooltip();
        });
        $(".btn_search").html(
          `<a href="javacript:;" class="kt-font-primary"><u><i class="la la-search"></i>  Advanced Search</u></a>`
        );
      },
      fnHeaderCallback: function (nHead, aData, iStart, iEnd, aiDisplay) {
        $(nHead).children("th").addClass("text-center");
      },
      fnFooterCallback: function (nFoot, aData, iStart, iEnd, aiDisplay) {
        $(nFoot).children("th").addClass("text-center");
      },
      fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
        for (var i = 0; i < data.column.length; i++) {
          if (data.column[i]["mid"] == true) {
            $(nRow)
              .children("td:nth-child(" + (i + 1) + ")")
              .addClass("text-center");
          }
        }
      },
    });
  });

  return dTable;
};

var geekDatatables = function (data) {
  let dTable,
    column = [],
    modColumn = [],
    isServerSide = data.serverSide ? data.serverSide : true;

  for (var i = 0; i < data.column.length; i++) {
    // Menggambar Kolom
    column.push({ mData: data.column[i]["col"] });

    // Modifikasi kolom
    if (data.column[i]["mod"] != null) {
      modColumn.push(data.column[i]["mod"]);
    }
  }

  $(data.target).each(function () {
    dTable = $(this).dataTable({
      bDestroy: true,
      processing: true,
      serverSide: isServerSide,
      ajax: {
        data:data.data,
        url: data.url,
        type: "GET", 
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        beforeSend: function (xhr) {
          xhr.setRequestHeader(
            "Authorization",
            "Bearer " + localStorage.getItem("token")
          );
        },
        error: function(jqXHR, ajaxOptions, thrownError) {
            if(jqXHR.status==401){
                localStorage.clear()
                window.location.href=baseUrl+"login"
            }else{
                handleErrorXML(jqXHR)
            }
        }
      },
      sPaginationType: "full_numbers",
      // dom:
      // "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-4'f><'col-sm-12 col-md-2 text-center'<'btn_search mt-2 mb-3'>>>" +
      // "<'row'<'col-md-12'tr>>" +
      // "<'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'p>>",
      aoColumns: column,
      aaSorting: [data.sorting],
      lengthMenu: [10, 25, 50, 75, 100],
      pageLength: 10,
      aoColumnDefs: modColumn,
      fnDrawCallback: function (oSettings) {
        $("tbody tr").each(function () {
          $('[data-toggle="tooltip"]').tooltip();
        });
        $(".btn_search").html(
          `<a href="javacript:;" class="kt-font-primary"><u><i class="la la-search"></i>  Advanced Search</u></a>`
        );
      },
      fnHeaderCallback: function (nHead, aData, iStart, iEnd, aiDisplay) {
        $(nHead).children("th").addClass("text-center");
      },
      fnFooterCallback: function (nFoot, aData, iStart, iEnd, aiDisplay) {
        $(nFoot).children("th").addClass("text-center");
      },
      fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
        for (var i = 0; i < data.column.length; i++) {
          if (data.column[i]["mid"] == true) {
            $(nRow)
              .children("td:nth-child(" + (i + 1) + ")")
              .addClass("text-center");
          }
        }
      },
    });
  });

  return dTable;
};

var handleErrorXML = function(response){
	var status = response.status
	if(status == 422){
		var res = response.responseJSON.data.errors
		var html = ''
		$.each(res, function (index, value) {
			html += '<label>'+value+'</label><br>'
		})
		Swal.fire('Oopss...', html, 'error')
	} else if(status == 401) {
		let res = response.responseJSON
		//if(res.status == 'Token is Invalid' || res.status == 'Token is Expired' || res.status == 'Your token has expired. Please, login again.' || res.status == 'Your token is invalid. Please, login again.') {
			Swal.fire({
				title: "Oopss...",
				icon: "error",
				text: res.status.message,
				showCancelButton: false,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: "Ok",
			}).then((result) => {
				if (result.value) {
					localStorage.setItem("token", "");
					window.location.href = baseUrl+'login';
				}
			});
		// } else {
		// 	Swal.fire({
		// 		title: "Oopss...",
		// 		icon: "error",
		// 		text: "Terjadi kesalahan koneksi",
		// 		showCancelButton: false,
		// 		confirmButtonColor: "#3085d6",
		// 		cancelButtonColor: "#d33",
		// 		confirmButtonText: "Ok",
		// 	}).then((result) => {
		// 		if (result.value) {
		// 			window.location.href = baseUrl+url;
		// 		}
		// 	});
		// }
	} else if(status == 403){
		Swal.fire('Oopss...', response.responseJSON.status.message, 'error')
	} else if(status == 400){
		Swal.fire('Oopss...', response.responseJSON.status.message, 'error')
	} else if(status == 405){
		Swal.fire('Oopss...', response.responseJSON.status.message, 'error')
	}  else {
        Swal.fire({
            title: "Oopss...",
            icon: "error",
            text: "Terjadi kesalahan koneksi",
            showCancelButton: false,
            confirmButtonColor: "#3085d6",
            confirmButtonText: "Ok",
        }).then((result) => {
            if (result.value) {
                location.reload();
            }
        });
	}
}