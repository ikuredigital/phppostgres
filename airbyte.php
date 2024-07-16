<?php

//echo "app runung";
//exit();
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

// Query to get the number of Patient
$query = "SELECT COUNT(*) AS patient_count FROM patients";
$result = pg_query($conn, $query);
if (!$result) {
    die("Error in SQL query: " . pg_last_error());
}

// Fetch the result
$row = pg_fetch_assoc($result);
$patient_count = $row['patient_count'];

// Free resultset
pg_free_result($result);

// Query to get the list of Patient
$list_query = "SELECT name, uhid, uhid FROM patients"; // Adjust the columns as necessary
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
    <title>Patient List and Count</title>
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
    <h2 style="text-align: center;">Patient Count</h2>
    <table>
        <tr>
            <th>Number of Patient</th>
        </tr>
        <tr>
            <td><?php echo $patient_count; ?></td>
        </tr>
    </table>

    <h2 style="text-align: center;">Patient List</h2>
    <table>
        <tr>
            <th>NAME</th>
            <th>UHID</th>
            <th>Facility Code</th>
        </tr>
        <?php while ($row = pg_fetch_assoc($list_result)): ?> 
        <tr>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo htmlspecialchars($row['uhid']); ?></td>
            <td><?php echo htmlspecialchars($row['uhid']); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
