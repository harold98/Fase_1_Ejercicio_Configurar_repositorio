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
     //si pasaron 10 minutos o m?s  
      session_destroy(); // destruyo la sesi?n 
      header("Location: ../index.php"); //env?o al usuario a la pag. de autenticaci?n 	  
      //sino, actualizo la fecha de la sesi?n  
    }else {  
    $_SESSION["ultimoAcceso"] = $ahora;  
   }
    
    
    	# Estos son los datos del registro elejido
    	$user=$_SESSION['inter_user'];
    	$localidad=$_SESSION["localidad"];
    	$estado=$_SESSION["estado"];
    	$tarea=$_SESSION["tarea"];
    	$tipocte=$_SESSION["tipocte"];
    	$solicitud=$_SESSION["solicitud"];
    	$codigoOT=$_SESSION["codigoOT"];
    	$fecha=$_SESSION["fecha"];

    	
    	# Estos son los datos de los campos seleccionados
    	$localidad2=$_SESSION["localidad2"];
    	$estado2=$_SESSION["estado2"];
    	$tarea2=$_SESSION["tarea2"];
    	$tipocte2=$_SESSION["tipocte2"];
    	$solicitud2=$_SESSION["solicitud2"];
    	$codigoOT2=$_SESSION["codigoOT2"];
		$fecha2=$_SESSION["fecha2"];
    	
    	
    	include("../datos/.Config.ini");
    	 $codigo=$_REQUEST['id'];
    	 $_SESSION['codigoid']=$codigo;
	
		 
         if($localidad2 == null){
		 $localidad2 = $localidad;
		 }  
         if($tarea2 == null){
		 $tarea2 = $tarea;
		 }
         if($tipocte2 == null){
		 $tipocte2 = $tipocte;
		 }	
         if($solicitud2 == null){
		 $solicitud2 = $solicitud;
		 }
      	 if($codigoOT2 == null){
		 $codigoOT2 = $codigoOT;
		 }	 
      
    	 $_SESSION['codigo']=$codigo2;
    	 $_SESSION["localidad"]=$localidad2;
    	 $_SESSION["tarea"]=$tarea2;
    	 $_SESSION["tipocte"]=$tipocte2;
    	 $_SESSION["solicitud"]=$solicitud2;
    	 $_SESSION["codigoOT"]=$codigoOT2;
    	 $_SESSION["estado2"]=$estado2;
		 $_SESSION["fecha"]=$fecha2;
    	
    	 
    ?>
