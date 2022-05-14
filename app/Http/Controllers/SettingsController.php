<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SettingsModel;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setting = SettingsModel::first();
        return view('settings.index', compact('setting'));
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

            SettingsModel::find($request->id)->update($request->all());

            DB::commit();
            return redirect()->route('settings.index')->with(['success' => true, 'message' => 'Configurações atualizadas com sucesso!']);
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->route('settings.index')->with(['error' => true, 'message' => 'Ocorreu um erro ao atualizar as configurações!']);
        }
    }
}
