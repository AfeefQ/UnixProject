<?php
$servername = "db"; // MySQL container name name inside docker-compose
$username = "root";
$password = "mypassword";
$dbname = "restaurant_db";

// create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// check connectiion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$meal = '';
$recommendations = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $meal = $_POST['meal'];
    $stmt = $conn->prepare("SELECT name, cuisine, rating FROM restaurants WHERE cuisine LIKE ? OR name LIKE ?");
    $meal_param = "%$meal%";
    $stmt->bind_param("ss", $meal_param, $meal_param);
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
    <title>Restaurant Recommendation System</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        input[type=text] { width: 300px; padding: 8px; }
        input[type=submit], button { padding: 8px 16px; }
        table { border-collapse: collapse; margin-top: 20px; width: 80%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Restaurant Recommendation System</h1>
    <form method="post">
        <label for="meal">Enter your favorite meal or cuisine:</label><br>
        <input type="text" id="meal" name="meal" placeholder="e.g., Sushi, Pasta" value="<?php echo htmlspecialchars($meal); ?>" required><br><br>
        <button type="submit">Find Restaurants</button>
    </form>

    <?php if (!empty($recommendations)) { ?>
        <h2>Recommended Restaurants:</h2>
        <table>
            <tr>
                <th>Name</th>
                <th>Cuisine</th>
                <th>Rating</th>
            </tr>
            <?php foreach ($recommendations as $restaurant) { ?>
            <tr>
                <td><?php echo htmlspecialchars($restaurant['name']); ?></td>
                <td><?php echo htmlspecialchars($restaurant['cuisine']); ?></td>
                <td><?php echo htmlspecialchars($restaurant['rating']); ?></td>
            </tr>
            <?php } ?>
        </table>
    <?php } elseif ($_SERVER["REQUEST_METHOD"] == "POST") { ?>
        <p>No restaurants found for '<?php echo htmlspecialchars($meal); ?>'.</p>
    <?php } ?>
</body>
</html>
