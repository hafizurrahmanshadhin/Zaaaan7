@extends('auth.app')

@section('title')
    Reset Password
@endsection

@section('main')
    <main class="main" id="top">
        <div class="container">
            <div class="row flex-center min-vh-100 py-5">
                <div class="col-sm-10 col-md-8 col-lg-5 col-xl-5 col-xxl-3"><a
                        class="d-flex flex-center text-decoration-none mb-4" href="{{route('admin.home.index')}}">
                        <div class="d-flex align-items-center fw-bolder fs-3 d-inline-block"><img
                                src="{{ asset('assets/img/icons/logo.png') }}" alt="phoenix" width="58" /></div>
                    </a>
                    <div class="text-center mb-6">
                        <h4 class="text-body-highlight">Reset new password</h4>
                        <p class="text-body-tertiary">Type your new password</p>
                        <form method="POST" action="{{ route('password.store') }}" class="mt-5">
                            @csrf
                            <input type="hidden" name="token" value="{{ $request->route('token') }}">
                            <div class="mb-2 text-start">
                                <input class="form-control" id="email" type="hidden" name="email"
                                    value="{{ old('email', $request->email) }}"
                                    placeholder="{{ $request->email ?? 'name@example.com' }}" />
                                @error('email')
                                    <div class="text-danger validation-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="position-relative mb-2" data-password="data-password">
                                <input class="form-control form-icon-input pe-6" id="password" type="password"
                                    name="password" placeholder="Type new password"
                                    data-password-input="data-password-input" />

                                {{-- <button class="btn px-3 py-0 h-100 position-absolute top-0 end-0 fs-7 text-body-tertiary"
                                    data-password-toggle="data-password-toggle">
                                    <span class="uil uil-eye show"></span>
                                    <span class="uil uil-eye-slash hide"></span>
                                </button> --}}
                            </div>
                            @error('password')
                                <div class="text-danger validation-error">{{ $message }}</div>
                            @enderror
                            <div class="position-relative mb-4" data-password="data-password">
                                <input class="form-control form-icon-input pe-6" id="confirmPassword" type="password"
                                    name="password_confirmation" placeholder="Cofirm new password"
                                    data-password-input="data-password-input" />

                                {{-- <button class="btn px-3 py-0 h-100 position-absolute top-0 end-0 fs-7 text-body-tertiary"
                                    data-password-toggle="data-password-toggle">
                                    <span class="uil uil-eye show"></span>
                                    <span class="uil uil-eye-slash hide"></span>
                                </button> --}}
                            </div>
                            <button class="btn btn-primary w-100" type="submit">Set Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
