function AjaxGo(layer,func,att,rc,img) {
	var Ajax = new ajaxObject(layer,"Include/ServerSideAjax.php",rc,img);
	Ajax.update("func="+func+att);
}

function AjaxGo2(layer,func,att,rc,img) {
	if (img===undefined) {
		img = "";
	}
	var Ajax = new ajaxObject(layer,"../Include/ServerSideAjax.php",rc,img);
	Ajax.update("func="+func+att);
}

function AjaxRun(func,att) {
	var Ajax = new ajaxObject("temp","Include/ServerSideAjax.php");
	Ajax.update("func="+func+att);
}

function AjaxRun2(func,att) {
	var Ajax = new ajaxObject("temp","../Include/ServerSideAjax.php");
	Ajax.update("func="+func+att);
}

function AjaxSQL(layer,sql,fld) {
	var Ajax = new ajaxObject(layer,"Include/ServerSideAjax.php");
	Ajax.update("func=AjaxSQL&sql="+sql+"&fld="+fld);	
}

function AjaxSQL2(layer,sql,fld) {
	var Ajax = new ajaxObject(layer,"../Include/ServerSideAjax.php");
	Ajax.update("func=AjaxSQL&sql="+sql+"&fld="+fld);	
}


function ajaxObject(layer, url, rc, img) {
   var that = this;
   var updating = false;
   this.callback = function(ret,layer) {
		if (rc!="") {
			eval(rc)(ret,layer);
		}
   }
   
   var LayerID = document.getElementById(layer);
   var urlCall = url;

   this.update = function(param) {
   
      if (updating==true) { return false; }
      updating=true;
      
      var AJAX = null;
      
      if (window.XMLHttpRequest) {
         AJAX=new XMLHttpRequest();
      } else {
         AJAX=new ActiveXObject("Microsoft.XMLHTTP");
      }
      
      if (AJAX==null) {
         alert("Your browser doesn't support AJAX.");
         return false
      } else {
	      
         AJAX.onreadystatechange = function() {
          	
			var loading = "";
			if (img!="") {
				loading = "<center><img src='"+img+"'></center>";//"<center><img src='"+img+"' width='10px'></center>";
			} else {
				loading = "";//"<center><img src='Images/loading.gif'></center>";
			}
			
         	if (AJAX.readyState==1 || AJAX.readyState=="loading") {
				if(LayerID){
					if(loading != ""){
						LayerID.innerHTML = loading;
					}
				}
			}
			
			if (AJAX.readyState==2) {
				if(LayerID){
				LayerID.innerHTML = "<!--span>GOT</span-->";
				}
			}
			
			if (AJAX.readyState==3) {
				if(LayerID){
				LayerID.innerHTML = loading; //"<!--span>REPLY</span-->";
				}
			}
			
			if (AJAX.readyState==4 || AJAX.readyState=="complete") {
				rObj = AJAX.responseText;
				if (rc!="") {
					that.callback(rObj,layer);
				} else {
					if(LayerID){
					LayerID.innerHTML = rObj;
					that.callback();
					}
				}
				delete AJAX;
				updating=false;
				
            }
         }
         var timestamp = new Date();
         var uri=urlCall+'?'+param+'&timestamp='+(timestamp*1);
         AJAX.open("GET", uri, true);
         AJAX.send(null);
         return true;
      }
   }
}


/*

// html onclick call javascript function
<input id="data"><button onClick="test()">test</button>
<div id="test"></div>

// javascript call ajaxscript fucntion
function test() {
	var func = "test";					// php function name in php process
	var layer = "test";					// html output div layer
	var att = "data="+$("data").value;	// data to pass to php process
	var rc = "receive";					// javascript return function name
	AjaxGo(layer,func,att,rc);			// ajax object call
}

// php process
$func = $_GET["func"];

if ($func!="") { $func(); }

function test() {
	$data = $_GET["data"];
	echo $data;
}

//javascript return
function receive(data,layer) {
	document.getElementById(layer).innerHTML=data;
}

*/
