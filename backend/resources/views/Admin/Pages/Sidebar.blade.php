<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>MIS&SB Sidebar</title>
  <link rel="stylesheet" href="{{asset('css/sidebar.css')}}">
</head>
<body>

  <div class="sidebar-container">
    <div class="Logo">
      <img src="/images/oop_logo.png" alt="Logo" style="height: 120px; width: 120px;">
    </div>

    <div class="nav-wrapper" style="flex: 1; display: flex; flex-direction: column; justify-content: center;">
      <ul>
        <li>
            <a href="{{route('dashboard')}}">
                <img src="/images/dashboard.png" alt="">
            <span class="nav-text">Dashboard</span>
          </a>
        </li>

        <li>
        <a href="{{route('sales')}}">
            <img src="/images/sales.png" alt="">
            <span class="nav-text">Sales</span>
          </a>
        </li>

        <li>
          <a href="{{route('products')}}">
            <img src="assets/components/product.png" alt="">
            <span class="nav-text">Products</span>
          </a>
        </li>

        <li>
        <a href="{{route('orders')}}">
        <img src="/images/order.png" alt="">
            <span class="nav-text">Orders</span>
          </a>
        </li>

        <li>
        <a href="{{route('inventory')}}">
        <img src="assets/components/inventory.png" alt="">
            <span class="nav-text">Inventory</span>
          </a>
        </li>

        <li>
        <a href="">
        <img src="assets/components/expenses.png" alt="">
            <span class="nav-text">Expenses</span>
          </a>
        </li>

      </ul>
    </div>

    <form action="{{route('logout.admin')}}" method="post">
      @csrf
      <button type="submit">
        <img src="assets/components/logout.png" alt="">
      </button>
    </form>
  </div>

  <script>
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      sidebar.classList.toggle('sidebar-hidden');
    }
  </script>

</body>
</html>
