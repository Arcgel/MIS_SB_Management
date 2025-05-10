<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{

    protected $table = 'inventories';
    protected $primaryKey = 'id';

    protected $fillable = [
        'itemName',
        'itemUnit',
        'inventoryStock',
        'inventoryDateAdded',
        'inventoryExpirationDate',
    ];

}
