<?php
include 'conn.php';

// SQL query to fetch data
$sql = "SELECT
          YEAR(last_update) AS year, 
          MONTH(last_update) AS month, 
          COUNT(DISTINCT id) AS joins
        FROM queue
        WHERE YEAR(last_update) = YEAR(CURDATE())
        GROUP BY YEAR(last_update), MONTH(last_update)";

$result = mysqli_query($conn, $sql);

// Initialize data arrays
$data = array();
$labels = array();
$backgroundColor = array(
    'rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)',
    'rgba(75, 192, 192, 0.2)', 'rgba(153, 102, 255, 0.2)', 'rgba(255, 159, 64, 0.2)',
    'rgba(99, 255, 132, 0.2)', 'rgba(162, 54, 235, 0.2)', 'rgba(206, 255, 86, 0.2)',
    'rgba(192, 75, 192, 0.2)', 'rgba(102, 153, 255, 0.2)', 'rgba(159, 255, 64, 0.2)'
);

if (mysqli_num_rows($result) > 0) {
    while ($track = mysqli_fetch_assoc($result)) {
        array_push($data, $track['joins']); // Add data
        array_push($labels, date('F', mktime(0, 0, 0, $track['month'], 10))); // Convert month number to name
    }
}

// Helper functions to convert PHP arrays to JavaScript-compatible format
function js_str($s) {
    return '"' . addcslashes($s, "\0..\37\"\\") . '"';
}

function js_array($array) {
    $temp = array_map('js_str', $array);
    return '[' . implode(',', $temp) . ']';
}
?>


<script>
<?php
echo 'var dataSet = ', js_array($data), ';';
echo 'var labelSet = ', js_array($labels), ';';
echo 'var backgroundColors = ', json_encode($backgroundColor), ';';
?>
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labelSet,
        datasets: [{
            label: '# of Vehicles',
            data: dataSet,
            backgroundColor: backgroundColors.slice(0, dataSet.length), // Limit colors to data length
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

