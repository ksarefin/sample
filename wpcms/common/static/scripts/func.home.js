j$(document).ready(function() {
	// image slider
	j$("#slider").delay(200).fadeIn(500);
	j$('#slider').nivoSlider({
		effect:'sliceUpDownRight',
		slices: 15,
		boxCols: 18,
		boxRows: 4,
		pauseTime: 5500,
		pauseOnHover : false,
		directionNav:false,
		directionNavHide:false,
		controlNav:false,
		controlNavThumbs:false
	});
});
