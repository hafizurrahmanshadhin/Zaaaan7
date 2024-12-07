@extends('auth.app')

@section('title')
    Verify Your Account
@endsection


@push('styles')
    <style>
        .fs-9 {
            cursor: pointer;
        }
        .fs-9:hover{
            text-decoration: none;
        }
    </style>
@endpush

@section('main')
    <main class="main" id="top">
        <div class="container">
            <div class="row flex-center min-vh-100 py-5">
                <div class="col-sm-10 col-md-8 col-lg-5 col-xxl-4"><a class="d-flex flex-center text-decoration-none mb-4"
                        href="{{route('admin.home.index')}}">
                        <div class="d-flex align-items-center fw-bolder fs-3 d-inline-block"><img
                                src="../../../assets/img/icons/logo.png" alt="phoenix" width="58" /></div>
                    </a>
                    <div class="px-xxl-5">
                        <div class="text-center mb-6">
                            <h4 class="text-body-highlight">Verify Your Account</h4>
                            <p class="text-body-tertiary mb-0">Thank you for signing up! To get started, please verify your
                                email address by clicking the link we just sent you. If you didn’t receive the email, just
                                let us know, and we’ll be happy to send another one your way.</p>
                            {{-- <P class="fs-10 mb-5">Don’t have access? <a href="#!">Use another method</a></P> --}}
                            <form class="verification-form mt-5" method="POST" action="{{ route('verification.send') }}"
                                data-2fa-form="data-2fa-form">
                                @csrf
                                <Button class="btn btn-primary w-100 mb-5" type="submit">Resend Verification Email</Button>
                                <a class="fs-9" id="logoutButton">Sign Out</a>
                            </form>

                            <form id="logoutForm" class="verification-form" data-2fa-form="data-2fa-form" method="POST"
                                action="{{ route('logout') }}">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection


@push('scripts')
    <script>
        $(document).ready(() => {
            $(`#logoutButton`).on(`click`, (e) => {
                e.preventDefault();
                $(`#logoutForm`).submit();
            })
        })
    </script>
@endpush
