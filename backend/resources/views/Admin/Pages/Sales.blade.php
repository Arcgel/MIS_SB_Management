<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sales</title>
  <link rel="stylesheet" href="{{asset('css/sales.css')}}">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet"/>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
  <aside>
    @include('Admin.Pages.Sidebar')
  </aside>

  <div class="content-wrapper">
    <div class="title">
      <div class="page-name">
        <h1>SALES ANALYTICS</h1>
      </div>
    </div>

    <div class="chart-container">
      <!-- TOTAL SALES BAR CHART -->
      <div class="chart-card small">
        <h2>Total Sales</h2>
        <div class="chart-canvas-container">
          <canvas id="totalSalesChart"></canvas>
        </div>
      </div>

      <!-- MONTHLY SALES LINE CHART -->
      <div class="chart-card">
        <h2>Monthly Sales</h2>
        <div class="chart-canvas-container">
          <canvas id="monthlySalesChart"></canvas>
        </div>
      </div>
    </div>
  </div>

  <script>
    const totalSalesData = {
      labels: ['Ice Scramble', 'Shakes', 'Drinks', 'Snack Bites'],
      datasets: [{
        label: 'Total Sales (₱)',
        data: @if(empty($totalSales) || array_sum($totalSales) === 0) 
            [0, 0, 0, 0]
        @else 
            {{ $totalSales }}
        @endif,
        emptyDataMessage: 'No sales data available',
        backgroundColor: ['#FFB6A6', '#A6C1FF', '#FFD1D1', '#D1A6FF'],
        borderRadius: 5
      }]
    };

    new Chart(document.getElementById('totalSalesChart'), {
      type: 'bar',
      data: totalSalesData,
      options: {
        responsive: true,
        maintainAspectRatio: false,
        animation: {
          duration: 1000
        },
        plugins: {
          legend: { display: false },
          tooltip: {
            callbacks: {
              label: function(context) {
                return `₱${context.raw}`;
              }
            }
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              callback: function(value) {
                return '₱' + value;
              }
            }
          },
          x: {
            grid: {
              display: false
            }
          }
        }
      }
    });

    const monthlySalesData = {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
      datasets: [{
        label: 'Monthly Sales (₱)',
        data: @if(empty($monthlySales) || array_sum($monthlySales->toArray()) === 0) 
            [0, 0, 0, 0,0, 0, 0, 0, 0, 0, 0, 0]
        @else 
            {{ $monthlySales }}
        @endif,
        emptyDataMessage: 'No monthly sales data available',
        fill: true,
        tension: 0.3,
        pointRadius: 3,
        pointHoverRadius: 5,
        borderColor: '#ff5e78',
        backgroundColor: 'rgba(255, 94, 120, 0.1)',
        borderWidth: 2,
      }]
    };

    new Chart(document.getElementById('monthlySalesChart'), {
      type: 'line',
      data: monthlySalesData,
      options: {
        responsive: true,
        maintainAspectRatio: false,
        animation: {
          duration: 1000
        },
        plugins: {
          legend: {
            position: 'top',
            labels: {
              boxWidth: 12,
              usePointStyle: true,
              pointStyle: 'circle'
            }
          },
          tooltip: {
            callbacks: {
              label: function(context) {
                return `${context.dataset.label}: ₱${context.raw}`;
              }
            }
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              callback: function(value) {
                return '₱' + value;
              }
            }
          },
          x: {
            grid: {
              display: false
            }
          }
        }
      }
    });
  </script>
</body>
</html>
