$(document).ready(function(){
    $('[data-toggle="modal"]').click(function(e) {
        var url = $(this).find('a').attr('href')
        showDialog(url);

        return false;
    });

    $("#login_modal").dialog({  //create dialog, but keep it closed
        autoOpen: false,
        height: 685,
        width: 700,
        modal: true
    });

    function showDialog(url){  //load content and open dialog
        $("#login_modal").load(url);
        $("#login_modal").dialog("open");
    }

});