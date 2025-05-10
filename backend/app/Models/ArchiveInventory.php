<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArchiveInventory extends Model
{
    protected $table = 'archive_inventories';

    protected $fillable = [
        'inventoryID',
        'itemName',
        'itemUnit',
        'inventoryStock',
        'inventoryDateAdded',
        'inventoryExpirationDate',
    ];
}
