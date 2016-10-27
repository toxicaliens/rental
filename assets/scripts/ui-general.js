var UIGeneral = new function () {
	/***
	 * This is the code responsible for basic chat
	 */
	var state;
	var chatServiceURL;
	var updateTimer = null;

	function stopUpdateTimer() {
		clearInterval(updateTimer);
		intervalTimer = null;
	}
	
	function startUpdateTimer() {
		updateTimer = setInterval(function(){updateChat()}, 1000);
	}
	
	//Updates the chat
	function updateChat() {
		stopUpdateTimer();
		$.ajax({
			type: "POST", url: chatServiceURL,
			data: { 'function': 'update', 'state': state },
			dataType: "json",
			success: function(data) {
				if( typeof(data.text) !== "boolean" ) {
					for (var i=0; i<data.text.length; i++) {
						// Show in the chat message notification area
						$('#chat-area').append($('<p><span class="label label-inverse">'+ data.text[i].ChatTitle +"</span>"+data.text[i].Chat+"</p>"));
						
						// Show using the gritter function
						$.gritter.add({
							title: data.text[i].ChatTitle,
							text: data.text[i].Chat,
							class_name: 'gritter-light'
						});
						
						// Save the notification
						saveNotification(data.text[i].ChatTitle, data.text[i].Chat);
					}								  
				}
				document.getElementById('chat-area').scrollTop = document.getElementById('chat-area').scrollHeight;
				state = data.state; startUpdateTimer();
			},
		});
	}

	//send the message
	function sendChat(title, text) {       
		$.ajax({
			type: "POST", url: chatServiceURL,
			data: { 'function': 'send', 'title': title, 'text': text },
			dataType: "json"
		});
	}
	
	//gets the state of the chat
	function getStateOfChat() {
		$.ajax({
			type: "POST", url: chatServiceURL,
			data: { 'function': 'getState' },
			dataType: "json",
			success: function(data) {
				state = data.state;
				startUpdateTimer();
			}
		});
	}
	
	// Init the chart
	this.initChat = function (ctrl, csu) {
		// Set the chat service url
		chatServiceURL = csu;
			
		// Get state of chart
		getStateOfChat();
			
		// watch textarea for key presses
		ctrl.keydown(function(event){
			var key = event.which;

			//all keys including return.
			if (key >= 33) {
				var maxLength = $(this).attr("maxlength");  
				var length = this.value.length;  
						            
				// don't allow new content if length is maxed out
				if (length >= maxLength) event.preventDefault();
			}  
		});
			
		// watch textarea for release of key press
		ctrl.keyup(function(e) {
			if (e.keyCode == 13) {
				var text = $(this).val();
				var maxLength = $(this).attr("maxlength");
				var length = text.length;
				var title = "Sample Message";
						            
				// send
				if (length <= maxLength + 1) {
					sendChat(title, text);
					$(this).val("");
				} else {
					$(this).val(text.substring(0, maxLength));
				}
			}
		});
	}


	/***
	 * This is to facilitate the display of notifications
	 */
	function getColor(c) {
		var s = c.css('border-top-color'), b = c.css('background-color');
		s = s.replace(/\s/g, ''); b = b.replace(/\s/g, '');
		
		if (
			b.indexOf("rgb(0,0,0")>=0 || b.indexOf("rgba(0,0,0")>=0 || 
			b.indexOf("rgb(255,255,255")>=0 || b.indexOf("rgba(255,255,255")>=0
		) b = "#399bc3";
		
		if (s.indexOf("rgb(0,0,0")>=0 || s.indexOf("rgba(0,0,0")>=0)
			return b;
		return s;
	}
	
	function handlePulsate() {
		// pulsate plugin does not support IE8 and below
		if (!jQuery().pulsate || App.isIE8()==true) return;
		
		// Init pulsate items
		if (jQuery().pulsate) {
			jQuery('.pulsate-regular').each(function(){
				var c = jQuery(this);
				c.pulsate({
					color: getColor(c)
				});
			});
			
			jQuery('.pulsate-hover').each(function(){
				var c = jQuery(this);
				c.pulsate({
					color: getColor(c),
					onHover: true
				});
			});
			
			jQuery('.pulsate-crazy').each(function(){
				var c = jQuery(this);
				c.pulsate({
					color: getColor(c),
					reach: 50,
					repeat: 10,
					speed: 100,
					glow: true
				});
			});
			
			jQuery('.pulsate-crazy-hover').each(function(){
				var c = jQuery(this);
				c.pulsate({
					color: getColor(c),
					reach: 50,
					repeat: 10,
					speed: 100,
					glow: true,
					onHover: true
				});
			});
		}
	}
	
	function saveNotification(title, text) {
		$("#smsContainer .notice-title").html('<p>Recent Notifications</p>');
		$("#smsContainer").append('<li><a href="#"><span class="subject"><span class="from">'+title+'</span><span class="time">16 mins</span></span>'+'<span class="message">'+text+'</span></a></li>');
		
		var i = 0;
		$("#smsContainer li").each(function(){ i++ });
		if ( i > 6 ) $("#smsContainer .notice-title").next().remove();
	}
	
	function showNotification (title, text, imageUrl, sticky, time, className) {
		// Ensure valid input
		if ( !jQuery.gritter || typeof(title) === "undefined" || typeof(text) === "undefined" ) return false;
		
		var params = {};
		// (string | mandatory) the heading of the notification
		params["title"] = title;
		// (string | mandatory) the text inside the notification
		params["text"] = text;
		// (string | optional) the image to display on the left
		if ( typeof(imageUrl)!=="undefined" && imageUrl!="" ) params["image"] = imageUrl;
		// (bool | optional) if you want it to fade out on its own or just sit there
		if ( typeof(sticky)!=="undefined" && sticky!="" ) params["sticky"] = sticky;
		// (int | optional) the time you want it to be alive for before fading out
		if ( typeof(time)!=="undefined" && time!="" ) params["time"] = time;
		// (string | optional) the class name you want to apply to that specific message
		if ( typeof(className) !== "undefined" ) params["class_name"] = className;
		
		// Show the notification
		$.gritter.add(params);
		
		// Save the notification
		saveNotification(title, text);
		
		// Process ended well
		return true;
	}
	
	this.stickyNotification = function (title, text, imageUrl) {
		return showNotification(title, text, imageUrl, true, "", "my-sticky-class");
	}
	
	this.regularNotification = function (title, text, imageUrl) {
		return showNotification(title, text, imageUrl);
	}
	
	this.lightNotification = function (title, text, imageUrl) {
		return showNotification(title, text, imageUrl, false, "", "gritter-light");
	}
	
	this.closeAllNotifications = function () {
		if ( !jQuery.gritter ) return false;
		$.gritter.removeAll();
		return true;
	}
	
	// place all items to init here
	this.init = function () {
		handlePulsate();
	}
};

