<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Sign Up</title>
</head>
<body>
    <div class="container">
        <div class="form-container sign-up-container">
            <form method="POST" action="">
                <h1>Create Account</h1>
                <input type="text" name="name" placeholder="Name" required />
                <input type="email" name="email" placeholder="Email" required />
                <input type="password" name="password" placeholder="Password" required />
                <button type="submit">Sign Up</button>
                <span>Already have an account? <a href="signin.php">Sign In</a></span>
            </form>
            <?php
            $dsn = 'mysql:host=localhost:3306;dbname=user;charset=utf8';
            $dbUsername = 'Ira';
            $dbPassword = 'catapiaira04';

            try {
                $pdo = new PDO($dsn, $dbUsername, $dbPassword);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $name = $_POST['name'];
                    $email = $_POST['email'];
                    $password = $_POST['password'];
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                    $checkEmailStmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
                    $checkEmailStmt->bindParam(':email', $email);
                    $checkEmailStmt->execute();
                    $emailExists = $checkEmailStmt->fetchColumn();

                    if ($emailExists) {
                        echo "<p>Email already exists. Please use a different email.</p>";
                    } else {
                        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
                        $stmt->bindParam(':name', $name);
                        $stmt->bindParam(':email', $email);
                        $stmt->bindParam(':password', $hashedPassword);
                        
                        if ($stmt->execute()) {
                            echo "<p>Account created for $name with email $email!</p>";
                        } else {
                            echo "<p>There was an error creating your account. Please try again.</p>";
                        }
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

