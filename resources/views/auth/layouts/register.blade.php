@extends('auth.app')

@section('title')
    Sing Up
@endsection

@section('main')
    <main class="main" id="top">
        <div class="container">
            <div class="row flex-center min-vh-100 py-5">
                <div class="col-sm-10 col-md-8 col-lg-5 col-xl-5 col-xxl-3"><a
                        class="d-flex flex-center text-decoration-none mb-4" href="{{route('admin.home.index')}}">
                        <div class="d-flex align-items-center fw-bolder fs-3 d-inline-block"><img
                                src="../../../assets/img/icons/logo.png" alt="phoenix" width="58" /></div>
                    </a>
                    <div class="text-center mb-7">
                        <h3 class="text-body-highlight">Sign Up</h3>
                        <p class="text-body-tertiary">Create your account today</p>
                    </div>
                    {{-- <button class="btn btn-phoenix-secondary w-100 mb-3"><span
                        class="fab fa-google text-danger validation-error me-2 fs-9"></span>Sign up with google
                </button>
                <button class="btn btn-phoenix-secondary w-100"><span
                        class="fab fa-facebook text-primary me-2 fs-9"></span>Sign up with facebook
                </button>
                <div class="position-relative mt-4">
                    <hr class="bg-body-secondary" />
                    <div class="divider-content-center">or use email</div>
                </div> --}}
                    {{-- Sigu Up form start --}}
                    <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3 text-start">
                            <label class="form-label" for="name">First Name</label>
                            <input class="form-control" id="name" type="text" name="first_name" value="{{old('first_name')}}" placeholder="First Name" />
                            @error('first_name')
                                <div class="text-danger validation-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 text-start">
                            <label class="form-label" for="name">Last Name</label>
                            <input class="form-control" id="name" type="text" name="last_name" value="{{old('last_name')}}" placeholder="Last Name" />
                            @error('last_name')
                                <div class="text-danger validation-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 text-start"><label class="form-label" for="email">Email address</label>
                            <input class="form-control" id="email" type="email" name="email" value="{{old('email')}}"
                                placeholder="name@example.com" />
                            @error('email')
                                <div class="text-danger validation-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-sm-6"><label class="form-label" for="password">Password</label>
                                <div class="position-relative" data-password="data-password">
                                    <input class="form-control form-icon-input pe-6" id="password" name="password"
                                        type="password" name="password" placeholder="Password"
                                        data-password-input="data-password-input" />
                                    {{-- <button
                                    class="btn px-3 py-0 h-100 position-absolute top-0 end-0 fs-7 text-body-tertiary"
                                    data-password-toggle="data-password-toggle">
                                    <span class="uil uil-eye show"></span>
                                    <span class="uil uil-eye-slash hide"></span>
                                </button> --}}
                                </div>
                            </div>
                            <div class="col-sm-6"><label class="form-label" for="confirmPassword">Confirm
                                    Password</label>
                                <div class="position-relative" data-password="data-password">
                                    <input class="form-control form-icon-input pe-6" id="confirmPassword" type="password"
                                        name="password_confirmation" placeholder="Confirm Password"
                                        data-password-input="data-password-input" />
                                    {{-- <button
                                    class="btn px-3 py-0 h-100 position-absolute top-0 end-0 fs-7 text-body-tertiary"
                                    data-password-toggle="data-password-toggle">
                                    <span class="uil uil-eye show"></span>
                                    <span class="uil uil-eye-slash hide"></span>
                                </button> --}}
                                </div>
                            </div>
                            @error('password')
                                <div class="text-danger validation-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" id="termsService" name="terms" type="checkbox" />
                            <label class="form-label fs-9 text-transform-none" for="termsService">
                                I accept the <a href="#!">terms </a>and <a href="#!">privacy policy</a>
                            </label>
                            @error('terms')
                                <div class="text-danger validation-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mb-3">Sign up</button>
                        <div class="text-center">
                            <a class="fs-9 fw-bold" href="{{ route('login') }}">Sign in to an existing account</a>
                        </div>
                    </form>
                    {{-- Sigu Up form end --}}
                </div>
            </div>
        </div>
    </main>
@endsection
