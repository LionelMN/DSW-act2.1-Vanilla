<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <main>
        <div class="product__card">
            <?php
                require "enviroment.php";
                $selectedProduct = $_GET['id'];
                if ($selectedProduct != '') {
                    $result = $conecction->query(
                        "SELECT * FROM productos
                        WHERE id = $selectedProduct");
                    $product = $result->fetch(PDO::FETCH_OBJ);
                    if ($product->nombre != '') {
                        print_r("
                            <div class='card__header'>
                                <h1>$product->nombre</h1>
                            </div>
                            <div class='card__body'>
                                <p><span>Nombre completo:</span>$product->nombre</p>
                                <p><span>Nombre corto:</span> $product->nombre_corto</p>
                                <p><span>Código:</span> $product->id</p>
                                <p><span>Código familia:</span> $product->familia</p>
                                <p><span>PVP:</span> $product->pvp €</p>
                                <p><span>Descripción:</span> $product->descripcion</p>
                            </div>
                        ");
                    } else{
                        header('Location:listado.php');
                    }
                } else{
                    header('Location:listado.php');
                }
            ?>
            <div class="card__footer">
                <a href="listado.php">Volver</a>
            </div>
        </div>
    </main>
</body>
</html>