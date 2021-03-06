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
            <!-- /.card-header -->
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    @foreach ($users as $user)
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-1">
                                <img src="{{ $user->dp('/images/s/') ?? asset('images/vendor/admin-lte/dist/AdminLTELogo.png') }}" class="img-rounded img-size-64" title="User Picture" />
                            </div>
                            <div class="col-9">
                                <h5>{{ $user->name }}
                                    <small>{{ $user->email }}
                                        @if ($e = $user->email_verified_at) <i title="Verified" class="fas fa-check-circle text-success"></i> @endif
                                    </small>
                                </h5>
                                <p>
                                    @if ($user->isProvider()) <span class="badge bg-olive">Provider</span> @endif
                                    @if ($user->stripe_id) <i class="fab fa-lg fa-cc-stripe text-info"></i> @endif
                                    @if ($card = $user->card_last_four)
                                    <span class="badge badge-info">
                                        @if ($cc = $user->card_brand) <i class="fab fa-lg fa-cc-{{$cc}}"></i> @endif
                                        {{$card}}
                                    </span>
                                    @endif
                                </p>
                                <p>
                                    <a class="btn btn-app">
                                        <span class="badge bg-olive">{{ $user->socialAccounts()->count() }}</span>
                                        <i class="fas fa-user-plus"></i>Social Accounts
                                    </a>
                                    <a class="btn btn-app">
                                        <span class="badge bg-olive">{{ $user->wishlist()->count() }}</span>
                                        <i class="fas fa-star"></i>Wishlist
                                    </a>
                                    <a class="btn btn-app">
                                        <span class="badge bg-olive">{{ 0 }}</span>
                                        <i class="fas fa-inbox"></i>Orders
                                    </a>
                                    <a class="btn btn-app">
                                        <span class="badge bg-olive">{{ $user->bookings()->count() }}</span>
                                        <i class="fas fa-calendar-check"></i>Bookings
                                    </a>
                                    @if ($user->isProvider())
                                    <a class="btn btn-app" href="{{ route('admin.users.businesses.index', ['user' => $user->id]) }}">
                                        <span class="badge bg-olive">{{ $user->businesses()->count() }}</span>
                                        <i class="fas fa-spray-can"></i>Businesses
                                    </a>
                                    @endif
                                </p>
                            </div>
                            <div class="col-2">
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->

<div class="modal fade" id="modal-add">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Register new User</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf
                <div class="modal-body">
                    <p>Enter the details&hellip;</p>
                    <div class="form-group">
                        <label for="inputName">Name</label>
                        <input type="name" class="form-control" id="inputName" name="name" placeholder="Enter name">
                    </div>
                    <div class="form-group">
                        <label for="inputEmail">Email</label>
                        <input type="email" class="form-control" id="inputEmail" name="email" placeholder="Enter email">
                    </div>
                    <div class="form-group">
                        <label for="inputPassword">Password</label>
                        <input type="password" class="form-control" id="inputPassword" name="password" placeholder="Enter password">
                    </div>
                    <div class="form-group">
                        <label for="inputPasswordC">Repeat Password</label>
                        <input type="password" class="form-control" id="inputPasswordC" name="password_confirmation" placeholder="Confirm password">
                    </div>
                </div>
                <div class="modal-footer justify-content-end">
                    <button type="submit" class="btn btn-primary">Save user</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@endsection
