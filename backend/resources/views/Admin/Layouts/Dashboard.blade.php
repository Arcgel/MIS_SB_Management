<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{asset('css/dashboard.css')}}">
  <link rel="shortcut icon" href="{{asset('/images/oop_logo.png')}}" type="image/x-icon" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      min-height: 100vh;
      display: flex;
    }

    .content-wrapper {
      margin-left: 250px;
      width: 100%;
      padding: 30px;
    }

    .main-container {
      flex: 1;
      padding: 2rem;
    }

    h1 {
      font-size: 25px;
      font-weight: 600;
      color: #ff5e78;
      margin-bottom: 0.5rem;
    }

    .welcome-text {
      font-family: 'Playfair Display', serif;
      font-size: 30px;
      font-weight: bold;
      margin-bottom: 2rem;
      background: linear-gradient(to right, #ff5e78, #ff6ec7);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
      display: inline-block;
    }

    .cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 20px;
      margin-bottom: 2rem;
    }

    .card {
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 6px 18px rgba(255, 94, 120, 0.2);
      padding: 1.8rem;
      transition: all 0.3s ease-in-out;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .card:hover {
      transform: translateY(-6px);
      box-shadow: 0 12px 24px rgba(255, 94, 120, 0.3);
    }

    .card-title {
      font-size: 20px;
      font-weight: 600;
      color: #ff5e78;
      margin-bottom: 1rem;
    }

    .stat-container {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1rem;
    }

    .stat-value {
      font-size: 28px;
      font-weight: 700;
      background: linear-gradient(to right, #ff5e78, #ff6ec7);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
    }

    .stat-label {
      font-size: 14px;
      color: #777;
    }

    .trend-up {
      color: #4caf50;
      font-size: 14px;
      font-weight: 500;
    }

    .trend-down {
      color: #f44336;
      font-size: 14px;
      font-weight: 500;
    }

    .chart-container {
      width: 100%;
      height: 250px;
      margin-top: auto;
    }

    .card:nth-child(3) {
      grid-column: span 2;
      height: 400px;
    }

    @media (max-width: 768px) {
      .card:nth-child(3) {
        grid-column: span 1;
        height: auto;
      }
    }
  </style>
</head>
<body>
  <aside>
    @include('Admin.Pages.Sidebar')
  </aside>

  <div class="content-wrapper">
    <div class="main-container">
      <div class="welcome-text">Welcome Back, {{ Auth::user()->name }}!</div>
      <h1>Dashboard</h1>

      <div class="cards">
        <div class="card">
          <div class="card-title">Order Received</div>
          <div class="stat-container">
            <div><div class="stat-value">₱1,832</div></div>
            <div class="trend-up">+12.5% ↑</div>
          </div>
          <div class="chart-container"><canvas id="orderChart"></canvas></div>
        </div>

        <div class="card">
          <div class="card-title">Sales Summary</div>
          <div class="stat-container">
            <div><div class="stat-value">₱1,356,800</div></div>
            <div class="trend-up">+8.2% ↑</div>
          </div>
          <div class="chart-container"><canvas id="salesChart"></canvas></div>
        </div>

        <div class="card">
          <div class="card-title">Best Sellers</div>
          <div class="chart-container"><canvas id="bestSellersChart"></canvas></div>
        </div>
      </div>
    </div>
  </div>

  <script>
    const orderChart = new Chart(document.getElementById('orderChart'), {
      type: 'line',
      data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        datasets: [{
          label: 'Orders',
          data: [125, 232, 348, 290, 410, 427],
          backgroundColor: 'rgba(255, 94, 120, 0.1)',
          borderColor: '#ff5e78',
          borderWidth: 2,
          tension: 0.4,
          fill: true,
          pointBackgroundColor: '#ffffff',
          pointBorderColor: '#ff5e78',
          pointBorderWidth: 2,
          pointRadius: 4,
          pointHoverRadius: 6
        }]
      },
      options: {
        maintainAspectRatio: false,
        plugins: {
          legend: { display: false },
          tooltip: {
            backgroundColor: '#333',
            titleColor: '#fff',
            bodyColor: '#fff',
            padding: 12,
            cornerRadius: 8,
            displayColors: false,
            callbacks: {
              label: function(context) {
                return '₱' + context.parsed.y;
              }
            }
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            grid: {
              display: true,
              color: 'rgba(0, 0, 0, 0.05)',
              drawBorder: false
            },
            ticks: {
              font: { family: 'Poppins', size: 11 },
              color: '#777',
              callback: function(value) {
                return '₱' + value;
              }
            }
          },
          x: {
            grid: { display: false },
            ticks: {
              font: { family: 'Poppins', size: 11 },
              color: '#777'
            }
          }
        }
      }
    });

    const salesChart = new Chart(document.getElementById('salesChart'), {
      type: 'bar',
      data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        datasets: [{
          label: 'Revenue',
          data: [235000, 289000, 310000, 256000, 199000, 267800],
          backgroundColor: function(context) {
            const chart = context.chart;
            const { ctx, chartArea } = chart;
            if (!chartArea) return;
            const gradient = ctx.createLinearGradient(0, 0, 0, chartArea.bottom);
            gradient.addColorStop(0, 'rgba(255, 110, 199, 0.8)');
            gradient.addColorStop(1, 'rgba(255, 94, 120, 0.8)');
            return gradient;
          },
          borderRadius: 6,
          maxBarThickness: 18
        }]
      },
      options: {
        maintainAspectRatio: false,
        plugins: {
          legend: { display: false },
          tooltip: {
            backgroundColor: '#333',
            titleColor: '#fff',
            bodyColor: '#fff',
            padding: 12,
            cornerRadius: 8,
            displayColors: false,
            callbacks: {
              label: function(context) {
                const value = context.parsed.y;
                return `₱${value.toLocaleString()}`;
              }
            }
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            grid: {
              display: true,
              color: 'rgba(0, 0, 0, 0.05)',
              drawBorder: false
            },
            ticks: {
              font: { family: 'Poppins', size: 11 },
              color: '#777',
              callback: value => `₱${value.toLocaleString()}`
            }
          },
          x: {
            grid: { display: false },
            ticks: {
              font: { family: 'Poppins', size: 11 },
              color: '#777'
            }
          }
        }
      }
    });

    const bestSellersChart = new Chart(document.getElementById('bestSellersChart'), {
      type: 'bar',
      data: {
        labels: ['Ice Scramble', 'Shakes', 'Drinks', 'Snack Bites'],
        datasets: [{
          label: 'Sold',
          data: [320, 280, 150, 190, 220],
          backgroundColor: ['#ff5e78', '#ffc0cb', '#ffa6c1', '#ff8da1'],
          borderRadius: 6,
          barThickness: 25
        }]
      },
      options: {
        indexAxis: 'y',
        maintainAspectRatio: false,
        plugins: {
          legend: { display: false },
          tooltip: {
            backgroundColor: '#333',
            titleColor: '#fff',
            bodyColor: '#fff',
            padding: 12,
            cornerRadius: 8,
            displayColors: false
          }
        },
        scales: {
          x: {
            beginAtZero: true,
            grid: {
              display: true,
              color: 'rgba(0, 0, 0, 0.05)',
              drawBorder: false
            },
            ticks: {
              font: { family: 'Poppins', size: 11 },
              color: '#777'
            }
          },
          y: {
            ticks: {
              font: { family: 'Poppins', size: 11 },
              color: '#777'
            },
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
