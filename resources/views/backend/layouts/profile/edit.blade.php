@extends('backend.app')

@section('title')
    Profile
@endsection

@section('main')
    <div class="content">
        <div class="mb-9">
            <div class="row g-6">
                <div class="col-12 col-xl-4">
                    <div class="card mb-5">
                        <div class="card-header hover-actions-trigger position-relative mb-6" style="min-height: 130px; ">
                            <div class="bg-holder rounded-top"
                                style="background-image: linear-gradient(0deg, #000000 -3%, rgba(0, 0, 0, 0) 83%), url(../../assets/img/generic/59.png)">
                                <input disabled class="d-none" id="upload-settings-cover-image" type="file" />
                                <label class="cover-image-file-input" for="upload-settings-cover-image"></label>
                                <div class="hover-actions end-0 bottom-0 pe-1 pb-2 text-white dark__text-gray-1100">
                                    <span class="fa-solid fa-camera me-2"></span>
                                </div>
                            </div>
                            <input class="d-none" id="upload-settings-profile-picture" name="avatar" type="file" />
                            <label class="avatar avatar-4xl status-online feed-avatar-profile cursor-pointer"
                                for="upload-settings-profile-picture">
                                <img class="rounded-circle img-thumbnail shadow-sm border-0" id="profile-image"
                                    src="{{ $user->avatar }}" width="200" alt="" />
                            </label>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex flex-wrap mb-2 align-items-center">
                                        <h3 class="me-2">{{ $user->first_name }} {{ $user->last_name }}</h3>
                                        <span class="fw-normal fs-8">{{ $user->handle }}</span>
                                    </div>
                                    <div class="d-flex d-xl-block d-xxl-flex align-items-center">
                                        <div class="d-flex mb-xl-2 mb-xxl-0 gap-2">
                                            <svg viewBox="0 0 24 24" id="meteor-icon-kit__regular-inventory" width="10"
                                                height="10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                    stroke-linejoin="round"></g>
                                                <g id="SVGRepo_iconCarrier">
                                                    <g clip-path="url(#clip0_525_147)">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M2 1C2 0.447715 1.55228 0 1 0C0.447715 0 0 0.447715 0 1V23C0 23.5523 0.447715 24 1 24C1.55228 24 2 23.5523 2 23V22H22V23C22 23.5523 22.4477 24 23 24C23.5523 24 24 23.5523 24 23V1C24 0.447715 23.5523 0 23 0C22.4477 0 22 0.447715 22 1V8H20V3C20 2.44772 19.5523 2 19 2H11C10.4477 2 10 2.44772 10 3V4H5C4.44772 4 4 4.44772 4 5V8H2V1ZM10 6H6V8H10V6ZM2 10V20H4V13C4 12.4477 4.44772 12 5 12H13C13.5523 12 14 12.4477 14 13V14H19C19.5523 14 20 14.4477 20 15V20H22V10H2ZM18 8V4H12V8H18ZM12 20H6V14H12V20ZM14 20V16H18V20H14Z"
                                                            fill="#525b75"></path>
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_525_147">
                                                            <rect width="24" height="24" fill="white"></rect>
                                                        </clipPath>
                                                    </defs>
                                                </g>
                                            </svg>
                                            <h6 class="d-inline-block mb-0">1297<span
                                                    class="fw-semibold ms-1 me-4">Inventories</span></h6>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <svg version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg"
                                                width="10" height="10" xmlns:xlink="http://www.w3.org/1999/xlink"
                                                viewBox="0 0 512 512" xml:space="preserve" fill="#000000">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                    stroke-linejoin="round"></g>
                                                <g id="SVGRepo_iconCarrier">
                                                    <style type="text/css">
                                                        .st0 {
                                                            fill: #525b75;
                                                        }
                                                    </style>
                                                    <g>
                                                        <path class="st0"
                                                            d="M77.609,448h52.781c7.516,0,13.609-6.094,13.609-13.609V315.094c0-7.516-6.094-13.609-13.609-13.609H77.609 c-7.516,0-13.609,6.094-13.609,13.609v119.297C64,441.906,70.094,448,77.609,448z">
                                                        </path>
                                                        <path class="st0"
                                                            d="M197.609,448h52.781c7.516,0,13.609-6.094,13.609-13.609V235.094c0-7.516-6.094-13.609-13.609-13.609h-52.781 c-7.516,0-13.609,6.094-13.609,13.609v199.297C184,441.906,190.094,448,197.609,448z">
                                                        </path>
                                                        <path class="st0"
                                                            d="M317.609,448h52.781c7.516,0,13.609-6.094,13.609-13.609V139.094c0-7.516-6.094-13.609-13.609-13.609h-52.781 c-7.516,0-13.609,6.094-13.609,13.609v295.297C304,441.906,310.094,448,317.609,448z">
                                                        </path>
                                                        <path class="st0"
                                                            d="M437.609,448h52.781c7.516,0,13.609-6.094,13.609-13.609V43.094c0-7.516-6.094-13.609-13.609-13.609h-52.781 c-7.516,0-13.609,6.094-13.609,13.609v391.297C424,441.906,430.094,448,437.609,448z">
                                                        </path>
                                                        <path class="st0"
                                                            d="M498.391,482H45.609C38.094,482,32,475.906,32,468.391V13.609C32,6.094,25.906,0,18.391,0h-4.781 C6.094,0,0,6.094,0,13.609v484.781C0,505.906,6.094,512,13.609,512h484.781c7.516,0,13.609-6.094,13.609-13.609v-2.781 C512,488.094,505.906,482,498.391,482z">
                                                        </path>
                                                    </g>
                                                </g>
                                            </svg>
                                            <h6 class="d-block d-xl-inline-block mb-0">3971
                                                <span class="fw-semibold ms-1">Sales</span>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-8">
                    {{-- profile update --}}
                    <form class="border-bottom mb-4" action="{{ route('admin.profile.update') }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="mb-6">
                            <h4 class="mb-4">Personal Information</h4>
                            <div class="row g-3">
                                <div class="col-12 col-sm-6">
                                    <div class="form-icon-container">
                                        <div class="form-floating">
                                            <input class="form-control form-icon-input" id="firstName" name="first_name"
                                                value="{{ $user->first_name }}" type="text" placeholder="First Name" />
                                            <label class="text-body-tertiary form-icon-label" for="firstName">
                                                FIRST NAME
                                            </label>
                                        </div>
                                        <span class="fa-solid fa-user text-body fs-9 form-icon"></span>
                                        @error('first_name')
                                            <div class="text-danger validation-error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="form-icon-container">
                                        <div class="form-floating">
                                            <input class="form-control form-icon-input" id="lastName" name="last_name"
                                                value="{{ $user->last_name }}" type="text" placeholder="Last Name" />
                                            <label class="text-body-tertiary form-icon-label" for="lastName">
                                                LAST NAME</label>
                                        </div>
                                        <span class="fa-solid fa-user text-body fs-9 form-icon"></span>
                                        @error('last_name')
                                            <div class="text-danger validation-error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="form-icon-container">
                                        <div class="form-floating">
                                            <input class="form-control form-icon-input" id="emailSocial" type="email"
                                                name="email" value="{{ $user->email }}" placeholder="Email" />
                                            <label class="text-body-tertiary form-icon-label" for="emailSocial">
                                                ENTER YOUR EMAIL
                                            </label>
                                        </div>
                                        <span class="fa-solid fa-envelope text-body fs-9 form-icon"></span>
                                        @error('email')
                                            <div class="text-danger validation-error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="form-icon-container">
                                        <div class="form-floating">
                                            <input class="form-control form-icon-input" id="phone" type="tel"
                                                name="phone" value="{{ $profile->phone ?? ''}}" placeholder="Phone" />
                                            <label class="text-body-tertiary form-icon-label" for="phone">
                                                ENTER YOUR PHONE
                                            </label>
                                        </div>
                                        <span class="fa-solid fa-phone text-body fs-9 form-icon"></span>
                                        @error('phone')
                                            <div class="text-danger validation-error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="form-icon-container">
                                        <div class="form-floating">
                                            <textarea class="form-control form-icon-input" id="bio" style="height: 115px;" placeholder="bio"
                                                name="bio">{{ $profile->bio ?? '' }}</textarea>
                                            <label class="text-body-tertiary form-icon-label" for="bio">Bio</label>
                                        </div>
                                        <span class="fa-solid fa-circle-info text-body fs-9 form-icon"></span>
                                        @error('bio')
                                            <div class="text-danger validation-error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="form-icon-container mb-3">
                                        <div class="form-floating">
                                            <input class="form-control form-icon-input" id="companyName" type="text"
                                                placeholder="Company Name" name="company_name"
                                                value="{{ $profile->company_name ?? '' }}" />
                                            <label class="text-body-tertiary form-icon-label" for="companyName">
                                                COMPANY NAME</label>
                                        </div>
                                        <span class="fa-solid fa-building text-body fs-9 form-icon"></span>
                                        @error('company_name')
                                            <div class="text-danger validation-error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-icon-container">
                                        <div class="form-floating">
                                            <input class="form-control form-icon-input" id="website" type="text"
                                                name="website" value="{{ $profile->website ?? '' }}" placeholder="Website" />
                                            <label class="text-body-tertiary form-icon-label"
                                                for="website">Website</label>
                                        </div>
                                        <span class="fa-solid fa-globe text-body fs-9 form-icon"></span>
                                        @error('website')
                                            <div class="text-danger validation-error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-end mb-6">
                            <div>
                                <button type="button" onclick="location.reload();"
                                    class="btn btn-phoenix-secondary me-2">Cancel Changes</button>
                                <button type="submit" class="btn btn-phoenix-primary">Save Information</button>
                            </div>
                        </div>
                    </form>

                    {{-- Update Password --}}
                    <form class="border-bottom mb-4" action="{{ route('password.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-6">
                            <div class="col-12 col-sm-6">
                                <h4 class="mb-4">Change Password</h4>
                                <div class="form-icon-container mb-3">
                                    <div class="form-floating">
                                        <input class="form-control form-icon-input" id="oldPassword"
                                            name="current_password" type="password" placeholder="Old password" />
                                        <label class="text-body-tertiary form-icon-label" for="oldPassword">
                                            Old Password</label>
                                    </div>
                                    <span class="fa-solid fa-lock text-body fs-9 form-icon"></span>
                                    @error('current_password')
                                        <div class="text-danger validation-error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-icon-container mb-3">
                                    <div class="form-floating"><input class="form-control form-icon-input"
                                            id="newPassword" type="password" placeholder="New password"
                                            name="password" />
                                        <label class="text-body-tertiary form-icon-label" for="newPassword">
                                            New Password
                                        </label>
                                    </div>
                                    <span class="fa-solid fa-key text-body fs-9 form-icon"></span>
                                    @error('password')
                                        <div class="text-danger validation-error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-icon-container">
                                    <div class="form-floating">
                                        <input class="form-control form-icon-input" id="newPassword2" type="password"
                                            placeholder="Confirm New password" name="password_confirmation" />
                                        <label class="text-body-tertiary form-icon-label" for="newPassword2">
                                            Confirm New Password
                                        </label>
                                    </div>
                                    <span class="fa-solid fa-key text-body fs-9 form-icon"></span>
                                    @error('password')
                                        <div class="text-danger validation-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="text-end mb-6">
                            <div>
                                <button type="button" onclick="location.reload();"
                                    class="btn btn-phoenix-secondary me-2">Cancel Changes</button>
                                <button type="submit" class="btn btn-phoenix-primary">Save Information</button>
                            </div>
                        </div>
                    </form>
                    <div class="row gy-5">
                        <div class="col-12 col-md-6">

                            <h4 class="text-body-emphasis">Account Deletion</h4>
                            <p class="text-body-tertiary">
                                Transfer this account to another person or to a company repository.
                            </p>
                            <a href="{{ route('admin.profile.destroy', $user->id) }}" class="btn btn-phoenix-danger">Delete account</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <x-footer />
    </div>
