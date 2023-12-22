<?php

namespace App\Http\Controllers;

use App\Client;
use App\Journal;
use Illuminate\Http\Request;

class JournalsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($client)
    {
        $userId = auth()->id();

        // Check if client exists and is associated with the user
        $clientExists = Client::where([
            ['id', '=', $client],
            ['user_id', '=', $userId]
        ])->exists();

        if($clientExists == false) {
            abort(404);
        }

        return view('journals.create', [
            'clientId' => $client
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $client)
    {
        $request->validate([
            'date' => 'required|date|date_format:Y-m-d',
            'content' => 'required|string',
        ]);

        $userId = auth()->id();

        // Check if client exists and is associated with the user

        // NOTE FOR INTERVIEW: I've rechecked here because I wanted to keep the current structure of the endpoint
        // Another posibility would have been to just add the client_id to the $request, and validate it above in the validate() method
        $clientExists = Client::where([
            ['id', '=', $client],
            ['user_id', '=', $userId]
        ])->exists();

        if($clientExists == false) {
            abort(404);
        }

        $journal = Journal::create([
            'date' => $request->get('date'),
            'content' => $request->get('content'),
            'client_id' => $client
        ]);

        return $journal;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($client, $journal)
    {
        Journal::where([
            ['id', $journal],
            ['client_id', $client]
        ])->delete();

        return 'Deleted';
    }
}
