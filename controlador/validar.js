function mascara(d,sep,pat,nums)
 {
  if(d.valant != d.value){
  val = d.value
  largo = val.lengt
  val = val.split(sep)
  val2 = ''
  for(r=0;r<val.length;r++){
  val2 += val[r]
  }
  if(nums){
  for(z=0;z<val2.length;z++){
  if(isNaN(val2.charAt(z))){
  letra = new RegExp(val2.charAt(z),"g")
  val2 = val2.replace(letra,"")
  }
  }
  }
  val = ''
  val3 = new Array()
  for(s=0; s<pat.length; s++){
  val3[s] = val2.substring(0,pat[s])
  val2 = val2.substr(pat[s])
  }
  for(q=0;q<val3.length; q++){
  if(q ==0){
  val = val3[q]
  }
  else{
  if(val3[q] != ""){
  val += sep + val3[q]
  }
  }
  }
  d.value = val
  d.valant = val
  }
  }

function catalogo(campo)
{
pagina=campo;
window.open(pagina,"Catalogo","menubar=no,toolbar=no,scrollbars=yes,width=500,heigth=400,resizable=yes,left=50,top=50");
}
function catalogo1(campo)
{
pagina=campo;
window.open(pagina,"Catalogo","menubar=no,toolbar=no,scrollbars=yes,width=580,heigth=400,resizable=yes,left=50,top=50");
}

function catalogo2(campo)
{
pagina=campo;
window.open(pagina,"Catalogo","menubar=no,toolbar=no,scrollbars=yes,width=1000,heigth=400,resizable=yes,left=50,top=50");
}

function valcaract(campo) {
    var RegExPattern = /(?!^[0-9]*$)(?!^[a-zA-Z]*$)^([a-zA-Z0-9]{8,10})$/;
    var error = 'Incorrecto ingrese solo Letras y Numeros.';
    if ((campo.value.match(RegExPattern)) && (campo.value!='')) {
        alert('Password Correcta');
    } else {
        alert(error);
        campo.focus();
     return (false);
    }
}

function val(evt){
 var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(evt)) {
   alert('No puedes ingresar Caracates especiales!');
   return (false);
   }
   }
   //onblur="val(this.value)"
function acessoNumerico(evt){
var nav4 = window.Event ? true : false;
var key = nav4 ? evt.which : evt.keyCode;
return (key <= 13 || (key >= 48 && key <= 57));
}
//onKeyPress="return acessoNumerico(event)"
function show_calendar(str_target, str_datetime) {
  var arr_months = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
    "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
  var week_days = ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"];
  var n_weekstart = 1; // day week starts from (normally 0 or 1)

  var dt_datetime = (str_datetime == null || str_datetime =="" ?  new Date() : str2dt(str_datetime));
  var dt_prev_month = new Date(dt_datetime);
  dt_prev_month.setMonth(dt_datetime.getMonth()-1);
  var dt_next_month = new Date(dt_datetime);
  dt_next_month.setMonth(dt_datetime.getMonth()+1);
  var dt_firstday = new Date(dt_datetime);
  dt_firstday.setDate(1);
  dt_firstday.setDate(1-(7+dt_firstday.getDay()-n_weekstart)%7);
  var dt_lastday = new Date(dt_next_month);
  dt_lastday.setDate(0);

  // html generation (feel free to tune it for your particular application)
  // print calendar header
  var Ruta = "images";
  var str_buffer = new String (
    "<html>\n"+
    "<head>\n"+
    "	<title>Calendar</title>\n"+
    "</head>\n"+
    "<body bgcolor=\"White\">\n"+
    "<table class=\"clsOTable\" cellspacing=\"0\" border=\"0\" width=\"100%\">\n"+
    "<tr><td bgcolor=\"#035E8D\">\n"+
    "<table cellspacing=\"1\" cellpadding=\"3\" border=\"0\" width=\"100%\">\n"+
    "<tr>\n	<td bgcolor=\"#035E8D\"><a href=\"javascript:window.opener.show_calendar('"+
    str_target+"', '"+ dt2dtstr(dt_prev_month)+"'+document.cal.time.value);\">"+
    "<img src=\"" +Ruta+ "/prev1.gif\"  width=\"16\" height=\"16\" border=\"0\""+
    " alt=\"previous month\"></a></td>\n"+
    "	<td bgcolor=\"#035E8D\" colspan=\"5\">"+
    "<font color=\"white\" face=\"tahoma, verdana\" size=\"2\">"
    +arr_months[dt_datetime.getMonth()]+" "+dt_datetime.getFullYear()+"</font></td>\n"+
    "	<td bgcolor=\"#035E8D\" align=\"right\"><a href=\"javascript:window.opener.show_calendar('"
    +str_target+"', '"+dt2dtstr(dt_next_month)+"'+document.cal.time.value);\">"+
    "<img src=\"" +Ruta+ "/next1.gif\" width=\"16\" height=\"16\" border=\"0\""+
    " alt=\"next month\"></a></td>\n</tr>\n"
  );

  var dt_current_day = new Date(dt_firstday);
  // print weekdays titles
  str_buffer += "<tr>\n";
  for (var n=0; n<7; n++)
    str_buffer += "	<td bgcolor=\"#87CEFA\">"+
    "<font color=\"white\" face=\"tahoma, verdana\" size=\"2\">"+
    week_days[(n_weekstart+n)%7]+"</font></td>\n";
  // print calendar table
  str_buffer += "</tr>\n";
  while (dt_current_day.getMonth() == dt_datetime.getMonth() ||
    dt_current_day.getMonth() == dt_firstday.getMonth()) {
    // print row heder
    str_buffer += "<tr>\n";
    for (var n_current_wday=0; n_current_wday<7; n_current_wday++) {
        if (dt_current_day.getDate() == dt_datetime.getDate() &&
          dt_current_day.getMonth() == dt_datetime.getMonth())
          // print current date
          str_buffer += "	<td bgcolor=\"#C0C0C0\" align=\"right\">";
        else if (dt_current_day.getDay() == 0 || dt_current_day.getDay() == 6)
          // weekend days
          str_buffer += "	<td bgcolor=\"#DBEAF5\" align=\"right\">";
        else
          // print working days of current month
          str_buffer += "	<td bgcolor=\"white\" align=\"right\">";

        if (dt_current_day.getMonth() == dt_datetime.getMonth())
          // print days of current month
          str_buffer += "<a href=\"javascript:window.opener."+str_target+
          ".value='"+dt2dtstr(dt_current_day)+"'+document.cal.time.value; window.close();\">"+
          "<font color=\"black\" face=\"tahoma, verdana\" size=\"2\">";
        else
          // print days of other months
          str_buffer += "<a href=\"javascript:window.opener."+str_target+
          ".value='"+dt2dtstr(dt_current_day)+"'+document.cal.time.value; window.close();\">"+
          "<font color=\"gray\" face=\"tahoma, verdana\" size=\"2\">";
        str_buffer += dt_current_day.getDate()+"</font></a></td>\n";
        dt_current_day.setDate(dt_current_day.getDate()+1);
    }
    // print row footer
    str_buffer += "</tr>\n";
  }
  // print calendar footer
  str_buffer +=
    "<form name=\"cal\">\n<tr><td colspan=\"7\" bgcolor=\"#87CEFA\">"+
    "<font color=\"White\" face=\"tahoma, verdana\" size=\"2\">"+
    "<input type=\"hidden\" name=\"time\" value=\""+dt2tmstr(dt_datetime)+
    "\" size=\"8\" maxlength=\"8\"></font></td></tr>\n</form>\n" +
    "</table>\n" +
    "</tr>\n</td>\n</table>\n" +
    "</body>\n" +
    "</html>\n";

  var vWinCal = window.open("", "Calendar",
    "width=200,height=210,status=no,resizable=no,top=200,left=200");
  vWinCal.opener = self;
  var calc_doc = vWinCal.document;
  calc_doc.write (str_buffer);
  calc_doc.close();
}

