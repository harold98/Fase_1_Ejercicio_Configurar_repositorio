<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?
session_start();
if ($_SESSION['inter_user'])
	echo "";

else{

	echo ("DEBES LOGEARTE !!")	?><script>
				window.location='../index.php';
				</script>
	<?}
	
	$user=$_SESSION['inter_user'];
	include("../datos/datos.php");
?>

<head>
<title>:::...Gesti&oacute;n de Transportes...:::</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link rel="stylesheet" type="text/css" href="../sortable/example.css"/>
	<meta name="author" content="Joost de Valk, http://www.joostdevalk.nl/" />
	<link href="http://www.joostdevalk.nl/" rev="made" />
	<script type="text/javascript" src="../sortable/sortable.js"></script>
	
	<link type='text/css' href='../calendario/css/ui-lightness/jquery-ui-1.7.2.custom.css' rel='stylesheet' />	
	<script type='text/javascript' src='../calendario/js/jquery-1.3.2.min.js'></script>
	<script type='text/javascript' src='../calendario/js/jquery-ui-1.7.2.custom.min.js'></script>
<script>
function confirmar(url)
{
	if(confirm('Est\u00E1s seguro de cancelar esta solicitud?'))
	{
		window.location=("../solicitudes/delelsol.php<?php echo"?id={$articulo['id_solicitud']}";?>");
		
	}
	else
	{
		return false;
	}
}	
</script> 
	
	</head>
	
<body topmargin=0  link="#ffffff" alink="#ffffff" vlink="#ffffff"> 
<font face="Verdana">
<?

 include ('../datos/validaciones.php');
?>

<div id="miga" style="width: 100%;font-family: Arial, Helvetica, sans-serif;font-size: 11px;color: #8A0808;">
						<table width="1000" align="center">
						<tr>
						<td>
						<p> Est&aacute;s en 
						<a href='../solicitudes/solicitudes.php'style='color:#8A0808;'>Inicio</a>>
						<b>Solicitudes</b></p>
						</td>
						</tr>
						</table>
</div>		
<div id="titulos"style="font-family: Arial, Helvetica, sans-serif;font-size: 18px;color: #8A0808;">
	<table width="1000" align="center">
	<tr>
	<td>
	<b>Solicitudes</b>
	</font>
	</td>
	</tr>
	</table>
