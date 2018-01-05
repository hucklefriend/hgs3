
$(function (){
    $('.table-clickable-row tbody tr').click(function (){
        location.href = $(this).parent().parent().data('link') + $(this).data('id');
    });

    $('.auto-hide').each(function (){
        let target = $(this);
        let time = parseInt(target.data('hide_time'));

        setTimeout(function (){
            target.fadeOut();
        }, time);
    });

});