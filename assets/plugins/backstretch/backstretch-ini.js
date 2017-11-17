$(document).ready(function() {
	$.getScript("assets/plugins/backstretch/jquery.backstretch.min.js", function(){
		$(".fullscreen-static-image").backstretch([
	  "assets/images/bg/img11.jpg", "assets/images/bg/img1.jpg",
	  ], {duration: 8000, fade: 800});
		$(".fullscreen-static-image1").backstretch([
	  "assets/images/bg/img10.jpg",
	  ], {duration: 8000, fade: 800});	  
		$(".fullscreen-static-image2").backstretch([
	  "assets/images/bg/img4.jpg",
	  ], {duration: 8000, fade: 800});
		$(".fullscreen-static-image3").backstretch([
	  "assets/images/bg/img5.jpg",
	  ], {duration: 8000, fade: 800});
		$(".fullscreen-static-image4").backstretch([
	  "assets/images/bg/img6.jpg",
	  ], {duration: 8000, fade: 800});
		$(".fullscreen-static-image5").backstretch([
	  "assets/images/bg/img7.jpg",
	  ], {duration: 8000, fade: 800});
		$(".fullscreen-static-image6").backstretch([
	  "assets/images/bg/img8.jpg",
	  ], {duration: 8000, fade: 800});
	});
});