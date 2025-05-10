<?php

namespace App\Http\Controllers\Inventory;

use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ArchiveInventory;
use Illuminate\Support\Facades\Validator;

class InventoryController extends Controller
{
    public function AddInventory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'itemName' => 'required|string|max:255',
            'itemUnit' => 'required|string|max:50',
            'inventoryStock' => 'required|integer|min:0',
            'inventoryDateAdded' => 'required|date',
            'inventoryExpirationDate' => 'required|date|after:inventoryDateAdded',
        ]);


        if($validator->fails()) {
            return redirect()->route('inventory')->with('error', $validator->errors());
        }

        $addInventory =  Inventory::create([
            'itemName' => $request->itemName,
            'itemUnit' => $request->itemUnit,
            'inventoryStock' => $request->inventoryStock,
            'inventoryDateAdded' => $request->inventoryDateAdded,
            'inventoryExpirationDate' => $request->inventoryExpirationDate,
        ]);

        return redirect()->route('inventory')->with('success', 'Inventory added successfully');
    }

    public function UpdateInventory(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'itemName' => 'required|string|max:255',
            'itemUnit' => 'required|string|max:50',
            'inventoryStock' => 'required|integer|min:0',
            'inventoryDateAdded' => 'required|date',
            'inventoryExpirationDate' => 'required|date',
        ]);

        if($validator->fails()) {
            return redirect()->route('inventory')->with('error', $validator->errors());
        }

        $updateInventory = Inventory::findOrFail($id);

        $updateInventory->update([
            'itemName' => $request->itemName,
            'itemUnit' => $request->itemUnit,
            'inventoryStock' => $request->inventoryStock,
            'inventoryDateAdded' => $request->inventoryDateAdded,
            'inventoryExpirationDate' => $request->inventoryExpirationDate,
        ]);

        return redirect()->route('inventory')->with('success', 'Inventory updated successfully');
    }

    public function ArchiveInventory($id)
    {
        $deleteInventory = Inventory::findOrFail($id);
        $deleteInventory->delete();

        ArchiveInventory::insert([
            'inventoryID' => $deleteInventory->id,
            'itemName' => $deleteInventory->itemName,
            'itemUnit' => $deleteInventory->itemUnit,
            'inventoryStock' => $deleteInventory->inventoryStock,
            'inventoryDateAdded' => $deleteInventory->inventoryDateAdded,
            'inventoryExpirationDate' => $deleteInventory->inventoryExpirationDate,
        ]);

        return redirect()->route('inventory')->with('success', 'Inventory archived successfully');
    }

    public function RestoreInventory($id)
    {
        $restoreInventory = ArchiveInventory::findOrFail($id);
        $restoreInventory->delete();

        Inventory::insert([
            'id' => $restoreInventory->id,
            'itemName' => $restoreInventory->itemName,
            'itemUnit' => $restoreInventory->itemUnit,
            'inventoryStock' => $restoreInventory->inventoryStock,
            'inventoryDateAdded' => $restoreInventory->inventoryDateAdded,
            'inventoryExpirationDate' => $restoreInventory->inventoryExpirationDate,
        ]);

        return redirect()->route('archiveinventory')->with('success', 'Inventory restore successfully');
    }

    public function DeleteInventory($id)
    {
        $deleteInventory = ArchiveInventory::findOrFail($id);
        $deleteInventory->delete();

        return redirect()->route('archiveinventory')->with('success', 'Inventory deleted successfully');
    }
}
