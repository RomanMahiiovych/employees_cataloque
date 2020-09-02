<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Faker\Generator as Faker;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
//     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $positions = Position::all();
        return view('positions.position', ['positions' => $positions]);
    }

    /**
     * Show the form for creating a new resource.
     *
//     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('positions.add_position');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
//     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Faker $faker)
    {
        $admin_created_id = $faker->unique()->randomNumber(6);
        $admin_updated_id = $faker->unique()->randomNumber(6);
        Position::create([
            'name' => $request->name,
            'admin_created_id' => $admin_created_id,
            'admin_updated_id' => $admin_updated_id
        ]);
        return redirect()->route('positions.index')->with('status', 'Position created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
//     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
//     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $position = Position::whereId($id)->first();

        return view('positions.edit_position', [
            'name' => $position->name,
            'id'   => $id,
            'created_at' => $position->created_at->format('d.m.y'),
            'updated_at' => $position->updated_at->format('d.m.y'),
            'admin_created_id' => $position->admin_created_id,
            'admin_updated_id' => $position->admin_updated_id,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
//     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, Faker $faker)
    {
        $position = Position::whereId($id)->first();
        $position->update([
            'name' => $request->name,
            'admin_updated_id' => $faker->unique()->randomNumber(6)
        ]);
        return redirect()->route('positions.index')->with('status', 'Position updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
//     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Position::find($id)->delete();
        return redirect()->route('positions.index')->with('status', 'Post deleted successfully');
    }
}
