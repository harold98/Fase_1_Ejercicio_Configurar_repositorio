<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
    session_start();
    if ($_SESSION['inter_user'])
	{
	
	 //calculamos el tiempo transcurrido  
    $fechaGuardada = $_SESSION["ultimoAcceso"];  
	if($fechaGuardada == null){
	$fechaGuardada = time();
	}
    $ahora = time();  
    $tiempo_transcurrido = $ahora-$fechaGuardada;  
	

    //comparamos el tiempo transcurrido  
     if($tiempo_transcurrido >= 1200) {  
     //si pasaron 10 minutos o más  
      session_destroy(); // destruyo la sesión 
      header("Location: ../index.php"); //envío al usuario a la pag. de autenticación 	  
      //sino, actualizo la fecha de la sesión  
    }else {  
    $_SESSION["ultimoAcceso"] = $ahora;  
   }
    	
    $user=$_SESSION['inter_user'];
    $codigo= $_SESSION['codigoid'];
    $enviofechaelegida=$_SESSION['enviofechaagendada'];
    $franjaelegida=$_SESSION['franjaagendada'];
    $unidadoperativa=$_SESSION['unidadoperagendada'];
    
    #datos para volver a la consulta de pendientes
    $localidad=$_SESSION["localidad"];
    $estado=$_SESSION["estado2"];
    $tarea=$_SESSION["tarea"];
    $tipocte=$_SESSION["tipocte"];
    $solicitud=$_SESSION["solicitud"];
    $codigoOT=$_SESSION["codigoOT"];
	$fecha=$_SESSION["fecha"];
    
     session_start();
     $_SESSION["localidad1"]=$localidad;
     $_SESSION["estado1"]=$estado;
     $_SESSION["tarea1"]=$tarea;
     $_SESSION["tipocte1"]=$tipocte;
     $_SESSION["solicitud1"]=$solicitud;
     $_SESSION["codigoOT1"]=$codigoOT;
	 $_SESSION["fecha1"]=$fecha;
	 $_SESSION["paginapendientesagendar"]=$_SESSION["paginapendientes"];
	 
    ?>
<head>
    <title>:::...Gesti&oacute;n de Agendamiento...:::</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body topmargin=4  link="#FFFFFF" alink="#FFFFFF" vlink="#FFFFFF">
    <font face="Verdana">
    <?php
        $observaciones=$_SESSION['observacion'];
        include ('../datos/validaciones.php');
        $hoy = date("Y-m-d");
        if ($franjaelegida == "Sin Fecha")
		{
         $franjaelegida = 'NA';
        }     
        ?>		
    <!-- desde aca comienza a la tabla de la consulta -->
    <?php
        include("../datos/.Config.ini");
        include("../presentacion/UtilView.php");  
        $conexion = connectDB("$usuario","$pswd","$db"); 	
        	//ACA DES BLOQUEA LA SOLICITUD A AGENDAR
       if($codigo != null)
		{
        	$stid=EjecutaPrcDin( $OBJ_ACT_AGENDA, $conexion, $codigo, NULL, NULL, NULL, NULL, NULL,$sbSalida);  
         }
        $sbSalida=$stid['par_7'];	
        ?>	
    <!--Le da el color rojo a las letras-->
    <br>
    <div id="tabla" style="width: 100%;font-family: Arial, Helvetica, sans-serif;font-size: 13px;color: #010D66;font-weight: bold;align: center;">
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
        <table width="1000" align="center" border="0" cellspacing="5" cellpadding="0" style="background-image: url(../images/bgtabla.jpeg);border-radius: 5px; -moz-border-radius: 5px; -o-border-radius: 5px;-webkit-border-radius: 0px;">
            <tr>
                <td align="center">
                    <label align="center">El registro fue desagendado con &eacutexito</label>
                </td>
            </tr>
            <tr>
                <td>
                </td>
            </tr>
        </table>
    </div>
<script>
        alert( 'El registro fue desagendado con \xc9xito' );
        window.location='../pendientes/pendientes.php';
    </script>
         <?php
 }else
	{
		echo ("DEBES LOGEARTE !!")	?>
		<script>
		 window.location='../index.php';
		</script>
		<?php
    } 
	?>
