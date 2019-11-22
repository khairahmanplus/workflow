<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Authorization\Role;
use App\Models\Document\DocumentStatus;
use App\Models\Workflow\Workflow;
use App\Models\Workflow\WorkflowStep;
use App\Rules\Password\ValidatePassword;
use App\Rules\Workflow\WorkflowStepMustUnique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class WorkflowStepController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Workflow $workflow)
    {
        $validator = Validator::make($request->all(), [
            'from_document_status'      => [
                'required',
                Rule::in(DocumentStatus::pluck('id')),
                new WorkflowStepMustUnique($request, $workflow)
            ],
            'to_document_status'        => [
                'required',
                Rule::in(DocumentStatus::pluck('id')),
                new WorkflowStepMustUnique($request, $workflow),
            ],
            'step_action_by'            => [
                'required',
                Rule::in(Role::pluck('id')),
                new WorkflowStepMustUnique($request, $workflow),
            ]
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator, 'workflowStepsStore')
                ->withInput();
        }

        WorkflowStep::create([
            'workflow_id'               => $workflow->id,
            'from_document_status_id'   => $request->input('from_document_status'),
            'to_document_status_id'     => $request->input('to_document_status'),
            'step_action_by'            => $request->input('step_action_by'),
        ]);

        session()->flash('app::message', __('Data successfully saved to the database.'));

        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Workflow\WorkflowStep  $workflowStep
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Workflow $workflow, WorkflowStep $workflowStep)
    {
        $validator = Validator::make($request->all(), [
            'from_document_status'      => [
                'required',
                Rule::in(DocumentStatus::pluck('id')),
                new WorkflowStepMustUnique($request, $workflow)
            ],
            'to_document_status'        => [
                'required',
                Rule::in(DocumentStatus::pluck('id')),
                new WorkflowStepMustUnique($request, $workflow),
            ],
            'step_action_by'            => [
                'required',
                Rule::in(Role::pluck('id')),
                new WorkflowStepMustUnique($request, $workflow),
            ]
        ]);

        if ($validator->fails()) {

            $request->merge([
                'action'    => $request->url()
            ]);

            return back()
                ->withErrors($validator, 'workflowStepsUpdate')
                ->withInput();
        }

        $workflowStep->update([
            'from_document_status_id'   => $request->input('from_document_status'),
            'to_document_status_id'     => $request->input('to_document_status'),
            'step_action_by'            => $request->input('step_action_by'),
        ]);

        session()->flash('app::message', __('Data successfully updated to the database.'));

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Workflow\WorkflowStep  $workflowStep
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Workflow $workflow, WorkflowStep $workflowStep)
    {
        $validator = Validator::make($request->all(), [
            'password' => [
                'required',
                new ValidatePassword
            ],
        ]);

        if ($validator->fails()) {

            $request->merge([
                'action'    => $request->url()
            ]);

            return back()
                ->withErrors($validator, 'workflowStepsDestroy')
                ->withInput();
        }

        $workflowStep->delete();

        session()->flash('app::class', 'alert-success');
        session()->flash('app::message', __('Data successfully deleted from the database.'));

        return back();
    }
}
