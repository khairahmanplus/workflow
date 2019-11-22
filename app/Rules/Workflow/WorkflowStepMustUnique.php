<?php

namespace App\Rules\Workflow;

use App\Models\Workflow\Workflow;
use App\Models\Workflow\WorkflowStep;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;

class WorkflowStepMustUnique implements Rule
{
    /**
     * The \Illuminate\Http\Request instance.
     *
     * @var  \Illuminate\Http\Request  $request
     */
    protected $request;

    /**
     * The \App\Models\Workflow\Workflow instance.
     *
     * @var  \App\Models\Workflow\Workflow  $workflow
     */
    protected $workflow;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(Request $request, Workflow $workflow)
    {
        $this->request = $request;

        $this->workflow = $workflow;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return WorkflowStep::query()
            ->where('workflow_id', $this->workflow->id)
            ->where('from_document_status_id', $this->request->input('from_document_status'))
            ->where('to_document_status_id', $this->request->input('to_document_status'))
            ->where('step_action_by', $this->request->input('step_action_by'))
            ->doesntExist();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('The workflow step must be unique.');
    }
}
