$(function() {
    $('#yandex-location').autocomplete({
        delay: 300,
        source: function(request, responce) {
            $.get('https://geocode-maps.yandex.ru/1.x/', {
                geocode: request.term,
                sizes: 5,
                format: 'json'
            }, function(data) {
                var result = [];
                data.response.GeoObjectCollection.featureMember.forEach(function(el, i) {
                    var el = el.GeoObject;
                    console.log(el);
                    result.push({
                        name: el.Point.pos,
                        value: (el.description?el.description + ', ':'') + el.name,
                        pos: el.Point.pos,
                    });
                });
                console.log(result);
                responce(result);
            })
        },
        select: function( event, ui ) {
            var latlong = ui.item.pos.split(' ');
            $('[name="data[location-lat]"]').val(latlong[1]);
            $('[name="data[location-long]"]').val(latlong[0]);
        }
    });

    jQuery.datetimepicker.setLocale('ru');
    $( "#datepicker" ).datetimepicker({
        format: "d.m.Y H:i",
        i18n:{
            ru:{
                months:[
                    'Январь','Февраль','Март','Апрель',
                    'Май','Июнь','Июль','Август',
                    'Сентябрь','Октябрь','Ноябрь','Декабрь',
                ],
                dayOfWeek:[
                    "Пн", "Вт", "Ср", "Чт",
                    "Пт", "Сб", "Вс",
                ]
            }
        },
        lang:'ru',
        mask:true,
    });

    $(document).on('click', '#more-stuff', function() {
        $('.template-stuff').clone().appendTo('.stuff-field').show().removeClass('template-stuff');
        return false;
    });

    $(document).on('click', '.check-button', function() {

        var field = $(this).attr('data-field');
        var data = {
            action: 'checkField',
            field : field,
            value : $('[name="data['+$(this).attr('data-field')+']"]').val()
        };
        console.log(data);
        $.post('/ajax', data, function(resp) {
            console.log(resp);
            if (resp.status === 'ok') {
                if (resp.data.check === 'success') {
                    alert('Всё в порядке!')
                }
                if (resp.data.check === 'fail') {
                    alert('Есть проблемы!')
                }
            }
        }, 'JSON');
    });

    $("#description").wysibb();
});