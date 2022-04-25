<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use App\Models\AddressModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\UserHasAddressesModel;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
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
    public function create()
    {
        return view('guest.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dados = $request->all();

        try {
            DB::beginTransaction();

            $rules = [
                'username' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
            ];

            $messages = [
                'username.required' => 'O campo Usuário é obrigatório',
                'email.required' => 'O campo E-mail é obrigatório',
                'password.required' => 'O campo Senha é obrigatório',
                'password.confirmed' => 'A confirmação da senha não corresponde.',
            ];

            $validator = Validator::make($dados, $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $dados['is_admin'] = 0;
            $dados['password'] = Hash::make($dados['password']);

            $user = User::create($dados);

            $address = AddressModel::create($dados);

            UserHasAddressesModel::create([
                'user_id' => $user->id,
                'address_id' => !empty($address) ? $address->id : NULL,
            ]);

            DB::commit();
            return redirect()->route('schedule.my-schedules')->with('success', 'Usuário cadastrado com sucesso!');
        } catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
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
        try {
            $user = User::find($id);

            if(is_null($user)) {
                $message = 'Usuário não encontrado.';
                return redirect()->back()->with(['error' => true, 'message' => $message]);
            }

            return view('user.form', ['user' => $user]);

        } catch(\Exception $e) {
            $message = 'Ocorreu um erro ao tentar editar.';
            return redirect()->route('user.edit')->with(['error' => true, 'message' => $message]);
        }
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
        $request['cpf'] = removeCaracteresEspeciais($request['cpf']);
        $dados = $request->except('_token');

        try {
            DB::beginTransaction();
            
            $rules = [
                'username' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,' . $request->id,
                'password' => 'required|string|min:8|confirmed',
            ];

            $messages = [
                'username.required' => 'O campo Usuário é obrigatório',
                'email.required' => 'O campo E-mail é obrigatório',
                'password.required' => 'O campo Senha é obrigatório',
                'password.confirmed' => 'A confirmação da senha não corresponde.',
            ];

            $validator = Validator::make($dados, $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $user = User::find($dados['user_id']);
            
            if(is_null($user)) {
                $message = 'Usuário não encontrado.';
                return redirect()->back()->with(['error' => true, 'message' => $message]);
            }
            
            $user->update($dados);

            $address = AddressModel::updateOrCreate(['id' => !empty($user->hasAddress) && $user->hasAddress->address_id != NULL ? $user->hasAddress->address_id : NULL], $dados);

            UserHasAddressesModel::updateOrCreate([
                'user_id' => $user->id
            ], [
                'address_id' => $address->id,
            ]);
            
            DB::commit();
            return redirect()->route('user.edit', ['user_id' => $user->id])->with('success', 'Usuário atualizado com sucesso!');
        } catch(\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            $message = 'Ocorreu um erro ao salvar.';
            return redirect()->route('user.edit', $dados['user_id'])->with(['error' => true, 'message' => $message]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
