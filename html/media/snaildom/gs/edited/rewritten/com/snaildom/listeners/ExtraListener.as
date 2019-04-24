import flash.external.ExternalInterface;
import mx.utils.Delegate;

class com.snaildom.listeners.ExtraListener {
	var gameshell:Object;
	var listeners:Array = [];
	
	function ExtraListener(gameshell) {
		this.gameshell = gameshell;
		
		this.init();
	}
	
	function init() {
		gameshell.uiListener.listen(Delegate.create(this, function() {
			gameshell.ui.loadExtra = Delegate.create(this, function(name, func) {
				if(name == "none") {
					gameshell.ui.interface_mc.extras_mc.loading_mc._visible = false;
					gameshell.ui.interface_mc.extras_mc.hideLoading();
					
					return;
				} // end if
				
				var _loc3 = gameshell.bridge.getContentLink("extra", name);
				gameshell.ui.interface_mc.extras_mc.load_mc.loadMovie(_loc3);
				
				var extras_mc = gameshell.ui.interface_mc.extras_mc;
				
				extras_mc.swapDepths(gameshell.ui.interface_mc.getNextHighestDepth());
				extras_mc.loading_mc._x = 220;
				extras_mc.loading_mc._visible = true;
				extras_mc.onEnterFrame = Delegate.create(this, function () {
					var _loc2 = Math.floor(extras_mc.load_mc.getBytesLoaded() / extras_mc.load_mc.getBytesTotal() * 100);
					
					if (isNaN(_loc2) || !_loc2) {
						_loc2 = 0;
					} // end if
					
					if (_loc2 < 100) {
						extras_mc.loading_mc.progress_txt.text = "Loading " + _loc2 + "%";
					} else {
						extras_mc.loading_mc._visible = false;
						
						for(var i in listeners) {
							var listener = listeners[i];
							
							if(name == listener.name) {
								listener.callback(extras_mc.load_mc);
							}
						}
						func(extras_mc.load_mc);
						
						extras_mc.onEnterFrame = null;
					} // end else if
				});
			});
			gameshell.dom.loadExtra = gameshell.ui.loadExtra;
		}));
	}
	
	function listen(extra, callback) {
		listeners.push({ name: extra, callback: callback });
	}
}