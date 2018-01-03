<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'image',
        'description',
        'content',
        'source',
        'file_type',
        'document_status',
        'comment_status',
        'coin',
        'page_count',
        'view_count',
        'download_count',
        'user_id',
    ];

    /**
     * Get the comments for the document
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function termtaxonomy()
    {
        return $this->belongsToMany(
            TermTaxonomy::class,
            'term_taxonomy_documents',
            'term_taxonomy_id',
            'object_id'
        );
    }

    public function favoritedUsers()
    {
        return $this->belongsToMany(User::class);
    }

    public function activities()
    {
        return $this->morphMany(Activity::class, 'activiable');
    }
}
