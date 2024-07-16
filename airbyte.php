<?php
// Database connection parameters
$host = '192.168.10.142';
$dbname = 'warehouse';
$user = 'danwqub7';
$password = 'MeYkguSUPNpx';

// Connect to PostgreSQL database
$conn = pg_connect("host=$host dbname=$dbname user=$user password=$password");
if (!$conn) {
    die("Connection failed: " . pg_last_error());
}

// Query to get the number of products
$query = "SELECT COUNT(*) AS product_count FROM testproducts";
$result = pg_query($conn, $query);
if (!$result) {
    die("Error in SQL query: " . pg_last_error());
}

// Fetch the result
$row = pg_fetch_assoc($result);
$product_count = $row['product_count'];

// Free resultset
pg_free_result($result);

// Query to get the list of products
$list_query = "SELECT testproduct_id, product_name, category_id FROM testproducts"; // Adjust the columns as necessary
$list_result = pg_query($conn, $list_query);
if (!$list_result) {
    die("Error in SQL query: " . pg_last_error());
}


// Close the connection
pg_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Products List and Count</title>
    <style>
        table {
            width: 50%;
            border-collapse: collapse;
            margin: 50px auto;
        }
        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Products Count</h2>
    <table>
        <tr>
            <th>Number of products</th>
        </tr>
        <tr>
            <td><?php echo $product_count; ?></td>
        </tr>
    </table>

    <h2 style="text-align: center;">Products List</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Product Name</th>
            <th>Category ID</th>
        </tr>
        <?php while ($row = pg_fetch_assoc($list_result)): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['testproduct_id']); ?></td>
            <td><?php echo htmlspecialchars($row['product_name']); ?></td>
            <td><?php echo htmlspecialchars($row['category_id']); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>