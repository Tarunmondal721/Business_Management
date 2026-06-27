/**
 * =====================================================
 * COMMON MULTI-LANGUAGE FORM HANDLER (FINAL + UX)
 * =====================================================
 */

(function () {

    /* ----------------------------------
     | SWITCH LANGUAGE TAB
     ---------------------------------- */
    window.switchToLang = function (lang) {

        $('.lang-link').removeClass('active');
        $('.lang-link[data-lang="' + lang + '"]').addClass('active');

        $('.lang-form').addClass('d-none');
        $('.lang-form[data-lang="' + lang + '"]').removeClass('d-none');

        if (typeof DEFAULT_LANG !== 'undefined' && lang === DEFAULT_LANG) {
            $('.from_part_2').removeClass('d-none');
        } else {
            $('.from_part_2').addClass('d-none');
        }
    };


    /* ----------------------------------
     | TAB CLICK
     ---------------------------------- */
    $(document).on('click', '.lang-link', function (e) {
        e.preventDefault();
        switchToLang($(this).data('lang'));
    });


    /* ----------------------------------
     | SHOW VALIDATION ERRORS
     | + Auto tab switch
     | + Auto scroll to error
     ---------------------------------- */
    // window.showValidationErrors = function (errors) {

    //     let firstErrorField = null;
    //     let firstLang = null;

    //     /* Reset old states */
    //     $('.text-danger').text('');
    //     $('.form-control, textarea, select').removeClass('is-invalid shake');

    //     /* Language fields first */
    //     $.each(errors, function (field, messages) {

    //         let normalized = field.replace(/\./g, '_');
    //         let $errorEl = $('.' + normalized + '_error');

    //         if (!$errorEl.length) return;

    //         $errorEl.text(messages[0]);

    //         let $input = $errorEl.closest('.lang-form')
    //             .find('input, textarea')
    //             .first();

    //         if ($input.length) {
    //             $input.addClass('is-invalid');
    //         }

    //         if (!firstErrorField && $input.length) {
    //             firstErrorField = $input;
    //             firstLang = $input.closest('.lang-form').data('lang');
    //         }
    //     });

    //     /* Switch language */
    //     if (firstLang) {
    //         switchToLang(firstLang);
    //     }

    //     /* Non-language fields */
    //     if (!firstErrorField) {
    //         $.each(errors, function (field, messages) {

    //             let normalized = field.replace(/\./g, '_');
    //             let $errorEl = $('.' + normalized + '_error');

    //             if (!$errorEl.length) return;

    //             $errorEl.text(messages[0]);

    //             let $input = $errorEl.closest('.input-style-1, .input-style-3, .select-style-1')
    //                 .find('input, textarea, select')
    //                 .first();

    //             if ($input.length) {
    //                 $input.addClass('is-invalid');
    //                 firstErrorField = $input;
    //             }
    //         });
    //     }

    //     /* Scroll + Focus + Shake */
    //     if (firstErrorField) {

    //         setTimeout(() => {

    //             $('html, body').animate({
    //                 scrollTop: firstErrorField.offset().top - 120
    //             }, 500);

    //             firstErrorField
    //                 .addClass('shake')
    //                 .trigger('focus');

    //         }, 300);
    //     }
    // };

    window.showValidationErrors = function (errors) {
        // console.log(errors);
        // Reset old errors
        $('.text-danger').text('');
        $('.form-control, textarea, select, .additional').removeClass('is-invalid');

        let firstInput = null;
        let firstLang = null;

        $.each(errors, function (field, messages) {

            let normalized = field.replace(/\./g, '_');
            let $errorEl = $('.' + normalized + '_error');

            if (!$errorEl.length) return;

            $errorEl.text(messages[0]);

            let $input = $errorEl
                .closest('.lang-form, .input-style-1, .input-style-3, .select-style-1, .select-style-2, .additional')
                .find('input, textarea, select')
                .first();

            if ($input.length) {
                $input.addClass('is-invalid');

                if (!firstInput) {
                    firstInput = $input;
                    firstLang = $input.closest('.lang-form').data('lang');
                }
            }
        });

        // Switch language tab first
        if (firstLang) {
            switchToLang(firstLang);
        }

        // Extra smooth scroll + focus
        if (firstInput) {

            setTimeout(() => {
                $('html, body').stop().animate(
                    {
                        scrollTop: firstInput.offset().top - 140
                    },
                    {
                        duration: 750,
                        easing: 'swing',
                        complete: function () {
                            // Soft focus (prevents jump)
                            setTimeout(() => {
                                firstInput.trigger('focus');
                            }, 100);
                        }
                    }
                );
            }, 250);
        }
    };







    /* ----------------------------------
     | AJAX FORM SUBMIT
     | + Disable button
     | + Please wait text
     ---------------------------------- */
    $(document).on('submit', '.ajax-form', function (e) {
        e.preventDefault();

        //  Sync TinyMCE
        if (typeof tinymce !== 'undefined') {
            tinymce.triggerSave();
        }

        let form = $(this);

        // Enable disabled fields (safe)
        form.find(':disabled').prop('disabled', false);

        let formData = new FormData(form[0]);
        console.log(formData);
        // DEBUG
        // for (let pair of formData.entries()) {
        //     console.log(pair[0], pair[1]);
        // }

        let $submitBtn = form.find('button[type="submit"]');
        let originalText = $submitBtn.text();

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            beforeSend: function () {
                $submitBtn.prop('disabled', true).text('Please wait...');
            },

            success: function (res) {
                if (res.success) {
                    showAlert('Success', res.message, 'success');
                    setTimeout(() => {
                        window.location.href = res.redirect;
                    }, 1500);
                } else if (res.errors) {
                    showValidationErrors(res.errors);
                } else if (!res.success) {
                    showAlert('Error', res.message, 'error');
                    setTimeout(() => {
                        window.location.href = res.redirect;
                    }, 1500);
                }
            },

            error: function (xhr) {
                if (xhr.status === 422) {
                    showValidationErrors(xhr.responseJSON.errors);
                } else {
                    showAlert('Error', 'Server error', 'error');
                }
            },

            complete: function () {
                $submitBtn.prop('disabled', false).text(originalText);
            }
        });
    });


})();
$(document).on('input change', '.form-control, textarea, select', function () {
    $(this)
        .removeClass('is-invalid shake')
        .closest('.input-style-1, .input-style-3, .select-style-1')
        .find('.text-danger')
        .text('');
});
const currency = window.APP_CONFIG.currency;


