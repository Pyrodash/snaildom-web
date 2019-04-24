import flash.external.ExternalInterface;
import mx.utils.Delegate;

class com.snaildom.listeners.AreaListener {
	var gameshell:Object;
	var listeners:Array = new Array();
	
	function AreaListener(gameshell) {
		this.gameshell = gameshell;
		
		init();
	}
	
	function init() {
		var oldHandler = Delegate.create(gameshell.server, gameshell.server.jsonmessages['area']);
		gameshell.server.listen('area', Delegate.create(this, function(params) {
			var currentArea = gameshell.bridge.currentArea;
			
			if(currentArea) {
				emit('left', currentArea.id, gameshell.dom.area_mc, currentArea);
			}
			
			emit('join', params.id, params, currentArea);
			oldHandler(params);
		}));
		
		var oldLoader = Delegate.create(gameshell.dom, gameshell.dom.loadArea);
		gameshell.dom.loadArea = Delegate.create(this, function(name) {
			oldLoader(name);
			
			var area_mc = gameshell.dom.area_mc;
			var oldEnterFrame = Delegate.create(area_mc, area_mc.onEnterFrame);
			
			emit('load', name, area_mc);
			area_mc.onEnterFrame = Delegate.create(this, function() {
				if(area_mc.load_mc.getBytesTotal() > 0)
				{
					if(area_mc.load_mc.getBytesLoaded() == area_mc.load_mc.getBytesTotal())
					{
						emit('joined', name, area_mc);
					}
				}
				
				oldEnterFrame();
			});
		});
	}
	
	function listen(type, name, self, callback) {
		var types = ['join', 'joined', 'left'];
		var aliases = {
			left: ['leave']
		};
		
		for(var i in aliases) {
			var arr = aliases[i];
			
			if(arr.indexOf(name) > -1) {
				name = i;
			}
			
			if(arr.indexOf(type) > -1) {
				type = i;
			}
		}
		
		if(callback === undefined) {
			var nType = typeof name;
			
			if(nType == 'function') {
				callback = name;
				name = type;
				type = null;
				self = null;
			} else if(nType == 'object' || nType == 'movieclip') {
				callback = self;
				self = name;
				name = type;
				type = null;
			}
		}
		
		if(!type || includes(type, types) == -1) {
			type = 'join';
		}
		
		if(includes(name, types) > -1) {
			type = name;
			name = null;
		}
		
		listeners.push({
			name: name,
			type: type,
			callback: callback,
			self: self
		});
	}
	
	function emit(type, name) {
		// Parse arguments
		var args = [];
		var begin = 2; // Start at argument #3 (1 and 2 are already taken by type and name)
		
		if(arguments.length > 0) {
			for(var i = begin; i < arguments.length; i++) {
				args.push(arguments[i]);
			}
		}
		
		for(var i in listeners) {
			var listener = listeners[i];
			
			if(listener.type == type && (!listener.name || listener.name == name)) {				
				if(args.length > 1) {
					if(listener.self) {
						listener.callback.apply(listener.self, args);
					} else {
						listener.callback(args); // We have to send arguments as one array only because we can't use listener.apply since we don't have access to the thisArg of the listener.
					}
				} else {
					listener.callback(args[0]);
				}
			}
		}
	}
	
	private function includes(param, arr) {
		for(var i in arr) {
			if(arr[i] == param) {
				return true;
			}
		}
		
		return false;
	}
}