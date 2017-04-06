$(document).ready(function () {
    var $confirmModal = $('#confirm-delete, #confirm-action'),
        $ajaxModal = $('#ajaxModal'),
        $notificationsArea = $('#notifications-area'),
        $notificationMarkRead = $('#notification-mark-read'),
        $calloutArea = $("#callout-area");

    $.showError = function (errorText, errorTitle) {
        errorTitle = errorTitle || 'Error';

        var alertHtml = '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">';
        alertHtml += '&times;</button>';
        alertHtml += '<h4><i class="icon fa fa-ban"></i>' + errorTitle + '</h4>';
        alertHtml += errorText;

        if ($calloutArea.find(".callout").size() > 4) {
            $calloutArea.find(".callout").first().remove();
        }
        $calloutArea.append($("<div></div>").toggleClass('alert alert-danger alert-dismissible').html(alertHtml));
    };

    $.ajax('/notifications/_widget').success(function (result) {
        $notificationsArea.html(result);
    });

    // Bind click to OK button within popup
    $confirmModal.on('click', '.btn-ok', function (e) {
        var $modalDiv = $(e.delegateTarget);
        var ref = $(this).data('ref');

        $modalDiv.addClass('loading');
        $.post(ref).then(function (resp) {
            $modalDiv.modal('hide').removeClass('loading');

            if (resp.success == true) {
                window.location.href = resp.redirect;
            } else {
                $.showError(resp.error);
            }
        });
    });

    // Bind click to OK button within popup
    $notificationMarkRead.on('click', function () {
        var ref = $(this).data('ref');

        $.post(ref).then(function (resp) {
            if (resp.success == true) {
                window.location.href = resp.redirect;
            } else {
                $.showError(resp.error);
            }
        });
    });

    // Bind to modal opening to set necessary data properties to be used to make request
    $confirmModal.on('show.bs.modal', function (e) {
        var data = $(e.relatedTarget).data();
        if (data.message !== undefined) {
            $('.modal-body').html(data.message);
        }

        $('.title', this).text(data.recordTitle);
        $('.btn-ok', this).data('ref', data.ref);
    });

    // Workaround for BS modals
    $('body').on('hidden.bs.modal', '.modal', function () {
        $(this).removeData('bs.modal');
    });

    // ajax forms
    $ajaxModal.on('click', '.btn-success', function (event) {
        event.preventDefault();

        var form = $(this).parents('form');

        $.ajax({
            type: 'POST',
            url: form.attr('action'),
            data: form.serialize(),
            success: function (data) {
                if (data.success) {
                    window.location.href = data.redirect;
                } else if (data.error) {
                    $ajaxModal.modal('hide');
                    $.showError(data.error);
                } else {
                    $ajaxModal.find(".modal-content").html(data);
                    $ajaxModal.trigger('reloaded.hitmeister.modal');
                }
            }
        });
    });

    $(".date-time-picker").daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        timePicker: true,
        format: 'MM/DD/YYYY hh:mm:00'
    });

    $(".date-time-range-picker").daterangepicker({
        showDropdowns: true,
        format: 'MM/DD/YYYY hh:mm:00',
        timePicker: true
    });

    $(".date-picker").daterangepicker({
        singleDatePicker: true,
        showDropdowns: true
    });

    $(".date-range-picker").daterangepicker({
        showDropdowns: true
    });

});
