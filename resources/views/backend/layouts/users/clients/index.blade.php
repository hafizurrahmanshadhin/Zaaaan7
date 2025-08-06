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
        td img{
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
                <li class="breadcrumb-item active">Users</li>
            </ol>
        </nav>
        <div class="mb-9">
            <div class="row g-3 mb-4">
                <div class="col-auto">
                    <h2 class="mb-0">Clients</h2>
                </div>
            </div>
            <div id="products"
                data-list="{&quot;valueNames&quot;:[&quot;product&quot;,&quot;price&quot;,&quot;category&quot;,&quot;tags&quot;,&quot;vendor&quot;,&quot;time&quot;],&quot;page&quot;:10,&quot;pagination&quot;:true}">
                <div class="mb-4">
                    <div class="d-flex flex-wrap gap-3">
                        <div class="search-box">
                            <div class="position-relative">
                                <input class="form-control search-input search" id="search-input" type="search"
                                    placeholder="Search products" aria-controls="data-table">
                                <svg class="svg-inline--fa fa-magnifying-glass search-box-icon" aria-hidden="true"
                                    focusable="false" data-prefix="fas" data-icon="magnifying-glass" role="img"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                    <path fill="currentColor"
                                        d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-body-emphasis border-top border-bottom border-translucent position-relative top-1">
                    <div class="table-responsive scrollbar mx-n1 px-1">
                        <table class="table fs-9 mb-0" id="data-table">
                            <thead>
                                <tr>
                                    <th class="sort white-space-nowrap align-middle fs-10" scope="col"
                                        style="width:50px;"></th>
                                    <th class="white-space-nowrap align-middle ps-4" scope="col" style="width:350px;">
                                        NAME
                                    </th>
                                    <th class="sort align-middle ps-4" scope="col" style="width:50px;"></th>
                                </tr>
                            </thead>
                            <tbody class="list" id="products-table-body">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        {{-- footer --}}
        <x-footer />
    </div>
@endsection


@push('scripts')
    {{-- Datatable --}}
    <script src="{{ asset('assets/dev/js/datatables.min.js') }}"></script>
    <script>
        var routeUrls = {
            viewUrl: "{{ route('admin.category.sub.index', ['category' => '__category__']) }}",
            editUrl: "{{ route('admin.category.edit', ['category' => '__category__']) }}"
        };
    </script>
    <script>
        $(document).ready(function() {
            if (!$.fn.DataTable.isDataTable('#data-table')) {
                var dTable = $('#data-table').DataTable({
                    ordering: false,
                    lengthMenu: [
                        [10, 25, 50, 100, 200, 500, -1],
                        [10, 25, 50, 100, 200, 500, "All"]
                    ],
                    processing: true,
                    responsive: true,
                    serverSide: true,
                    searching: false,
                    language: {
                        processing: ''
                    },
                    scroller: {
                        loadingIndicator: true
                    },
                    pagingType: "full_numbers",
                    dom: "<'row justify-content-between table-topbar'<'col-md-2 col-sm-4 px-0'f>>tipr",
                    ajax: {
                        url: "{{ route('admin.user.client.index') }}",
                        type: "GET",
                        data: (d) => {
                            d.search = $('#search-input').val();
                        }
                    },
                    columns: [{
                            data: 'image',
                            name: 'image',
                            orderable: true,
                            searchable: true,
                            render: function(data, type, row) {
                                return `
                                <td>
                                    <img src="${data}" alt="" width="53">
                                </td>`;
                            }
                        },
                        {
                            data: 'name',
                            name: 'name',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false,
                            render: function(data, type, row) {
                                var viewUrl = routeUrls.viewUrl.replace('__category__', data);
                                var editUrl = routeUrls.editUrl.replace('__category__', data);
                                return `
                                    <td class="align-middle white-space-nowrap text-end pe-0 ps-4 btn-reveal-trigger">
                                        <div class="btn-reveal-trigger position-static">
                                            <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                                type="button" data-bs-toggle="dropdown" data-boundary="window"
                                                aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                                                <svg class="svg-inline--fa fa-ellipsis fs-10" aria-hidden="true" focusable="false"
                                                    data-prefix="fas" data-icon="ellipsis" role="img" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 448 512" data-fa-i2svg="">
                                                    <path fill="currentColor" d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"></path>
                                                </svg>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end py-2">
                                                <button onclick="deleteAlert('${data}')" class="dropdown-item text-danger" href="#!">Remove</button>
                                            </div>
                                        </div>
                                    </td>
                                `;
                            }
                        },
                    ]
                });
                // Custom search functionality
                $('#search-input').on('keyup', function() {
                    dTable.draw(); // Redraw the table with the custom search value
                });
            }
        });


        const deleteAlert = (id) => {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: false,
                showCancelButton: true,
                confirmButtonColor: "#25b003",
                cancelButtonColor: "#fa3b1d",
                confirmButtonText: "Yes, delete it!",
                customClass: {
                    popup: 'my-popup-class',
                    title: 'my-title-class',
                    content: 'my-content-class',
                    confirmButton: 'my-confirm-button-class',
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteItem(id);
                }
            });
        }


        // deleteing parcel
        const deleteItem = (id) => {
            try {
                $.ajax({
                    // Generate the URL using the named route
                    url: `{{ route('admin.user.client.destroy', '') }}/${id}`,
                    type: 'DELETE',
                    dataType: 'json',
                    success: (response) => {
                        try {
                            Swal.fire({
                                title: "Deleted!",
                                text: "deleted successfully",
                                icon: "success",
                                showConfirmButton: false,
                                timer: 500,
                                customClass: {
                                    popup: 'my-popup-class',
                                    title: 'my-title-class',
                                    content: 'my-content-class',
                                    confirmButton: 'my-confirm-button-class',
                                },
                            });
                            $('#data-table').DataTable().ajax.reload();
                        } catch (e) {
                            Swal.fire({
                                title: 'Error',
                                text: 'Something went wrong',
                                icon: false,
                                customClass: {
                                    popup: 'my-popup-class',
                                    title: 'my-title-class',
                                    content: 'my-content-class',
                                    confirmButton: 'my-confirm-button-class',
                                },
                            })
                        }
                    },
                    error: (xhr, status, error) => {
                        Swal.fire({
                            title: 'Error',
                            text: 'Something went wrong',
                            icon: false,
                            customClass: {
                                popup: 'my-popup-class',
                                title: 'my-title-class',
                                content: 'my-content-class',
                                confirmButton: 'my-confirm-button-class',
                            },
                        })
                    }
                });
            } catch (e) {
                Swal.fire({
                    title: 'Error',
                    text: 'Something went wrong',
                    icon: false,
                    customClass: {
                        popup: 'my-popup-class',
                        title: 'my-title-class',
                        content: 'my-content-class',
                        confirmButton: 'my-confirm-button-class',
                    },
                })
            }

        }
    </script>
@endpush
