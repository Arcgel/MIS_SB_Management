<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/inventory.css')}}">
    <link rel="shortcut icon" href="{{asset('/images/oop_logo.png')}}" type="image/x-icon">
</head>

<body>
    <aside>
        @include('Admin.Pages.Sidebar')
    </aside>

    @if(session('success'))
        <script>alert("{{session('success')}}")</script>
    @endif

    @if(session('error'))
        <script>alert("{{session('error')}}")</script>
    @endif

    <div class="content-wrapper">
        <div class="title">
            <div class="brandName">
                <h1>Inventory</h1>
            </div>
        </div>

        <div class="action-bar">
            <a href="#" id="createNewOrderLink">
                <button class="btn"><span class="btn-icon">+</span> Add New inventory</button>
            </a>
            <a href="/archiveinventory" id="archiveinventory">
                <button class="btn"><img src="/images/archives.png" alt="Archives">Archives</button>
            </a>
        </div>

        <!-- Inventor Table   -->
        <div class="inventorys-table">
            <table>
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Unit</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Date Added</th>
                        <th>Expiration Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($inventories) > 0)
                    @foreach($inventories as $inventory)
                    <tr>
                        <td>{{$inventory->itemName}}</td>
                        <td>{{$inventory->itemUnit}}</td>
                        <td>{{$inventory->inventoryStock}}</td>
                        <td><span class="status status-in-stock">In Stock</span></td>
                        <td>{{$inventory->inventoryDateAdded}}</td>
                        <td><span class="expirationDate">{{$inventory->inventoryExpirationDate}}</span></td>
                        <td>
                            <div class="action-btn">
                                <button class="edit" onclick="editInventory('{{$inventory->id}}' , '{{$inventory->itemName}}' , '{{$inventory->itemUnit}}' , '{{$inventory->inventoryStock}}' , '{{$inventory->inventoryDateAdded}}' , '{{$inventory->inventoryExpirationDate}}')">
                                    <img src="/images/edit.png" alt="Edit">
                                    Edit
                                </button>
                                <form action="/archiveinventory/{{$inventory->id}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="archive">
                                        <img src="/images/archive.png" alt="Archive">
                                        Archive
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="7" style="text-align: center;" class="no-data">No Inventory Data Available</td>
                    </tr>
                    @endif

                </tbody>
            </table>
        </div>
    </div>

    <!--Add New Inventory Form -->
    <div id="new-inventory-form">
        <button type="button" id="closeNewFormButton">
            <img src="/images/close.png" alt="Close">
        </button>
        <h2>Add Item to Inventory</h2>
        <form action="{{route('add.inventory')}}" method="POST">
            @csrf
            <div>
                <label for="newItemName">Item Name</label>
                <input type="text" id="newItemName" name="itemName" placeholder="Enter Item Name">
            </div>
            <div>
                <label for="newItemUnit">Unit</label>
                <input type="text" id="newItemUnit" name="itemUnit" placeholder="Input Unit">
            </div>
            <div>
                <label for="newInventoryStock">Stock</label>
                <input type="number" id="newInventoryStock" name="inventoryStock" placeholder="Input Stock">
            </div>
            <div>
                <label for="newInventoryDateAdded">Date Added</label>
                <input type="date" id="newInventoryDateAdded" name="inventoryDateAdded">
            </div>
            <div>
                <label for="newInventoryExpirationDate">Expiration Date</label>
                <input type="date" id="newInventoryExpirationDate" name="inventoryExpirationDate">
            </div>
            <button type="submit">Add</button>
        </form>
    </div>


    <!--Edit Inventory Form -->
    <div id="edit-inventory-form">
        <button type="button" id="closeEditFormButton">
            <img src="/images/close.png" alt="Close">
        </button>
        <h2>Edit Item</h2>
        <form action="" method="POST">
            @csrf
            @method('PUT')
            <div>
                <label for="editItemName">Item Name</label>
                <input type="text" id="editItemName" name="itemName" placeholder="Enter Item Name">
            </div>
            <div>
                <label for="editItemUnit">Unit</label>
                <input type="text" id="editItemUnit" name="itemUnit" placeholder="Input Unit">
            </div>
            <div>
                <label for="editInventoryStock">Current Stock</label>
                <input type="number" id="editInventoryStock" name="inventoryStock" placeholder="Input Stock">
            </div>
            <div>
                <label for="editInventoryDateAdded">Date Added</label>
                <input type="date" id="editInventoryDateAdded" name="inventoryDateAdded">
            </div>
            <div>
                <label for="editInventoryExpirationDate">Expiration Date</label>
                <input type="date" id="editInventoryExpirationDate" name="inventoryExpirationDate">
            </div>
            <button type="submit">Save Changes</button>
        </form>
    </div>

    <script>
        document.getElementById('createNewOrderLink').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('new-inventory-form').style.display = 'block';
        });

        document.getElementById('closeNewFormButton').addEventListener('click', function() {
            document.getElementById('new-inventory-form').style.display = 'none';
        });

        const editButtons = document.querySelectorAll('.edit');
        const editForm = document.getElementById('edit-inventory-form');
        const closeEditFormButton = document.getElementById('closeEditFormButton');

        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                editForm.style.display = 'block';
            });
        });

        closeEditFormButton.addEventListener('click', function() {
            editForm.style.display = 'none';
        });


        function editInventory(id, itemName, itemUnit, inventoryStock, inventoryDateAdded, inventoryExpirationDate) {
            const editForm = document.querySelector('#edit-inventory-form form');
            editForm.action = `/updateinventory/${id}`;
            document.getElementById('editItemName').value = itemName;
            document.getElementById('editItemUnit').value = itemUnit;
            document.getElementById('editInventoryStock').value = inventoryStock;
            document.getElementById('editInventoryDateAdded').value = inventoryDateAdded;
            document.getElementById('editInventoryExpirationDate').value = inventoryExpirationDate;
        }
    </script>
</body>

</html>
