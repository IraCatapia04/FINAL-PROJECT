<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Sign In</title>
</head>
<body>
    <div class="container">
        <div class="form-container sign-in-container">
            <form method="POST" action="">
                <h1>Sign In</h1>
                <input type="email" name="email" placeholder="Email" required />
                <input type="password" name="password" placeholder="Password" required />
                <button type="submit">Sign In</button>
                <span>Don't have an account? <a href="signup.php">Sign Up</a></span>
            </form>
            <?php
          session_start();

          $dsn = 'mysql:host=localhost:3306;dbname=user;charset=utf8';
          $username = 'Ira';
          $password = 'catapiaira04'; 
          try {
              $pdo = new PDO($dsn, $username, $password);
              $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              
              if ($_SERVER["REQUEST_METHOD"] == "POST") {
                  $email = $_POST['email'];
                  $password = $_POST['password'];
            
                  $stmt = $pdo->prepare("SELECT name, password FROM users WHERE email = :email");
                  $stmt->bindParam(':email', $email);
                  $stmt->execute();
                  
                  if ($stmt->rowCount() > 0) {
                      $row = $stmt->fetch(PDO::FETCH_ASSOC);
                      
                      
                      if (password_verify($password, $row['password'])) {
                          $_SESSION['email'] = $email; 
                          setcookie('username', $row['name'], time() + (30 * 24 * 60 * 60), "/");  // Set cookie for 30 days
                          header("Location: main.php"); 
                          exit();
                      } else {
                          echo "<p>Invalid email or password.</p>";
                      }
                  } else {
                      echo "<p>Invalid email or password.</p>";
                  }
              }
          } catch (PDOException $e) {
              echo "Connection failed: " . $e->getMessage();
          }
            ?>
        </div>
    </div>
</body>
</html>
