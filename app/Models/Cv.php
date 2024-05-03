<?php

namespace App\Models;

use App\Filters\V1\CvFilters;
use Medianet\APIToolKit\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Cv extends Model
{
    use HasFactory, Filterable;

    protected string $default_filters = CvFilters::class;

    /**
     * Mass-assignable attributes.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
