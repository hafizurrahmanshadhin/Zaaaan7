@extends('backend.app')

@section('title')
    Sing In
@endsection

@section('main')
    <div class="content">
        <div class="pb-5">
            <div class="row g-4">
                <div class="col-12 col-xxl-6">
                    <div class="mb-8">
                        <h2 class="mb-2">OK-App Dashboard</h2>
                        <h5 class="text-body-tertiary fw-semibold">Here’s what’s going on at your business right now</h5>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer position-absolute">
            <div class="row g-0 justify-content-between align-items-center h-100">
                <div class="col-12 col-sm-auto text-center">
                    <p class="mb-0 mt-2 mt-sm-0 text-body">Thank you for creating with Phoenix<span
                            class="d-none d-sm-inline-block"></span><span
                            class="d-none d-sm-inline-block mx-1">|</span><br class="d-sm-none" />2024 &copy;<a
                            class="mx-1" href="https://themewagon.com/">Themewagon</a></p>
                </div>
                <div class="col-12 col-sm-auto text-center">
                    <p class="mb-0 text-body-tertiary text-opacity-85">v1.18.1</p>
                </div>
            </div>
        </footer>
    </div>
@endsection
@push('scripts')

    <script>
        $(document).ready(function() {
            Echo.private('chat.1').listen('MessageSent', (e) => {
                console.log(e);
            })
            Echo.private('chat.1').listen('MessageSent', (e) => {
                console.log(e);
            })
        });
    </script>
@endpush


