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
        return asset(config('setting.document_image_folder') . DIRECTORY_SEPARATOR . $this->image);
    }

    public function getDefaultImageUrlAttribute()
    {
        return asset('templates/e-document/images/doc_normal.png');
    }

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = str_slug($value);
    }

    public function getDetailUrlAttribute()
    {
        return route('document.detail', [str_slug($this->attributes['title']), $this->attributes['id']]);
    }

    public function getDocumentSourceAttribute()
    {
        return asset(config('setting.storage_folder') . DIRECTORY_SEPARATOR . $this->attributes['source']);
    }

    public function getFileRealPathAttribute()
    {
        return storage_path(config('setting.storage_public_folder') . DIRECTORY_SEPARATOR . $this->attributes['source']);
    }

    public function getDocumentDownloadUrl($token)
    {
        return route('document.download', [$token, $this->attributes['id']]);
    }

    public function getDownloadFileNameAttribute()
    {
        return str_slug($this->attributes['title']) . '-' . time() . '.' . $this->attributes['file_type'];
    }

    public function getUploadDateAttribute()
    {
        $time = strtotime($this->attributes['created_at']);

        return date('H:i d/m/Y', $time);
    }

    public function scopeOfStatus($query, $status)
    {
        return $query->where('document_status', $status)->where('user_id', auth()->user()->id);
    }
}
