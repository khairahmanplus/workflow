<?php

namespace App\Models\Document;

use App\User;
use Illuminate\Database\Eloquent\Model;

class DocumentActivity extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'document_id',
        'document_status_id',
        'action_by',
    ];

    /**
     * Get all permissions belongs to role.
     *
     * @return  \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function documentStatus()
    {
        return $this->belongsTo(DocumentStatus::class, 'document_status_id', 'id')->withDefault();
    }

    /**
     * Get all permissions belongs to role.
     *
     * @return  \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function actionBy()
    {
        return $this->belongsTo(User::class, 'action_by', 'id')->withDefault();
    }
}
