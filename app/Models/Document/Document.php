<?php

namespace App\Models\Document;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Get all document activities belongs to document.
     *
     * @return  \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function documentActivities()
    {
        return $this->hasMany(DocumentActivity::class, 'document_id', 'id');
    }

    /**
     * Get latest all document activities belongs to document.
     *
     * @return  \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function latestDocumentActivities()
    {
        return $this->documentActivities()->latest();
    }

    /**
     * Get latest document activity belongs to document.
     *
     * @return  \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function latestDocumentActivity()
    {
        return $this->hasOne(DocumentActivity::class, 'document_id', 'id')->latest();
    }

    /**
     * Determine if latest document status is a new one.
     *
     * @return  boolean
     */
    public function isNew()
    {
        return $this->latestDocumentActivity->documentStatus->name == 'New';
    }

    /**
     * Determine if latest document status is a reviewed one.
     *
     * @return  boolean
     */
    public function isReviewed()
    {
        return $this->latestDocumentActivity->documentStatus->name == 'Reviewed';
    }
}
