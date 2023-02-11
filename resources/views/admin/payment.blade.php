<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment methods</title>
    <!-- Scripts -->
    <script src="{{asset('js/jquery-3.5.1.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
	
    
    <!-- Styles -->
    <link href="/css/b_style.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
            @include("admin.menu")

            @if(Session::get('success'))
                <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
            <h4>Payments</h4><a href="/admin/payment/new" class="btn btn-warning">New payment</a>
            </div>
            <div class="col-8">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <td>Name</td>
                        <td>Active</td>
                        <td>Cost</td>
                        <td></td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $PaymentInfo)
                    <tr class="table-dark">
                        <td>{{ $PaymentInfo->name }}</td>
                        <td>{{ $PaymentInfo->active }}</td>
                        <td>{{ $PaymentInfo->cost }}</td>
                        <td><a href="/admin/payment/{{ $PaymentInfo->id }}" class="btn btn-warning">Modify</a></td>
                        <td>
                        <form action="{{ route('admin.paymentDelete') }}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $PaymentInfo->id }}">
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
            <div class="col-4">
            @if($PaymentData == 'new')
            <form action="{{ route('admin.paymentCreate') }}" method="post">
            @csrf
            <div class="form-group">
                    <label for="title">Name</label>
                    <input type="text" class="form-control" name="name" id="" placeholder="Name" value="{{ old('title') }}">
                    <span class="text-danger">@error('name'){{ $message }} @enderror</span>
                </div>
                <div class="form-group">
                    <label for="content">Content</label>
                    <textarea class="form-control" name="content" id="" placeholder="Content">{{ old('content') }}</textarea>
                    <span class="text-danger">@error('content'){{ $message }} @enderror</span>
                </div>
                <div class="form-group">
                    <label for="active">Active</label>
                    <input type="checkbox" class="form-control" name="active" id="">
                </div>
                <div class="form-group">
                    <label for="cost">Cost</label>
                    <input type="number" class="form-control" name="cost" id="" placeholder="Cost" value="{{ old('cost') }}">
                    <span class="text-danger">@error('cost'){{ $message }} @enderror</span>
                </div>
                <div class="form-group">
                    <button class="btn btn-block btn-primary" type="submit">Create</button>
                </div>
            </form>
            <a href="/admin/payment" class="col-12 btn btn-outline-warning">Close</a>
            @elseif($PaymentData != null)
            <form action="{{ route('admin.paymentUpdate') }}" method="post">
            @csrf
            <div class="form-group">
                    <label for="title">Name</label>
                    <input type="text" class="form-control" name="name" id="" placeholder="Name" value="{{ $PaymentData->name }}">
                    <span class="text-danger">@error('name'){{ $message }} @enderror</span>
                </div>
                <div class="form-group">
                    <label for="content">Content</label>
                    <textarea class="form-control" name="content" id="" placeholder="Content">{{ $PaymentData->content }}</textarea>
                    <span class="text-danger">@error('content'){{ $message }} @enderror</span>
                </div>
                <div class="form-group">
                    <label for="active">Active</label>
                    <input type="checkbox" class="form-control" name="active" id="" 
                    @if($PaymentData->active == 1)
                        checked
                    @endif
                    >
                </div>
                <div class="form-group">
                    <label for="order">Cost</label>
                    <input type="number" class="form-control" name="cost" id="" placeholder="Cost" value="{{ $PaymentData->cost }}">
                    <span class="text-danger">@error('cost'){{ $message }} @enderror</span>
                </div>
                <input type="hidden" name="id" value="{{ $PaymentInfo->id }}">
                <div class="form-group">
                    <button class="btn btn-block btn-primary" type="submit">Update</button>
                </div>
            </form>
            <a href="/admin/payment" class="col-12 btn btn-outline-warning">Close</a>
            @endif
            </div>
        </div>
    </div>
</body>
</html>