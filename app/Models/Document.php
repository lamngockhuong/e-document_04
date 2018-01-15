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

    public function termTaxonomys()
    {
        return $this->belongsToMany(
            TermTaxonomy::class,
            'term_taxonomy_documents',
            'object_id',
            'term_taxonomy_id'
        )->withPivot('object_id');
    }

    public function favoritedUsers()
    {
        return $this->belongsToMany(User::class);
    }

    public function activities()
    {
        return $this->morphMany(Activity::class, 'activiable');
    }

    /**
     * Get image url
     * @return string
     */
    public function getImageUrlAttribute()
    {
        return asset(config('setting.avatar_folder') . '/' . $this->image);
    }

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = str_slug($value);
    }
}
