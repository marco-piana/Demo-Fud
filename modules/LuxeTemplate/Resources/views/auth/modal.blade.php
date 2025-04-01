<!-- Bootstrap Modal -->
<div class="modal" id="authModal" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="authModalLabel">Authentication</h5>
            </div>
            <div class="modal-body">
                <div id="loading" class="text-center d-none">
                    <img src="{{ url('/images/loader.gif') }}" alt="Loading..." width="50" height="50">
                </div>
                <div id="errorMsg" class="alert alert-danger d-none"></div>
                <!-- Navigation Links -->
                <div id="authLinks" class="mb-3">
                    <a href="#" id="loginLink" class="auth-link active">{{ __('Login') }}</a>
                    <a href="#" id="registerLink" class="auth-link">{{ __('Register') }}</a>
                </div>

                <div id="loginForm" class="auth-form py-2">
                    <h5 class="py-2">{{ __('Login to access the Restaurant menu') }}</h5>
                    <small>{{ __('Sign in to your account to explore our delicious restaurant menu and discover your next favorite meal. Dont miss out on exclusive dishes and specials!') }}</small>
                    
                    <input id="loginEmail" type="email" placeholder="Email" class="form-control mb-2 mt-2" required>
                    <input id="loginPassword" type="password" placeholder="Password" class="form-control mb-2" required>
                    <button id="loginBtn" type="button" class="btn btn-primary w-100 mt-2" onclick="handleLogin()">
                        {{ __('Login') }}
                    </button>
                    <div class="py-6">
                        <a href="#" id="forgotLink" class="auth-link">{{ __('Forgot Password') }}</a>
                        <a href="#" id="verifyLink" class="auth-link">{{ __('Resend Email Verification') }}</a>
                    </div>
                </div>

                <div id="registerForm" class="auth-form d-none py-2">
                    <h5 class="py-2">{{ __('Register to access the Restaurant menu') }}</h5>
                    <small>{{ __('Create an account to explore our restaurant menu, enjoy personalized recommendations, and stay updated with exclusive offers and specials.') }}</small>
                    <input id="registerName" type="name" placeholder="Name" class="form-control mb-2 mt-2" required>
                    <input id="registerEmail" type="email" placeholder="Email" class="form-control mb-2" required>
                    <input id="registerPassword" type="password" placeholder="Password" class="form-control mb-2"
                        required>
                    <input id="registerConfirmPassword" type="password" placeholder="Confirm Password"
                        class="form-control mb-2" required>
                    <button id="registerBtn" type="button" class="btn btn-primary w-100 mt-2"
                        onclick="handleRegister()">{{ __('Register') }}</button>
                </div>

                <div id="forgotForm" class="auth-form d-none">

                    <h5 class="py-2">{{ __('Forgot Password?') }}</h5>
                    <small>{{ __('Enter your email address, and we will send you a link to reset your password. Check your inbox and follow the instructions to regain access to your account.') }}</small>
                    <input id="forgotEmail" type="email" placeholder="Enter your email" class="form-control mb-2 mt-2"
                        required>
                    <button id="forgotBtn" type="button" class="btn btn-primary w-100 mt-2"
                        onclick="handleForgotPassword()">{{ __('Send Reset Link') }}</button>
                </div>

                <div id="verifyForm" class="auth-form d-none">

                    <h5 class="py-2">{{ __('Resend Verification Link') }}</h5>
                    <small>{{ __('If you havent received your verification email, click the button below to resend the verification link. Make sure to check your spam or junk folder if the email doesnt appear in your inbox.') }}</small>
                    <input id="verifyEmail" type="email" placeholder="Enter your email" class="form-control mt-2 mb-2"
                        required>
                    <button id="verifyBtn" type="button" class="btn btn-primary w-100 mt-2"
                        onclick="resendVerification()">{{ __('Send Link') }}</button>
                </div>

            </div>
        </div>
    </div>
</div>
