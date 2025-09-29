@extends('layouts.front')

@section('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@100;200;300;400;500;600;700&display=swap');
    </style>
    <style>
        form {
            width: 50%;
            margin: 40px auto 80px;
            max-width: 400px;
            text-align: right;
            font-family: 'IBM Plex Sans Arabic', sans-serif;
        }

        @media(max-width: 480px) {
            form {
                width: 80%;
            }

            #map {
                height: 300px;
                width: 95%;
                margin: auto;
            }
        }

        .input-group {
            width: 100%;
            font-size: 16px;
            max-width: 400px;
            position: relative;
            margin: auto;
            margin-bottom: 20px;
            text-align: right;
            direction: rtl;
            font-family: 'IBM Plex Sans Arabic', sans-serif;

            input,
            textarea {
                width: 100%;
                color: #010101;
                border: none;
                outline: none;
                line-height: 1;
                padding: 5px 0;
                padding-left: 20px;
                font-size: 16px;
                border-bottom: solid 1px #010101;
                background-color: transparent;
                transition: all 0.2s ease-in;
                font-weight: 400;
                text-align: right;
                direction: rtl;

                +label {
                    right: 10px;
                    top: -5px;
                    position: absolute;
                    pointer-events: none;
                    transition: all 0.2s ease-in;
                    text-align: right;
                    direction: rtl;
                }

                &:focus {
                    box-shadow: 0 1px 0 0 #010101;
                }

                &:focus,
                &.active {
                    +label {
                        font-size: 12px;
                        transform: translate(10px, -12px);
                    }
                }

            }

            /* Phone input with prefix styling */
            &.phone-input {
                input {
                    padding-left: 60px;
                    /* Make space for the +966 prefix */


                    &:focus,
                    &.active {
                        +label {
                            font-size: 12px;
                            transform: translate(10px, -12px);
                        }
                    }

                }

                label {
                    right: 10px;
                    top: -5px;
                    position: absolute;
                    pointer-events: none;
                    transition: all 0.2s ease-in;
                    text-align: right;
                    direction: rtl;
                }

                input:focus &input:active {

                    +label {
                        font-size: 12px;
                        transform: translate(10px, -12px);
                    }

                    .phone-prefix {
                        position: absolute;
                        left: 10px;
                        top: 5px;
                        color: #010101;
                        font-size: 16px;
                        font-weight: 400;
                        pointer-events: none;
                        user-select: none;
                        direction: ltr;
                        z-index: 1;
                    }
                }

                textarea {

                    &:focus {
                        box-shadow: 0px 0px 0px 1px #010101;
                    }

                    &:focus,
                    &.active {
                        height: 100px;
                        margin-top: 10px;
                        padding-left: 10px;
                        border: solid 1px #010101;
                    }
                }
            }

            .message-send {
                border: none;
                font-size: 18px;
                color: #010101;
                cursor: pointer;
                display: flex;
                font-weight: 500;
                float: left;
                padding: 0;
                font-family: 'IBM Plex Sans Arabic', sans-serif;

            }

            .message-send svg {
                transition: all 0.2s ease-in;
                transform: rotate(180deg)
            }

            .message-send:hover svg {
                transform: rotate(180deg)
            }

            /* Custom Google Maps Info Window Styling */
            .gm-style .gm-style-iw {
                padding: 0 !important;
            }

            .gm-style .gm-style-iw-d {
                overflow: visible !important;
            }

            .gm-style .gm-style-iw-c {
                padding: 0 !important;
                border-radius: 8px !important;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
            }

            .gm-style .gm-style-iw-tc {
                display: none !important;
            }

            .gm-style .gm-style-iw button {
                display: none !important;
            }

            /* Success Modal Styles */
            .success-modal {
                display: none;
                position: fixed;
                z-index: 9999;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                backdrop-filter: blur(5px);
                animation: fadeIn 0.3s ease-in-out;
            }

            .success-modal.show {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .modal-content {
                background-color: white;
                padding: 40px;
                border-radius: 15px;
                text-align: center;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
                max-width: 400px;
                width: 90%;
                animation: slideIn 0.4s ease-out;
                position: relative;
            }

            .success-icon {
                width: 80px;
                height: 80px;
                background-color: #003cfc;
                border-radius: 50%;
                margin: 0 auto 20px;
                display: flex;
                align-items: center;
                justify-content: center;
                animation: bounce 0.6s ease-in-out;
            }

            .success-icon svg {
                width: 40px;
                height: 40px;
                fill: white;
            }

            .success-message {
                font-size: 18px;
                color: #333;
                margin-bottom: 10px;
                font-weight: 500;
                font-family: 'IBM Plex Sans Arabic', sans-serif;
            }

            .success-submessage {
                font-size: 14px;
                color: #666;
                margin-bottom: 20px;
                font-family: 'IBM Plex Sans Arabic', sans-serif;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                }

                to {
                    opacity: 1;
                }
            }

            @keyframes slideIn {
                from {
                    transform: translateY(-50px);
                    opacity: 0;
                }

                to {
                    transform: translateY(0);
                    opacity: 1;
                }
            }

            @keyframes bounce {

                0%,
                20%,
                50%,
                80%,
                100% {
                    transform: translateY(0);
                }

                40% {
                    transform: translateY(-10px);
                }

                60% {
                    transform: translateY(-5px);
                }
            }

            .form-loading {
                opacity: 0.6;
                pointer-events: none;
            }

            .loading-spinner {
                display: none;
                width: 20px;
                height: 20px;
                border: 2px solid #f3f3f3;
                border-top: 2px solid #010101;
                border-radius: 50%;
                animation: spin 1s linear infinite;
                margin-left: 10px;
            }

            @keyframes spin {
                0% {
                    transform: rotate(0deg);
                }

                100% {
                    transform: rotate(360deg);
                }
            }

            /* Error Modal Styles */
            .error-modal {
                display: none;
                position: fixed;
                z-index: 9999;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                backdrop-filter: blur(5px);
                animation: fadeIn 0.3s ease-in-out;
            }

            .error-modal.show {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .error-modal .modal-content {
                background-color: white;
                padding: 40px;
                border-radius: 15px;
                text-align: center;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
                max-width: 400px;
                width: 90%;
                animation: slideIn 0.4s ease-out;
                position: relative;
            }

            .error-icon {
                width: 80px;
                height: 80px;
                background-color: #dc3545;
                border-radius: 50%;
                margin: 0 auto 20px;
                display: flex;
                align-items: center;
                justify-content: center;
                animation: shake 0.6s ease-in-out;
            }

            .error-icon svg {
                width: 40px;
                height: 40px;
                fill: white;
            }

            .error-message {
                font-size: 18px;
                color: #333;
                margin-bottom: 10px;
                font-weight: 500;
                font-family: 'IBM Plex Sans Arabic', sans-serif;
            }

            .error-submessage {
                font-size: 14px;
                color: #666;
                margin-bottom: 20px;
                font-family: 'IBM Plex Sans Arabic', sans-serif;
            }

            @keyframes shake {

                0%,
                100% {
                    transform: translateX(0);
                }

                10%,
                30%,
                50%,
                70%,
                90% {
                    transform: translateX(-5px);
                }

                20%,
                40%,
                60%,
                80% {
                    transform: translateX(5px);
                }
            }

            .modal-close-btn {
                background-color: #dc3545;
                color: white;
                border: none;
                padding: 10px 20px;
                border-radius: 5px;
                cursor: pointer;
                font-size: 14px;
                transition: background-color 0.3s ease;
                font-family: 'IBM Plex Sans Arabic', sans-serif;
            }

            .modal-close-btn:hover {
                background-color: #c82333;
            }
    </style>
@endsection

@section('content')
    <div id="page">
        <section class="svg-header contact-header">
            <div class="svgh-bh">
                <div id="svg-animaiotn" class="inview flex flex--bottom">
                    <div class="js-parallaxheader">
                        <svg class="deaw studio contact" id="Layer_1" data-name="Layer 1"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 383.19 391.63">
                            <defs>
                                <style>
                                    .cls-1 {
                                        fill: none;
                                        stroke: #212120;
                                        stroke-miterlimit: 10;
                                        stroke-width: 2px;
                                    }
                                </style>
                            </defs>
                            <path class="cls-1"
                                d="m336.44,233.26c-15.09-1.71-64.12-21.03-101.51-31.75-8.64-2.46-16.62-4.47-23.45-5.7,6.83-1.23,14.82-3.24,23.45-5.7,37.42-10.65,86.45-29.97,101.51-31.75,17.26-2.15,32.54-6.03,45.56-11.66-1.99-8.11-4.63-16.1-7.82-23.96-5.7-7.22-10.86-14.93-15.57-23.08-4.63-8.02-8.61-16.32-11.87-24.77-5.37-6.96-11.16-13.41-17.3-19.39-11.42,8.39-22.38,19.75-32.98,33.59-9.03,12.22-50.28,45.02-78.25,72.04-6.45,6.25-12.18,12.16-16.67,17.46,2.35-6.53,4.6-14.45,6.79-23.16,9.49-37.73,17.27-89.86,23.26-103.78,6.77-16.03,11.05-31.2,12.68-45.28-8.01-2.33-16.26-4.05-24.66-5.21-9.1,1.32-18.36,1.94-27.77,1.94s-18.44-.7-27.38-2.1c-8.71,1.17-17.19,2.96-25.44,5.29,1.56,14.08,5.91,29.25,12.6,45.36,6.07,13.93,13.85,66.05,23.26,103.78,2.19,8.71,4.44,16.63,6.79,23.16-4.49-5.3-10.22-11.21-16.67-17.46-27.93-27.09-69.18-59.88-78.25-72.04-10.49-13.88-21.49-25.17-32.87-33.62-6.03,5.77-11.63,12.06-16.84,18.75-3.41,8.54-7.5,16.87-12.2,25.02-4.63,8.02-9.82,15.62-15.51,22.67-3.35,8.13-6.04,16.37-8.14,24.68,12.97,5.69,28.29,9.5,45.58,11.76,15.09,1.71,64.12,21.03,101.51,31.74,8.64,2.46,16.62,4.47,23.46,5.7-6.83,1.23-14.82,3.24-23.45,5.7-37.42,10.65-86.45,29.97-101.51,31.75-17.26,2.15-32.54,6.03-45.56,11.66,1.99,8.11,4.63,16.11,7.82,23.96,5.7,7.22,10.86,14.93,15.57,23.08,4.63,8.02,8.61,16.32,11.87,24.77,5.37,6.96,11.16,13.41,17.3,19.39,11.42-8.39,22.37-19.75,32.98-33.59,9.03-12.22,50.28-45.02,78.25-72.04,6.45-6.25,12.18-12.16,16.67-17.46-2.35,6.53-4.6,14.45-6.79,23.16-9.49,37.73-17.27,89.85-23.26,103.78-6.77,16.03-11.05,31.2-12.68,45.28,8.01,2.33,16.26,4.05,24.66,5.21,9.1-1.32,18.36-1.95,27.77-1.95s18.44.7,27.39,2.1c8.71-1.17,17.19-2.95,25.44-5.29-1.56-14.08-5.91-29.25-12.6-45.36-6.07-13.93-13.85-66.05-23.26-103.78-2.19-8.71-4.44-16.63-6.79-23.16,4.49,5.3,10.22,11.21,16.67,17.46,27.93,27.09,69.18,59.88,78.25,72.04,10.49,13.88,21.5,25.17,32.87,33.62,6.03-5.77,11.63-12.06,16.84-18.75,3.41-8.54,7.5-16.87,12.2-25.02,4.63-8.02,9.82-15.62,15.51-22.67,3.35-8.13,6.04-16.37,8.14-24.68-12.97-5.69-28.29-9.5-45.58-11.76Z" />
                        </svg>
                    </div>
                </div>
                <div class="grid-width svgh-bh flex text-center">
                    <div class="js-parallaxheader-text">
                        <div class="subline inview inview--up">(سجل بياناتك)</div>
                        <h2 class="inview inview--up">عرض اليوم الوطنى</h2>
                    </div>
                </div>
            </div>
        </section>

        <section class="contact-form">
            <form id="dataForm" action="{{ route('send data') }}" method="POST">
                @csrf
                <div class="input-group">
                    <input type="text" id="name" name="name" onblur="checkInput(this)" required>
                    <label for="name">الاسم</label>
                </div>
                <div class="input-group phone-input">
                    <input type="tel" name="mobile" id="mobile" onblur="checkInput(this)" required>
                    <span class="phone-prefix">+966</span>
                    <label for="mobile">رقم الجوال</label>
                </div>
                <div class="input-group">
                    <input type="email" name="email" id="email" onblur="checkInput(this)">
                    <label for="email">البريد الالكتروني</label>
                </div>
                <div class="input-group">
                    <textarea name="message" id="message" onblur="checkInput(this)" required></textarea>
                    <label for="message">استشارتك</label>
                </div>
                <button type="submit" class="message-send"><svg style="margin-top: -3px; margin-left:5px"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24">
                        <path d="M7.293 4.707 14.586 12l-7.293 7.293 1.414 1.414L17.414 12 8.707 3.293 7.293 4.707z" />
                    </svg>ارسال استشارتك
                    <div class="loading-spinner"></div>

                </button>
            </form>

        </section>

        <!-- Success Modal -->
        <div id="successModal" class="success-modal">
            <div class="modal-content">
                <div class="success-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z" />
                    </svg>
                </div>
                <div class="success-message">تم إرسال استشارتك بنجاح!</div>
                <div class="success-submessage">سيتم التواصل معكم خلال 24 ساعة</div>
            </div>
        </div>

        <!-- Error Modal -->
        <div id="errorModal" class="error-modal">
            <div class="modal-content">
                <div class="error-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path
                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"
                            fill="none" />
                        <path
                            d="M15.73 3H8.27L3 8.27v7.46L8.27 21h7.46L21 15.73V8.27L15.73 3zM12 17.3c-.72 0-1.3-.58-1.3-1.3s.58-1.3 1.3-1.3 1.3.58 1.3 1.3-.58 1.3-1.3 1.3zm1-4.3h-2V7h2v6z" />
                    </svg>
                </div>
                <div class="error-message">فشل في إرسال الاستشارة!</div>
                <div class="error-submessage" id="errorText">حدث خطأ أثناء إرسال الرسالة. يرجى المحاولة مرة أخرى.</div>
                <button class="modal-close-btn" onclick="hideErrorModal()">حسناً</button>
            </div>
        </div>

    </div><!-- /page -->
@endsection

@section('js')
    <script>
        let checkInput = function(input) {
            if (input.value.length > 0) {
                input.className = 'active';
            } else {
                input.className = '';
            }
        };

        // AJAX Form Submission
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('dataForm');
            const submitButton = form.querySelector('.message-send');
            const loadingSpinner = submitButton.querySelector('.loading-spinner');
            const successModal = document.getElementById('successModal');
            const errorModal = document.getElementById('errorModal');
            const errorText = document.getElementById('errorText');

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                // Show loading state
                form.classList.add('form-loading');
                loadingSpinner.style.display = 'inline-block';
                submitButton.disabled = true;

                // Get form data
                const formData = new FormData(form);

                // Send AJAX request
                fetch('{{ route('send data') }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                ?.getAttribute('content') || document.querySelector(
                                    'input[name="_token"]').value
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Hide loading state
                        form.classList.remove('form-loading');
                        loadingSpinner.style.display = 'none';
                        submitButton.disabled = false;

                        if (data.success) {
                            // Show success modal
                            successModal.classList.add('show');

                            // Reset form
                            form.reset();

                            // Remove active classes from inputs
                            form.querySelectorAll('input, textarea').forEach(input => {
                                input.className = '';
                            });

                            // Auto-hide modal after 4 seconds
                            setTimeout(() => {
                                hideModal();
                            }, 10000);
                        } else {
                            // Show error modal
                            errorText.textContent = data.message ||
                                'حدث خطأ أثناء إرسال الرسالة. يرجى المحاولة مرة أخرى.';
                            errorModal.classList.add('show');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);

                        // Hide loading state
                        form.classList.remove('form-loading');
                        loadingSpinner.style.display = 'none';
                        submitButton.disabled = false;

                        // Show error modal
                        errorText.textContent = 'حدث خطأ أثناء إرسال الرسالة. يرجى المحاولة مرة أخرى.';
                        errorModal.classList.add('show');
                    });
            });

            // Function to hide success modal
            function hideModal() {
                successModal.classList.remove('show');
            }

            // Function to hide error modal
            window.hideErrorModal = function() {
                errorModal.classList.remove('show');
            }

            // Hide modals when clicking outside
            successModal.addEventListener('click', function(e) {
                if (e.target === successModal) {
                    hideModal();
                }
            });

            errorModal.addEventListener('click', function(e) {
                if (e.target === errorModal) {
                    hideErrorModal();
                }
            });

            // Hide modals on escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    if (successModal.classList.contains('show')) {
                        hideModal();
                    }
                    if (errorModal.classList.contains('show')) {
                        hideErrorModal();
                    }
                }
            });
        });
    </script>
@endsection
