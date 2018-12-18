var input = document.getElementById("imageFile"), formdata = false;

if (window.FormData) {
    
    formdata = new FormData();

    $('#imageFile').on('change', function (e) {

        var i = 0, len = this.files.length, img, file, $submitButton = $('button[type="submit"]');

        file = this.files[0];

        $('.progress').show();

        $submitButton.prop('disabled', true);

        if (formdata) {
            formdata.append("file", file);
            formdata.append("old_image", $('#image').val());
            $.ajax({
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        percentComplete = parseInt(percentComplete * 100) + '%';

                        $('.progress-bar').css('width', percentComplete).text(percentComplete);

                        if (percentComplete === 100) {
                            // $('#imagePreview').append($('<img src="'++'" />'))
                        }
                    }
                  }, false);

                return xhr;
                },
                url: $("#UPLOAD_URL").val(),
                type: "POST",
                dataType: 'json',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (data) {
                    $('#imagePreview img').css('opacity', '1');
                    if (data.file_name) {
                        $('#image').val(data.file_name);
                    }else{
                        toastr.options = {
                          'closeButton': true,
                          'debug': false,
                          'progressBar': true,
                          'positionClass': 'toast-bottom-right',
                          'showDuration': 400,
                          'hideDuration': 1000,
                          'timeOut': 5000,
                          'extendedTimeOut': 1000,
                          'showEasing': 'swing',
                          'hideEasing': 'linear',
                          'showMethod': 'fadeIn',
                          'hideMethod': 'fadeOut'
                        };
                        toastr.warning(data.error, "Warning");
                    }
                    $submitButton.prop('disabled', false);
                    if (!data.error) {
                        $('#imagePreview')
                            .html($('<div class="imageview-container">'+
                                        '<span class="delete" data-image-name="'+data.file_name+'">X</span>'+
                                        '<a href="'+data.file_name+'" download="'+data.file_name+'">'+data.file_name+'</a>'+
                                    '</div>'));
                    }

                }
            });
          
        } // if formdata 
    });

    $('#imagePreview').on('click', '.delete', function(event) {
        if ( !confirm("Are you sure do delete that image?\n This action will delete image whether or not you click save buttom!") ) {
            return;
        }
        var $that = $(this);
        $that.prop('disable', true);
        $.ajax({
            url: $("#DELETE_URL").val() + $("#FOLDER").val() + '/' + $("#MODEL").val(),
            type: 'POST',
            dataType: 'json',
            data: {file_name: $that.data('image-name'), rec : $('#RECORD_ID').val()},
        })
        .done(function(data) {

            if (data.status) {
                $("#imagePreview").find('.imageview-container').fadeOut('slow', function() {
                    $(this).remove();
                });
                $('#image').val('');
            }else{
                console.log("problem while deleting!");
                $that.prop('disable', false);
            }

        })
        .fail(function() {
            console.log("error");
        });
        
    });

} // if FormData is available