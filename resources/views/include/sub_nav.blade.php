<ul class="dropdown-menu top_menu" aria-labelledby="navbarDropdown">
    @foreach($catalogs as $catalog)
        <li>
            @if($catalog->parent_id == $parent_id)
                @if($catalog->sub_menu == null)
                        <div class="menu menu-first">{{$catalog->name}}</div>
                        <?php $parent_id2 = $catalog->id?>
                        @foreach($catalogs as $catalog2)
                            @if($catalog2->parent_id == $parent_id2)
                            <i><a class="menu" href="/catalog/{{$catalog2->url}}">{{$catalog2->name}}</a></i>
                            @endif
                        @endforeach
                        <?php $parent_id2 = $catalog->id;?>
                @else
                    <a class="menu menu-first" href="/catalog/{{$catalog->url}}">{{$catalog->name}}</a>
                @endif
            @endif
        </li>
    @endforeach
</ul>