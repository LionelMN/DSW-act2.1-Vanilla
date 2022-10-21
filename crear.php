<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <?php
        isset($_GET['update']) ? print_r("<title>Actualizar registro</title>") : print_r("<title>Nuevo registro</title>");
    ?>
    <title>Nuevo registro</title>
</head>
<body>
    <?php
    require "enviroment.php";
    function printForm($nombre = "", $nombreCorto = "", $precio = "", $familia = '', $descripcion = ''){
        isset($_GET['update']) ? print_r("<form action='update.php' method='post'>") : print_r("<form action='add.php' method='post'>");

        print_r("
            <fieldset>
                <legend>Datos del producto</legend>
                <label for='productName'>Nombre del producto</label>
                <input type='text' name='productName' id='productName' placeholder='Nombre del producto' value='$nombre'>
                <label for='shortName'>Nombre corto del producto</label>
                <input type='text' name='shortName' id='shortName' placeholder='Nombre corto del producto' value='$nombreCorto'>
                <label for='prize'>Precio €</label>
                <input type='number' name='prize' id='prize' placeholder='000.00' value='$precio'>
                <label for='familyProduct'>Familia del producto</label>
                <select name='familyProduct' id='familyProduct'>
        ");
        $result = $GLOBALS['conecction']->query('SELECT * FROM familias');
        while($family = $result->fetch(PDO::FETCH_OBJ)){
            if($familia == $family->cod){
                print_r("
                <option value='$family->cod' selected>$family->nombre</option>
            ");
            }else{
                print_r("
                    <option value='$family->cod'>$family->nombre</option>
                ");
            }
        }
        print_r("
                </select>
                <label for='description'>Descripción</label>
                <textarea name='description' id='description' cols='30' rows='10' placeholder='Descripción'>$descripcion</textarea>
                <input type='submit' value='Enviar'>
            </fieldset>
        </form>
        ");
    }
        if (!isset($_GET['id']) && !isset($_GET['update'])) {
            printForm();
        } else{
            $selectedProduct = $_GET['id'];
            $result = $conecction->query(
                "SELECT * FROM productos
                WHERE id = $selectedProduct");
            $product = $result->fetch(PDO::FETCH_OBJ);
            printForm($product->nombre,$product->nombre_corto,$product->pvp,$product->familia,$product->descripcion);
        }
    ?>
</body>
</html>