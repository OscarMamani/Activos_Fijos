<?php include("../template/cabecera.php"); ?>

<style>
    body {
        background-image: url("../../img/medicina-plana-sobre-fondo-azul_23-2149341570.jpg");
        background-repeat: no-repeat;
        background-size: cover;

    }
    #titulo{
        color: #FFFFFF;
        font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
        text-align: center;
        font-size: 58px;

    }
    body{
      background-color: #A2ECA3;
      background-repeat: no-repeat;
      background-size: cover;
      
    }
</style>
<?php

$txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : "";
$txtCID = (isset($_POST['txtCID'])) ? $_POST['txtCID'] : "";
$txtTipo = (isset($_POST['txtTipo'])) ? $_POST['txtTipo'] : "";
$txtPrecio = (isset($_POST['txtPrecio'])) ? $_POST['txtPrecio'] : "";
$txtEspecificaciones = (isset($_POST['txtEspecificaciones'])) ? $_POST['txtEspecificaciones'] : "";
$txtFecha = (isset($_POST['txtFecha'])) ? $_POST['txtFecha'] : "";
$txtArea = (isset($_POST['txtArea'])) ? $_POST['txtArea'] : "";
$txtEstado = (isset($_POST['txtEstado'])) ? $_POST['txtEstado'] : "";
$txtObservaciones = (isset($_POST['txtObservaciones'])) ? $_POST['txtObservaciones'] : "";
$txtImagen = (isset($_FILES['txtImagen']['name'])) ? $_FILES['txtImagen']['name'] : "";
$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";

include("../config/bd.php");

