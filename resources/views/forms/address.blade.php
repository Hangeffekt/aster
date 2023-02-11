<form action="{{ route('shop.addDelivery') }}" method="post" class="sum-cart-div">
        @csrf
        <h5 class="sum-cart-div-head">Új cím</h5>
        <div class="card-body">
            <div class="">
                <label for="">Család név</label>
                <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}">
                <span class="text-danger">@error('first_name'){{ $message }} @enderror</span>
            </div>
            <div class="">
                <label for="">Kereszt név</label>
                <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}">
            </div>
            <div class="">
                <label for="">Irányítószám</label>
                <input type="text" name="zip_code" class="form-control" value="{{ old('zip_code') }}">
                <span class="text-danger">@error('zip_code'){{ $message }} @enderror</span>
            </div>
            <div class="">
                <label for="">Város</label>
                <input type="text" name="town" class="form-control" value="{{ old('town') }}">
                <span class="text-danger">@error('town'){{ $message }} @enderror</span>
            </div>
            <div class="">
                <label for="">Utcanév</label>
                <input type="text" name="street" class="form-control" value="{{ old('street') }}">
                <span class="text-danger">@error('street'){{ $message }} @enderror</span>
            </div>
            <div class="">
                <label for="">Közterült típusa</label>
                <select class="form-control" name="street_type">
                    <option value="">Kérem válasszon</option>
                        @foreach ($ps_lists as $ps_object)
                        <option value="{{ $ps_object->ps_name }}" 
                            @if(old('street_type') == $ps_object->ps_name)
                                selected
                            @endif  
                        >{{ $ps_object->ps_name }}</option>
                        @endforeach
                </select>
                <span class="text-danger">@error('street_type'){{ $message }} @enderror</span>
            </div>
            <div class="">
                <label for="">Házszám, emelet, ajtó</label>
                <input type="text" name="number_floor" class="form-control" value="{{ old('number_floor') }}">
                <span class="text-danger">@error('number_floor'){{ $message }} @enderror</span>
            </div>
            <div class="form-group">
                <label for="">Aktív</label>
                <input type="checkbox" name="active">
            </div>
            <div class="form-group">
                <label for="">Ezek legyenek a számlázási adatok is</label>
                <input type="checkbox" name="copy_invoice">
            </div>
            <button type="submit" class="btn-cart">Mentés</button>
        </div>
    </form>