// datetime parsing and formatting routimes. modify them if you wish other datetime format
function str2dt (str_datetime) {
  var re_date = /^(\d+)\/(\d+)\/(\d+)/;
//	var re_date = /^(\d+)\/(\d+)\/(\d+)\s+(\d+)\:(\d+)\:(\d+)$/;
  if (!re_date.exec(str_datetime))
    return alert("Invalid Datetime format: "+ str_datetime);
  return (new Date (RegExp.$3, RegExp.$2-1, RegExp.$1, RegExp.$4, RegExp.$5, RegExp.$6));
}

function dt2dtstr (dt_datetime) {
  var dia = (dt_datetime.getDate()).toString();
  var mes = (dt_datetime.getMonth()+1).toString();
  if ( dia.length < 2 )
    {
      dia = 	"0" + dia	;
    }
  if ( mes.length < 2 )
    {
      mes = "0" + mes;
    }
  return (new String (dia+"/"+mes+"/"+dt_datetime.getFullYear()+""));
//	return (new String (dt_datetime.getDate()+"/"+(dt_datetime.getMonth()+1)+"/"+dt_datetime.getFullYear()+""));
}
function dt2tmstr (dt_datetime) {
  var hora = dt_datetime.getHours();
  if ( hora > 12 )
    {
      hora = hora - 12
    }
  return "";
//	return (new String (hora +":"+dt_datetime.getMinutes()+":"+dt_datetime.getSeconds()));
//	return (new String (dt_datetime.getHours() +":"+dt_datetime.getMinutes()+":"+dt_datetime.getSeconds()));
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_validateForm() { //v4.0
  var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
  for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
    if (val) { nm=val.name; if ((val=val.value)!="") {
      if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
        if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
      } else if (test!='R') { num = parseFloat(val);
        if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
  } if (errors) alert('The following error(s) occurred:\n'+errors);
  document.MM_returnValue = (errors == '');
}




function campos_clases(){
 if (document.form1.cod.value.length==0){
    alert("Debe Ingresar un código");
    document.form1.cod.focus()
    return (false);
                                      }
                                      else
                     {
   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.cod.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.cod.focus()
    return (false);}
                     }

 if (document.form1.nomb.value.length==0){
  alert("Debe Ingresar una Descripción");
  document.form1.nomb.focus()
  return (false);
                                         }else
                     {
   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.nomb.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.nomb.focus()
    return (false);}
                     }

enviarDatosClases();
}

function campos_color(){
 if (document.form1.cod.value.length==0){
    alert("Debe Ingresar un código");
    document.form1.cod.focus()
    return (false);
                                      }
                                      else
                     {
   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.cod.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.cod.focus()
    return (false);}
                     }

 if (document.form1.nomb.value.length==0){
  alert("Debe Ingresar una Descripción");
  document.form1.nomb.focus()
  return (false);
                                         }
                                         else
                     {
   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.nomb.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.nomb.focus()
    return (false);}
                     }

enviarDatosColor();
}

function campos_uso(){
 if (document.form1.cod.value.length==0){
    alert("Debe Ingresar un código");
    document.form1.cod.focus()
    return (false);
                                      }
                                      else
                     {
   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.cod.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.cod.focus()
    return (false);}
                     }

 if (document.form1.nomb.value.length==0){
  alert("Debe Ingresar una Descripción");
  document.form1.nomb.focus()
  return (false);
                                         }
                                         else
                     {
   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.nomb.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.nomb.focus()
    return (false);}
                     }

enviarDatosUso();
}

function campos_combustible(){
 if (document.form1.cod.value.length==0){
    alert("Debe Ingresar un código");
    document.form1.cod.focus()
    return (false);
                                      }

 if (document.form1.nomb.value.length==0){
  alert("Debe Ingresar una Descripción");
  document.form1.nomb.focus()
  return (false);
                                         }
                                         else
                     {
   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.nomb.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.nomb.focus()
    return (false);}
                     }

enviarDatosCombustible();
}

function campos_estado(){
 if (document.form1.cod.value.length==0){
    alert("Debe Ingresar un código");
    document.form1.cod.focus()
    return (false);
                                      }
                                      else
                     {
   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.cod.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.cod.focus()
    return (false);}
                     }

 if (document.form1.nomb.value.length==0){
  alert("Debe Ingresar una Descripción");
  document.form1.nomb.focus()
  return (false);
                                         }
                                         else
                     {
   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.nomb.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.nomb.focus()
    return (false);}
                     }

enviarDatosEstado();
}

function campos_marca(){
 if (document.form1.cod.value.length==0){
    alert("Debe Ingresar un código");
    document.form1.cod.focus()
    return (false);
                                      }
                                      else
                     {
   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.cod.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.cod.focus()
    return (false);}
                     }

 if (document.form1.nomb.value.length==0){
  alert("Debe Ingresar una Descripción");
  document.form1.nomb.focus()
  return (false);
                                         }
                                         else
                     {
   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.nomb.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.nomb.focus()
    return (false);}
                     }

enviarDatosMarca();
}


function campos_servicios(){
 if (document.form1.cod.value.length==0){
    alert("Debe Ingresar un código");
    document.form1.cod.focus()
    return (false);
                                      }
                                      else
                     {
   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.cid.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.cod.focus()
    return (false);}
                     }

 if (document.form1.nomb.value.length==0){
  alert("Debe Ingresar una Descripción");
  document.form1.nomb.focus()
  return (false);
                                         }
                                         else
                     {
   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.nomb.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.nomb.focus()
    return (false);}
                     }

enviarDatosServicios();
}

function campos_tipos(){
 if (document.form1.cod.value.length==0){
    alert("Debe Ingresar un código");
    document.form1.cod.focus()
    return (false);
                                      }
                                      else
                     {
   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.cod.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.cod.focus()
    return (false);}
                     }

 if (document.form1.nomb.value.length==0){
  alert("Debe Ingresar una Descripción");
  document.form1.nomb.focus()
  return (false);
                                         }
                                         else
                     {
   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.nomb.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.nomb.focus()
    return (false);}
                     }

