<?php

namespace App\Http\Controllers;

use App\Models\ImagemSalaModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class InstitutionalController extends Controller
{
    public function index()
    {
        $imagemSalas = ImagemSalaModel::orderBy('order_image', 'ASC')->get()->map(function($image) {
            $image->filepath = Storage::disk('local')->url('images-room-institutional/'.$image->filename);
            return $image;
        });

        return view('settings.institutional', ['imagemSalas' => $imagemSalas]);
    }

    public function modalAdicionarImagem(Request $request)
    {
        $route = '.institutional.save-image';
        $model = ImagemSalaModel::find($request->id);
        if ($request->type == 'edit') {
            $route = '.institutional.edit-image';
        }

        return view('settings.modals.modal-adicionar-imagem-sala', ['model' => $model, 'route' => $route]);
    }

    public function store(Request $request)
    {
        $dados = $request->all();

        // $rules = [
        //     'description'=> 'required',
        //     'image'=> 'required|file|mimes:png,jpeg',
        //     'image_order' => 'required'
        // ];

        // $validator = Validator::make($dados, $rules);

        // if ($validator->fails()) {
        //     session()->flash("warning", "O formato do arquivo deve ser do tipo: pdf");
        //     return response()->json(['status' => 'warning', 'message' => $validator]);
        // }

        try {

            DB::beginTransaction();

            $extensao = $dados['image']->getClientOriginalExtension();
            $filename = time() . '.' . $extensao;

            Storage::disk('public')->put('images-room-institutional/'.$filename, file_get_contents($dados['image']));

            $arrCreate = [
                'filename' => $filename,
                'description' => $dados['description'],
                'order_image' => $dados['order_image'],
                'created_by' => auth()->user()->id
            ];

            ImagemSalaModel::create($arrCreate);

            DB::commit();

            return redirect()->route('.institutional.index')->with(['success' => true, 'message' => 'Imagem salva com sucesso']);
        } catch(Exception $e) {
            DB::rollback();

            return redirect()->route('.institutional.index')->with(['error' => true, 'message' => 'Ocorreu um erro ao salvar a imagem']);
        }
    }

    public function edit(Request $request)
    {
        $dados = $request->all();
        $arrUpdate = [];
        $filename = null;

        // $rules = [
        //     'description'=> 'required',
        //     'image'=> 'required|file|mimes:png,jpeg',
        //     'image_order' => 'required'
        // ];

        // $validator = Validator::make($dados, $rules);

        // if ($validator->fails()) {
        //     session()->flash("warning", "O formato do arquivo deve ser do tipo: pdf");
        //     return response()->json(['status' => 'warning', 'message' => $validator]);
        // }
        try {
            DB::beginTransaction();

            $model = ImagemSalaModel::find($dados['id']);
            if (!empty($dados['image'])) {
                $extensao = $dados['image']->getClientOriginalExtension();
                $filename = time() . '.' . $extensao;
            }

            $arrUpdate = [
                'filename' => $filename ?? $model->filename,
                'description' => $dados['description'],
                'order_image' => $dados['order_image'],
                'created_by' => auth()->user()->id
            ];

            if ($model && !empty($dados['image'])) {
                Storage::disk('public')->delete('images-room-institutional/'.$model->filename);
                // unset($arrUpdate['filename']);
            }

            // TODO: Não apagar a imagem se o campo de imagem vier vazio, isso só vale para edição
            if (!empty($dados['image'])) {
                Storage::disk('public')->put('images-room-institutional/'.$filename, file_get_contents($dados['image']));
            }

            $model->update($arrUpdate);

            DB::commit();

            return redirect()->route('.institutional.index')->with(['success' => true, 'message' => 'Imagem atualizada com sucesso']);
        } catch(Exception $e) {
            DB::rollback();

            return redirect()->route('.institutional.index')->with(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    public function deleteInstitutionalImage(Request $request)
    {
        $dados = $request->all();

        try {
            DB::beginTransaction();

            $model = ImagemSalaModel::where(['id' => $dados['image_id']])->first();

            if ($model) {
                Storage::disk('public')->delete('images-room-institutional/'.$model->filename);
            }

            $model->delete();

            DB::commit();
            
            return response()->json(['status' => 'success', 'message' => 'Imagem removida com sucesso']);
            
        } catch (\Throwable $th) {
            DB::rollBack();
            
            return response()->json(['status' => 'error', 'message' => 'Ocorreu um erro ao remover a imagem', 'messageDebug' => $th->getMessage()]);
        }
    }
}
