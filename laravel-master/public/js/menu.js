function disableSide(){
	if ($("#menu").hasClass("active")) {
		$("#menu").toggleClass("active");
		// $(".main-container").toggleClass("active");
		$("#menu-left").toggleClass("inactive");
		$("#header-menu-left").toggleClass("active");
	}
	if ($("#menu-left").hasClass("active")) {
		$("#menu-left").toggleClass("active");
		$("#header-menu-left").toggleClass("active");
		// $(".main-container").toggleClass("active-left");
		$("#menu").toggleClass("inactive");
	}
}

$(".menu-link").click(function() {
	if ($("#menu-left").hasClass("active")) {
		$("#menu-left").toggleClass("active");
		$("#header-menu-left").toggleClass("active");
		// $(".main-container").toggleClass("active-left");
		$("#menu").toggleClass("inactive");
	}
	$("#menu").toggleClass("active");
	// $(".main-container").toggleClass("active");
	$("#menu-left").toggleClass("inactive");
	$("#header-menu-left").toggleClass("inactive");
});
$(".menu-link-left").click(function() {
	if ($("#menu").hasClass("active")) {
		$("#menu").toggleClass("active");
		// $(".main-container").toggleClass("active");
		$("#menu-left").toggleClass("inactive");
		$("#header-menu-left").toggleClass("inactive");
	}
	$("#menu-left").toggleClass("active");
	$("#header-menu-left").toggleClass("active");
	// $(".main-container").toggleClass("active-left");
	$("#menu").toggleClass("inactive");
});
