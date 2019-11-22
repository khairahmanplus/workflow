<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Authorization\Role;
use App\Models\Document\DocumentStatus;
use App\Models\Workflow\Workflow;
use App\Models\Workflow\WorkflowStep;
use App\Rules\Password\ValidatePassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WorkflowController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $workflows = Workflow::paginate();

        return view('workflows.index', [
            'workflows' => $workflows
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => [
                'required',
                'string',
                'max:255'
            ],
        ]);

        if ($validator->fails()) {

            $request->merge([
                'action'    => $request->url()
            ]);

            return back()
                ->withErrors($validator, 'workflowsStore')
                ->withInput();
        }

        $workflow = Workflow::create([
            'name'          => $request->input('name'),
        ]);

        session()->flash('app::class', 'alert-success');
        session()->flash('app::message', __('Data successfully saved to the database.'));

        return redirect()->route('workflows.edit', $workflow);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Workflow\Workflow  $workflow
     * @return \Illuminate\Http\Response
     */
    public function show(Workflow $workflow)
    {
        $workflow->loadMissing('workflowSteps');

        return view('workflows.show', [
            'workflow' => $workflow
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Workflow\Workflow  $workflow
     * @return \Illuminate\Http\Response
     */
    public function edit(Workflow $workflow)
    {
        $workflow->loadMissing('workflowSteps');

        $documentStatuses = DocumentStatus::get();

        $roles = Role::get();

        return view('workflows.edit', [
            'workflow'          => $workflow,
            'documentStatuses'  => $documentStatuses,
            'roles'             => $roles
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Workflow\Workflow  $workflow
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Workflow $workflow)
    {
        $validator = Validator::make($request->all(), [
            'name'      => [
                'required',
                'string',
                'max:255'
            ],
        ]);

        if ($validator->fails()) {

            $request->merge([
                'action'    => $request->url()
            ]);

            return back()
                ->withErrors($validator, 'workflowsUpdate')
                ->withInput();
        }

        $workflow->update([
            'name'          => $request->input('name'),
        ]);

        session()->flash('app::class', 'alert-success');
        session()->flash('app::message', __('Data successfully updated to the database.'));

        return redirect()->route('workflows.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Workflow\Workflow  $workflow
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Workflow $workflow)
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
                ->withErrors($validator, 'workflowsDestroy')
                ->withInput();
        }

        $workflow->workflowSteps->each->delete();

        $workflow->delete();

        session()->flash('app::class', 'alert-success');
        session()->flash('app::message', __('Data successfully deleted from the database.'));

        return back();
    }
}
