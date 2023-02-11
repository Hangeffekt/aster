$(document).ready(function(){
	
	/**main nagyítás ha kevés a kontent */
	let contentHeight = $("#screen").height();

	let screenHeight = screen.height;

    if(contentHeight < screenHeight){
      //$("main").css("height", screenHeight-200);
	}

	/**end */

	/** cart-check */
	if(window.location.pathname == "/cart"){
		$("#cart-check-cart i").addClass("cart-check-active");
	}
	else if(window.location.pathname == "/delivery"){
		$("#cart-check-cart i").addClass("cart-check-success");
		$("#cart-check-delivery i").addClass("cart-check-active");
	}
	else if(window.location.pathname == "/payment"){
		$("#cart-check-cart i").addClass("cart-check-success");
		$("#cart-check-delivery i").addClass("cart-check-success");
		$("#cart-check-payment i").addClass("cart-check-active");
	}
	else if(window.location.pathname == "/checkout"){
		$("#cart-check-cart i").addClass("cart-check-success");
		$("#cart-check-delivery i").addClass("cart-check-success");
		$("#cart-check-payment i").addClass("cart-check-success");
		$("#cart-check-checkout i").addClass("cart-check-active");
	}
	else if(window.location.pathname == "/thankyou"){
		$("#cart-check-cart i").addClass("cart-check-success");
		$("#cart-check-delivery i").addClass("cart-check-success");
		$("#cart-check-payment i").addClass("cart-check-success");
		$("#cart-check-checkout i").addClass("cart-check-success");
	}

	/* delivery cost werite */
	if($("#delivery_address_need input").is(':checked')){
		console.log("megy");
		$(".delivery_address").css("display", "block");
	}

	$(".delivery_type_card").each(function(){

		if($(this).find("input").is(":checked")){
			let delivery_cost = $(this).find(".delivery_cost").text();
			let sub_total_price = parseInt($("#sum_cart_value").text()) + parseInt(delivery_cost);

			$("#sum_delivery_cost").text(delivery_cost);
			$("#sub_total_price").text(sub_total_price);
		}

		$(this).click(function(){
			let delivery_cost = $(this).find(".delivery_cost").text();
			let sub_total_price = parseInt($("#sum_cart_value").text()) + parseInt(delivery_cost);

			$(".delivery_type_card input").attr("checked", false);
			$(this).find("input").attr("checked", true);

			$("#sum_delivery_cost").text(delivery_cost);
			$("#sub_total_price").text(sub_total_price);

			if($(this).attr("id") == "delivery_address_need"){
				$(".delivery_address").css("display", "block");
				$(".fas").removeClass("fa-chevron-down");
				$(".fas").addClass("fa-chevron-up");

			}
			else {
				$(".delivery_address").css("display", "none");
				$(".fas").removeClass("fa-chevron-up");
				$(".fas").addClass("fa-chevron-down");
			}
		})
	})

	$(".delivery_address").each(function(){
		$(this).click(function(){
			$(".delivery_address input").attr("checked", false);
			$(this).find("input").attr("checked", true);
		})
	})

	$(".payment_type_card").each(function(){
		if($(this).find("input").is(":checked")){
			let delivery_cost = $("#sum_delivery_cost").text();
			let payment_cost = $(this).find(".payment_cost").text();
			let sub_total_price = parseInt($("#sum_cart_value").text()) + parseInt(payment_cost) + parseInt(delivery_cost);
			
			$("#sum_payment_cost").text(payment_cost);
			$("#sub_total_price").text(sub_total_price);
		}

		$(this).click(function(){
			let delivery_cost = $("#sum_delivery_cost").text();
			let payment_cost = $(this).find(".payment_cost").text();
			let sub_total_price = parseInt($("#sum_cart_value").text()) + parseInt(payment_cost) + parseInt(delivery_cost);

			$(".payment_type_card input").attr("checked", false);
			$(this).find("input").attr("checked", true);

			$("#sum_payment_cost").text(payment_cost);
			$("#sub_total_price").text(sub_total_price);
		})
	})

	$(".invoice_address").each(function(){
		$(this).click(function(){
			$(".invoice_address input").attr("checked", false);
			$(this).find("input").attr("checked", true);
		})
	})
	/** end */

	/** checkout page */

	$(".comment-title").click(function(){
		if($("#comment").hasClass("open")){
			$("#comment").css("display", "none");
			$("#comment").removeClass("open");
			$(".fas").removeClass("fa-chevron-up");
			$(".fas").addClass("fa-chevron-down");
		}
		else{
			$("#comment").css("display", "block");
			$("#comment").addClass("open");
			$(".fas").removeClass("fa-chevron-down");
			$(".fas").addClass("fa-chevron-up");
		}
			
	})

	$(".leftmenu-szuro").click(function (){
		if ($(".leftmenu").length == 1) {
			$("#leftmenu").addClass("block");
			$("#leftmenu").removeClass("leftmenu");
		}
		else{
			$("#leftmenu").removeClass("block");
			$("#leftmenu").addClass("leftmenu");
			
		}
	});

	/* cookie start*/
	$("#cookie").click(function () {
		$.post("fd_cookie.php",
		{
		cookie: "true"
		},
		function(data){
			if(data["cookie"] == true){
				$("#eucookielaw").css("display", "none");
				$("#closedCookie").css("display", "none");
			}
		},
	"json");
	});
	
	$("#cookieClose").click(function(){
		$("#eucookielaw").css("display", "none");
		$("#closedCookie").css("display", "block");
	});
	
	$("#cookieClosedButton").click(function(){
		$("#eucookielaw").css("display", "block");
		$("#closedCookie").css("display", "none");
	});
	/*cookie end*/

	/*popper tooltip start*/

	$('.tooltip-button')
		.mouseenter(function(){
			console.log("fel");
			$('#tooltip').css("display", "block");
		});
	$('.tooltip-button').mouseleave(function(){
			console.log("le");
			$('#tooltip').css("display", "none");
		});
	/*popper tooltip end*/

	// Get the modal
	var modal = $("#myModal");

	$("#prev, #next").click(function(){
		
	})

	$(".carousel-inner div").each(function(){
		var img = $(this).find("img");
		
		img.click(function(){
			modal.css("display", "block");
			modalImg.attr("src", img.attr("src"));
			captionText.innerHTML = img.attr("alt");
		});
	});

	var img = $("#myImg1");
	
	// Get the image and insert it inside the modal - use its "alt" text as a caption
	var modalImg = $("#img01");
	var captionText = $("#caption");

	img.click(function(){
		modal.css("display", "block");
		modalImg.attr("src", img.attr("src"));
		captionText.innerHTML = img.attr("alt");
	});

	// When the user clicks on image, close the modal
	$("#myModal").click(function() {
	modal.css("display", "none");
	})

});


