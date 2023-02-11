<nav class="navbar navbar-expand-lg top_menu col-12 navbar-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item mobil-login dropdown">
          <a class="nav-link lablec" href="index.php?page=3">Bejelentkezés</a>
        </li>
        <li class="nav-item mobil-reg dropdown">
          <a class="nav-link lablec" href="index.php?page=4">Regisztráció</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/">Home</a>
        </li>
        
        @foreach($catalogs as $catalog)
          @if($catalog->parent_id == 0)
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              {{$catalog->name}}
            </a>
            <?php $parent_id = $catalog->id;?>
            @include('include.sub_nav')
          </li>
          @endif
        @endforeach
      </ul>
      <form class="d-flex" role="search" method="post" action="{{ route('search') }}">
        @csrf
        <input class="form-control mr-sm-2" type="search" placeholder="Keresés..." aria-label="Search" name="search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="kereses">Keresés</button>
      </form>
    </div>
  </div>
</nav>
@if(Session::get('fail'))
    <div class="alert alert-danger">{{ Session::get('fail') }}</div>
@elseif(Session::get('success'))
  <div class="alert alert-success">{{ Session::get('success') }}</div>
@endif