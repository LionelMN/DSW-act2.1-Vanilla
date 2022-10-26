<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mover stock</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <main>
        <?php
            require "enviroment.php";
            try{
                $id = $_GET['id'];
                $selectedProduct = $conecction->query(
                    "SELECT nombre FROM productos
                    WHERE id = $id"
                );
                $product = $selectedProduct->fetch(PDO::FETCH_OBJ);

                $stocks = $conecction->query(
                    "SELECT producto, tienda, unidades, nombre FROM stocks
                    INNER JOIN tiendas
                    ON tienda = id
                    where producto = $id"
                );
                while($stock = $stocks->fetch(PDO::FETCH_OBJ)){
                    $stores = $conecction->query(
                        "SELECT * FROM tiendas"
                    );
                    print_r("
                        <form action='mueveStock.php?id=$id' method='POST'>
                            <fieldset>
                                <legend><h2>Mover stock de $product->nombre</h2></legend>
                                <label for='tiendaActual'>Tienda actual</label>
                                <input type='text' id='tiendaActual' disabled value='$stock->nombre'>
                                <input type='text' name='tiendaActual' id='tiendaActual' hidden value='$stock->tienda'>
                                <label for='stockActual'>Stock actual</label>
                                <input type='number' name='' id='stockActual' disabled value=$stock->unidades>
                                <input type='number' name='stockActual' id='stockActual' hidden value=$stock->unidades>
                                <label for='selectTienda'>Tienda de destino</label>
                                <select name='selectTienda' id='selectTienda'>
                    ");
                    while($store = $stores->fetch(PDO::FETCH_OBJ)){
                        if($store->id != $stock->tienda){
                            print_r("
                                    <option value='$store->id'>$store->nombre</option>
                            ");
                        }
                    }
                    print("
                                </select>
                                <label for='cantidad'>Cantidad a mover</label>
                                <select name='cantidad' id='cantidad'>
                    ");
                    for($i = 1; $i <= $stock->unidades; $i++){
                        print_r("<option value='$i'>$i</option>");
                    }
                    print_r("
                                </select>
                                <input class='submitButton' id='submitButton' type='submit' value='Enviar'>
                            </fieldset>
                        </form>
                    ");
                }
                if(isset($_POST['selectTienda'])){
                    $tiendaActual = $_POST['tiendaActual'];
                    $stockActual = $_POST['stockActual'];
                    $cantidad = $_POST['cantidad'];
                    $tiendaDestino = $_POST['selectTienda'];
                    try {
                        $conecction->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $conecction->beginTransaction();
                        $conecction->exec("UPDATE  stocks SET unidades = ($stockActual - $cantidad) WHERE producto = $id AND tienda = $tiendaActual");
                        if(comprobarStockTiendaDestino($tiendaDestino))
                            $conecction->exec("UPDATE  stocks SET unidades = ($stockActual + $cantidad) WHERE producto = $id AND tienda = $tiendaDestino");
                        else{
                            $conecction->exec("INSERT INTO stocks (producto, tienda, unidades) VALUES ($id, $tiendaDestino, $cantidad)");
                        }
                        $conecction->commit();
                    } catch (PDOException $error) {
                        $conecction->rollback();
                        echo "Transaction not completed: " . $error->getMessage();
                    }
                }
            } catch(PDOException $e){
                echo "<div class='error'>ERROR: ". $e->getMessage() ."</div>";
                die();
            }
            function comprobarStockTiendaDestino($tiendaDestino){
                $id = $GLOBALS['id'];
                $stock = $GLOBALS['conecction']->query(
                    "SELECT producto, tienda, unidades, nombre FROM stocks
                    INNER JOIN tiendas
                    ON tienda = id
                    WHERE producto = $id
                    AND tienda = $tiendaDestino"
                );
                $tienda = $stock->fetch(PDO::FETCH_OBJ);
                if($tienda == ""){
                    return false;
                } else{
                    return true;
                }
            }
        ?>
    </main>
</body>
</html>