<head>
    <title>:::...Gesti&oacute;n de Agendamiento...:::</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body topmargin=4  link="#FFFFFF" alink="#FFFFFF" vlink="#FFFFFF">
    <font face="Verdana">
    <!--Le da el color Azul a las letras-->
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
    <?php
        $codigo=$_REQUEST['id'];
        include("../datos/consultas.php");
        include("../datos/.Config.ini");
        include("../presentacion/UtilView.php");
        
         $conexion = connectDB("$usuario","$pswd","$db");
        //ACA BLOQUEA LA SOLICITUD A AGENDAR 
        
        $bloquearagenda = "S";
        $stid=EjecutaPrcDin( $OBJ_BLOQUEAAGENDA, $conexion, $codigo, $user, $bloquearagenda, $Salida );
        $sbValidaProc = $stid['par_4'] ;	 
        if ($sbValidaProc != '' ) {
        include ('../datos/validacionesagendabloqueo.php');
        echo"<br>";
        echo"<table width='900' align='center'>";
        echo "<td align='center'> " . $sbValidaProc . "</td>";	 
        echo"</table>";
        
        
        $_SESSION["localidad1"]=$localidad;
        $_SESSION["estado1"]=$estado2;
        $_SESSION["tarea1"]=$tarea;
        $_SESSION["tipocte1"]=$tipocte;
        $_SESSION["solicitud1"]=$solicitud;
        $_SESSION["codigoOT1"]=$codigoOT;
		$_SESSION["fecha1"]=$fecha2;
        
        } else {	
          include ('../datos/validacionesagenda.php');
        ?>
    <script>
        function abririncumplidas(){
        alert("No hay disponibilidad para esta fecha o el tiempo minimo previo para agenda se ha superado (4 horas)");
        }
    </script>
    <div id="titulos" style="font-family: Arial, Helvetica, sans-serif;font-size: 16px;color: #8A0808;">
        <table width="900" align="center"  cellspacing="0" cellpadding="0" border = '0'>
            <tr>
                <td align="center">
                    <b>
                        <font size = '5'>
                            Agenda</a>
                    </b>
                </td>
            <tr>	
            </font>
        </table>
    </div>
    <?php
        #desde aca comienza a la tabla de la consulta 
        
        $coloor = $_POST['coloor'];
        
        # este estado es el que trae con el boton para retormar el estado que lleba la orden reagendada
        $estadoreagenda = $_POST['estado'];
        
        #trae denuevo la unidad operativa una ves se preciona un boton esto para que no se borren los botones al precionar uno
        $mantunidadoperativa= $_POST['unidadoperativa'];
        
        if($coloor != R){
        $fechadiaselegido = $_POST['fechadias'];
        $franjadiaselegido = $_POST['franja']; 
        }else{
        ?>
    <script>
        abririncumplidas();
    </script>

    <!--Le da el color rojo a las letras-->
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
        <?php
            $Activadorunidadoper = 1;
            $reciboactivador = $_POST['activadorunidadoper'];
            if($reciboactivador != null){
            $Activadorunidadoper = 2;
            }
            
            if($mantunidadoperativa != null){ //ESTO SE ACTIVA CUANDO PRECIONO UN BOTON DE LOS DE AGENDA PARA QUE LA UNIDAD OPERATIVA MANTENGA LA MISMA DE LOS BOTONES Y AL HACER EL SUMBIT ESTE NO CAMBIE AL DE FACRICA
                  $nuUnidOper = $mantunidadoperativa;
            }else if($unidadoperagendada3 != null and $Activadorunidadoper == 1){
               $nuUnidOper = $unidadoperagendada;
            }
            ?>
        <form name="formulario10" method="post" onSubmit="return validar(this)">
            <table width="630" align="center" border="0" cellspacing="0" cellpadding="0" >
                <tr>
                    <td>
                        <?php				
                            if ( $_POST['unidadoper'] == '' and $mantunidadoperativa == null and $unidadoperagendada == null){
                            			  $nuUnidOper=2000;
                            			  }
                            			else if($nuUnidOper == null){
                            			  $nuUnidOper=$_POST['unidadoper'];
                            			  }
                                            
                            			AdicionListaValoressubmit("unidadoper","Unidad&nbsp;Operativa&nbsp;", $nuUnidOper, "Seleccione Unidad Operativa", "N", $SEL_UNIOPER, $conexion);
                            echo"&nbsp;";
                            
                            if($nuUnidOper == null){
                            		$unidadoperativa = 2000;
                            		}else{
                            		$unidadoperativa = $nuUnidOper;
                            		}	
                                      
                                  echo"</td>";
                                  echo"<td align=\"center\">";
                                  echo "<input type='text' name='estado' value='$estado' maxlength='1' size='1' style='width:1px; height:1px; visibility: hidden'/>";	
                                  echo "<input type='text' name='fechaAgendada' value='$fechaAgendada' maxlength='1' size='1' style='width:1px; height:1px; visibility: hidden'/>";
                            	  echo "<input type='text' name='franjaAgendada' value='$franjaAgendada' maxlength='1' size='1' style='width:1px; height:1px; visibility: hidden'/>";
                                  echo "<input type='text' name='observaciones' value='$observaciones' maxlength='1' size='1' style='width:1px; height:1px; visibility: hidden'/>";
                            	  echo "<input type='text' name='unidadoperagendada' value='$unidadoperagendada' maxlength='1' size='1' style='width:1px; height:1px; visibility: hidden'/>";		
                                  echo "<input type='text' name='descunidadoperagendada' value='$descunidadoperagendada' maxlength='1' size='1' style='width:1px; height:1px; visibility: hidden'/>";
                                  echo "<input type='text' name='activadorunidadoper' value='$Activadorunidadoper' maxlength='1' size='1' style='width:1px; height:1px; visibility: hidden'/>";	
                              				 ?>			
                    </td>
                </tr>
            </table>
        </form>
        <FORM NAME="formulario" METHOD="post" onSubmit="return validar(this)">
            <table width="1000" align="center" border="0" cellspacing="0" cellpadding="0" style="background-image: url(../images/bgtabla.jpeg);border-radius: 5px; -moz-border-radius: 5px; -o-border-radius: 5px;-webkit-border-radius: 0px;">
                <tr>
                    <dt>
                        <table width="1000" align="center" border="0" cellspacing="0" cellpadding="0" style="background-image: url(../images/bgtabla.jpeg);border-radius: 0px; -moz-border-radius: 0px; -o-border-radius: 0px;-webkit-border-radius: 0px;">
                            <tr>
                                <td align="left" valign="top" >
                                    <table width="338" align="center" cellspacing="0" border = "0" style="background-image: url(../images/bgtabla.jpeg);border-radius: 5px; -moz-border-radius: 5px; -o-border-radius: 5px;-webkit-border-radius: 5px;">
                                        <tr>
                                            <!-- Campo de Pedido -->
                                            <td  height="30px">															
                                                Solicitud 											
                                            </td>
                                            <!-- Campo de la consulta del pedido-->
                                            <td height="30px" >
                                                <?php
                                                    echo "<strong style='font-weight: normal'>$periodo<strong>";
                                                          	?>								
                                            </td>
                                        </tr>
                                        <tr>
                                            <!-- Campo de Orden -->
                                            <td height="20px" >
                                                Orden
                                            </td>
                                            <!-- Campo de la consulta de la Orden -->
                                            <td height="20px" >
                                                <?php
                                                    echo "<strong style='font-weight: normal'>$orden<strong>";
                                                     ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <!-- Campo del Cliente -->
                                            <td height="20px" >
                                                Cliente
                                            </td>
                                            <!-- Campo de la consulta del Telefono -->
                                            <td height="20px" >
                                                <?php
                                                    echo "<strong style='font-weight: normal'>$cliente<strong>";
                                                    ?> 
                                            </td>
                                        </tr>
                                        <tr>
                                            <!-- Campo de Contacto -->
                                            <td height="30px" >
                                                Contacto 
                                            </td>
                                            <!-- Campo de la consulta del Contrato -->
                                            <td height="30px" >
                                                <?php
                                                    echo "<strong style='font-weight: normal'>$contacto<strong>";
                                                    ?> 
                                            </td>
                                        </tr>
                                        <tr>
                                            <!-- Campo del Telefono -->
                                            <td height="30px" >
                                               Tel&eacutefono
                                            </td>
                                            <!-- Campo de la consulta del Telefono -->
                                            <td height="30px" >
                                                <?php
                                                    echo "<strong style='font-weight: normal'>$telefono<strong>";
                                                    ?> 
                                            </td>
                                        </tr>
                                        <tr>
                                            <!-- Campo del Municipio -->
                                            <td height="20px" >
                                                Municipio
                                            </td>
                                            <td height="20px" >
                                                <?php
                                                    echo "<strong style='font-weight: normal'>$municipio<strong>";
                                                    ?> 
                                            </td>
                                        </tr>
                                        <tr>
                                            <!-- Campo del Barrio -->
                                            <td height="30px" >
                                                Barrio
                                            </td>
                                            <td height="30px" >
                                                <?php
                                                    echo "<strong style='font-weight: normal'>$barrio<strong>";
                                                    ?> 
                                            </td>
                                        </tr>
                                        <tr>
                                        <tr>
                                            <!-- Campo de la Direccion -->
                                            <td height="30px" >
                                                Direcci&oacuten
                                            </td>
                                            <td height="30px" >
                                                <?php
                                                    echo "<strong style='font-weight: normal'>$direccion<strong>";
                                                    ?> 
                                            </td>
                                        </tr>
                                        <tr>
                                            <!-- Campo de la Fecha -->
                                            <td height="20px" >
                                                Fecha
                                            </td>
                                            <td height="20px" >
                                                <?php
                                                    echo "<strong style='font-weight: normal'>$fecha<strong>";
                                                    ?> 
                                            </td>
                                        </tr>
                                        <tr>
                                            <!-- Campo de Trabajo a Realizar -->
                                            <td height="30px" >
                                                Trabajo a Realizar
                                            </td>
                                            <td height="30px" >
                                                <?php
                                                    echo "<strong style='font-weight: normal'>$trabajorealizar<strong>";
                                                    ?> 
                                            </td>
                                        </tr>
                                        <tr>
                                            <!-- Campo de GrupoTarea -->
                                            <td height="20px" >
                                                Grupo Tarea
                                            </td>
                                            <td height="20px" >
                                                <?php
                                                    echo "<strong style='font-weight: normal'>$desGrupoTarea<strong>";
                                                    ?> 
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="30px" >
                                                Cantidad de Reagendas
                                            </td>
                                            <td height="30px" >
                                                <?php
                                                    echo "<strong style='font-weight: normal'>$reagendadas<strong>";
                                                    ?>
                                        <tr>
                                        </tr>
                                        <tr>
                                            <td height="30px" >
                                                <a href="#" onclick="abririncumplidas()"><font color=#8A0808><b>Ver incumplidas</b></font></a>
                                            </td>
                                            <td height="30px" >
                                                <?php	$cantincumplidas = 0;   
                                                    $stid=EjecutaRefCursor2( $LST_INCUMPLIDAS, $conexion, 1, $codigo, NULL, NULL, NULL, NUll, NULL, NULL, NULL);
                                                                              
                                                    while (($fila = oci_fetch_array($stid, OCI_ASSOC))) {
                                                       $rc = $fila['DATA'];
                                                       oci_execute($rc);  // el valor de la columna devuelta por la consulta es un ref cursor
                                                    while (($articulo = oci_fetch_array($rc, OCI_ASSOC))) {
                                                       $articulo['ORDER_ID'];
                                                    	
                                                    	$cantincumplidas = $cantincumplidas + 1;
                                                           }
                                                    	   oci_free_statement($rc);
                                                    }
                                                    echo "<strong style='font-weight: normal'>$cantincumplidas<strong>";
                                                    									?>
                                            </td>
                                        </tr>
                                        <?php
                                            if ($estado != 1){
                                                echo"<tr>";
                                            echo"<td height='30px' >";
                                            echo "Fecha &uacuteltima Agenda";
                                            echo"</td>";
                                            echo"<td height='30px'>";	
                                                       if($fechaAgendada == "1969-12-31" or $fechaAgendada == "1900-01-01"){
                                              
                                              $fechaAgendada = null;
                                               
                                              echo "<strong style='font-weight: normal'>$franjaAgendada<strong>";
                                              }else{		
                                                  echo "<strong style='font-weight: normal'>$fechaAgendadatotal <strong>";
                                            }
                                            echo"</td>";
                                            echo"</tr>";	
                                                       }    
                                               if ($estado != 1){
                                            echo"<tr>";
                                            echo"<td height='30px' >";
                                            echo"<br>";
                                            echo "Unidad Operativa Agendada";
                                            echo"</td>";
                                            echo"<td height='30px'>";	
                                                        echo "<strong style='font-weight: normal'>$descunidadoperagendada<strong>";
                                            echo"</td>";
                                            echo"</tr>";
                                            }
                                              ?>		
                                        <tr>
                                            <!-- Campo de Causa de incumplimiento -->
                                            <td height="30px" >
                                                Observaciones
        <form name="formulario" method="post" action="registraragenda.php">
        </form>
        </td>
        <td height="30px" >
        <form name="formulario2" method="post" action="registraragenda.php" style=" margin-bottom: 1px">
		<script type="text/javascript">
				function limita(elEvento, maximoCaracteres) {
				  var elemento = document.getElementById("texto");

				  // Obtener la tecla pulsada 
				  var evento = elEvento || window.event;
				  var codigoCaracter = evento.charCode || evento.keyCode;
				  // Permitir utilizar las teclas con flecha horizontal
				  if(codigoCaracter == 37 || codigoCaracter == 39) {
					return true;
				  }

				  // Permitir borrar con la tecla Backspace y con la tecla Supr.
				  if(codigoCaracter == 8 || codigoCaracter == 46) {
					return true;
				  }
				  else if(elemento.value.length >= maximoCaracteres ) {
					return false;
				  }
				  else {
					return true;
				  }
				}

				function actualizaInfo(maximoCaracteres) {
				  var elemento = document.getElementById("texto");
				  var info = document.getElementById("info");

				  if(elemento.value.length >= maximoCaracteres ) {
					info.innerHTML = "M&aacute;ximo "+maximoCaracteres+" caracteres";
				  }
				  else {
					info.innerHTML = "Faltan "+(maximoCaracteres-elemento.value.length)+" caracteres adicionales";
				  }
				}

            </script>
		<div id="info">M&aacute;ximo 512 caracteres</div>
        <textarea required name ="observasion"  id="texto" onkeypress="return limita(event, 512);" onkeyup="actualizaInfo(512)" class="redo" rows="4" cols="30"><?php echo $observaciones?></textarea>  <!-- si se corre uno o mas hacia la derecha ya no funcionara la restriccion Requiered-->
        <?php
            $_SESSION['enviofechaelegida']=$fechadiaselegido;
            $_SESSION['franjaelegida']=$franjadiaselegido;
            $_SESSION['unidadoperativa']=$unidadoperativa;
            ?>	
        </td>
        </tr>
        <tr>
        <td height="30px" >						
        <input type="submit" value="Agendar" name="agendar" style="
            font-family: 'verdana'; font-size: 11px; font-weight: bold; color: #FFFFFF; display: block; height: 27px; width: 86px; margin-left: 30px; margin-top: 1px; margin-bottom: 10px;
            text-align: center; background-image: url(../images/boton_g.png); text-decoration: none; padding-left: 4px; text-shadow: 1px 1px 1px #9b9b9b;
            border-top-width: 0px; border-right-width: 0px; border-bottom-width: 0px; border-left-width: 0px; border-top-style: none; border-right-style: none;
            border-bottom-style: none; border-left-style: none; background-color: transparent; cursor:pointer; float: left;">	
        </form>
        </td>
        <td height="30px" >	
        <table border = "0">
        <td>						
        <?php
            echo "<form name=\"formulario4\" method=\"post\" action=\"desbloquearagenda.php\">";
            
            echo "<input type=\"submit\" value=\"Cancelar\" name=\"cancelar\" style=\"
            font-family: 'verdana'; font-size: 11px; font-weight: bold; color: #FFFFFF; display: block; height: 27px; width: 86px; margin-top: 10px; margin-left: 30px; margin-top: 1px; margin-bottom: 10px;
            text-align: center; background-image: url(../images/boton_g.png); text-decoration: none; padding-left: 4px; text-shadow: 1px 1px 1px #9b9b9b;
            border-top-width: 0px; border-right-width: 0px; border-bottom-width: 0px; border-left-width: 0px; border-top-style: none; border-right-style: none;
            border-bottom-style: none; border-left-style: none; background-color: transparent; cursor:pointer; float: left;\">";	
            echo "</form>";				
            ?>
        </td>								 
        <td>								 
        <form name="formulario3" method="post" action="desagendar.php">
        <?php
            if ($estado == 2 or $estado == 3 or $estado == 4){
            echo "
            <input type=\"submit\" value=\"Des Agendar\" name=\"desagendar\" style=\"
            font-family: 'verdana'; font-size: 11px; font-weight: bold; color: #FFFFFF; display: block; height: 27px; width: 86px; margin-top: 10px; margin-left: 30px; margin-top: 1px; margin-bottom: 10px;
            text-align: center; background-image: url(../images/boton_g.png); text-decoration: none; padding-left: 4px; text-shadow: 1px 1px 1px #9b9b9b;
            border-top-width: 0px; border-right-width: 0px; border-bottom-width: 0px; border-left-width: 0px; border-top-style: none; border-right-style: none;
            border-bottom-style: none; border-left-style: none; background-color: transparent; cursor:pointer; float: left;\">";
            }
            ?>
        </form>
        </td>
        </table>
        <td>
        </tr>
        <tr>
        <td>
        <td>
        </tr>
        </tr>		
        </table>
        </dt>
        <!--Aca comienza la tabla de los botones-->
        <td align="left" valign="top">
        <table cellpadding="0" width="500" align="center" border="0" cellspacing="0" cellpadding="0" style="border-radius: 5px; -moz-border-radius: 5px; -o-border-radius: 5px;-webkit-border-radius: 5px;">
        <tr height='9'>
        </tr>	
        <tr>
        <td>
        <table border='0' cellspacing='0' cellpadding='0'  height='5' align='center'>
        <tr>
        <!-- Campo de Fecha de agendamiento -->
        <?php
            AddField("FechaAgenda","Fecha de Agendamiento",$fechadiaselegido,20,20,"C",90,"S")	;
            ?>
        </td>
        <td>
        <P ALIGN=left>&nbsp;</p>
        </td>
        <!-- Campo de Franja Agendamiento -->
        <?php
            AddField("franjadias", "&nbsp;Franja&nbsp;Agendamiento",$franjadiaselegido,20,20,"C",40,"S")	;
            ?>
        </td>
        </tr>					
        </table>
        </td>
        </tr>
        <?php
            if ($estado != 1 and $unidadoperagendada2 == null){
            $unidadoperativa =  $unidadoperagendada;
            }
            
            $fechaini = date("Y-m-d");
            $contador = 1;
            $num1cont = 1;
            $num2cont = 3;
            $numcolumn = 1;
            $activafranja = 1;
            #Autor : INDRA
			#Fecha Creación : 01-03-2019
			#Requerimiento: RQ-629784 Circular Única SIC-EDATEL
			#Descripcion: Contador para las 6 franjas definidas para las solicitudes de retiro.
			$num2cont2=6;
			
            echo"<tr>";
            echo"<td>";
            echo "<table border='0' cellspacing='0' cellpadding='0'  align='center'>\n";
            echo "<tr>";
            echo "<td height='5' colspan='16' WIDTH='86'>";	boton ('malo', 'M', 1, 1, 'R', $fechaini, $fechadias, $franjadias, $estado, $fechaAgendada, $franjaAgendada, $observaciones, $unidadoperativa, $unidadoperagendada, $descunidadoperagendada); echo "</td>";
            echo "</tr>";
                              echo "</table>\n";
            echo"</td>";
            echo"</tr>";
            echo"<tr valign='top'>";
            echo"<td valign='top'>";
            
            #Autor : INDRA
			#Fecha Creacion : 01-03-2019
			#Requerimiento: RQ-629784 Circular Unica SIC-EDATEL
			#Descripcion: Tabla para las 6 franjas definidas para las solicitudes de retiro.
			if ($nuGrupoTarea == 3) {
				echo "<table border='0' align='center'  cellspacing='0' cellpadding='0' width='600' >";
				echo"<tr>";
				echo "<th width='110px'><font face='Verdana' color='#ffffff' size='2'></a></th>";
				echo "<th width='80px' align = 'left' ><font face='Verdana' size='2' >&nbsp; 08-10</a></th>";
				echo "<th width='80px' align = 'left' ><font face='Verdana' size='2' >&nbsp; 10-12</a></th>";
				echo "<th width='80px' align = 'left' ><font face='Verdana' size='2' >&nbsp; 12-14</a></th>";
				echo "<th width='80px' align = 'left' ><font face='Verdana' size='2' >&nbsp; 14-16</a></th>";
				echo "<th width='80px' align = 'left' ><font face='Verdana' size='2' >&nbsp; 16-18</a></th>";
				echo "<th width='80px' align = 'left' ><font face='Verdana' size='2' >&nbsp; 18-20</a></th>";
				echo"</tr>";
			}else{
				echo "<table border='0' align='center'  cellspacing='0' cellpadding='0' width='400' >";
				echo"<tr>";
				echo "<th width='110px'><font face='Verdana' color='#ffffff' size='2'></a></th>";
				echo "<th width='80px' align = 'left' ><font face='Verdana' size='5' >&nbsp; AM</a></th>";
				echo "<th width='80px' align = 'left' ><font face='Verdana' size='5' >&nbsp; PM</a></th>";
				echo "<th width='80px' align = 'left' ><font face='Verdana' size='5' >&nbsp; TD</a></th>";
				echo"</tr>";
			}

			#Autor : INDRA
			#Fecha Creacion : 01-03-2019
			#Requerimiento: RQ-629784 Circular Única SIC-EDATEL
			#Descripcion: Tabla para las 6 franjas definidas para las solicitudes de retiro.
			#Inicio RQ-629784
			if ($nuGrupoTarea == 3) {
				$stid=EjecutaRefCursor2($LST_DSPONIBILIDAD_NFR, $conexion, 4, $nuLocalidad, $unidadoperativa, $nuGrupoTarea, $fechaini, Null, NULL, NULL, NULL);
				while (($fila = oci_fetch_array($stid, OCI_ASSOC))) {
					$rc = $fila['DATA'];
					oci_execute($rc);  // el valor de la columna devuelta por la consulta es un ref cursor
					while (($fila_rc = oci_fetch_array($rc, OCI_ASSOC))) {
						$fechadis = $fila_rc['FECHA'];
						$capacidaddis = $fila_rc['CAPACIDAD'];
						$franjadias = $fila_rc['FRANJA'];
						$ocupadosdis = $fila_rc['OCUPADOS'];
						$disponibilidaddis = $fila_rc['DISPONIBILIDAD'];
						$colordis = $fila_rc['COLOR'];
									$fechadias = date("Y-m-d", strtotime($fechadis));
					// ACA COMIENZA A CREAR LOS BOTONES						  
					if ($contador >= $num1cont and $contador <= $num2cont2){ 
				
						if ($contador == $num1cont){ #echo "<tr>";
						}
						for ($col=$numcolumn; $col<=($numcolumn); $col++)
						{	
					
						if ( $contador == $num1cont) {  
						
							echo "<tr><td  width='110' height='30px' align='center'> 
								  <p ALIGN=center style='font-size: 16px'>$fechadias</p>
								  </td>";
								}							
									$descripcion =  $fechadias . "-" . $franjadias;
									
									echo "<td  WIDTH='80' height='30px' align='center'>";	
									boton ($descripcion, $disponibilidaddis, 78, 77, $colordis, $fechaini,  $fechadias, $franjadias, $estado, $fechaAgendada, $franjaAgendada, $observaciones, $unidadoperativa, $unidadoperagendada, $descunidadoperagendada); 
									echo "</td>";
													
																								
						} $contador = $contador + 1;							
						if ($contador == $num2cont2){  
					
						}
				
					}
					if ($contador == ($num2cont2+1) ){$num1cont = $num1cont + 6;
										   $num2cont2 = $num2cont2 + 6; $numcolumn= $numcolumn + 1; echo "</tr>";}
									   // ACA FINALIZA DE CREAR LOS BOTONES												
						}
					oci_free_statement($rc);
				}
			}else{
	         #Fin RQ-629784
				$stid=EjecutaRefCursor2($LST_DSPONIBILIDAD, $conexion, 4, $nuLocalidad, $unidadoperativa, $nuGrupoTarea, $fechaini, Null, NULL, NULL, NULL);
				while (($fila = oci_fetch_array($stid, OCI_ASSOC))) {
				$rc = $fila['DATA'];
				oci_execute($rc);  // el valor de la columna devuelta por la consulta es un ref cursor
				while (($fila_rc = oci_fetch_array($rc, OCI_ASSOC))) {
				
				$fechadis = $fila_rc['FECHA'];
				$capacidaddis = $fila_rc['CAPACIDAD'];
				$franjadias = $fila_rc['FRANJA'];
				$ocupadosdis = $fila_rc['OCUPADOS'];
				$disponibilidaddis = $fila_rc['DISPONIBILIDAD'];
				$colordis = $fila_rc['COLOR']; 
            
            
				$fechadias = date("Y-m-d", strtotime($fechadis));
					// ACA COMIENZA A CREAR LOS BOTONES						  
					if ($contador >= $num1cont and $contador <= $num2cont){ 
				
						if ($contador == $num1cont){ #echo "<tr>";
						}
						for ($col=$numcolumn; $col<=($numcolumn); $col++)
						{	
					
						if ( $contador == $num1cont) {  
						
							echo "<tr><td  width='110' height='30px' align='center'> 
								  <p ALIGN=center style='font-size: 16px'>$fechadias</p>
								  </td>";
								}							
									$descripcion =  $fechadias . "-" . $franjadias;
									
									echo "<td  WIDTH='80' height='30px' align='center'>";	
									boton ($descripcion, $disponibilidaddis, 78, 77, $colordis, $fechaini,  $fechadias, $franjadias, $estado, $fechaAgendada, $franjaAgendada, $observaciones, $unidadoperativa, $unidadoperagendada, $descunidadoperagendada); 
									echo "</td>";
													
																								
						} $contador = $contador + 1;							
						if ($contador == $num2cont){  
					
						}
				
					}
					if ($contador == ($num2cont+1) ){$num1cont = $num1cont + 3;
										   $num2cont = $num2cont + 3; $numcolumn= $numcolumn + 1; echo "</tr>";}
									   // ACA FINALIZA DE CREAR LOS BOTONES												
						}
					oci_free_statement($rc);
					} echo "</tr>"; echo "</table>\n";
			}   					
            				?>
        </td>					
        </tr>
        </table>
        </td>					
        </tr>
        </dt>	
        </tr>
        </table>						   	                     
        </tr>
        </dt>						
        </table>
    </div>
    <script>
        function abririncumplidas(){
        var codigo = <?php echo $codigo; ?>;
        window.open("../agenda/incumplidas.php?id="+codigo,"incumplidas","width=1030,height=300,scrollbars=SI");
        }
    </script>
    <?php
        }
        //ACA CIERRA LA VALIDACION DE QUE EL REGISTRO ESTE BLOQUEADO
        }else{
        
        	echo ("DEBES LOGEARTE !!")	?><script>
        window.location='../index.php';
    </script>
    <?php
        }
        ?>


		  
