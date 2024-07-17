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
$query = "SELECT COUNT(*) AS patient_count FROM ikure_chw_patient_be_patients";
$result = pg_query($conn, $query);
if (!$result) {
    die("Error in SQL query: " . pg_last_error());
}

// Fetch the result
$row = pg_fetch_assoc($result);
$patient_count = $row['patient_count'];

// Free resultset
pg_free_result($result);

// Query to get the number of vitals
$total_vitals_query = "SELECT SUM(count) AS total_vitals_count
FROM (
  SELECT COUNT(*) AS count FROM ikure_chw_vitals_be_heights
  UNION ALL
  SELECT COUNT(*) AS count FROM ikure_chw_vitals_be_bloodpressures
  UNION ALL
  SELECT COUNT(*) AS count FROM ikure_chw_vitals_be_weights
 UNION ALL
  SELECT COUNT(*) AS count FROM ikure_chw_vitals_be_pulses
     UNION ALL
  SELECT COUNT(*) AS count FROM ikure_chw_vitals_be_temperatures
  UNION ALL
  SELECT COUNT(*) AS count FROM ikure_chw_vitals_be_respiratories
  UNION ALL
  SELECT COUNT(*) AS count FROM ikure_chw_vitals_be_oxygensaturations
) AS subquery";


$vitals_result = pg_query($conn, $total_vitals_query);
if (!$vitals_result) {
    die("Error in SQL query: " . pg_last_error());
}

// Fetch the vitals_result
$row = pg_fetch_assoc($vitals_result);
$total_vitals_count = $row['total_vitals_count'];

// Free vitals_result
pg_free_result($vitals_result);

// Query to get the number of pathology
$total_pathology_query = "SELECT SUM(count) AS total_pathology_count
FROM (
  SELECT COUNT(*) AS count FROM ikure_chw_vitals_be_ecgs
  UNION ALL
  SELECT COUNT(*) AS count FROM ikure_chw_vitals_be_bloodglucoses
  UNION ALL
  SELECT COUNT(*) AS count FROM ikure_chw_vitals_be_hemoglobins
 
) AS subquery";


$pathology_result = pg_query($conn, $total_pathology_query);
if (!$pathology_result) {
    die("Error in SQL query: " . pg_last_error());
}

// Fetch the pathology_result
$row = pg_fetch_assoc($pathology_result);
$total_pathology_count = $row['total_pathology_count'];

// Free pathology_result
pg_free_result($pathology_result);



// Query to get the list of Patient
$list_query = "SELECT name, uhid, addresses FROM ikure_chw_patient_be_patients limit 5"; // Adjust the columns as necessary
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
    <h2 style="text-align: center;">Key Metrics</h2>
    <table>
        <tr>
            <th>Patient</th>       
            <th>Vitals</th>
            <th>Pathology</th>
        
        </tr>
        <tr>
            <td><?php echo $patient_count; ?></td>
            <td><?php echo $total_vitals_count; ?></td>
            <td><?php echo $total_pathology_count; ?></td>
        </tr>
    </table>

    <h2 style="text-align: center;">Patient List (5 Record)</h2>
    <table>
        <tr>
            <th>NAME</th>
            <th>UHID</th>
            <th>Addresses</th>
        </tr>
        <?php while ($row = pg_fetch_assoc($list_result)): ?> 
        <tr>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo htmlspecialchars($row['uhid']); ?></td>
            <td><?php echo htmlspecialchars($row['addresses']); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
