function objetoAjax(){
var xmlhttp=false;
try {

xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
} catch (e) {
try {
xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
} catch (E) {
xmlhttp = false;
}

}
if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
  xmlhttp = new XMLHttpRequest();
  }
  return xmlhttp;
  }

////ACTO
function enviarDatosActo(){
  //donde se mostrar� lo resultados

  divResultado = document.getElementById('resultado');
  //valores de los inputs
  nom=document.form1.nomb.value;
  fec=document.form1.fec.value;
  //instanciamos el objetoAjax
  ajax=objetoAjax();
  //uso del medotod POST
  //archivo que realizar� la operacion

  ajax.open("POST","con_cat_acto.php",true);
  ajax.onreadystatechange=function() {
  if (ajax.readyState==4) {
  //mostrar resultados en esta capa
  divResultado.innerHTML = ajax.responseText
  //llamar a funcion para limpiar los inputs
  LimpiarCampos_lote();
  }
  }
  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  //enviando los valores
  ajax.send("nombI="+nom+"&fecI="+fec)
}



function buscarDatosActo(pag){
  //donde se mostrar� lo resultados

  divResultado = document.getElementById('resultado');
  //valores de los inputs
  nom=document.form1.nomb.value;
  fec=document.form1.fec.value;
  //instanciamos el objetoAjax
  ajax=objetoAjax();
  //uso del medotod POST
  //archivo que realizar� la operacion

  ajax.open("POST",pag,true);
  ajax.onreadystatechange=function() {
  if (ajax.readyState==4) {
  //mostrar resultados en esta capa
  divResultado.innerHTML = ajax.responseText
  //llamar a funcion para limpiar los inputs
  //LimpiarCampos_acto();
  }
  }
  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  //enviando los valores
  ajax.send("nomb="+nom+"&fec="+fec);
 }


function LimpiarCampos_acto(){

 document.form1.nomb.value = "";
 document.form1.fec.value = "";
 // document.form1.cod.focus();
}

//FIN ACTO

//banco
function buscarDatosBanco(pag){
  //donde se mostrar� lo resultados

  divResultado = document.getElementById('resultado');
  //valores de los inputs
  nomb=document.form1.nomb.value;
  nume=document.form1.nume.value;
  des=document.form1.des.value;
  //instanciamos el objetoAjax
  ajax=objetoAjax();
  //uso del medotod POST
  //archivo que realizar� la operacion

  ajax.open("POST",pag,true);
  ajax.onreadystatechange=function() {
  if (ajax.readyState==4) {
  //mostrar resultados en esta capa
  divResultado.innerHTML = ajax.responseText
  //llamar a funcion para limpiar los inputs
  //LimpiarCampos_banco();
  }
  }
  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  //enviando los valores
  ajax.send("nomb="+nomb+"&nume="+nume+"&des="+des);
 }

 function enviarDatosBanco(){
  //donde se mostrar� lo resultados
  divResultado = document.getElementById('resultado');
  //valores de los inputs
  nomb=document.form1.nomb.value;
  nume=document.form1.nume.value;
  des=document.form1.des.value;
  //instanciamos el objetoAjax
  ajax=objetoAjax();
  //uso del medotod POST
  //archivo que realizar� la operacion
  ajax.open("POST","con_cat_banco.php",true);
  ajax.onreadystatechange=function() {
  if (ajax.readyState==4) {
  //mostrar resultados en esta capa
  divResultado.innerHTML = ajax.responseText
  //llamar a funcion para limpiar los inputs
  //LimpiarCampos_banco();
  }
  }

  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  //enviando los valores
   ajax.send("nomb="+nomb+"&nume="+nume+"&des="+des+"&env=1");
}

function LimpiarCampos_banco(){

 document.form1.nomb.value = "";
 document.form1.nume.value = "";
 document.form1.des.value = "";
 // document.form1.cod.focus();
}
//fin banco


// DEPARTAMENTO
function buscarDatosDpto(pag){
  //donde se mostrar� lo resultados

  divResultado = document.getElementById('resultado');
  //valores de los inputs

  descdep=document.form1.descdep.value;

  //instanciamos el objetoAjax
  ajax=objetoAjax();
  //uso del medotod POST
  //archivo que realizar� la operacion

  ajax.open("POST",pag,true);
  ajax.onreadystatechange=function() {
  if (ajax.readyState==4) {
  //mostrar resultados en esta capa
  divResultado.innerHTML = ajax.responseText
  //llamar a funcion para limpiar los inputs
  //LimpiarCampos_Departamento();
  }
  }
  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  //enviando los valores
  ajax.send("&descdep="+descdep);
 }

 function enviarDatosDpto(){
  //donde se mostrar� lo resultados
  divResultado = document.getElementById('resultado');
  //valores de los inputs
  descdep=document.form1.descdep.value;
  //instanciamos el objetoAjax
  ajax=objetoAjax();
  //uso del medotod POST
  //archivo que realizar� la operacion
  ajax.open("POST","con_cat_dep.php",true);
  ajax.onreadystatechange=function() {
  if (ajax.readyState==4) {
  //mostrar resultados en esta capa
  divResultado.innerHTML = ajax.responseText
  //llamar a funcion para limpiar los inputs
  //LimpiarCampos_Departamento();
  }
  }

  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  //enviando los valores
   ajax.send("&descdep="+descdep+"&env=1");
}

