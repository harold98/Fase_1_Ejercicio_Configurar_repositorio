<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
   // session_destroy();
    session_unset();
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
     if($tiempo_transcurrido >= 600) {  
     //si pasaron 10 minutos o más  
      session_destroy(); // destruyo la sesión 
      header("Location: ../index.php"); //envío al usuario a la pag. de autenticación 	  
      //sino, actualizo la fecha de la sesión  
    }else {  
    $_SESSION["ultimoAcceso"] = $ahora;  
   }
    	
    	$user=$_SESSION['inter_user'];
    
        # Inicio validacion de formulario
        $user=$_SESSION['inter_user'];
        include("../datos/.Config.ini");
        include("../database/ValidPerfilUsr.php");
        $RolValidacion= $PERFIL_CONSULTA;
        $perfil = ValidaUsuario($user, "$usuario", "$pswd", "$db",$RolValidacion, "$PERFIL_ADMIN", "$PERFIL_AGENDADOR", null) ;
    ?>
<head>
    <title>:::...Gesti&oacute;n de Agendamiento...:::</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link rel="stylesheet" type="text/css" href="../sortable/example.css"/>
    <meta name="author" content="Joost de Valk, http://www.joostdevalk.nl/" />
    <link href="http://www.joostdevalk.nl/" rev="made" />
    <script type="text/javascript" src="../sortable/sortable.js"></script>
    <!--BAYRON LO PUSO PARA QUE CUANDO SE PRESIONE ATRAS Y SE DIRIJA A ESTA PAGINA NUNA LO REALIZE Y SE MANTENGA EN LA QUE SE PRECIONO ESE BOTON-->	
    <meta http-equiv="Expires" content="0" />
    <meta http-equiv="Pragma" content="no-cache" />
    <script type="text/javascript">
        if(history.forward(1)){
        location.replace( history.forward(1) );
        }
    </script>
    <!-- ACA FINALIZA -->
    <link type='text/css' href='../calendario/css/ui-lightness/jquery-ui-1.7.2.custom.css' rel='stylesheet' />
    <script type='text/javascript' src='../calendario/js/jquery-1.3.2.min.js'></script>
    <script type='text/javascript' src='../calendario/js/jquery-ui-1.7.2.custom.min.js'></script>
    <script>
        function confirmar(url,mensaje)
        {
        	if(confirm('Est\u00E1s seguro de ' + mensaje + ' este registro?'))
        	{
        		window.location=("../parametrizacion/eliminacapac.php <?php echo"?id={$articulo['CAPAC_UNID_OPER_ID']}";?>");
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
        <?php
            include ('../datos/validaciones.php');
            ?>
        <div id="titulos"style="font-family: Arial, Helvetica, sans-serif;font-size: 18px;color: #8A0808;">
            <table width="1000" align="center">
                <tr>
                    <td>
                        <b>Agenda - Excepciones por Localidad</b>
    </font>
    </td>
    </tr>
    </table>
    </div>
    <?php
	
				
        include("../presentacion/UtilView.php");
        $conexion = connectDB("$usuario","$pswd","$db");
        	//Parametros de busqueda  
        	
        	
        	$localidad=$_REQUEST['localidad'];
        	$localidadcancelar = $_POST['localidadcancelar'];
        		if($localidadcancelar != null){
        		    $localidad= (int) $localidadcancelar;
        	             }
        
            if($localidadcancelar  == 0)	{
        	$localidad=$_REQUEST['localidad'];
        	}	
        
            $localidadeliminar = $_SESSION['localidadeliminar'];  		 
        		if($localidadeliminar != null){
        		$localidad= (int) $localidadeliminar;
        		}
        	unset($_SESSION['localidadeliminar']); 	
        
        
        	$unioper=$_REQUEST['unidadoper'];
        	$uniopercancelar = $_POST['uniopercacenlar'];
        	if($uniopercancelar != null){
        		$unioper = $uniopercancelar;
        	}
        	
        	$uniopereliminar = $_SESSION["uniopereliminar"]; 
        	if($uniopereliminar != null){
        	$unioper = $uniopereliminar;
        	}
        	unset($_SESSION["uniopereliminar"]); 
        	
        	
        	  $grupotarea = $_POST['grupotarea'];
        	  $grupotareacancelar = $_POST['grupotareacancelar'];
        	  if($grupotareacancelar  != null){
        	  $grupotarea = $grupotareacancelar;
        	  }
        	  
        	  $grupotareaeliminar = $_SESSION["grupotareaeliminar"];
        	  if($grupotareaeliminar != null){
        	  $grupotarea = $grupotareaeliminar;
        	  }
             
        	 	unset($_SESSION["grupotareaeliminar"]); 	   	
        
        ?>	
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
            <table width="900" align="center" border="0" style="background-image: url(../images/bgtabla.jpeg);border-radius: 5px; -moz-border-radius: 5px; -o-border-radius: 5px;-webkit-border-radius: 5px;">
                <tr height='20'>
                </tr>
                <tr>
                    <td width='60'>
                    </td>
                    <!-- Campo de localidad -->
                    <td>
                        <?php	
                            AdicionListaValores("localidad","Localidad", $localidad, "Seleccione una Localidad", "N", $SEL_LOCALIDAD, $conexion);
                            ?> 
                    </td>
                    <!-- Campo de Unidad Operativa-->
                    <td>
                        <?php
                            AdicionListaValores("unidadoper","Unidad&nbsp;Operativa", $unioper, "Seleccione la unidad operativa", "N", $SEL_UNIOPER, $conexion );
                            ?> 
                    </td>
                </tr>
                <tr>
                    <td width='60'>
                    </td>
                    <!-- Campo de Grupo de Tareas -->
                    <td>
                        <?php
                            AdicionListaValores("grupotarea","Grupo&nbsp;Tarea", $grupotarea, "Seleccione Grupo de Tarea", "N", $SEL_TIPO_TAREA, $conexion);
                            ?> 
                    </td>
                    <td>
                    </td>
                    <td> 
                    </td>
                    <td>
                        <table border="0" aling = "center">
                   <td aling = "right">
		<form name="formulario1">
        </form >
        <form name="formulario1" method="post" action="editarexcepciones.php">
        <?php	
            echo"<input type='text' name='id' value='0' maxlength='1' size='1' style='width:1px; height:1px; visibility: hidden'>";
            echo"<input type='text' name='localidadnuevo' value='$localidad' maxlength='1' size='1' style='width:1px; height:1px; visibility: hidden'>";
            echo"<input type='text' name='uniopernuevo' value='$unioper' maxlength='1' size='1' style='width:1px; height:1px; visibility: hidden'>";
            echo"<input type='text' name='grupotareanuevo' value='$grupotarea' maxlength='1' size='1' style='width:1px; height:1px; visibility: hidden'>";
            ?>
        <input type="submit" value="Nueva excep" name="nuevo" align='right' style="
            font-family: 'verdana'; font-size: 11px; font-weight: bold; color: #FFFFFF; display: block; height: 27px; width: 86px; margin-left: 30px; margin-top: 1px; margin-bottom: 10px;
            text-align: center; background-image: url(../images/boton_g.png); text-decoration: none; padding-left: 4px; text-shadow: 1px 1px 1px #9b9b9b;
            border-top-width: 0px; border-right-width: 0px; border-bottom-width: 0px; border-left-width: 0px; border-top-style: none; border-right-style: none;
            border-bottom-style: none; border-left-style: none; background-color: transparent; cursor:pointer; float: center;">
        </form>
        </td>
        <td aling = "right">
		
        <form name="formulario2" >
        </form >
        <form name="formulario2" >
        <input type='text' name='id' value='0' maxlength='1' size='1' style='width:1px; height:1px; visibility: hidden'>
        </form>
        <input type="submit" value="Buscar" name="buscar" align="right" style="
            font-family: 'verdana'; font-size: 11px; font-weight: bold; color: #FFFFFF; display: block; height: 27px; width: 86px; margin-left: 30px; margin-top: 1px; margin-bottom: 10px;
            text-align: center; background-image: url(../images/boton_g.png); text-decoration: none; padding-left: 4px; text-shadow: 1px 1px 1px #9b9b9b;
            border-top-width: 0px; border-right-width: 0px; border-bottom-width: 0px; border-left-width: 0px; border-top-style: none; border-right-style: none;
            border-bottom-style: none; border-left-style: none; background-color: transparent; cursor:pointer; float: left;">
        </td> 
        </table>
        </tr>
        </table>
    </div>
    <?php
        function conectar() 
        { 
        		include("../datos/.Config.ini");
        		if (!($conexion = connectDB("$usuario","$pswd","$db")))
        		{ 
        				echo "Error conectando a la base de datos."; 
        				exit(); 
        		} 
        		return $conexion; 
        } 
        
        $db = conectar();
        
        // Registros por pagina
        $registros = 10;
        
        if (!$pagina) { 
            $inicio = 0; 
            $pagina = 1; 
        } 
        else 
        { 
            $inicio = ($pagina - 1) * $registros; 
        } 
        // Se define consulta 
        $stid=EjecutaRefCursor( $LST_EXCEPLOCA, $conexion, $localidad, $unioper, $grupotarea );
        while (($fila = oci_fetch_array($stid, OCI_ASSOC))) {
            $rc = $fila['DATA'];
            oci_execute($rc);  // el valor de la columna devuelta por la consulta es un ref cursor
            oci_free_statement($stid);
        	?>
    <center>
        <br>
        <div id="tabla"  style="width: 1000px;font-family: Arial, Helvetica, sans-serif;font-size: 13px;color: #010D66;font-weight: bold;align:center;">
            <table class="sortable" id="anyid" width="900" align="center" border="0" >
            <th style="background-image: url(../images/bgmenu.png);"><font face='Verdana' color='#ffffff' size='2'>U_Operativa</a></th>
            <th style="background-image: url(../images/bgmenu3.png);"><font face='Verdana' color='#ffffff' size='2'>______Unidad_Operativa_____</a></th>
            <th style="background-image: url(../images/bgmenu3.png);"><font face='Verdana' color='#ffffff' size='2'>_____Localidad______</a></th>
            <th style="background-image: url(../images/bgmenu3.png);"><font face='Verdana' color='#ffffff' size='2'>Franja</a></th>
            <th style="background-image: url(../images/bgmenu3.png);"><font face='Verdana' color='#ffffff' size='2'>Nro_T&eacutecnicos</a></th>
            <th style="background-image: url(../images/bgmenu3.png);"><font face='Verdana' color='#ffffff' size='2'>Cant_Trabajos</a></th>
            <th style="background-image: url(../images/bgmenu3.png);"><font face='Verdana' color='#ffffff' size='2'>Grupo_Tarea</a></th>
            <th style="background-image: url(../images/bgmenu3.png);"><font face='Verdana' color='#ffffff' size='2'>Fecha_Excep</a></th>
            <th style="background-image: url(../images/bgmenu3.png);"><font face='Verdana' color='#ffffff' size='2'>Eliminar</a></th>
            <?php
                $i = 1; // Contador
                # Se recorre subconsulta de cursor referenciado
                   while (($articulo = oci_fetch_array($rc, OCI_ASSOC))) {
                	// para algunas columnas
                	$total_registros++;
                	$idCapacidadAgenda = $articulo['CAPAC_UNID_OPER_EXC_ID'] ;
                	echo"<tr bgcolor='#Ffffff'>";
                	echo"<td > {$articulo['UNIDAD_OPERATIVA_ID']} </font> </td>"; 
                	echo"<td >"; $desunidadoper = ("{$articulo['NAME']}"); echo"$desunidadoper</font> </td>";
                	echo"<td style='text-align: left;'>"; $deslocalidad = ("{$articulo['DESCLOCALIDAD']}"); echo"$deslocalidad</font> </td>";
                	echo"<td > {$articulo['FRANJA']} </font> </td>";
                	echo"<td > {$articulo['TECNICOS']} </font> </td>";
                	echo"<td > {$articulo['CANTIDAD']} </font> </td>";
                	echo"<td style='text-align: left;'> {$articulo['DESC_GRUPO_TAREA']} </font>  </td>";
					echo"<td style='text-align: left;'> {$articulo['FECHA']} </font>  </td>";
                
                	// Se asigna id para Eliminar
                echo"<td align='center'>";
                ?>
            <a href='../parametrizacion/eliminaexcep.php<?php echo"?id={$articulo['CAPAC_UNID_OPER_EXC_ID']}" ;?>' onclick="return confirmar('../parametrizacion/eliminaexcep.php <?php echo"?id={$articulo['CAPAC_UNID_OPER_EXC_ID']}" ;?>','eliminar')">
            <IMG src='../images/eliminar.png' border='0'width='30'>
            </a>
            <?php
                echo "</td>";
                }

                }
		
                if( $total_registros <= 0 )
                {
                echo "<div align='center'>"; 
                echo "<br><br><br><br><font size='2' face='verdana' color='#C12C2A'>
                <IMG src='../images/info.png' border='0' width='80'>
                <b>No se encontraron Datos</b>"; 
                echo "</div>";
                } 
				
                $_SESSION["localidadeditar"]=$localidad;
                $_SESSION["uniopereditar"]=$unioper;
                $_SESSION["grupotareaeditar"]=$grupotarea;
				
                
                oci_close($conexion);
                
                ?>
				</table>
        </div>	
    </center>
<?php
	    }else{
    
    	echo ("DEBES LOGEARTE !!")	?><script>
    window.location='../index.php';
</script>
<?php
    }
	?>
