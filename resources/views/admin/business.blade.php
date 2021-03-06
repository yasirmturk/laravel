@extends('admin.layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 card">
            <div class="card-header">
                <h3 class="card-title">Tools:</h3>
                <div class="card-tools">
                    <a href="#" data-toggle="modal" data-target="#modal-add">Add New</a>
                </div>
            </div>
            <ul class="list-group list-group-flush">
                @foreach($businesses as $business)
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-2">
                            <img class="img-thumbnail rounded w-100" style="object-fit: cover;" src="{{ $business->dp('/images/s/') ?? asset('images/vendor/admin-lte/dist/AdminLTELogo.png') }}" />
                        </div>
                        <div class="col">
                            <h5>{{ $business->name }}
                                <small><i class="fas fa-phone-square"></i> {{ $business->phone }} <i class="fas fa-map-marked"></i> {{ $business->address() }}</small>
                            </h5>
                            <p>
                                <span class="badge bg-olive"><i class="fas fa-briefcase"></i>
                                    {{ $business->type }}
                                </span>
                                @if ($business->is_service)
                                <span class="badge bg-purple"><i class="fa fa-check"></i>
                                    Service
                                </span>
                                @endif
                                @if ($business->is_product)
                                <span class="badge bg-purple"><i class="fa fa-check"></i>
                                    Product
                                </span>
                                @endif
                                @foreach ($business->categories as $category)
                                <span class="badge bg-olive">{{ $category->name }}</span>
                                @endforeach
                            </p>
                            <p>
                                <a class="btn btn-app">
                                    <span class="badge bg-olive">{{ $business->employee_count }}</span>
                                    <i class="fas fa-user-friends"></i>Employees
                                </a>
                                <a class="btn btn-app" href="{{ route('admin.businesses.products.index', ['business' => $business->id]) }}">
                                    <span class="badge bg-olive">{{ $business->products()->count() }}</span>
                                    <i class="fas fa-barcode"></i>Products
                                </a>
                                <a class="btn btn-app" href="{{ route('admin.businesses.services.index', ['business' => $business->id]) }}">
                                    <span class="badge bg-olive">{{ $business->services()->count() }}</span>
                                    <i class="fas fa-spa"></i>Services
                                </a>
                            </p>
                            <p>{{ $business->description }}</p>
                        </div>
                        <form action="{{ route('admin.businesses.destroy', $business->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="close" aria-label="Delete"><span aria-hidden="true">&times;</span></button>
                        </form>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-add">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Register new Business</h4>
            </div>
            <form method="POST" action="{{ route('admin.businesses.store') }}">
                @csrf
                <div class="modal-body"></div>
        </div>
    </div>
</div>
@endsection