function LimpiarCampos_Departamento(){

 document.form1.descdep.value = "";
 // document.form1.cod.focus();
}
//fin Departamento

// ESTATUS

   function buscarDatosEstatus(pag){
  //donde se mostrar� lo resultados

  divResultado = document.getElementById('resultado');
  //valores de los inputs
  descripcion=document.form1.descripcion.value;
  orden=document.form1.orden.value;

  //instanciamos el objetoAjax
  ajax=objetoAjax();
  //uso del medotod POST
  //archivo que realizar� la operacion

  ajax.open("POST",pag,true);
  ajax.onreadystatechange=function() {
  if (ajax.readyState==4) {
  //mostrar resultados en esta capa
  divResultado.innerHTML = ajax.responseText
  //llamar a funcion para limpiar los inputs
  //LimpiarCampos_Estatus();
  }
  }
  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  //enviando los valores
  ajax.send("&descripcion="+descripcion+"&orden="+orden);
 }

 function enviarDatosEstatus(){
  //donde se mostrar� lo resultados
  divResultado = document.getElementById('resultado');
  //valores de los inputs
  descripcion=document.form1.descripcion.value;
  orden=document.form1.orden.value;

  //instanciamos el objetoAjax
  ajax=objetoAjax();
  //uso del medotod POST
  //archivo que realizar� la operacion
  ajax.open("POST","con_cat_estatus.php",true);
  ajax.onreadystatechange=function() {
  if (ajax.readyState==4) {
  //mostrar resultados en esta capa
  divResultado.innerHTML = ajax.responseText
  //llamar a funcion para limpiar los inputs
  //LimpiarCampos_Estatus();
  }
  }

  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  //enviando los valores
   ajax.send("&descripcion="+descripcion+"&orden="+orden+"&env=1");
}

function LimpiarCampos_Estatus(){

 document.form1.descripcion.value = "";
 document.form1.orden.value = "";

}
//fin Estatus


////CLASES
function enviarDatosClases(){
  //donde se mostrar� lo resultados
  divResultado = document.getElementById('resultado');
  //valores de los inputs
  cod=document.form1.cod.value;
  nom=document.form1.nomb.value;
  //instanciamos el objetoAjax
  ajax=objetoAjax();
  //uso del medotod POST
  //archivo que realizar� la operacion


  ajax.open("POST","funciones.php?opr=ac",true);
  ajax.onreadystatechange=function() {
  if (ajax.readyState==4) {
  //mostrar resultados en esta capa
  divResultado.innerHTML = ajax.responseText
  //llamar a funcion para limpiar los inputs
  LimpiarCampos_clases();
  }
  }
  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  //enviando los valores
  ajax.send("cod="+cod+"&nomb="+nom)
  }



function buscarDatosClases(pag){
  //donde se mostrar� lo resultados

  divResultado = document.getElementById('resultado');
  //valores de los inputs
  cod=document.form1.cod.value;
  nomb=document.form1.nomb.value;

  //instanciamos el objetoAjax
  ajax=objetoAjax();
  //uso del medotod POST
  //archivo que realizar� la operacion

  ajax.open("POST",pag,true);
  ajax.onreadystatechange=function() {
  if (ajax.readyState==4) {
  //mostrar resultados en esta capa
  divResultado.innerHTML = ajax.responseText
  //llamar a funcion para limpiar los inputs
  //LimpiarCampos_clases();
  }
  }
  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  //enviando los valores
  ajax.send("cod="+cod+"&nomb="+nomb)
  }


function LimpiarCampos_clases(){
 document.form1.cod.value  = "";
 document.form1.nomb.value = "";
 // document.form1.cod.focus();
}

//FIN CLASES

////COLOR
function enviarDatosColor(){
  //donde se mostrar� lo resultados

  divResultado = document.getElementById('resultado');
  //valores de los inputs
  cod=document.form1.cod.value;
  nom=document.form1.nomb.value;
  //instanciamos el objetoAjax
  ajax=objetoAjax();
  //uso del medotod POST
  //archivo que realizar� la operacion


  ajax.open("POST","con_cat_color.php",true);
  ajax.onreadystatechange=function() {
  if (ajax.readyState==4) {
  //mostrar resultados en esta capa
  divResultado.innerHTML = ajax.responseText
  //llamar a funcion para limpiar los inputs
  LimpiarCampos_color();
  }
  }
  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  //enviando los valores
  ajax.send("codI="+cod+"&nombI="+nom)
  }


  //getYear()
function buscarDatosColor(pag){
  //donde se mostrar� lo resultados

  divResultado = document.getElementById('resultado');
  //valores de los inputs
  cod=document.form1.cod.value;
  nom=document.form1.nomb.value;
  //instanciamos el objetoAjax
  ajax=objetoAjax();
  //uso del medotod POST
  //archivo que realizar� la operacion


  ajax.open("POST",pag,true);
  ajax.onreadystatechange=function() {
  if (ajax.readyState==4) {
  //mostrar resultados en esta capa
  divResultado.innerHTML = ajax.responseText
  //llamar a funcion para limpiar los inputs
  //LimpiarCampos_color();
  }
  }
  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  //enviando los valores
  ajax.send("cod="+cod+"&nomb="+nom)
  }


