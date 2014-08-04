$(document).ready(function(){


    $('.dropdown-menu a').click(function(){
        var dataHref = $(this).attr('data-href');
        console.log(dataHref);
        if (typeof dataHref != 'undefined') {
            $.ajax({
                url: dataHref
            }).done(function (data) {
                    bsNotify(false, data.msg)
                });
        }
    });
});