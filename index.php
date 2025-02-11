<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra de Paquetes de Libros</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="box">
            <h2>Formulario de Compra</h2>
            <form method="POST" action="" id="formPaquetes">
                <label for="nombreLibro">Nombre del Libro</label>
                <input type="text" id="nombreLibro" name="nombreLibro">

                <label for="tipoLibro">Tipo de Libro</label>
                <select id="tipoLibro" name="tipoLibro">
                    <option value="matematicas">Matemáticas</option>
                    <option value="lenguaje">Lenguaje</option>
                </select>

                <label for="precio">Precio por Libro (€)</label>
                <input type="number" id="precio" name="precio" min="1" >

                <label for="cantidad">Cantidad</label>
                <input type="number" id="cantidad" name="cantidad" min="1">

                <button type="submit" class="btn">Añadir Paquete</button>
            </form>
        </div>

        <div class="box" id="resultado">
            <h2>Resultado</h2>
            <div id="detallePaquetes">
                <?php
                    abstract class Producto {
                        protected $nombre;
                        protected $precio;

                        public function __construct($nombre, $precio) {
                            $this->nombre = $nombre;
                            $this->precio = $precio;
                        }

                        public function getPrecio() {
                            return $this->precio;
                        }

                        public function getNombre() {
                            return $this->nombre;
                        }
                    }

                    class Libro extends Producto {
                        private $tematica;

                        public function __construct($nombre, $precio, $tematica) {
                            parent::__construct($nombre, $precio);
                            $this->tematica = $tematica;
                        }

                        public function getTematica() {
                            return $this->tematica;
                        }
                    }

                    class PaqueteLibros {
                        private $libro;
                        private $cantidad;

                        public function __construct(Libro $libro, $cantidad) {
                            $this->libro = $libro;
                            $this->cantidad = $cantidad;
                        }

                        public function calcularImporteTotal() {
                            return $this->libro->getPrecio() * $this->cantidad;
                        }

                        public function mostrarDetalle() {
                            $tipo = $this->libro->getTematica();
                            $nombre = $this->libro->getNombre();
                            echo "<p>Paquete de {$this->cantidad} libro(s) de {$tipo} llamado '{$nombre}', Precio por libro: €{$this->libro->getPrecio()}, Importe total: €" . $this->calcularImporteTotal() . "</p>";
                        }
                    }
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $errores = [];
                        $nombreLibro = trim($_POST['nombreLibro'] ?? '');
                        $tipoLibro = trim($_POST['tipoLibro'] ?? '');
                        $precio = filter_var($_POST['precio'] ?? 0, FILTER_VALIDATE_FLOAT);
                        $cantidad = filter_var($_POST['cantidad'] ?? 0, FILTER_VALIDATE_INT);
                    
                      
                        if (empty($nombreLibro)) {
                            $errores[] = "El nombre del libro no puede estar vacío.";
                        }
                        if (empty($tipoLibro)) {
                            $errores[] = "Debe seleccionar un tipo de libro.";
                        }
                        if ($precio === false || $precio <= 0) {
                            $errores[] = "El precio debe ser un número mayor a 0.";
                        }
                        if ($cantidad === false || $cantidad <= 0) {
                            $errores[] = "La cantidad debe ser un número entero mayor a 0.";
                        }
                    
                        
                        if (empty($errores)) {
                            $libro = new Libro($nombreLibro, $precio, $tipoLibro);
                            $paquete = new PaqueteLibros($libro, $cantidad);
                            echo "<div class='result'>";
                            $paquete->mostrarDetalle();
                            echo "</div>";
                        } else {
                           
                            foreach ($errores as $error) {
                                echo "<div class='result' style='color: red;'>$error</div>";
                            }
                        }
                    }
        
                ?>
            </div>
        </div>
    </div>
</body>
</html>