enviarDatosTipos();
}

function campos_empresa(){
 if (document.form1.cod.value.length==0){
    alert("Debe Ingresar un código");
    document.form1.cod.focus()
    return (false);
                                      }
                                      else
                     {
   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.cod.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.cod.focus()
    return (false);}
                     }
if (document.form1.reg.value.length==0){
  alert("Debe Ingresar un N° de Registro");
  document.form1.reg.focus()
  return (false);
                                         }
 if (document.form1.nomb.value.length==0){
  alert("Debe Ingresar un Nombre");
  document.form1.nomb.focus()
  return (false);
                                         }
                                         else
                     {
   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.nomb.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.nomb.focus()
    return (false);}
                     }



enviarDatosEmpresa();
}

function campos_ensambladora()         {
if (document.form1.cod.value.length==0){
    alert("Debe Ingresar el código del rif");
    document.form1.cod.focus()
    return (false);
                                      }
                                      else
                     {
   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.cod.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.cod.focus()
    return (false);}
                     }

if (document.form1.num.value.length==0){
  alert("Debe Ingresar el N° de rif");
  document.form1.num.focus()
  return (false);
                                     }
if (document.form1.num.value.length<=7){
  alert("Debe Ingresar 8 numeros  para el rif");
  document.form1.num.focus()
  return (false);
                                     }

if (document.form1.dig.value.length==0){
  alert("Debe Ingresar el digito del rif");
  document.form1.dig.focus()
  return (false);
                                       }

 if (document.form1.nomb.value.length==0){
  alert("Debe Ingresar un Nombre");
  document.form1.nomb.focus()
  return (false);
                                         }
                                         else
                     {
   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.nomb.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.nomb.focus()
    return (false);}
                     }
enviarDatosEnsambladora();
}

function campos_lote()
{
	if (document.form1.fec.value.length==0)
	{
	  alert("Debes Ingresar una Fecha");
 	  document.form1.fec.focus()
 	  return (false);
    }
	if (document.form1.nomb.value.length==0)
	{
	  alert("Debe Ingresar una Descripción");
	  document.form1.nomb.focus()
      return (false);
    }
    else
    {
   		var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
		   if (!filter.test(document.form1.nomb.value)) {
			   alert('No puedes ingresar Caracteres especiales!');
			   document.form1.nomb.focus()
			   return (false);
			}
    }
enviarDatosLote();
}

function campos_modelo(){
 if (document.form1.cod.value.length==0){
    alert("Debe Ingresar un código");
    document.form1.cod.focus()
    return (false);
                                      }else
                     {
   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.cod.value)) {
   alert('No puedes ingresar Caracteres especiales!');
   document.form1.cod.focus()
    return (false);}
                     }

if (document.form1.des.value.length==0){
  alert("Debes Ingresar una descripción");
  document.form1.des.focus()
  return (false);
                                         }else
                     {
   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.des.value)) {
   alert('No puedes ingresar Caracteres especiales!');
   document.form1.des.focus()
    return (false);}
                     }


enviarDatosModelo();
}

function campos_serie(){

 if (document.form1.cod.value.length==0){
    alert("Debe Ingresar un código");
    document.form1.cod.focus()
    return (false);
                                      }
                                      else
                     {
   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.cod.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.cod.focus()
    return (false);}
                     }

if (document.form1.des.value.length==0){
  alert("Debes Ingresar una descripción");
  document.form1.des.focus()
  return (false);
                                         }




enviarDatosSerie();
}

function campos_pto(){
 if (document.form1.cod.value.length==0){
    alert("Debe Ingresar un código");
    document.form1.cod.focus()
    return (false);
                                      }
                                      else
                     {
   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.cod.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.cod.focus()
    return (false);}
                     }

 if (document.form1.nomb.value.length==0){
  alert("Debe Ingresar una Descripción");
  document.form1.nomb.focus()
  return (false);
                                         }else
                     {
   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.nomb.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.nomb.focus()
    return (false);}
                     }

enviarDatosPto();
}

