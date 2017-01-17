var counter = 1;
var limit =50;
var counter2 = 4;

function addDashes(f){
	num = f.value;
	parts = [num.slice(0,2),num.slice(2,4),num.slice(4,6),num.slice(6,8),num.slice(8,12)];
	fNum = parts[0]+"-"+parts[1]+"-"+parts[2]+"-"+parts[3];
	f.value = fNum;
}

function verifyEmail(obj){
var status = false;     
var emailRegEx = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i;
     if (document.getElementById(obj).value.search(emailRegEx) == -1) {
          document.getElementById(obj).focus(obj);
		  alert("Sila masukkan alamat email yang sah.");		  
     }
	 else {
          status = true;
     }
     return status;
}

function kadar_harga(){
	
	if(document.getElementById("checkbox_kos").checked == true){
		document.getElementById("kos").value = "";
		document.getElementById("kos").disabled = true;	
		AjaxGo("kosdisplay","kos_ajax","","","");	
	}
	if(document.getElementById("checkbox_kos").checked == false){
		document.getElementById("kos").disabled = false;
		AjaxGo("kosdisplay","kos_ajax2","","","");		
	}
}
function kod_bidang_2(){
	
	var x = document.getElementById("sub_bidang").value;
	var y = x.split("|");
	var z = y[1]
	
	document.getElementById("kod_2").value = z;
}
function radio_button(idname)
{
		var radio = idname;
		for (var x = 0; x < radio.length; x ++) 
		{
			if (radio[x].checked) 
			{
			var idname = radio[x].value;
			return idname;	
			}
		}
}

function check_box(idname)
{	
	var check_box = idname;
		for (var x = 0; x < check_box.length; x ++) 
		{
			if (check_box[x].checked) 
			{
			var idname = check_box[x].value;
			return idname;
			}
		}
}

function capitalize(text) {
	
	var text2 = text.value;
	var text3 = text2.toUpperCase();
	text.value = text3;
}

function first_uppercase(obj){
	
		var text2 = obj.value;
		//var text2 = text.toLowerCase();
		var val = text2;
		
        newVal = '';
        val = val.split(' ');
        for(var c=0; c < val.length; c++) {
                newVal += val[c].substring(0,1).toUpperCase() + val[c].substring(1,val[c].length) + ' ';
        }
        obj.value = newVal;
	
}

function removeCounter() {
	
	counter=counter-1;
	document.getElementById("counter").value=counter;
}

function removeCounter2() {
	
	counter2=counter2-1;
	document.getElementById("counter2").value=counter2;	
}
	
function addInput(divName){
		
     if (counter == limit)  {
          alert("You have reached the limit of adding " + counter + " inputs");
     }
     else {
		  //var counter_pemilik = document.getElementById("counter_pemilik").value;
		  //alert(counter);
		  counter++;
		  document.getElementById("counter").value=counter;
          var newdiv = document.createElement('div');
          newdiv.innerHTML = '<br /><br /><input type="button" value="Batal Pemilik" onclick="this.parentNode.parentNode.removeChild(this.parentNode)" /> '+
		    '<table width="200" border="0" style="padding:2px; width:100%; border:#999999 1px solid"> '+
                                '<tr> '+
                                  '<td width="32%">&nbsp;&nbsp;&nbsp;&nbsp;<strong>Maklumat Pemilik '  + (counter) +'</strong></td> '+
                                  '<td width="68%">&nbsp;</td> '+
                                '</tr> '+
                                '<tr> '+
                                 ' <td>&nbsp;&nbsp;&nbsp;&nbsp;Pemilik </td> '+
                                  '<td><input accept="check" name="pemilik'+counter+'" type="text" id="pemilik" size="40" />  '+
                                  '</td> '+
                                '</tr> '+
								'<tr> '+
                                 ' <td>&nbsp;&nbsp;&nbsp;&nbsp;Kad Pengenalan</td> '+
                                  '<td><input accept="check" name="no_ic'+counter+'" type="text" id="kad penggenalan" size="40" onKeyUp="checknumber(this)" onblur="checknumber(this)" onchange="checknumber(this)" /> '+
                                  '</td> '+
                                '</tr> '+
                                '<tr> '+
                                  '<td>&nbsp;&nbsp;&nbsp;&nbsp;Alamat</td> '+
                                  '<td><textarea name="alamat'+counter+'" id="alamat1" cols="45" rows="5"></textarea></td> '+
                                '</tr> '+
                                '<tr> '+
                                 ' <td>&nbsp;&nbsp;&nbsp;&nbsp;No. Telefon</td> '+
                                  '<td><input name="telefon'+counter+'" type="text" id="no tel" size="40" onKeyUp="checknumber(this)" onblur="checknumber(this)" onchange="checknumber(this)" /> '+
                                  '</td> '+
                                '</tr> '+
								'<tr> '+
                                 ' <td>&nbsp;&nbsp;&nbsp;&nbsp;No. Telefon 2</td> '+
                                  '<td><input name="telefon2'+counter+'" type="text" id="no tel" size="40" onKeyUp="checknumber(this)" onblur="checknumber(this)" onchange="checknumber(this)" /> '+
                                  '</td> '+
                                '</tr> '+  
                                '<tr> '+
                                 ' <td>&nbsp;</td> '+
                                 ' <td> '+
                                  '</div></td> '+
                                '</tr> '+
                              '</table>';
          document.getElementById(divName).appendChild(newdiv);
     }
		resetHeight();
}

function resetHeight() {
	layer = "txtupdateuser";
	bg = "popupbg";
	var top = document.body.scrollTop;
	var ypos = document.body.clientHeight;
	var h = xDocSize("h");
	var height = parseInt(document.getElementById(layer).style.height);
	
	var divHeight=document.getElementById(layer).clientHeight;
	document.getElementById(bg).style.height = divHeight+(ypos/2);

}

function removechild(removechild){
	
counter2=counter2-1;	
removechild.parentNode.parentNode.removeChild(removechild.parentNode)	
	
}

function addinsuran(divName){

     if (counter2 == limit)  {
          alert("You have reached the limit of adding " + counter2 + " inputs");
     }
     else {
		  counter2++;
		  document.getElementById("counter2").value=counter2;
          var newdiv = document.createElement('div');
          newdiv.innerHTML = '<table width="100%" border="0"> '+
                                  '<tr> '+
                                  	'<td width="6%" align="right">' + counter2+'.</td> '+
                                    '<td width="34%"><input type="text" name="insuran'+counter2+'" id="insuran'+counter2+'" size="40" /></td> '+
                                    '<td width="43%">&nbsp;RM '+
                                      '<label for="textfield4"></label> '+
                                      '<input type="text" name="nilai'+counter2+'" id="nilai'+counter2+'" onkeyup="numberkos(this)" onblur="numberkos(this)" onchange="numberkos(this)"/> '+
                                    '<input type="button" name="Batal" id="Batal" value="Batal" onclick="removechild(this.parentNode)" /></td> '+
                                  '</tr> '+
                                  '</table> ';
          document.getElementById(divName).appendChild(newdiv);
     }
}

function masukdata(colno,pid,dpid) {
	//alert(colno+"^"+pid+"^"+dpid);
	if ((colno!="")&&(pid!="")) {
		AjaxGo("txtupdateuser","masukdata","&colno="+colno+"&projek_id="+pid+"&dpid="+dpid,"update12","");
	}
}

function insertdata() {
	var fizikal = document.getElementById("fizikal").value;
	var project_id = document.getElementById("project_id").value;
	var columnnum = document.getElementById("columnnum").value;
	var date_pay = document.getElementById("date_pay").value;
	var amount = document.getElementById("amount").value;
	if ((date_pay!="")||(amount!="")) {
		alert("Sila lengkapkan maklumat pembayaran sebelum simpan.");
		if (date_pay=="") {
			document.getElementById("date_pay").style.backgroundColor="#ff8080";
			document.getElementById("date_pay").onclick = function() { document.getElementById("date_pay").style.backgroundColor=""; }
		}
		if (amount=="") {
			document.getElementById("amount").style.backgroundColor="#ff8080";
			document.getElementById("amount").onclick = function() { document.getElementById("amount").style.backgroundColor=""; }
		}
	} else {
		AjaxGo("temp","checkFizikal","&fizikal="+fizikal+"&pid="+project_id+"&columnnum="+columnnum,"insertdatacont","images/loading.gif");
	}
	//alert(fizikal+">>"+kewangan+">>>"+bayaran+">>>"+catatan+">>>"+project_id+">>>"+columnnum+">>>"+date_data+">>>"+year_data); 
	//check fizikal data exceeds last fizikal data or not
}

