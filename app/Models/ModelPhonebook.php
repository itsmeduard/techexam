<?php
namespace App\Models;
use Illuminate\Database\Eloquent\{ Model };
class ModelPhonebook extends Model
{
    protected $table='phonebook';

    protected $fillable = [
        'title',
        'firstname',
        'lastname',
        'mobilenum',
        'companyname',
    ];
}
