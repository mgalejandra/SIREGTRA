<?php
class estados extends conexion{
function buscarEdo($cod,$des){
  $sql = "select * FROM estado ";


  	if (($cod) and ($des))
  	{
  		$sql.="WHERE codest like '%$cod%' and desest like '%$des%' ";
  	}
  	else
  	{
  		if (($cod) and (!$des))
  		{
  			$sql.="WHERE codest like '%$cod%' ";
  		}
  		else
  		if ((!$cod) and ($des))
  		{
  			$sql.="WHERE desest like '%$des%' ";
  		}
  	}

  $sql.= " order by desest";

  //print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $desest= $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $desest;
 }

 public function Regiones(){
 	 $sql = "SELECT
 	 			(id||'-'||reg_nombre) AS reg_nombre
 	 		FROM
 	 			regiones reg";

 	 $conexion = $this->conectar2();
  	 $consulta = $this->consultar($conexion,$sql);
  	 $regiones = $this->ret_vector($consulta);
  	 $this->desconectar($conexion);
     return $regiones;
 }

 function EstadosRegiones($reg_id = null){
 	//echo $reg_id; die();
 	$sql = "SELECT
 	 			(codest||'-'||nomest) AS est_nombre
 	 		FROM
 	 			zona_estado
 	 		WHERE
 	 			reg_id = $reg_id";

 	 $conexion = $this->conectar2();
  	 $consulta = $this->consultar($conexion, $sql);
  	 $estado = $this->ret_vector($consulta);
  	 $this->desconectar($conexion);
     return $estado;
 }

