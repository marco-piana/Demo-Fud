@extends('layouts.app', ['class' => 'bg-default'])

@section('content')
    <style>
        .h2 {
            color: #fff;
        }
    </style>
    <div class="container py-8">
        <h2>Reset Password</h2>

        <div id="errorMsg" class="alert alert-danger d-none"></div>
        <div id="successMsg" class="alert alert-success d-none"></div>

        <form id="resetPasswordForm">
            @csrf
            <input id="token" type="hidden" name="token" value="{{ $token }}">

            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" placeholder="Enter your email" required
                    class="form-control">
            </div>

            <div class="form-group">
                <label for="password">New Password</label>
                <input id="password" type="password" placeholder="Enter new password" name="password" required
                    class="form-control">
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input id="password_confirmation" type="password" placeholder="Confirm password"
                    name="password_confirmation" required class="form-control">
            </div>

            <button type="button" class="btn btn-primary mt-2 w-100" onclick="resetPassword()">Reset Password</button>
        </form>
    </div>

    <script>
        async function resetPassword() {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const passwordConfirmation = document.getElementById('password_confirmation').value;
            const token = document.getElementById('token').value;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            console.log('Reset Password:', password, passwordConfirmation);

            try {
                const response = await fetch('{{ route('userviewer.reset-newpassword') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({
                        email: email,
                        password: password,
                        password_confirmation: passwordConfirmation, // Include confirmation field
                        token: token
                    })
                });

                const textResponse = await response.text();
                console.log('Raw Response:', textResponse);

                const data = JSON.parse(textResponse);
                console.log('Parsed JSON:', data);

                if (response.ok) {
                    const successMsg = document.getElementById('successMsg');
                    successMsg.textContent = data.message;
                    successMsg.classList.remove('d-none');
                    document.getElementById('resetPasswordForm').reset();
                } else {
                    const errorMsg = document.getElementById('errorMsg');
                    errorMsg.textContent = data.message || 'Something went wrong';
                    errorMsg.classList.remove('d-none');
                }
            } catch (error) {
                console.error('AJAX Error:', error);
            }
        }
    </script>

    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
