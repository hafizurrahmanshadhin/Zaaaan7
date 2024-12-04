@extends('backend.app')

@section('title')
    Mail SMTP Setting
@endsection

@section('main')
    <div class="content">
        <h2 class="mb-2 lh-sm">Validation</h2>
        <p class="text-body-tertiary lead mb-2">Setup Your Email SMTP For Your Application</p>
        <div class="mt-4">
            <div class="row g-4">
                <div class="col-12 col-xl-10 order-1 order-xl-0">
                    <div class="mb-9">
                        <div class="card shadow-none border my-4" id="mailForm" data-component-card="data-component-card">
                            <div class="card-body p-0">
                                <div class="p-4 code-to-copy">
                                    <form action="{{route('admin.setting.mail.store')}}" method="POST" class="row g-3 needs-validation" novalidate="">
                                        @csrf
                                        <div class="col-md-4">
                                            <label class="form-label" for="mail_mailer">Mail Mailer</label>
                                            <input class="form-control" id="mail_mailer" value="{{ env('MAIL_MAILER') }}" name="mail_mailer" type="text"
                                                 placeholder="smtp"/>
                                            @error('mail_mailer')
                                                <div class="text-danger validation-error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label" for="mail_host">Mail Host</label>
                                            <input class="form-control" id="mail_host" value="{{ env('MAIL_HOST') }}" name="mail_host" type="text"
                                                 placeholder="mail.example.com"/>
                                            @error('mail_host')
                                                <div class="text-danger validation-error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label" for="mail_port">Mail Port</label>
                                            <input class="form-control" id="mail_port" value="{{ env('MAIL_PORT') }}" name="mail_port" type="text"
                                                 placeholder="185"/>
                                            @error('mail_port')
                                                <div class="text-danger validation-error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label" for="mail_username">Username</label>
                                            <input class="form-control" id="mail_username" value="{{ env('MAIL_USERNAME') }}" name="mail_username"
                                                type="text" placeholder="email@example.com"/>
                                            @error('mail_username')
                                                <div class="text-danger validation-error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label" for="mail_password">Password</label>
                                            <input class="form-control" id="mail_password" value="{{ env('MAIL_PASSWORD') }}" name="mail_password"
                                                type="password" placeholder="************"/>
                                            @error('mail_password')
                                                <div class="text-danger validation-error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label" for="mail_encryption">Encryption</label>
                                            <input class="form-control" id="mail_encryption" value="{{ env('MAIL_ENCRYPTION') }}" name="mail_encryption"
                                                type="text" placeholder="tls or ssl"/>
                                            @error('mail_encryption')
                                                <div class="text-danger validation-error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label" for="mail_from_address">Mail Address</label>
                                            <input class="form-control" id="mail_from_address" value="{{ env('MAIL_FROM_ADDRESS') }}" name="mail_from_address"
                                                type="text" placeholder="email@example.com"/>
                                            @error('mail_from_address')
                                                <div class="text-danger validation-error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-primary" type="submit">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-2">
                    <div class="position-sticky mt-xl-4" style="top: 80px;">
                        <h5 class="lh-1">On this page </h5>
                        <hr />
                        <ul class="nav nav-vertical flex-column doc-nav" data-doc-nav="data-doc-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="#mailForm">Mail SMTP Setting</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 5">
            <div class="toast align-items-center text-white bg-dark border-0" id="icon-copied-toast" role="alert"
                aria-live="assertive" aria-atomic="true">
                <div class="d-flex" data-bs-theme="dark">
                    <div class="toast-body p-3"></div>
                    <button class="btn-close me-2 m-auto" type="button" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>
@endsection
