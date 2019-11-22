<?php

namespace App\Models\Workflow;

use App\Models\Authorization\Role;
use App\Models\Document\DocumentStatus;
use Illuminate\Database\Eloquent\Model;

class WorkflowStep extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'workflow_id',
        'from_document_status_id',
        'to_document_status_id',
        'step_action_by'
    ];

    /**
     * Get workflow for the workflow step.
     *
     * @return  \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function workflow()
    {
        return $this->belongsTo(Workflow::class, 'workflow_id', 'id')->withDefault();
    }

    /**
     * Get from document status for the workflow step.
     *
     * @return  \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fromDocumentStatus()
    {
        return $this->belongsTo(DocumentStatus::class, 'from_document_status_id', 'id')->withDefault();
    }

    /**
     * Get to document status for the workflow step
     *
     * @return  \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function toDocumentStatus()
    {
        return $this->belongsTo(DocumentStatus::class, 'to_document_status_id', 'id')->withDefault();
    }

    /**
     * Get role for the workflow step.
     *
     * @return  \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function stepActionBy()
    {
        return $this->belongsTo(Role::class, 'step_action_by', 'id')->withDefault();
    }
}
