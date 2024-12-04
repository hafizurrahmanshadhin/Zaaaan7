@extends('auth.app')

@section('title')
    Password Confirm
@endsection

@php
    $user = auth()->user();
@endphp

@section('main')
    <main class="main" id="top">
        <div class="container">
            <div class="row flex-center min-vh-100 py-5">
                <form method="POST" action="{{ route('password.confirm') }}"
                    class="col-sm-10 col-md-8 col-lg-5 col-xl-5 col-xxl-3">
                    @csrf
                    <div class="text-center mb-5">
                        <div class="avatar avatar-4xl mb-4"><img class="rounded-circle"
                                src="../../../assets/img/team/30.webp" alt="" /></div>
                        <h2 class="text-body-highlight"> <span class="fw-normal">Hello </span>{{ $user->name }}</h2>
                        <p class="text-body-tertiary">Enter your password to continue</p>
                    </div>
                    <div class="position-relative" data-password="data-password">
                        <input class="form-control" id="password" name="password" type="password"
                            placeholder="Enter Password" data-password-input="data-password-input" />
                        {{-- <button class="btn px-3 py-0 h-100 position-absolute top-0 end-0 fs-7 text-body-tertiary"
                            data-password-toggle="data-password-toggle">
                            <span class="uil uil-eye show"></span>
                            <span class="uil uil-eye-slash hide"></span>
                        </button> --}}
                    </div>
                    @error('password')
                        <div class="text-danger validation-error">{{ $message }}</div>
                    @enderror
                    <Button type="submit" class="btn btn-primary w-100 mt-3">Confirm</Button>
                </form>
            </div>
        </div>
    </main>
@endsection
