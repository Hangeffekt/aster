@extends('admin.app')

@section("title", "Brands")

@section("content")

    <div class="col-12">
        <h4>{{ $User->first_name }} {{ $User->last_name }}</h4>
    </div>
    <div class="col-4">
        <h3>Main datas</h3>
        <form action="{{ route('admin.modifyUser') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="first name">First name</label>
                <input type="text" name="first_name" class="form-control" value="{{ $User->first_name }}">
                <span class="text-danger">@error('first_name'){{ $message }} @enderror</span>
            </div>
            <div class="form-group">
                <label for="last name">Last name</label>
                <input type="text" name="last_name" class="form-control" value="{{ $User->last_name }}">
                <span class="text-danger">@error('last_name'){{ $message }} @enderror</span>
            </div>
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" name="email" class="form-control" value="{{ $User->email }}">
                <span class="text-danger">@error('email'){{ $message }} @enderror</span>
            </div>
            <div class="form-group">
                <label for="telephone">Telephone</label>
                <input type="text" name="telephone" class="form-control" value="{{ $User->telephone }}">
                <span class="text-danger">@error('telephone'){{ $message }} @enderror</span>
            </div>
            <input type="hidden" name="id" value="{{ $User->id }}">
            <button class="btn btn-block btn-primary" type="submit">Update</button>
        </form>
    </div>
    <div class="col-4">
        <h3>Address datas</h3>
        <form action="{{ route('admin.modifyAddress') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="">Család név</label>
                <input type="text" name="first_name" class="form-control" value="@if($modify_address != null){{ $modify_address->first_name }}@endif">
                <span class="text-danger">@error('first_name'){{ $message }} @enderror</span>
            </div>
            <div class="form-group">
                <label for="">Kereszt név</label>
                <input type="text" name="last_name" class="form-control" value="@if($modify_address != null){{ $modify_address->last_name }}@endif">
            </div>
            <div class="form-group">
                <label for="">Irányítószám</label>
                <input type="text" name="zip_code" class="form-control" value="@if($modify_address != null){{ $modify_address->zip_code }}@endif">
                <span class="text-danger">@error('zip_code'){{ $message }} @enderror</span>
            </div>
            <div class="form-group">
                <label for="">Város</label>
                <input type="text" name="town" class="form-control" value="@if($modify_address != null){{ $modify_address->town }}@endif">
                <span class="text-danger">@error('town'){{ $message }} @enderror</span>
            </div>
            <div class="form-group">
                <label for="">Utcanév</label>
                <input type="text" name="street" class="form-control" value="@if($modify_address != null){{ $modify_address->street }}@endif">
                <span class="text-danger">@error('street'){{ $message }} @enderror</span>
            </div>
            <div class="form-group">
                <label for="">Közterült típusa</label>
                <select class="form-control" name="street_type">
                    <option value="">Kérem válasszon</option>
                        @foreach ($ps_lists as $ps_object)
                        <option value="{{ $ps_object->ps_name }}"
                            @if($modify_address != null)
                                @if($ps_object->ps_name == $modify_address->street_type)
                                    selected
                                @endif   
                            @endif 
                        >{{ $ps_object->ps_name }}</option>
                        @endforeach
                </select>
                <span class="text-danger">@error('street_type'){{ $message }} @enderror</span>
            </div>
            <div class="form-group">
                <label for="">Házszám, emelet, ajtó</label>
                <input type="text" name="number_floor" class="form-control" value="@if($modify_address != null){{ $modify_address->number_floor }}@endif">
                <span class="text-danger">@error('number_floor'){{ $message }} @enderror</span>
            </div>
            @if($modify_address != null)
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
            @if($modify_address != null)
                <input type="hidden" name="address_id" value="{{ $modify_address->id }}">
            @endif
            <input type="hidden" name="user_id" value="{{ $User->id }}">
            <button type="submit" class="btn btn-block btn-primary">Módosít</button>
        </form>
        <a href="/admin/user/addresses/{{ $User->id }}">További címek</a>
    </div>
    <div class="col-4">
        <h3>Invoice datas</h3>
        <form action="{{ route('admin.modifyInvoice') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="">Család név</label>
                <input type="text" name="first_name" class="form-control" value="@if( $modify_invoice!= null){{ $modify_invoice->first_name }}@endif">
                <span class="text-danger">@error('first_name'){{ $message }} @enderror</span>
            </div>
            <div class="form-group">
                <label for="">Kereszt név</label>
                <input type="text" name="last_name" class="form-control" value="@if( $modify_invoice!= null){{ $modify_invoice->last_name }}@endif">
            </div>
            <div class="form-group">
                <label for="">Irányítószám</label>
                <input type="text" name="zip_code" class="form-control" value="@if( $modify_invoice!= null){{ $modify_invoice->zip_code }}@endif">
                <span class="text-danger">@error('zip_code'){{ $message }} @enderror</span>
            </div>
            <div class="form-group">
                <label for="">Város</label>
                <input type="text" name="town" class="form-control" value="@if( $modify_invoice!= null){{ $modify_invoice->town }}@endif">
                <span class="text-danger">@error('town'){{ $message }} @enderror</span>
            </div>
            <div class="form-group">
                <label for="">Utcanév</label>
                <input type="text" name="street" class="form-control" value="@if( $modify_invoice!= null){{ $modify_invoice->street }}@endif">
                <span class="text-danger">@error('street'){{ $message }} @enderror</span>
            </div>
            <div class="form-group">
                <label for="">Közterült típusa</label>
                <select class="form-control" name="street_type">
                    <option value="">Kérem válasszon</option>
                        @foreach ($ps_lists as $ps_object)
                        <option value="{{ $ps_object->ps_name }}"
                            @if( $modify_invoice!= null)
                                @if($ps_object->ps_name == $modify_invoice->street_type)
                                    selected
                                @endif   
                            @endif 
                        >{{ $ps_object->ps_name }}</option>
                        @endforeach
                </select>
                <span class="text-danger">@error('street_type'){{ $message }} @enderror</span>
            </div>
            <div class="form-group">
                <label for="">Házszám, emelet, ajtó</label>
                <input type="text" name="number_floor" class="form-control" value="@if( $modify_invoice!= null){{ $modify_invoice->number_floor }}@endif">
                <span class="text-danger">@error('number_floor'){{ $message }} @enderror</span>
            </div>
            @if( $modify_invoice != null)
                <div class="form-group">
                    <label for="">Aktív</label>
                    <input type="checkbox" name="active" class="form-control"
                    @if($modify_invoice->active == 1)
                        checked
                    @endif
                    >
                </div>
            @endif
            <div class="form-group">
                <label for="">Ezek legyenek a szállítási adatok is</label>
                <input type="checkbox" name="copy_invoice" class="form-control">
            </div>
            @if( $modify_invoice!= null)
                <input type="hidden" name="address_id" value="{{ $modify_invoice->id }}">
            @endif
            <input type="hidden" name="user_id" value="{{ $User->id }}">
            <button type="submit" class="btn btn-block btn-primary">Módosít</button>
        </form>
        <a href="/admin/user/invoices/{{ $User->id }}">További címek</a>
    </div>
    <div class="col-12">
        <h3>Orders</h3>
        <div class="tcontent thead">
            <div>Azonosító</div>
            <div>Rendelés dátuma</div>
            <div>Állapot</div>
            <div>Rendelés összege</div>
            <div></div>
        </div>
        
        @if($Orders != null)
        @foreach($Orders as $object)
        <div class="tcontent">
            <div class="rend_id">{{ $object->id }}</div>
            <div><strong class="mobil-cim">Rendelés dátuma: </strong>{{ $object->date }}</div>
            <div><strong class="mobil-cim">Állapot: </strong>{{ $object->status }}</div>
            <?php
            
            $sum_price = $object->delivery_cost;
            $sum_price += $object->payment_cost;
            $prices = 0;

            
            foreach($Products as $product){
                if($product["order_id"] == $object->id){
                    $prices = $product["qty"] * $product["price"];
                    $sum_price += $prices;
                }
            }
            
            ?>
            <div><strong class="mobil-cim">Rendelés összege</strong>{{ $sum_price }}</div>
            <div><a href="/order/{{ $object->id }}">Részletek</a></div>
        </div>
        @endforeach
        @endif
    </div>

@endsection