function catalogo(campo)
{
pagina=campo;
window.open(pagina,"Catalogo","menubar=no,toolbar=no,scrollbars=yes,width=500,heigth=400,resizable=yes,left=50,top=50");
}
function catalogoAncho(campo)
{
pagina=campo;
window.open(pagina,"Catalogo","menubar=no,toolbar=no,scrollbars=yes,width=1050,heigth=400,resizable=yes,left=50,top=50");
}

function catalogoCla(campo)
{
pagina=campo;
window.open(pagina,"Catalogo","menubar=no,toolbar=no,scrollbars=yes,width=1000,heigth=400,resizable=yes,left=50,top=50");
}
function acessoNumerico(evt){
var nav4 = window.Event ? true : false;
var key = nav4 ? evt.which : evt.keyCode;
return (key <= 13 || (key >= 48 && key <= 57));
}

function acessoDecimal(evt){
var nav4 = window.Event ? true : false;
var key = nav4 ? evt.which : evt.keyCode;
return (key <= 13 || (key >= 48 && key <= 57) || key == 46);
}

function IsNumeric(input) {
   return (input - 0) == input && input.length > 0;
}


//Para validar Extenciones de Archivos
function validaExt(archivo){
	extensiones_permitidas = new Array(".pdf",".doc",".odt");
	extension = (archivo.substring(archivo.lastIndexOf("."))).toLowerCase();
	permitida = false;
	resultado = false;
	if(archivo.length!=''){
      		for (var i = 0; i < extensiones_permitidas.length; i++)
      		{
         		if (extensiones_permitidas[i] == extension)
         		{
         			permitida = true;
         			resultado = false;
         			break;
         		}

      		}
      		if (!permitida)
      		{
         		resultado = true;
         	}
	}
	return (resultado);
	}




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
  }//fin de funcion mascara para las fechas
