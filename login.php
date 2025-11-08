<?php
require_once 'includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = limpiarDatos($_POST['username']);
    $password = $_POST['password'];
    
    try {
        // Buscar el usuario en la base de datos
        $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        
        if ($stmt->rowCount() === 1) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Verificar la contraseña
            if (password_verify($password, $user['password'])) {
                // Iniciar sesión
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                
                // Redirigir al dashboard según el rol
                header('Location: dashboard.php');
                exit();
            }
        }
        
        // Si las credenciales son incorrectas
        header('Location: index.php?error=1');
        exit();
        
    } catch(PDOException $e) {
        die("Error: " . $e->getMessage());
    }
} else {
    // Si se intenta acceder directamente al archivo, redirigir al inicio
    header('Location: index.php');
    exit();
}
?>
