@extends('backend.app')

@section('title')
    Clients
@endsection


@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/dev/css/datatables.min.css') }}">
    <style>
        th {
            text-align: center !important;
        }

        td {
            text-align: center !important;
        }

        td img {
            width: 53px;
            height: 53px;
            object-fit: cover;
            border-radius: 5px;
        }
    </style>
@endpush

@section('main')
    <div class="content">
        <nav class="mb-3" aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item active">Profile</li>
            </ol>
        </nav>
        <div class="border-bottom border-translucent mb-7 mx-n3 px-2 mx-lg-n6 px-lg-6">
            <div class="row">
                <div class="col-xl-9">
                    <div class="d-sm-flex justify-content-between">
                        <h2 class="mb-4">{{ $user->role }}</h2>
                        @if ($user->status)
                            <div class="d-flex mb-3">
                                <a href="{{ route('admin.user.status', $user->id) }}" class="btn btn-primary">Dactivate</a>
                            </div>
                        @else
                            <a href="{{ route('admin.user.status', $user->id) }}"
                                class="btn btn-phoenix-primary me-2 px-6">Activate</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-9">
                <div class="d-flex align-items-end position-relative mb-7"><input class="d-none" id="upload-avatar"
                        type="file" />
                    <div class="hoverbox" style="width: 150px; height: 150px">
                        <div class="hoverbox-content rounded-circle d-flex flex-center z-1"
                            style="--phoenix-bg-opacity: .56;"><span
                                class="fa-solid fa-camera fs-1 text-body-quaternary"></span></div>
                        <div
                            class="position-relative bg-body-quaternary rounded-circle cursor-pointer d-flex flex-center mb-xxl-7">
                            <div class="avatar avatar-5xl"><img class="rounded-circle" src="{{ $user->avatar }}"
                                    alt="{{ $user->first_name }}" /></div><label class="w-100 h-100 position-absolute z-1"
                                for="upload-avatar"></label>
                        </div>
                    </div>
                </div>
                <h4 class="mb-3">Lead Information </h4>
                <form class="row g-3 mb-9">
                    <div class="col-sm-6 col-md-4">
                        <div class="form-floating"><input class="form-control" id="floatingInputFirstname" type="text"
                                readonly value="{{ $user->first_name }}" placeholder="First name" /><label
                                for="floatingInputFirstname">First Name</label></div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="form-floating"><input class="form-control" id="floatingInputLastname" type="text"
                                readonly value="{{ $user->last_name }}" placeholder="Last name" /><label
                                for="floatingInputLastname">Last name</label></div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="form-floating"><input class="form-control" id="floatingInputEmail" type="text"
                                readonly value="{{ $user->email }}" placeholder="email" /><label
                                for="floatingInputEmail">Email</label></div>
                    </div>
                    @if ($user->role == 'helper')
                        @php
                            $userTransections = App\Models\Transaction::where('helper', $user->id);
                            $totalEarning = $userTransections->sum('amount');
                            $weekEarning = $userTransections
                                ->where('created_at', '>=', Carbon\Carbon::now()->subDays(7))
                                ->sum('amount');
                        @endphp
                        <div class="col-sm-6 col-md-6">
                            <div class="form-floating"><input class="form-control" id="floatingInputEmail" type="text"
                                    readonly value="{{ $totalEarning }}" placeholder="email" /><label
                                    for="floatingInputEmail">Total Earn</label></div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-floating"><input class="form-control" id="floatingInputEmail" type="text"
                                    readonly value="{{ $totalEarning - ($totalEarning * 20) / 100 }}"
                                    placeholder="email" /><label for="floatingInputEmail">Earn After Splite</label></div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-floating"><input class="form-control" id="floatingInputEmail" type="text"
                                    readonly value="{{ $weekEarning }}" placeholder="email" /><label
                                    for="floatingInputEmail">Total Earn This Week</label></div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-floating"><input class="form-control" id="floatingInputEmail" type="text"
                                    readonly value="{{ $weekEarning - ($weekEarning * 20) / 100 }}"
                                    placeholder="email" /><label for="floatingInputEmail">Earn After Splite This
                                    Week</label></div>
                        </div>
                    @endif
                    @if ($user->role == 'user')
                        @php
                            $tasks = $user->clientTasks()->count();
                            $completed = $user->clientTasks()->where('status', 'completed')->count();
                            $pending = $user->clientTasks()->where('status', 'pending')->count();
                            $process = $user->clientTasks()->where('status', 'in process')->count();
                        @endphp

                        <div class="col-sm-6 col-md-6">
                            <div class="form-floating"><input class="form-control" id="floatingInputEmail" type="text"
                                    readonly value="{{ $tasks }}" placeholder="email" /><label
                                    for="floatingInputEmail">Total Tasks</label>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-floating"><input class="form-control" id="floatingInputEmail"
                                    type="text" readonly value="{{ $completed }}" placeholder="email" /><label
                                    for="floatingInputEmail">Total Completed Tasks</label>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-floating"><input class="form-control" id="floatingInputEmail"
                                    type="text" readonly value="{{ $pending }}" placeholder="email" /><label
                                    for="floatingInputEmail">Total pending Tasks</label>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-floating"><input class="form-control" id="floatingInputEmail"
                                    type="text" readonly value="{{ $process }}" placeholder="email" /><label
                                    for="floatingInputEmail">Total In Process Tasks</label>
                            </div>
                        </div>
                    @endif
                </form>
            </div>
        </div>
        <footer class="footer position-absolute">
            <div class="row g-0 justify-content-between align-items-center h-100">
                <div class="col-12 col-sm-auto text-center">
                    <p class="mb-0 mt-2 mt-sm-0 text-body">Thank you for creating with Phoenix<span
                            class="d-none d-sm-inline-block"></span><span
                            class="d-none d-sm-inline-block mx-1">|</span><br class="d-sm-none" />2024 &copy;<a
                            class="mx-1" href="https://themewagon.com/">Themewagon</a>
                    </p>
                </div>
                <div class="col-12 col-sm-auto text-center">
                    <p class="mb-0 text-body-tertiary text-opacity-85">v1.18.1</p>
                </div>
            </div>
        </footer>
    </div>
@endsection
