/**
 * This function will be called whenever the page has completed loading to 
 * identify all map items and give them the relevant google settings
 */
if ( typeof(google) !== 'undefined' ) {
	google.maps.event.addDomListener (window, "load", function(){
		var e = document.getElementById("gmap_canvas");

		var map = new google.maps.Map(e, {
			center: new google.maps.LatLng(e.getAttribute('data-longitude'),e.getAttribute('data-latitude')),
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			zoom: 14
		});

		var marker = new google.maps.Marker({
			position: new google.maps.LatLng(e.getAttribute('data-longitude'),e.getAttribute('data-latitude')),
			map: map
		});
	});
}