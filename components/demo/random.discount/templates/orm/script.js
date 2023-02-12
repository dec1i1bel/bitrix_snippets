$(function () {
    $('#form_get_discount_orm').submit(function (e) {
        e.preventDefault();

        const formData = $(this).serialize();
        const formAction = $(this).attr('action');
        const formMethod = $(this).attr('method');

        $('.js-discount-status-message-orm').text('');
        $('.js-check-status-message-orm').text('');
        $('#discount_orm_quantity').attr('value', '');
        $('#discount_orm_code').attr('value', '');

        $.ajax({
            type: formMethod,
            url: formAction,
            data: formData,
            success: function (response) {
                console.log([
                    response,
                    response.discount.percentage,
                    typeof response.isPromoCodeChecked
                ]);
                if (typeof response.isPromoCodeChecked != 'undefined') {
                    console.log('__if__');
                    if (response.isPromoCodeChecked == 'true') {
                        $('.js-check-status-message-orm').text('Ваша скидка: ' + response.discount.percentage + '%');
                    } else {
                        $('.js-check-status-message-orm').text('Скидка не доступна');
                    }
                } else {
                    console.log('__else__');
                    $('#discount_orm_quantity').attr('value', response.discount.percentage);
                    $('#discount_orm_code').attr('value', response.discount.promoCode);

                    if (response.minutesRemaining == 0 || typeof response.minutesRemaining == 'undefined') {
                        $('.js-discount-status-message-orm').text('Вы получили скидку, действует 1 час.');
                    } else {
                        $('.js-discount-status-message-orm').text('Ваша скидка ещё действует. Новую можно получить через ' + response.minutesRemaining + ' минут');
                    }
                }
            },
            error: function (response) {
                console.log('error');
                console.log(response);
                $('.js-discount-status-message-orm').text('Ошибка сервера, пожалуйста обновите страницу, или зайдите позже.');
            }
        })
    })
})