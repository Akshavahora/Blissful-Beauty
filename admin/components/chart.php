<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cosmetic Products Sales Graph</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

    <div style="width: 80%; margin: auto;">
        <h2 style="text-align: center;">Cosmetic Product Sales</h2>
        
        <!-- Product Data inside HTML -->
        <ul id="productData" style="display: none;">
            <li data-name="Lipstick" data-sales="120"></li>
            <li data-name="Foundation" data-sales="200"></li>
            <li data-name="Eyeliner" data-sales="150"></li>
            <li data-name="Blush" data-sales="80"></li>
            <li data-name="Mascara" data-sales="190"></li>
            <li data-name="Nail Polish" data-sales="100"></li>
        </ul>

        <canvas id="cosmeticChart"></canvas>
    </div>

    <script>
        // Get product data from HTML
        const productElements = document.querySelectorAll("#productData li");
        const productNames = [];
        const salesData = [];

        productElements.forEach(item => {
            productNames.push(item.getAttribute("data-name"));
            salesData.push(parseInt(item.getAttribute("data-sales")));
        });

        // Chart Configuration
        const ctx = document.getElementById('cosmeticChart').getContext('2d');
        const cosmeticChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: productNames,
                datasets: [{
                    label: 'Units Sold',
                    data: salesData,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                        'rgba(255, 159, 64, 0.7)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
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

</body>
</html>
