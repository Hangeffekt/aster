<header>
	<div class="col-3"><a href="index.php"><img src="style/aster_logo.png" class="logo" alt="aster_bt_logo"></a></div>
	<div class="col-9 head-login">
		@if(session("LoggedUser"))
		<div class="head-login">
			<span><a class="login" href="/profile" alt="fiókom">Fiókom</a></span>
			<span><a class="login" href="/logout" alt="kilépés"><i class="fas fa-sign-out-alt"></i></a></span>
		@else
			<a class="login" href="/login">Bejelentkezés</a>
			<a class="login" href="/register">Regisztráció</a>
		@endif
		<a class="login" href="/cart"><i class="fas fa-shopping-cart"></i>
			
				<?php
					$x = 0;
					if($CountProducts != null){
						foreach($CountProducts as $object){
							if($object->user_id == session("LoggedUser")){
								$x++;
							}
						}
					}
				?>
				@if($x != 0)
					<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{ $x }}</span>
				@endif
			
		</a>
	</div>
</header>