@extends('backend.app')

@section('title')
    General Setting
@endsection

@section('main')
    <div class="content">
        <h2 class="mb-2 lh-sm">Validation</h2>
        <p class="text-body-tertiary lead mb-2">Provide valuable, actionable feedback to your users with HTML5 form
            validation, via browser default behaviors or custom styles and JavaScript.</p><a class="btn btn-link p-0"
            href="https://getbootstrap.com/docs/5.3/forms/validation/" target="_blank">Forms validation on Bootstrap<span
                class="ms-1" data-feather="chevron-right"></span></a>
        <div class="mt-4">
            <div class="row g-4">
                <div class="col-12 col-xl-10 order-1 order-xl-0">
                    <div class="mb-9">
                        <div class="card shadow-none border my-4" data-component-card="data-component-card">
                            <div class="card-body p-0">
                                <div class="p-4 code-to-copy">
                                    <form class="row g-3 needs-validation" novalidate="">
                                        <div class="col-md-4">
                                            <label class="form-label" for="validationCustom01">First name</label>
                                            <input class="form-control" id="validationCustom01" type="text"
                                                value="Mark" required="" />
                                            <div class="valid-feedback">Looks good!</div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label" for="validationCustom02">Last name</label>
                                            <input class="form-control" id="validationCustom02" type="text"
                                                value="Otto" required="" />
                                            <div class="valid-feedback">Looks good!</div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label" for="validationCustomUsername">Username</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text" id="inputGroupPrepend">@</span>
                                                <input class="form-control" id="validationCustomUsername" type="text"
                                                    aria-describedby="inputGroupPrepend" required="" />
                                                <div class="invalid-feedback">Please choose a username.</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="validationCustom03">City</label>
                                            <input class="form-control" id="validationCustom03" type="text"
                                                required="" />
                                            <div class="invalid-feedback">Please provide a valid city.</div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label" for="validationCustom04">State</label>
                                            <select class="form-select" id="validationCustom04" required="">
                                                <option selected="" disabled="" value="">Choose...</option>
                                                <option>...</option>
                                            </select>
                                            <div class="invalid-feedback">Please select a valid state.</div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label" for="validationCustom05">Zip</label>
                                            <input class="form-control" id="validationCustom05" type="text"
                                                required="" />
                                            <div class="invalid-feedback">Please provide a valid zip.</div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-check">
                                                <input class="form-check-input" id="invalidCheck" type="checkbox"
                                                    value="" required="" />
                                                <label class="form-check-label mb-0" for="invalidCheck">Agree to terms and
                                                    conditions</label>
                                                <div class="invalid-feedback mt-0">You must agree before submitting.</div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-primary" type="submit">Submit form</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card shadow-none border my-4" data-component-card="data-component-card">
                            <div class="card-body p-0">
                                <div class="p-4 code-to-copy">
                                    <form class="row g-3 needs-validation" novalidate="">
                                        <div class="col-md-4 position-relative">
                                            <label class="form-label" for="validationTooltip01">First name</label>
                                            <input class="form-control" id="validationTooltip01" type="text"
                                                value="Mark" required="" />
                                            <div class="valid-tooltip">Looks good!</div>
                                        </div>
                                        <div class="col-md-4 position-relative">
                                            <label class="form-label" for="validationTooltip02">Last name</label>
                                            <input class="form-control" id="validationTooltip02" type="text"
                                                value="Otto" required="" />
                                            <div class="valid-tooltip">Looks good!</div>
                                        </div>
                                        <div class="col-md-4 position-relative">
                                            <label class="form-label" for="validationTooltipUsername">Username</label>
                                            <div class="input-group">
                                                <span class="input-group-text"
                                                    id="validationTooltipUsernamePrepend">@</span>
                                                <input class="form-control" id="validationTooltipUsername" type="text"
                                                    aria-describedby="validationTooltipUsernamePrepend" required="" />
                                                <div class="invalid-tooltip">Please choose a unique and valid username.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 position-relative">
                                            <label class="form-label" for="validationTooltip03">City</label>
                                            <input class="form-control" id="validationTooltip03" type="text"
                                                required="" />
                                            <div class="invalid-tooltip">Please provide a valid city.</div>
                                        </div>
                                        <div class="col-md-3 position-relative">
                                            <label class="form-label" for="validationTooltip04">State</label>
                                            <select class="form-select" id="validationTooltip04" required="">
                                                <option selected="" disabled="" value="">Choose...</option>
                                                <option>...</option>
                                            </select>
                                            <div class="invalid-tooltip">Please select a valid state.</div>
                                        </div>
                                        <div class="col-md-3 position-relative">
                                            <label class="form-label" for="validationTooltip05">Zip</label>
                                            <input class="form-control" id="validationTooltip05" type="text"
                                                required="" />
                                            <div class="invalid-tooltip">Please provide a valid zip.</div>
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-primary" type="submit">Submit form</button>
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
                            <li class="nav-item"> <a class="nav-link" href="#custom-styles-example">Custom styles
                                    Example</a></li>
                            <li class="nav-item"> <a class="nav-link" href="#tooltips">Tooltips</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 5">
            <div class="toast align-items-center text-white bg-dark border-0" id="icon-copied-toast" role="alert"
                aria-live="assertive" aria-atomic="true">
                <div class="d-flex" data-bs-theme="dark">
                    <div class="toast-body p-3"></div><button class="btn-close me-2 m-auto" type="button"
                        data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>
@endsection