switch ($accion) {
    case "Agregar":
        $sentenciaSQL = $conexion->prepare("INSERT INTO equipos (CID_ACTIVO, TIPO, PRECIO, ESPECIFICACIONES, FECHA_INGRESO, AREA, ESTADO, OBSERVACIONES, IMAGEN) VALUES (:CID_ACTIVO,:TIPO, :PRECIO, :ESPECIFICACIONES, :FECHA_INGRESO, :AREA, :ESTADO, :OBSERVACIONES, :IMAGEN);");

        $sentenciaSQL->bindParam(':CID_ACTIVO', $txtCID);
        $sentenciaSQL->bindParam(':TIPO', $txtTipo);
        $sentenciaSQL->bindParam(':PRECIO', $txtPrecio);
        $sentenciaSQL->bindParam(':ESPECIFICACIONES', $txtEspecificaciones);
        $sentenciaSQL->bindParam(':FECHA_INGRESO', $txtFecha);
        $sentenciaSQL->bindParam(':AREA', $txtArea);
        $sentenciaSQL->bindParam(':ESTADO', $txtEstado);
        $sentenciaSQL->bindParam(':OBSERVACIONES', $txtObservaciones);

        $fecha = new DateTime();
        $nombreArchivo = ($txtImagen != "") ? $fecha->getTimestamp() . "_" . $_FILES["txtImagen"]["name"] : "imagen.jpg";
        $tmpImagen = $_FILES["txtImagen"]["tmp_name"];

        if ($tmpImagen != "") {
            move_uploaded_file($tmpImagen, "../imagenes/" . $nombreArchivo);
        }

        $sentenciaSQL->bindParam(':IMAGEN', $nombreArchivo);
        $sentenciaSQL->execute();
        header("Location:registrar.php");
        break;

    case "Modificar":
        $sentenciaSQL = $conexion->prepare("UPDATE  equipos SET CID_ACTIVO=:CID_ACTIVO WHERE ID=:ID");
        $sentenciaSQL->bindParam(':CID_ACTIVO', $txtCID);
        $sentenciaSQL->bindParam(':ID', $txtID);
        $sentenciaSQL->execute();

        $sentenciaSQL = $conexion->prepare("UPDATE  equipos SET TIPO=:TIPO WHERE ID=:ID");
        $sentenciaSQL->bindParam(':TIPO', $txtTipo);
        $sentenciaSQL->bindParam(':ID', $txtID);
        $sentenciaSQL->execute();

        $sentenciaSQL = $conexion->prepare("UPDATE  equipos SET PRECIO=:PRECIO WHERE ID=:ID");
        $sentenciaSQL->bindParam(':PRECIO', $txtPrecio);
        $sentenciaSQL->bindParam(':ID', $txtID);
        $sentenciaSQL->execute();

        $sentenciaSQL = $conexion->prepare("UPDATE  equipos SET ESPECIFICACIONES=:ESPECIFICACIONES WHERE ID=:ID");
        $sentenciaSQL->bindParam(':ESPECIFICACIONES', $txtEspecificaciones);
        $sentenciaSQL->bindParam(':ID', $txtID);
        $sentenciaSQL->execute();

        $sentenciaSQL = $conexion->prepare("UPDATE  equipos SET FECHA_INGRESO=:FECHA_INGRESO WHERE ID=:ID");
        $sentenciaSQL->bindParam(':FECHA_INGRESO', $txtFecha);
        $sentenciaSQL->bindParam(':ID', $txtID);
        $sentenciaSQL->execute();

        $sentenciaSQL = $conexion->prepare("UPDATE  equipos SET AREA=:AREA WHERE ID=:ID");
        $sentenciaSQL->bindParam(':AREA', $txtArea);
        $sentenciaSQL->bindParam(':ID', $txtID);
        $sentenciaSQL->execute();

        $sentenciaSQL = $conexion->prepare("UPDATE  equipos SET ESTADO=:ESTADO WHERE ID=:ID");
        $sentenciaSQL->bindParam(':ESTADO', $txtEstado);
        $sentenciaSQL->bindParam(':ID', $txtID);
        $sentenciaSQL->execute();

        $sentenciaSQL = $conexion->prepare("UPDATE  equipos SET OBSERVACIONES=:OBSERVACIONES WHERE ID=:ID");
        $sentenciaSQL->bindParam(':OBSERVACIONES', $txtObservaciones);
        $sentenciaSQL->bindParam(':ID', $txtID);
        $sentenciaSQL->execute();

        if ($txtImagen != "") {
            $fecha = new DateTime();
            $nombreArchivo = ($txtImagen != "") ? $fecha->getTimestamp() . "_" . $_FILES["txtImagen"]["name"] : "imagen.jpg";
            $tmpImagen = $_FILES["txtImagen"]["tmp_name"];
            move_uploaded_file($tmpImagen, "../imagenes/" . $nombreArchivo);

            //borrar la anterior imagen:
            $sentenciaSQL = $conexion->prepare("SELECT IMAGEN FROM equipos WHERE ID=:ID");
            $sentenciaSQL->bindParam(':ID', $txtID);
            $sentenciaSQL->execute();
            $equipo = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

            if (isset($equipo["IMAGEN"]) && ($equipo["IMAGEN"] != "imagen.jpg")) {

                if (file_exists("../imagenes/" . $equipo["IMAGEN"])) {
                    unlink("../imagenes/" . $equipo["IMAGEN"]);
                }
            }

            $sentenciaSQL = $conexion->prepare("UPDATE  equipos SET IMAGEN=:IMAGEN WHERE ID=:ID");
            $sentenciaSQL->bindParam(':IMAGEN', $nombreArchivo);
            $sentenciaSQL->bindParam(':ID', $txtID);
            $sentenciaSQL->execute();
        }
        header("Location:registrar.php");
        break;

    case "Cancelar":
        header("Location:registrar.php");

        break;

    case "Seleccionar":
        //PRESIONA BOTON SELECCIONAR
        $sentenciaSQL = $conexion->prepare("SELECT * FROM equipos WHERE ID=:ID");
        $sentenciaSQL->bindParam(':ID', $txtID);
        $sentenciaSQL->execute();
        $equipo = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

        $txtCID = $equipo['CID_ACTIVO'];
        $txtTipo = $equipo['TIPO'];
        $txtPrecio = $equipo['PRECIO'];
        $txtEspecificaciones = $equipo['ESPECIFICACIONES'];
        $txtFecha = $equipo['FECHA_INGRESO'];
        $txtArea = $equipo['AREA'];
        $txtEstado = $equipo['ESTADO'];
        $txtObservaciones = $equipo['OBSERVACIONES'];
        $txtImagen = $equipo['IMAGEN'];

        break;
    case "Borrar":

        $sentenciaSQL = $conexion->prepare("SELECT IMAGEN FROM equipos WHERE ID=:ID");
        $sentenciaSQL->bindParam(':ID', $txtID);
        $sentenciaSQL->execute();
        $equipo = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

        if (isset($equipo["IMAGEN"]) && ($equipo["IMAGEN"] != "imagen.jpg")) {

            if (file_exists("../imagenes/" . $equipo["IMAGEN"])) {
                unlink("../imagenes/" . $equipo["IMAGEN"]);
            }
        }

        $sentenciaSQL = $conexion->prepare("DELETE FROM equipos WHERE ID=:ID");
        $sentenciaSQL->bindParam(':ID', $txtID);
        $sentenciaSQL->execute();
        header("Location:registrar.php");
        break;
}

$sentenciaSQL = $conexion->prepare("SELECT * FROM equipos");
$sentenciaSQL->execute();
$listaequipos = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

?>
<h1 id="titulo">Registro de Activos Fijos</h1>
<div class="col-md-4">
    <a name="adicionar" class="btn btn-success" href="#AUMENTAR" role="button">AGREGAR EQUIPOS</a><br>
