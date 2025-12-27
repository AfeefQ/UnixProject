<?php
$servername = "db"; // MySQL container name
$username = "root";
$password = "mypassword";
$dbname = "restaurant_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$meal = '';
$recommendations = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $meal = $_POST['meal'];
    $stmt = $conn->prepare("SELECT name, cuisine, rating FROM restaurants WHERE cuisine LIKE ?");
    $meal_param = "%$meal%";
    $stmt->bind_param("s", $meal_param);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $recommendations[] = $row;
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Restaurant Recommendation</title>
</head>
<body>
    <h1>Restaurant Recommendation System</h1>
    <form method="post">
        <label for="meal">Enter your favorite cuisine:</label>
        <input type="text" id="meal" name="meal" value="<?php echo htmlspecialchars($meal); ?>" required>
        <button type="submit">Find Restaurants</button>
    </form>

    <?php if (!empty($recommendations)) { ?>
        <h2>Recommendations:</h2>
        <ul>
        <?php foreach ($recommendations as $r) {
            echo "<li>{$r['name']} ({$r['cuisine']}) - Rating: {$r['rating']}</li>";
        } ?>
        </ul>
    <?php } elseif ($_SERVER["REQUEST_METHOD"] == "POST") { ?>
        <p>No restaurants found for "<?php echo htmlspecialchars($meal); ?>"</p>
    <?php } ?>
</body>
</html>
