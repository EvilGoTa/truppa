$(function() {
    $(document).on('click', '.delete-participant a', function() {
        var target = $(this);
        console.log(target);
        var contact = target.attr('data-contact_id');
        var event = target.attr('data-event');
        var data = {
            action: 'deleteParticipant',
            event_id: event,
            contact_id: contact
        };
        // console.log(data);
        $.post('/ajax', data, function(resp) {
            console.log(resp);

            if (resp.errors == 1) {
                alert('ошибка!');
            } else {
                target.closest('.initials-cucumber').addClass('deleted');
                setTimeout(function() {
                    target.closest('.initials-cucumber').hide();
                }, 200);
            }
        }, 'JSON');
        return false;
    });
});
