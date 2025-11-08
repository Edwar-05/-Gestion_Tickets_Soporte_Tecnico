<?php
require_once "config/database.php";

echo "<h2>Verificando usuarios en la base de datos</h2>";

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consultar usuarios
$sql = "SELECT id, username, email, role, password FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Hash de Contraseña</th>
            </tr>";
    
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["id"]. "</td>
                <td>" . $row["username"]. "</td>
                <td>" . $row["email"]. "</td>
                <td>" . $row["role"]. "</td>
                <td>" . substr($row["password"], 0, 20) . "...</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No se encontraron usuarios en la base de datos.";
}

// Cerrar conexión
$conn->close();
?>

<h3>Prueba de hash para 'admin123'</h3>
<?php
$test_password = 'admin123';
$hashed = password_hash($test_password, PASSWORD_DEFAULT);

echo "Contraseña: " . $test_password . "<br>";
echo "Hash generado: " . $hashed . "<br>";
echo "Verificación: " . (password_verify($test_password, $hashed) ? 'Éxito' : 'Falló');
?>

<p><a href="login.php">Volver al login</a></p>