function campos_propietario(){
 if (document.form1.numrif.value.length==0){
    alert("Debe Ingresar un N° de RIF");
    document.form1.numrif.focus()
    return (false);
                                      }


 if (document.form1.numrif.value.length<=6){
    alert("Debe Ingresar minimo 7 digitos");
    document.form1.numrif.focus()
    return (false);
                                      }

 if (document.form1.digrif.value.length==0){
  alert("Debe Ingresar el ultimo Digito del RIF");
  document.form1.digrif.focus()
  return (false);
                                         }

 if (document.form1.nom1.value.length==0){
    alert("Debe Ingresar el Primer Nombre del Propietario");
    document.form1.nom1.focus()
    return (false);
 }else
 {
   var filter = /^[a-z0-9_\-\.\ \[\]\(\)]+$/i;
   if (!filter.test(document.form1.nom1.value)) {
   alert('Caracteres no validos en el Primer nombre');
   document.form1.nomb1.focus();
   return (false);}
 }

if (document.form1.nom2.value.length > 0){
     var letras_mayusculas="0123456789ABCDEFGHIJKLMNÑOPQRSTUVWXYZ ";
    var texto = document.form1.nom2.value;
    var ind = 1;
    for(i=0; i<texto.length; i++){
      if (letras_mayusculas.indexOf(texto.charAt(i))==-1){
         ind = 0;
         break;
      }
    }
    if(!ind){
      alert('Caracteres no validos en el segundo nombre');
      document.form1.nomb2.focus();
      return (false);
    }
   // return ind;
 }

if (document.form1.ape1.value.length > 0){
    var letras_mayusculas="0123456789ABCDEFGHIJKLMNÑOPQRSTUVWXYZ ";
    var texto = document.form1.ape1.value;
    var ind = 1;
    for(i=0; i<texto.length; i++){
      if (letras_mayusculas.indexOf(texto.charAt(i))==-1){
         ind = 0;
         break;
      }
    }
    if(!ind){
      alert('Caracteres no validos en el Primer Apellido');
      document.form1.ape1.focus();
      return (false);
    }
   // return ind;
 }

if (document.form1.ape2.value.length > 0){
    var letras_mayusculas="0123456789ABCDEFGHIJKLMNÑOPQRSTUVWXYZ ";
    var texto = document.form1.ape2.value;
    var ind = 1;
    for(i=0; i<texto.length; i++){
      if (letras_mayusculas.indexOf(texto.charAt(i))==-1){
         ind = 0;
         break;
      }
    }
    if(!ind){
      alert('Caracteres no validos en el segundo Apellido');
      document.form1.ape2.focus();
      return (false);
    }
   // return ind;
 }



/* if (document.form1.ape1.value.length==0 ){
  alert("Debe Ingresar el Primer Apellido del Propietario");
  document.form1.ape1.focus()
  return (false);
                                         }else
                     {
   var filter = /^[a-z0-9_\-\.\ \[\]\(\)]+$/i;
   if (!filter.test(document.form1.ape1.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.ape1.focus()
    return (false);}
                     }*/

 if (document.form1.calle.value.length==0){
    alert("Debe Ingresar la Calle/avenida/plaza/esquina de la direccion del propietario");
    document.form1.calle.focus()
    return (false);
                                      }

 if (document.form1.calle.value.length > 0){
     var letras_mayusculas="0123456789ABCDEFGHIJKLMNÑOPQRSTUVWXYZ ";
    var texto = document.form1.calle.value;
    var ind = 1;
    for(i=0; i<texto.length; i++){
      if (letras_mayusculas.indexOf(texto.charAt(i))==-1){
         ind = 0;
         break;
      }
    }
    if(!ind){
      alert('Caracteres no validos en el campo calle');
      document.form1.calle.focus();
      return (false);
    }
   // return ind;
 }


 if (document.form1.urb.value.length==0){
  alert("Debe Ingresar la Urbanizacion o Barrio  de la direccion del propietario");
  document.form1.urb.focus()
  return (false);
                                         }

 if (document.form1.urb.value.length > 0){
    var letras_mayusculas="0123456789ABCDEFGHIJKLMNÑOPQRSTUVWXYZ ";
    var texto = document.form1.urb.value;
    var ind = 1;
    for(i=0; i<texto.length; i++){
      if (letras_mayusculas.indexOf(texto.charAt(i))==-1){
         ind = 0;
         break;
      }
    }
    if(!ind){
      alert('Caracteres no validos en el campo Urbanizacion');
      document.form1.urb.focus();
      return (false);
    }
   // return ind;
 }


 if (document.form1.casa.value.length==0){
    alert("Debe Ingresar el Nombre del Edificio/casa/quinta  de la direccion del propietario");
    document.form1.casa.focus()
    return (false);
                                      }

 if (document.form1.casa.value.length > 0){
    var letras_mayusculas="0123456789ABCDEFGHIJKLMNÑOPQRSTUVWXYZ ";
    var texto = document.form1.casa.value;
    var ind = 1;
    for(i=0; i<texto.length; i++){
      if (letras_mayusculas.indexOf(texto.charAt(i))==-1){
         ind = 0;
         break;
      }
    }
    if(!ind){
      alert('Caracteres no validos en el campo Casa');
      document.form1.casa.focus();
      return (false);
    }
   // return ind;
 }

if (document.form1.apart.value.length > 0){
     var letras_mayusculas="0123456789ABCDEFGHIJKLMNÑOPQRSTUVWXYZ ";
    var texto = document.form1.apart.value;
    var ind = 1;
    for(i=0; i<texto.length; i++){
      if (letras_mayusculas.indexOf(texto.charAt(i))==-1){
         ind = 0;
         break;
      }
    }
    if(!ind){
      alert('Caracteres no validos en el campo Numero de Apartamento');
      document.form1.apart.focus();
      return (false);
    }
   // return ind;
 }

 if (document.form1.dist.value.length==0){
  alert("Debe Ingresar el Distrito/Municipio/Parroquia de la direccion del propietario");
  document.form1.dist.focus()
  return (false);
                                         }


if (document.form1.dist.value.length > 0){
    var letras_mayusculas="0123456789ABCDEFGHIJKLMNÑOPQRSTUVWXYZ ";
    var texto = document.form1.dist.value;
    var ind = 1;
    for(i=0; i<texto.length; i++){
      if (letras_mayusculas.indexOf(texto.charAt(i))==-1){
         ind = 0;
         break;
      }
    }
    if(!ind){
      alert('Caracteres no validos en el campo Distrito');
      document.form1.dist.focus();
      return (false);
    }
   // return ind;
 }



if (document.form1.ciudad.value.length > 0){
    var letras_mayusculas="0123456789ABCDEFGHYJKLMNÑOPQRSTUVWXYZ ";
    var texto = document.form1.ciudad.value;
    var ind = 1;
    for(i=0; i<texto.length; i++){
      if (letras_mayusculas.indexOf(texto.charAt(i))==-1){
         ind = 0;
         break;
      }
    }
    if(!ind){
      alert('Caracteres no validos en el campo Ciudad');
      document.form1.ciudad.focus();
      return (false);
    }
   // return ind;
 }

/*
var s1 = document.form1.codtlf1.selectedIndex;
var s2= form1.codtlf1.options[s1].text;

  if(s2=="")
  {
   alert("Debe Seleccionar un Codigo de Area");
   return false;
  }*/

if (document.form1.codtlf1.value.length!=4){
  alert("Debe Ingresar un codigo de area de 4 digitos");
  document.form1.codtlf1.focus()
  return (false);
                                         }

 if (document.form1.tlf1.value.length!=7){
  alert("Debe Ingresar un Numero de Télefono de 7 digitos");
  document.form1.tlf1.focus()
  return (false);
                                         }
   if (document.form1.obspro.value.length>10){
  alert("Supero la cantidad maxima de 500 caracteres");
  document.form1.obspro.focus()
  return (false);
                                         }


  document.form1.action="funciones.php?opr=apro";
  document.form1.submit();

}



function campos_reptxtpro(){
 if (document.form1.numlotveh.value.length==0){
    alert("Debe Ingresar un numero de lote");
    document.form1.numlotveh.focus()
    return (false);
                                      }

 if (document.form1.numenv.value.length==0){
    alert("Debe Ingresar un numero de envio");
    document.form1.numenv.focus()
    return (false);
                                      }

 if (document.form1.rifemp.value.length==0){
    alert("Debe Ingresar un numero  de R.I.F");
    document.form1.rifemp.focus()
    return (false);
                                      }

 if (document.form1.nomemp.value.length==0){
    alert("Debe Ingresar el nombre de la Ensambladora");
    document.form1.nomemp.focus()
    return (false);
                                      }

 if (document.form1.numregemp.value.length==0){
    alert("Debe Ingresar un numero de Registro de la Empresa");
    document.form1.numregemp.focus()
    return (false);
                                      }

 if (document.form1.fecfincon.value.length==0){
    alert("Debe Ingresar la fecha de fin de convenio");
    document.form1.fecfincon.focus()
    return (false);
                                      }


enviar_funciones('pdftxtpro.php')
}


function campos_reptxtpla(){
 if (document.form1.numlotveh.value.length==0){
    alert("Debe Ingresar un numero de lote");
    document.form1.numlotveh.focus()
    return (false);
                                      }

 if (document.form1.numenv.value.length==0){
    alert("Debe Ingresar un numero de envio");
    document.form1.numenv.focus()
    return (false);
                                      }

enviar_funciones('pdftxtpla.php')
}

