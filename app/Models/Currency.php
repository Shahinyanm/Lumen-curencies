<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CurrencyResource
 *
 * @package App\Models
 */
class Currency extends Model
{
    protected $fillable = ['name','english_name','alphabetic_code','digit_code','rate','currency_id'];
}