function LimpiarCampos_color(){
 document.form1.cod.value  = "";
 document.form1.nomb.value = "";
 // document.form1.cod.focus();
}

//FIN COLOR

////COMBUSTIBLE
function enviarDatosCombustible(){
  //donde se mostrar� lo resultados

  divResultado = document.getElementById('resultado');
  //valores de los inputs
  cod=document.form1.cod.value;
  nom=document.form1.nomb.value;
  //instanciamos el objetoAjax
  ajax=objetoAjax();
  //uso del medotod POST
  //archivo que realizar� la operacion


  ajax.open("POST","con_cat_combustible.php",true);
  ajax.onreadystatechange=function() {
  if (ajax.readyState==4) {
  //mostrar resultados en esta capa
  divResultado.innerHTML = ajax.responseText
  //llamar a funcion para limpiar los inputs
  LimpiarCampos_combustible();
  }
  }
  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  //enviando los valores
  ajax.send("codI="+cod+"&nomI="+nom)
  }


function buscarDatosCombustible(pag){
  //donde se mostrar� lo resultados

  divResultado = document.getElementById('resultado');
  //valores de los inputs
  cod=document.form1.cod.value;
  nom=document.form1.nomb.value;

  //instanciamos el objetoAjax
  ajax=objetoAjax();
  //uso del medotod POST
  //archivo que realizar� la operacion

  ajax.open("POST",pag,true);
  ajax.onreadystatechange=function() {
  if (ajax.readyState==4) {
  //mostrar resultados en esta capa
  divResultado.innerHTML = ajax.responseText
  //llamar a funcion para limpiar los inputs
  //LimpiarCampos_combustible();
  }
  }
  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  //enviando los valores
  ajax.send("cod="+cod+"&nom="+nom)
  }

function LimpiarCampos_combustible(){
 document.form1.cod.value  = "";
 document.form1.nomb.value = "";
 // document.form1.cod.focus();
}

//FIN COMBUSTIBLE

////USO
function enviarDatosUso(){
  //donde se mostrar� lo resultados

  divResultado = document.getElementById('resultado');
  //valores de los inputs
  cod=document.form1.cod.value;
  nom=document.form1.nomb.value;
  //instanciamos el objetoAjax
  ajax=objetoAjax();
  //uso del medotod POST
  //archivo que realizar� la operacion


  ajax.open("POST","funciones.php?opr=au",true);
  ajax.onreadystatechange=function() {
  if (ajax.readyState==4) {
  //mostrar resultados en esta capa
  divResultado.innerHTML = ajax.responseText
  //llamar a funcion para limpiar los inputs
  LimpiarCampos_uso();
  }
  }
  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  //enviando los valores
  ajax.send("cod="+cod+"&nomb="+nom)
  }


function buscarDatosUso(pag){
  //donde se mostrar� lo resultados

  divResultado = document.getElementById('resultado');
  //valores de los inputs
  cod=document.form1.cod.value;
  nomb=document.form1.nomb.value;

  //instanciamos el objetoAjax
  ajax=objetoAjax();
  //uso del medotod POST
  //archivo que realizar� la operacion

  ajax.open("POST",pag,true);
  ajax.onreadystatechange=function() {
  if (ajax.readyState==4) {
  //mostrar resultados en esta capa
  divResultado.innerHTML = ajax.responseText
  //llamar a funcion para limpiar los inputs
  //LimpiarCampos_combustible();
  }
  }
  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  //enviando los valores
  ajax.send("cod="+cod+"&nomb="+nomb)
  }


function LimpiarCampos_uso(){
 document.form1.cod.value  = "";
 document.form1.nomb.value = "";
 // document.form1.cod.focus();
}

//FIN USO


////ESTADO
function enviarDatosEstado(){
  //donde se mostrar� lo resultados

  divResultado = document.getElementById('resultado');
  //valores de los inputs
  cod=document.form1.cod.value;
  nom=document.form1.nomb.value;
  //instanciamos el objetoAjax
  ajax=objetoAjax();
  //uso del medotod POST
  //archivo que realizar� la operacion


  ajax.open("POST","funciones.php?opr=aest",true);
  ajax.onreadystatechange=function() {
  if (ajax.readyState==4) {
  //mostrar resultados en esta capa
  divResultado.innerHTML = ajax.responseText
  //llamar a funcion para limpiar los inputs
  LimpiarCampos_estado();
  }
  }
  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  //enviando los valores
  ajax.send("cod="+cod+"&nomb="+nom)
  }



function buscarDatosEstado(pag){
  //donde se mostrar� lo resultados

  divResultado = document.getElementById('resultado');
  //valores de los inputs
  cod=document.form1.cod.value;
  nom=document.form1.nomb.value;
  //instanciamos el objetoAjax
  ajax=objetoAjax();
  //uso del medotod POST
  //archivo que realizar� la operacion


  ajax.open("POST",pag,true);
  ajax.onreadystatechange=function() {
  if (ajax.readyState==4) {
  //mostrar resultados en esta capa
  divResultado.innerHTML = ajax.responseText
  //llamar a funcion para limpiar los inputs
  LimpiarCampos_estado();
  }
  }
  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  //enviando los valores
  ajax.send("cod="+cod+"&nomb="+nom)
  }


