@extends('admin.app')

@section("title", "Users")

@section("content")
    <div class="col-9">
        @if(count($UserAddress) == 0)
            
            <div class="empty-cart">There is no address</div>
            
        @else
            @foreach ($UserAddress as $object)
                <div class="card">
                    <h5 class="card-header
                    @if($object->active == 1)
                        alert-success
                    @endif
                    ">{{ $object->first_name }} {{ $object->last_name }}
                        @if($object->active == 1)
                            <i class="fas fa-check-circle"></i></h5>
                        @endif
                    </h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8">
                                <p>{{ $object->zip_code }} {{ $object->town }}</p>
                                <p>{{ $object->street }} {{ $object->ps_name }} {{ $object->number_floor }}</p>
                            </div>
                    
                            <div class="col-4">
                                <a href="/admin/user/addresses/{{ $object->user_id }}/{{ $object->id }}" class="btn-cart">Módosítás</a>
                                <form action="{{ route('shop.deleteDelivery') }}" method="post">
                                    @csrf
                                    <input type="submit" value="Törlés" class="btn btn-danger">
                                    <input type="hidden" name="address_id" value="{{ $object->id }}">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    @if($modify_address != null)
    <form action="{{ route('shop.modifyDelivery') }}" method="post" class="col-3 sum-cart-div">
        @csrf
        <h5 class="sum-cart-div-head">Cím módisítása</h5>
        <div class="card-body">
            <div class="">
                <label for="">Család név</label>
                <input type="text" name="first_name" class="form-control" value="{{ $modify_address->first_name }}">
                <span class="text-danger">@error('first_name'){{ $message }} @enderror</span>
            </div>
            <div class="">
                <label for="">Kereszt név</label>
                <input type="text" name="last_name" class="form-control" value="{{ $modify_address->last_name }}">
            </div>
            <div class="">
                <label for="">Irányítószám</label>
                <input type="text" name="zip_code" class="form-control" value="{{ $modify_address->zip_code }}">
                <span class="text-danger">@error('zip_code'){{ $message }} @enderror</span>
            </div>
            <div class="">
                <label for="">Város</label>
                <input type="text" name="town" class="form-control" value="{{ $modify_address->town }}">
                <span class="text-danger">@error('town'){{ $message }} @enderror</span>
            </div>
            <div class="">
                <label for="">Utcanév</label>
                <input type="text" name="street" class="form-control" value="{{ $modify_address->street }}">
                <span class="text-danger">@error('street'){{ $message }} @enderror</span>
            </div>
            <div class="">
                <label for="">Közterült típusa</label>
                <select class="form-control" name="street_type">
                    <option value="">Kérem válasszon</option>
                        @foreach ($ps_lists as $ps_object)
                        <option value="{{ $ps_object->ps_name }}" 
                            @if($ps_object->ps_name == $modify_address->street_type)
                                selected
                            @endif    
                        >{{ $ps_object->ps_name }}</option>
                        @endforeach
                </select>
                <span class="text-danger">@error('street_type'){{ $message }} @enderror</span>
            </div>
            <div class="">
                <label for="">Házszám, emelet, ajtó</label>
                <input type="text" name="number_floor" class="form-control" value="{{ $modify_address->number_floor }}">
                <span class="text-danger">@error('number_floor'){{ $message }} @enderror</span>
            </div>
            @if($modify_address->active == 0)
                <div class="form-group">
                    <label for="">Aktív</label>
                    <input type="checkbox" name="active" class="form-control"
                    @if($modify_address->active == 1)
                        checked
                    @endif
                    >
                </div>
            @endif
            <div class="form-group">
                <label for="">Ezek legyenek a számlázási adatok is</label>
                <input type="checkbox" name="copy_invoice" class="form-control">
            </div>
            <input type="hidden" name="address_id" value="{{ $modify_address->id }}">
            <button type="submit" class="btn-cart">Módosít</button>
        </div>
    </form>
    @endif

@endsection