function insertdatacont(data,layer) {
	var fizikal = document.getElementById("fizikal").value;
	var catatan = document.getElementById("catatan").value;
	var project_id = document.getElementById("project_id").value;
	var columnnum = document.getElementById("columnnum").value;
	var date_data = document.getElementById("date_data").value;
	var year_data = document.getElementById("year_data").value;
	
	var dataArr = data.split("^");
	
	//alert(dataArr[0]);
	
	if (dataArr[0]==1) {
		document.getElementById("popupbg").style.display="none";
		document.getElementById("txtupdateuser").style.display="none";
		document.body.style.overflowX="auto";
		document.body.style.overflowY="auto";
		AjaxGo("projectData","insertdata","&fizikal="+fizikal+"&catatan="+catatan+"&project_id="+project_id+"&columnnum="+columnnum+"&date_data="+date_data+"&year_data="+year_data,"loadFindProj","images/loading.gif");
	} else if (dataArr[0]==2) {
		alert("Peratusan kemajuan fizikal kurang daripada peratusan sebelum. ("+dataArr[1]+"%)");
		document.getElementById("fizikal").select();
	} else if (dataArr[0]==3) {
		alert("Peratusan kemajuan fizikal sama dengan peratusan sebelum. ("+dataArr[1]+"%)");
		document.getElementById("fizikal").select();
	} else if (dataArr[0]==4) {
		alert("Peratusan kemajuan fizikal sama dengan peratusan selepas. ("+dataArr[1]+"%)");
		document.getElementById("fizikal").select();
	} else if (dataArr[0]==5) {
		alert("Peratusan kemajuan fizikal lebih besar daripada peratusan selepas. ("+dataArr[1]+"%)");
		document.getElementById("fizikal").select();
	} else if (dataArr[0]==6) {
		document.getElementById("popupbg").style.display="none";
		document.getElementById("txtupdateuser").style.display="none";
		document.body.style.overflowX="auto";
		document.body.style.overflowY="auto";
		AjaxGo("projectData","insertdata","&fizikal="+fizikal+"&catatan="+catatan+"&project_id="+project_id+"&columnnum="+columnnum+"&date_data="+date_data+"&year_data="+year_data,"loadFindProj","images/loading.gif");
	}
}

function displayinsertdata(data,layer) {
	dataArr = data.split("|");
	document.getElementById(layer+"_1").innerHTML = dataArr[0];
	document.getElementById(layer+"_2").innerHTML = dataArr[1];
}

function getCheckedRadio() {
      var radioButtons = document.getElementsByName("radio");
      for (var x = 0; x < radioButtons.length; x ++) {
        if (radioButtons[x].checked) {
          alert("You checked " + radioButtons[x].value);
        }
      }
 }
 
function limitText(limitField, limitCount, limitNum) {
	if (limitField.value.length > limitNum) {
		limitField.value = limitField.value.substring(0, limitNum);
	} else {
		limitCount.value = limitNum - limitField.value.length;
	}
}

function checknumber(obj){
	
	obj.value=obj.value.replace(/[^\d]/g,'');
}

function numberkos(MyString){
	
		var x = MyString.value;
		y=x.replace(/[^\d.]/g,'');
		 var objRegex  = new RegExp('(-?[0-9]+)([0-9]{3})');

		 //Check For Criteria....
		 while(objRegex.test(y))
		 {
					 //Add Commas After Every Three Digits Of Number...
					 y = y.replace(objRegex, '$1,$2');
		 }
		 var n = y.indexOf(".");
			if (n!=-1) {
				if(y.length>n+2) {
					y=y.substr(0,n+3);
				}
			}
			
		MyString.value=y;
}

function checkform() {
	
	for(var i=0;i<document.theForm.elements.length;i++){
		if(document.theForm.elements[i].accept == 'check'){
			if(document.theForm.elements[i].type == 'text'){
				if(document.theForm.elements[i].value != ''){
					document.theForm.elements[i].style.backgroundColor = '';
				}
			}
			if(document.theForm.elements[i].type == 'select-one'){
				if(document.theForm.elements[i].value != '0'){
					document.theForm.elements[i].style.backgroundColor = '';
				}
			}
			if(document.theForm.elements[i].type == 'textarea'){
				if(document.theForm.elements[i].value != ''){
					document.theForm.elements[i].style.backgroundColor = '';
				}
			}
		}		
	}
	
	for(var i=0;i<document.theForm.elements.length;i++){
		
		if(document.theForm.elements[i].accept == 'check'){
			if(document.theForm.elements[i].type == 'text'){
				if(document.theForm.elements[i].value == ''){
					document.theForm.elements[i].style.backgroundColor = '#ff8080';
					document.theForm.elements[i].onclick = function() { document.theForm.elements[i].style.backgroundColor=""; }
				}
			}
			if(document.theForm.elements[i].type == 'textarea'){
				if(document.theForm.elements[i].value == ''){
					document.theForm.elements[i].style.backgroundColor = '#ff8080';
				}
			}
			if(document.theForm.elements[i].type == 'select-one'){
				if(document.theForm.elements[i].value == '0'){
					document.theForm.elements[i].style.backgroundColor = '#ff8080';
				}
			}
			if(document.theForm.elements[i].type == "radio"){
				var y = document.theForm.elements[i].name;
				var radio = document.getElementsByName(y);
				for (var x = 0; x < radio.length; x ++) 
				{
					if (radio[x].checked == false)
					{
						document.theForm.elements[i].style.backgroundColor = '#ff8080';
					}
					
					if (radio[x].checked == true)
					{
						for (var x = 0; x < radio.length; x ++) {
							document.theForm.elements[i].style.backgroundColor = '';
						}
					}
				}
			}
		}
	}
	
	for(var i=0;i<document.theForm.elements.length;i++){
		if(document.theForm.elements[i].style.backgroundColor == "#ff8080"){
			//alert(document.theForm.elements[i].name)
			//alert("Sila lengkapkan yang bertanda merah");
			return false;
		}
		//athirah 28092012 start
		if((document.getElementById("datemula")) || (document.getElementById("datetamat")))
		{
			var datemula = document.getElementById("datemula").value;
			var datetamat = document.getElementById("datetamat").value;
			var stat = true;
				
			arraymula = datemula.split("-"); 
			var daymula = parseFloat(arraymula[0]);
			var monthmula = parseFloat(convertmonth2(arraymula[1]));
			var yearmula = parseFloat(arraymula[2]);
			
			arraytamat = datetamat.split("-"); 
			var daytamat = parseFloat(arraytamat[0]);
			var monthtamat = parseFloat(convertmonth2(arraytamat[1]));
			var yeartamat = parseFloat(arraytamat[2]);
				
			if(yearmula > yeartamat ){
				stat = false;
			}
			
			if(yearmula == yeartamat) {
				if(monthmula == monthtamat){
					if(daymula > daytamat){
						stat =  false;
					}
				}
				if(monthmula > monthtamat){
					stat =  false;
				}
			}
						
			if (stat == false) {
				alert("Sila masukkan tarikh mula dan tarikh siap yang sah.");
				return stat;
			}
			//athirah 28092012 end
		}
	}
	if(document.getElementById('jangkamasa')){
		if(document.getElementById('jangkamasa').value == "Tiada" ){
			alert("Sila masukkan tempoh siap");
		return false;
		}
	}
	if(document.getElementById('email')){
		if(document.getElementById('email').value != "" ){
			var status = false;     
			var emailRegEx = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i;
    		if (document.getElementById("email").value.search(emailRegEx) == -1) {
          		document.getElementById("email").focus();
		  		alert("Sila masukkan alamat email yang sah.");		  
     		}
	 		else {
          		status = true;
     		}
     	return status;
		}
	}
	
	return true;
}
	
function getHeight() {
	var top = document.body.scrollTop;
	document.getElementById("top").value = top;
}

function xDocSize(len) {
	var b=document.body, e=document.documentElement;
	var esw=0, eow=0, bsw=0, bow=0, esh=0, eoh=0, bsh=0, boh=0;
	if (e) {
		esw = e.scrollWidth;
		eow = e.offsetWidth;
		esh = e.scrollHeight;
		eoh = e.offsetHeight;
	}
	if (b) {
		bsw = b.scrollWidth;
		bow = b.offsetWidth;
		bsh = b.scrollHeight;
		boh = b.offsetHeight;
	}
	var w = Math.max(esw,eow,bsw,bow);
	var h = Math.max(esh,eoh,bsh,boh);
	if (len == "w") { return w; }
	if (len == "h") { return h; }
}

function show_det(div){
	if(document.getElementById(div).style.display=='none'){
		document.getElementById(div).style.display='inline';
	}else{
		document.getElementById(div).style.display='none';
	}
}

function getUser() {
	var deptId = document.getElementById("department").value;
	AjaxGo("txtHint","getUser","&deptId="+deptId,"dispBhg","");
	  
  }
  
  function dispBhg(data,layer) {
		var dataChk = data.replace(" ","");
		//alert();
	  	if (dataChk!="") {
			document.getElementById(layer+"TR").style.display="inline";
			document.getElementById(layer).innerHTML=data;
		} else {
			document.getElementById(layer+"TR").style.display="none";
		}
  }
  
  function getReferen() {
	
	//alert("xxxx")        
	var perunding = radio_button(document.getElementsByName("perunding"));
	var jenisId = document.getElementById("jenis_projek").value;
	//var datemula = document.getElementById("mula").value;	
	//alert(perunding)
	AjaxGo("txtHintRef","getReferen","&jenisId="+jenisId+"&perunding="+perunding,"","");

}
 
  
  function dispRef(data,layer) {
		var dataChk = data.replace(" ","");
		//alert();
	  	if (dataChk!="") {
			document.getElementById(layer+"Ref").style.display="inline";
			document.getElementById(layer).innerHTML=data;
		} else {
			document.getElementById(layer+"Ref").style.display="none";
		}
  }
  
function datediffhari(){
	 	var mula = document.getElementById("mula").value;
		var tamat = document.getElementById("tamat").value;
		AjaxGo("txtdatediff","datediffhari","&mula="+mula+"&tamat="+tamat,"","");
	  }
	  