function LimpiarCampos_estado(){
 document.form1.cod.value  = "";
 document.form1.nomb.value = "";
 // document.form1.cod.focus();
}

//FIN ESTADO



////MARCA
function enviarDatosMarca(){
  //donde se mostrar� lo resultados

  divResultado = document.getElementById('resultado');
  //valores de los inputs
  cod=document.form1.cod.value;
  nom=document.form1.nomb.value;
  //instanciamos el objetoAjax
  ajax=objetoAjax();
  //uso del medotod POST
  //archivo que realizar� la operacion


  ajax.open("POST","con_marca2.php",true);
  ajax.onreadystatechange=function() {
  if (ajax.readyState==4) {
  //mostrar resultados en esta capa
  divResultado.innerHTML = ajax.responseText
  //llamar a funcion para limpiar los inputs
  LimpiarCampos_marca();
  }
  }
  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  //enviando los valores
  ajax.send("codI="+cod+"&nombI="+nom)
  }



function buscarDatosMarca(pag){
  //donde se mostrar� lo resultados

  divResultado = document.getElementById('resultado');
  //valores de los inputs
  cod=document.form1.cod.value;
  nom=document.form1.nomb.value;
  //instanciamos el objetoAjax
  ajax=objetoAjax();
  //uso del medotod POST
  //archivo que realizar� la operacion

  ajax.open("POST",pag,true);
  ajax.onreadystatechange=function() {
  if (ajax.readyState==4) {
  //mostrar resultados en esta capa
  divResultado.innerHTML = ajax.responseText
  //llamar a funcion para limpiar los inputs
  //LimpiarCampos_marca();
  }
  }
  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  //enviando los valores
  ajax.send("cod="+cod+"&nomb="+nom)
  }
function LimpiarCampos_marca(){
 document.form1.cod.value  = "";
 document.form1.nomb.value = "";
 // document.form1.cod.focus();
}

//FIN MARCA


////SERVICIOS
function enviarDatosServicios(){
  //donde se mostrar� lo resultados

  divResultado = document.getElementById('resultado');
  //valores de los inputs
  cod=document.form1.cod.value;
  nom=document.form1.nomb.value;
  //instanciamos el objetoAjax
  ajax=objetoAjax();
  //uso del medotod POST
  //archivo que realizar� la operacion


  ajax.open("POST","con_cat_servicios.php",true);
  ajax.onreadystatechange=function() {
  if (ajax.readyState==4) {
  //mostrar resultados en esta capa
  divResultado.innerHTML = ajax.responseText
  //llamar a funcion para limpiar los inputs
  LimpiarCampos_servicios();
  }
  }
  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  //enviando los valores
  ajax.send("codI="+cod+"&nombI="+nom)
  }


  function buscarDatosServicios(pag){
  //donde se mostrar� lo resultados

  divResultado = document.getElementById('resultado');
  //valores de los inputs
  cod=document.form1.cod.value;
  nomb=document.form1.nomb.value;

  //instanciamos el objetoAjax
  ajax=objetoAjax();
  //uso del medotod POST
  //archivo que realizar� la operacion

  ajax.open("POST",pag,true);
  ajax.onreadystatechange=function() {
  if (ajax.readyState==4) {
  //mostrar resultados en esta capa
  divResultado.innerHTML = ajax.responseText
  //llamar a funcion para limpiar los inputs
  //LimpiarCampos_combustible();
  }
  }
  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  //enviando los valores
  ajax.send("cod="+cod+"&nomb="+nomb)
  }


function LimpiarCampos_servicios(){
 document.form1.cod.value  = "";
 document.form1.nomb.value = "";
 // document.form1.cod.focus();
}

//FIN SERVICIOS

////TIPOS
function enviarDatosTipos(){
  //donde se mostrar� lo resultados

  divResultado = document.getElementById('resultado');
  //valores de los inputs
  cod=document.form1.cod.value;
  nom=document.form1.nomb.value;
  //instanciamos el objetoAjax
  ajax=objetoAjax();
  //uso del medotod POST
  //archivo que realizar� la operacion


  ajax.open("POST","con_cat_tipos.php",true);
  ajax.onreadystatechange=function() {
  if (ajax.readyState==4) {
  //mostrar resultados en esta capa
  divResultado.innerHTML = ajax.responseText
  //llamar a funcion para limpiar los inputs
  LimpiarCampos_tipos();
  }
  }
  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  //enviando los valores
  ajax.send("codI="+cod+"&nombI="+nom)
  }



function buscarDatosTipos(pag){
  //donde se mostrar� lo resultados

  divResultado = document.getElementById('resultado');
  //valores de los inputs
  cod=document.form1.cod.value;
  nomb=document.form1.nomb.value;

  //instanciamos el objetoAjax
  ajax=objetoAjax();
  //uso del medotod POST
  //archivo que realizar� la operacion

  ajax.open("POST",pag,true);
  ajax.onreadystatechange=function() {
  if (ajax.readyState==4) {
  //mostrar resultados en esta capa
  divResultado.innerHTML = ajax.responseText
  //llamar a funcion para limpiar los inputs
  //LimpiarCampos_tipos();
  }
  }
  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  //enviando los valores
  ajax.send("cod="+cod+"&nomb="+nomb)
  }


