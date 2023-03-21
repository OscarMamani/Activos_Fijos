<?php  include ("../template/cabecera.php");?>
<style>
      body{
        background-image:url("../../img/medicina-plana-sobre-fondo-azul_23-2149341570.jpg");
        background-repeat: no-repeat;
        background-size: cover;
      }
    </style>
<?php 

$txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
$txtNombre=(isset($_POST['txtNombre']))?$_POST['txtNombre']:"";
$txtDetalles=(isset($_POST['txtDetalles']))?$_POST['txtDetalles']:"";
$txtImagen=(isset($_FILES['txtImagen']['name']))?$_FILES['txtImagen']['name']:"";
$accion=(isset($_POST['accion']))?$_POST['accion']:"";


include ("../config/bd.php");

switch($accion){
    case "Agregar":
        case "Agregar":
            $sentenciaSQL=$conexion->prepare("INSERT INTO comunicaciones (Nombre, Detalles,Imagen) VALUES (:Nombre,:Detalles,:Imagen);");
            $sentenciaSQL->bindParam(':Nombre',$txtNombre);
            $sentenciaSQL->bindParam(':Detalles',$txtDetalles);

            $fecha=new DateTime();
            $nombreArchivo= ($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";
            $tmpImagen=$_FILES["txtImagen"]["tmp_name"];
    
            if ($tmpImagen!=""){
                move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);
            }
    
            $sentenciaSQL->bindParam(':Imagen',$nombreArchivo);
            $sentenciaSQL->execute(); 
            header("Location:comunicacion social.php");          
            break;

    case "Modificar":
        $sentenciaSQL=$conexion->prepare("UPDATE  comunicaciones SET Nombre=:Nombre WHERE ID=:ID");
        $sentenciaSQL->bindParam(':Nombre',$txtNombre);
        $sentenciaSQL->bindParam(':ID',$txtID);
        $sentenciaSQL->execute();

        $sentenciaSQL=$conexion->prepare("UPDATE  comunicaciones SET Detalles=:Detalles WHERE ID=:ID");
        $sentenciaSQL->bindParam(':Detalles',$txtDetalles);
        $sentenciaSQL->bindParam(':ID',$txtID);
        $sentenciaSQL->execute();

        if($txtImagen!=""){

                $fecha = new DateTime();
                $nombreArchivo = ($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";      
                $tmpImagen=$_FILES["txtImagen"]["tmp_name"];
                move_uploaded_file($tmpImagen, "../../img/".$nombreArchivo);
    
                $sentenciaSQL=$conexion->prepare("SELECT Imagen FROM comunicaciones WHERE ID=:ID");
                $sentenciaSQL->bindParam(':ID',$txtID);
                $sentenciaSQL->execute();
                $comunicacion= $sentenciaSQL->fetch(PDO::FETCH_LAZY);

            if( isset($comunicacion["Imagen"]) && ($comunicacion["Imagen"]!="imagen.jpg") ){

                if(file_exists("../../img/".$comunicacion["Imagen"])){
                    unlink("../../img/".$comunicacion["Imagen"]);

                }
            }



            $sentenciaSQL=$conexion->prepare("UPDATE  comunicaciones SET Imagen=:Imagen WHERE ID=:ID");
            $sentenciaSQL->bindParam(':Imagen',$nombreArchivo);
            $sentenciaSQL->bindParam(':ID',$txtID);
            $sentenciaSQL->execute();
        }
        header("Location:comunicacion social.php");
        break;

    case "Cancelar":
        header("Location:comunicacion social.php");
        
        break;
    case "Seleccionar":
              //PRESIONA BOTON SELECCIONAR
              $sentenciaSQL=$conexion->prepare("SELECT * FROM comunicaciones WHERE ID=:ID");
              $sentenciaSQL->bindParam(':ID',$txtID);
              $sentenciaSQL->execute();
              $comunicacion= $sentenciaSQL->fetch(PDO::FETCH_LAZY);
      
              $txtNombre =$comunicacion['Nombre'];
              $txtDetalles =$comunicacion['Detalles'];
              $txtImagen =$comunicacion['Imagen'];
      
      
        break;

    case "Borrar":
            //presiona boton borrar
           
            $sentenciaSQL=$conexion->prepare("SELECT Imagen FROM comunicaciones WHERE ID=:ID");
            $sentenciaSQL->bindParam(':ID',$txtID);
            $sentenciaSQL->execute();
            $comunicacion= $sentenciaSQL->fetch(PDO::FETCH_LAZY);

            if( isset($comunicacion["Imagen"]) && ($comunicacion["Imagen"]!="imagen.jpg") ){

                if(file_exists("../../img/".$comunicacion["Imagen"])){
                    unlink("../../img/".$comunicacion["Imagen"]);

                }
            }

            $sentenciaSQL= $conexion->prepare("DELETE FROM comunicaciones WHERE ID=:ID");
            $sentenciaSQL->bindParam(':ID',$txtID);
            $sentenciaSQL->execute();
            header("Location:comunicacion social.php");
        break;
}

$sentenciaSQL=$conexion->prepare("SELECT * FROM comunicaciones");
$sentenciaSQL->execute();
$listacomunicaciones= $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="col-md-4">
 
<div class="card">
    <div class="card-header">
        <strong>Comunicacion Social</strong>
    </div>
    <div class="card-body">

    <form method="POST" enctype="multipart/form-data">
        <div class = "form-group">
        <label for = "txtID"> ID:</label>
        <input type = "text" required readonly class = "form-control" value="<?php echo $txtID ?>" name ="txtID" id ="txtID" placeholder ="Codigo ID" >
        </div >

        <div class ="form-group">
        <label for="txtNombre"> Nombre: </label>
        <input type="text" required  class ="form-control" value="<?php echo $txtNombre ?>"name="txtNombre" id = "txtNombre" placeholder ="Titulo de la publicacion">
        </div>

        <div class ="form-group">
        <label for ="txtDetalles"> Detalles: </label>
        <input type ="text" required  class ="form-control" value="<?php echo $txtDetalles ?>" name="txtDetalles" id="txtDetalles" placeholder="Detalles de la publicacion">
        </div >

        <div class = "form-group">
        <label for = "file" > Imagen: </label>
        
        <?php if($txtImagen!=""){ ?>

             <img class="img-thumbnail rounded" src="../../img/<?php echo $txtImagen; ?>" width="80" alt="">
        
         <?php  }?>


        <input type = "file"   class = "form-control" value="<?php echo $txtImagen ?>" name="txtImagen" id ="txtImagen" placeholder="" >
        </div>

            <div class="btn-group" role="group">
            <button type="submit" name="accion" <?php echo ($accion=="Seleccionar")?"disabled":""?> value="Agregar" class="btn btn-success"> Agregar</button>
            <button type="submit" name="accion" <?php echo ($accion!="Seleccionar")?"disabled":""?> value="Modificar" class="btn btn-dark"> Modificar</button>
            <button type="submit" name="accion" <?php echo ($accion!="Seleccionar")?"disabled":""?> value="Cancelar" class="btn btn-danger"> Cancelar</button>
        </form>

    </div>
</div>





</div>

</div>
<div class="col-md-8">
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>NOMBRE</th>
            <th>DETALLES</th>
            <th>IMAGEN</th>
            <th>ACCIONES</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($listacomunicaciones as $comunicaciones){?>
        <tr>
            <td><?php echo $comunicaciones['ID']; ?></td>
            <td><?php echo $comunicaciones['Nombre']; ?></td>
            <td><?php echo $comunicaciones['Detalles']; ?></td>
            <td> <img class="img-thumbnail rounded" src="../../img/<?php echo $comunicaciones['Imagen']; ?>" width="80" alt=""></td>
            <td>
            <form method="post">
                    <input type="hidden" name="txtID" value="<?php echo $comunicaciones['ID']; ?>" id="txtID">
                    <input type="submit" name="accion" value="Seleccionar" class="btn btn-success" />
                    <input type="submit" name="accion" value="Borrar" class="btn btn-danger" />

                </form>
            </td>
        </tr>
        <?php  }?>
           
    </tbody>
</table>


</div>

<?php  include ("../template/pie.php");?>