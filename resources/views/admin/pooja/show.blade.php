@extends('layouts.app')

@section('title', 'Pooja Preview')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h3 class="fw-bold mb-1">Pooja Preview</h3>
        <p class="text-muted mb-0">
            View complete pooja information.
        </p>
    </div>

    <div class="d-flex gap-2">

        <a href="{{ route('admin.pooja.edit', $pooja->id) }}"
           class="btn btn-primary">
            <i class="bi bi-pencil me-1"></i>
            Edit
        </a>

        <a href="{{ route('admin.pooja.index') }}"
           class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>
            Back
        </a>

    </div>

</div>


<div class="row g-4">

    {{-- Main Information --}}
    <div class="col-lg-8">

        <div class="card border-0 shadow-sm rounded-4 mb-4">

            <div class="card-body">

                <h4 class="fw-bold mb-3">
                    {{ $pooja->name }}
                </h4>

                @if($pooja->short_description)
                    <p class="text-muted">
                        {{ $pooja->short_description }}
                    </p>
                @endif

                <hr>

                <h5 class="fw-bold">Description</h5>

                <p>
                    {{ $pooja->description }}
                </p>

            </div>

        </div>


        {{-- Pricing --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">

            <div class="card-body">

                <h5 class="fw-bold mb-3">
                    Pricing & Details
                </h5>

                <div class="row g-3">

                    <div class="col-md-4">

                        <small class="text-muted d-block">
                            Original Price
                        </small>

                        <span class="text-decoration-line-through text-muted">
                            ₹{{ number_format($pooja->price, 2) }}
                        </span>

                    </div>


                    <div class="col-md-4">

                        <small class="text-muted d-block">
                            Offer Price
                        </small>

                        @if($pooja->offer_price)
                            <strong class="text-success fs-5">
                                ₹{{ number_format($pooja->offer_price, 2) }}
                            </strong>
                        @else
                            <span>-</span>
                        @endif

                    </div>


                    <div class="col-md-4">

                        <small class="text-muted d-block">
                            Duration
                        </small>

                        <strong>
                            {{ $pooja->duration ?? '-' }}
                        </strong>

                    </div>


                    <div class="col-md-6">

                        <small class="text-muted d-block">
                            Timings
                        </small>

                        {{ $pooja->timings ?? '-' }}

                    </div>


                    <div class="col-md-6">

                        <small class="text-muted d-block">
                            Location
                        </small>

                        {{ $pooja->location ?? '-' }}

                    </div>

                </div>

            </div>

        </div>


        {{-- Benefits --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">

            <div class="card-body">

                <h5 class="fw-bold mb-3">
                    Benefits
                </h5>

                @if(!empty($pooja->benefits))

                    <ul class="mb-0">

                        @foreach($pooja->benefits as $benefit)

                            <li class="mb-2">
                                {{ $benefit }}
                            </li>

                        @endforeach

                    </ul>

                @else

                    <span class="text-muted">
                        No benefits added.
                    </span>

                @endif

            </div>

        </div>


        {{-- Samagri --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">

            <div class="card-body">

                <h5 class="fw-bold mb-3">
                    Samagri
                </h5>

                @if(!empty($pooja->samagri))

                    <ul class="mb-0">

                        @foreach($pooja->samagri as $item)

                            <li class="mb-2">
                                {{ $item }}
                            </li>

                        @endforeach

                    </ul>

                @else

                    <span class="text-muted">
                        No Samagri added.
                    </span>

                @endif

            </div>

        </div>


        {{-- Process --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">

            <div class="card-body">

                <h5 class="fw-bold mb-3">
                    Puja Process
                </h5>

                <p class="mb-0">
                    {{ $pooja->process ?? '-' }}
                </p>

            </div>

        </div>


        {{-- Gallery --}}
        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body">

                <h5 class="fw-bold mb-3">
                    Gallery
                </h5>

                @if(!empty($pooja->gallery))

                    <div class="row g-3">

                        @foreach($pooja->gallery as $image)

                            <div class="col-md-4">

                                <img
                                    src="{{ asset('storage/' . $image) }}"
                                    class="img-fluid rounded-3"
                                    style="width:100%; height:180px; object-fit:cover;"
                                    alt="{{ $pooja->name }}"
                                >

                            </div>

                        @endforeach

                    </div>

                @else

                    <span class="text-muted">
                        No gallery images.
                    </span>

                @endif

            </div>

        </div>

    </div>


    {{-- Right Sidebar --}}
    <div class="col-lg-4">

        {{-- Main Photo --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">

            <div class="card-body">

                <h5 class="fw-bold mb-3">
                    Main Photo
                </h5>

                @if($pooja->photo)

                    <img
                        src="{{ asset('storage/' . $pooja->photo) }}"
                        class="img-fluid rounded-3"
                        style="width:100%; height:280px; object-fit:cover;"
                        alt="{{ $pooja->name }}"
                    >

                @else

                    <div class="bg-light rounded-3 d-flex align-items-center justify-content-center"
                         style="height:280px;">

                        <i class="bi bi-image fs-1 text-muted"></i>

                    </div>

                @endif

            </div>

        </div>


        {{-- Status --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">

            <div class="card-body">

                <h5 class="fw-bold mb-3">
                    Status
                </h5>

                <div class="d-flex justify-content-between mb-3">

                    <span>
                        Featured
                    </span>

                    @if($pooja->is_featured)

                        <span class="badge bg-warning text-dark">
                            Featured
                        </span>

                    @else

                        <span class="badge bg-light text-dark">
                            No
                        </span>

                    @endif

                </div>


                <div class="d-flex justify-content-between">

                    <span>
                        Status
                    </span>

                    @if($pooja->status)

                        <span class="badge bg-success">
                            Active
                        </span>

                    @else

                        <span class="badge bg-secondary">
                            Inactive
                        </span>

                    @endif

                </div>

            </div>

        </div>


        {{-- Other Information --}}
        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body">

                <h5 class="fw-bold mb-3">
                    Other Information
                </h5>

                <div class="mb-3">

                    <small class="text-muted d-block">
                        Slug
                    </small>

                    {{ $pooja->slug }}

                </div>


                <div class="mb-3">

                    <small class="text-muted d-block">
                        Sort Order
                    </small>

                    {{ $pooja->sort_order }}

                </div>


                <div>

                    <small class="text-muted d-block">
                        Created On
                    </small>

                    {{ $pooja->created_at->format('d M Y, h:i A') }}

                </div>

            </div>

        </div>

    </div>

</div>

@endsection