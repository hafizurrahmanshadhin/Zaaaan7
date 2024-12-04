@extends('frontend.app')

@section('title')
    template
@endsection

@section('main')
    <div class="content">
        <div class="container-small">
            <nav class="mb-3" aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('stockX.catalogue.index') }}">Catalogue Search</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $product['title'] }}</li>
                </ol>
            </nav>
            <div class="d-flex justify-content-between align-items-end mb-4">
                <h2 class="mb-0">Catalogue Details</h2>
            </div>
            <div class="bg-body dark__bg-gray-1100 p-4 mb-4 rounded-2">
                <div class="row g-4">
                    <div class="col-12 col-lg-3">
                        <div class="row g-4 g-lg-2">
                            <div class="col-12 col-sm-6 col-lg-12">
                                <div class="row align-items-center g-0">
                                    <div class="col-auto col-lg-6 col-xl-5">
                                        <h6 class="mb-0 me-3">Category No :</h6>
                                    </div>
                                    <div class="col-auto col-lg-6 col-xl-7">
                                        <p class="fs-9 text-body-secondary fw-semibold mb-0">
                                            {{ $product['productId'] ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-12">
                                <div class="row align-items-center g-0">
                                    <div class="col-auto col-lg-6 col-xl-5">
                                        <h6 class="me-3">Release Date :</h6>
                                    </div>
                                    <div class="col-auto col-lg-6 col-xl-7">
                                        <p class="fs-9 text-body-secondary fw-semibold mb-0">
                                            {{ isset($product['productAttributes']['releaseDate']) && $product['productAttributes']['releaseDate'] !== null
                                                ? (new DateTime($product['productAttributes']['releaseDate']))->format('M d, Y')
                                                : 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-5">
                        <div class="row g-4 gy-lg-5">
                            <div class="col-12 col-lg-8">
                                <h6 class="mb-2 me-3">Title :</h6>
                                <p class="fs-9 text-body-secondary fw-semibold mb-0">{{ $product['title'] }}</p>
                            </div>
                            <div class="col-12 col-lg-4">
                                <h6 class="mb-2"> Brand :</h6>
                                <p class="fs-9 text-body-secondary fw-semibold mb-0"> {{ $product['brand'] ?? 'N/A' }}</p>
                            </div>
                            <div class="col-12 col-lg-4">
                                <h6 class="mb-2"> Product Type :</h6>
                                <p class="fs-9 text-body-secondary fw-semibold mb-0">{{ $product['productType'] ?? 'N/A' }}
                                </p>
                            </div>
                            <div class="col-12 col-lg-4">
                                <h6 class="mb-2"> Style ID :</h6>
                                <p class="fs-9 text-body-secondary fw-semibold mb-0">{{ $product['styleId'] ?? 'N/A' }}</p>
                            </div>
                            <div class="col-12 col-lg-4">
                                <h6 class="mb-2"> Retail Price :</h6>
                                <p class="fs-9 text-body-secondary fw-semibold mb-0">
                                    {{ $product['productAttributes']['retailPrice'] ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4">
                        <div class="row g-4">
                            <div class="col-12 col-lg-6">
                                <h6 class="mb-2"> General Details:</h6>
                                <div class="fs-9 text-body-secondary fw-semibold mb-0">
                                    <p class="mb-2">Color: {{ $product['productAttributes']['color'] ?? 'N/A' }}</p>
                                    <p class="mb-2">Color Way: {{ $product['productAttributes']['colorway'] ?? 'N/A' }}
                                    </p>
                                    <p class="mb-2">Gender: {{ $product['productAttributes']['gender'] ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <h6 class="mb-2"> Other Details :</h6>
                                <div class="fs-9 text-body-secondary fw-semibold mb-0">
                                    <p class="mb-2">Season: {{ $product['season']['retailPrice'] ?? 'N/A' }}</p>
                                    <p class="mb-2">URL Key: {{ $product['urlKey'] ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-0">
                <div class="table-responsive scrollbar">
                    <table class="table fs-9 text-body mb-6">
                        <thead class="bg-body-secondary">
                            <tr>
                                <th scope="col" style="width: 24px;"></th>
                                <th scope="col" style="min-width: 60px;">SL NO.</th>
                                <th scope="col" style="min-width: 360px;">Variant ID</th>
                                <th scope="col" style="width: 80px;">Size</th>
                                <th class="text-end" scope="col" style="min-width: 92px;">Variant Value</th>
                                <th class="sort text-end align-middle pe-0 ps-4" scope="col"></th>
                                <th scope="col" style="width: 24px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($variants as $index=>$variant)
                                <tr>
                                    <td class="border-0"></td>
                                    <td class="align-middle">{{ $index + 1 }}</td>
                                    <td class="align-middle">
                                        <p class="line-clamp-1 mb-0 fw-semibold">{{ $variant['variantId'] ?? 'N/A' }}</p>
                                    </td>
                                    <td class="align-middle text-body-tertiary fw-semibold">
                                        {{ $variant['sizeChart']['availableConversions'][4]['size'] ?? ($variant['sizeChart']['defaultConversion']['size'] . ' ' . $variant['sizeChart']['defaultConversion']['type'] ?? 'N/A') }}
                                    </td>
                                    <td class="align-middle text-end fw-semibold">{{ $variant['variantValue'] ?? 'N/A' }}
                                    </td>
                                    <td class="align-middle white-space-nowrap text-end pe-0 ps-4 btn-reveal-trigger">
                                        <div class="btn-reveal-trigger position-static">
                                            <button
                                                class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                                type="button" data-bs-toggle="dropdown" data-boundary="window"
                                                aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                                                <svg class="svg-inline--fa fa-ellipsis fs-10" aria-hidden="true"
                                                    focusable="false" data-prefix="fas" data-icon="ellipsis" role="img"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                                                    data-fa-i2svg="">
                                                    <path fill="currentColor"
                                                        d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z">
                                                    </path>
                                                </svg><!-- <span class="fas fa-ellipsis-h fs-10"></span> Font Awesome fontawesome.com -->
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end py-2" style="">
                                                <a class="dropdown-item"
                                                    href="{{ route('stockX.catalogue.variant.show', ['productId' => $product['productId'], 'variantId' => $variant['variantId']]) }}">Add
                                                    to Inventory</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="border-0"></td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="border-0"></td>
                                    <td class="align-middle"></td>
                                    <td class="align-middle">
                                        <p class="line-clamp-1 mb-0 fw-semibold">No Variant Foutn...!</p>
                                    </td>
                                    <td class="align-middle text-body-tertiary fw-semibold"></td>
                                    <td class="align-middle text-end fw-semibold"></td>
                                    <td class="border-0"></td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{-- footer --}}
        <x-footer />
    </div>
@endsection