 function CantidadSolicitudesBeneficiariosWeb($reg_id = null){
	//echo $reg_id; die();
 	$sql = "SELECT
					COUNT(*) AS cantidad_web,
					(SELECT
							COUNT(*) AS regiones_web
						FROM
							ususolcit citas,
							repbenefsol solicitante,
							regiones region,
							zona_estado estado
						WHERE
							citas.codpro = solicitante.codpro
							AND solicitante.codest = estado.codest
							AND estado.reg_id = reg.id
							AND citas.asiste = 'S'
							AND region.id = reg.id) AS atendidas,
					(SELECT
							COUNT(*) AS regiones_web
						FROM
							ususolcit citas,
							repbenefsol solicitante,
							regiones region,
							zona_estado estado
						WHERE
							citas.codpro = solicitante.codpro
							AND solicitante.codest = estado.codest
							AND estado.reg_id = reg.id
							AND citas.asiste = 'A'
							AND region.id = reg.id) AS pendientes,
						(SELECT
							COUNT(*) AS regiones_web
						FROM
							ususolcit citas,
							repbenefsol solicitante,
							regiones region,
							zona_estado estado
						WHERE
							citas.codpro = solicitante.codpro
							AND solicitante.codest = estado.codest
							AND estado.reg_id = reg.id
							AND citas.asiste = 'V'
							AND region.id = reg.id) AS noasistieron,
						(SELECT
							COUNT(*) AS regiones_web
						FROM
							repbenefsol solicitante,
							regiones region,
							zona_estado estado
						WHERE
							solicitante.codest = estado.codest
							AND estado.reg_id = reg.id
							AND region.id = reg.id
							AND solicitante.codpro NOT IN (SELECT codpro FROM ususolcit)) AS sincita
				FROM
					ususolcit citas,
					repbenefsol solicitante,
					regiones reg,
					zona_estado estado
				WHERE
					citas.codpro 		   = solicitante.codpro
					AND solicitante.codest = estado.codest
					AND estado.reg_id 	   = reg.id
					AND reg.id = ".$reg_id."
				GROUP BY
					reg.id";

	 $conexion = $this->conectar2();
  	 $consulta = $this->consultar($conexion,$sql);
  	 $web 	   = $this->ret_vector($consulta);
  	 $this->desconectar($conexion);
     return $web;

 }
function CantSolicitudesBeneficiariosWeb($reg_id = null){
	//echo $reg_id; die();
 	$sql = "SELECT
					COUNT(*) AS regiones_web
					FROM
						ususolcit citas,
						repbenefsol solicitante,
						regiones reg,
						zona_estado estado
					WHERE
						citas.codpro 		   = solicitante.codpro
						AND solicitante.codest = estado.codest
						AND estado.reg_id 	   = reg.id
					AND reg.id = $reg_id";

	 $conexion = $this->conectar2();
  	 $consulta = $this->consultar($conexion,$sql);
  	 $web 	   = $this->ret_vector($consulta);
  	 $this->desconectar($conexion);
     return $web;

 }

function CantSolicitudesBeneficiariosWebEstados($cod_id = null){
	//echo $reg_id; die();
 	$sql = "
 	SELECT
	 	nomest AS estado,
		COUNT(*) AS estado_web,
		(SELECT
				COUNT(*)
			FROM
				repbenefsol sol,
				ususolcit cit
			WHERE
				sol.codpro = cit.codpro
				AND cit.asiste = 'S'
				AND sol.codest = estado.codest) AS atendidas,
	(SELECT
				COUNT(*)
			FROM
				repbenefsol sol,
				ususolcit cit
			WHERE
				sol.codpro = cit.codpro
				AND cit.asiste = 'A'
				AND sol.codest = estado.codest) AS pendientes,
	(SELECT
				COUNT(*)
			FROM
				repbenefsol sol,
				ususolcit cit
			WHERE
				sol.codpro = cit.codpro
				AND cit.asiste = 'V'
				AND sol.codest = estado.codest) AS noasistieron,
	(SELECT
				COUNT(*)
			FROM
				repbenefsol sol
			WHERE
				sol.codest = estado.codest
				AND sol.codpro NOT IN (SELECT codpro FROM ususolcit)) AS sincita
	FROM
		ususolcit citas,
		repbenefsol solicitante,
		zona_estado estado
	WHERE
		citas.codpro 	       = solicitante.codpro
		AND solicitante.codest = estado.codest
		AND estado.codest = '".$cod_id."'
	GROUP BY
		estado.codest,
		estado.nomest";

	 $conexion = $this->conectar2();
  	 $consulta = $this->consultar($conexion,$sql);
  	 $web 	   = $this->ret_vector($consulta);
  	 $this->desconectar($conexion);
     return $web;

 }
 function TotalCitas(){
 	$sql = "SELECT ((SELECT
    				COUNT(*) AS regiones_web
                    FROM
                        ususolcit citas,
                        repbenefsol solicitante,
                        regiones reg,
                        zona_estado estado
                    WHERE
                        citas.codpro            = solicitante.codpro
                        AND solicitante.codest = estado.codest
                        AND estado.reg_id        = reg.id
                   )+
                    (SELECT
                            COUNT(*) AS regiones_web
                        FROM
                            repbenefsol solicitante,
                            regiones region,
                            zona_estado estado
                        WHERE
                            solicitante.codest = estado.codest
                            AND estado.reg_id = region.id
                            AND solicitante.codpro NOT IN (SELECT codpro FROM ususolcit))+
                       (SELECT
    				COUNT(*) AS regiones_web
                    FROM
                        ususolcit citas,
                        repbenefsol solicitante
                    WHERE
                        citas.codpro            = solicitante.codpro
                        AND solicitante.codest = '0'
			  )+
		 (SELECT
                COUNT(*)
            FROM
                repbenefsol sol
            WHERE
                sol.codest = '0'
                AND sol.codpro NOT IN (SELECT codpro FROM ususolcit))) AS totalcitas";

 	 $conexion = $this->conectar2();
  	 $consulta = $this->consultar($conexion,$sql);
  	 $web 	   = $this->ret_vector($consulta);
  	 $this->desconectar($conexion);
     return $web;
 }

 function CantidadesCitasxEstado(){
 	$sql = "
( SELECT
         reg_nombre,
         nomest AS estado,
         COUNT(*) AS estado_web,
        (SELECT
                COUNT(*)
            FROM
                repbenefsol sol,
                ususolcit cit
            WHERE
                sol.codpro = cit.codpro
                AND cit.asiste = 'S' and sol.status='A'
                AND sol.codest = estado.codest) AS atendidas,
    (SELECT
                COUNT(*)
            FROM
                repbenefsol sol,
                ususolcit cit
            WHERE
                sol.codpro = cit.codpro and sol.status='A'
                AND cit.asiste = 'A' and cit.asiste <> 'E'
                AND sol.codest = estado.codest) AS pendientes,
    (SELECT
                COUNT(*)
            FROM
                repbenefsol sol,
                ususolcit cit
            WHERE
                sol.codpro = cit.codpro
                AND cit.asiste = 'V' and sol.status='A'
                AND sol.codest = estado.codest) AS noasistieron,
    (SELECT
                COUNT(*)
            FROM
                repbenefsol sol
            WHERE
                sol.codest = estado.codest and sol.status='A'
                AND sol.codpro NOT IN (SELECT codpro FROM ususolcit)) AS sincita, id
    FROM
        ususolcit citas,
        repbenefsol solicitante,
        zona_estado estado,
        regiones regiones
    WHERE
        citas.codpro            = solicitante.codpro and  citas.asiste <> 'E' and solicitante.status='A'
        AND solicitante.codest = estado.codest and regiones.id=estado.reg_id
    GROUP BY
        estado.codest,
        estado.nomest, id,
        reg_nombre
        order by id)
       UNION ALL (
        select  'SIN REGION' as sinreg, 'SIN ESTADO' as sinest, (
    SELECT
        count(*)
    FROM
        repbenefsol sol,
        ususolcit cit
    WHERE
        cit.codpro = sol.codpro and cit.asiste <> 'E' and sol.status='A'
        AND sol.codest = '0') AS otorgadas,
     (SELECT
        count(*)
    FROM
        repbenefsol sol,
        ususolcit cit
    WHERE
        cit.codpro = sol.codpro
        AND cit.asiste = 'S' and sol.status='A'
        AND sol.codest = '0') AS atendidas,
    (SELECT
        count(*)
    FROM
        repbenefsol sol,
        ususolcit cit
    WHERE
        cit.codpro = sol.codpro and sol.status='A'
        AND cit.asiste = 'A' and cit.asiste <> 'E'
        AND sol.codest = '0') AS pendientes,
    (SELECT
        count(*)
    FROM
        repbenefsol sol,
        ususolcit cit
    WHERE
        cit.codpro = sol.codpro and sol.status='A'
        AND cit.asiste = 'V' and  cit.asiste <> 'E'
        AND sol.codest = '0') AS diferencia,
    (SELECT
                COUNT(*)
            FROM
                repbenefsol sol
            WHERE
                sol.codest = '0' and sol.status='A'
                AND sol.codpro NOT IN (SELECT codpro FROM ususolcit where asiste <> 'E')) AS sincita, 0 as sinid)";

 	 $conexion = $this->conectar2();
  	 $consulta = $this->consultar($conexion, $sql);
  	 $web 	   = $this->ret_vector($consulta);
  	 $this->desconectar($conexion);
     return $web;
 }


 function TotalCitasxEstado(){
 	$sql = "select x.id, x.reg_nombre,
sum(x.estado_web) as estado_web,
sum(x.atendidas) as atendidas,
sum(x.pendientes) as pendientes,
sum(x.noasistieron) as noasistieron,
sum(x.sincita) as sincita
from (
( SELECT
         reg_nombre,
         nomest AS estado,
         COUNT(*) AS estado_web,
        (SELECT
                COUNT(*)
            FROM
                repbenefsol sol,
                ususolcit cit
            WHERE
                sol.codpro = cit.codpro
                AND cit.asiste = 'S' and sol.status='A'
                AND sol.codest = estado.codest) AS atendidas,
    (SELECT
                COUNT(*)
            FROM
                repbenefsol sol,
                ususolcit cit
            WHERE
                sol.codpro = cit.codpro and sol.status='A'
                AND cit.asiste = 'A' and cit.asiste <> 'E'
                AND sol.codest = estado.codest) AS pendientes,
    (SELECT
                COUNT(*)
            FROM
                repbenefsol sol,
                ususolcit cit
            WHERE
                sol.codpro = cit.codpro
                AND cit.asiste = 'V' and sol.status='A'
                AND sol.codest = estado.codest) AS noasistieron,
    (SELECT
                COUNT(*)
            FROM
                repbenefsol sol
            WHERE
                sol.codest = estado.codest and sol.status='A'
                AND sol.codpro NOT IN (SELECT codpro FROM ususolcit)) AS sincita, id

    FROM
        ususolcit citas,
        repbenefsol solicitante,
        zona_estado estado,
        regiones regiones
    WHERE
        citas.codpro            = solicitante.codpro AND citas.asiste <> 'E' and solicitante.status='A'
        AND solicitante.codest = estado.codest and regiones.id=estado.reg_id
    GROUP BY
        estado.codest,
        estado.nomest,
        reg_nombre, id
        order by reg_nombre)
       UNION ALL (
        select 'SIN REGION' as sinreg, 'SIN ESTADO' as sinest, (
    SELECT
        count(*)
    FROM
        repbenefsol sol,
        ususolcit cit
    WHERE
        cit.codpro = sol.codpro and cit.asiste <> 'E' and sol.status='A'
        AND sol.codest = '0') AS otorgadas,
     (SELECT
        count(*)
    FROM
        repbenefsol sol,
        ususolcit cit
    WHERE
        cit.codpro = sol.codpro
        AND cit.asiste = 'S' and sol.status='A'
        AND sol.codest = '0') AS atendidas,
    (SELECT
        count(*)
    FROM
        repbenefsol sol,
        ususolcit cit
    WHERE
        cit.codpro = sol.codpro and sol.status='A'
        AND cit.asiste = 'A' and cit.asiste <> 'E'
        AND sol.codest = '0') AS pendientes,
    (SELECT
        count(*)
    FROM
        repbenefsol sol,
        ususolcit cit
    WHERE
        cit.codpro = sol.codpro and sol.status='A'
        AND cit.asiste = 'V' and  cit.asiste <> 'E'
        AND sol.codest = '0') AS diferencia,
    (SELECT
                COUNT(*)
            FROM
                repbenefsol sol
            WHERE
                sol.codest = '0' and sol.status='A'
                AND sol.codpro NOT IN (SELECT codpro FROM ususolcit where asiste <> 'E')) AS sincita, 0 as sinid) ) x

                GROUP BY x.id, x.reg_nombre order by x.id desc
";
//echo '<pre>'.$sql;

 	 $conexion = $this->conectar2();
  	 $consulta = $this->consultar($conexion, $sql);
  	 $web 	   = $this->ret_vector($consulta);
  	 $this->desconectar($conexion);
     return $web;
 }
 /* function buscarServicioID($id){

  $sql = "select desmar from marcas where '".$id."' ";
  //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $desmar= $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $desmar[0];
 }*/

}
?>