function campos_reptxtveh(){
if (document.form1.iniemp.value.length==0){
    alert("Debe Ingresar las iniciales de la compañia");
    document.form1.iniemp.focus()
    return (false);
                                      }


 if (document.form1.numenv.value.length==0){
    alert("Debe Ingresar un numero de envio");
    document.form1.numenv.focus()
    return (false);
                                      }


 if (document.form1.nomemp.value.length==0){
    alert("Debe Ingresar el nombre de la Ensambladora");
    document.form1.nomemp.focus()
    return (false);
                                      }

 if (document.form1.numregemp.value.length==0){
    alert("Debe Ingresar un numero de Registro de la Empresa");
    document.form1.numregemp.focus()
    return (false);
                                      }

 if (document.form1.fecfincon.value.length==0){
    alert("Debe Ingresar la fecha de fin de convenio");
    document.form1.fecfincon.focus()
    return (false);
                                      }
/*
 if (document.form1.fecdes.value.length==0){
    alert("Debe Ingresar el Rango de fecha completo");
    document.form1.fecdes.focus()
    return (false);
                                      }

 if (document.form1.fechas.value.length==0){
    alert("Debe Ingresar el Rango de fecha completo");
    document.form1.fechas.focus()
    return (false);
                                      }*/

 if (document.form1.numlotveh.value.length==0){
    alert("Debe Ingresar un numero de lote ");
    document.form1.numlotveh.focus()
    return (false);
                                      }



 /*if (document.form1.origen.checked=="false"){
    alert("Debe Seleccionar un origen");
    return (false);
                                      }	*/



enviar_funciones('pdftxt.php');
}


function enviar_funciones(campo){
  //alert("entro");
  document.form1.action=campo;
  document.form1.submit();

}


function cerrar()
{
  window.close();
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function campos_vehimportados(){

   if (document.form1.numlotveh.value.length==0){
    alert("Debe Ingresar un N°  de Lote");
    document.form1.numlotveh.focus()
    return (false);
                                           }

  if (document.form1.sercarveh.value.length!=17){
  alert("Debe Ingresar un serial de carroceria de 17 Caracteres");
  document.form1.sercarveh.focus()
  return (false);
                                         }else
                     {
   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.sercarveh.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.sercarveh.focus()
  return (false);}
                     }




 if (document.form1.codmar.value.length==0){
  alert("Debe Ingresar un codigo de marca ");
  document.form1.codmar.focus()
  return (false);
                                         }
                     else
                     {
   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.codmar.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.codmar.focus()
  return (false);}
                     }



   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.serveh.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.serveh.focus()
  return (false);}


if (document.form1.modveh.value.length==0){
  alert("Debe Ingresar un Modelo");
  document.form1.modveh.focus()
  return (false);                         }
                     else
                     {
   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.modveh.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.modveh.focus()
  return (false);}
                     }

var s3 = document.form1.anomodveh.selectedIndex;
var s4= form1.anomodveh.options[s3].text;

  if(s4=="")
  {
   alert("Debe Seleccionar el año del Modelo ");
   return false;
  }



 if (document.form1.sermotveh.value.length==0){
  alert("Debe Ingresar el serial del Motor");
  document.form1.sermotveh.focus()
  return (false);
                                         } else
                     {
   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.modveh.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.modveh.focus()
  return (false);}
                     }


  if (document.form1.col1veh.value.length!=2){
  alert("Debe Ingresar un Codigo de Color");
  document.form1.col1veh.focus()
  return (false);
                                         } else
                     {
   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.col1veh.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.col1veh.focus()
  return (false);}
                     }


 if (document.form1.pesveh.value.length==0){
  alert("Debe Ingresar el peso del vehiculo");
  document.form1.pesveh.focus()
  return (false);
                                         }

 if (document.form1.tipcapveh.value.length==0){
  alert("Debe Ingresar el tipo de capacidad del vehiculo");
  document.form1.tipcapveh.focus()
  return (false);
                                         }

 if (document.form1.capcarveh.value.length==0){
  alert("Debe Ingresar la capacidad de carga del vehiculo");
  document.form1.capcarveh.focus()
  return (false);
                                         }

 if (document.form1.numejeveh.value.length==0){
  alert("Debe Ingresar el numero de ejes del vehiculo");
  document.form1.numejeveh.focus()
  return (false);
                                         }

 if (document.form1.diarueveh.value.length==0){
  alert("Debe Ingresar el diametro de la rueda del vehiculo");
  document.form1.diarueveh.focus()
  return (false);
                                         }

/*
 if (document.form1.fecemiveh.value.length==0){
    alert("Debe Ingresar la fecha de emisión");
    document.form1.fecemiveh.focus()
    return (false);
                                            }*/


 if (document.form1.codptoveh.value.length!=2){
  alert("Debe Ingresar el codigo del Puerto de Entrada");
  document.form1.codptoveh.focus()
  return (false);
                                         }

 if (document.form1.numliqveh.value.length==0){
  alert("Debe Ingresar el N° de Planilla de liquidacion de gravamenes ");
  document.form1.numliqveh.focus()
  return (false);
                                              } else
                     {
   var filter = /^[a-z0-9_\-\ \.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.numliqveh.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.numliqveh.focus()
  return (false);}
                     }

 if (document.form1.fecplaveh.value.length==0){
    alert("Debe Ingresar la fecha de la planilla de liquidación de gravámenes");
    document.form1.fecplaveh.focus()
    return (false);
                                      }

if (document.form1.numfacveh.value.length==0){
  alert("Debe Ingresar el N° de factura de adquisicion ");
  document.form1.numfacveh.focus()
  return (false);
                                              } else
                     {
   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.numfacveh.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.numfacveh.focus()
  return (false);}
                     }

 if (document.form1.fecfacveh.value.length==0){
  alert("Debe Ingresar la fecha de factura de adquisición");
  document.form1.fecfacveh.focus()
  return (false);
                                         }


 /*if (document.form1.serimpveh.value.length!=17){
  alert("Debe Ingresar el serial de carrozado de 17 caracteres");
  document.form1.serimpveh.focus()
  return (false);
                                              } else
                     {
   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.serimpveh.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.serimpveh.focus()
  return (false);}
                     }*/


var s5 = document.form1.anofabveh.selectedIndex;
var s6= form1.anofabveh.options[s5].text;

  if(s6=="")
  {
   alert("Debe Seleccionar el año del Modelo ");
   return false;
  }

 if (document.form1.sernivveh.value.length!=17){
  alert("Debe Ingresar el N° de serial del N.I.V de 17 caracteres");
  document.form1.sernivveh.focus()
  return (false);
                                     } else
                     {
   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.sernivveh.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.sernivveh.focus()
  return (false);}
                     }

  /* if (document.form1.serchaveh.value.length!=17){
  alert("Debe Ingresar el N° de serial de de Chasis de 17 caracteres");
  document.form1.serchaveh.focus()
  return (false);
                                          } else
                     {
   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.serchaveh.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.serchaveh.focus()
  return (false);}
                     }*/

