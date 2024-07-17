<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vitals and Pathology Counts</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h2 {
            color: #2c3e50;
        }
        .count-table {
            width: 50%;
            border-collapse: collapse;
            margin: 50px auto;
        }
        .count-table th, .count-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .count-table th {
            background-color: #f2f2f2;
            text-align: center;
        }
        .count-table td {
            text-align: left;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center;">Vitals and Pathology Counts</h1>
    <?php
    // Database connection parameters
    $host = '192.168.10.142';
    $dbname = 'warehouse';
    $user = 'danwqub7';
    $password = 'MeYkguSUPNpx';

    try {
        // Establish a connection to the PostgreSQL database
        $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Define an array of tables under "vitals" and "pathology"
        $vitalsTables = ['ikure_chw_vitals_be_heights', 'ikure_chw_vitals_be_bloodpressures', 'ikure_chw_vitals_be_weights', 'ikure_chw_vitals_be_pulses', 'ikure_chw_vitals_be_temperatures', 'ikure_chw_vitals_be_respiratories', 'ikure_chw_vitals_be_oxygensaturations'];
        $pathologyTables = ['ikure_chw_vitals_be_ecgs', 'ikure_chw_vitals_be_bloodglucoses', 'ikure_chw_vitals_be_hemoglobins'];

        // Function to get the count of rows in a table
        function getCount($pdo, $table) {
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM $table");
            $stmt->execute();
            return $stmt->fetchColumn();
        }

        // Fetch and display counts for vitals tables
        echo "<h2><a href=\"./home.php\">Back</a></h2>";
        echo "<table class='count-table'>";
        echo "<tr><th>Vitals Name</th><th>Count</th></tr>";
        foreach ($vitalsTables as $table) {
            $count = getCount($pdo, $table);
            echo "<tr><td>$table</td><td>$count</td></tr>";
        }
        echo "</table>";

        // Fetch and display counts for pathology tables
        echo "<h2>.</h2>";
        echo "<table class='count-table'>";
        echo "<tr><th>Pathology Name</th><th>Count</th></tr>";
        foreach ($pathologyTables as $table) {
            $count = getCount($pdo, $table);
            echo "<tr><td>$table</td><td>$count</td></tr>";
        }
        echo "</table>";

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    // Close the database connection
    $pdo = null;
    ?>
</body>
</html>
