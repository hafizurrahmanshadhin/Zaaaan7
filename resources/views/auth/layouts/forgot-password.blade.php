@extends('auth.app')

@section('title')
    Forget Password
@endsection

@section('main')
    <main class="main" id="top">
        <div class="container">
            <div class="row flex-center min-vh-100 py-5">
                <div class="col-sm-10 col-md-8 col-lg-5 col-xxl-4">
                    <a class="d-flex flex-center text-decoration-none mb-4" href="{{route('admin.home.index')}}">
                        <div class="d-flex align-items-center fw-bolder fs-3 d-inline-block">
                            <img src="{{ asset('assets/img/icons/logo.png') }}" alt="phoenix" width="58" />
                        </div>
                    </a>
                    <div class="px-xxl-5">
                        <div class="text-center mb-6">
                            <h4 class="text-body-highlight">Forgot your password?</h4>
                            @if (session('status'))
                                <p class="text-body-tertiary color-success mb-5">
                                    {{ session('status') }}
                                </p>
                            @else
                                <p class="text-body-tertiary  mb-5">
                                    Enter your email below and we will send <br class="d-sm-none" />you a reset link
                                </p>
                            @endif

                            <form method="POST" action="{{ route('password.email') }}"
                                class="d-flex align-items-center mb-5">
                                @csrf
                                <input class="form-control flex-1" id="email" name="email" type="email"
                                    placeholder="Email" />
                                <button class="btn btn-primary ms-2">Send
                                    <span class="fas fa-chevron-right ms-2"></span>
                                </button>
                            </form>
                            @error('email')
                                <div class="text-danger validation-error">{{ $message }}</div>
                            @enderror
                            <a class="fs-9 fw-bold" href="#!">Still having problems?</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
