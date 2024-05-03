<?php

namespace App\Models;

use App\Filters\V1\OfferFilters;
use Medianet\APIToolKit\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Offer extends Model
{
    use HasFactory, Filterable;

    protected string $default_filters = OfferFilters::class;


    protected $table = 'offres';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];


    public function users()
    {
        return $this->belongsToMany(User::class, 'candidatures', 'offre_id', 'user_id');
    }
}