</div>
<?php
include("../datos/datos.php");
	//Parametros de busqueda
	$codigo=$_REQUEST['codigo'];
	$estado=$_REQUEST['estado'];
	$fechade=$_REQUEST['fechade'];
	$fechaha=$_REQUEST['fechaha'];	
	$origen=$_REQUEST['origen'];
	$destino=$_REQUEST['destino'];
	$prioridad=$_REQUEST['prioridad'];
	$centro=$_REQUEST['centro'];
	$conexion=mysql_connect("$server","$usuario","$pswd")  
	  or  die("Problemas en la conexion");
	mysql_select_db("$db",$conexion) 
	or  die("Problemas en la selección de la base de datos");
	$registros=mysql_query("SELECT id_solicitud,fecha_registro,id_estado,user_solicita,prioridad,
	fecha_limite_ent,centro_costos,origen,destino,direccion_origen,direccion_destino,persona_entrega,
	persona_recibe,tel_entrega,tel_destino,email_entrega,email_destino,
	(SELECT nombre from tbl_estadoSol E WHERE E.idestados='$estado') AS nomestado,
	(SELECT nombre from tbl_prioridadSol P WHERE P.idprioridad='$prioridad') AS nomprioridad,
	(SELECT nombre from tbl_sitios S WHERE S.idsitio='$origen') AS norigen,
	(SELECT nombre from tbl_sitios S WHERE S.idsitio= '$destino') AS ndestino,
	(SELECT nombre from tbl_cenCostos T WHERE T.idcentro= '$centro') AS ncentro
	FROM tbl_solicitudes WHERE 1 limit 0,30",$conexion)
	or die("Problemas en el select:".mysql_error()); 
	while ($reg=mysql_fetch_array($registros)) 
	{
		$nomestado=$reg['nomestado'];
		$nprioridad=$reg['nomprioridad'];
		$norigen=$reg['norigen'];
		$ndestino=$reg['ndestino'];
		$nocentro=$reg['ncentro'];
	}
	mysql_close($conexion);


?>	
	<br>
	<div id="tabla" style="width: 100%;font-family: Arial, Helvetica, sans-serif;font-size: 13px;color: #8A0808;font-weight: bold;align: center;">

	<style type="text/css">
	.redo
	{
		border-radius: 5px; 
		-moz-border-radius: 5px; 
		-o-border-radius: 5px; 
		-webkit-border-radius: 5px;
		border: 1px;
		border-style: solid;
		border-color:#7C7C7C;
		font-family:verdana;
		font-size:10pt; 
		color: #421C5E;
	}
	</style>
	<FORM NAME="formulario" METHOD="post" onSubmit="return validar(this)">	
	<table width="900" align="center" style="background-image: url(../images/bgtabla.jpeg);border-radius: 5px; -moz-border-radius: 5px; -o-border-radius: 5px;-webkit-border-radius: 5px;">
		<tr height='20'>
		</tr>
		<tr>
		<td width="35" >
				
			</td>
			<td>
				C&oacute;digo de la Solicitud
			</td>
			<td>
				<input type="text" name="codigo" maxlength="20" style="width:200px" value="<?echo $codigo;?>" class='redo'>
			</td>
			<td>
				Estado
			</td>
			<td>
				<?
				if($estado!="")
				{
					include("../datos/conexion.php");
							$sentencia="SELECT idestados,nombre FROM  tbl_estadoSol  WHERE idestados!='$estado' ORDER BY nombre ASC";
							$res=mysql_query($sentencia) or die("Error en la consulta");
							$numeroRegistros=mysql_num_rows($res); 
							
				echo"<select name='estado' style='width:200px' class='redo'>
							<option value=''>Seleccione el Estado</option>
							<option value='$estado' selected>$nomestado</option>";
							while($datos=mysql_fetch_array($res))
							{
						?>
							<option value="<? echo $datos[0]; ?>"><? echo utf8_decode($datos[1]); ?></option>
							<?php
							}
							echo"</select>";
							mysql_close($Conexion);
				}
				else
				{
					include("../datos/conexion.php");
							$sentencia="SELECT idestados,nombre FROM  tbl_estadoSol ORDER BY nombre ASC";
							$res=mysql_query($sentencia) or die("Error en la consulta");
							$numeroRegistros=mysql_num_rows($res); 
						echo"<select name='estado' style='width:200px' class='redo'>
							<option value=''>Seleccione el Estado</option>";
							while($datos=mysql_fetch_array($res))
							{
						?>
							<option value="<? echo $datos[0]; ?>"><? echo utf8_decode($datos[1]); ?></option>
							<?php
							}
							echo"</select>";
							mysql_close($Conexion);
				}
				?>
			</td>
			
			<td width="35" >
				
			</td>
		</tr>
		<tr>
		<td width="35" >
				
			</td>
			<td>
			<?
			echo"
				<script type='text/javascript'>";
			echo"	$(function() {
					$('#datepicker').datepicker({ dateFormat: 'yy-mm-dd' });
				})";
			echo"</script>";
			?>
				Fecha Desde
			</td>
			<td>
				<input type='date' name="fechade" size="10" class='redo' maxlength="10" value="<?echo $fechade;?>">
			</td>
			<td>
			<?
			echo"
				<script type='text/javascript'>";
			echo"	$(function() {
					$('#datepicker2').datepicker({ dateFormat: 'yy-mm-dd' });
				})";
			echo"</script>";
			?>
				Fecha Hasta
			</td>
			<td>
				<input type='date' name="fechaha"  size="10" class='redo' maxlength="10" value="<?echo $fechaha;?>">
			<!--id="datepicker2"-->
			</td>
		</tr>
		<tr>
			<td width="35" >
				
			</td>
			<td>
				Origen
			</td>
			<td>
				<?
				if($origen!="")
				{
					include("../datos/conexion.php");
							$sentencia="SELECT idsitio,nombre FROM  tbl_sitios WHERE idsitio!='$origen' ORDER BY nombre ASC";
							$res=mysql_query($sentencia) or die("Error en la consulta");
							$numeroRegistros=mysql_num_rows($res); 
							
				echo"<select name='origen' style='width:200px' class='redo'>
							<option value=''>Seleccione el Origen</option>
							<option value='$origen' selected>$norigen</option>";
							while($datos=mysql_fetch_array($res))
							{
						?>
							<option value="<? echo $datos[0]; ?>"><? echo utf8_decode($datos[1]); ?></option>
							<?php
							}
							echo"</select>";
							mysql_close($Conexion);
				}
				else
				{
					include("../datos/conexion.php");
							$sentencia="SELECT idsitio,nombre FROM  tbl_sitios ORDER BY nombre ASC";
							$res=mysql_query($sentencia) or die("Error en la consulta");
							$numeroRegistros=mysql_num_rows($res); 
						echo"<select name='origen' style='width:200px' class='redo'>
							<option value=''>Seleccione el Origen</option>";
							while($datos=mysql_fetch_array($res))
							{
						?>
							<option value="<? echo $datos[0]; ?>"><? echo utf8_decode($datos[1]); ?></option>
							<?php
							}
							echo"</select>";
							mysql_close($Conexion);
				}
				?>
			</td>
			<td>
				Destino
			</td>
			<td>
				<?
				if($destino!="")
				{
					include("../datos/conexion.php");
							$sentencia="SELECT idsitio, nombre FROM  tbl_sitios WHERE idsitio!='$destino' ORDER BY nombre ASC";
							$res=mysql_query($sentencia) or die("Error en la consulta");
							$numeroRegistros=mysql_num_rows($res); 
							
				echo"<select name='destino' style='width:200px' class='redo'>
							<option value=''>Seleccione el Destino</option>
							<option value='$destino' selected>$ndestino</option>";
							while($datos=mysql_fetch_array($res))
							{
						?>
							<option value="<? echo $datos[0]; ?>"><? echo utf8_decode($datos[1]); ?></option>
							<?php
							}
							echo"</select>";
							mysql_close($Conexion);
				}
				else
				{
					include("../datos/conexion.php");
							$sentencia="SELECT idsitio,nombre FROM  tbl_sitios ORDER BY nombre ASC";
							$res=mysql_query($sentencia) or die("Error en la consulta");
							$numeroRegistros=mysql_num_rows($res); 
						echo"<select name='destino' style='width:200px' class='redo'>
							<option value=''>Seleccione el Destino</option>";
							while($datos=mysql_fetch_array($res))
							{
						?>
							<option value="<? echo $datos[0]; ?>"><? echo utf8_decode($datos[1]); ?></option>
							<?php
							}
							echo"</select>";
							mysql_close($Conexion);
				}
				?>
			</td>
		</tr>
		<tr>
			<td width="35" >
				
			</td>
			<td>
				Prioridad
			</td>
			<td>
				<?
				if($prioridad!="")
				{
					include("../datos/conexion.php");
							$sentencia="SELECT idprioridad,nombre FROM  tbl_prioridadSol WHERE idprioridad!='$prioridad' ORDER BY nombre ASC";
							$res=mysql_query($sentencia) or die("Error en la consulta");
							$numeroRegistros=mysql_num_rows($res); 
							
				echo"<select name='prioridad' style='width:200px' class='redo'>
							<option value=''>Seleccione la Prioridad</option>
							<option value='$prioridad' selected>$nprioridad</option>";
							while($datos=mysql_fetch_array($res))
							{
						?>
							<option value="<? echo $datos[0]; ?>"><? echo $datos[1]; ?></option>
							<?php
							}
							echo"</select>";
							mysql_close($Conexion);
				}
				else
				{
					include("../datos/conexion.php");
							$sentencia="SELECT idprioridad,nombre FROM  tbl_prioridadSol ORDER BY nombre ASC";
							$res=mysql_query($sentencia) or die("Error en la consulta");
							$numeroRegistros=mysql_num_rows($res); 
						echo"<select name='prioridad' style='width:200px' class='redo'>
							<option value=''>Seleccione la Prioridad</option>";
							while($datos=mysql_fetch_array($res))
							{
						?>
							<option value="<? echo $datos[0]; ?>"><? echo $datos[1]; ?></option>
							<?php
							}
							echo"</select>";
							mysql_close($Conexion);
				}
				?>
			</td>
			<td>
				Centro de Costos
			</td>
			<td>
				<?
				if($centro!="")
				{
					include("../datos/conexion.php");
							$sentencia="SELECT idcentro,nombre FROM  tbl_cenCostos WHERE idcentro!='$centro' ORDER BY nombre ASC";
							$res=mysql_query($sentencia) or die("Error en la consulta");
							$numeroRegistros=mysql_num_rows($res); 
							
				echo"<select name='centro' style='width:200px' class='redo'>
							<option value=''>Seleccione el C. Costos</option>
							<option value='$centro' selected>$nocentro</option>";
							while($datos=mysql_fetch_array($res))
							{
						?>
							<option value="<? echo $datos[0]; ?>"><? echo utf8_decode($datos[1]); ?></option>
							<?php
							}
							echo"</select>";
							mysql_close($Conexion);
				}
				else
				{
					include("../datos/conexion.php");
							$sentencia="SELECT idcentro,nombre FROM  tbl_cenCostos ORDER BY nombre ASC";
							$res=mysql_query($sentencia) or die("Error en la consulta");
							$numeroRegistros=mysql_num_rows($res); 
						echo"<select name='centro' style='width:200px' class='redo'>
							<option value=''>Seleccione el C. Costos</option>";
							while($datos=mysql_fetch_array($res))
							{
						?>
							<option value="<? echo $datos[0]; ?>"><? echo utf8_decode($datos[1]); ?></option>
							<?php
							}
							echo"</select>";
							mysql_close($Conexion);
				}
				?>
			</td>
			<td width="35" >
				
			</td>
		</tr>
	<tr>
	 <td height='50'colspan='4' align='center'>
	 </td>
	  <td height='50' align='center'>
	  <center>
	  <input type="submit" value="Buscar" name="buscar" style="
		font-family: 'verdana';
		font-size: 15px;
		font-weight: bold;
		color: #FFFFFF;
		display: block;
		height: 23px;
		width: 94px;
		margin-left: 130px;
		text-align: center;
		background-image: url(../images/boton_g.png);
		text-decoration: none;
		padding-left: 4px;
		text-shadow: 1px 1px 1px #9b9b9b;
		border-top-width: 0px;
		border-right-width: 0px;
		border-bottom-width: 0px;
		border-left-width: 0px;
		border-top-style: none;
		border-right-style: none;
		border-bottom-style: none;
		border-left-style: none;
		background-color: transparent;
		cursor:pointer;
		float: left;">
	  &nbsp;&nbsp;</center>
	 </td>
	 
	 </tr>
	</table>
	</div>
	
