<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'room_name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:lab,studio'],
            'capacity' => ['required', 'integer', 'min:1'],
            'status' => ['required', 'in:active,maintenance'],
        ]);

        Room::create($data);

        return back()->with('success', 'Room created successfully.');
    }

    public function edit(Room $room)
    {
        return view('admin.rooms.edit', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $data = $request->validate([
            'room_name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:lab,studio'],
            'capacity' => ['required', 'integer', 'min:1'],
            'status' => ['required', 'in:active,maintenance'],
        ]);

        $room->update($data);

        return redirect()->route('admin.dashboard')->with('success', 'Room updated successfully.');
    }

    public function destroy(Room $room)
    {
        $room->delete();

        return back()->with('success', 'Room deleted successfully.');
    }
}
