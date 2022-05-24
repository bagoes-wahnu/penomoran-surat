$(document).ready(function () {
    sLoader('sector-penomoran','sector-penomoran',"Bidang")


    var arrows;
      if (KTUtil.isRTL()) {
          arrows = {
              leftArrow: '<i class="la la-angle-right"></i>',
              rightArrow: '<i class="la la-angle-left"></i>'
          }
      } else {
          arrows = {
              leftArrow: '<i class="la la-angle-left"></i>',
              rightArrow: '<i class="la la-angle-right"></i>'
          }
      }
      var dates=$('#tgl-awal,#tgl-akhir').datepicker({
          rtl: KTUtil.isRTL(),
          todayHighlight: true,
          orientation: "bottom left",
          templates: arrows,
          // format: 'yyyy-mm-dd'
          format: 'dd-mm-yyyy'
      }).on("change", function() {
        var option = this.id == "tgl-awal" ? "setStartDate" : "setEndDate",
        date = this.id == "tgl-awal" ?$('#tgl-awal').val() : dateToday
        dates.not(this).datepicker(option, date);
      });
  });

  function cetak(){
    window.open(baseUrl + 'api/export-excel?start='+$('#num-awal').val()+'&end='+$('#num-akhir').val()+
    '&date_start='+$('#tgl-awal').val()+'&date_end='+$('#tgl-akhir').val()+'&letter_number=&preview=2&token='+localStorage.getItem("token"));
  }

  function perview(){
    var link = baseUrl + 'perview?start='+$('#num-awal').val()+'&end='+$('#num-akhir').val()+
    '&date_start='+$('#tgl-awal').val()+'&date_end='+$('#tgl-akhir').val()+'&letter_number=&preview=1';

    window.open(link);
  }
