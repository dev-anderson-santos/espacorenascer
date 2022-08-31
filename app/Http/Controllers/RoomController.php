<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\RoomModel;
use Illuminate\Http\Request;
use App\Models\ScheduleModel;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms = RoomModel::all();
        return view('rooms.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $action = 'room.store';
        return view('rooms.modals.modal-adicionar-sala', compact('action'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            
            RoomModel::create([
                'name' => $request->name
            ]);
            
            DB::commit();
            
            return redirect()->route('room.index')->with(['type' => true, 'message' => 'Sala adicionada com sucesso!']);
        } catch (Exception $e) {
            DB::rollback();
            
            return redirect()->route('room.index')->with(['type' => false, 'message' => 'Ocorreu um erro ao adicionar a sala!']);
        }
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
        $room = RoomModel::find($id) ?? NULL;
        $action = 'room.update';

        return view('rooms.modals.modal-adicionar-sala', ['room' => $room, 'action' => $action]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            DB::beginTransaction();
            
            RoomModel::find($request->room_id)->update([
                'name' => $request->name
            ]);
            
            DB::commit();
            
            return redirect()->route('settings.index')->with(['type' => true, 'message' => 'Sala atualizada com sucesso!']);
        } catch (Exception $e) {
            DB::rollback();
            
            return redirect()->route('settings.index')->with(['type' => false, 'message' => 'Ocorreu um erro ao atualizar a sala!']);
        }
    }

    public function verificarSalaEmUso(Request $request)
    {
        $room = RoomModel::find($request->id) ?? NULL;
        
        if ($room) {
            $schedule = ScheduleModel::where('room_id', $room->id)->get();
            
            if ($schedule->count() > 0) {
                return response()->json(['status' => 'false', 'message' => "Não é possível remover a sala <b>{$room->name}</b> pois existem agendamentos associados a ela!"]);
            }
        }
        
        return response()->json(['status' => 'true']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            DB::beginTransaction();

            $room = RoomModel::where('id', $request->id)->first();
            $schedule = ScheduleModel::where('room_id', $room->id)->get();
            
            if ($schedule->count() > 0) {
                return response()->json(['status' => 'error', 'message' => "Não é possível remover a sala <b>{$room->name}</b> pois existem agendamentos associados a ela!"]);
            }

            $room->delete();
            // dd($room);
            DB::commit();

            return response()->json(['status' => 'success', 'message' => 'Sala removida com sucesso!']);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Ocorreu um erro ao remover a sala!']);
        }
    }
}
