$(document).ready(function () {
    show()
})

function show(){
    ewpLoadingShow();
    var links=window.location.href
    var lks=links.split("?")
    $.ajax({
        type:'GET',
        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        "Authorization":"Bearer " + localStorage.getItem("token")},
        url : baseUrl + 'api/export-excel?'+lks[1],
        success : function(response){
            ewpLoadingHide();
            
            $('#div-perview').html(response)

        },
        error: function (xhr, ajaxOptions, thrownError) {
            ewpLoadingHide();
            handleErrorDetail(xhr);
          },
    })
}