<?	
function conectar() 
{ 
	
   include("../datos/datos.php");
	if (!($link = mysql_connect("$server", "$usuario","$pswd"))) 
	{ 
		echo "Error conectando a la base de datos."; 
		exit(); 
	} 
	if (!mysql_select_db($db, $link)) 
	{ 
		echo "Error seleccionando la base de datos."; 
		exit(); 
	} 
	return $link; 
} 

$db = conectar();


$registros = 10;

if (!$pagina) { 
    $inicio = 0; 
    $pagina = 1; 
} 
else 
{ 
    $inicio = ($pagina - 1) * $registros; 
} 
//echo "perfiill $perfil";
//Perfil de Administrador
if($perfil=="1")
{
	$consultausu="where (C.id_solicitud>0)";
}
//Perfil de Almacenista Aprobado
else if($perfil=="2")
{
	$consultausu="where ((C.enviada='1') or (C.enviada=0 and C.user_solicita='$user'))";
}
//Perfil de Consulta
else if($perfil=="3")
{
	$consultausu="where (C.enviada='1')";
}
//Perfil de Registro
else if(($perfil=="4")or($perfil=="")or($perfil=="0"))
{
	$consultausu="where (C.user_solicita='$user')";
}
//Perfil de Consulta y Registro
elseif($perfil=="5")
{
	$consultausu="where (C.enviada='1' or user_solicita='$user')";
}

 	
	//Consultas generales
	if($codigo=="" and $estado=="" and $fechade=="" and $fechaha=="" and $origen=="" and $destino=="" and $prioridad=="" and $centro=="")
	{
		$nada="limit 0,30";
	}
	else
	{
		$nada="";
	}
	//Consulta Por numero de documento del contratista
	if($codigo!="")
	{
		$consulta1="and id_solicitud like '%$codigo%'";
	}
	else
	{
		$consulta1="";
	}	
