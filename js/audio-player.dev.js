var shiwordAudioPlayer;

(function($) {

shiwordAudioPlayer = {

	//initialize
	init : function() {

		sw_AudioPlayer.setup( sw_SWFPlayer, {
			width: 415,
			loop: "yes",
			transparentpagebg: "yes",
			leftbg: "262626",
			lefticon: "aaaaaa",
			rightbg: "262626",
			righticon: sw_righticon,
			righticonhover: sw_righticonhover,
			animation: "no"
		});
		shiwordAudioPlayer.start();
	},

    start : function() {

		var the_id = 0;
		return $('audio').each(function() {
			the_id++;
			$(this).attr('id', 'sw-player-id' + the_id );
			var the_source = $(this).children('source:first-child');
			if ( the_source.size() !== 0 ) {
				the_href = the_source.attr('src');
				var the_type = the_href.substr( the_href.length - 4, 4 )
				switch (the_type)
				{
				case '.ogg':
					if ( !document.createElement("audio").canPlayType ) {
						$(this).parent().html('<span class="sw-player-notice">' + sw_unknown_media_format + ' (ogg)</span>');
					}
					break;
				case '.mp3':
					if ( !document.createElement("audio").canPlayType || (document.createElement("audio").canPlayType && !document.createElement("audio").canPlayType('audio/mpeg')) ) {
						sw_AudioPlayer.embed(this.id, {  
							soundFile: the_href
						});  
					}
					break;
				case '.m4a':
					if ( !document.createElement("audio").canPlayType || (document.createElement("audio").canPlayType && !document.createElement("audio").canPlayType('audio/x-m4a')) ) {
						$(this).parent().html('<span class="sw-player-notice">' + sw_unknown_media_format + ' (m4a)</span>');
					}
					break;
				default:
					$(this).parent().html('<span class="sw-player-notice">' + sw_unknown_media_format + '</span>');
				}				
			}
			
        });
        
    }

};

$(document).ready(function($){ shiwordAudioPlayer.init(); });

})(jQuery);

var sw_AudioPlayer = function () {
	var instances = [];
	var activePlayerID;
	var playerURL = "";
	var defaultOptions = {};
	var currentVolume = -1;
	var requiredFlashVersion = "9";
	
	function getPlayer(playerID) {
		if (document.all && !window[playerID]) {
			for (var i = 0; i < document.forms.length; i++) {
				if (document.forms[i][playerID]) {
					return document.forms[i][playerID];
					break;
				}
			}
		}
		return document.all ? window[playerID] : document[playerID];
	}
	
	function addListener (playerID, type, func) {
		getPlayer(playerID).addListener(type, func);
	}
	
	return {
		setup: function (url, options) {
			playerURL = url;
			defaultOptions = options;
			if (swfobject.hasFlashPlayerVersion(requiredFlashVersion)) {
				swfobject.switchOffAutoHideShow();
				swfobject.createCSS(".swf-audio-player small", "display:none;");
			}
		},

		getPlayer: function (playerID) {
			return getPlayer(playerID);
		},
		
		addListener: function (playerID, type, func) {
			addListener(playerID, type, func);
		},
		
		embed: function (elementID, options) {
			var instanceOptions = {};
			var key;
			
			var flashParams = {};
			var flashVars = {};
			var flashAttributes = {};
	
			// Merge default options and instance options
			for (key in defaultOptions) {
				instanceOptions[key] = defaultOptions[key];
			}
			for (key in options) {
				instanceOptions[key] = options[key];
			}
			
			if (instanceOptions.transparentpagebg == "yes") {
				flashParams.bgcolor = "#FFFFFF";
				flashParams.wmode = "transparent";
			} else {
				if (instanceOptions.pagebg) {
					flashParams.bgcolor = "#" + instanceOptions.pagebg;
				}
				flashParams.wmode = "opaque";
			}
			
			flashParams.menu = "false";
			
			for (key in instanceOptions) {
				if (key == "pagebg" || key == "width" || key == "transparentpagebg") {
					continue;
				}
				flashVars[key] = instanceOptions[key];
			}
			
			flashAttributes.name = elementID;
			flashAttributes.style = "outline: none";
			
			flashVars.playerID = elementID;
			
			swfobject.embedSWF(playerURL, elementID, instanceOptions.width.toString(), "24", requiredFlashVersion, false, flashVars, flashParams, flashAttributes);
			
			instances.push(elementID);
		},
		
		syncVolumes: function (playerID, volume) {	
			currentVolume = volume;
			for (var i = 0; i < instances.length; i++) {
				if (instances[i] != playerID) {
					getPlayer(instances[i]).setVolume(currentVolume);
				}
			}
		},
		
		activate: function (playerID, info) {
			if (activePlayerID && activePlayerID != playerID) {
				getPlayer(activePlayerID).close();
			}

			activePlayerID = playerID;
		},
		
		load: function (playerID, soundFile, titles, artists) {
			getPlayer(playerID).load(soundFile, titles, artists);
		},
		
		close: function (playerID) {
			getPlayer(playerID).close();
			if (playerID == activePlayerID) {
				activePlayerID = null;
			}
		},
		
		open: function (playerID, index) {
			if (index == undefined) {
				index = 1;
			}
			getPlayer(playerID).open(index == undefined ? 0 : index-1);
		},
		
		getVolume: function (playerID) {
			return currentVolume;
		}
		
	}
	
}();