var input = document.getElementById("imageFile"), formdata = false;

if (window.FormData) {
    
    formdata = new FormData();

    $('#imageFile').on('change', function (e) {

        var i = 0, len = this.files.length, img, reader, file, $submitButton = $('button[type="submit"]');

        file = this.files[0];

        if (!!file.type.match(/image.*/)) {

            $('.progress').show();

            $submitButton.prop('disabled', true);

            if ( window.FileReader ) {
                reader = new FileReader();
                
                reader.onloadend = function (e) { 
                    showUploadedItem(e.target.result);
                };

                reader.readAsDataURL(file);

            } // if fileReader support

            if (formdata) {
                formdata.append("file", file);
                formdata.append("old_image", $('#image').val());
                formdata.append("folder", $('#FOLDER').val());
                formdata.append("model", $('#MODEL').val());
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
                            $("#imagePreview").find('.imageview-container').fadeOut('slow', function() {
                                $(this).remove();
                            });
                        }
                        $submitButton.prop('disabled', false);
                        $('#imagePreview').find('.uploading').attr('data-image-name', data.file_name).removeClass('uploading');
                    }
                });
              
            } // if formdata 
            
        } // if file type is image
        else{
            alert(file.type+' not supported. only image can be upload!');
        }

    });
    
    function showUploadedItem (source) {
      $("#imagePreview")
        .html( '<div class="imageview-container"><span class="delete uploading">X</span><img class="img-responsive" src="'+source+'"/></div>');
    }

    $('#imagePreview').on('click', '.delete', function(event) {
        if ( !confirm("Are you sure do delete that image?\n This action will delete image whether or not you click save buttom!") ) {
            return;
        }
        var $that = $(this);
        $that.prop('disabled', true);
        $.ajax({
            url: $("#DELETE_URL").val(),
            type: 'POST',
            dataType: 'json',
            data: {
                file_name: $that.data('image-name'), 
                rec : $('#RECORD_ID').val(), 
                folder : $('#FOLDER').val(), 
                model : $('#MODEL').val() 
            },
        })
        .done(function(data) {

            if (data.status) {
                $("#imagePreview").find('.imageview-container').fadeOut('slow', function() {
                    $(this).remove();
                });
                $('#image').val('');
            }else{
                console.log("problem while deleting!");
                $that.prop('disabled', false);
            }

        })
        .fail(function() {
            console.log("error");
        });
        
    });

} // if FormData is available