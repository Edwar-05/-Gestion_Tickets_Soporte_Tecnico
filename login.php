<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "config/database.php";

$username = "";
$password = "";
$login_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["username"]))) {
        $login_err = "Por favor ingrese su nombre de usuario.";
    } else {
        $username = trim($_POST["username"]);
    }
    
    if (empty(trim($_POST["password"]))) {
        $login_err = "Por favor ingrese su contraseña.";
    } else {
        $password = trim($_POST["password"]);
    }
    
    if (empty($login_err)) {
        $sql = "SELECT id, username, password, role FROM users WHERE username = ?";
        
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = $username;
            
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                
                echo "Número de filas encontradas: " . mysqli_stmt_num_rows($stmt) . "<br>";
                
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password, $role);
                    if (mysqli_stmt_fetch($stmt)) {
                        echo "Contraseña ingresada: " . $password . "<br>";
                        echo "Hash almacenado: " . $hashed_password . "<br>";
                        echo "Verificación de contraseña: " . (password_verify($password, $hashed_password) ? 'Éxito' : 'Falló') . "<br>";
                        
                        if (password_verify($password, $hashed_password)) {
                            session_start();
                            
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            $_SESSION["role"] = $role;
                            
                            if ($role == 'admin') {
                                header("location: admin/dashboard.php");
                            } else {
                                header("location: client/dashboard.php");
                            }
                        } else {
                            $login_err = "El nombre de usuario o la contraseña no son válidos.";
                        }
                    }
                } else {
                    $login_err = "El nombre de usuario o la contraseña no son válidos.";
                }
            } else {
                echo "Algo salió mal. Por favor, inténtalo de nuevo más tarde.";
            }
            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; margin: 0 auto; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Iniciar Sesión</h2>
        <p>Por favor ingrese sus credenciales para iniciar sesión.</p>

        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Nombre de Usuario</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>">
            </div>    
            <div class="form-group">
                <label>Contraseña</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Iniciar Sesión">
            </div>
            <p>¿No tienes una cuenta? <a href="register.php">Regístrate ahora</a>.</p>
        </form>
    </div>
</body>
</html>
