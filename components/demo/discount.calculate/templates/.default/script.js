$(function () {
    $('#form_get_discount').submit(function (e) {
        e.preventDefault();

        const formData = $(this).serialize();
        const formAction = $(this).attr('action');
        const formMethod = $(this).attr('method');

        $('.js-discount-status-message').text('');

        $.ajax({
            type: formMethod,
            url: formAction,
            data: formData,
            success: function (response) {
                $('#discount_quantity').attr('value', response.discount.percentage);
                $('#discount_code').attr('value', response.discount.promoCode);

                if (response.minutesRemaining == 0 || typeof response.minutesRemaining == 'undefined') {
                    $('.js-discount-status-message').text('Вы получили скидку, действует 1 час.');
                } else {
                    $('.js-discount-status-message').text('Ваша скидка ещё действует. Новую можно получить через ' + response.minutesRemaining + ' минут');
                }
            },
            error: function (response) {
                console.log('error');
                console.log(response);
                $('.js-discount-status-message').text('Ошибка сервера, пожалуйста обновите страницу, или зайдите позже');
            }
        })
    })
})