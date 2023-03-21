<?php
session_start();
if (!isset($_SESSION['Usuario'])) {
  header("Location:../index.php");
} else {
  if ($_SESSION['Usuario'] == "ok") {
    $nombreUsuario = $_SESSION["nombreUsuario"];
  }
}
?>

<!doctype html>
<html lang="en">

<head>
  <title>ACTIVOS - HOSPITAL DE CLINICAS</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body> <!-- aqui abajo el nombre el servidor del sitio web -->




  <style>
    body {
      background-color: #6DE35D;
      background-repeat: no-repeat;
      background-size: cover;
    }

    .navbar {
      background-color: #E8F0E7;
      font-size: 22px;
      font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
      font-size: 22px;
      border-radius: 18px;

    }
  </style>

  <?php $url = "http://" . $_SERVER['HTTP_HOST'] . "/activos" ?>
  <div class="container-fluid"><br>
    <div class="row">

      
        <div class="col-md-3"></div>
      
        <div class="col-md-6 ">
          <nav class="navbar navbar-expand-lg navbar navbar  ">
            <div class="container-fluid ">
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>

              <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                <ul class="navbar-nav  me-auto mb-2 mb-lg-0  ">
                  <li class="nav-item">
                    <a class="nav-item nav-link  " href="<?php echo $url; ?>/inicio.php"">Inicio<span class=" sr-only">(current)</span></a>
                  </li>

                  <li class="nav-item">
                    <a class="nav-item nav-link " href="<?php echo $url; ?>/seccion/activosfijos.php"> Activos fijos</a>
                  </li>

                  <li class="nav-item">
                    <a class="nav-item nav-link " href="<?php echo $url; ?>/seccion/registrar.php">Registrar Activos</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-item nav-link text-dark" href="<?php echo $url; ?>/seccion/Unidades.php">Unidades</a>
                  </li>

                  <li class="nav-item">
                    <a class="nav-item nav-link " href="<?php echo $url; ?>/seccion/Administradores.php">Administradores</a>
                  </li>
                </ul>
              </div>
            </div>
          </nav>

        </div>

      </div></br>

      <div class="col-md-3"></div>

      <div class="container-fluid">

        <div class="row">