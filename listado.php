<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de productos</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <main>
        <h1>Gestión de productos</h1>
        <a class="button createButton" href="crear.php">Añadir producto</a>
        <div class="products__table">
            <div class="products__table__header products__table__row">
                <div>Detalles</div>
                <div>Código</div>
                <div>Nombre</div>
                <div>Acciones</div>
            </div>
            <?php
                require "enviroment.php";
                $result = $conecction->query("SELECT * FROM productos");
                while($products = $result->fetch(PDO::FETCH_OBJ)){
                    print_r("
                    <div class='products__table__row'>
                        <div class='products__table__col'> <a class='button detailsButton' href='detalles.php?id=$products->id'> Detalles </a> </div>
                        <div class='products__table__col'>$products->id </div>
                        <div class='products__table__col'>$products->nombre </div>
                        <div class='products__table__col'>
                            <a class='button deleteButton' href='borrar.php?id=$products->id'> Borrar </a>
                            <a class='button updateButton' href='crear.php?id=$products->id&update=true'> Actualizar </a>
                            <a class='button updateButton' href='mueveStock.php?id=$products->id&update=true'> Mover stock </a>
                        </div>
                    </div>");
                }
            ?>
        </div>
    </main>
</body>
</html>