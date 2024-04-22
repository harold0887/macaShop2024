<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageAsProduct extends Model
{
    protected $guarded= [];
    protected $table = 'package_product';
    use HasFactory;
}