function datediffminggu(){
		
	 	var mula = document.getElementById("mula").value;
		var tamat = document.getElementById("tamat").value;
		AjaxGo("txtdatediff","datediffminggu","&mula="+mula+"&tamat="+tamat,"","");
	  }
	  
function datediffbulan(){
		
	 	var mula = document.getElementById("mula").value;
		var tamat = document.getElementById("tamat").value;
		AjaxGo("txtdatediff","datediffbulan","&mula="+mula+"&tamat="+tamat,"","");
	  }

function datedifftahun(){
		
	 	var mula = document.getElementById("mula").value;
		var tamat = document.getElementById("tamat").value;
		AjaxGo("txtdatediff","datedifftahun","&mula="+mula+"&tamat="+tamat,"","");
	  }
	  
function convertdate(){
	 	var mula = document.getElementById("mula").value;
		var tamat = document.getElementById("tamat").value;
		AjaxGo("txtconvertdate","convertdate","&mula="+mula+"&tamat="+tamat,"","");
	  }


function validate(){
	//var ok=1;
	for(var i=0;i<document.theForm.elements.length;i++){
		if(document.theForm.elements[i].type=='text'){
			if(document.theForm.elements[i].value==''){
				alert(document.theForm.elements[i].name)
				//ok=0;
				return false;	
			}
		}
	}
	//return ok;
}

function save_form(frm){
	if(validate()){
		frm.submit();	
	}else{
		alert('Sila lengkapkan maklumat!');
	}	
}

  function hidejabatan() {
	  
	  var nama = document.getElementById('peringkat').value
	   
	  if(document.getElementById('peringkat').value==2){
			document.getElementById('jabatan').style.display='inline';			
							
	  }
	  else{document.getElementById('jabatan').style.display='none';}
							
						
  }
  
  function add() {
	
			document.getElementById('tambah2').style.display='inline';
			document.getElementById('divtambah').style.display='none';
  }
  
  function add2() {
	  	  		
			document.getElementById('tambah3').style.display='inline';
			document.getElementById('divtambah2').style.display='none';
  }
  
   function tolak() {
	
			document.getElementById('tambah2').style.display='none';
			document.getElementById('divtambah').style.display='inline';
			var x = document.getElementById("theForm");
			
			pemilik = document.theForm.elements[15];
			alamat = document.theForm.elements[16];
			no_tel = document.theForm.elements[17];
			kadpen = document.theForm.elements[18];
			
			pemilik.value = "";
			alamat.value = "";
			no_tel.value = "";
			kadpen.value = "";
			
	}

  
  function tolak2() {
	  	  		
			document.getElementById('tambah3').style.display='none';
			document.getElementById('divtambah2').style.display='inline';
			
			pemilik = document.theForm.elements[21];
			alamat = document.theForm.elements[22];
			no_tel = document.theForm.elements[23];
			kadpen = document.theForm.elements[24];
			
			pemilik.value = "";
			alamat.value = "";
			no_tel.value = "";
			kadpen.value = "";
  }
  
  function getUser() {
	var deptId = document.getElementById("jabatan").value;
	AjaxGo("txtHint","getUser","&deptId="+deptId,"dispBhg","");
	  
  }
  
  function dispBhg(data,layer) {
		var dataChk = data.replace(" ","");
		//alert();
	  	if (dataChk!="") {
			document.getElementById(layer+"TR").style.display="inline";
			document.getElementById(layer).innerHTML=data;
		} else {
			document.getElementById(layer+"TR").style.display="none";
		}
  }
  
 function update() {
	AjaxGo("txtupdateuser","updateuser","","update12","");
	  
  }
  
   
function update11(data,layer) {
	var dataChk = data.replace(" ","");
	//alert();
	if (dataChk!="") {
		layer = "txtupdateuser";
		bg = "popupbg";
		document.getElementById(layer).innerHTML=data;
		document.getElementById(layer).style.display="inline";
		document.getElementById(bg).style.display="inline";
		var top = document.body.scrollTop;
		var left = document.body.scrollLeft;
		var ypos = document.body.clientHeight;
		var xpos = document.body.clientWidth;
		var w = xDocSize("w");
		var h = xDocSize("h");
		
		//alert(top+"^"+h);
		
		document.getElementById(layer).style.top = top+254;
		document.getElementById(layer).style.left = (xpos/2)-80;
		document.getElementById(bg).style.top = 0-(top+100);
		document.getElementById(bg).style.left = 0-((xpos/2)-620);
		document.getElementById(bg).style.height = h+1000;
		document.getElementById(bg).style.width = w+1000;
		document.body.scrollTop = top;
		document.body.style.overflow = "hidden";
		document.body.style.overflowY = "hidden";
		document.body.style.overflowX = "hidden";
		
		document.body.style.overflowX="hidden";
		document.body.style.overflowY="hidden";
	} else {
		document.getElementById(bg).style.display="none";
	}
}

function jsupdateuser() {
	
	document.getElementById("popupbg").style.display="none";
	document.getElementById("txtupdateuser").style.display="none";
	
	var name = document.getElementById("name").value;
	var email = document.getElementById("email").value;
	var notel = document.getElementById("notel").value;
	var nobimbit = document.getElementById("nobimbit").value;

	AjaxGo("txtupdateuser","jsupdate","&name="+name+"&email="+email+"&notel="+notel+"&nobimbit="+nobimbit,"","");
	
  }
  
function password() {
	
	AjaxGo("txtupdateuser","validatepassword","","update12","");
	//document.getElementById("validatepass").style.display="inline";
	//document.getElementById("popupbg").style.display="inline";
	//document.body.style.overflowX="hidden";
	//document.body.style.overflowY="hidden";
	  
  }
  
function validate_password() {
	
	var password1 = document.getElementById("password1").value;

	AjaxGo("validate","validate","&password1="+password1,"password2","");
	
  }
  
 //function password2(data,layer) {
	 //var dataArr = data.split("|~|");
	 //var image = dataArr[0];
	 //var result = dataArr[1];
	 //if (result == 1) {
		//alert("Betul");
	//} else {
		//alert("Salah");
	//}
	//document.getElementById(layer).innerHTML = image;
	
//}
 
 function password2(data,layer) {
	 var right = "<img src='images/right.png' width='15' height='15' />";
	 var x = "<img src='images/x.png' width='15' height='15' />";
	 
	if (data == 1){
		document.getElementById(layer).innerHTML = right ;	
		document.getElementById("password2").disabled = false;
		document.getElementById("password3").disabled = false;
		document.getElementById("button").disabled = false;
		document.getElementById("button").disabled = true;
		}
	if (data == 2){
		document.getElementById(layer).innerHTML = x ;
		alert("Katalaluan Semasa Salah");
		document.getElementById("password1").value='';
		document.getElementById("password1").focus();
		document.getElementById("password2").disabled = true;
		document.getElementById("password3").disabled = true;
		document.getElementById("button").disabled = true;
		document.getElementById("button").disabled = true;
		}
}

function updatepassword(){
	
	document.getElementById("popupbg").style.display="none";
	document.getElementById("txtupdateuser").style.display="none";
	
	var password2 = document.getElementById("password2").value;

	AjaxGo("","updatepassword","&password2="+password2,"","");
	
  }
  
function validate_samepassword(pass){
	if (pass.value!="") {
		if (pass.value.length>=document.getElementById("password2").value.length){
			if(pass.value == document.getElementById("password2").value){
				document.getElementById("button").disabled = false;
				document.getElementById("respass2").innerHTML = "<img src='images/right.png' width='15' height='15' />";
				
				}
			if(pass.value != document.getElementById("password2").value){
				alert("Katalaluan Baru Tidak Sama");
				document.getElementById("password3").value = "";
				document.getElementById("button").disabled = true;
				document.getElementById("password3").focus();
				document.getElementById("respass2").innerHTML = "<img src='images/x.png' width='15' height='15' />";
				}
		}
	//var pass3 = document.getElementById("password3").value;
//	
//	if (pass2 == pass3){
//		document.getElementById("button").disabled = false;
//		
//		}
//	if (pass2 != pass3){
//		alert("Ulangi Katalaluan Baru Tidak Sama");
//		document.getElementById("button").disabled = true;
//		
		}
	 }
function tutup(data,layer) {
	if ((typeof data!="undefined")&&(typeof layer!="undefined")) {
		loadFindProj(data,layer);
	}
	document.getElementById("container").style.display="none";
	document.getElementById("popupbg").style.display="none";
	document.getElementById("txtupdateuser").style.display="none";
	if (document.getElementById("validatepass")) {
		document.getElementById("validatepass").style.display="none";
	}
	document.body.style.overflowX="hidden";
	document.body.style.overflowY="auto";
}
	

function checkPwd(obj) {
	if (obj.value!="") {
		var space = obj.value.split(" ");
		if (obj.value.length<6) {
			alert("Katalaluan hendaklah enam aksara atau lebih.");
			obj.value="";
			obj.focus();
			document.getElementById("respass1").innerHTML = "<img src='images/x.png' width='15' height='15' />";
			document.getElementById("respass1").focus();
		}
		else{
			if (space.length != 1){
				alert("Login ID tidak boleh mempunyai ruang kosong.");
				obj.value = "";
				obj.focus();
				document.getElementById("respass1").innerHTML = "<img src='images/x.png' width='15' height='15' />";
				}
			else{
			document.getElementById("respass1").innerHTML = "<img src='images/right.png' width='15' height='15' />";
				}
			}
		}

}

