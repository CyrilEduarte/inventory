<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
     .btn-danger:hover{
        background-color: #ed5153 !important;
     }
     .chart-container{
        background-color: white;
        padding: 2%;
        border-radius: 8px;
        margin: 10px;
     }
</style>

<div class="mt-3 mb-3 text-center">
    <div class="chart-container" style="position: relative; display: inline-block; text-align: center; width: 75%;">
    <div class="text-center">
    <!-- <div class="btn-group" role="group" aria-label="Sales Interval">
        <button type="button" class="btn btn-danger" id="dailyBtn" style="background-color: #BD2025; color:white;">Daily</button>
        <button type="button" class="btn btn-danger" id="weeklyBtn" style="background-color: #BD2025; color:white;">Weekly</button>
        <button type="button" class="btn btn-danger" id="monthlyBtn" style="background-color: #BD2025; color:white;">Monthly</button>
        <button type="button" class="btn btn-danger" id="yearlyBtn" style="background-color: #BD2025; color:white;">Yearly</button>
    </div> -->
</div>
        <canvas id="salesChart"></canvas>
    </div>
</div>


<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "scinventory_system";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to fetch sales data from the database
function fetchSalesData($interval)
{
    global $conn;
    // Aggregate data based on the specified interval
    switch ($interval) {
        case 'daily':
            $sql = "SELECT DATE(date) AS date, SUM(price) AS total_sales FROM sales GROUP BY DATE(date)";
            break;
        case 'weekly':
            $sql = "SELECT YEAR(date) AS year, WEEK(date) AS week, SUM(price) AS total_sales FROM sales GROUP BY YEAR(date), WEEK(date)";
            break;
        case 'monthly':
            $sql = "SELECT YEAR(date) AS year, MONTH(date) AS month, SUM(price) AS total_sales FROM sales GROUP BY YEAR(date), MONTH(date)";
            break;
        case 'yearly':
            $sql = "SELECT YEAR(date) AS year, SUM(price) AS total_sales FROM sales GROUP BY YEAR(date)";
            break;
        default:
            return [];
    }
    $result = $conn->query($sql);
    $salesData = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $salesData[] = $row;
        }
    }
    return $salesData;
}

// Render chart with desired interval
$interval = isset($_GET['interval']) ? $_GET['interval'] : 'daily';
$salesData = fetchSalesData($interval);
?>

<script>
    // Function to prepare aggregated data for Chart.js
    function prepareChartData(salesData) {
        const labels = [];
        const amounts = [];
        salesData.forEach(item => {
            labels.push(item.date || item.year);
            amounts.push(item.total_sales);
        });
        return {
            labels,
            amounts
        };
    }

    // Function to render chart
    function renderChart(interval, salesData) {
        const {
            labels,
            amounts
        } = prepareChartData(salesData);
        const ctx = document.getElementById('salesChart').getContext('2d');

        // Check if window.salesChart is defined and is an instance of Chart.js
        if (window.salesChart !== undefined && window.salesChart instanceof Chart) {
            window.salesChart.destroy(); // Destroy previous chart instance
        }

        window.salesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Sales',
                    data: amounts,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    // Function to reload chart with the selected interval
    function reloadChart(interval) {
        fetch(`sales_chart.php?interval=${interval}`)
            .then(response => response.text())
            .then(data => {
                const salesData = JSON.parse(data);
                renderChart(interval, salesData);
            })
            .catch(error => console.error('Error fetching data:', error));
    }

    // // Event listeners for interval buttons
    // document.getElementById('dailyBtn').addEventListener('click', () => reloadChart('daily'));
    // document.getElementById('weeklyBtn').addEventListener('click', () => reloadChart('weekly'));
    // document.getElementById('monthlyBtn').addEventListener('click', () => reloadChart('monthly'));
    // document.getElementById('yearlyBtn').addEventListener('click', () => reloadChart('yearly'));

    // Initial chart render with default interval
    renderChart('<?php echo $interval; ?>', <?php echo json_encode($salesData); ?>);
</script>
