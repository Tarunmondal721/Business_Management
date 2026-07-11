<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">


    {{-- <link rel="shortcut icon" href="{{ asset('storage/admin/favicon/' . $favicon) }}" type="image/x-icon" /> --}}
    <title>@yield('title', env('APP_NAME'))</title>


    <!-- ========== All CSS files linkup ========= -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}
	" />
    <link rel="stylesheet" href="{{ asset('assets/css/lineicons.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/css/materialdesignicons.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/css/fullcalendar.css') }}" />
    {{-- <link rel="stylesheet" href="assets/css/fullcalendar.css" /> --}}
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/quill/bubble.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/quill/snow.css') }}">

    {{-- <link rel="stylesheet" href="{{ asset('assets/css/pos.css') }}"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/2.3.8/css/dataTables.bootstrap5.css"> --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.8/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- ========= All Javascript files linkup ======== -->
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script> --}}
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{ asset('tinymce/tinymce.min.js') }}"></script>
    <!-- SweetAlert2 -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
    <script src="{{ asset('assets/js/sweetalert.js') }}"></script>

    <style>
        .dataTables_filter,
        .dataTables_paginate {
            margin-top: -31px !important;
        }
    </style>
    @stack('css_or_js')
</head>

<body>
    <!-- ======== Preloader =========== -->
    <div id="preloader">
        <div class="spinner"></div>
    </div>
    <!-- ======== Preloader =========== -->


    <!-- ======== sidebar-nav start =========== -->

    @include('layouts.admin.sidebar')
    <!-- ======== sidebar-nav end =========== -->


    <!-- ======== main-wrapper start =========== -->
    <main class="main-wrapper">
        <!-- ========== header start ========== -->
        @include('layouts.admin.header')
        <!-- ========== header end ========== -->

        <!-- ========== section start ========== -->
        @yield('content')
        <!-- ========== section end ========== -->

        <!-- ========== footer start =========== -->


            @include('layouts.admin.footer')

        <!-- ========== footer end =========== -->
    </main>
    <!-- ======== main-wrapper end =========== -->

    <!-- ========= Toasts  ======== -->
    {{-- @include('partials.toasts') --}}

    {!! Toastr::message() !!}



    @if ($errors->any())
        <script>
            @foreach ($errors->all() as $error)

                toastr.error('{{ $error }}', Error, {

                    CloseButton: true,

                    ProgressBar: true

                });
            @endforeach
        </script>
    @endif
    <!-- ========= All Javascript files linkup ======== -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/js/dynamic-pie-chart.js') }}"></script>
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/fullcalendar.js') }}"></script>
    <script src="{{ asset('assets/js/jvectormap.min.js') }}"></script>
    <script src="{{ asset('assets/js/world-merc.js') }}"></script>
    <script src="{{ asset('assets/js/polyfill.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/quill.js') }}"></script>
    <script src="{{ asset('assets/js/pdf.js') }}"></script>




    {{-- <script>
        window.APP_CONFIG = {
            currency: "{{ currency_symbols() }}"
        };
    </script> --}}
    <script src="{{ asset('assets/js/multilang-form.js') }}"></script>

    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    {{-- <script src="https://cdn.datatables.net/2.3.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.3.8/js/dataTables.bootstrap5.js"></script> --}}
    <script src="https://cdn.datatables.net/2.3.8/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.3.8/js/dataTables.bootstrap5.min.js"></script>
    {{-- PayPal SDK --}}
    {{-- @php
            $paypalConfig = \App\Models\BusinessSetting::where('type', 'paypal')->first();
            $clientId = $paypalConfig->value['paypal_client_id'] ?? env('PAYPAL_CLIENT_ID') ;

            $stripeConfig = \App\Models\BusinessSetting::where('type', 'stripe')->first();
            $stripeKey = $stripeConfig->value['api_key'] ?? env('STRIPE_KEY');
        @endphp --}}
    {{-- @if ($clientId)
        <script
            src="https://www.paypal.com/sdk/js?client-id={{ $clientId }}&currency={{ currency_code() }}">
        </script>
    @endif

<script src="https://js.stripe.com/v3/"></script> --}}

    {{-- <script>
const stripe = Stripe("{{ $stripeKey }}");
const elements = stripe.elements();
const card = elements.create("card");
card.mount("#card-element");
</script> --}}


    {{-- Page-level Scripts --}}
    <script>
        const originalFetch = window.fetch;

        window.fetch = function(...args) {
            return originalFetch(...args).then(response => {

                if (response.status === 419) {
                    window.location.href = "{{ route('admin.logout') }}";
                    return Promise.reject('Session expired');
                }

                return response;
            });
        };
    </script>


    <script>
        $(document).ajaxError(function(event, xhr) {
            if (xhr.status === 419) {
                window.location.href = "{{ route('admin.logout') }}";
            }
        });
    </script>

    {{-- <script>
        // POS idle auto logout (1 hours)
        let idleTimer;

        const resetIdleTimer = () => {
            clearTimeout(idleTimer);
            idleTimer = setTimeout(() => {
                window.location.href = "{{ route('admin.logout') }}";
            }, 60 * 60 * 1000); // 1 hour
        };

        // Track user activity
        ['mousemove', 'keydown', 'click', 'touchstart'].forEach(event => {
            document.addEventListener(event, resetIdleTimer);
        });

        // Start timer immediately
        resetIdleTimer();
    </script> --}}

    @stack('scripts')

    <script>
        document.getElementById('statusSwitch')?.addEventListener('change', function() {
            this.nextElementSibling.textContent = this.checked ?
                "{{ trans('messages.Active') }}" :
                "{{ trans('messages.Inactive') }}";
        });
    </script>


    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (input.type === "password") {
                input.type = "text";

                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');

            } else {
                input.type = "password";
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');

            }
        }




        $(document).on('change', '#customFileUpload', function() {
            const file = this.files[0];

            if (file) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    $('#viewer').attr('src', e.target.result);
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
    {{-- <script>
        tinymce.init({
            selector: '.tinymce-editor',
            license_key: 'gpl', // <-- Required for open-source version
            height: 300,
            branding: false,

            plugins: 'link lists table code',
            toolbar: 'undo redo | bold italic | bullist numlist | link',
        });
    </script> --}}

    {{-- <script>
        tinymce.init({
            selector: '.tinymce-editor',
            license_key: 'gpl',
            height: 400,
            branding: false,
            menubar: true,

            plugins: [
                'advlist autolink lists link image charmap preview anchor',
                'searchreplace visualblocks  fullscreen',
                'insertdatetime media table help wordcount',
                'emoticons directionality',

            ],

            toolbar: `
        undo redo | blocks fontfamily fontsize |
        bold italic underline strikethrough |
        forecolor backcolor |
        alignleft aligncenter alignright alignjustify |
        bullist numlist outdent indent |
        link image media table |
        emoticons charmap  |
        preview fullscreen
      `,

            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
        });
    </script> --}}

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            document.querySelectorAll('.quill-editor').forEach(function(editor) {

                let hiddenInput = editor.nextElementSibling;

                let quill = new Quill(editor, {
                    theme: 'snow',
                    placeholder: 'Enter Description.....',
                    modules: {
                        toolbar: [
                            [{
                                'font': []
                            }],
                            [{
                                'size': []
                            }],
                            [{
                                'header': [1, 2, 3, 4, 5, 6, false]
                            }],
                            ['bold', 'italic', 'underline', 'strike'],
                            [{
                                'color': []
                            }, {
                                'background': []
                            }],
                            [{
                                'script': 'sub'
                            }, {
                                'script': 'super'
                            }],
                            [{
                                'list': 'ordered'
                            }, {
                                'list': 'bullet'
                            }],
                            [{
                                'indent': '-1'
                            }, {
                                'indent': '+1'
                            }],
                            [{
                                'direction': 'rtl'
                            }],
                            [{
                                'align': []
                            }],
                            ['link', 'image', 'video'],
                            ['blockquote', 'code-block'],
                            ['clean']
                        ]
                    }
                });

                //  Show edit value properly
                if (hiddenInput.value.trim() !== '') {
                    quill.clipboard.dangerouslyPasteHTML(hiddenInput.value);
                }

                //  Sync on change
                quill.on('text-change', function() {
                    hiddenInput.value = quill.root.innerHTML;
                });

                // Sync before submit
                // editor.closest('form').addEventListener('submit', function() {
                //     hiddenInput.value = quill.root.innerHTML;
                // });

                editor.closest('form').addEventListener('submit', function() {
                    let html = quill.root.innerHTML;

                    hiddenInput.value = (html === '<p><br></p>') ? '' : html;
                });

            });

        });
    </script>


</body>

</html>