function changedate() {
	var date = document.getElementById("tamat").value;
	dataArr = date.split("-");
	var bul = dataArr[1]
	//convertmonth2(bul);
	document.getElementById("bulan").value = convertmonth2(bul);
	document.getElementById("tahun").value = dataArr[2];
	
}

function convertmonth2(bulan) {
	
	if(bulan=="JAN"){
		bulan = "1";
		}
	if(bulan=="FEB"){
		bulan = "2";
		}
	if(bulan=="MAR"){
		bulan = "3";
		}
	if(bulan=="APR"){
		bulan = "4";
		}
	if(bulan=="MAY"){
		bulan = "5";
		}
	if(bulan=="JUN"){
		bulan = "6";
		}
	if(bulan=="JUL"){
		bulan = "7";
		}
	if(bulan=="AUG"){
		bulan = "8";
		}
	if(bulan=="SEP"){
		bulan = "9";
		}
	if(bulan=="OCT"){
		bulan = "10";
		}
	if(bulan=="NOV"){
		bulan = "11";
		}
	if(bulan=="DEC"){
		bulan = "12";
		}
	return bulan;	
		
	}
	
	
	
function subbidang(value){
	
	var x = value;
	var y = x.split("|");
	var value = y[0]
	
	var perunding = document.getElementById("perunding").value;
	
	document.getElementById("kod_1").value = y[1];
	
	AjaxGo("sub_kepala","sub_kepala","&value="+value+"&perunding="+perunding,"","");
	
}

function subbidangajax(value){
	
	var x = value;
	var y = x.split("|");
	var value = y[0]
	
	var perunding = document.getElementById("perunding").value;
	
	document.getElementById("kod_1").value = y[1];
	
	AjaxGo("sub_kepala","sub_kepalaajax","&value="+value+"&perunding="+perunding,"","");
	
}

function tambah_bidang() {
		
	
	var perunding = document.getElementById("perunding").value;
	
	AjaxGo("txtupdateuser","tambah_bidang","&perunding="+perunding,"update12","");
	  
  }
  
 function save_bidang(){
	 
	 var perunding = document.getElementById("perunding").value;
	 var kod = document.getElementById("kod").value;
	 var bidang = document.getElementById("bidang").value;
	 
	 AjaxGo("","save_bidang","&perunding="+perunding+"&kod="+kod+"&bidang="+bidang,"datarefresh","");
	 	 
}

function datarefresh() {
	
	var perunding = document.getElementById("perunding").value;
		
	AjaxGo("bidangdata","display_bidang","&perunding="+perunding,"","");
}

function tambah_subbidang(kepala) {
	
	var perunding = document.getElementById("perunding").value;
	 
	AjaxGo("txtupdateuser","tambah_subbidang","&kepala="+kepala+"&perunding="+perunding,"update12","");
	 // alert(kepala);
  }
  
 function save_subbidang(){
	 
	 var kepala = document.getElementById("kepala").value;
	 var kod = document.getElementById("kod").value;
	 var bidang = document.getElementById("bidang").value;

	 AjaxGo("sub_kepala","save_subbidang","&kepala="+kepala+"&kod="+kod+"&bidang="+bidang,"datarefresh2","");
	 //alert(kepala+"xxxx"+kod+"xxxx"+bidang) 
}

function datarefresh2(){
	
		var value = document.getElementById("kepala").value;
		var perunding = document.getElementById("perunding").value;
		
		AjaxGo("sub_kepala","sub_kepala","&value="+value+"&perunding="+perunding,"","");
	
}

function bidangshow(obj){
	
		var data = obj.value;

		if(data=="0"){
			document.getElementById("label_bidang").innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;Kelas";	
			}
		if(data=="1"){
			document.getElementById("label_bidang").innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;Bidang";				
			}		
		//alert(data);
		AjaxGo("bidang","bidangshow","&perunding="+data,"","");
		
}

function jenis(obj){
	
		var data = obj.value;
		
		if(data == 0){
			
			document.getElementById("display_kategori").style.display = "inline";
			AjaxGo("title","title","","","");
                      															
			}
		if(data == 1){
			
			document.getElementById("kontraktor_bidang").innerHTML ='	<select name="kontraktor" id="kontraktor"> '+
                      												'		<option>---Sila Pilih---</option> '+
                   													'	</select>'
			document.getElementById("display_kategori").style.display = "none";
			AjaxGo("title","title2","","","");
		}	

		//alert(data);
		
		AjaxGo("jenisAjax","jenis","&perunding="+data,"","");
		
}

function get_contractor1(){
	
	if(document.getElementById("bidangprojek")){
	
		var bidangid = document.getElementById("bidangprojek").value;
	}
	var perunding = radio_button(document.getElementsByName("perunding"));
	if(document.getElementById("kategori")){
		var kategori = document.getElementById("kategori").value;
	}
	AjaxGo("kontraktor_bidang","kontraktor_bidang","&bidangid="+bidangid+"&perunding="+perunding+"&kategori="+kategori,"","");
	
	}
// update for admin
  
function adminupdate(idupdate) {
	
	counter=0;
	counter2=0;
	AjaxGo("txtupdateuser","adminupdate","&idupdate="+idupdate,"update12","");
	  
  }
function update12(data,layer) {

	var dataChk = data.replace(" ","");
	//alert(data);
	if (dataChk!="") {
		layer = "txtupdateuser";
		bg = "popupbg";
		
		document.getElementById("container").style.display="inline";
		document.getElementById("container").style.position="absolute";
		document.getElementById(layer).innerHTML=data;
		document.getElementById(layer).style.display="inline";
		document.getElementById(bg).style.display="inline";
		
		var top = document.body.scrollTop;
		var left = document.body.scrollLeft;
		var ypos = document.body.clientHeight;
		var xpos = document.body.clientWidth;
		var w = xDocSize("w");
		var h = xDocSize("h");

		var height = parseInt(document.getElementById(layer).style.height);
		var width = parseInt(document.getElementById(layer).style.width);
		
		var divHeight=document.getElementById(layer).clientHeight;
		var divWidth=document.getElementById(layer).clientWidth;
		var divWidth2=document.getElementById(bg).clientWidth;
		
		var left2 = (Number(divWidth2)-Number(divWidth));
		var left3 = (Number(left2) / 2);
		
		
		document.getElementById("container").style.top=top;
		document.getElementById("container").style.bottom=ypos;
		document.getElementById("container").style.height=ypos;
		document.getElementById("container").style.overflowY="auto";
		document.getElementById("container").style.overflowX="hidden";
		document.getElementById("container").scrollTop = 0;
		
		//alert("top:"+top+" height:"+h+" ypos:"+ypos+" left:"+left+" width:"+w+" xpos:"+xpos);
		// alert(height+"^"+width);
		document.getElementById(layer).style.top = (ypos/8);
		document.getElementById(layer).style.left = left3;
		document.getElementById(bg).style.top = 0;
		document.getElementById(bg).style.left = left;
		if ((divHeight+(ypos/4))<ypos) {
			document.getElementById(bg).style.height = ypos+50;
			document.getElementById("container").style.overflowY="hidden";			
		} else {
			document.getElementById(bg).style.height = divHeight+(ypos/2)+40;
		}
		document.getElementById(bg).style.width = w;
		document.body.scrollTop = top;
		
		document.body.style.overflowY="hidden";
		document.body.style.overflowX="hidden";
		document.body.style.overflow="hidden";
		
		if (document.getElementById("counter")) {
			counter = document.getElementById("counter").value;
		}
		if (document.getElementById("counter2")) {
			counter2 = document.getElementById("counter2").value;
		}
		
		if (document.getElementById("date_pay")) {
			new JsDatePick({
				useMode:2,
				target:"date_pay", 
				dateFormat:"%d/%m/%Y"
			});
		}
		if (document.getElementById("date_eot")) {
			new JsDatePick({
				useMode:2,
				target:"date_eot", 
				dateFormat:"%d/%m/%Y"
			});
		}
		if (document.getElementById("date_eoc")) {
			new JsDatePick({
				useMode:2,
				target:"date_eoc",
				dateFormat:"%d/%m/%Y"
			});
		}
		if (document.getElementById("datemula")) {
			//alert(document.getElementById("datemula").value);
			
		}
	} else {
		document.getElementById(bg).style.display="none";
	}
}

function update12_old(data,layer) {
	var dataChk = data.replace(" ","");
	//alert();
	if (dataChk!="") {
		layer = "txtupdateuser";
		bg = "popupbg";
		document.getElementById(layer).innerHTML=data;
		document.getElementById(layer).style.display="inline";
		document.getElementById(bg).style.display="inline";
		var top = document.body.scrollTop;
		var left = document.body.scrollLeft;
		var ypos = document.body.clientHeight;
		var xpos = document.body.clientWidth;
		var w = xDocSize("w");
		var h = xDocSize("h");
		
		//alert(top+"^"+h);
		
		document.getElementById(layer).style.top = top+254;
		document.getElementById(layer).style.left = (xpos/2)-80;
		document.getElementById(bg).style.top = 0-(top+100);
		document.getElementById(bg).style.left = 0-((xpos/2)-620);
		document.getElementById(bg).style.height = h+1000;
		document.getElementById(bg).style.width = w+1000;
		document.body.scrollTop = top;
		//document.getElementById("popupbg").style.overflowY = scroll;
		//document.body.style.overflow = "hidden";
		//document.body.style.overflowY = "hidden";
		document.body.style.overflowX = "hidden";
		
		document.body.style.overflowX="hidden";
		//document.body.style.overflowY="hidden";
		
		
	} else {
		document.getElementById(bg).style.display="none";
	}
}

