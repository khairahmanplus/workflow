<?php

namespace App\Models\Module;

use App\Models\Module\Module;
use App\Models\Workflow\Workflow;
use Illuminate\Database\Eloquent\Model;

class ModuleWorkflow extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'module_id',
        'workflow_id'
    ];

    /**
     * Get module belongs to Module Workflow.
     *
     * @return  \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function module()
    {
        return $this->belongsTo(Module::class, 'module_id', 'id')->withDefault();
    }

    /**
     * Get workflow belongs to Module Workflow.
     *
     * @return  \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function workflow()
    {
        return $this->belongsTo(Workflow::class, 'workflow_id', 'id')->withDefault();
    }
}