function LimpiarCampos_tipos(){
 document.form1.cod.value  = "";
 document.form1.nomb.value = "";
 // document.form1.cod.focus();
}

//FIN TIPOS

////EMPRESA
function enviarDatosEmpresa(){
  //donde se mostrar� lo resultados

  divResultado = document.getElementById('resultado');
  //valores de los inputs
  cod=document.form1.cod.value;
  nom=document.form1.nomb.value;
  reg=document.form1.reg.value;
  //instanciamos el objetoAjax
  ajax=objetoAjax();
  //uso del medotod POST
  //archivo que realizar� la operacion

  ajax.open("POST","funciones.php?opr=aemp",true);
  ajax.onreadystatechange=function() {
  if (ajax.readyState==4) {
  //mostrar resultados en esta capa
  divResultado.innerHTML = ajax.responseText
  //llamar a funcion para limpiar los inputs
  LimpiarCampos_empresa();
  }
  }
  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  //enviando los valores
  ajax.send("cod="+cod+"&nomb="+nom+"&reg="+reg)
  }



function buscarDatosEmpresa(pag){
  //donde se mostrar� lo resultados

  divResultado = document.getElementById('resultado');
  //valores de los inputs
  cod=document.form1.cod.value;
  nom=document.form1.nomb.value;
  reg=document.form1.reg.value;
  //instanciamos el objetoAjax
  ajax=objetoAjax();
  //uso del medotod POST
  //archivo que realizar� la operacion

  ajax.open("POST",pag,true);
  ajax.onreadystatechange=function() {
  if (ajax.readyState==4) {
  //mostrar resultados en esta capa
  divResultado.innerHTML = ajax.responseText
  //llamar a funcion para limpiar los inputs
  LimpiarCampos_empresa();
  }
  }
  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  //enviando los valores
  ajax.send("cod="+cod+"&nomb="+nom+"&reg="+reg)
  }

  function buscarDatosEmpresa2(pag){
  //donde se mostrar� lo resultados

  divResultado = document.getElementById('resultado');
  //valores de los inputs
  nom=document.form1.nomb.value;
  reg=document.form1.reg.value;
  //instanciamos el objetoAjax
  ajax=objetoAjax();
  //uso del medotod POST
  //archivo que realizar� la operacion

  ajax.open("POST",pag,true);
  ajax.onreadystatechange=function() {
  if (ajax.readyState==4) {
  //mostrar resultados en esta capa
  divResultado.innerHTML = ajax.responseText
  //llamar a funcion para limpiar los inputs
  LimpiarCampos_empresa2();
  }
  }
  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  //enviando los valores
  ajax.send("nomb="+nom+"&reg="+reg)
  }


function LimpiarCampos_empresa2(){

 document.form1.nomb.value = "";
 document.form1.reg.value = "";

}

function LimpiarCampos_empresa(){
 document.form1.cod.value  = "";
 document.form1.nomb.value = "";
 document.form1.reg.value = "";
 // document.form1.cod.focus();
}

//FIN EMPRESA
//ENSAMBLADORA
function enviarDatosEnsambladora(){
  //donde se mostrar� lo resultados
  divResultado = document.getElementById('resultado');
  //valores de los inputs
  cod=document.form1.cod.value;
  nom=document.form1.nomb.value;
  dig=document.form1.dig.value;
  num=document.form1.num.value;
  //instanciamos el objetoAjax
  ajax=objetoAjax();
  //uso del medotod POST
  //archivo que realizar� la operacion


  ajax.open("POST","funciones.php?opr=aens",true);
  ajax.onreadystatechange=function() {
  if (ajax.readyState==4) {
  //mostrar resultados en esta capa
  divResultado.innerHTML = ajax.responseText
  //llamar a funcion para limpiar los inputs
  LimpiarCampos_ensambladora();
  }
  }
  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  //enviando los valores
  ajax.send("cod="+cod+"&nomb="+nom+"&num="+num+"&dig="+dig)
  }

function buscarDatosEnsambladora(){
  //donde se mostrar� lo resultados
  divResultado = document.getElementById('resultado');
  //valores de los inputs
  cod=document.form1.cod.value;
  nom=document.form1.nomb.value;
  dig=document.form1.dig.value;
  num=document.form1.num.value;
  //instanciamos el objetoAjax
  ajax=objetoAjax();
  //uso del medotod POST
  //archivo que realizar� la operacion


  ajax.open("POST","con_ensambladora.php?opc=1",true);;
  ajax.onreadystatechange=function() {
  if (ajax.readyState==4) {
  //mostrar resultados en esta capa
  divResultado.innerHTML = ajax.responseText
  //llamar a funcion para limpiar los inputs
  LimpiarCampos_ensambladora();
  }
  }
  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  //enviando los valores
  ajax.send("cod="+cod+"&nomb="+nom+"&num="+num+"&dig="+dig)
  }


