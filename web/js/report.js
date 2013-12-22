$('.descriptionTd').click(function() {
    $(this).html($(this).attr('data-description'));
});

$('.assetHeader').click(function() {

    var container = $('#' + $(this).attr('data-container'));

    if(container.hasClass('hide'))
    {
        container.removeClass('hide');
    }
    else
    {
        container.addClass('hide');
    }

});