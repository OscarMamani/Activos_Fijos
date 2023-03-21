<?php

use JetBrains\PhpStorm\Deprecated;

include("../template/cabecera.php"); ?>

<?php
include("../config/bd.php");


?>

<style>
    body {
        background-color: #9EDAF9;
        background-repeat: no-repeat;
        background-size: cover;

    }

    #imagenes_edit {
        width: 480px;
        height: 330px;
        object-fit: cover;
        border-radius: 28px;

    }

    .card {
        box-shadow: 10px 5px 5px #BFBFBF;
        border-radius: 18px;
        background-color: #31F767;
    }

    .navbar {
        background-color: #F0F0EE;
        color: #2EB099;
        border-radius: 18px;


    }

    #titulo {
        color: #242B29;
        font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
        text-align: center;
        font-size: 50px;

    }
</style>

<h1 id="titulo">Activos fijos de la institución</h1>
<div class="container-fluid">

    <div class="row">




        <?php
        /*conectar a la base de datos para mostrar*/
        $sentenciaSQL = $conexion->prepare("SELECT IMAGEN FROM equipos WHERE ID=:ID");
        $sentenciaSQL->bindParam(':ID', $txtID);
        $sentenciaSQL->execute();
        $equipo = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

        $sentenciaSQL = $conexion->prepare("SELECT * FROM equipos");
        $sentenciaSQL->execute();
        $listaequipos = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);




        foreach ($listaequipos as $equipo) { ?>
            <div class="col-md-4">
                <div class="card text-bg mb-3 ">
                    <img src="../imagenes/<?php echo $equipo['IMAGEN']; ?>" class="img rounded img-thumbnail" id="imagenes_edit">
                    <div class="card-body">
                        <p class="card-text"> <b>Tipo de Equipo: </b> <?php echo $equipo['TIPO']; ?></p>
                        <p class="card-text"> <b>Precio de Equipo: </b> <?php echo $equipo['PRECIO']; ?></p>
                        <p class="card-text"> <b>Especificaciones: </b> <?php echo $equipo['ESPECIFICACIONES']; ?></p>
                        <p class="card-text"> <b>Area designada: </b> <?php echo $equipo['AREA']; ?></p>
                        <p class="card-text"> <b>Fecha de Ingreso: </b> <?php echo $equipo['FECHA_INGRESO']; ?></p>
                        <p class="card-text"> <b>Observaciones: </b> <?php echo $equipo['OBSERVACIONES']; ?></p>
                        <p class="card-text"> <b>Depreciacion Anual: </b><?php

                                                                            $tipo = $equipo['TIPO'];
                                                                            $Precio = $equipo['PRECIO'];
                                                                            $Resultado = 0;
                                                                            
                                                                                    if ($tipo == 'Maquina') {
                                                                                        $ResultadoF = number_format($Resultado = (($Precio - 0.125) / 8), 2);
                                                                                        echo ($ResultadoF);
                                                                                        
                                                                                    } 
                                                                                    else if($tipo == 'Equipo de computación') {
                                                                                        $ResultadoN = number_format($Resultado = (($Precio - 0.1) / 10), 2);
                                                                                        echo ($ResultadoN);
                                                                                    }   
                                                                                    else if($tipo == 'Enseres de oficina') {
                                                                                         $ResultadoM = number_format($Resultado = (($Precio - 0.1) / 10), 2);
                                                                                         echo ($ResultadoM);
                                                                                        
                                                                                    }
                                                                                    else{
                                                                                        echo('aun faltas');

                                                                                    }
                                                                            
                                                                            ?></p>



                        </p>
                    </div>
                </div>
            </div>
        <?php  } ?>
    </div>


</div>

</div>




<?php include("../template/pie.php"); ?>