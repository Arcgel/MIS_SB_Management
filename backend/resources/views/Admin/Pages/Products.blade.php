<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MIS&SB Products</title>
    <link rel="stylesheet" href="{{asset('css/products.css')}}">
    <link rel="shortcut icon" href="{{asset('assets/components/oop_logo.png')}}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <aside>
        @include('Admin.Pages.Sidebar')
    </aside>

    @if(session('success'))
    <script>
        alert("{{session('success')}}")
    </script>
    @endif
    @if(session('error'))
    <script>
        alert("{{session('error')}}")
    </script>
    @endif
    <main class="main-content">
        <div class="header-section">
            <h1 class="h3 mb-3">MIS & SB Product Management</h1>
            <div>
                <button class="btn btn-primary" onclick="toggleForm('addProductForm')">
                    <i class="fas fa-plus"></i> Add Product
                </button>
                <a href="{{route('archive-products')}}" class="btn btn-warning">
                    <i class="fas fa-archive"></i> Archive
                </a>
            </div>
        </div>

        <section>
            @if (!$products->isEmpty())
            <nav class="category-nav-container">
                <ul class="category-nav">
                    <li>
                        <button class="filter-btn active" onclick="filterProducts('all', event)">
                            All
                        </button>
                    </li>
                    @foreach ($categories as $category)
                    <li>
                        <button class="filter-btn" onclick="filterProducts('{{ $category }}', event)">
                            {{ $category }}'s
                        </button>
                    </li>
                    @endforeach
                </ul>
            </nav>
            @endif
        </section>

        <!--Table Products-->
        <h1 id="categoryTitle">All Products</h1>
        <div class="table-responsive">
            <table class="table table-hover" id="productTable">
                <thead class="table-light">
                    <tr>
                        <th>Item Code</th>
                        <th>Image</th>
                        <th>Item Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($products) > 0)
                    @foreach($products as $product)
                    <tr>
                        <td>{{ $product->Itemcode }}</td>
                        <td>
                            <img src="{{asset('/images/' . $product->Image) }}" alt="{{$product->Item_Name}}" class="product-img">
                        </td>
                        <td>{{ $product->Item_Name }}</td>
                        <td>{{ $product->Category }}</td>
                        <td>₱{{ number_format($product->Unit_Price, 2) }}</td>
                        <td>{{ $product->Quantity }}</td>
                        <td>{{ $product->Description }}</td>
                        <td class="action-buttons">
                            <button
                                onclick="EditForm(
                                    '{{$product->Itemcode}}',
                                    '{{$product->Item_Name}}',
                                    '{{$product->Category}}',
                                    '{{$product->Unit_Price}}',
                                    '{{$product->Quantity}}',
                                    '{{$product->Description}}',
                                    '{{$product->Image}}')"

                                class="btn btn-sm btn-success">
                                <i class="fas fa-edit"></i> Edit
                            </button>

                            <form action="{{ route('archive.item', $product->Itemcode) }}" method="post" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-archive"></i> Archive
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="8" class="text-center">No products available</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Add Product Section -->
        <div id="addProductForm" class="form-container">
            <h4 class="fa fa-plus mb-4">Add New Product</h4>
            <form action="{{route('create.item')}}" enctype="multipart/form-data" method="post" class="row g-3">
            @csrf
            <div class="col-md-6">
                <label class="form-label">Product Name</label>
                <input type="text" name="Item_Name" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Price</label>
                <input type="number" name="Unit_Price" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Category</label>
                <input type="string" name="Category" class="form-control" required>
            </div>
         
            <div class="col-md-6">
                <label class="form-label">Quantity</label>
                <input type="number" name="Quantity" class="form-control" required>
            </div>
            <div class
                    <label class="form-label">Description</label>
                    <input type="text" name="Description" class="form-control" required>
                </div>
                <div class="col-12">
                    <label class="form-label">Product Image</label>
                    <input type="file" name="Image" class="form-control" accept="image/*" onchange="previewImage(event, 'img3')">
                    <img id="img3" src="" alt="" class="mt-2 product-img">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Add Product</button>
                </div>
            </form>
        </div>

        <!-- Update Product Section -->
        <div id="editProductForm" class="form-container" style="display: none; position:absolute; margin-top:-20%; width:50%; margin-left:15%;">
            <h4 class="fas fa-edit mb-4"> Edit Product</h4>
            <form id="submitForm" method="post" class="row g-3" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="number" name="Itemcode" id="editItemCode" hidden>

                <div class="col-md-6">
                    <label class="form-label">Item Name</label>
                    <input type="text" name="Item_Name" id="editItemName" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Price</label>
                    <input type="number" name="Unit_Price" id="editPrice" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Category</label>
                    <input type="text" name="Category" id="editCategory" class="form-control" readonly>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Quantity</label>
                    <input type="number" name="Quantity" id="editQuantity" class="form-control" required>
                </div>

                <div class="col-12">
                    <label class="form-label">Description</label>
                    <input type="text" name="Description" id="editDescription" class="form-control" required>
                </div>

                <div class="col-12">
                    <input type="file" name="Image" accept="image/*" onchange="previewImage(event, 'editImage')" required>

                </div>
                <div class="col-12">
                    <img id="editImage" src="" alt="Product Image" class="product-img mt-2">
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Update Product
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="toggleForm('editProductForm')">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                </div>
            </form>
        </div>
    </main>

    <!-- Add Bootstrap JS and FontAwesome -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/your-code.js"></script>
    <script>
        function previewImage(event, imgId) {
            const reader = new FileReader();
            reader.onload = function() {
                document.getElementById(imgId).src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        function EditForm(Itemcode, Item_Name, Category, Price, Stock, Description, Image) {
            document.getElementById('editProductForm').style.display = 'block'
            document.getElementById('submitForm').action = `/update/products/${Itemcode}`
            document.getElementById('editItemCode').value = Itemcode
            document.getElementById('editItemName').value = Item_Name
            document.getElementById('editPrice').value = Price
            document.getElementById('editCategory').value = Category
            document.getElementById('editQuantity').value = Stock
            document.getElementById('editDescription').value = Description
            document.getElementById('editImage').src = "{{ asset('images/') }}/" + Image
        }


        function toggleForm(formId) {
            const form = document.getElementById(formId);
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }

        function previewImage(event, imgId) {
            const reader = new FileReader();
            reader.onload = function() {
                document.getElementById(imgId).src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        function filterProducts(category, event) {
            document.querySelectorAll('nav .filter-btn').forEach(btn => {
                btn.classList.remove('active');
            });

            event.target.classList.add('active');

            // Update the heading
            const categoryTitle = document.getElementById('categoryTitle');
            categoryTitle.textContent = category === 'all' ? 'All Products' : category;

            let table = document.getElementById('productTable');
            let tr = table.getElementsByTagName('tr');

            for (let i = 1; i < tr.length; i++) {
                let categoryCell = tr[i].getElementsByTagName('td')[3];
                if (categoryCell) {
                    let categoryValue = categoryCell.textContent || categoryCell.innerText;

                    if (category === 'all' || categoryValue.trim() === category) {
                        tr[i].style.display = '';
                    } else {
                        tr[i].style.display = 'none';
                    }
                }
            }
        }
    </script>
</body>

</html>