function buscarDatosEnsambladora2(pag){
  //donde se mostrar� lo resultados
  divResultado = document.getElementById('resultado');
  //valores de los inputs
  cod=document.form1.cod.value;
  nom=document.form1.nomb.value;
  //instanciamos el objetoAjax
  ajax=objetoAjax();
  //uso del medotod POST
  //archivo que realizar� la operacion


  ajax.open("POST",pag,true);;
  ajax.onreadystatechange=function() {
  if (ajax.readyState==4) {
  //mostrar resultados en esta capa
  divResultado.innerHTML = ajax.responseText
  //llamar a funcion para limpiar los inputs
  LimpiarCampos_ensambladora();
  }
  }
  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  //enviando los valores
  ajax.send("cod="+cod+"&nom="+nom)
  }

  function LimpiarCampos_ensambladora(){
 document.form1.cod.value  = "";
 document.form1.nomb.value = "";
 document.form1.num.value = "";
 document.form1.dig.value = "";
 // document.form1.cod.focus();
}
//fin ensambladora
////LOTE
function enviarDatosLote(){
  //donde se mostrar� lo resultados

  divResultado = document.getElementById('resultado');
  //valores de los inputs
  nom=document.form1.nomb.value;
  fec=document.form1.fec.value;
  dept=document.form1.dep.value;
  //instanciamos el objetoAjax
  ajax=objetoAjax();
  //uso del medotod POST
  //archivo que realizar� la operacion

  ajax.open("POST","con_cat_lot.php",true);
  ajax.onreadystatechange=function() {
  if (ajax.readyState==4) {
  //mostrar resultados en esta capa
  divResultado.innerHTML = ajax.responseText
  //llamar a funcion para limpiar los inputs
  LimpiarCampos_lote();
  }
  }
  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  //enviando los valores
  ajax.send("nombI="+nom+"&fecI="+fec+"&dptoI="+dept)
}



function buscarDatosLote(pag){
  //donde se mostrar� lo resultados

  divResultado = document.getElementById('resultado');
  //valores de los inputs
  nom=document.form1.nomb.value;
  fec=document.form1.fec.value;
  dept=document.form1.dep.value;
  //instanciamos el objetoAjax
  ajax=objetoAjax();
  //uso del medotod POST
  //archivo que realizar� la operacion

  ajax.open("POST",pag,true);
  ajax.onreadystatechange=function() {
  if (ajax.readyState==4) {
  //mostrar resultados en esta capa
  divResultado.innerHTML = ajax.responseText
  //llamar a funcion para limpiar los inputs
  //LimpiarCampos_lote();
  }
  }
  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  //enviando los valores
  ajax.send("nomb="+nom+"&fec="+fec+"&dpto="+dept)
  //alert('Nombre '+nom+' Fecha '+fec+' Dpto '+dept);
 }


function LimpiarCampos_lote(){

 document.form1.nomb.value = "";
 document.form1.fec.value = "";
 document.form1.dep.value = "";
 // document.form1.cod.focus();
}

//FIN LOTE

////MODELO
function enviarDatosModelo(){
  //donde se mostrar� lo resultados

  divResultado = document.getElementById('resultado');
  //valores de los inputs
  cod=document.form1.cod.value;
  des=document.form1.des.value;

  //instanciamos el objetoAjax
  ajax=objetoAjax();
  //uso del medotod POST
  //archivo que realizar� la operacion

  //ajax.open("POST","funciones.php?opr=amod",true);
  ajax.open("POST","con_cat_mod.php",true);
  ajax.onreadystatechange=function() {
  if (ajax.readyState==4) {
  //mostrar resultados en esta capa
  divResultado.innerHTML = ajax.responseText
  //llamar a funcion para limpiar los inputs
  LimpiarCampos_modelo();
  }
  }
  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  //enviando los valores
  ajax.send("codI="+cod+"&desI="+des)
}



function buscarDatosModelo(pag){
  //donde se mostrar� lo resultados

  divResultado = document.getElementById('resultado');
  //valores de los inputs
  cod=document.form1.cod.value;
  des=document.form1.des.value;

  //instanciamos el objetoAjax
  ajax=objetoAjax();
  //uso del medotod POST
  //archivo que realizar� la operacion

  ajax.open("POST",pag,true);
  ajax.onreadystatechange=function() {
  if (ajax.readyState==4) {
  //mostrar resultados en esta capa
  divResultado.innerHTML = ajax.responseText
  //llamar a funcion para limpiar los inputs
  //LimpiarCampos_modelo();
  }
  }
  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  //enviando los valores
  ajax.send("cod="+cod+"&des="+des)
  }


function LimpiarCampos_modelo(){
 document.form1.cod.value  = "";
 document.form1.des.value = "";

}

//FIN MODELO