//Consulta por estado
	if($estado=="")
	{
		$consulta2="";
	}
	if($estado!="")
	{
		$consulta2="and id_estado='$estado'";
	}
//Consulta por rango de fechas
	if($fechade=="")
	{
		$consulta3="";
	}
	if($fechade!="")
	{
		$consulta3="and DATE(fecha_envio) between '$fechade' and '$fechaha'";
	}
//Consulta por ciudad de origen
	if($origen=="")
	{
		$consulta4="";
	}
	if($origen!="")
	{
		$consulta4="and origen='$origen'";
	}
//Consulta por ciudad de destino
	if($destino=="")
	{
		$consulta5="";
	}
	if($destino!="")
	{
		$consulta5="and destino='$destino'";
	}
//Consulta por prioridad
	if($prioridad=="")
	{
		$consulta6="";
	}
	if($prioridad!="")
	{
		$consulta6="and prioridad='$prioridad'";
	}
//Consulta por centro de costos
	if($centro=="")
	{
		$consulta7="";
	}
	if($centro!="")
	{
		$consulta7="and centro_costos='$centro'";
	}
	
	
	
	$resultados = mysql_query("SELECT id_solicitud,fecha_registro,fecha_envio,id_estado,user_solicita,prioridad,
	fecha_limite_ent,centro_costos,origen,destino,direccion_origen,direccion_destino,persona_entrega,
	persona_recibe,tel_entrega,tel_destino,email_entrega,email_destino,enviada,
	(SELECT nombre_apellido from tbl_usuarios U WHERE U.usuario= C.user_solicita) AS autor,
	(SELECT nombre from tbl_estadoSol E WHERE E.idestados= C.id_estado) AS nomestado,
	(SELECT nombre from tbl_prioridadSol P WHERE P.idprioridad= C.prioridad) AS nomprioridad,
	(SELECT nombre from tbl_sitios S WHERE S.idsitio= C.origen) AS norigen,
	(SELECT nombre from tbl_sitios S WHERE S.idsitio= C.destino) AS ndestino
	FROM tbl_solicitudes C $consultausu $consulta1 $consulta2 $consulta3 $consulta4 $consulta5 $consulta6 $consulta7 
	");
	
	$total_registros = mysql_num_rows($resultados); 
	$resultados = mysql_query("SELECT id_solicitud,fecha_registro,fecha_envio,id_estado,user_solicita,prioridad,
	fecha_limite_ent,centro_costos,origen,destino,direccion_origen,direccion_destino,persona_entrega,
	persona_recibe,tel_entrega,tel_destino,email_entrega,email_destino,enviada,
	(SELECT nombre_apellido from tbl_usuarios U WHERE U.usuario= C.user_solicita) AS autor,
	(SELECT nombre from tbl_estadoSol E WHERE E.idestados= C.id_estado) AS nomestado,
	(SELECT nombre from tbl_prioridadSol P WHERE P.idprioridad= C.prioridad) AS nomprioridad,
	(SELECT nombre from tbl_sitios S WHERE S.idsitio= C.origen) AS norigen,
	(SELECT nombre from tbl_sitios S WHERE S.idsitio= C.destino) AS ndestino
	FROM tbl_solicitudes C 
	$consultausu $consulta1 $consulta2 $consulta3 $consulta4 $consulta5 $consulta6 $consulta7 
	ORDER BY C.fecha_envio DESC LIMIT $inicio, $registros");	
	mysql_query("SET NAMES 'utf8'");
	//or die("Problemas en el select:".mysql_error()); 
	$total_paginas = ceil($total_registros / $registros);
	/*$query="SELECT id_solicitud,fecha_registro,fecha_envio,id_estado,user_solicita,prioridad,
	fecha_limite_ent,centro_costos,origen,destino,direccion_origen,direccion_destino,persona_entrega,
	persona_recibe,tel_entrega,tel_destino,email_entrega,email_destino,enviada,
	(SELECT nombre_apellido from tbl_usuarios U WHERE U.usuario= C.user_solicita) AS autor,
	(SELECT nombre from tbl_estadoSol E WHERE E.idestados= C.id_estado) AS nomestado,
	(SELECT nombre from tbl_prioridadSol P WHERE P.idprioridad= C.prioridad) AS nomprioridad,
	(SELECT nombre from tbl_sitios S WHERE S.idsitio= C.origen) AS norigen,
	(SELECT nombre from tbl_sitios S WHERE S.idsitio= C.destino) AS ndestino
	FROM tbl_solicitudes C 
	$consultausu $consulta1 $consulta2 $consulta3 $consulta4 $consulta5 $consulta6 $consulta7 
	ORDER BY C.fecha_envio";echo $query;*/
	?>
	<center>
	<div id="tabla"  style="width: 900px;font-family: Arial, Helvetica, sans-serif;font-size: 13px;color: #1152A2;font-weight: bold;align:center;">
	
	<table  align="left" border='0'>
		<tr>
			<td align="left">
				<input type="button" value="Crear Solicitud&nbsp;&nbsp;" name="guardar" onClick="location.href='../solicitudes/newsolicitud.php'" style="
		font-family: 'verdana';
		font-size: 14px;
		font-weight: bold;
		color: #FFFFFF;
		display: block;
		height: 43px;
		width: 195px;
		text-align: center;
		background-image: url(../images/btncont.png);
		text-decoration: none;
		padding-left: 1px;
		text-shadow: 1px 1px 1px #9b9b9b;
		border-top-width: 0px;
		border-right-width: 0px;
		border-bottom-width: 0px;
		border-left-width: 0px;
		border-top-style: none;
		border-right-style: none;
		border-bottom-style: none;
		border-left-style: none;
		background-color: transparent;
		cursor:pointer;
		float: left;">
		<?
		if($perfil==1 or $perfil==2)
		{
		?>
		<input type="button" value="Exportar&nbsp;&nbsp;&nbsp;&nbsp;" name="guardar" onClick="location.href='../solicitudes/export_tiempos.php'" style="
		font-family: 'verdana';
		font-size: 14px;
		font-weight: bold;
		color: #FFFFFF;
		display: block;
		height: 43px;
		width: 195px;
		text-align: center;
		background-image: url(../images/btnexporta.png);
		text-decoration: none;
		padding-left: 1px;
		text-shadow: 1px 1px 1px #9b9b9b;
		border-top-width: 0px;
		border-right-width: 0px;
		border-bottom-width: 0px;
		border-left-width: 0px;
		border-top-style: none;
		border-right-style: none;
		border-bottom-style: none;
		border-left-style: none;
		background-color: transparent;
		cursor:pointer;
		float: left;">
		<?
		}
		else
		{
		?>
		<input type="button" value="Exportar&nbsp;&nbsp;&nbsp;&nbsp;" name="guardar" onClick="location.href='../solicitudes/export.php'" style="
		font-family: 'verdana';
		font-size: 14px;
		font-weight: bold;
		color: #FFFFFF;
		display: block;
		height: 43px;
		width: 195px;
		text-align: center;
		background-image: url(../images/btnexporta.png);
		text-decoration: none;
		padding-left: 1px;
		text-shadow: 1px 1px 1px #9b9b9b;
		border-top-width: 0px;
		border-right-width: 0px;
		border-bottom-width: 0px;
		border-left-width: 0px;
		border-top-style: none;
		border-right-style: none;
		border-bottom-style: none;
		border-left-style: none;
		background-color: transparent;
		cursor:pointer;
		float: left;">
		<?
		}
		?>
			</td>
		</tr>
	</table>
	</div>
	<?
	if($total_registros<=0)
	{
		echo "<div align='center'>"; 
				echo "<br><br><br><br><font size='2' face='verdana' color='#C12C2A'>
				<IMG src='../images/info.png' border='0' width='80'>
				<b>No se encontraron solicitudes registradas</b>"; 
				echo "</div>";
			
	}
	else
	{
	?>
	
	<?
	
	?>
	<br><br><br>
	
	<div id="tabla"  style="width: 900px;font-family: Arial, Helvetica, sans-serif;font-size: 13px;color: #8A0808;font-weight: bold;align:center;">
	<table class="sortable" id="anyid" width="900" align="center" border="0" style="border-radius: 5px;-moz-border-radius: 5px;-o-border-radius: 5px;-webkit-border-radius: 5px;">
			<th style="background-image: url(../images/bgmenu.png);"><font face='Verdana' color='#ffffff' size='2'>Id Solicitud</a></th>
			<th style="background-image: url(../images/bgmenu.png);"><font face='Verdana' color='#ffffff' size='2'>Estado</a></th>
			<th style="background-image: url(../images/bgmenu.png);"><font face='Verdana' color='#ffffff' size='2'>Prioridad</a></th>
			<th style="background-image: url(../images/bgmenu.png);"><font face='Verdana' color='#ffffff' size='2'>Origen</a></th>
			<th style="background-image: url(../images/bgmenu.png);"><font face='Verdana' color='#ffffff' size='2'>Destino</a></th>
			<th style="background-image: url(../images/bgmenu.png);"><font face='Verdana' color='#ffffff' size='2'>Fecha de Registro</a></th>
			<th style="background-image: url(../images/bgmenu.png);"><font face='Verdana' color='#ffffff' size='2'>Fecha Limite</a></th>
			<th style="background-image: url(../images/bgmenu.png);"><font face='Verdana' color='#ffffff' size='2'>Ver</a></th>
			<?
				
			?>
				<th style="background-image: url(../images/bgmenu.png);"><font face='Verdana' color='#ffffff' size='2'>Actualizar</a></th>
				<?
				
				
			?>
				<th style="background-image: url(../images/bgmenu.png);"><font face='Verdana' color='#ffffff' size='2'>Cancelar</a></th>
			<?
				
			?>
			<!--<th style="background-image: url(../images/bgmenu.png);"><font face='Verdana' color='#ffffff' size='2'>Ver Historial</a></th>-->
	<?
	$i = 1; // Contador
	while($articulo=mysql_fetch_array($resultados)) {
	echo"<tr bgcolor='#Ffffff'>";
					echo"<td > 
							{$articulo['id_solicitud']}
							</font>
					</td>";
					echo"<td style='text-align: left;'> ";
							$nomestado=utf8_decode($articulo['nomestado']);
							if("{$articulo['id_estado']}"==3 and ($perfil==1 or $perfil==2))
							{
								echo"<a href='../unidad/newunidad.php?id={$articulo['id_solicitud']}'>
										<IMG src='../images/pmorado.png' border='0'width='20'>
									 </a>";
									}
							else if("{$articulo['id_estado']}"==10 and ($perfil==1 or $perfil==2))
							{
								//<a href='../unidad/newunidad.php?id={$articulo['id_solicitud']}'>
								echo"<IMG src='../images/final.png' border='0'width='20'>
									 </a>";
									}
							
							echo "$nomestado
							</font>
					</td>";
					$idprioridad=$articulo['prioridad'];
					if(($idprioridad==1) and ("{$articulo['id_estado']}"!=7 and "{$articulo['id_estado']}"!=10))//Urgente
					{
						//$fondo="#FE2E2E";//Rojo
						$fondo="<IMG src='../images/projo.png' border='0'width='20'>";//Rojo
					}
					else if(($idprioridad==2) and ("{$articulo['id_estado']}"!=7 and "{$articulo['id_estado']}"!=10))//Alta
					{
						//$fondo="#E2A9F3";//Morada
						$fondo="<IMG src='../images/pazul.png' border='0'width='20'>";//Rojo
					}
					else if(($idprioridad==3) and ("{$articulo['id_estado']}"!=7 and "{$articulo['id_estado']}"!=10))//Baja
					{
						//$fondo="#D7DF01";//Amarilla
						$fondo="<IMG src='../images/pamarillo.png' border='0'width='20'>";//Rojo
					}
					else if(($idprioridad==4) and ("{$articulo['id_estado']}"!=7 and "{$articulo['id_estado']}"!=10))//Media
					{
						//$fondo="#FF8000";//Naranja
						$fondo="<IMG src='../images/pnaranja.png' border='0'width='20'>";//Rojo
					}
					else if(("{$articulo['id_estado']}"==7) or ("{$articulo['id_estado']}"==10))//Media
					{
						$fondo="";//Naranja
						//$fondo="<IMG src='../images/pnaranja.png' border='0'width='20'>";//Rojo
					}
					
					echo"<td align='left' style='text-align: left;'> ";//background-color: $fondo;
							$prioridad=($articulo['nomprioridad']);
							echo"$fondo $prioridad </font>
					</td>";
					echo"<td >";
							$norigen=utf8_decode($articulo['norigen']);
							echo"$norigen</font>
					</td>";
					
					echo"<td >";
							$ndestino=utf8_decode($articulo['ndestino']);
							echo"$ndestino</font>
					</td>";	
					echo"	<td>
							{$articulo['fecha_envio']}
						</td>";	
					echo"	<td>
							{$articulo['fecha_limite_ent']}
						</td>";	
					echo"	<td align='center'>
							<a href='../solicitudes/bussolicitud.php?id={$articulo['id_solicitud']}'><IMG src='../images/buscar.png' border='0'width='20'>
						";
						echo"</td>";	
					if($perfil=="1" or $perfil=="2")
					{	
						/*if("{$articulo['enviada']}"=="1")
						{
							echo"<td align='center'>
								<IMG src='../images/actualizardes.png' border='0'width='20'>
							";
							echo"</td>";
						}
						else */
						if((("{$articulo['id_estado']}"==5)or("{$articulo['id_estado']}"==7)) and ("{$articulo['user_solicita']}"==$user))
						{
							echo"<td align='center'>
								<a href='../solicitudes/newsolicitud.php?id={$articulo['id_solicitud']}'><IMG src='../images/actualizar.png' border='0'width='20'>
							";
							echo"</td>";
						}
						else
						{
							echo"	<td align='center'>
								<IMG src='../images/actualizardes.png' border='0'width='20'>
							";
							echo"</td>";
						}
					}
					else if("{$articulo['enviada']}"=="0" and "{$articulo['user_solicita']}"==$user) 
					{
						echo"<td align='center'>
								<a href='../solicitudes/newsolicitud.php?id={$articulo['id_solicitud']}'><IMG src='../images/actualizar.png' border='0'width='20'>
						";
						echo"</td>";
					}
					else if("{$articulo['enviada']}"=="1" and "{$articulo['user_solicita']}"==$user and "{$articulo['id_estado']}"==7) 
					{
						echo"<td align='center'>
								<a href='../solicitudes/newsolicitud.php?id={$articulo['id_solicitud']}'><IMG src='../images/actualizar.png' border='0'width='20'>
						";
						echo"</td>";
					}
					else
					{
						echo"	<td align='center'>
								<IMG src='../images/actualizardes.png' border='0'width='20'>
							";
							echo"</td>";
					}
					
							
						echo"<td align='center'>";
						if(("{$articulo['user_solicita']}"==$user) and (("{$articulo['id_estado']}"==3)or("{$articulo['id_estado']}"==4)or("{$articulo['id_estado']}"==5)or("{$articulo['id_estado']}"==6)or("{$articulo['id_estado']}"==7)or("{$articulo['id_estado']}"==8)))
						{
						?>
							<a href='../solicitudes/delelsol.php<?echo"?id={$articulo['id_solicitud']}";?>' onclick="return confirmar('delcontra.php<?echo"?id={$articulo['id_solicitud']}";?>')">
								<IMG src='../images/eliminar.png' border='0'width='20'>
							</a>
						<?
						}
						else if(($perfil=="1" or $perfil=="2")and(("{$articulo['id_estado']}"==3)or("{$articulo['id_estado']}"==4)or("{$articulo['id_estado']}"==5)or("{$articulo['id_estado']}"==6)or("{$articulo['id_estado']}"==7)or("{$articulo['id_estado']}"==8)))
						{
						?>
							<a href='../solicitudes/delelsol.php<?echo"?id={$articulo['id_solicitud']}";?>' onclick="return confirmar('delcontra.php<?echo"?id={$articulo['id_solicitud']}";?>')">
								<IMG src='../images/eliminar.png' border='0'width='20'>
							</a>
						<?
						}
						
						else 
						{
						?>
							<IMG src='../images/eliminardes.png' border='0'width='20'>
						<?
						}
						echo "</td>";
					
					/*echo"	<td align='center'>
							<a href='../solicitude/bitasolicitud.php?id={$articulo['id_solicitud']}'><IMG src='../images/bitacora.png' border='0'width='25'>
						";
						echo"</td>";*/
						
	}
	mysql_free_result($resultados);	
	if($total_registros) {
		echo"</tr> </table>";
		echo "
		
		<center>";
		
		if(($pagina - 1) > 0) {
			echo "<font size='2' face='verdana' color='#8A0808'><TR><a href='solicitudes.php?pagina=".($pagina-1)."' style='text-decoration:none;color:#8A0808;'>< Anterior</a> ";
		}
		
		for ($i=1; $i<=$total_paginas; $i++){ 
			if ($pagina == $i) 
				echo "<b>".$pagina."</b> "; 
			else
				echo "<font size='2' face='verdana' color='#8A0808'><a href='solicitudes.php?pagina=$i' style='text-decoration:none;color:#8A0808;'>$i</a> "; 
		}
	  
		if(($pagina + 1)<=$total_paginas) {
			echo " <font size='2' face='verdana' color='#8A0808'><a href='solicitudes.php?pagina=".($pagina+1)."' style='text-decoration:none;color:#8A0808;'>Siguiente ></a>";
		}
		
		echo "</center></div>";
	}
}

	$_SESSION["consultausu"]=$consultausu;
	$_SESSION["consulta1"]=$consulta1;
	$_SESSION["consulta2"]=$consulta2;
	$_SESSION["consulta3"]=$consulta3;
	$_SESSION["consulta4"]=$consulta4;
	$_SESSION["consulta5"]=$consulta5;
	$_SESSION["consulta6"]=$consulta6;
	$_SESSION["consulta7"]=$consulta7;
?>
</div>
</center>