function removepemilik(obj){

	var remove = document.getElementById("show"+obj);
	//counter = document.getElementById("counter").value;
	//counter = counter - 1;
	//document.getElementById("counter").value = counter;
	remove.parentNode.removeChild(remove);
		//document.removeChild(document.getElementById("show"+obj));
		//document.getElementById("show"+obj).style.display = "none";
}

function removeinsuran(obj){

	var remove = document.getElementById("insuranshow"+obj);
	//counter = document.getElementById("counter").value;
	//counter = counter - 1;
	//document.getElementById("counter").value = counter;
	remove.parentNode.removeChild(remove);
		//document.removeChild(document.getElementById("show"+obj));
		//document.getElementById("show"+obj).style.display = "none";
}

 
function update11XXX(data,layer) {
	var dataChk = data.replace(" ","");
	//alert();
	if (dataChk!="") {
		document.getElementById("txtupdateuser").style.display="inline";
		document.getElementById("popupbg").style.display="inline";
		document.getElementById("validatepass").style.display="none";
		document.getElementById(layer).innerHTML=data;
		document.body.style.overflowX="hidden";
		document.body.style.overflowY="hidden";
	} else {
		document.getElementById("popupbg").style.display="none";
	}
}

function updatedept() {
	
	document.getElementById("popupbg").style.display="none";
	document.getElementById("txtupdateuser").style.display="none";
	
	//var jabatan = document.getElementById("jabatan").style.display;
	var peringkat = document.getElementById("peringkat").value;
	var bahagian = document.getElementById("bahagian").value;
	var nama = document.getElementById("nama").value;
	var idupdate = document.getElementById("idupdate").value;
	
	
	AjaxGo("update"+idupdate,"updatedept","&peringkat="+peringkat+"&bahagian="+bahagian+"&nama="+nama+"&idupdate="+idupdate,"displayDept","");
	

  }
  
function displayDept(data,layer) {
	
			document.location.href="main.php?m=1&sm=1";
			//box = document.theForm.elements[1];
			//box.focus();
	//alert(data);
	//dataArr = data.split("|");
	//document.getElementById(layer+"_1").innerHTML = dataArr[0];
	//document.getElementById(layer+"_2").innerHTML = dataArr[1];
	
}

function updateusergroup() {
	
	document.getElementById("popupbg").style.display="none";
	document.getElementById("txtupdateuser").style.display="none";
	
	var kumpengguna = document.getElementById("kumpengguna").value;
	var turutan = document.getElementById("turutan").value;
	var idupdate = document.getElementById("idupdate").value;
	var level = radio_button(document.getElementsByName("RadioGroup"));
	
	AjaxGo("","delete_usergroupmodule","&idupdate="+idupdate,"insert_usergroupmodule","")
	AjaxGo("update"+idupdate,"updateusergroup","&kumpengguna="+kumpengguna+"&turutan="+turutan+"&idupdate="+idupdate+"&level="+level,"displayusergroup","");
}


function insert_usergroupmodule(){
	
	var id_check = document.getElementsByName("checkbox_module[]");
	var idupdate = document.getElementById("idupdate").value;
	var check_box = id_check;
		
		for (var x = 0; x <check_box.length; x++) 
		{
			if (check_box[x].checked) 
			{
			var id_check = check_box[x].value;
			//alert(id_check)
			AjaxGo("","insert_usergroupmodule","&idupdate="+idupdate+"&id_check="+id_check,"","");			
			}
		}
	
		
		//alert("checked");	
}

function displayusergroup(data,layer) {
	dataArr = data.split("|");
	document.getElementById(layer+"_1").innerHTML = dataArr[0];
	//document.getElementById(layer+"_2").innerHTML = dataArr[1];
}

function updatejawatan() {
	
	document.getElementById("popupbg").style.display="none";
	document.getElementById("txtupdateuser").style.display="none";
	
	var jawatan = document.getElementById("jawatan").value;
	//var turutan = document.getElementById("turutan").value;
	var idupdate = document.getElementById("idupdate").value;
	
	//alert(kumpengguna+">>"+turutan+">>>"+idupdate); 
	
	AjaxGo("update"+idupdate,"updatejawatan","&jawatan="+jawatan+"&idupdate="+idupdate,"displayjawatan","");
}

function displayjawatan(data,layer) {
	dataArr = data.split("|");
	document.getElementById(layer+"_1").innerHTML = dataArr[0];
	//document.getElementById(layer+"_2").innerHTML = dataArr[1];
}

function updateuseradmin() {
	
	document.getElementById("popupbg").style.display="none";
	document.getElementById("txtupdateuser").style.display="none";
	
	var nama = document.getElementById("nama").value;
	var jawatan = document.getElementById("jawatan").value;
	var gred = document.getElementById("gred").value;
	var email = document.getElementById("email").value;
	var notel = document.getElementById("notel").value;
	var notelbimbit = document.getElementById("notelbimbit").value;
	var kumpengguna = document.getElementById("kumpengguna").value;
	var jabatan = document.getElementById("jabatan").value;
	var idupdate = document.getElementById("idupdate").value;
	
	AjaxGo("update"+idupdate,"updateuseradmin","&nama="+nama+"&jawatan="+jawatan+"&gred="+gred+"&email="+email+"&notel="+notel+"&notelbimbit="+notelbimbit+"&kumpengguna="+kumpengguna+"&jabatan="+jabatan+"&idupdate="+idupdate,"displayuser","");
}

function displayuser(data,layer) {
	dataArr = data.split("|");
	document.getElementById(layer+"_2").innerHTML = dataArr[0];
	document.getElementById(layer+"_3").innerHTML = dataArr[1];
	document.getElementById(layer+"_4").innerHTML = dataArr[2];
	document.getElementById(layer+"_5").innerHTML = dataArr[3];
	document.getElementById(layer+"_6").innerHTML = dataArr[4];
	document.getElementById(layer+"_7").innerHTML = dataArr[5];
	document.getElementById(layer+"_8").innerHTML = dataArr[6];
	document.getElementById(layer+"_9").innerHTML = dataArr[7];
}

function updatetype() {
	
	document.getElementById("popupbg").style.display="none";
	document.getElementById("txtupdateuser").style.display="none";
	
	var jenis = document.getElementById("jenis").value;
	var short = document.getElementById("short").value;
	//var turutan = document.getElementById("turutan").value;
	var idupdate = document.getElementById("idupdate").value;
	
	//alert(jenis+singkatan+turutan+idupdate);
	AjaxGo("update"+idupdate,"updatetype","&jenis="+jenis+"&short="+short+"&idupdate="+idupdate,"displaytype","");
}

function displaytype(data,layer) {
	dataArr = data.split("|");
	//alert(dataArr[0]+dataArr[1]+dataArr[2]);
	document.getElementById(layer+"_1").innerHTML = dataArr[0];
	document.getElementById(layer+"_2").innerHTML = dataArr[1];
	//document.getElementById(layer+"_3").innerHTML = dataArr[2];

}

function updatecategory() {
	
	document.getElementById("popupbg").style.display="none";
	document.getElementById("txtupdateuser").style.display="none";
	
	var kategori = document.getElementById("kategori").value;
	var short = document.getElementById("short").value;
	//var turutan = document.getElementById("turutan").value;
	var idupdate = document.getElementById("idupdate").value;
	
	//alert(jenis+singkatan+turutan+idupdate);
	AjaxGo("update"+idupdate,"updatecategory","&kategori="+kategori+"&short="+short+"&idupdate="+idupdate,"displaycategory","");
}

function displaycategory(data,layer) {
	dataArr = data.split("|");
	document.getElementById(layer+"_1").innerHTML = dataArr[0];
	document.getElementById(layer+"_2").innerHTML = dataArr[1];
//	document.getElementById(layer+"_3").innerHTML = dataArr[2];
	
}

function updategred() {
	
	
	document.getElementById("popupbg").style.display="none";
	document.getElementById("txtupdateuser").style.display="none";
	
	var gred = document.getElementById("gred").value;
	//var turutan = document.getElementById("turutan").value;
	var idupdate = document.getElementById("idupdate").value;
	
	//alert(gred+turutan+idupdate);
	AjaxGo("update"+idupdate,"updategred","&gred="+gred+"&idupdate="+idupdate,"displaygred","");
}

function displaygred(data,layer) {
	dataArr = data.split("|");
	//alert(dataArr[0]+dataArr[1]+dataArr[2]);
	document.getElementById(layer+"_1").innerHTML = dataArr[0];
	//document.getElementById(layer+"_2").innerHTML = dataArr[1];

}

