require('./bootstrap');

function cancelUpload() {
    if (jqXHR) {
        jqXHR.abort();
        jqXHR = null;
    }
    return false;
};

$(function () {
    // click upload button event
    $('#btnUpload').click(function () {
        $('#fileupload').click();
    });

    $('.upload-result').on('click', '.btnCancelUpload', function (e) {
        return cancelUpload();
    });

    // load sub-categories
    $('.upload-result').on('change', 'select.parent-category', function (e) {
        var uid = $(this).closest('.odd').prop('id');
        var url = $('#' + uid + ' #subcategories-url').val();
        var id = this.value;
        var name = $('#' + uid + ' #subcategory-none').val();
        url = url.replace('categoryId', id);
        $.get(url, function (data) {
            $('#' + uid + ' .subcategory').empty().append('<option value="0">' + name + '</option>');
            if (data.length == 0) {
                $('#' + uid + ' .subcategory').attr("disabled","disabled");
            } else {
                $('#' + uid + ' .subcategory').removeAttr("disabled");
            }
            $.each(data, function (index, element) {
                $('#' + uid + ' .subcategory').append('<option value="' + element.id + '">' + element.name + '</option>');
            });
        });
    });

    // save document
    $('.upload-result').on('click', '.btn-save', function (e) {
        var uid = $(this).closest('.odd').prop('id');
        var url = $('#' + uid + ' .upload-form').attr('action');
        var form = $('#' + uid + ' .upload-form');
        $.ajax({
            url: url,
            type:'POST',
            dataType: 'json',
            data: form.serialize(),
            success: function (data) {
                if(data.status == 200){
                    $('#' + uid).html(data.html);
                } else {
                    $('#uploadResult #' + uid + ' .tr_uploadNotifi .error').remove();
                    $('#uploadResult #' + uid).prepend('<tr class="tr_uploadNotifi error"><td colspan="2"><span><i class="icon"></i> ' + data.message + '</span></td></tr>');

                }
            },
            error: function (data) {
                if(data.status == 422) {
                    var error = data.responseJSON;
                    var errors = error.errors;
                    $('#uploadResult #' + uid + ' .tr_uploadNotifi').remove();
                    $('#uploadResult #' + uid).prepend('<tr class="tr_uploadNotifi error"><td colspan="2"><span><i class="icon"></i> ' + error.message + '</span></td></tr>');
                    $.each(errors, function (key, value) {
                        $('#uploadResult #' + uid + ' .tr_uploadNotifi td span').append('<br><i class="icon"></i> ' + value);
                    });
                } else {
                    // Error
                    // Incorrect credentials
                    $('#uploadResult #' + uid + ' .tr_uploadNotifi').remove();
                    $('#uploadResult #' + uid).prepend('<tr class="tr_uploadNotifi error"><td colspan="2"><span><i class="icon"></i>  Incorrect credentials. Please try again.</span></td></tr>');
                }
            }
        });
    });

    // upload document
    $('#fileupload').fileupload({
        dataType: 'json',
        add: function (e, data) {
            $.each(data.files, function (index, file) {
                var uid = Math.random().toString(36).substr(2, 16);
                $('#file-id').val(uid);
                $('#uploadResult').append('<tbody class="odd" id="' + uid + '"><tr><td colspan="2"><div class="upload-process-text"><span class="process-percent">0%</span>&nbsp;•&nbsp;' + file.name + '</div><div class="btnCancelUpload">Hủy tải lên</div><div class="upload-process"><div class="upload-process-bar" style="width: 0%"></div></div></td></tr></tbody>');
            });
            data.formData = $('#upload-form').serializeArray();
            jqXHR = data.submit();

        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            var uid = $('#file-id').val();
            $('#' + uid + ' .process-percent').text(progress + '%');
            $('#' + uid + ' .upload-process .upload-process-bar').css('width', progress + '%');
        },
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
                $('#uploadResult #' + file.uid + ' tr:nth-child(1)').html('<td colspan="2"><div class="upload-process-text"><span class="process-percent">100%</span>&nbsp;•&nbsp;' + file.name + ' (' + file.size + 'KB)</div><div class="upload-process"><div class="upload-process-bar" style="width: 100%"></div></div></td>');
                $('#uploadResult #' + file.uid).append(data.result.html);
            });
        },
        fail: function (e, data) {
            var errorThrown = data.errorThrown;
            var message;
            if (typeof data.jqXHR.responseJSON !== 'undefined') {
                message = data.jqXHR.responseJSON.message;
            } else {
                message = 'Cancel the file upload';
            }
            var formData = data.formData;
            var uid;
            $.each(formData, function (index, value) {
                if (value.name == 'id') {
                    uid = value.value;
                }
            });
            $.each(data.files, function (index, file) {
                $('#uploadResult #' + uid + ' tr:nth-child(1)').html('<td colspan="2"><div class="upload-process-text"><span class="process-percent">0%</span>&nbsp;•&nbsp;' + file.name + '</div><div class="upload-process"><div class="upload-process-bar" style="width: 0%"></div></div></td>');
                $('#uploadResult #' + uid + ' .process-percent').text('0%');
                $('#uploadResult #' + uid + ' .upload-process .upload-process-bar').css('width', '0%');
                $('#uploadResult #' + uid).prepend('<tr class="tr_uploadNotifi error"><td colspan="2"><span><i class="icon"></i> ' + errorThrown + ': ' + message + '</span></td></tr>');
            });
        }
    });
});
