<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Module\Module;
use App\Models\Module\ModuleWorkflow;
use App\Models\Workflow\Workflow;
use App\Rules\Password\ValidatePassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ModuleWorkflowController extends Controller
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
        $moduleWorkflows = ModuleWorkflow::paginate();

        return view('module_workflows.index', [
            'moduleWorkflows'   => $moduleWorkflows
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modules = Module::get();

        $workflows = Workflow::get();

        return view('module_workflows.create', [
            'modules'   => $modules,
            'workflows' => $workflows
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'module'        => [
                'required',
                Rule::in(Module::pluck('id'))
            ],
            'workflow'      => [
                'required',
                Rule::in(Workflow::pluck('id'))
            ]
        ]);

        ModuleWorkflow::create([
            'module_id'     => $request->input('module'),
            'workflow_id'   => $request->input('workflow'),
        ]);

        session()->flash('app::class', 'alert-success');
        session()->flash('app::message', __('Data successfully saved to the database.'));

        return redirect()->route('module-workflows.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Module\ModuleWorkflow  $moduleWorkflow
     * @return \Illuminate\Http\Response
     */
    public function show(ModuleWorkflow $moduleWorkflow)
    {
        $moduleWorkflow->loadMissing([
            'module',
            'workflow'
        ]);

        return view('module_workflows.show', [
            'moduleWorkflow' => $moduleWorkflow
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Module\ModuleWorkflow  $moduleWorkflow
     * @return \Illuminate\Http\Response
     */
    public function edit(ModuleWorkflow $moduleWorkflow)
    {
        $moduleWorkflow->loadMissing([
            'module',
            'workflow'
        ]);

        $modules = Module::get();

        $workflows = Workflow::get();

        return view('module_workflows.edit', [
            'moduleWorkflow'    => $moduleWorkflow,
            'modules'           => $modules,
            'workflows'         => $workflows
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Module\ModuleWorkflow  $moduleWorkflow
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ModuleWorkflow $moduleWorkflow)
    {
        $request->validate([
            'module'        => [
                'required',
                Rule::in(Module::pluck('id'))
            ],
            'workflow'      => [
                'required',
                Rule::in(Workflow::pluck('id'))
            ]
        ]);

        $moduleWorkflow->update([
            'module_id'     => $request->input('module'),
            'workflow_id'   => $request->input('workflow'),
        ]);

        session()->flash('app::class', 'alert-success');
        session()->flash('app::message', __('Data successfully updated to the database.'));

        return redirect()->route('module-workflows.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Module\ModuleWorkflow  $moduleWorkflow
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, ModuleWorkflow $moduleWorkflow)
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

        $moduleWorkflow->delete();

        session()->flash('app::class', 'alert-success');
        session()->flash('app::message', __('Data successfully deleted from the database.'));

        return back();
    }
}