/*   if (document.form1.numfac1veh.value.length==0){
  alert("Debe Ingresar el N° de factura 1 ");
  document.form1.numfac1veh.focus()
  return (false);
                                          } else
                     {
   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.numfac1veh.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.numfac1veh.focus()
  return (false);}
                     }


   if (document.form1.fecfac1veh.value.length==0){
  alert("Debe Ingresar la fecha de factura");
  document.form1.fecfac1veh.focus()
  return (false);
                                                 }*/

  /* if (document.form1.numhomveh.value.length!=15){
  alert("Debe Ingresar el N° Homologacion INTTT");
  document.form1.numhomveh.focus()
  return (false);
                                          } else
                     {
   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.numhomveh.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.numhomveh.focus()
  return (false);}
                     }

   if (document.form1.fechomveh.value.length==0){
  alert("Debe Ingresar la fecha de la homologacion INTT");
  document.form1.fechomveh.focus()
  return (false);
                                          }*/
/*
if (document.form1.codserveh.value.length!=3){
    alert("Debe Ingresar el codigo del servicio del vehiculo");
    document.form1.codserveh.focus()
    return (false);
                                           } else
                     {
   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.codserveh.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.codserveh.focus()
  return (false);}
                     }*/

 if (document.form1.numpueveh.value.length==0){
    alert("Debe Ingresar el N° de puesto del vehiculo");
    document.form1.numpueveh.focus()
    return (false);
                                            }


   if (document.form1.codconveh.value.length==0){
  alert("Debe Ingresar el tipo de combustible");
  document.form1.codconveh.focus()
  return (false);
                                          }

   if (document.form1.preveh.value.length==0){
  alert("Debe Ingresar el Precio del Vehiculo  utiliza . como separador de decimales ");
  document.form1.preveh.focus()
  return (false);
                                          }else
                     {
   var filter = /^([0-9])*[.]?[0-9]*$/i;
   if (!filter.test(document.form1.preveh.value)) {
   alert('No puedes ingresar Caracates Solo Numero y punto (.) como separador de decimales!');
   document.form1.preveh.focus()
  return (false);}
                     }



/*
if (document.form1.sergasveh.value.length!=17){
    alert("Debe Ingresar el serial Gas natural (GNV)");
    document.form1.sergasveh.focus()
    return (false);
                                           } else
                     {
   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.sergasveh.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.sergasveh.focus()
  return (false);}
                     }

   if (document.form1.cencubveh.value.length==0){
  alert("Debe Ingresar los centimetros cúbicos del motor");
  document.form1.cencubveh.focus()
  return (false);
                                          }

  if (document.form1.feclicveh.value.length==0){
  alert("Debe Ingresar ela fecha de licencia de importacion");
  document.form1.feclicveh.focus()
  return (false);
                                          }

if (document.form1.numlicveh.value.length!=12){
    alert("Debe Ingresar el N° de Lic de Importación");
    document.form1.numlicveh.focus()
    return (false);
                                           } else
                     {
   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.numlicveh.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.numlicveh.focus()
  return (false);}
                     }
*/

 document.form1.action="funciones.php?opr=aveh";
 document.form1.submit();

}


function campos_reptxtpro(){
 if (document.form1.numlotveh.value.length==0){
    alert("Debe Ingresar un numero de lote");
    document.form1.numlotveh.focus()
    return (false);
                                      }

 if (document.form1.numenv.value.length==0){
    alert("Debe Ingresar un numero de envio");
    document.form1.numenv.focus()
    return (false);
                                      }

 if (document.form1.rifemp.value.length==0){
    alert("Debe Ingresar un numero  de R.I.F");
    document.form1.rifemp.focus()
    return (false);
                                      }

 if (document.form1.nomemp.value.length==0){
    alert("Debe Ingresar el nombre de la Ensambladora");
    document.form1.nomemp.focus()
    return (false);
                                      }

 if (document.form1.numregemp.value.length==0){
    alert("Debe Ingresar un numero de Registro de la Empresa");
    document.form1.numregemp.focus()
    return (false);
                                      }

 if (document.form1.fecfincon.value.length==0){
    alert("Debe Ingresar la fecha de fin de convenio");
    document.form1.fecfincon.focus()
    return (false);
                                      }


enviar_funciones('pdftxtpro.php')
}


function campos_reptxtpla(){
 if (document.form1.numlotveh.value.length==0){
    alert("Debe Ingresar un numero de lote");
    document.form1.numlotveh.focus()
    return (false);
                                      }


enviar_funciones('pdftxtpla.php')
}

function campos_reptxtveh(){
if (document.form1.iniemp.value.length==0){
    alert("Debe Ingresar las iniciales de la compañia");
    document.form1.iniemp.focus()
    return (false);
                                      }


 if (document.form1.numenv.value.length==0){
    alert("Debe Ingresar un numero de envio");
    document.form1.numenv.focus()
    return (false);
                                      }


 if (document.form1.nomemp.value.length==0){
    alert("Debe Ingresar el nombre de la Ensambladora");
    document.form1.nomemp.focus()
    return (false);
                                      }

 if (document.form1.numregemp.value.length==0){
    alert("Debe Ingresar un numero de Registro de la Empresa");
    document.form1.numregemp.focus()
    return (false);
                                      }

 if (document.form1.fecfincon.value.length==0){
    alert("Debe Ingresar la fecha de fin de convenio");
    document.form1.fecfincon.focus()
    return (false);
                                      }

 /*if (document.form1.fecdes.value.length==0){
    alert("Debe Ingresar el Rango de fecha completo");
    document.form1.fecdes.focus()
    return (false);
                                      }

 if (document.form1.fechas.value.length==0){
    alert("Debe Ingresar el Rango de fecha completo");
    document.form1.fechas.focus()
    return (false);
                                      }*/

 if (document.form1.numlotveh.value.length==0){
    alert("Debe Ingresar un numero de lote");
    document.form1.numlotveh.focus()
    return (false);
                                      }

  //document.form1.action="funciones.php?opr=aveh";
  // document.form1.submit();

  enviar_funciones('pdftxt.php')

}

function campos_placa(op){

 if (document.form1.sercarveh.value.length!=17){
  alert("Debe Ingresar un serial de carroceria de 17 Caracteres");
  document.form1.sercarveh.focus()
  return (false);
                                         }else
                     {
   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.sercarveh.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.sercarveh.focus()
  return (false);}
                     }



 if (document.form1.plaveh.value.length!=7){
    alert("Debe Ingresar un numero de placa de 7 Caracteres");
    document.form1.plaveh.focus()
    return (false);
                                      }else
                     {
   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.plaveh.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.plaveh.focus()
  return (false);}
                     }
//fecrafveh



 if (document.form1.codestveh.value.length==0){
    alert("Debe Ingresar el codigo del estado ");
    document.form1.codestveh.focus()
    return (false);
                                      }


 if (document.form1.numrafveh.value.length==0){
    alert("Debe Ingresar el numero de la Rafaga ");
    document.form1.numrafveh.focus()
    return (false);
                                      }

 if (document.form1.fecrafveh.value.length==0){
    alert("Debe Ingresar la fecha de la Rafaga ");
    document.form1.fecrafveh.focus()
    return (false);
                                      }

