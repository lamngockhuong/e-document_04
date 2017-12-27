<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TermTaxonomy extends Model
{
    protected $table = 'term_taxonomy';

    public $timestamps = false;

    protected $fillable = [
        'term_id',
        'taxonomy',
        'description',
        'parent',
    ];

    public function documents()
    {
        return $this->belongsToMany(Document::class, 'term_taxonomy_documents', 'object_id', 'term_taxonomy_id');
    }

    public function term()
    {
        return $this->belongsTo(Term::class);
    }
}
