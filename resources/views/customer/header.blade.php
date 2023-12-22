<header>
    <nav class="navbar navbar-expand-sm bg-body-tertiary w-100" style="background-color: white !important; position: fixed; z-index: 1;">
        <div class="container-fluid">
            <img src="{{ asset('assets/images/logo.png') }}" alt="logo" style="height: 50px; width:50px; margin-right:10px;">
            <a class="navbar-brand" href="/">BiteBuddy</a>
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <button id="open-sidebar" class="nav-link" aria-current="page">Select City</button>
                </li>
            </ul>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/checkout"><i class="bi bi-cart3"></i> Cart</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/track-order" id="track-order-nav"><i class="bi bi-map"></i> Track Order</a>
                    </li>
                    @if (Auth::check())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-left"></i> {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" id="sign-in" onclick="openLoginModal();"><i class="bi bi-person-circle"></i> sign in</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
</header>
<div class="container">
{{--    <div class="row">--}}
{{--        <div class="col-sm-4"></div>--}}
{{--        <div class="col-sm-4">--}}
{{--            <a class="btn big-login" data-toggle="modal" href="javascript:void(0)" onclick="openLoginModal();">Log in</a>--}}
{{--            <a class="btn big-register" data-toggle="modal" href="javascript:void(0)" onclick="openRegisterModal();">Register</a></div>--}}
{{--        <div class="col-sm-4"></div>--}}
{{--    </div>--}}


    <div class="modal fade login" id="loginModal">
        <div class="modal-dialog login animated">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" id="close1-btn" data-dismiss="modal" aria-hidden="true" >&times;</button>
                    <h4 class="modal-title">Login with</h4>
                </div>
                <div class="modal-body">
                    <div class="box">
                        <div class="content">
                            <div class="social">
                                <a class="circle github" href="#">
                                    <i class="fa fa-github fa-fw"></i>
                                </a>
                                <a id="google_login" class="circle google" href="#">
                                    <i class="fa fa-google-plus fa-fw"></i>
                                </a>
                                <a id="facebook_login" class="circle facebook" href="#">
                                    <i class="fa fa-facebook fa-fw"></i>
                                </a>
                            </div>
                            <div class="division">
                                <div class="line l"></div>
                                <span>or</span>
                                <div class="line r"></div>
                            </div>
                            <div class="error"></div>
                            <div class="form loginBox">
                                <form method="POST" id="login-form" action="{{ route('login') }}" accept-charset="UTF-8">
                                    @csrf
                                    <input id="login-email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus type="email" placeholder="Email">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert" id="backend-login-email-invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    <input id="login-password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required placeholder="password" autocomplete="current-password">
                                    @error('password')
                                    <span class="invalid-feedback"  role="alert" id="backend-login-password-invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                    <button type="submit" class="btn btn-primary" id="login-submit-btn">
                                        {{ __('Login') }}
                                    </button>
                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="box">
                        <div class="content registerBox" style="display:none;">
                            <div class="form">
                                <form method="POST" action="{{ route('register') }}" id="reg-form">
                                    @csrf
                                    <input id="reg-name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required placeholder="name" autocomplete="name" autofocus>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert" id="backend-reg-name-invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    <input id="reg-email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required placeholder="email" autocomplete="email">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert" id="backend-reg-email-invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    <input id="reg-password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required placeholder="password" autocomplete="new-password" >
                                    @error('password')
                                    <span class="invalid-feedback" role="alert" id="backend-reg-password-invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    <input id="reg-password-confirm-invalid-feedback" type="password" class="form-control" name="password_confirmation" required placeholder="confirm password" autocomplete="new-password" >

                                    <button type="submit" id="reg-submit-btn" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="forgot login-footer">
                            <span>Looking to
                                 <a href="javascript: showRegisterForm();">create an account</a>
                            ?</span>
                    </div>
                    <div class="forgot register-footer" style="display:none">
                        <span>Already have an account?</span>
                        <a href="javascript: showLoginForm();">Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="loadingOverlay" class="overlay">
    <div class="spinner"></div>
</div>