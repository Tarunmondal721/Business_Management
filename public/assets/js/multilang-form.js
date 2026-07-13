document.addEventListener('DOMContentLoaded', function () {

    $(document).on('submit', '.ajax-form', function (e) {
        e.preventDefault();
        console.log('form submitted');
        let form = $(this);

        // TinyMCE sync (only if exists)
        if (typeof tinymce !== 'undefined') {
            tinymce.triggerSave();
        }

        // Enable disabled fields
        form.find(':disabled').prop('disabled', false);

        let formData = new FormData(this);

        let $submitBtn = form.find('[type="submit"]');
        let originalText = $submitBtn.html();

        // Clear old errors
        form.find('.text-danger').html('');

        $.ajax({
            url: form.attr('action'),
            type: form.attr('method') || 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            },

            beforeSend: function () {
                $submitBtn.prop('disabled', true).html('Please wait...');
            },

            success: function (res) {
                console.log('yreeuyreruy', res.success);
                if (res.success == 1) {
                    showAlert('Success', res.message, 'success');
                    $('#forgotModal').modal('hide');

                    $('#forgotStepEmail').hide();

                    // Reset form (optional global behavior)
                    form[0].reset();

                    if (res.redirect) {
                        setTimeout(() => {
                            window.location.href = res.redirect;
                        }, 1500);
                    }
                } else if (res.errors) {
                    showValidationErrors(res.errors, form);
                } else {
                    showAlert('', res.message, 'error' || 'Something went wrong');
                    if (res.redirect) {
                        setTimeout(() => {
                            window.location.href = res.redirect;
                        }, 1500);
                    }
                }
            },

            error: function (xhr) {

                console.log('Status:', xhr.status);
                console.log('Response Text:', xhr.responseText);
                console.log('Response JSON:', xhr.responseJSON);

                if (xhr.status === 422) {
                    showValidationErrors(xhr.responseJSON.errors, form);
                } else {
                    showAlert('', 'Something went wrong', 'error');
                }
            },

            complete: function () {
                $submitBtn.prop('disabled', false).html(originalText);
            }
        });
    });

    function showValidationErrors(errors, form) {

        // Clear old errors
        form.find('.text-danger').html('');

        $.each(errors, function (key, value) {

            if (key.indexOf('.') !== -1) {

                let parts = key.split('.');

                let field = parts[0];
                let index = parts[1];

                // Departure Table
                if (field.startsWith('departure_')) {

                    $('#departureFishTable tbody tr')
                        .eq(index)
                        .find('.' + field + '_error')
                        .html(value[0]);

                }
                // Bill Table
                else if (field.startsWith('bill_')) {

                    $('#billFishTable tbody tr')
                        .eq(index)
                        .find('.' + field + '_error')
                        .html(value[0]);

                }

            } else {

                form.find('.' + key + '_error').html(value[0]);

            }

        });

    }

    $(document).on('click', '#resetForm', function () {

        const form = $('.ajax-form')[0];

        // Reset all form fields
        form.reset();

        // Clear validation errors
        $('.text-danger').html('');

        // Reset image preview
        $('#imagePreview')
            .attr('src', asset("assets/images/img/400x400/img2.jpg")); // Change to your default image

        // If using Select2
        $('select').trigger('change');

        // If using TinyMCE
        if (typeof tinymce !== 'undefined') {
            tinymce.triggerSave();
            tinymce.editors.forEach(function (editor) {
                editor.setContent('');
            });
        }
    });
});