////SERIE
function enviarDatosSerie(){
  //donde se mostrar� lo resultados

  divResultado = document.getElementById('resultado');
  //valores de los inputs
  cod=document.form1.cod.value;
  des=document.form1.des.value;

  //instanciamos el objetoAjax
  ajax=objetoAjax();
  //uso del medotod POST
  //archivo que realizar� la operacion

  //ajax.open("POST","funciones.php?opr=amod",true);
  ajax.open("POST","con_cat_serie.php",true);
  ajax.onreadystatechange=function() {
  if (ajax.readyState==4) {
  //mostrar resultados en esta capa
  divResultado.innerHTML = ajax.responseText
  //llamar a funcion para limpiar los inputs
  LimpiarCampos_serie();
  }
  }
  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  //enviando los valores
  ajax.send("codI="+cod+"&desI="+des)
}



function buscarDatosSerie(pag){
  //donde se mostrar� lo resultados

  divResultado = document.getElementById('resultado');
  //valores de los inputs
  cod=document.form1.cod.value;
  des=document.form1.des.value;

  //instanciamos el objetoAjax
  ajax=objetoAjax();
  //uso del medotod POST
  //archivo que realizar� la operacion

  ajax.open("POST",pag,true);
  ajax.onreadystatechange=function() {
  if (ajax.readyState==4) {
  //mostrar resultados en esta capa
  divResultado.innerHTML = ajax.responseText
  //llamar a funcion para limpiar los inputs
  //LimpiarCampos_serie();
  }
  }
  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  //enviando los valores
  ajax.send("cod="+cod+"&des="+des)
  }


function LimpiarCampos_serie(){
 document.form1.cod.value  = "";
 document.form1.des.value = "";

}
//FIN SERIE

////PTO
function enviarDatosPto(){
  //donde se mostrar� lo resultados

  divResultado = document.getElementById('resultado');
  //valores de los inputs
  cod=document.form1.cod.value;
  nom=document.form1.nomb.value;
  //instanciamos el objetoAjax
  ajax=objetoAjax();
  //uso del medotod POST
  //archivo que realizar� la operacion


  ajax.open("POST","funciones.php?opr=apto",true);
  ajax.onreadystatechange=function() {
  if (ajax.readyState==4) {
  //mostrar resultados en esta capa
  divResultado.innerHTML = ajax.responseText
  //llamar a funcion para limpiar los inputs
  LimpiarCampos_pto();
  }
  }
  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  //enviando los valores
  ajax.send("cod="+cod+"&nomb="+nom)
  }



function buscarDatosPto(pag){
  //donde se mostrar� lo resultados

  divResultado = document.getElementById('resultado');
  //valores de los inputs
  cod=document.form1.cod.value;
  nomb=document.form1.nomb.value;

  //instanciamos el objetoAjax
  ajax=objetoAjax();
  //uso del medotod POST
  //archivo que realizar� la operacion

  ajax.open("POST",pag,true);
  ajax.onreadystatechange=function() {
  if (ajax.readyState==4) {
  //mostrar resultados en esta capa
  divResultado.innerHTML = ajax.responseText
  //llamar a funcion para limpiar los inputs
  //LimpiarCampos_tipos();
  }
  }
  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  //enviando los valores
  ajax.send("cod="+cod+"&nomb="+nomb)
}


function buscarDatosPropietario(pag){
  //donde se mostrar� lo resultados

  divResultado = document.getElementById('resultado');
  //valores de los inputs
  cod=document.form1.cod.value;
  nom=document.form1.nomb.value;
  //instanciamos el objetoAjax
  ajax=objetoAjax();
  //uso del medotod POST
  //archivo que realizar� la operacion


  ajax.open("POST",pag,true);
  ajax.onreadystatechange=function() {
  if (ajax.readyState==4) {
  //mostrar resultados en esta capa
  divResultado.innerHTML = ajax.responseText
  //llamar a funcion para limpiar los inputs
  LimpiarCamposPropietario();
  }
  }
  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  //enviando los valores
  ajax.send("cod="+cod+"&nomb="+nom)
  }


function LimpiarCampos_pto(){
 document.form1.cod.value  = "";
 document.form1.nomb.value = "";
 // document.form1.cod.focus();
}

//FIN PTO


////Propietario
function LimpiarCamposPropietario(){
//  nac=document.form1.nac.value;
  document.form1.numrif.value = "";
  document.form1.digrif.value= "";
  document.form1.nom1.value= "";
  document.form1.ape1.value= "";
  document.form1.nom2.value= "";
  document.form1.ape2.value= "";
  document.form1.nomorg.value= "";
  document.form1.calle.value = "";
  document.form1.urb.value= "";
  document.form1.casa.value= "";
  document.form1.piso.value= "";
  document.form1.apart.value= "";
  document.form1.dist.value= "";
  document.form1.codtlf1.value= "";
  document.form1.tlf1.value= "";
  document.form1.codtlf2.value= "";
  document.form1.tlf2.value= "";
  document.form1.cod.value= "";

  }
  //aqui


function buscarDatosVeh(pag){
  //donde se mostrar� lo resultados

  divResultado = document.getElementById('resultado');
  //valores de los inputs
  sercarveh=document.form1.sercarveh.value;
  sermotveh=document.form1.sermotveh.value;
  //instanciamos el objetoAjax
  ajax=objetoAjax();
  //uso del medotod POST
  //archivo que realizar� la operacion


  ajax.open("POST",pag,true);
  ajax.onreadystatechange=function() {
  if (ajax.readyState==4) {
  //mostrar resultados en esta capa
  divResultado.innerHTML = ajax.responseText
  //llamar a funcion para limpiar los inputs
  LimpiarCampos_veh();
  }
  }
  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  //enviando los valores
  ajax.send("sercarveh="+sercarveh+"&sermotveh="+sermotveh)
  }

