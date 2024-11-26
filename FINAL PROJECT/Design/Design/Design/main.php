<?php 
session_start();
if (!isset($_COOKIE['username'])) {
    header("Location: signin.php");
    exit();
}
include 'header.php'; 
?>

<ul id="slides">
    <?php
    $slides = [
        ['name' => 'Aaron Angelo Aquino', 'desc' => 'Hello, I\'m Aaron, 21 years old, a group member who is a Full-Stack Developer in this webpage.', 'image' => 'aaron.jpg'],
        ['name' => 'Aljon Nuestro', 'desc' => 'A group member who is responsive with every language. <br> -Full-Stack', 'image' => 'aljon.jpg'],
        ['name' => 'Ira Christine Catapia', 'desc' => 'Hello, I\'m Ira, a  group member who is a Full-Stack Developer:> ', 'image' => 'IRA.JPG'],
        ['name' => 'Jacob Alocon', 'desc' => 'An IT Student who is responsive with every language. <br> -Full-Stack', 'image' => 'jacob.jpg'],
        ['name' => 'Rafael Cena', 'desc' => 'An IT Student who is responsible with every language', 'image' => 'rafael.jpg']
    ];
    foreach ($slides as $index => $slide) {
        $activeClass = ($index === 0) ? 'showing' : '';
        echo "<li class='slide $activeClass' style='background-image: url({$slide['image']});'>
                <p class='names'>{$slide['name']}</p><br>
                <p class='desc'>{$slide['desc']}</p>
            </li>";
    }
    ?>
</ul>

<section class="team">
    <div class="center">
        <h1>Group 3</h1>
        <div class="header-container">
        <!-- <form id="searchForm" method="GET" action="" onsubmit="return searchTeam();"> -->
            <form id="searchForm" onsubmit="return searchTeam();">
                <input type="text" name="q" id="query" placeholder="Search Team Member" required>
                <input type="submit" value="Search">
            </form>
            <div id="livesearch" class="live-search-results"></div>
        </div>
        <div id="error" class="error-message"></div>
    </div>
    <div class="team-content" id="teamMembers">
        <button class="contact-button" onclick="toggleContactForm()">Contact Us</button>
        <div class="contact-form" id="contactForm">
            <form method="POST" action="">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
                <br>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <br>
                <label for="message">Message:</label>
                <textarea id="message" name="message" required></textarea>
                <br>
                <button type="submit">Send</button>
            </form>

            <?php
$servername = "localhost:3306"; 
$username = "Ira"; 
$password = "catapiaira04"; 
$dbname = "contact_us"; 
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    $stmt = $conn->prepare("INSERT INTO contact(name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Thank you, $name! We have received your message.";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        $_SESSION['error_message'] = "There was an error. Please try again later.";
    }
    $stmt->close();
}
if (isset($_SESSION['success_message'])) {
    echo "<p>{$_SESSION['success_message']}</p>";
    unset($_SESSION['success_message']);
}
if (isset($_SESSION['error_message'])) {
    echo "<p>{$_SESSION['error_message']}</p>";
    unset($_SESSION['error_message']);
}

$conn->close();
?>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>
