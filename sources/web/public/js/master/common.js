
$(function (){

    $('.auto-hide').each(function (){
        let target = $(this);
        let time = parseInt(target.data('hide_time'));

        setTimeout(function (){
            target.fadeOut();
        }, time);
    });

});