function updateperunding(){
	
	
	document.getElementById("popupbg").style.display="none";
	document.getElementById("txtupdateuser").style.display="none";
	
	var idupdate = document.getElementById("idupdate").value;
	var no_pendaftaran = document.getElementById("no_pendaftaran").value;
	var kontraktor = document.getElementById("nama_kontraktor").value;
	var alamat = document.getElementById("alamat").value;
	var no_kkm = document.getElementById("no_kkm").value;
	var email = document.getElementById("email").value;
	var telefon = document.getElementById("telefon").value;
	var telefon2 = document.getElementById("telefonpejabat").value;
	var fax = document.getElementById("fax").value;
	var radio_bumiputra = radio_button(document.getElementsByName("radio_bumiputra"));
	var radio_BList = radio_button(document.getElementsByName("radio_BList"));
	
	var counter = document.getElementById("counter").value;

	AjaxGo("","delete_pemilikkontraktor","&idupdate="+idupdate,"insert_pemilikkontraktor","");
	AjaxGo("","delete_bidangp","&idupdate="+idupdate,"insert_bidangp","");
	AjaxGo("update"+idupdate,"updateperunding","&idupdate="+idupdate+"&kontraktor="+kontraktor+"&no_pendaftaran="+no_pendaftaran+"&alamat="+alamat+"&email="+email+"&telefon="+telefon+"&telefon2="+telefon2+"&fax="+fax+"&radio_bumiputra="+radio_bumiputra+"&radio_BList="+radio_BList+"&no_kkm="+no_kkm,"displayperunding","");	
	//alert(AjaxGo)
}

function insert_bidangp(){
	
	var id_check = document.getElementsByName("bidang[]");
	var idupdate = document.getElementById("idupdate").value;
	var check_box = id_check;
		
		for (var x = 0; x<check_box.length; x++) 
		{
			if (check_box[x].checked) 
			{
			var id_check = check_box[x].value;
			//alert(id_check)
			AjaxGo("","insert_bidangp","&idupdate="+idupdate+"&id_check="+id_check,"","");			
			}
		}
}


function insert_pemilikkontraktor(){
	
	var idupdate = document.getElementById("idupdate").value;
	var counter = document.getElementById("counter").value;
	
	for(i=1;i<=counter;i++){
			
			if(document.getElementById("pemilik"+i)){
				if((document.getElementById("pemilik"+i).value) != ""){							
					var pemilik = document.getElementById("pemilik"+i).value;
					var no_ic_pemilik = document.getElementById("no_ic"+i).value;
					var alamat_pemilik = document.getElementById("alamat"+i).value;
					var telefon_pemilik = document.getElementById("telefon"+i).value;
					var telefon2_pemilik = document.getElementById("telefon2"+i).value;
			
					//alert(pemilik+"xx"+no_ic_pemilik+"xx"+alamat_pemilik+"xx"+telefon_pemilik+"xx"+telefon2_pemilik);
					AjaxGo("","insert_pemilikkontraktor","&idupdate="+idupdate+"&pemilik="+pemilik+"&no_ic="+no_ic_pemilik+"&alamat="+alamat_pemilik+"&telefon="+telefon_pemilik+"&telefon2="+telefon2_pemilik,"");
				}
			}
	}
}

function updatekontraktor(){
	
	
	document.getElementById("popupbg").style.display="none";
	document.getElementById("txtupdateuser").style.display="none";
	
	var idupdate = document.getElementById("idupdate").value;
	var no_pendaftaran = document.getElementById("no_pendaftaran").value;
	var kontraktor = document.getElementById("nama_kontraktor").value;
	var alamat = document.getElementById("alamat").value;
	var email = document.getElementById("email").value;
	var telefon = document.getElementById("telefon").value;
	var telefon2 = document.getElementById("telefonpejabat").value;
	var fax = document.getElementById("fax").value;
	var radio_bumiputra = radio_button(document.getElementsByName("radio_bumiputra"));
	var radio_cidb = radio_button(document.getElementsByName("radio_cidb"));
	var no_pkk = document.getElementById("no_pkk").value;
	var kelas = document.getElementById("kelas").value;
	var no_kkm = document.getElementById("no_kkm").value;
	var radio_upen = radio_button(document.getElementsByName("radio_upen"));
	var bon_perlaksanaan = document.getElementById("bon_perlaksanaan").value;
	var kaedah = document.getElementById("kaedah").value;
	var radio_BList = radio_button(document.getElementsByName("radio_BList"));
	
	var counter = document.getElementById("counter").value;
	
	//alert(counter);
	
	AjaxGo("","delete_pemilikkontraktor","&idupdate="+idupdate,"insert_pemilikkontraktor","");		
	AjaxGo("","delete_insurankontraktor","&idupdate="+idupdate,"insert_insurankontraktor","");
	
	AjaxGo("update"+idupdate,"updatekontraktor","&idupdate="+idupdate+"&kontraktor="+kontraktor+"&no_pendaftaran="+no_pendaftaran+"&alamat="+alamat+"&email="+email+"&telefon="+telefon+"&telefon2="+telefon2+"&fax="+fax+"&radio_bumiputra="+radio_bumiputra+"&radio_cidb="+radio_cidb+"&radio_upen="+radio_upen+"&bon_perlaksanaan="+bon_perlaksanaan+"&kaedah="+kaedah+"&kelas="+kelas+"&no_pkk="+no_pkk+"&no_kkm="+no_kkm+"&radio_BList="+radio_BList,"displaykontraktor","");	
	//alert(AjaxGo)
	
}

function insert_insurankontraktor(){	
	
	var counter2 = document.getElementById("counter2").value;
	var idupdate = document.getElementById("idupdate").value;
	
	for(i=1;i<=counter2;i++){
		if(document.getElementById("insuran"+i)){
			if(document.getElementById("insuran"+i).value != ""){		
				var insuran = document.getElementById("insuran"+i).value;
				var nilai = document.getElementById("nilai"+i).value;
			//alert(insuran+"xx"+nilai+"xx"+idupdate);
				AjaxGo("","insert_insurankontraktor","&idupdate="+idupdate+"&insuran="+insuran+"&nilai="+nilai,"","");			
			}
		}
	}
	
}

function displayperunding(data,layer) {
	dataArr = data.split("|");
	//alert(data);
	document.getElementById(layer+"_1").innerHTML = dataArr[0];
	document.getElementById(layer+"_2").innerHTML = dataArr[1];
	document.getElementById(layer+"_3").innerHTML = dataArr[2];
	document.getElementById(layer+"_4").innerHTML = dataArr[3];
	document.getElementById(layer+"_5").innerHTML = dataArr[4];
	document.getElementById(layer+"_6").innerHTML = dataArr[5];
	document.getElementById(layer+"_7").innerHTML = dataArr[6];
	document.getElementById(layer+"_8").innerHTML = dataArr[7];
	document.getElementById(layer+"_9").innerHTML = dataArr[8];
	
}

function displaykontraktor(data,layer) {
	dataArr = data.split("|");
	//alert(data);
	document.getElementById(layer+"_1").innerHTML = dataArr[0];
	document.getElementById(layer+"_2").innerHTML = dataArr[1];
	document.getElementById(layer+"_3").innerHTML = dataArr[2];
	document.getElementById(layer+"_4").innerHTML = dataArr[3];
	document.getElementById(layer+"_5").innerHTML = dataArr[4];
	document.getElementById(layer+"_6").innerHTML = dataArr[5];
	document.getElementById(layer+"_7").innerHTML = dataArr[6];
	document.getElementById(layer+"_8").innerHTML = dataArr[7];
	document.getElementById(layer+"_9").innerHTML = dataArr[8];
	document.getElementById(layer+"_10").innerHTML = dataArr[9];
	document.getElementById(layer+"_11").innerHTML = dataArr[10];
	document.getElementById(layer+"_12").innerHTML = dataArr[11];
}

function update_bidang() {
	
	
	document.getElementById("popupbg").style.display="none";
	document.getElementById("txtupdateuser").style.display="none";
	
	var kod_1 = document.getElementById("kod_1").value;
	var kod_2 = document.getElementById("kod_2").value;
	var kod = document.getElementById("kod").value;
	var nama = document.getElementById("nama").value;
	var sub_bidang = document.getElementById("sub_bidang").value;
	var idupdate = document.getElementById("idupdate").value;
	var kod_bidang = kod_1+kod_2+kod;

	AjaxGo("update"+idupdate,"update_bidang","&kod_bidang="+kod_bidang+"&kod="+kod+"&nama="+nama+"&sub_bidang="+sub_bidang+"&idupdate="+idupdate,"display_bidang","");
}

function display_bidang(data,layer) {
	dataArr = data.split("|");

	document.getElementById(layer+"_1").innerHTML = dataArr[0];
	document.getElementById(layer+"_2").innerHTML = dataArr[1];
}


