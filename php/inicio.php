<?php
include 'conexion.php';

// Obtener las 3 categorías
$sql_categorias = "SELECT id_categoria, nombre_categoria FROM categorias LIMIT 3";
$resultado_categorias = $conexion->query($sql_categorias);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inicio</title>
  <link rel="stylesheet" href="../css/style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Electrolize&display=swap" rel="stylesheet">
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
  <style>
    .modal {
      position: fixed;
      top: 0; left: 0; right: 0; bottom: 0;
      background-color: rgba(0,0,0,0.5);
      display: none; justify-content: center; align-items: center;
      z-index: 1000;
    }
    .modal-content {
      background-color: white;
      padding: 20px;
      border-radius: 10px;
      max-height: 80%;
      overflow-y: auto;
      width: 80%;
    }
    .modal-content table {
      width: 100%;
      border-collapse: collapse;
    }
    .modal-content th, .modal-content td {
      padding: 10px;
      border: 1px solid #ddd;
    }
  </style>
</head>
<body>
  <header>
    <nav>
      <ul>
        <li><a href="#" id="abrirCarrito"><i class="fa-solid fa-cart-plus"></i></a></li>
      </ul>
    </nav>
  </header>

  <section id="inicio"></section>

  <?php
  if ($resultado_categorias->num_rows > 0) {
      while ($categoria = $resultado_categorias->fetch_assoc()) {
          $id_categoria = $categoria['id_categoria'];
          $nombre_categoria = $categoria['nombre_categoria'];

          // Obtener productos ordenados por precio ascendente
          $sql_productos = "SELECT * FROM productos WHERE id_categoria = $id_categoria ORDER BY precio ASC";
          $resultado_productos = $conexion->query($sql_productos);
  ?>
      <section class="categoria" data-aos="fade-up">
        <div class="container">
          <div class="titulo">
            <h1><?php echo htmlspecialchars($nombre_categoria); ?></h1>
          </div>
          <div class="content-target">
            <?php
              if ($resultado_productos->num_rows > 0) {
                  while ($producto = $resultado_productos->fetch_assoc()) {
                      echo '<div class="target">';
                      echo '<img class="imagen" src="' . $producto["url_imagen"] . '" alt="Imagen del producto">';
                      echo '<div class="info">';
                      echo '<h3>' . $producto["nombre_producto"] . '</h3>';
                      echo '<p>Precio: $' . $producto["precio"] . '</p>';
                      echo '<p>Stock: ' . $producto["stock"] . '</p>';
                      echo '<button class="btn btn-primary" 
                                   data-id="' . $producto["id_producto"] . '" 
                                   data-nombre="' . $producto["nombre_producto"] . '" 
                                   data-precio="' . $producto["precio"] . '" 
                                   data-stock="' . $producto["stock"] . '" 
                                   data-imagen="' . $producto["url_imagen"] . '">Agregar al carrito</button>';
                      echo '</div>';
                      echo '</div>';
                  }
              } else {
                  echo "<p>No hay productos disponibles en esta categoría.</p>";
              }
            ?>
          </div>
        </div>
      </section>
  <?php
      }
  } else {
      echo "<p>No se encontraron categorías.</p>";
  }

  $conexion->close();
  ?>

  <!-- Modal del Carrito -->
  <div id="modalCarrito" class="modal">
    <div class="modal-content">
      <span id="cerrarCarrito" style="cursor:pointer; float:left;">&times;</span>
      <h2>Carrito de Compras</h2>
      <table id="tablaCarrito"  class="table table-striped">
        <thead>
          <tr>
            <th>Imagen</th>
            <th>Producto</th>
            <th>Precio</th>
            <th>Unidades</th>
            <th>Total</th>
            <th>Eliminar</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </div>

  <footer></footer>
</body>
</html>

<!-- Funcion del carrito de compra  -->
<script>
  AOS.init();

  const carrito = {};

  document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".btn-primary").forEach(btn => {
      btn.addEventListener("click", () => {
        const id = btn.dataset.id;
        const imagen = btn.dataset.imagen;
        const nombre = btn.dataset.nombre;
        const precio = parseFloat(btn.dataset.precio);
        const stock = parseInt(btn.dataset.stock);

        if (!carrito[id]) {
          carrito[id] = { imagen, nombre, precio, cantidad: 1, stock };
        } else if (carrito[id].cantidad < stock) {
          carrito[id].cantidad++;
        } else {
          alert("No puedes agregar más unidades, has alcanzado el stock disponible.");
          return;
        }

        actualizarCarrito();
      });
    });

    document.getElementById("abrirCarrito").addEventListener("click", (e) => {
      e.preventDefault();
      document.getElementById("modalCarrito").style.display = "flex";
    });

    document.getElementById("cerrarCarrito").addEventListener("click", () => {
      document.getElementById("modalCarrito").style.display = "none";
    });
  });

  function actualizarCarrito() {
    const tbody = document.querySelector("#tablaCarrito tbody");
    tbody.innerHTML = "";

    for (const id in carrito) {
      const prod = carrito[id];
      const fila = document.createElement("tr");
//aqui salen los datos del producto
      fila.innerHTML = `
        <td><img src="${prod.imagen}" alt="Imagen" width="60"></td>
        <td>${prod.nombre}</td>
        <td>$${prod.precio.toFixed(2)}</td>
        <td>${prod.cantidad}</td>
        <td>$${(prod.precio * prod.cantidad).toFixed(2)}</td>
        <td><button class="btn btn-danger" onclick="eliminarProducto('${id}')">Eliminar</button></td>
      `;
      tbody.appendChild(fila);
    }
  }

  function eliminarProducto(id) {
    delete carrito[id];
    actualizarCarrito();
  }
</script>
