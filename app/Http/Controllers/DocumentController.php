<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Document\Document;
use App\Models\Document\DocumentActivity;
use App\Models\Document\DocumentStatus;
use App\Rules\Password\ValidatePassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DocumentController extends Controller
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
        $documents = Document::paginate();

        return view('documents.index', compact('documents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('documents.create');
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
            'name'      => [
                'required',
                'string',
                'max:255'
            ],
        ]);

        $document = Document::create([
            'name'  => $request->input('name')
        ]);

        DocumentActivity::create([
            'document_id'               => $document->id,
            'document_status_id'        => DocumentStatus::where('name', 'New')->value('id'),
            'action_by'                 => $request->user()->id,
        ]);

        session()->flash('app::class', 'alert-success');
        session()->flash('app::message', __('Data successfully saved to the database.'));

        return redirect()->route('documents.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Document\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document)
    {
        $document->loadMissing('documentActivities');

        return view('documents.show', compact('document'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Document\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function edit(Document $document)
    {
        return view('documents.edit', [
            'document' => $document
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Document\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Document $document)
    {
        $request->validate([
            'name'      => [
                'required',
                'string',
                'max:255'
            ],
        ]);

        $document->update([
            'name'  => $request->input('name')
        ]);

        session()->flash('app::class', 'alert-success');
        session()->flash('app::message', __('Data successfully updated to the database.'));

        return redirect()->route('documents.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Document\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Document $document)
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

        $document->documentActivities->each->delete();

        $document->delete();

        session()->flash('app::class', 'alert-success');
        session()->flash('app::message', __('Data successfully deleted from the database.'));

        return back();
    }
}
