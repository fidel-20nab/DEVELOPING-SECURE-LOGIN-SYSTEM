<?php
require 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Prevent SQL injection with prepared statements
  $stmt = $pdo->prepare("SELECT id, password FROM users WHERE email = ?");
  $stmt->execute([$email]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($user && password_verify($password, $user['password'])) {
    // Start session and set secure cookie
    $_SESSION['user_id'] = $user['id'];
    setcookie("loggedin", "true", [
      'expires' => time() + 3600,
      'secure' => true,
      'httponly' => true,
      'samesite' => 'Strict'
    ]);
    header("Location: dashboard.php");
  } else {
    echo "Invalid email or password.";
  }
}
?>
