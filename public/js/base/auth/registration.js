$(document).ready(function() {
    $("#activationLoginBtn").on("click", function (element) {
        location.href = activationLoginUrl;
    });

    $("#registrationFormSubmitBtn").on("click", function (element) {
        var form = $("form#registration");
        form.find('span.help-inline').parent().removeClass('has-error');
        form.find('span.help-inline').remove();

        if(element.handled !== true) {
            $.post(registrationUrl, { dataArr: form.serializeArray() }, function( data ) {
                if(data.formErrorMessagess && data.formErrorMessagess.length !== 0) {
                    $.each(data.formErrorMessagess, function (elementId, value) {
                        if(elementId == 'country') {
                            form.find('select[name="' + elementId + '"]').parent().addClass('has-error');
                            form.find('select[name="' + elementId + '"]').parent().append('<span class="help-inline"><ul class="errors-ul"></ul></span>');
                            form.find('select[name="' + elementId + '"]').parent().find('span.help-inline ul').append('<li>Pole jest wymagane</li>');
                        } else {
                            form.find('input[name="' + elementId + '"]').parent().parent().addClass('has-error');
                            form.find('input[name="' + elementId + '"]').parent().parent().append('<span class="help-inline"><ul class="errors-ul"></ul></span>');
                            $.each(value, function (index, value) {
                                form.find('input[name="' + elementId + '"]').parent().parent().find('span.help-inline ul').append('<li>' + value + '</li>');
                            });
                        }
                    });
                } else if(data.success) {
                    location.href = dashboardUrl;
                }
            });
            element.handled = true;
        }
        return false;
    });
});