var url = "funciones.php?opr=apla&op="+op;
document.form1.action=url;
document.form1.submit();
}


function campos_vender(op){

 if (document.form1.sercarveh.value.length!=17){
  alert("Debe Ingresar un serial de carroceria de 17 Caracteres");
  document.form1.sercarveh.focus()
  return (false);
                                         }else
                     {
   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.sercarveh.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.sercarveh.focus()
  return (false);}
                     }



 if (document.form1.rif.value.length==0){
    alert("Debe Ingresar un numero de rif ");
    document.form1.rif.focus()
    return (false);
                                      }else
                     {
   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.rif.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.rif.focus()
  return (false);}
                     }

var url = "funciones.php?opr=aven&op="+op;
document.form1.action=url;
document.form1.submit();
}


function campos_factura(){


 if (document.form1.sercarveh.value.length==0){
    alert("Debe Ingresar el serial del vehiculo ");
    document.form1.sercarveh.focus()
    return (false);
                                      }else
                     {
   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.sercarveh.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.sercarveh.focus()
  return (false);}
                     }

var url = "pdffactura.php";
document.form1.action=url;
document.form1.submit();
}


function campos_garantia(){


 if (document.form1.sercarveh.value.length==0){
    alert("Debe Ingresar un vehiculo. ");
    document.form1.sercarveh.focus()
    return (false);
                                      }else
                     {
   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.sercarveh.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.rif.focus()
  return (false);}
                     }

 if (document.form1.fecnac.value.length==0){
    alert("Debe Ingresar una fecha de Nacimiento ");
    document.form1.fecnac.focus()
    return (false);
                                      }

//var url = "pdfgarantiavw.php";

var url = "funciones.php?opr=garantia";
document.form1.action=url;
document.form1.submit();
}


function campos_garantia2(){


 if (document.form1.rif.value.length==0){
    alert("Debe Ingresar un numero de R.I.F. ");
    document.form1.rif.focus()
    return (false);
                                      }

var url = "pdfgarantiavw.php";
document.form1.action=url;
document.form1.submit();
}

function campos_autorizacion(){


 if (document.form1.nombre.value.length==0){
    alert("Debe Ingresar El nombre Completo");
    document.form1.nombre.focus()
    return (false);
                                      }

if (document.form1.cedula.value.length==0){
    alert("Debe Ingresar La Cédula");
    document.form1.cedula.focus()
    return (false);
                                      }

var url = "pdfautorizacion.php";
document.form1.action=url;
document.form1.submit();
}


function Caracteres(campo){
var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.campo.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.campo.focus()
  return (false);}

   function entro(){
     alert('entro!');
   }
}


function campos_certificado(op){

 if (document.form1.sercarveh.value.length==0){
  alert("Debe Ingresar el serial del vehiculo");
  document.form1.sercarveh.focus()
  return (false);
                                         }else
                     {
   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.sercarveh.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.sercarveh.focus()
  return (false);}
                     }


 if (document.form1.inicerveh.value.length!=2){
  alert("Debe Ingresar Las dos iniciales del numero de certificado");
  document.form1.inicerveh.focus()
  return (false);
                                         }


if (document.form1.numcerveh.value.length!=6){
  alert("Debe Ingresar el numero de certificado de origen preimpreso de 6 caracteres");
  document.form1.numcerveh.focus()
  return (false);
                                         }else
                     {
   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.numcerveh.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.numcerveh.focus()
  return (false);}
                     }

 if (document.form1.numfac1veh.value.length==0){
  alert("Debe Ingresar el numero de factura");
  document.form1.numfac1veh.focus()
  return (false);
                                         }

 if (document.form1.fecfac1veh.value.length==0){
  alert("Debe Ingresar La fecha de la factura");
  document.form1.fecfac1veh.focus()
  return (false);
                                         }


var url = "funciones.php?opr=cert&op="+op;
document.form1.action=url;
document.form1.submit();
}



function campos_seguro(){



 if (document.form1.sercarveh.value.length==0){
  alert("Debe Ingresar el serial");
  document.form1.rif.focus()
  return (false);
                                         }


var url = "funciones.php?opr=seguro";
document.form1.action=url;
document.form1.submit();
}

function campos_repbitacora(){


var url = "pdfbitacora.php";
document.form1.action=url;
document.form1.submit();
}


function campos_repPlacasAsignadas(){


var url = "pdfplacasAsignadas.php";
document.form1.action=url;
document.form1.submit();
}

function campos_vehcat(){


var url = "pdfvehiculos.php";
document.form1.action=url;
document.form1.submit();
}


function campos_repvehasignados(){


var url = "pdfvehasignados.php";
document.form1.action=url;
document.form1.submit();
}


function campos_propietarios(){


var url = "pdfpropietarios.php";
document.form1.action=url;
document.form1.submit();
}

function campos_repestatus(){


var url = "pdfvehestatus.php";
document.form1.action=url;
document.form1.submit();
}

function campos_estatus(){

var url = "pdfestatus.php";
document.form1.action=url;
document.form1.submit();
}

function campos_vehestatus(){

var url = "pdfvehestatus.php";
document.form1.action=url;
document.form1.submit();
}

function campos_vehestatuspla(){

var url = "pdfvehestatuspla.php";
document.form1.action=url;
document.form1.submit();
}

function campos_certificadoR(){


var url = "pdfcertificado.php";
document.form1.action=url;
document.form1.submit();
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function campos_vehnacexppvm(){


   if (document.form1.numlotveh.value.length==0){
    alert("Debe Ingresar un N°  de Lote");
    document.form1.numlotveh.focus()
    return (false);
                                           }

  if (document.form1.sercarveh.value.length!=17){
  alert("Debe Ingresar un serial de carroceria de 17 Caracteres");
  document.form1.sercarveh.focus()
  return (false);
                                         }else
                     {
   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.sercarveh.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.sercarveh.focus()
  return (false);}
                     }




 if (document.form1.codmar.value.length==0){
  alert("Debe Ingresar un codigo de marca ");
  document.form1.codmar.focus()
  return (false);
                                         }
                     else
                     {
   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.codmar.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.codmar.focus()
  return (false);}
                     }



  /* var filter = /^[a-z0-9_\-\ \.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.serveh.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.serveh.focus()
  return (false);}
*/

if (document.form1.serveh.value.length > 0){
     var letras_mayusculas="0123456789ABCDEFGHIJKLMNÑOPQRSTUVWXYZ ";
    var texto = document.form1.serveh.value;
    var ind = 1;
    for(i=0; i<texto.length; i++){
      if (letras_mayusculas.indexOf(texto.charAt(i))==-1){
         ind = 0;
         break;
      }
    }
    if(!ind){
      alert('Caracteres no validos en la serie del vehiculo');
      document.form1.serveh.focus();
      return (false);
    }
   // return ind;
 }


if (document.form1.modveh.value.length==0){
  alert("Debe Ingresar un Modelo");
  document.form1.modveh.focus()
  return (false);                         }


