<?php include("template/cabecera.php"); ?>


<div class="col-md-12">
  <style>
    
    div.jumbotron {

      background-image: url("");
      background-repeat: no-repeat;
      background-size: cover;

    }

    h1.display-2 {

      color: #400C0C;
      font-size: 60px;
      font-family:Georgia, 'Times New Roman', Times, serif;

    }

    p.lead1 {
      background: #7DD99D;
      color: black;
      font-size: 27px;
      font-family: Georgia, 'Times New Roman', Times, serif;
    }

    p.lead {
      font-size: 25px;
      font-family: Georgia, 'Times New Roman', Times, serif;
    }
  </style>

  <center>
  <div class="col-md-1"></div>
  <div class="col-md-10">
      <h1 class="display-2">BIENVENIDO AL SISTEMA</h1>

      <p class="lead1">El hospital de clinicas aplico la tecnologia RFID para poder mantener un control eficiente sobre sus activos fijos, de tal manera nos ponemos a la altura de la inovaciocion tecnologica.</p>
     </center>
  <hr class="my-2">
  <div class="col-md-1"></div></div>
    <div class="col-md-1"></div>
<div class="col-md-5">
  <p><strong>Secciones:</strong></p>
  <p class="lead">
    <a class="btn btn-secondary btn-block" href="seccion/activosfijos.php" role="button"><strong>ACTIVOS FIJOS</strong></a>
  </p>
  <br>
  <p class="lead">
    <a class="btn btn-success btn-block" href="seccion/registrar.php" role="button"><strong>REGISTRAR ACTIVOS</strong></a>
  </p><br>
  <p class="lead">
    <a class="btn btn-danger btn-block" href="" role="button"><strong>REGISTRAR ACTIVOS</strong></a>
  </p>
  <br>
  <p class="lead">
    <a class="btn btn-primary btn-block" href="" role="button"><strong>ACTIVOS FIJOS</strong></a>
  </p>
</div>

<div class="col-md-5">
  <img src="imagenes/inicios.PNG" alt="" class="img-fluid">
</div><div class="col-md-1"></div>



<?php include("template/pie.php"); ?>