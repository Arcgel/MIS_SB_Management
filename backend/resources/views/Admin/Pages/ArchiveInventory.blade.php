<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Archives</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/archiveinventory.css')}}">
    <link rel="shortcut icon" href="{{asset('/images/oop_logo.png')}}" type="image/x-icon">
</head>

<body>

    <div class="back">
        <a href="/inventory">
            <img src="/images/back.png" alt="Back to Inventory">
        </a>
    </div>

    <h1>INVENTORY ARCHIVES</h1>

    <div class="inventorys-archives-table">
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
                @if(count($archive_inventories) > 0)
                @foreach($archive_inventories as $inventory)
                <tr>
                    <td>{{ $inventory->itemName }}</td>
                    <td>{{ $inventory->itemUnit }}</td>
                    <td>{{ $inventory->inventoryStock }}</td>
                    <td><span class="status status-in-stock">In Stock</span></td>
                    <td>{{ $inventory->inventoryDateAdded }}</td>
                    <td><span class="expirationDate">{{ $inventory->inventoryExpirationDate }}</span></td>
                    <td>
                        <div class="action-btn">
                            <form action="/restoreinventory/{{$inventory->id}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="restore">
                                    <img src="/images/restore.png" alt="Restore">
                                    Restore
                                </button>
                            </form>

                            <form action="/deleteinventory/{{$inventory->id}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete">
                                    <img src="/images/delete.png" alt="Delete">
                                Delete
                            </button>
                            </form>
                           
                        </div>
                    </td>
                </tr>
                @endforeach

                @else
                <tr>
                    <td colspan="7" style="text-align: center;" class="no-data">No archived inventories found.</td>
                </tr>
                @endif

            </tbody>
        </table>
    </div>

</body>

</html>