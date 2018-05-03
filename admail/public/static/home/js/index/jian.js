// JavaScript Document

jQuery(document).ready(function(){
	
	 //var font_size_persent = screen.width * 0.0020 ;
	 var font_size_persent = document.body.clientWidth   * 0.0020 ;
	 
	// alert(document.body.clientWidth);
	 
	 //alert(screen.width);
	 jQuery('.ui-mobile').attr("style","font-size:"+ font_size_persent +"px");
	 
	
	});
window.onresize = function(){
	 //alert(window.screen.availWidth);
	 var font_size_persent = document.body.clientWidth  * 0.0020 ;
	jQuery('.ui-mobile').attr("style","font-size:"+ font_size_persent +"px");
}


/*
(function(e, t) {
	function i() {
		var i = t.documentElement;
		n = i.offsetWidth, i.style.fontSize = 0.0020 * n + "px";
		var o = parseFloat(e.getComputedStyle(i, null)["font-size"]),
			u = 0.0020 * n;
		o !== u && (o > u + 1 || o < u - 1) && (i.style.fontSize = "1px")
	}
	var n, r = function() {
		setTimeout(function() {
			i()
		}, 300)
	};
	i(), e.addEventListener("resize", r)
})(window, document);
*/