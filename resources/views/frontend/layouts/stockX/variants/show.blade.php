@extends('frontend.app')

@section('title')
    template
@endsection

@push('styles')
    <link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
@endpush

@section('main')
    <div class="content">
        <div class="container-small cart">
            <nav class="mb-3" aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('stockX.catalogue.index') }}">Catalogue Search</a></li>
                    <li class="breadcrumb-item"><a
                            href="{{ route('stockX.catalogue.show', $product['productId']) }}">{{ $product['title'] }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $variant['variantName'] ?? 'Variant' }}</li>
                </ol>
            </nav>
            <h2 class="mb-5">Add Product to Inventory</h2>
            <div class="row">
                <div class="col-lg-7 mb-4 mb-lg-0">
                    <form action="{{ route('products.inventories.store') }}" method="POST">
                        @csrf
                        <h3 class="mb-5">Product Info</h3>
                        <div class="row g-4">
                            {{-- variant id --}}
                            <input type="hidden" name="variant_id" value="{{ $variant['variantId'] ?? 'N/A' }}">
                            <div class="col-12">
                                <label class="form-label fs-8 text-body-highlight ps-0 text-transform-none"
                                    for="inputName">Product Name</label>
                                <input class="form-control" id="inputName" type="text"
                                    value="{{ $product['title'] ?? 'N/A' }}" name="name"
                                    placeholder="{{ $product['title'] ?? 'N/A' }}" readonly>
                                @error('title')
                                    <p class="validation-error">{{ $message }}</p>
                                @enderror
                            </div>
                            {{-- style id --}}
                            <div class="col-md-6">
                                <label class="form-label fs-8 text-body-highlight ps-0 text-transform-none"
                                    for="inputStyle">Style ID</label>
                                <input class="form-control" id="inputStyle" type="text"
                                    placeholder="{{ $product['styleId'] ?? 'N/A' }}" name="style_id"
                                    value="{{ $product['styleId'] ?? 'N/A' }}" readonly>
                                @error('styleId')
                                    <p class="validation-error">{{ $message }}</p>
                                @enderror
                            </div>
                            {{-- size --}}
                            <div class="col-md-6">
                                <label class="form-label fs-8 text-body-highlight ps-0 text-transform-none"
                                    for="inputSize">Size</label>
                                <input class="form-control" id="inputSize" type="text" readonly
                                    placeholder="{{ $variant['sizeChart']['availableConversions'][4]['size'] ?? ($variant['sizeChart']['defaultConversion']['size'] . ' ' . $variant['sizeChart']['defaultConversion']['type'] ?? 'N/A') }}"
                                    value="{{ $variant['sizeChart']['availableConversions'][4]['size'] ?? ($variant['sizeChart']['defaultConversion']['size'] . ' ' . $variant['sizeChart']['defaultConversion']['type'] ?? 'N/A') }}"
                                    name="size">
                                @error('size')
                                    <p class="validation-error">{{ $message }}</p>
                                @enderror
                            </div>
                            {{-- price --}}
                            <div class="col-md-6">
                                <label class="form-label fs-8 text-body-highlight ps-0 text-transform-none"
                                    for="inputPrice">Price</label>
                                <input class="form-control number-arrows-none" id="inputPrice" type="number" step="any"
                                    name="price" placeholder="52">
                                @error('price')
                                    <p class="validation-error">{{ $message }}</p>
                                @enderror
                            </div>
                            {{-- tax --}}
                            <div class="col-md-6">
                                <label class="form-label fs-8 text-body-highlight ps-0 text-transform-none"
                                    for="inputTax">Tax</label>
                                <input class="form-control number-arrows-none" id="inputTax" type="number" step="any"
                                    name="tax" placeholder="24">
                                @error('tax')
                                    <p class="validation-error">{{ $message }}</p>
                                @enderror
                            </div>
                            {{-- currency --}}
                            <div class="col-md-6">
                                <label class="form-label fs-8 text-body-highlight ps-0 text-transform-none"
                                    for="inputCurrency">
                                    Currency
                                </label>
                                <select name="currency" class="form-select text-body-emphasis" id="inputCurrency">
                                    <option value="AUD">AUD</option>
                                    <option value="CHF">CHF</option>
                                    <option selected="selected" value="EUR">EUR</option>
                                    <option value="GBP">GBP</option>
                                    <option value="HKD">HKD</option>
                                    <option value="JPY">JPY</option>
                                    <option value="KRW">KRW</option>
                                    <option value="MXN">MXN</option>
                                    <option value="NZD">NZD</option>
                                    <option value="SGD">SGD</option>
                                    <option value="USD">USD</option>
                                </select>
                                @error('currency')
                                    <p class="validation-error">{{ $message }}</p>
                                @enderror
                            </div>
                            {{-- place of purchase --}}
                            <div class="col-6">
                                <label class="form-label fs-8 text-body-highlight ps-0 text-transform-none"
                                    for="inputPlaceOfPurchase">Place of Purchase</label>
                                <input class="form-control" id="inputPlaceOfPurchase" type="text"
                                    name="place_of_purchase" placeholder="LA Mart..." value="">
                                @error('place_of_purchase')
                                    <p class="validation-error">{{ $message }}</p>
                                @enderror
                            </div>
                            {{-- purchase date --}}
                            <div class="col-6">
                                <label class="form-label fs-8 text-body-highlight ps-0 text-transform-none"
                                    for="datepicker">Purchase Date</label>
                                <input class="form-control datetimepicker flatpickr-input" id="datepicker" type="text"
                                    placeholder="dd/mm/yyyy" name="purchase_date"
                                    data-options="{&quot;disableMobile&quot;:true,&quot;dateFormat&quot;:&quot;d/m/Y&quot;}"
                                    readonly="readonly">
                                @error('purchase_date')
                                    <p class="validation-error">{{ $message }}</p>
                                @enderror
                            </div>
                            {{-- order_id --}}
                            <div class="col-md-6">
                                <label class="form-label fs-8 text-body-highlight ps-0 text-transform-none"
                                    for="inputOrderID">Order ID</label>
                                <input class="form-control number-arrows-none" id="inputOrderID" type="number"
                                    name="order_id" placeholder="52">
                                @error('order_id')
                                    <p class="validation-error">{{ $message }}</p>
                                @enderror
                            </div>
                            {{-- Quantity --}}
                            <div class="col-md-12">
                                <label class="form-label fs-8 text-body-highlight ps-0 text-transform-none"
                                    for="inputQuantity">Quantity</label>
                                <input class="form-control number-arrows-none" id="inputQuantity" type="number"
                                    name="quantity" placeholder="52">
                                @error('quantity')
                                    <p class="validation-error">{{ $message }}</p>
                                @enderror
                            </div>
                            {{-- Note --}}
                            <div class="col-md-12">
                                <label class="form-label fs-8 text-body-highlight ps-0 text-transform-none"
                                    for="inputNote">Note</label>
                                <textarea class="form-control" id="inputNote" rows="3" name="note"></textarea>
                                @error('note')
                                    <p class="validation-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-12">
                                <button class="btn btn-primary px-8 px-sm-11 me-2" type="submit">Save</button>
                                <a href="{{route('home.index')}}" class="btn btn-phoenix-secondary text-nowrap" type="button">
                                    Exit Without Saving
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-5 col-xl-4 offset-xl-1">
                    <div class="card mt-3 mt-lg-0 mb-6">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <h3 class="mb-0">Variant Details</h3>
                            </div>
                            <div class="border-dashed border-bottom border-translucent mt-4">
                                <div class="ms-n2">
                                    {{-- product title --}}
                                    <div class="row align-items-center mb-2 g-3">
                                        <div class="col-4 col-md-4 col-lg-4">
                                            <h5 class="fw-semibold text-body-highlight lh-base">Title</h5>
                                        </div>
                                        <div class="col-8 col-md-8 col-lg-8">
                                            <div class="d-flex align-items-center">
                                                <h5 class="fw-semibold text-body-highlight lh-base">
                                                    {{ $product['title'] ?? 'N/A' }}
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- product id --}}
                                    <div class="row align-items-center mb-2 g-3">
                                        <div class="col-4 col-md-4 col-lg-4">
                                            <h6 class="fw-semibold text-body-highlight lh-base">Product ID</h6>
                                        </div>
                                        <div class="col-8 col-md-8 col-lg-8">
                                            <div class="d-flex align-items-center">
                                                <h6 class="fw-semibold text-body-highlight lh-base">
                                                    {{ $product['productId'] ?? 'N/A' }}
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- product brand --}}
                                    <div class="row align-items-center mb-2 g-3">
                                        <div class="col-4 col-md-4 col-lg-4">
                                            <h6 class="fw-semibold text-body-highlight lh-base">Brand</h6>
                                        </div>
                                        <div class="col-8 col-md-8 col-lg-8">
                                            <div class="d-flex align-items-center">
                                                <h6 class="fw-semibold text-body-highlight lh-base">
                                                    {{ $product['brand'] ?? 'N/A' }}
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- product type --}}
                                    <div class="row align-items-center mb-2 g-3">
                                        <div class="col-4 col-md-4 col-lg-4">
                                            <h6 class="fw-semibold text-body-highlight lh-base">Product Type</h6>
                                        </div>
                                        <div class="col-8 col-md-8 col-lg-8">
                                            <div class="d-flex align-items-center">
                                                <h6 class="fw-semibold text-body-highlight lh-base">
                                                    {{ $product['productType'] ?? 'N/A' }}
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- product styleId --}}
                                    <div class="row align-items-center mb-2 g-3">
                                        <div class="col-4 col-md-4 col-lg-4">
                                            <h6 class="fw-semibold text-body-highlight lh-base">Style ID</h6>
                                        </div>
                                        <div class="col-8 col-md-8 col-lg-8">
                                            <div class="d-flex align-items-center">
                                                <h6 class="fw-semibold text-body-highlight lh-base">
                                                    {{ $product['styleId'] ?? 'N/A' }}
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- product urlKey --}}
                                    <div class="row align-items-center mb-2 g-3">
                                        <div class="col-4 col-md-4 col-lg-4">
                                            <h6 class="fw-semibold text-body-highlight lh-base">URL Key</h6>
                                        </div>
                                        <div class="col-8 col-md-8 col-lg-8">
                                            <div class="d-flex align-items-center">
                                                <h6 class="fw-semibold text-body-highlight lh-base">
                                                    {{ $product['urlKey'] ?? 'N/A' }}
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="border-dashed border-bottom border-translucent mt-4">
                                <div class="ms-n2">
                                    {{-- color --}}
                                    <div class="row align-items-center mb-2 g-3">
                                        <div class="col-4 col-md-4 col-lg-4">
                                            <h6 class="fw-semibold text-body-highlight lh-base">Color</h6>
                                        </div>
                                        <div class="col-8 col-md-8 col-lg-8">
                                            <div class="d-flex align-items-center">
                                                <h6 class="fw-semibold text-body-highlight lh-base">
                                                    {{ $product['productAttributes']['color'] ?? 'N/A' }}
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Color Way --}}
                                    <div class="row align-items-center mb-2 g-3">
                                        <div class="col-4 col-md-4 col-lg-4">
                                            <h6 class="fw-semibold text-body-highlight lh-base">Color Way</h6>
                                        </div>
                                        <div class="col-8 col-md-8 col-lg-8">
                                            <div class="d-flex align-items-center">
                                                <h6 class="fw-semibold text-body-highlight lh-base">
                                                    {{ $product['productAttributes']['colorway'] ?? 'N/A' }}
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- gender --}}
                                    <div class="row align-items-center mb-2 g-3">
                                        <div class="col-4 col-md-4 col-lg-4">
                                            <h6 class="fw-semibold text-body-highlight lh-base">Gender</h6>
                                        </div>
                                        <div class="col-8 col-md-8 col-lg-8">
                                            <div class="d-flex align-items-center">
                                                <h6 class="fw-semibold text-body-highlight lh-base">
                                                    {{ $product['productAttributes']['gender'] ?? 'N/A' }}
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Release Date --}}
                                    <div class="row align-items-center mb-2 g-3">
                                        <div class="col-4 col-md-4 col-lg-4">
                                            <h6 class="fw-semibold text-body-highlight lh-base">Color</h6>
                                        </div>
                                        <div class="col-8 col-md-8 col-lg-8">
                                            <div class="d-flex align-items-center">
                                                <h6 class="fw-semibold text-body-highlight lh-base">
                                                    {{ isset($product['productAttributes']['releaseDate']) && $product['productAttributes']['releaseDate'] !== null
                                                        ? (new DateTime($product['productAttributes']['releaseDate']))->format('M d, Y')
                                                        : 'N/A' }}
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Retail Price --}}
                                    <div class="row align-items-center mb-2 g-3">
                                        <div class="col-4 col-md-4 col-lg-4">
                                            <h6 class="fw-semibold text-body-highlight lh-base">Retail Price</h6>
                                        </div>
                                        <div class="col-8 col-md-8 col-lg-8">
                                            <div class="d-flex align-items-center">
                                                <h6 class="fw-semibold text-body-highlight lh-base">
                                                    {{ $product['productAttributes']['retailPrice'] ?? 'N/A' }}
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Season --}}
                                    <div class="row align-items-center mb-2 g-3">
                                        <div class="col-4 col-md-4 col-lg-4">
                                            <h6 class="fw-semibold text-body-highlight lh-base">Season</h6>
                                        </div>
                                        <div class="col-8 col-md-8 col-lg-8">
                                            <div class="d-flex align-items-center">
                                                <h6 class="fw-semibold text-body-highlight lh-base">
                                                    {{ $product['season']['retailPrice'] ?? 'N/A' }}
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- variant --}}
                            <div class="border-dashed border-bottom border-translucent mt-4">
                                <div class="ms-n2">
                                    {{-- variant id --}}
                                    <div class="row align-items-center mb-2 g-3">
                                        <div class="col-4 col-md-4 col-lg-4">
                                            <h6 class="fw-semibold text-body-highlight lh-base">Variant ID</h6>
                                        </div>
                                        <div class="col-8 col-md-8 col-lg-8">
                                            <div class="d-flex align-items-center">
                                                <h6 class="fw-semibold text-body-highlight lh-base">
                                                    {{ $variant['variantId'] ?? 'N/A' }}
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Variant Value --}}
                                    <div class="row align-items-center mb-2 g-3">
                                        <div class="col-4 col-md-4 col-lg-4">
                                            <h6 class="fw-semibold text-body-highlight lh-base">Variant Value</h6>
                                        </div>
                                        <div class="col-8 col-md-8 col-lg-8">
                                            <div class="d-flex align-items-center">
                                                <h6 class="fw-semibold text-body-highlight lh-base">
                                                    {{ $variant['variantValue'] ?? 'N/A' }}
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Size --}}
                                    <div class="row align-items-center mb-2 g-3">
                                        <div class="col-4 col-md-4 col-lg-4">
                                            <h6 class="fw-semibold text-body-highlight lh-base">Variant Size</h6>
                                        </div>
                                        <div class="col-8 col-md-8 col-lg-8">
                                            <div class="d-flex align-items-center">
                                                <h6 class="fw-semibold text-body-highlight lh-base">
                                                    {{ $variant['sizeChart']['availableConversions'][4]['size'] ?? ($variant['sizeChart']['defaultConversion']['size'] . ' ' . $variant['sizeChart']['defaultConversion']['type'] ?? 'N/A') }}
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- highestBidAmount --}}
                                    <div class="row align-items-center mb-2 g-3">
                                        <div class="col-4 col-md-4 col-lg-4">
                                            <h6 class="fw-semibold text-body-highlight lh-base">Highest Bid Amount</h6>
                                        </div>
                                        <div class="col-8 col-md-8 col-lg-8">
                                            <div class="d-flex align-items-center">
                                                <h6 class="fw-semibold text-body-highlight lh-base">
                                                    {{ $marketData['highestBidAmount'] ?? 'N/A' }} EUR
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- lowestAskAmount --}}
                                    <div class="row align-items-center mb-2 g-3">
                                        <div class="col-4 col-md-4 col-lg-4">
                                            <h6 class="fw-semibold text-body-highlight lh-base">Lowest Ask Amount</h6>
                                        </div>
                                        <div class="col-8 col-md-8 col-lg-8">
                                            <div class="d-flex align-items-center">
                                                <h6 class="fw-semibold text-body-highlight lh-base">
                                                    {{ $marketData['lowestAskAmount'] ?? 'N/A' }} EUR
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- flexLowestAskAmount --}}
                                    <div class="row align-items-center mb-2 g-3">
                                        <div class="col-4 col-md-4 col-lg-4">
                                            <h6 class="fw-semibold text-body-highlight lh-base">Flex Lowest Ask Amount</h6>
                                        </div>
                                        <div class="col-8 col-md-8 col-lg-8">
                                            <div class="d-flex align-items-center">
                                                <h6 class="fw-semibold text-body-highlight lh-base">
                                                    {{ $marketData['flexLowestAskAmount'] ?? 'N/A' }} EUR
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- earnMoreAmount --}}
                                    <div class="row align-items-center mb-2 g-3">
                                        <div class="col-4 col-md-4 col-lg-4">
                                            <h6 class="fw-semibold text-body-highlight lh-base">Earn More Amount</h6>
                                        </div>
                                        <div class="col-8 col-md-8 col-lg-8">
                                            <div class="d-flex align-items-center">
                                                <h6 class="fw-semibold text-body-highlight lh-base">
                                                    {{ $marketData['earnMoreAmount'] ?? 'N/A' }} EUR
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- sellFasterAmount --}}
                                    <div class="row align-items-center mb-2 g-3">
                                        <div class="col-4 col-md-4 col-lg-4">
                                            <h6 class="fw-semibold text-body-highlight lh-base">Sell Faster Amount</h6>
                                        </div>
                                        <div class="col-8 col-md-8 col-lg-8">
                                            <div class="d-flex align-items-center">
                                                <h6 class="fw-semibold text-body-highlight lh-base">
                                                    {{ $marketData['sellFasterAmount'] ?? 'N/A' }} EUR
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- footer --}}
        <x-footer />
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('vendors/flatpickr/flatpickr.min.js') }}"></script>
@endpush
