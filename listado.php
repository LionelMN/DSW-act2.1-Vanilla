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
        <form action="listado.php" method="get" class="paginationForm">
            <label for="results_per_page">Número de resultados por página</label>
            <select name="results_per_page" id="results_per_page">
                <option value="5" selected>5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
            </select>
            <label for="orderCriteria">Ordenar por:</label>
            <select name="orderCriteria" id="orderCriteria">
                <option value="id" selected>ID</option>
                <option value="nombre">Nombre</option>
            </select>
            <input type="submit" value="Enviar">
        </form>
        <div class="products__table">
            <div class="products__table__header products__table__row">
                <div>Detalles</div>
                <div>Código</div>
                <div>Nombre</div>
                <div>Acciones</div>
            </div>
            <?php
                require "enviroment.php";
                $page = 1;
                $results_per_page = 5;
                $orderCriteria = 'id';
                if(isset($_GET['page'])){
                    $page = $_GET['page'];
                };
                if(isset($_GET['results_per_page'])){
                    $results_per_page = $_GET['results_per_page'];
                };
                if(isset($_GET['orderCriteria'])){
                    $orderCriteria = $_GET['orderCriteria'];
                };
                $page_first_result = ($page-1) * $results_per_page;
                try{
                    $result = $conecction->query("SELECT * FROM productos");
                    $totalItems = $result->rowCount();
                    $resultLimited = $conecction->query("SELECT * FROM productos ORDER BY $orderCriteria ASC LIMIT $page_first_result, $results_per_page");
                    $number_of_page = ceil ($totalItems / $results_per_page);
                    while($products = $resultLimited->fetch(PDO::FETCH_OBJ)){
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
                    print_r("</div>");
                    print_r("<div class='paginationContainer'>");
                    for($page = 1; $page <= $number_of_page; $page++) {
                        echo "<a href = 'listado.php?page=$page&results_per_page=$results_per_page&orderCriteria=$orderCriteria'> $page </a>";
                    };
                    print_r("</div>");
                }catch(PDOException $e){
                    echo "ERROR: " . $e->getMessage();
                }
            ?>

    </main>
</body>
</html>