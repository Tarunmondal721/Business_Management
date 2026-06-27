(function () {
    /* ========= Preloader ======== */
    const preloader = document.querySelectorAll('#preloader')

    window.addEventListener('load', function () {
        if (preloader.length) {
            this.document.getElementById('preloader').style.display = 'none'
        }
    })

    /* ========= Add Box Shadow in Header on Scroll ======== */
    window.addEventListener('scroll', function () {
        const header = document.querySelector('.header')
        if (window.scrollY > 0) {
            header.style.boxShadow = '0px 0px 30px 0px rgba(200, 208, 216, 0.30)'
        } else {
            header.style.boxShadow = 'none'
        }
    })

    /* ========= sidebar toggle ======== */
    const sidebarNavWrapper = document.querySelector(".sidebar-nav-wrapper");
    const mainWrapper = document.querySelector(".main-wrapper");
    const menuToggleButton = document.querySelector("#menu-toggle");
    const menuToggleButtonIcon = document.querySelector("#menu-toggle i");
    const overlay = document.querySelector(".overlay");

    menuToggleButton.addEventListener("click", () => {
        sidebarNavWrapper.classList.toggle("active");
        overlay.classList.add("active");
        mainWrapper.classList.toggle("active");

        if (document.body.clientWidth > 1200) {
            if (menuToggleButtonIcon.classList.contains("lni-chevron-left")) {
                menuToggleButtonIcon.classList.remove("lni-chevron-left");
                menuToggleButtonIcon.classList.add("lni-menu");
            } else {
                menuToggleButtonIcon.classList.remove("lni-menu");
                menuToggleButtonIcon.classList.add("lni-chevron-left");
            }
        } else {
            if (menuToggleButtonIcon.classList.contains("lni-chevron-left")) {
                menuToggleButtonIcon.classList.remove("lni-chevron-left");
                menuToggleButtonIcon.classList.add("lni-menu");
            }
        }
    });
    overlay.addEventListener("click", () => {
        sidebarNavWrapper.classList.remove("active");
        overlay.classList.remove("active");
        mainWrapper.classList.remove("active");
    });

    //    window.showValidationErrors = (errors) => {
    //         for (const key in errors) {
    //             $(`.${key}_error`).html(errors[key]);
    //         }
    //     }

    // window.showValidationErrors = (errors) => {

    //     $('.error').html(''); // clear old errors

    //     for (const key in errors) {

    //         // Laravel keys → CSS safe class
    //         // name.0 → name_0
    //         // meta_title.1 → meta_title_1
    //         let normalizedKey = key.replace(/\./g, '_');

    //         // Show first error message
    //         $(`.${normalizedKey}_error`).html(errors[key][0]);
    //     }
    // };

// window.showValidationErrors = function (errors) {

//     // Clear old errors
//     $('small.text-danger').html('');

//     let firstErrorIndex = null;

//     $.each(errors, function (field, messages) {

//         // name.0 → name_0_error
//         let errorClass = field.replace('.', '_') + '_error';
//         $('.' + errorClass).html(messages[0]);

//         // Extract index (0,1,2...)
//         let match = field.match(/\.(\d+)/);
//         if (match && firstErrorIndex === null) {
//             firstErrorIndex = match[1];
//         }
//     });

//     // Switch to first error language tab
//     if (firstErrorIndex !== null) {
//         switchToLangTabByIndex(firstErrorIndex);
//     }
// };

// window.switchToLangTabByIndex = function (index) {

//     $('.lang-link').removeClass('active');
//     $('.lang-form').addClass('d-none');
//     $('#meta-en, #meta-ar').addClass('d-none');
//     $('#meta-desc-en, #meta-desc-ar').addClass('d-none');
//     $('#meta-key-en, #meta-key-ar').addClass('d-none');

//     let $tab = $('.lang-link').eq(index);
//     if (!$tab.length) return;

//     $tab.addClass('active');
//     let lang = $tab.data('lang');

//     $('#lang-' + lang).removeClass('d-none');
//     $('#meta-' + lang).removeClass('d-none');
//     $('#meta-desc-' + lang).removeClass('d-none');
//     $('#meta-key-' + lang).removeClass('d-none');

//     if (lang === 'en') {
//         $('.from_part_2').removeClass('d-none');
//     } else {
//         $('.from_part_2').addClass('d-none');
//     }
// };







    window.showAlert = (title = '', html = '', icon = 'success') => {
        Swal.fire({
            title: title,
            text: html,
            icon: icon
        });
    }
})();
