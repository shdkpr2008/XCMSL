<?php
session_start();
if(!(isset($_SESSION['login_i'])) && !($_SESSION['login_i']==true))
{
    header('location: ./login.php');
}

include 'php/conexion.php';
?>

<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Registrar Evento</title>

        <link rel="stylesheet" type="text/css" href="css/materialize.min.css">
        <link rel="stylesheet" type="text/css" href="css/materialize.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

        <script type="text/javascript">
            $('.chips').material_chip();
        </script>

        <style type="text/css">
            #btnsumib{
             background-color: #000 !important;

            }
            #btnsumibr{
             background-color: #e65100 !important;
            }
            ul:not(.browser-default) {
                padding-right: 0px;
                list-style-type: none;
            }
        </style>
    </head>

    <body>
        <?php
        include 'nav.php'
        $principal= $_SESSION['username'];
        include ('php/conexion.php');
        $SQL="select * from admin where username like '$principal'";
        $resultado = $conexion->query($SQL);
        $ROW = $resultado->fetch_array(MYSQLI_ASSOC)   ;
        $id_G=$ROW["id"];
        ?>

        <br><br>
        <center><span ><h4 class="flow-text"> Registrar Evento</h4> </span></center>

         <form action="php/conex_clases.php" method="POST" enctype="multipart/form-data" >
            <div class="card-panel teal transparent">
            <div id="contenformm">
            <div class="row">

            <div  class="col s4"> </div>

            <div class="col s4">

                <div class="row">
                       <div class="input-field col s12">
                      <label for="email" data-error="wrong" data-success="right">Nombre</label>
                      <input type="text"  class="validate" id="Log entry" name="nombre" required/>
                        </div>
                    </div>

                        <input name="id_general" value="<?php echo $id_G ?> " type="hidden">

                    <div class="row">
                        <label for="email" data-error="wrong" data-success="right">Ministerio</label>
                        <select name="ministerio">
                            <option></option>
                            <?php	$sql="select * from paquetes where id_general like '$id_G' order by name";
                                $result = $conexion->query($sql);
                                while($row = $result->fetch_array(MYSQLI_ASSOC)){
                                    echo "<option>".$row["log_entry"]."</option>";
                                }
                              ?>
                         </select>
                    </div>

                    <div class="row">
                        <label for="email" data-error="wrong" data-success="right">Maestros</label>
                        <select name="maestros">
                            <option value=""></option>
                            <?php
                                $sql2="select * from empleados where id_general like '$id_G' order by name";
                                $result2 = $conexion->query($sql2);
                                while($row2 = $result2->fetch_array(MYSQLI_ASSOC)){
                                $num = $result2->num_rows;

                                $nombre= $row2["name"].' '.$row2["apellido"];

                                echo "<p>
                                <input id='test".$row2["id"]."' type='checkbox' name='lideres[]' value='".$nombre."' />
                                <label value='".$nombre."' for='test".$row2["id"]."'>".$nombre."</label></p>";
                                }
                                ?>
                        </select>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <label for="email" data-error="wrong" data-success="right">Fecha</label>
                            <input id="skids"  type="date" name="fecha" class="datepicker" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                           <label for="email" data-error="wrong" data-success="right">Horario</label>
                          <input id="skids"  type="text" name="hora" class="validate" />
                      </div>
                    </div>


                    <div class="row">
                        <div id="salones" class="input-field col s12">
                            <label  id="salones" for="email" data-error="wrong" data-success="right">Salones</label>
                            <input class="validate" type="text" name="salones" id="numberofpieces" />
                        </div>
                    </div>
                <br>
                <div class="row">
                    <div class="col s6">
                            <button id="btnsumib" class="btn waves-effect waves-light" type="submit" name="submit">Enviar
                        <i class="material-icons right">send</i>
                        </button>
                    </div>
                </div>
          </div>
        </div>
        </div>
        </form>

        <script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
        <script type="text/javascript" src="js/materialize.min.js"></script>

        <script type="text/javascript">
        $('.datepicker').pickadate({
            selectMonths: true, // Creates a dropdown to control month
            selectYears: 30, // Creates a dropdown of 15 years to control year
            labelMonthNext: 'Go to the next month',
            labelMonthPrev: 'Go to the previous month',
            labelMonthSelect: 'Pick a month from the dropdown',
            labelYearSelect: 'Pick a year from the dropdown',
            format: 'mm-dd-yyyy'
        });
        </script>

        <script type="text/javascript">
        $(document).ready(function() {
            $('select').material_select();
        });
        </script>

    </body>
</html>
