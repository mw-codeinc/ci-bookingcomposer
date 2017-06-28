function format(state) {
    if (!state.id) return state.text;
    return sate.text;
}
$(document).ready(function() {
    if ($().select2 && $('#employeeSelect').size() > 0) {
        $("#employeeSelect").select2({
            language: "pl",
            placeholder: '<i class="fa fa-users"></i>&nbsp;Wybierz pracownika',
            allowClear: true,
            formatResult: format,
            formatSelection: format,
            escapeMarkup: function(m) {
                return m;
            }
        });

        $('#employeeSelect').change(function() {
            //$('.profile-form').validate().element($(this));
        });
    }

    if ($().select2 && $('#roomSelect').size() > 0) {
        $("#roomSelect").select2({
            language: "pl",
            placeholder: '<i class="fa fa-map-marker"></i>&nbsp;Wybierz gabinet',
            allowClear: true,
            formatResult: format,
            formatSelection: format,
            escapeMarkup: function(m) {
                return m;
            }
        });

        $('#roomSelect').change(function() {
            //$('.profile-form').validate().element($(this));
        });
    }

    $('#addAppointmentModal').on('show.bs.modal', function (event) {
        //var modal = $(this);
        //var addForm = $(this).find('form#artistEventForm');
        //addForm.find('input').not('.dpArtistEvent').val("");
        //
        //addForm.find('p.help-block').parent().removeClass('has-error');
        //addForm.find('p.help-block').remove();
        //
        //$("#addArtistEventSubmitBtn").on("click", function (element) {
        //    addForm.find('p.help-block').parent().removeClass('has-error');
        //    addForm.find('p.help-block').remove();
        //
        //    if(element.handled !== true) {
        //        $.post(createEventUrl, { dataArr: addForm.serializeArray(), dataKey: artistDataKey }, function( data ) {
        //            if(data.formErrorMessagess && data.formErrorMessagess.length !== 0) {
        //                $.each(data.formErrorMessagess, function (elementId, value) {
        //                    $.each(value, function (index, value) {
        //                        addForm.find('input[name="' + elementId + '"]').parent().addClass('has-error').append('<p for="' + elementId + '" generated="true" class="help-block">' + value + '</p>');
        //                    });
        //                });
        //            } else {
        //                if(data.eventData && data.eventData.length !== 0) {
        //                    var rowNode = $('#artist-event-table').DataTable()
        //                        .row.add( [ data.eventData.date, data.eventData.name, data.eventData.artistName, data.eventData.status, null, null ] )
        //                        .draw()
        //                        .node();
        //                    $(rowNode).addClass('key-tr gradeX row-bg-pending');
        //                    $(rowNode).attr('data-key', data.eventData.id);
        //                    $(rowNode).find('td').eq(4).empty();
        //                    $(rowNode).find('td').eq(5).empty();
        //                }
        //                modal.modal('hide');
        //                if(isAdmin) {
        //                    toastr.success('Event has been successfully added', 'Success');
        //                } else {
        //                    toastr.success('Event has been successfully submitted for review', 'Success');
        //                }
        //            }
        //        });
        //        element.handled = true;
        //    }
        //});
        //modalViewCount++;
    });

    //$('#artistFormBtnSubmit').on("click", function(element) {
    //    if(element.handled !== true) {
    //        var updateForm = $('form#');
    //
    //        updateForm.find('p.help-block').parent().removeClass('error');
    //        updateForm.find('p.help-block').remove();
    //
    //        $.post(updateProfileUrl, { dataArr: updateForm.serializeArray() }, function (data) {
    //            if (data.formErrorMessagess && data.formErrorMessagess.length !== 0) {
    //                $.each(data.formErrorMessagess, function (elementId, value) {
    //                    $.each(value, function (index, value) {
    //                        updateForm.find('input[name="' + elementId + '"]').parent().addClass('has-error').append('<p for="' + elementId + '" generated="true" class="help-block">' + value + '</p>');
    //                    });
    //                });
    //            } else {
    //                toastr.success('Artist has been successfully updated', 'Success');
    //            }
    //        });
    //        element.handled = true;
    //    }
    //});
});