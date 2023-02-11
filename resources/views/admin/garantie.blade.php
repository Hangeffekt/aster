@extends('admin.app')

@section("title", "Garanties")

@section("content")

<div class="col-12">
    <h4>Garantie</h4><a href="/admin/garantie/new" class="btn btn-warning">New garantie</a>
    </div>
    @if(count($data) != 0)
    <div class="col-8">
    <table class="table table-hover">
        <thead>
            <tr>
                <td>Name</td>
                <td>Inside name</td>
                <td>Garantie(month)</td>
                <td>Active</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $GarantieInfo)
            <tr class="table-dark">
                <td>{{ $GarantieInfo->name }}</td>
                <td>{{ $GarantieInfo->inside_name }}</td>
                <td>{{ $GarantieInfo->garantie }}</td>
                <td>{{ $GarantieInfo->active }}</td>
                <td><a href="/admin/garantie/{{ $GarantieInfo->id }}" class="btn btn-warning">Modify</a></td>
                <td>
                <form action="{{ route('admin.garantieDelete') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $GarantieInfo->id }}">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    </div>
    <div class="col-4">
        
        
        @if($garantieData == 'new')
        <div class="mb-3 border-primary card">
            <h3 class="card-header">New garantie</h3>
            <div class="card-body">
            <form action="{{ route('admin.garantieCreate') }}" method="post">
            @csrf
                <div class="form-group">
                    <label for="title">Name</label>
                    <input type="text" class="form-control" name="name" id="" placeholder="Name" value="{{ old('title') }}">
                    <span class="text-danger">@error('name'){{ $message }} @enderror</span>
                </div>
                <div class="form-group">
                    <label for="title">Inside name</label>
                    <input type="text" class="form-control" name="inside_name" id="" placeholder="Inside name" value="{{ old('inside_name') }}">
                    <span class="text-danger">@error('inside_name'){{ $message }} @enderror</span>
                </div>
                <div class="form-group">
                    <label for="title">Garantie</label>
                    <input type="text" class="form-control" name="garantie" id="" placeholder="Garantie" value="{{ old('garantie') }}">
                    <span class="text-danger">@error('garantie'){{ $message }} @enderror</span>
                </div>
                <div class="form-group">
                    <label for="active">Active</label>
                    <input type="checkbox" class="form-control" name="active" id="">
                </div>
                <div class="form-group">
                    <button class="btn btn-block btn-primary" type="submit">Create</button>
                </div>
            </form>
            <a href="{{ URL::previous() }}" class="btn btn-outline-warning">Back</a>
        </div>
        @elseif($garantieData != null)
        <div class="mb-3 border-primary card">
            <h3 class="card-header">{{ $garantieData->name }}</h3>
            <div class="card-body">
            <form action="{{ route('admin.garantieUpdate') }}" method="post">
            @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" id="" value="{{ $garantieData->name }}">
                </div>
                <div class="form-group">
                    <label for="inside_name">Inside name</label>
                    <input type="text" class="form-control" name="inside_name" id="" value="{{ $garantieData->inside_name }}">
                </div>
                <div class="form-group">
                    <label for="garantie">Garantie (month)</label>
                    <input type="text" class="form-control" name="garantie" id="" value="{{ $garantieData->garantie }}">
                </div>
                <div class="form-group">
                    <label for="active">Active</label>
                    <input type="checkbox" class="form-control" name="active" id="" 
                    @if($garantieData->active == 1)
                        checked
                    @endif
                    >
                </div>
                <input type="hidden" name="id" value="{{ $garantieData->id }}">
                <div class="form-group">
                    <button class="btn btn-block btn-primary" type="submit">Update</button>
                </div>
            </form>
            <a href="{{ URL::previous() }}" class="btn btn-outline-warning">Back</a>
        </div>
        @endif
    </div>
</div>

@else
    <div class="col-12 alert alert-info">There is no brands!</div>
@endif

@endsection