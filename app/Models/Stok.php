<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
  use HasFactory;
  protected $table = 'stok';
  protected $primaryKey = 'id_stok';
  public $timestamps = false;
}