var s3 = document.form1.anomodveh.selectedIndex;
var s4= form1.anomodveh.options[s3].text;

  if(s4=="")
  {
   alert("Debe Seleccionar el año del Modelo ");
   return false;
  }



 if (document.form1.sermotveh.value.length==0){
  alert("Debe Ingresar el serial del Motor");
  document.form1.sermotveh.focus()
  return (false);
                                         } else
                     {
   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.sermotveh.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.sermotveh.focus()
  return (false);}
                     }


  if (document.form1.col1veh.value.length!=2){
  alert("Debe Ingresar un Codigo de Color");
  document.form1.col1veh.focus()
  return (false);
                                         } else
                     {
   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.col1veh.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.col1veh.focus()
  return (false);}
                     }


 if (document.form1.pesveh.value.length==0){
  alert("Debe Ingresar el peso del vehiculo");
  document.form1.pesveh.focus()
  return (false);
                                         }

 if (document.form1.tipcapveh.value.length==0){
  alert("Debe Ingresar el tipo de capacidad del vehiculo");
  document.form1.tipcapveh.focus()
  return (false);
                                         }

 if (document.form1.capcarveh.value.length==0){
  alert("Debe Ingresar la capacidad de carga del vehiculo");
  document.form1.capcarveh.focus()
  return (false);
                                         }

 if (document.form1.numejeveh.value.length==0){
  alert("Debe Ingresar el numero de ejes del vehiculo");
  document.form1.numejeveh.focus()
  return (false);
                                         }

 if (document.form1.diarueveh.value.length==0){
  alert("Debe Ingresar el diametro de la rueda del vehiculo");
  document.form1.diarueveh.focus()
  return (false);
                                         }


var s5 = document.form1.anofabveh.selectedIndex;
var s6= form1.anofabveh.options[s5].text;

  if(s6=="")
  {
   alert("Debe Seleccionar el año del Modelo ");
   return false;
  }

 if (document.form1.sernivveh.value.length!=17){
  alert("Debe Ingresar el N° de serial del N.I.V de 17 caracteres");
  document.form1.sernivveh.focus()
  return (false);
                                     } else
                     {
   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.sernivveh.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.sernivveh.focus()
  return (false);}
                     }


 if (document.form1.numpueveh.value.length==0){
    alert("Debe Ingresar el N° de puesto del vehiculo");
    document.form1.numpueveh.focus()
    return (false);
                                            }


   if (document.form1.codconveh.value.length==0){
  alert("Debe Ingresar el tipo de combustible");
  document.form1.codconveh.focus()
  return (false);
                                          }

   if (document.form1.preveh.value.length==0){
  alert("Debe Ingresar el Precio del Vehiculo  utiliza . como separador de decimales ");
  document.form1.preveh.focus()
  return (false);
                                          }else
                     {
   var filter = /^([0-9])*[.]?[0-9]*$/i;
   if (!filter.test(document.form1.preveh.value)) {
   alert('No puedes ingresar Caracates Solo Numero y punto (.) como separador de decimales!');
   document.form1.preveh.focus()
  return (false);}
                     }


 document.form1.action="funciones.php?opr=aveh";
 document.form1.submit();

}




function campos_vehcarrozados(){

   if (document.form1.numlotveh.value.length==0){
    alert("Debe Ingresar un N°  de Lote");
    document.form1.numlotveh.focus()
    return (false);
                                           }

  if (document.form1.sercarveh.value.length!=17){
  alert("Debe Ingresar un serial de carroceria de 18 Caracteres");
  document.form1.sercarveh.focus()
  return (false);
                                         }else
                     {
   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.sercarveh.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.sercarveh.focus()
  return (false);}
                     }



 /*if (document.form1.numregveh.value.length!=7){
    alert("Debe Ingresar un numero de registro de ocho (7) caracteres");
    document.form1.numregveh.focus()
    return (false);
                                            }*/

 if (document.form1.codmar.value.length==0){
  alert("Debe Ingresar un codigo de marca ");
  document.form1.codmar.focus()
  return (false);
                                         }
                     else
                     {
   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.codmar.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.codmar.focus()
  return (false);}
                     }



if (document.form1.modveh.value.length==0){
  alert("Debe Ingresar un Modelo");
  document.form1.modveh.focus()
  return (false);                         }



var s3 = document.form1.anomodveh.selectedIndex;
var s4= form1.anomodveh.options[s3].text;

  if(s4=="")
  {
   alert("Debe Seleccionar el año del Modelo ");
   return false;
  }

  if (document.form1.col1veh.value.length!=2){
  alert("Debe Ingresar un Codigo de Color");
  document.form1.col1veh.focus()
  return (false);
                                         } else
                     {
   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.col1veh.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.col1veh.focus()
  return (false);}
                     }


 if (document.form1.pesveh.value.length==0){
  alert("Debe Ingresar el peso del vehiculo");
  document.form1.pesveh.focus()
  return (false);
                                         }

 if (document.form1.tipcapveh.value.length==0){
  alert("Debe Ingresar el tipo de capacidad del vehiculo");
  document.form1.tipcapveh.focus()
  return (false);
                                         }

 if (document.form1.capcarveh.value.length==0){
  alert("Debe Ingresar la capacidad de carga del vehiculo");
  document.form1.capcarveh.focus()
  return (false);
                                         }

var s5 = document.form1.anofabveh.selectedIndex;
var s6= form1.anofabveh.options[s5].text;

  if(s6=="")
  {
   alert("Debe Seleccionar el año de fabricacion ");
   return false;
  }

   if (document.form1.numfac1veh.value.length==0){
  alert("Debe Ingresar el N° de factura 2");
  document.form1.numfac1veh.focus()
  return (false);
                                          } else
                     {
   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.numfac1veh.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.numfac1veh.focus()
  return (false);}
                     }


   if (document.form1.fecfac1veh.value.length==0){
  alert("Debe Ingresar la fecha de factura");
  document.form1.fecfac1veh.focus()
  return (false);
                                                 }

   if (document.form1.numhomveh.value.length!=15){
  alert("Debe Ingresar el N° Homologacion INTTT de 15 caracteres");
  document.form1.numhomveh.focus()
  return (false);
                                          } else
                     {
   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.numhomveh.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.numhomveh.focus()
  return (false);}
                     }

   if (document.form1.fechomveh.value.length==0){
  alert("Debe Ingresar la fecha de la homologacion INTT");
  document.form1.fechomveh.focus()
  return (false);
                                          }

 if (document.form1.numpueveh.value.length==0){
    alert("Debe Ingresar el N° de puesto del vehiculo");
    document.form1.numpueveh.focus()
    return (false);
                                            }


 document.form1.action="funciones.php?opr=aveh";
 document.form1.submit();

}

function validaFloat(numero)
{
if (!/^([0-9])*[.]?[0-9]*$/.test(numero))
alert("El valor " + numero + " no es un número");
}