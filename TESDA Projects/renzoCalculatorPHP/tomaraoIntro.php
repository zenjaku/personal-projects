<!-- index.php -->
<!DOCTYPE html>
<html>
<head>
    <title>PHP Form Example</title>
</head>
<body>
    <h2>Enter Your Name</h2>
    
    <!-- HTML Form -->
    <form method="post" action="index.php">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <input type="submit" value="Submit">
    </form>

    <!-- PHP Script to Echo the Name -->
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the value of the 'name' input
        $name = $_POST['name'];
        
        // Echo the content of the text box
        echo "<h3>Hello, " . htmlspecialchars($name) . "!</h3>";
    }
    ?>
</body>
</html>