function formatCurrency(value) {
    if (value >= 1_000_000) {
        return currency + (value / 1_000_000)
            .toFixed(1)
            .replace(/\.0$/, '') + 'M';
    }

    if (value >= 1_000) {
        return currency + (value / 1_000)
            .toFixed(1)
            .replace(/\.0$/, '') + 'K';
    }

    return currency + value;
}





// function slugify(text) {
//     return text
//         .toString()
//         .toLowerCase()
//         .replace(/\//g, '-')
//         .trim()
//         .replace(/\s+/g, '-')
//         .replace(/[^\w\-]+/g, '')
//         .replace(/\-\-+/g, '-');

// }

function slugify(text) {
    return text
        .toString()
        .toLowerCase()
        .replace(/\//g, '-')         // replace "/" with "-"
        .trim()
        .replace(/\s+/g, '-')       // spaces → hyphen
        .replace(/[^\w\-]+/g, '')   // remove special chars
        .replace(/\-\-+/g, '-')     // remove duplicate "-"
        .replace(/^-+|-+$/g, '');   // trim "-"
}

let slugManuallyEdited = false;

// Detect manual slug edit
$(document).on('input', 'input[name="slug"]', function () {
    slugManuallyEdited = true;
});

// Auto update slug from name
$(document).on('input', 'input[name="name[]"]', function () {
    if (slugManuallyEdited) return;

    let name = $(this).val();
    $('input[name="slug"]').val(slugify(name));
});

$(document).on('input', 'input[name="name"]', function () {
    if (slugManuallyEdited) return;

    let name = $(this).val();
    $('input[name="slug"]').val(slugify(name));
});










