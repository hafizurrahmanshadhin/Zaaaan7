@extends('frontend.app')

@section('title')
    StockX Products
@endsection

@section('main')
    <div class="content">
        <nav class="mb-3" aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                {{-- <li class="breadcrumb-item"><a href="{{ route('products.inventories.index') }}">Inventory</a></li> --}}
                <li class="breadcrumb-item active">StockX Products</li>
            </ol>
        </nav>
        <div class="mb-9">
            <div class="row g-3 mb-4">
                <div class="col-auto">
                    <h2 class="mb-0">Products From StockX</h2>
                    @if ($query)
                        <h4 class="mt-4" style="color: rgb(80, 80, 80)">Search Result Of {{ $query }}</h4>
                    @endif
                </div>
            </div>
            <div id="products"
                data-list="{&quot;valueNames&quot;:[&quot;product&quot;,&quot;price&quot;,&quot;category&quot;,&quot;tags&quot;,&quot;vendor&quot;,&quot;time&quot;],&quot;page&quot;:10,&quot;pagination&quot;:true}">
                <div class="mb-4">
                    <div class="d-flex flex-wrap gap-3">
                        <div class="search-box">
                            <form class="position-relative" action="{{ route('stockX.catalogue.search') }}"
                                method="GET">
                                @csrf
                                <input class="form-control search-input" type="search" placeholder="Search products"
                                    aria-label="Search" name="query">
                                <svg class="svg-inline--fa fa-magnifying-glass search-box-icon" aria-hidden="true"
                                    focusable="false" data-prefix="fas" data-icon="magnifying-glass" role="img"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                    <path fill="currentColor"
                                        d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z">
                                    </path>
                                </svg><!-- <span class="fas fa-search search-box-icon"></span> Font Awesome fontawesome.com -->
                            </form>
                        </div>
                    </div>
                </div>
                @if (count($products))
                    <div
                        class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-body-emphasis border-top border-bottom border-translucent position-relative top-1">
                        <div class="table-responsive scrollbar mx-n1 px-1">
                            <table class="table fs-9 mb-0">
                                <thead>
                                    <tr>
                                        <th class="sort white-space-nowrap align-middle ps-4" scope="col"
                                            style="width:350px;" data-sort="product">PRODUCT NAME</th>
                                        <th class="sort align-middle text-end ps-4" scope="col" data-sort="price"
                                            style="width:150px;">STYLE ID</th>
                                        <th class="sort align-middle ps-4" scope="col" data-sort="category"
                                            style="width:150px;">BRAND</th>
                                        <th class="sort align-middle ps-4" scope="col" data-sort="category"
                                            style="width:150px;">PRODUCT TYPE</th>
                                        <th class="sort align-middle ps-3" scope="col" data-sort="tags"
                                            style="width:250px;">COLOR WAY</th>
                                        <th class="sort align-middle ps-3" scope="col" data-sort="tags"
                                            style="width:250px;">COLOR</th>
                                        <th class="sort align-middle ps-4" scope="col" data-sort="vendor"
                                            style="width:200px;">GENDER</th>
                                        <th class="sort align-middle ps-4" scope="col" data-sort="time"
                                            style="width:50px;">RELEASE DATE</th>
                                        <th class="sort text-end align-middle pe-0 ps-4" scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody class="list" id="products-table-body">

                                    @foreach ($products as $product)
                                        <tr class="position-static">
                                            <td class="product align-middle ps-4">
                                                <a class="fw-semibold line-clamp-3 mb-0"
                                                    href="{{route('stockX.catalogue.show', $product['productId'])}}">
                                                    {{ $product['title'] ?? 'N/A' }}
                                                </a>
                                            </td>
                                            <td
                                                class="price align-middle white-space-nowrap text-end fw-bold text-body-tertiary ps-4">
                                                {{ $product['styleId'] ?? 'N/A' }}
                                            </td>
                                            <td
                                                class="category align-middle white-space-nowrap text-body-quaternary fs-9 ps-4 fw-semibold">
                                                {{ $product['brand'] ?? 'N/A' }}
                                            </td>
                                            <td
                                                class="category align-middle white-space-nowrap text-body-quaternary fs-9 ps-4 fw-semibold">
                                                {{ $product['productType'] ?? 'N/A' }}
                                            </td>
                                            <td
                                                class="category align-middle white-space-nowrap text-body-quaternary fs-9 ps-4 fw-semibold">
                                                {{ $product['productAttributes']['colorway'] ?? 'N/A' }}
                                            </td>
                                            <td
                                                class="category align-middle white-space-nowrap text-body-quaternary fs-9 ps-4 fw-semibold">
                                                ({{ $product['productAttributes']['color'] ?? 'N/A' }})
                                            </td>
                                            <td
                                                class="category align-middle white-space-nowrap text-body-quaternary fs-9 ps-4 fw-semibold">
                                                {{ $product['productAttributes']['gender'] ?? 'N/A' }}
                                            </td>
                                            <td
                                                class="time align-middle white-space-nowrap text-body-tertiary text-opacity-85 ps-4">
                                                {{ isset($product['productAttributes']['releaseDate']) && $product['productAttributes']['releaseDate'] !== null
                                                    ? (new DateTime($product['productAttributes']['releaseDate']))->format('M d, Y')
                                                    : 'N/A' }}
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <div class="row align-items-center justify-content-between py-2 pe-0 fs-9">
                            <div class="col-auto d-flex">
                                <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body"
                                    data-list-info="data-list-info">
                                    1 to 10 <span class="text-body-tertiary"> Items of
                                    </span>10
                                </p>
                            </div>
                            <div class="col-auto d-flex">
                                <form action="{{ route('stockX.catalogue.search.pagination') }}" method="GET">
                                    @csrf
                                    <input type="hidden" name="query" value="{{ $query }}">
                                    <input type="hidden" name="pageNumber" value="{{ $pageNumber - 1 }}">
                                    <button class="page-link @if ($pageNumber == 1) disabled @endif"
                                        data-list-pagination="prev">
                                        <svg class="svg-inline--fa fa-chevron-left" aria-hidden="true" focusable="false"
                                            data-prefix="fas" data-icon="chevron-left" role="img"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                            <path fill="currentColor"
                                                d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l192 192c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L77.3 256 246.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-192 192z">
                                            </path>
                                        </svg><!-- <span class="fas fa-chevron-left"></span> Font Awesome fontawesome.com -->
                                    </button>
                                </form>

                                <ul class="mb-0 p-0">
                                    <li class="active" style="list-style-type: none;">
                                        <button class="page" type="button" data-i="1" data-page="10">
                                            {{ $pageNumber }}
                                        </button>
                                    </li>
                                </ul>
                                <form action="{{ route('stockX.catalogue.search.pagination') }}" method="GET">
                                    @csrf
                                    <input type="hidden" name="query" value="{{ $query }}">
                                    <input type="hidden" name="pageNumber" value="{{ $pageNumber + 1 }}">
                                    <button class="page-link @if (!$hasNextPage) disabled @endif"
                                        data-list-pagination="next">
                                        <svg class="svg-inline--fa fa-chevron-right" aria-hidden="true" focusable="false"
                                            data-prefix="fas" data-icon="chevron-right" role="img"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                                            <path fill="currentColor"
                                                d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z">
                                            </path>
                                        </svg><!-- <span class="fas fa-chevron-right"></span> Font Awesome fontawesome.com -->
                                    </button>
                                </form>

                            </div>
                        </div>
                    </div>
                @else
                    <div class="d-flex justify-content-center flex-column align-items-center" style="margin-top: 100px;">
                        <h2>No Result..!</h2>
                        <img width="500px" src="{{ asset('assets/dev/svg/search.svg') }}" alt="">
                    </div>
                @endif
            </div>
        </div>
        {{-- footer --}}
        <x-footer />
    </div>
@endsection
