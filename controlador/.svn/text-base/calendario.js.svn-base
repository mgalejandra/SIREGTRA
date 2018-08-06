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
  var Ruta = "imagenes";
  var str_buffer = new String (
    "<html>\n"+
    "<head>\n"+
    "	<title>Calendar</title>\n"+
    "</head>\n"+
    "<body bgcolor=\"White\">\n"+
    "<table class=\"clsOTable\" cellspacing=\"0\" border=\"0\" width=\"100%\">\n"+
    "<tr><td bgcolor=\"#941616\">\n"+
    "<table cellspacing=\"1\" cellpadding=\"3\" border=\"0\" width=\"100%\">\n"+
    "<tr>\n	<td bgcolor=\"#941616\"><a href=\"javascript:window.opener.show_calendar('"+
    str_target+"', '"+ dt2dtstr(dt_prev_month)+"'+document.cal.time.value);\">"+
    "<img src=\"" +Ruta+ "/prev1.gif\"  width=\"16\" height=\"16\" border=\"0\""+
    " alt=\"previous month\"></a></td>\n"+
    "	<td bgcolor=\"#941616\" colspan=\"5\">"+
    "<font color=\"white\" face=\"tahoma, verdana\" size=\"2\">"
    +arr_months[dt_datetime.getMonth()]+" "+dt_datetime.getFullYear()+"</font></td>\n"+
    "	<td bgcolor=\"#941616\" align=\"right\"><a href=\"javascript:window.opener.show_calendar('"
    +str_target+"', '"+dt2dtstr(dt_next_month)+"'+document.cal.time.value);\">"+
    "<img src=\"" +Ruta+ "/next1.gif\" width=\"16\" height=\"16\" border=\"0\""+
    " alt=\"next month\"></a></td>\n</tr>\n"
  );

  var dt_current_day = new Date(dt_firstday);
  // print weekdays titles
  str_buffer += "<tr>\n";
  for (var n=0; n<7; n++)
    str_buffer += "	<td bgcolor=\"#cacdd0\">"+
    "<font color=\"black\" face=\"tahoma, verdana\" size=\"2\">"+
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
          str_buffer += "	<td bgcolor=\"#d09999\" align=\"right\">";
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
    "<form name=\"cal\">\n<tr><td colspan=\"7\" bgcolor=\"#8d0303\">"+
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