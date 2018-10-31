<?php

namespace App\Http\Controllers;

use App\Filters\ThreadFilters;
use App\Thread;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ThreadFilters $filters)
    {
	    return $this->getThreads($filters);
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
	    $this->validate($request, [
		    'title' => 'required',
		    'body' => 'required'
	    ]);

	    $thread = Thread::create([
		    'user_id' => auth()->id(),
		    'title' => request('title'),
		    'body' => request('body')
	    ]);

	    return response(['status' => 'Thread created']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function show(Thread $thread)
    {
	    return $thread->load('replies');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thread $thread)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy(Thread $thread)
    {
	    $this->authorize('update', $thread);
	    $thread->delete();

	    return response(['status' => 'Thread deleted']);
    }

	/**
	 * Fetch all relevant threads.
	 *
	 * @param Channel       $channel
	 * @param ThreadFilters $filters
	 * @return mixed
	 */
	protected function getThreads(ThreadFilters $filters)
	{
		return Thread::latest()->filter($filters)->get();
	}
}
