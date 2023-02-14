$(function () {
    $('#form_get_discount_hlblock').submit(function (e) {
        e.preventDefault();

        const formData = $(this).serialize();
        const formAction = $(this).attr('action');
        const formMethod = $(this).attr('method');

        $('.js-discount-status-message-hlblock').text('');
        $('.js-check-status-message-hlblock').text('');
        $('#discount_hlblock_quantity').attr('value', '');
        $('#discount_hlblock_code').attr('value', '');

        $.ajax({
            type: formMethod,
            url: formAction,
            data: formData,
            success: function (response) {
                if (typeof response.ajax_error != 'undefined') {
                    console.log('ajax_error: ' + response.ajax_error);
                } else {
                    if (typeof response.isPromoCodeChecked != 'undefined') {
                        if (response.isPromoCodeChecked == 'true') {
                            $('.js-check-status-message-hlblock').text('Ваша скидка: ' + response.discount.percentage + '%');
                        } else {
                            $('.js-check-status-message-hlblock').text('Скидка не доступна');
                        }
                    } else {
                        $('#discount_hlblock_quantity').attr('value', response.discount.percentage);
                        $('#discount_hlblock_code').attr('value', response.discount.promoCode);

                        if (response.minutesRemaining == 0 || typeof response.minutesRemaining == 'undefined') {
                            $('.js-discount-status-message-hlblock').text('Вы получили скидку, действует 1 час.');
                        } else {
                            $('.js-discount-status-message-hlblock').text('Ваша скидка ещё действует. Новую можно получить через ' + response.minutesRemaining + ' минут');
                        }
                    }
                }
            },
            error: function (response) {
                console.log('error');
                console.log(response);
                $('.js-discount-status-message-hlblock').text('Ошибка сервера, пожалуйста обновите страницу, или зайдите позже.');
            }
        })
    })
})