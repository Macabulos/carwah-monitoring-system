<?php
include 'conn.php';

// Query for annual report
$sql = "SELECT 
          YEAR(last_update) AS year, 
          COUNT(DISTINCT id) AS total_joins
        FROM queue
        GROUP BY YEAR(last_update)";

$result = mysqli_query($conn, $sql);

// Initialize data arrays
$annualData = array();
$annualLabels = array();
$annualColors = array(
    'rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)',
    'rgba(75, 192, 192, 0.2)', 'rgba(153, 102, 255, 0.2)', 'rgba(255, 159, 64, 0.2)',
    'rgba(99, 255, 132, 0.2)', 'rgba(162, 54, 235, 0.2)', 'rgba(206, 255, 86, 0.2)'
);

if (mysqli_num_rows($result) > 0) {
    while ($track = mysqli_fetch_assoc($result)) {
        array_push($annualData, $track['total_joins']);
        array_push($annualLabels, $track['year']); // Year label
    }
}

// Helper functions
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
echo 'var annualDataSet = ', js_array($annualData), ';';
echo 'var annualLabelSet = ', js_array($annualLabels), ';';
echo 'var annualColors = ', json_encode($annualColors), ';';
?>
var annualCtx = document.getElementById('annualChart').getContext('2d');
var annualChart = new Chart(annualCtx, {
    type: 'bar',
    data: {
        labels: annualLabelSet,
        datasets: [{
            label: '# of Vehicles (Annual)',
            data: annualDataSet,
            backgroundColor: annualColors.slice(0, annualDataSet.length), // Limit colors
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
