@extends('frontend.app')

@section('title')
    Create Product Catalog
@endsection

@push('styles')
@endpush

@push('headScripts')
    {{-- <script>
        var phoenixIsRTL = window.config.config.phoenixIsRTL;
        if (phoenixIsRTL) {
            var linkDefault = document.getElementById('style-default');
            var userLinkDefault = document.getElementById('user-style-default');
            linkDefault.setAttribute('disabled', true);
            userLinkDefault.setAttribute('disabled', true);
            document.querySelector('html').setAttribute('dir', 'rtl');
        } else {
            var linkRTL = document.getElementById('style-rtl');
            var userLinkRTL = document.getElementById('user-style-rtl');
            linkRTL.setAttribute('disabled', true);
            userLinkRTL.setAttribute('disabled', true);
        }
    </script> --}}
@endpush

@section('main')
    <div class="content">
        <h2 class="mb-2 lh-sm">Create a Product Catalog</h2>
        <p class="text-body-tertiary lead mb-2">Please Provide Your Product Informations</p>
        <div class="mt-4">
            <div class="row g-4">
                <div class="col-12 col-xl-10 order-1 order-xl-0">
                    <div class="mb-9">
                        <div class="card shadow-none border my-4" data-component-card="data-component-card">
                            <div class="card-header p-4 border-bottom bg-body">
                                <div class="row g-3 justify-content-between align-items-center">
                                    <div class="col-12 col-md">
                                        <h4 class="text-body mb-0" data-anchor="data-anchor" id="save-StockX-credentials">
                                            Save your Information
                                            <a class="anchorjs-link " aria-label="Anchor" data-anchorjs-icon="#"
                                                href="#save-StockX-credentials"
                                                style="margin-left: 0.1875em; padding-right: 0.1875em; padding-left: 0.1875em;">
                                            </a>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="p-4 code-to-copy">
                                    <form class="row g-3 needs-validation" action="{{ route('settings.stockx.update') }}"
                                        method="POST" novalidate="">
                                        @csrf
                                        @method('PUT')
                                        <div class="col-md-12">
                                            <label class="form-label" for="api_key">API Key</label>
                                            <input class="form-control" id="api_key" name="api_key" type="text"
                                                placeholder="{{ 'API Key' }}" value="{{ old('api_key') }}">
                                            @error('api_key')
                                                <div class="validation-error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="client_id">Client ID</label>
                                            <input class="form-control" id="client_id" name="client_id" type="text"
                                                placeholder="{{ 'Client ID' }}" value="{{ old('client_id') }}">
                                            @error('client_id')
                                                <div class="validation-error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="client_secret">Client Secret</label>
                                            <input class="form-control" id="" name="client_secret"
                                                placeholder="Client Secret" type="password" value="{{ '' }}">
                                            @error('client_secret')
                                                <div class="validation-error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label" for="redirect_url">Callback URL</label>
                                            <input class="form-control" id="redirect_url" type="text"
                                                value="https://dariobouman.test/auth/stockx/callback" disabled>
                                        </div>
                                        <label for="organizerMultiple">Multiple</label>
                                        <select class="form-select" id="organizerMultiple" data-choices="data-choices"
                                            multiple="multiple" data-options='{"removeItemButton":true,"placeholder":true}'>
                                            <option value="">Select organizer...</option>
                                            <option>Massachusetts Institute of Technology</option>
                                            <option>University of Chicago</option>
                                            <option>GSAS Open Labs At Harvard</option>
                                            <option>California Institute of Technology</option>
                                        </select>





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
                        <hr>
                        <ul class="nav nav-vertical flex-column doc-nav" data-doc-nav="data-doc-nav">
                            <li class="nav-item"> <a class="nav-link" href="#save-StockX-credentials">Create a Product
                                    Catalog</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            {{-- footer --}}
            <x-footer />
        </div>
    </div>
@endsection

@push('scripts')
@endpush
