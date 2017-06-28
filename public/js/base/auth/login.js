$(document).ready(function() {
    $("#loginFormSubmitBtn").on("click", function (element) {
        var form = $("form#login");
        form.find('span.help-block').parent().removeClass('has-error');
        form.find('span.help-block').remove();

        $('#loginErrorAlert').css('display', 'none');

        if(element.handled !== true) {
            $.post(loginUrl, { dataArr: form.serializeArray() }, function( data ) {
                if(!data.success) {
                        $('#loginErrorAlert').removeClass('display-hide');
                        $('#loginErrorAlert').addClass('display-show');
                        $('#loginErrorAlert').css('display', 'block');
                        form.find('input').parent().parent().addClass('has-error');
                        $('#loginErrorAlert').find('span').text('Błędny email lub hasło');
                } else if(data.success) {
                    location.href = dashboardUrl;
                }
            });
            element.handled = true;
        }
        return false;
    });
});