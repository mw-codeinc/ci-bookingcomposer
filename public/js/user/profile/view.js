function format(state) {
    if (!state.id) return state.text;
    return "<img class='flag' src='../../../img/flags/" + state.element[0]['attributes'][0]['value'].toLowerCase() + ".png'/>&nbsp;&nbsp;" + state.text;
}
$(document).ready(function() {
    if ($().select2 && $('#countrySelect').size() > 0) {
        $("#countrySelect").select2({
            placeholder: '<i class="fa fa-flag"></i>&nbsp;Wybierz kraj',
            allowClear: true,
            formatResult: format,
            formatSelection: format,
            escapeMarkup: function(m) {
                return m;
            }
        });

        $('#countrySelect').change(function() {
            $('.profile-form').validate().element($(this));
        });
    }

    $('#artistFormBtnSubmit').on("click", function(element) {
        if(element.handled !== true) {
            var updateForm = $('form#');

            updateForm.find('p.help-block').parent().removeClass('error');
            updateForm.find('p.help-block').remove();

            $.post(updateProfileUrl, { dataArr: updateForm.serializeArray() }, function (data) {
                if (data.formErrorMessagess && data.formErrorMessagess.length !== 0) {
                    $.each(data.formErrorMessagess, function (elementId, value) {
                        $.each(value, function (index, value) {
                            updateForm.find('input[name="' + elementId + '"]').parent().addClass('has-error').append('<p for="' + elementId + '" generated="true" class="help-block">' + value + '</p>');
                        });
                    });
                } else {
                    toastr.success('Artist has been successfully updated', 'Success');
                }
            });
            element.handled = true;
        }
    });
});