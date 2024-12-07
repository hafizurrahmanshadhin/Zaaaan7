@extends('auth.app')

@section('title')
    Sing In
@endsection

@section('main')
    <main class="main" id="top">
        <div class="container">
            <div class="row flex-center min-vh-100 py-5">
                <form action="{{ route('login') }}" method="POST" class="col-sm-10 col-md-8 col-lg-5 col-xl-5 col-xxl-3">
                    @csrf
                    <a class="d-flex flex-center text-decoration-none mb-4" href="{{route('admin.home.index')}}">
                        <div class="d-flex align-items-center fw-bolder fs-3 d-inline-block"><img
                                src="{{ asset('assets/img/icons/logo.png') }}" alt="phoenix" width="58" />
                        </div>
                    </a>
                    <div class="text-center mb-7">
                        <h3 class="text-body-highlight">Sign In</h3>
                        <p class="text-body-tertiary">Get access to your account</p>
                    </div>
                    <div class="mb-3 text-start"><label class="form-label" for="email">Email address</label>
                        <div class="form-icon-container">
                            <input class="form-control form-icon-input" id="email" value="{{old('email')}}"
                                type="email" name="email" placeholder="name@example.com" />
                            <span class="fas fa-user text-body fs-9 form-icon"></span>
                        </div>
                        @error('email')
                            <div class="text-danger validation-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 text-start"><label class="form-label" for="password">Password</label>
                        <div class="form-icon-container" data-password="data-password">
                            <input class="form-control form-icon-input pe-6" id="password" type="password"
                                placeholder="Password" name="password" data-password-input="data-password-input" />
                            <span class="fas fa-key text-body fs-9 form-icon"></span>
                        </div>
                        @error('password')
                            <div class="text-danger validation-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="row flex-between-center mb-7">
                        <div class="col-auto">
                            <div class="form-check mb-0">
                                <input class="form-check-input" id="basic-checkbox" name="remember" type="checkbox" />
                                <label class="form-check-label mb-0" for="basic-checkbox">Remember me</label>
                            </div>
                        </div>
                        <div class="col-auto">
                            <a class="fs-9 fw-semibold" href="{{route('password.request')}}">Forgot
                                Password?</a>
                            </div>
                    </div>
                    <button class="btn btn-primary w-100 mb-3">Sign In</button>
                    <div class="text-center"><a class="fs-9 fw-bold" href="{{route('register')}}">Create an account</a></div>
                </form>
            </div>
        </div>
    </main>
@endsection
