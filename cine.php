<?php
$nombre=$_POST['nombre'];
$pelicula=$_POST['pelicula'];
$sala=$_POST['sala'];
$num_boletos=$_POST['boletos'];
$lleva_niños=$_POST['niños'];
if($lleva_niños=="no"){
    $boletos_niños = 0;
}else{
    $boletos_niños = (int)$_POST['cuantos'];
}

$num_boletos = (int)$num_boletos;
$boletos_adultos = $num_boletos - $boletos_niños;
if($boletos_adultos < 0) $boletos_adultos = 0;

$iva = 0.16;

// Definir precio según sala
if($sala == "normal") {
    $precio_boleto = 75;
} elseif ($sala == "3D") {
    $precio_boleto = 110;
} elseif($sala == "vip") {
    $precio_boleto = 146;
} else {
    $precio_boleto = 0;
}

$subtotal_nino=$boletos_niños* $precio_boleto;
$subtotal_adulto=$boletos_adultos*$precio_boleto;
$total=$subtotal_nino+$subtotal_adulto;

$subtotal_sin_iva = round($total / (1 + $iva), 2);
$total_iva = round($total - $subtotal_sin_iva, 2);

switch($pelicula){
    case "inception":
        $imagen_pelicula = "img5/inception.png";
        break;
    case "avatar":
        $imagen_pelicula = "img5/avatar.jpg";
        break;
    case "gladiador":
        $imagen_pelicula = "img5/gladiador.jpg";
        break;
    case "matrix":
        $imagen_pelicula = "img5/matrix.png";
        break;
    case "titanic":
        $imagen_pelicula = "img5/titanic.jpg";
        break;
    case "jurassic":
        $imagen_pelicula = "img5/jurassic.jpg";
        break;
    case "up":
        $imagen_pelicula = "img5/up.jpg";
        break;
    case "parásitos":
        $imagen_pelicula = "img5/parasitos.jpg";
        break;
    case "spiderman":
        $imagen_pelicula = "img5/spiderman.jpg";
        break;
    case "batman":
        $imagen_pelicula = "img5/batman.jpg";
        break;
    default:
        $imagen_pelicula = "img5/default.jpg";
        break;
}


$conexion = new mysqli("localhost", "root", "", "cine");
$consulta = "INSERT INTO pelicula (nombre, pelicula, sala, num_boletos, boleto_ad, boleto_ni,total,iva,sub_total,lleva_ninos) VALUES ('$nombre', '$pelicula', '$sala', '$num_boletos', '$boletos_adultos', '$boletos_niños', '$total', '$total_iva', '$subtotal_sin_iva', '$lleva_niños')";
$registro = $conexion->query($consulta);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Ticket Cine</title>
<style>
body {
    margin:0;
    font-family: 'Poppins', sans-serif;
    background: radial-gradient(circle at top, #0d0d0d, #1a1a1a 80%);
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:100vh;
    color:#fff;
}

.ticket {
    width:380px;
    background:#141414;
    border-radius:20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.6);
    overflow:hidden;
    border:3px solid #e50914;
    padding:18px;
    position:relative;
}

.ticket-header {
    display:flex;
    align-items:center;
    justify-content:space-between;
    margin-bottom:14px;
}

.logo-cine {
    height:55px;
    width:auto;
    border-radius:10px;
}

.cinename {
    font-size:20px;
    font-weight:bold;
    color:#e50914;
    text-align:center;
    flex:1;
    margin:0 12px;
    letter-spacing:1px;
    text-shadow:0 0 10px #e50914;
}

.info {
    font-size:11px;
    color:#aaa;
    text-align:right;
    line-height:1.3;
}

.imagen-pelicula {
    width:100%;
    border-radius:12px;
    margin-bottom:14px;
    box-shadow:0 6px 18px rgba(0,0,0,0.4);
    border:2px solid #e50914;
}

.body {
    font-size:13px;
    line-height:1.7;
    color:#eee;
    background:#1e1e1e;
    padding:10px;
    border-radius:10px;
    border-left:4px solid #e50914;
}

.body strong {
    color:#e50914;
}

.totals {
    margin-top:14px;
    display:flex;
    justify-content:space-between;
    font-weight:bold;
    border-top:2px dashed #e50914;
    padding-top:10px;
    font-size:12px;
    text-transform:uppercase;
    color:#f2f2f2;
}

.barcode {
    margin-top:18px;
    height:45px;
    background: repeating-linear-gradient(90deg, #fff 0 2px, #000 2px 6px);
    border-radius:5px;
}

@media (max-width:420px){
    .ticket{ width:90%; padding:14px; }
    .logo-cine{ height:40px; }
}
</style>
</head>
<body>

<div class="ticket">
    <div class="ticket-header">
        
    </div>

    <img src="<?php echo $imagen_pelicula; ?>" alt="Película" class="imagen-pelicula">

    <div class="body">
        <?php
        echo "<strong>Datos del cliente:</strong><br>";
        echo " Nombre: <strong>$nombre</strong><br>";
        echo "Película: <strong>$pelicula</strong><br>";
        echo " Sala: <strong>$sala</strong><br>";
        echo " Boletos: <strong>$num_boletos</strong><br>";
        echo " Niños: <strong>$boletos_niños</strong><br>";
        echo " Adultos: <strong>$boletos_adultos</strong><br>";
        echo " Precio boleto: <strong>$precio_boleto</strong><br>";
        echo " Subtotal sin IVA: <strong>$subtotal_sin_iva</strong><br>";
        echo " IVA: <strong>$total_iva</strong><br>";
        echo " Total: <strong>$total</strong><br>";
        ?>
    </div>

    <div class="totals">
        <div>GRACIAS POR PREFERIRNOS</div>
        <div>No reembolsable</div>
    </div>

    <div class="barcode"></div>
</div>

</body>
</html>