function buscarDatosVeh12(pag){
  //donde se mostrar� lo resultados

  divResultado = document.getElementById('resultado');
  //valores de los inputs
  sercarveh=document.form1.sercarveh.value;
  cod=document.form1.cod.value;
  nomb=document.form1.nomb.value;
  //instanciamos el objetoAjax
  ajax=objetoAjax();
  //uso del medotod POST
  //archivo que realizar� la operacion


  ajax.open("POST",pag,true);
  ajax.onreadystatechange=function() {
  if (ajax.readyState==4) {
  //mostrar resultados en esta capa
  divResultado.innerHTML = ajax.responseText
  //llamar a funcion para limpiar los inputs
  LimpiarCampos_veh();
  }
  }
  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  //enviando los valores
  ajax.send("sercarveh="+sercarveh+"&cod="+cod+"&nomb="+nomb)
  }




function buscarDatosClasificacion(pag){
  //donde se mostrar� lo resultados

  divResultado = document.getElementById('resultado');
  //valores de los inputs
    desser=document.form1.desser.value;
	despla=document.form1.despla.value;
	descat=document.form1.descat.value;
	descla=document.form1.descla.value;
	destip=document.form1.destip.value;
	desuso=document.form1.desuso.value;
  //instanciamos el objetoAjax
  ajax=objetoAjax();
  //uso del medotod POST
  //archivo que realizar� la operacion


  ajax.open("POST",pag,true);
  ajax.onreadystatechange=function() {
  if (ajax.readyState==4) {
  //mostrar resultados en esta capa
  divResultado.innerHTML = ajax.responseText
  //llamar a funcion para limpiar los inputs
  //LimpiarCampos_clasificacion();
  }
  }
  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  //enviando los valores
  ajax.send("desser="+desser+"&despla="+despla+"&descat="+descat+"&descla="+descla+"&destip="+destip+"&desuso="+desuso)
  }

  function LimpiarCampos_clasificacion(){
	document.form1.desser.value  = "";
	document.form1.despla.value = "";
	document.form1.descat.value  = "";
	document.form1.descla.value = "";
	document.form1.destip.value  = "";
	document.form1.desuso.value = "";
 // document.form1.cod.focus();
}

/*
    desser=document.form1.desser.value;
	despla=document.form1.despla.value;
	descat=document.form1.descat.value;
	descla=document.form1.descla.value;
	desstip=document.form1.destip.value;
	desuso=document.form1.desuso.value;*/

function LimpiarCampos_veh(){
 document.form1.sercarveh.value  = "";
 document.form1.sermotveh.value = "";
 // document.form1.cod.focus();
}


////TALLER
function enviarDatosTaller(){
  //donde se mostrar� lo resultados

  divResultado = document.getElementById('resultado');
  //valores de los inputs
  rif=document.form1.rif.value;
  nom=document.form1.nomb.value;
  dir=document.form1.dir.value;
  con=document.form1.contac.value;
  tel=document.form1.telf.value;
  //instanciamos el objetoAjax
  ajax=objetoAjax();
  //uso del medotod POST
  //archivo que realizar� la operacion

  ajax.open("POST","con_cat_taller.php",true);
  ajax.onreadystatechange=function() {
  if (ajax.readyState==4) {
  //mostrar resultados en esta capa
  divResultado.innerHTML = ajax.responseText
  //llamar a funcion para limpiar los inputs
  LimpiarCampos_taller();
  }
  }
  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  //enviando los valores
  ajax.send("rifI="+rif+"&nombI="+nom+"&dirI="+dir+"&conI="+con+"&telfI="+tel)
}



function buscarDatosTaller(pag){
  //donde se mostrar� lo resultados

  divResultado = document.getElementById('resultado');
  //valores de los inputs
  rif=document.form1.rif.value;
  nom=document.form1.nomb.value;
  dir=document.form1.dir.value;
  con=document.form1.contac.value;
  tel=document.form1.telf.value;
  //instanciamos el objetoAjax
  ajax=objetoAjax();
  //uso del medotod POST
  //archivo que realizar� la operacion

  ajax.open("POST",pag,true);
  ajax.onreadystatechange=function() {
  if (ajax.readyState==4) {
  //mostrar resultados en esta capa
  divResultado.innerHTML = ajax.responseText
  //llamar a funcion para limpiar los inputs
  //LimpiarCampos_taller();
  }
  }
  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  //enviando los valores
  ajax.send("rif="+rif+"&nomb="+nom+"&dir="+dir+"&con="+con+"&telf="+tel)
 }


function LimpiarCampos_taller(){
  document.form1.rif.value = "";
  document.form1.nomb.value = "";
  document.form1.dir.value = "";
  document.form1.contac.value = "";
}

//FIN TALLER




function link (pag,form1){
form1.action=pag;
form1.submit();
}


function mensaje_modificar (pag){
alert ("los datos han sido modificados");
location.href=pag;
}