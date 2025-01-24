<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
  use HasFactory;

  protected $table = 'configs';
  protected $fillable = ['nama', 'label', 'value', 'type'];
  protected $appends = ['file_path'];

  public function getFilePathAttribute()
  {
    if ($this->type == 2) {
      if ($this->value != null) {
        return asset('storage/' . $this->value);
      } else {
        return asset('default/null/notfound.png');
      }
    }
  }
}
