<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrar</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php
        require "enviroment.php";
        $selectedProduct = $_GET['id'];
        if ($selectedProduct != '') {
            $result = $conecction->query(
                "DELETE FROM productos
                WHERE id = $selectedProduct");
            print_r("
                <p>El producto con código $selectedProduct ha sido borrado</p>
                <a href='listado.php'>Volver</a>
            ");
        } else{
            header('Location:listado.php');
        }
    ?>
</body>
</html>