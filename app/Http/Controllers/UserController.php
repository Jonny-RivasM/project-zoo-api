<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
//use Laravel\Passport\HasApiTokens;
use Validator;

class UserController extends Controller
{
    public $successStatus = 200;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return response()->json(['success'=>$users], $this->successStatus);

//        return response()->json(['success' => $user], $this->successStatus);
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
        $validator = Validator::make($request->all(),[
            'name'       => 'required',
            'email'      => 'required|email',
            'password'   => 'required',
            'c_password' => 'required|same:password',
        ]);
        if ($validator->fails()){
            return response()->json(['error'=>$validator->errors()],401);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input );
        $success['token'] = $user->createToken('MyApp')->accessToken;
        $success['name'] = $user->name;

        return response()->json(['success'=>$success], $this->successStatus);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        return response()->json(['success' => $user], $this->successStatus);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
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
        $user = User::find($id);
        $input = $request->all();



        $validator = Validator::make($request->all(),[
            'name'       => 'required',
            'email'      => 'required|email',
            'password'   => 'required',
            'card_id'    => 'required',
            'gender'     => 'required',
            'numberphone'=> 'required',
            'birthdata'  => 'required'
        ]);
        if ($validator->fails()){
            return response()->json(['error'=>$validator->errors()],401);
        }
        //return response()->json(['success' => $input], $this->successStatus);
        //$input = $request->all();

        $user['name'] = $input['name'];
        $user['email'] = $input['email'];
        $user['password'] = bcrypt($input['password']);
        $user['card_id'] = $input['card_id'];
        $user['gender'] = $input['gender'];
        $user['numberphone'] = $input['numberphone'];
        $user['birthdata'] = $input['birthdata'];
        $user->save();

        return response()->json(['success' => $user], $this->successStatus);
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



    public function login(Request $request){
        $credentials = $request->all();
        if( Auth::attempt($credentials)){

            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->accessToken;
            $success['id'] = $user->id;

            return response()->json(['success' => $success], $this->successStatus);
        }else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }

}
