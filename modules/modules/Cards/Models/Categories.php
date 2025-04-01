<?php

namespace Modules\Cards\Models;

use App\Models\TranslateAwareModel;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;


class Categories extends TranslateAwareModel implements Sortable
{

    use SortableTrait;
    use SoftDeletes;

    protected $table = 'categories';
    public $fillable = ['name','restorant_id','created_at','updated_at','percent','staticpoints','threshold'];
    public $translatable = ['name'];

    public $sortable = [
        'order_column_name' => 'order_index',
        'sort_when_creating' => true,
    ];

    //Used for sort grouping
    public function buildSortQuery()
    {
        return static::query()->where('restorant_id', $this->restorant_id);
    }



    public function restorant()
    {
        return $this->belongsTo(\App\Restorant::class);
    }
}
