import flash.external.ExternalInterface;
import mx.utils.Delegate;

class com.snaildom.listeners.UIListener {
	var gameshell:Object;
	var listeners:Array = [];
	
	var loaded:Boolean = false;
	
	function UIListener(gameshell) {
		this.gameshell = gameshell;
		
		this.init();
	}
	
	function init() {
		var oldUiLoaded = gameshell.dom.uiLoaded;
		
		gameshell.dom.uiLoaded = Delegate.create(this, function() {
			loaded = true;
			oldUiLoaded();
			
			for(var i in gameshell.rewritten.ui) {
				gameshell.ui[i] = gameshell.rewritten.ui[i];
			}
			
			for(var i in listeners) {
				var listener = listeners[i];
				
				listener(gameshell.ui);
			}
		});
	}
	
	function listen(callback) {
		listeners.push(callback);
		
		/*if(loaded) {
			callback();
		}*/
	}
}