function update_project(){
	
	document.getElementById("popupbg").style.display="none";
	document.getElementById("txtupdateuser").style.display="none";
	
	var idupdate = document.getElementById("idupdate").value;
	
	var awal = document.getElementById("no_kontrak").value;	
	var tengah = document.getElementById("no_kontrak2").value;	
	var akhir = document.getElementById("no_kontrak3").value;	
	
	var kategori = document.getElementById("kategori").value;	
	var bidangprojek = document.getElementById("bidangprojek");
	
	
	if(bidangprojek){
		bidangprojek = bidangprojek.value;
	}
	else{
		bidangprojek = '';
	}
	
	var jenis = document.getElementById("jenis").value;
	var kontraktor = document.getElementById("kontraktor").value;	
	var jabatan = document.getElementById("jabatan").value;	
	var nama_projek2 = document.getElementById("nama_projek").value; 
	var nama_projek = nama_projek2.replace(/\+/g,'plustambah');
	nama_projek = nama_projek.replace(/\&/g,'simboldan');
	nama_projek = nama_projek.replace(/\'/g,'simbolapos');
	nama_projek = nama_projek.replace(/\"/g,'dblquote');
	var datemula = document.getElementById("datemula").value;
	var datetamat = document.getElementById("datetamat").value;		
	var jangkamasa = document.getElementById("jangkamasa").value;	
	var no_peruntukan = document.getElementById("no_peruntukan").value;	
	var kos = document.getElementById("kos").value;
	var kos2 = document.getElementById("kos2").value;
	var bon_perlaksanaan2 = document.getElementById("bon_perlaksanaan2").value;
	var kaedah = document.getElementById("kaedah").value;
	var kesemua_bon = document.getElementById("kesemua_bon");
	var kesemua_insuran = document.getElementById("kesemua_insuran");
	//var counter = document.getElementById("counter").value;
	
	if(kesemua_bon.checked == true){
		kesemua_bon = 1;
	}
	else{
		kesemua_bon = 0;
	}
	
	if(kesemua_insuran.checked == true){
		kesemua_insuran = 1;
	}
	else{
		kesemua_insuran = 0;
	}
	
	if(kos2 == ''){
		kos2 = 0;
	}
	else{
		kos2 = kos2;
	}
	
	var kos3 = document.getElementById("kos3").value;
	
	if(kos3 == ''){
		kos3 = 0;
	}
	else{
		kos3 = kos3;
	}
	
	var kadar_harga = document.getElementById("checkbox_kos");
	
	if(kadar_harga.checked == true){
		kadar_harga = 1;
	}
	else{
		kadar_harga = 0;
	}
		
	var p_projek = document.getElementById("p_projek").value;
	var jawatan_pprojek = document.getElementById("jawatan_pprojek").value;
	var email = document.getElementById("email").value;
	
	var pen_projek = document.getElementById("pen_projek").value;
	var jawatan_penprojek = document.getElementById("jawatan_penprojek").value;
	var ptbk = document.getElementById("ptbk").value;
	var jawatan_ptbk = document.getElementById("jawatan_ptbk").value;
	
	AjaxGo("","delete_bidangp2","&idupdate="+idupdate,"insert_bidangp2","");
	AjaxGo("","delete_insuranprojek","&idupdate="+idupdate,"insert_insuranprojek","");
	
	AjaxGo("update"+idupdate,"update_project","&idupdate="+idupdate+"&awal="+awal+"&tengah="+tengah+"&akhir="+akhir+"&kategori="+kategori+"&bidangprojek="+bidangprojek+"&jenis="+jenis+"&kontraktor="+kontraktor+"&jabatan="+jabatan+"&nama_projek="+nama_projek+"&datemula="+datemula+"&datetamat="+datetamat+"&jangkamasa="+jangkamasa+"&no_peruntukan="+no_peruntukan+"&kos="+kos+"&kos2="+kos2+"&kos3="+kos3+"&kadar_harga="+kadar_harga+"&p_projek="+p_projek+"&jawatan_pprojek="+jawatan_pprojek+"&email="+email+"&bon_perlaksanaan2="+bon_perlaksanaan2+"&kaedah="+kaedah+"&kesemua_bon="+kesemua_bon+"&kesemua_insuran="+kesemua_insuran+"&pen_projek="+pen_projek+"&jawatan_penprojek="+jawatan_penprojek+"&ptbk="+ptbk+"&jawatan_ptbk="+jawatan_ptbk,"display_project","");		
}

function insert_insuranprojek(){	
	
	var counter2 = document.getElementById("counter2").value;
	var idupdate = document.getElementById("idupdate").value;
	
	for(i=1;i<=counter2;i++){
		if(document.getElementById("insuran"+i)){
			if(document.getElementById("insuran"+i).value != ""){		
				var insuran = document.getElementById("insuran"+i).value;
				var nilai = document.getElementById("nilai"+i).value;
			//alert(insuran+"xx"+nilai+"xx"+idupdate);
				AjaxGo("","insert_insuranprojek","&idupdate="+idupdate+"&insuran="+insuran+"&nilai="+nilai,"","");			
			}
		}
	}
	
}

function insert_bidangp2(){
	
	var id_check = document.getElementsByName("bidang[]");
	var idupdate = document.getElementById("idupdate").value;
	var check_box = id_check;
		
		for (var x = 0; x<check_box.length; x++) 
		{
			if (check_box[x].checked) 
			{
			var id_check = check_box[x].value;
			//alert(id_check)
			AjaxGo("","insert_bidangp2","&idupdate="+idupdate+"&id_check="+id_check,"","");			
			}
		}
	
	}

function display_project(data,layer) {
	
	dataArr = data.split("|");
	
	for (var i=0;i<=10;i++){
		if (dataArr[i]== ""){
			dataArr[i] = "-";
		}
	}
	document.getElementById(layer+"_1").innerHTML = dataArr[0];
	document.getElementById(layer+"_2").innerHTML = dataArr[1];
	document.getElementById(layer+"_3").innerHTML = dataArr[2];
	document.getElementById(layer+"_4").innerHTML = dataArr[3];
	document.getElementById(layer+"_5").innerHTML = dataArr[4];
	document.getElementById(layer+"_6").innerHTML = dataArr[5];
	document.getElementById(layer+"_7").innerHTML = dataArr[6];
	document.getElementById(layer+"_8").innerHTML = dataArr[7];
	document.getElementById(layer+"_9").innerHTML = dataArr[8];
	document.getElementById(layer+"_10").innerHTML = dataArr[9];
	document.getElementById(layer+"_11").innerHTML = dataArr[10];
}



function showinclude(){
	 	
		AjaxGo("includediv","includediv","","displayinclude","");
	
	  }

function displayinclude(data,layer) {
	document.getElementById(layer).innerHTML = data;
	
	//alert(data);
	
}

function classcondition(obj){
	
	if(obj.value == 1){
		document.getElementById("label_bidang").innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;Kelas";
		document.getElementById("kontraktor_bidang").innerHTML ='	<select name="kontraktor" id="kontraktor"> '+
                      												'		<option>---Sila Pilih---</option> '+
                   													'	</select>'
		bidangshow(0);	
	}
	
	if(obj.value == 2){
		document.getElementById("label_bidang").innerHTML = "";
		AjaxGo("bidang","bidanghide","","get_contractor2","")
		
	}
	if(obj.value == 3){
		document.getElementById("label_bidang").innerHTML = "";
		AjaxGo("bidang","bidanghide","","get_contractor2","")
		
	}
	
}

function classcondition2(obj){
	
	if(obj.value == 1){
		document.getElementById("hide").style.display = "inline";
		document.getElementById("label_bidang").innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;Kelas";
		AjaxGo("bidang","bidangshow","&perunding="+0,"","")

	}
	
	if(obj.value == 2){
		document.getElementById("label_bidang").innerHTML = "";
		AjaxGo("bidang","bidanghide","","","")
		
	}
	if(obj.value == 3){
		document.getElementById("label_bidang").innerHTML = "";
		AjaxGo("bidang","bidanghide","","","")
		
	}
	
}

function get_contractor2(){

	if(document.getElementById("bidangprojek")){
	
	var bidangid = document.getElementById("bidangprojek").value;
	}
	
	var perunding = radio_button(document.getElementsByName("perunding"));
	
	if(document.getElementById("kategori")){
		var kategori = document.getElementById("kategori").value;
	}
	
	AjaxGo("kontraktor_bidang","kontraktor_bidang2","&bidangid="+bidangid+"&perunding="+perunding+"&kategori="+kategori,"","");
		
}

function get_type(object){
	
	var data = object.value;
	
	AjaxGo("type_short","type_short","&data="+data,"","");
}

function bidang_perunding(){
	var data = 1;
	
	var id_check = document.getElementsByName("bidang_perunding[]");
//	var idupdate = document.getElementById("idupdate").value;
	var check_box = id_check;
	var bidang="";	
		for (var x = 0; x<check_box.length; x++) 
		{
			if (check_box[x].checked) 
			{
				var id_check = check_box[x].value;
				if (bidang=="") {
					bidang=id_check;
				} else {
					bidang=bidang+","+id_check;
				}
			//AjaxGo("","insert_bidangp","&idupdate="+idupdate+"&id_check="+id_check,"","");			
			}
		}
	AjaxGo("kontraktor_bidang","bidang_perunding","&data="+data,"","");			
			
		
}

function check_kontrak(){
	
	var kontrak1 = document.getElementById("no_kontrak").value;
	var kontrak2 = document.getElementById("no_kontrak2").value;
	var kontrak3 = document.getElementById("no_kontrak3").value
	
	//alert(kontrak2)
	AjaxGo("","check_kontrak","&kontrak1="+kontrak1+"&kontrak2="+kontrak2+"&kontrak3="+kontrak3,"check_kontrak_display","");	
}

function check_kontrak_display(data,layer){
	
	data.replace(" ","");
	if(data==1){
	alert("No kontak tersebut telah didaftarkan. Sila masukkan nombor kontrak yang berbeza.");
	}
}

//shahrul end
//Nurul punye

function selectJenis()
{
	var jenisKontraktor = document.getElementById('jenisKontraktor').value;
	AjaxGo("laporan","getReport","&jenisKontraktor="+jenisKontraktor,"","");
}

function searchData()
{
	var namaProjek = document.getElementById('namaProjek').value;
	var jenisKontraktor = document.getElementById('jenisKontraktor').value;
	var selBumi = document.getElementById('selBumi').value;
	var jabatan = document.getElementById('selJabatan').value;
	var kategori = document.getElementById('selKategori').value;
	var jenis = document.getElementById('selJenis').value;
	var dari = document.getElementById('dari').value;
	var ke = document.getElementById('ke').value;
	var from = document.getElementById('from').value;
	var to = document.getElementById('to').value;
	var selStatus = document.getElementById('selStatus').value;
	
	if(jenisKontraktor!="")
	{
		var selKontraktor = document.getElementById('selKontraktor').value;
		AjaxGo("res","getData","&namaProjek="+namaProjek+"&jenisKontraktor="+jenisKontraktor+"&selKontraktor="+selKontraktor+"&selBumi="+selBumi+"&selJabatan="+jabatan+"&selKategori="+kategori+"&selJenis="+jenis+"&dari="+dari+"&ke="+ke+"&from="+from+"&to="+to+"&selStatus="+selStatus,"","");
	}
	else
	
	AjaxGo("res","getData","&namaProjek="+namaProjek+"&jenisKontraktor="+jenisKontraktor+"&selBumi="+selBumi+"&selJabatan="+jabatan+"&selKategori="+kategori+"&selJenis="+jenis+"&dari="+dari+"&ke="+ke+"&from="+from+"&to="+to+"&selStatus="+selStatus,"","");
}

function searchKontraktor()
{	
	var jenisKontraktor = document.getElementById('jenisKontraktor').value;
	var bumi = document.getElementById('selBumi').value;
	var jabatan = document.getElementById('selJabatan').value;
	var status = document.getElementById('selSenarai').value;
	
	if(jenisKontraktor!=""){
		var selKontraktor = document.getElementById('selKontraktor').value;
		AjaxGo("kon","getKontraktor","&jenisKontraktor="+jenisKontraktor+"&selKontraktor="+selKontraktor+"&selBumi="+bumi+"&selJabatan="+jabatan+"&selSenarai="+status,"","");
	}
	else
	{
		AjaxGo("kon","getKontraktor","&jenisKontraktor="+jenisKontraktor+"&selBumi="+bumi+"&selJabatan="+jabatan+"&selSenarai="+status,"","");
	}	
}

function searchWang()
{	  	
	var dari = document.getElementById('from').value;
	var ke = document.getElementById('to').value;
	var jabatan = document.getElementById('selJabatan').value;
	var jenisKontraktor = document.getElementById('jenisKontraktor').value;
	var jenis = document.getElementById('selJenis').value;
	
	if(jenisKontraktor!=""){
		var selKontraktor = document.getElementById('selKontraktor').value;
		AjaxGo("kewangan","getWang","&from="+dari+"&to="+ke+"&selJabatan="+jabatan+"&jenisKontraktor="+jenisKontraktor+"&selKontraktor="+selKontraktor+"&selJenis="+jenis,"","");
	}
	else
	{
		AjaxGo("kewangan","getWang","&from="+dari+"&to="+ke+"&selJabatan="+jabatan+"&jenisKontraktor="+jenisKontraktor+"&selJenis="+jenis,"","");
	}	
	
	
		
}

function searchAnalisis()
{	
	var jabatan = document.getElementById('selJabatan').value;
	var tahun = document.getElementById('selTahun').value;
	AjaxGo("analisis","getAnalisis","&selJabatan="+jabatan+"&selTahun="+tahun,"","");
}

//syed 27062012 start

function loadProject() {
	document.getElementById("projectData").innerHTML="";
	var jab = document.getElementById("jabatan").value;
	AjaxGo("projectList","projectList","&jab="+jab,"","images/loading.gif");
	findProj();
}

function updateName() {
	var ref = document.getElementById("referen").value;
	document.getElementById("project_name").value=ref;
	findProj();
}

function updateRef() {
	var name = document.getElementById("project_name").value;
	document.getElementById("referen").value=name;
	findProj();
}

function checknumberpercent(obj) {	
	obj.value=obj.value.replace(/[^\d\.]/g,'');
	if (obj.value>100) {
		var ret = obj.value.replace(/(\s+)?.$/,'');
	} else {
		var ret = obj.value;
	}
	var n = ret.indexOf(".");
	if (n!=-1) {
		if(ret.length>n+2) {
			ret=ret.substr(0,n+3);
		}
	}
	obj.value = ret;	
}

function numberkosfloat(MyString) {
	var x = MyString.value;
	y=x.replace(/[^\d\.]/g,'');
	var objRegex  = new RegExp('(-?[0-9]+)([0-9]{3})');
	
	while(objRegex.test(y)) {
		y = y.replace(objRegex, '$1,$2');
	}
	
	var n = y.indexOf(".");
	if (n!=-1) {
		if(y.length>n+2) {
			y=y.substr(0,n+3);
		}
	}			
	MyString.value=y;
}

function popup(dataLayer) {
	if (document.getElementById(dataLayer)) {
		var data = document.getElementById(dataLayer).innerHTML;
		var dataChk = data.replace(" ","");
		if (dataChk!="") {
			update12(data,"");
		}
	}
}

function addEot(pid) {
	var date_eot = document.getElementById("date_eot").value;
	if (date_eot!="") {
		document.getElementById("date_eot").value="";
		AjaxGo("eotDet","addEot","&pid="+pid+"&date_eot="+date_eot,"reloadEot","images/loading.gif");
	} else {
		alert("Sila masukkan tarikh lanjutan masa.");
		document.getElementById("date_eot").focus();
	}
}

function deleteEot(pid,date_eot) {
	var confirmDelete = confirm("Adakah anda pasti?");
	if (confirmDelete==true) {
		AjaxGo("eotDet","deleteEot","&pid="+pid+"&date_eot="+date_eot,"reloadEot","images/loading.gif");
	}
}

function reloadEot(data,layer) {
	AjaxGo("eotDet","reloadEot","&pid="+data,"","images/loading.gif");
}

function addEoc(pid) {
	var amount_eoc = document.getElementById("amount_eoc").value;
	var date_eoc = document.getElementById("date_eoc").value;
	if ((date_eoc!="")&&(amount_eoc!="")) {
		document.getElementById("amount_eoc").value="";
		document.getElementById("date_eoc").value="";
		AjaxGo("eocDet","addEoc","&pid="+pid+"&amount_eoc="+amount_eoc+"&date_eoc="+date_eoc,"reloadEoc","images/loading.gif");
	} else if (amount_eoc=="") {
		alert("Sila masukkan jumlah harga kontrak baru.");
		document.getElementById("amount_eoc").focus();
	} else if (date_eoc=="") {
		alert("Sila masukkan tarikh harga kontrak baru.");
		document.getElementById("date_eoc").focus();
	}
}

function deleteEoc(pid,amount_eoc,date_eoc) {
	//alert(pid+"^"+amount_eoc+"^"+date_eoc);
	var confirmDelete = confirm("Adakah anda pasti?");
	if (confirmDelete==true) {
		AjaxGo("eocDet","deleteEoc","&pid="+pid+"&amount_eoc="+amount_eoc+"&date_eoc="+date_eoc,"reloadEoc","images/loading.gif");
	}
}

function reloadEoc(data,layer) {
	var dataArr = data.split("^");
	if (dataArr.length==2) {
		AjaxGo("eocDet","reloadEoc","&pid="+dataArr[0]+"&status="+dataArr[1],"","images/loading.gif");

		if (dataArr[1]!=1) {
			var url = "AjaxGo(\"eocDet\",\"reloadEoc\",\"&pid="+parseInt(dataArr[0])+"\",\"\",\"images/loading.gif\")";
			setTimeout(url,5000);
		}

	} else {
		AjaxGo("eocDet","reloadEoc","&pid="+parseInt(data),"","images/loading.gif");
	}
}

function setCheckbox(cnt,pid,conid,scaleid) {
	//alert(cnt+"^"+pid+"^"+conid+"^"+perfid);
	var currChk = document.getElementById("cp_"+scaleid).checked;
	for (var i=1;i<=cnt;i++) {
		if (document.getElementById("cp_"+i)) {
			document.getElementById("cp_"+i).checked = false;
		}
	}
	if (currChk==false) {
		document.getElementById("cp_"+scaleid).checked=false;
		AjaxRun("ContractorPerformanceRemove","&pid="+pid+"&conid="+conid+"&scaleid="+scaleid)
	} else {
		document.getElementById("cp_"+scaleid).checked=true;
		AjaxRun("ContractorPerformance","&pid="+pid+"&conid="+conid+"&scaleid="+scaleid)
	}
}

//syed 27062012 end


//athirah start

function email2(email) {
	var userId = email.value;
	AjaxGo("emailAjax","emailAjax","&userId="+userId,"","");	
}

function jawatan2(jwtn) {
	var userId = jwtn.value;
	AjaxGo("jawatanAjax","jawatanAjax","&userId="+userId,"","");	
}

//athirah end