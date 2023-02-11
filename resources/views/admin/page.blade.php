<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
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
            <h4>Pages</h4><a href="/page/new" class="btn btn-warning">New page</a>
            </div>
            <div class="col-8">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <td>Title</td>
                        <td>Active</td>
                        <td>Order</td>
                        <td></td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $PageInfo)
                    <tr class="table-dark">
                        <td>{{ $PageInfo->title }}</td>
                        <td>{{ $PageInfo->active }}</td>
                        <td>{{ $PageInfo->order }}</td>
                        <td><a href="/page/{{ $PageInfo->id }}" class="btn btn-warning">Modify</a></td>
                        <td>
                        <form action="{{ route('admin.pageDelete') }}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $PageInfo->id }}">
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
            <div class="col-4">
            @if($PageData == 'new')
            <form action="{{ route('admin.pageCreate') }}" method="post">
            @csrf
            <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" name="title" id="" placeholder="Title" value="{{ old('title') }}">
                    <span class="text-danger">@error('title'){{ $message }} @enderror</span>
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
                    <label for="order">Order</label>
                    <input type="number" class="form-control" name="order" id="" placeholder="Order" value="{{ old('order') }}">
                    <span class="text-danger">@error('order'){{ $message }} @enderror</span>
                </div>
                <div class="form-group">
                    <label for="url">Url</label>
                    <input type="text" class="form-control" name="url" id="" placeholder="Url" value="{{ old('url') }}">
                    <span class="text-danger">@error('url'){{ $message }} @enderror</span>
                </div>
                <div class="form-group">
                    <button class="btn btn-block btn-primary" type="submit">Create</button>
                </div>
            </form>
            <a href="/page" class="col-12 btn btn-outline-warning">Close</a>
            @elseif($PageData != null)
            <form action="{{ route('admin.pageUpdate') }}" method="post">
            @csrf
            <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" name="title" id="" placeholder="Title" value="{{ $PageData->title }}">
                    <span class="text-danger">@error('title'){{ $message }} @enderror</span>
                </div>
                <div class="form-group">
                    <label for="content">Content</label>
                    <textarea class="form-control" name="content" id="" placeholder="Content">{{ $PageData->content }}</textarea>
                    <span class="text-danger">@error('content'){{ $message }} @enderror</span>
                </div>
                <div class="form-group">
                    <label for="active">Active</label>
                    <input type="checkbox" class="form-control" name="active" id="" 
                    @if($PageData->active == 1)
                        checked
                    @endif
                    >
                </div>
                <div class="form-group">
                    <label for="order">Order</label>
                    <input type="number" class="form-control" name="order" id="" placeholder="Order" value="{{ $PageData->order }}">
                    <span class="text-danger">@error('order'){{ $message }} @enderror</span>
                </div>
                <div class="form-group">
                    <label for="order">Url</label>
                    <input type="text" class="form-control" name="url" id="" placeholder="Url" value="{{ $PageData->url }}">
                    <span class="text-danger">@error('url'){{ $message }} @enderror</span>
                </div>
                <input type="hidden" name="id" value="{{ $PageData->id }}">
                <div class="form-group">
                    <button class="btn btn-block btn-primary" type="submit">Update</button>
                </div>
            </form>
            <a href="/page" class="col-12 btn btn-outline-warning">Close</a>
            @endif
            </div>
        </div>
    </div>
</body>
</html>