</div>
<div class="col-md-8"> </div>
<br>
<div class="col-md-12"><br>
    <table class="table table-dark table-striped table-hover ">
        <thead>
            <tr>
                <th>ID</th>
                <th>C.RFID</th>
                <th>TIPO</th>
                <th>PRECIO</th>
                <th>ESPECIFICACIONES</th>
                <th>FECHA DE INGRESO</th>
                <th>AREA</th>
                <th>ESTADO</th>
                <th>OBSERVACIONES</th>
                <th>IMAGEN</th>
                <th>ACCIONES</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($listaequipos as $equipo) { ?>
                <tr>
                    <td><?php echo $equipo['ID']; ?></td>
                    <td><?php echo $equipo['CID_ACTIVO']; ?></td>
                    <td><?php echo $equipo['TIPO']; ?></td>
                    <td><?php echo $equipo['PRECIO']; ?></td>
                    <td><?php echo $equipo['ESPECIFICACIONES']; ?></td>
                    <td><?php echo $equipo['FECHA_INGRESO']; ?></td>
                    <td><?php echo $equipo['AREA']; ?></td>
                    <td><?php echo $equipo['ESTADO']; ?></td>
                    <td><?php echo $equipo['OBSERVACIONES']; ?></td>
                    <td> <img class="img rounded" src="../imagenes/<?php echo $equipo['IMAGEN']; ?>" width="300" alt=""> </td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="txtID" value="<?php echo $equipo['ID']; ?>" id="txtID">
                            <input type="submit" name="accion" value="Seleccionar" class="btn btn-success" />
                            <input type="submit" name="accion" value="Borrar" class="btn btn-danger" />

                        </form>
                    </td>

                </tr>
            <?php  } ?>
        </tbody>
    </table>

</div>

<div class="col-md-2"></div>
<div class="col-md-8">

    <div class="card">
        <div class="card-header" id="AUMENTAR">
            <center><strong>Agregar equipos</strong></center>
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="txtID"> ID del equipo:</label>
                    <input type="text" required readonly class="form-control" value="<?php echo $txtID ?>" name="txtID" id="txtID" placeholder="Codigo ID">
                </div>

                <div class="form-group">
                    <label for="txtCID"> Codigo RFID: </label>
                    <input type="text" required class="form-control" value="<?php echo $txtCID ?>" name="txtCID" id="txtCID " placeholder="Codigo de identificacion RFID">
                </div>

                <div class="form-group">
                    <label for="txtTipo"> Tipo de equipo: </label>
                    <input type="text" required class="form-control" value="<?php echo $txtTipo ?>" name="txtTipo" id="txtTipo " placeholder="Tipo de equipo">
                </div>

                <div class="form-group">
                    <label for="txtTipo"> Precio del equipo: </label>
                    <input type="number" required class="form-control" step="any" value="<?php echo $txtPrecio?>" name="txtPrecio" id="txtPrecio " placeholder="Precio de equipo">
                </div>

                <div class="form-group ">
                    <label for="txtEspecificaciones "> Especificaciones: </label>
                    <input type="text" required class="form-control" value="<?php echo $txtEspecificaciones ?>" name="txtEspecificaciones" id="txtEspecificaciones " placeholder="Especificaciones del equipo">
                </div>

                <div class="form-group ">
                    <label for="txtFecha"> Fecha de ingreso: </label>
                    <input type="date" required class="form-control" value="<?php echo $txtFecha ?>" name="txtFecha" id="txtFecha " placeholder="Detalles del ingresa">
                </div>

                <div class="form-group ">
                    <label for="txtArea"> Area: </label>
                    <input type="text" required class="form-control" value="<?php echo $txtArea ?>" name="txtArea" id="txtArea " placeholder="Area designada">
                </div>

                <div class="form-group ">
                    <label for="txtEstado"> Estado: </label>
                    <input type="text" required class="form-control" value="<?php echo $txtEstado ?>" name="txtEstado" id="txtEstado " placeholder="estado deL equipo">
                </div>

                <div class="form-group ">
                    <label for="txtObservaciones"> Observaciones: </label>
                    <input type="text" required class="form-control" value="<?php echo $txtObservaciones ?>" name="txtObservaciones" id="txtObservaciones " placeholder="observaciones">
                </div>


                <div class="form-group ">
                    <label for="file"> Imagen: </label>

                    <?php if ($txtImagen != "") { ?>

                        <img class="img-thumbnail rounded" src="../imagenes/<?php echo $txtImagen; ?>" width="80" alt="">

                    <?php } ?>

                    <input type="file" class=" form-control" value="<?php echo $txtImagen ?>" name="txtImagen" id="txtImagen" placeholder="">
                </div>

                <div class="btn-group" role="group" aria-label="">
                    <button type="submit" name="accion" <?php echo ($accion == "Seleccionar") ? "disabled" : "" ?> value="Agregar" class="btn btn-success"> Agregar</button>
                    <button type="submit" name="accion" <?php echo ($accion != "Seleccionar") ? "disabled" : "" ?> value="Modificar" class="btn btn-dark"> Modificar</button>
                    <button type="submit" name="accion" <?php echo ($accion != "Seleccionar") ? "disabled" : "" ?> value="Cancelar" class="btn btn-danger"> Cancelar</button>
            </form>

        </div>
    </div>

</div>


<div class="col-md-2"></div><br><br>


<?php include("../template/pie.php"); ?>