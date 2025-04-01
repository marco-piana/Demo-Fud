<script>
    var modalInstance;

    function openModal() {
        var modalElement = document.getElementById('authModal');

        // Initialize Bootstrap Modal with backdrop: 'static' and keyboard: false
        modalInstance = new bootstrap.Modal(modalElement, {
            backdrop: 'static',
            keyboard: false
        });

        modalInstance.show();
    }

    document.addEventListener('DOMContentLoaded', function() {
        openModal();

        function toggleForm(activeForm) {
            var forms = document.getElementsByClassName('auth-form');
            for (var form of forms) {
                form.classList.add('d-none');
            }
            document.getElementById(activeForm).classList.remove('d-none');

            var links = document.getElementsByClassName('auth-link');
            for (var link of links) {
                link.classList.remove('active');
            }
            document.getElementById(activeForm + 'Link').classList.add('active');
        }

        // Link event listeners to switch forms
        document.getElementById('loginLink').addEventListener('click', function() {
            toggleForm('loginForm');
        });
        document.getElementById('registerLink').addEventListener('click', function() {
            toggleForm('registerForm');
        });
        document.getElementById('forgotLink').addEventListener('click', function() {
            toggleForm('forgotForm');
        });
        document.getElementById('verifyLink').addEventListener('click', function() {
            toggleForm('verifyForm');
        });
    });
    // Clean up modal backdrop
    function removeModalBackdrop() {
        const backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) {
            backdrop.parentNode.removeChild(backdrop);
        }
        console.log('backdrop removed');
    }

    function handleLogin() {
        const email = $('#loginEmail').val();
        const password = $('#loginPassword').val();
        const loginBtn = document.getElementById('loginBtn');
        const errorMsg = document.getElementById('errorMsg');

        if (!email || !password) {
            $('#errorMsg').removeClass('d-none').text('Please fill in both email and password');
            return;
        }
        if (email && password) {
            try {
                loginBtn.disabled = true;
                loginBtn.innerHTML = 'Sending...';

                $.ajax({
                    url: '/userviewer/login',
                    method: 'POST',
                    data: {
                        email: email,
                        password: password,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            errorMsg.textContent = 'Login successful';
                            errorMsg.classList.remove('d-none');
                            errorMsg.classList.replace('alert-danger', 'alert-success');
                            removeModalBackdrop();
                            location.reload();
                        } else {
                            $('#errorMsg').removeClass('d-none').text(response.error);
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        $('#errorMsg').removeClass('d-none').text(
                            'Invalid credentials or user not found!');
                    }
                });
            } catch (error) {
                console.error('AJAX request failed:', error);
            } finally {

                loginBtn.disabled = false;
                loginBtn.innerHTML = 'Login';
            }

        }
    }

    function handleRegister() {

        const name = $('#registerName').val();
        const email = $('#registerEmail').val();
        const password = $('#registerPassword').val();
        const confirmPassword = $('#registerConfirmPassword').val();

        if (!name || !email || !password || !confirmPassword) {
            $('#errorMsg').removeClass('d-none').text('Please fill in all registration fields');
            return;
        }

        if (password !== confirmPassword) {
            $('#errorMsg').removeClass('d-none').text('Passwords do not match');
            return;
        }

        $.ajax({
            url: '/userviewer/register',
            method: 'POST',
            data: {
                name: name,
                email: email,
                password: password,
                company_id: {{ $restorant->id }},
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.status === 'success') {
                    removeModalBackdrop();
                    location.reload();
                } else {
                    $('#errorMsg').removeClass('d-none').text(response.message);
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                $('#errorMsg').removeClass('d-none').text('Failed registration');
            }
        });
    }

    function handleForgotPassword() {
        const email = document.getElementById('forgotEmail').value.trim();
        const errorMsg = document.getElementById('errorMsg');

        if (!email) {
            errorMsg.textContent = 'Please enter your email address.';
            errorMsg.classList.remove('d-none');
            return;
        }

        fetch('{{ route('userviewer.forgot-password') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    email
                })
            })
            .then(response => response.text()) // Get the response as plain text first
            .then(text => {
                console.log('Server Response:', text); // Log the response
                try {
                    const data = JSON.parse(text);
                    if (data.status === 'success') {
                        errorMsg.textContent = 'Password reset link sent! Please check your email.';
                        errorMsg.classList.remove('d-none');
                        errorMsg.classList.replace('alert-danger', 'alert-success');
                        location.reload();
                    } else {
                        errorMsg.textContent = data.message || 'An error occurred. Please try again.';
                        errorMsg.classList.remove('d-none');
                        errorMsg.classList.replace('alert-success', 'alert-danger');
                    }
                } catch (e) {
                    console.error('Failed to parse JSON:', e);
                    errorMsg.textContent = 'Unexpected server response. Please try again.';
                    errorMsg.classList.remove('d-none');
                }
            })
            .catch(error => {
                console.error('AJAX Error:', error);
                errorMsg.textContent = 'An error occurred. Please try again later.';
                errorMsg.classList.remove('d-none');
            });
    }

    async function resendVerification() {
        const email = document.getElementById('verifyEmail').value;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        try {
            const response = await fetch('{{ route('userviewer.resend-verification') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({
                    email
                }),
            });

            const textResponse = await response.text(); // Get response body as text
            console.log('Raw Response:', textResponse);

            try {
                const data = JSON.parse(textResponse); // Try parsing JSON
                console.log('Parsed JSON:', data);

                if (response.status == "success") {
                    errorMsg.textContent = 'Verification email sent successfully';
                    errorMsg.classList.remove('d-none');
                    errorMsg.classList.replace('alert-danger', 'alert-success');
                    location.reload();
                } else {
                    errorMsg.textContent = data.message || ' Failed to resend email verification link';
                    errorMsg.classList.remove('d-none');
                    errorMsg.classList.replace('alert-success', 'alert-danger');
                }
            } catch (parseError) {
                console.error('Parsing error:', parseError);
                errorMsg.textContent = data.message || ' Received unexpected response from the server';
                errorMsg.classList.remove('d-none');
                errorMsg.classList.replace('alert-success', 'alert-danger');
                //  alert('Received unexpected response from the server');
            }
        } catch (error) {
            console.error('AJAX Error:', error);
            alert('AJAX request failed');
        }
    }
</script>
