<?php

namespace App\Http\Controllers;

use App\Models\Document\Document;
use App\Models\Document\DocumentActivity;
use App\Models\Document\DocumentStatus;
use App\Models\Module\Module;
use App\Models\Module\ModuleWorkflow;
use App\Models\Workflow\WorkflowStep;
use App\Rules\Password\ValidatePassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DocumentApprovalController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Document $document)
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
                ->withErrors($validator)
                ->withInput();
        }

        if ($request->has('action') == 'approval' && $request->has('step-to')) {
            // User
            $user = $request->user();

            // Search module
            $module = Module::query()
                ->where('name', 'Document')
                ->first();

            if (is_null($module)) {
                session()->flash('app::class', 'alert-danger');
                session()->flash('app::message', __('Module doesn\'t exists.'));
                return back();
            }

            // Search module workflow
            $moduleWorkflow = ModuleWorkflow::query()
                ->where('module_id', $module->id)
                ->first();

            if (is_null($moduleWorkflow)) {
                session()->flash('app::class', 'alert-danger');
                session()->flash('app::message', __('Module\'s workflow doesn\'t exists.'));
                return back();
            }

            // Search document status from and to
            $fromDocumentStatus = $document->latestDocumentActivity->documentStatus;
            
            $toDocumentStatus = DocumentStatus::query()
                ->where('label', $request->query('step-to'))
                ->first();

            if (is_null($fromDocumentStatus) && is_null($toDocumentStatus)) {
                session()->flash('app::class', 'alert-danger');
                session()->flash('app::message', __('Invalid workflow action.'));
                return back();
            }

            // Search workflow step
            $workflowStep = WorkflowStep::query()
                ->where('workflow_id', $moduleWorkflow->workflow_id)
                ->where('from_document_status_id', $fromDocumentStatus->id)
                ->where('to_document_status_id', $toDocumentStatus->id)
                ->first();

            if (is_null($workflowStep)) {
                session()->flash('app::class', 'alert-danger');
                session()->flash('app::message', __('Workflow step doesn\'t exists.'));
                return back();
            }

            if (! in_array($workflowStep->step_action_by, $user->roles->modelKeys())) {
                session()->flash('app::class', 'alert-danger');
                session()->flash('app::message', __('You doesn\'t have enough permission to continue.'));
                return back();
            }

            DocumentActivity::create([
                'document_id'           => $document->id,
                'document_status_id'    => $toDocumentStatus->id,
                'action_by'             => $user->id,
            ]);
        }

        session()->flash('app::class', 'alert-success');
        session()->flash('app::message', __('Data successfully updated to the database.'));

        return back();
    }
}
