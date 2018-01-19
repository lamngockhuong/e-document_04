<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    protected $fillable = [
        'name',
        'slug',
    ];

    public function termTaxonomy()
    {
        return $this->hasOne(TermTaxonomy::class);
    }

    public function scopeSubCategories($query, $id)
    {
        $subCategories = $query->whereHas('termtaxonomy', function ($q) use ($id) {
            $q->where('taxonomy', 'like', config('setting.category.taxonomy'))
                ->where('parent', '=', $id);
        })->get(['name', 'id']);

        return $subCategories;
    }

}
