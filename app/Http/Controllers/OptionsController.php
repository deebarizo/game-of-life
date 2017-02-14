<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Option;

class OptionsController extends Controller
{
     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $h2Tag = 'Edit Options';

        $option = Option::find($id);

        return view('options/edit', compact('h2Tag', 'option'));
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
        $option = Option::find($id);

        $option->start_time = trim($request->input('start_time'));
        $option->end_time = trim($request->input('end_time'));
 
        $option->save();

        return redirect()->route('options.edit', $id)->with('message', 'Success!'); 
    }
}
