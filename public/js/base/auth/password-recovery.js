$(document).ready(function() {
    $("#passwordResetBackBtn").on("click", function (element) {
        location.href = loginPageUrl;
    });

    $("#passwordRecoverySubmitBtn").on("click", function (element) {
        var form = $("form#passwordRecovery");
        form.find('span.help-block').parent().removeClass('has-error');
        form.find('span.help-block').remove();

        $('#passwordRecoverySuccessAlert').css('display', 'none');

        if(element.handled !== true) {
            $.post(passwordRecoveryUrl, { dataArr: form.serializeArray() }, function( data ) {
                if(data.formErrorMessagess && data.formErrorMessagess.length !== 0) {
                    $.each(data.formErrorMessagess, function (elementId, value) {
                        form.find('input[name="' + elementId + '"]').parent().parent().addClass('has-error');
                        form.find('input[name="' + elementId + '"]').parent().parent().append('<span class="help-inline"><ul class="errors-ul"></ul></span>');
                        $.each(value, function (index, value) {
                            form.find('input[name="' + elementId + '"]').parent().parent().find('span.help-inline ul').append('<li>' + value + '</li>');
                        });
                    });
                } else if(data.success) {
                    $('#passwordRecoverySuccessAlert').removeClass('display-hide');
                    $('#passwordRecoverySuccessAlert').addClass('display-show');
                    $('#passwordRecoverySuccessAlert').css('display', 'block');
                }
            });
            element.handled = true;
        }
        return false;
    });
});