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
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php
    require "enviroment.php";
        function printForm($nombre = "", $nombreCorto = "", $precio = "", $familia = '', $descripcion = ''){
            $id;
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
            }

            isset($_GET['update']) ? print_r("<form action='crear.php?update=true&id=$id' method='post'>") : print_r("<form action='crear.php' method='post'>");

            print_r("
                <fieldset>
                <legend>Datos del producto</legend>
                    <div class='error' id='nameError'>
                        El nombre no puede estar vacío.
                    </div>
                    <label for='productName'>Nombre del producto</label>
                    <input type='text' name='productName' id='productName' placeholder='Nombre del producto' value='$nombre'>
                    <div class='error' id='shortNameError'>
                        El nombre corto no puede estar vacío.
                    </div>
                    <label for='shortName'>Nombre corto del producto</label>
                    <input type='text' name='shortName' id='shortName' placeholder='Nombre corto del producto' value='$nombreCorto'>
                    <div class='error' id='prizeError'>
                        El precio no puede estar vacío o ser 0.
                    </div>
                    <label for='prize'>Precio €</label>
                    <input type='number' name='prize' id='prize' placeholder='000.00' value='$precio'>
                    <div class='error' id='familyError'>
                        La familia introducida no es válida
                    </div>
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
                    <div class='error' id='descriptionError'>
                        La descripción no puede estar vacío.
                    </div>
                    <label for='description'>Descripción</label>
                    <textarea name='description' id='description' cols='30' rows='10' placeholder='Descripción'>$descripcion</textarea>
                    <input type='submit' value='Enviar' id='submitButton'>
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
        if ($_POST) {
            $form = processForm();
            if(isset($_GET['update'])){
                updateProduct($form);
            } else{
                insertProduct($form);
            }
        }

        function processForm(){
            $formArray = [];
            $errors = false;
            $msgError = "";
            foreach ($_POST as $key => $value) {
                if($value != ""){
                    $formArray[$key] = $value;
                } else{
                    $errors = true;
                    $msgError = "El campo $key está vacío \n";
                }
            }
            if($errors){
                return false;
            } else{
                return $formArray;
            }
        }

        function updateProduct($form){
            $id = $_GET['id'];
            try {
                $result = $GLOBALS['conecction']->prepare(
                    "UPDATE productos
                    SET
                        nombre=:nombre,
                        nombre_corto=:nombre_corto,
                        pvp=:prize,
                        familia=:familia,
                        descripcion=:descripcion
                    WHERE id=:id");
                $data = array(
                    "nombre"=>$form['productName'],
                    "nombre_corto"=>$form['shortName'],
                    "prize"=>$form['prize'],
                    "familia"=>$form['familyProduct'],
                    "descripcion"=>$form['description'],
                    "id"=>$id
                );
                print_r($data);
                if( $result->execute($data) )
                    header("Location: listado.php");
                else
                    print_r("<div class='error showedError'>Error: el producto no ha podido actualizarse correctamente</div>");
            } catch(PDOException $e){
                echo "ERROR: " . $e->getMessage();
            }
        }

        function insertProduct($form){
            try{
                $result = $GLOBALS['conecction']->prepare(
                    "INSERT INTO productos (
                        nombre,
                        nombre_corto,
                        pvp,
                        familia,
                        descripcion
                    )
                    VALUES (
                        :nombre,
                        :nombre_corto,
                        :prize,
                        :familia,
                        :descripcion
                    )
                ");
                $data = array(
                    "nombre"=>$form['productName'],
                    "nombre_corto"=>$form['shortName'],
                    "prize"=>$form['prize'],
                    "familia"=>$form['familyProduct'],
                    "descripcion"=>$form['description'],
                );
                if( $result->execute($data) )
                    header("Location: listado.php");
                else
                    print_r("<div class='error showedError'>Error: el producto no ha podido insertarse correctamente</div>");
            } catch(PDOException $e){
                echo "ERROR: " . $e->getMessage();
            }
        }
    ?>
    <script src="main.js"></script>
</body>
</html>