@endsection


@push('scripts')
    <script>
        $(document).ready(() => {
            /**
             * jQuery Document Ready Function
             * 
             * This script handles the profile picture upload functionality. 
             * When the user selects an image file through the file input with 
             * the ID 'upload-settings-profile-picture', it reads the file 
             * and displays a preview. The script then sends the image to the 
             * server using AJAX for upload. It provides user feedback using 
             * toastr notifications for success and error handling.
             */
            $('#upload-settings-profile-picture').on('change', (event) => {
                const file = event.target.files[0];
                try {
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            $('#profile-image').attr('src', e.target.result);
                        }
                        // Read the file immediately after selection
                        reader.readAsDataURL(file);


                        const formData = new FormData();
                        formData.append('avatar', file);

                        $.ajax({
                            url: '{{ route('admin.profile.avatar') }}',
                            type: 'POST',
                            data: formData, // Use formData here
                            contentType: false,
                            processData: false,
                            success: (response) => {
                                toastr.success('Profile Image Uploaded');
                            },
                            error: (XHR, textStatus, errorThrown) => {
                                if (XHR.status == 422) {
                                    XHR.responseJSON.errors.avatar.forEach(element => {
                                        toastr.error(element);
                                    });

                                } else {
                                    toastr.error(XHR.responseJSON.message ||
                                        'An error occurred. Please try again.');
                                }
                            }
                        });
                    }
                } catch (e) {
                    console.error('An error occurred:', e);
                }
            });
        });
    </script>
@endpush
