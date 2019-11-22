<?php

namespace App\Models\Workflow;

use Illuminate\Database\Eloquent\Model;

class Workflow extends Model
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
     * Get all workflow steps for the workflow.
     *
     * @return  \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function workflowSteps()
    {
        return $this->hasMany(WorkflowStep::class, 'workflow_id', 'id');
    }
}
