<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archive Products</title>
    <link rel="stylesheet" href="{{asset('css/archive-products.css')}}">
    <link rel="shortcut icon" href="{{asset('/images/oop_logo.png')}}" type="image/x-icon">
</head>

<body>
    @if(session('success'))
    <script>
        alert('{{session("success")}}');
    </script>
    @endif

    <div class="container">
        <a href="{{route('products')}}" class="back-link">
            <img src="/images/back.png" alt="Back">
        </a>
        
        <h1>PRODUCT ARCHIVES</h1>
        
        <table class="table" id="productTable">
            <thead>
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
                @if(count($archive_products) > 0)
                @foreach($archive_products as $archive)
                <tr>
                    <td>{{ $archive->Itemcode }}</td>
                    <td>
                        <img src="{{asset('/images/' . $archive->Image) }}" alt="{{$archive->Item_Name}}" class="product-img">
                    </td>
                    <td>{{ $archive->Item_Name }}</td>
                    <td>{{ $archive->Category }}</td>
                    <td>₱{{ number_format($archive->Unit_Price, 2) }}</td>
                    <td>{{ $archive->Quantity }}</td>
                    <td>{{ $archive->Description }}</td>
                    <td class="action-buttons">
                        <form action="{{route('restore.item' , $archive->Itemcode)}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="restore-btn">
                                <img src="/images/restore.png" alt="Restore"> Restore
                            </button>
                        </form>
                        <form action="{{route('delete.item', $archive->Itemcode)}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-btn">
                                <img src="/images/delete.png" alt="Delete"> Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="8" style="text-align:center;">No products available</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</body>

</html>
