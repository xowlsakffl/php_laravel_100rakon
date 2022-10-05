<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $state = $request->state;
        $searchOption = $request->search_option;
        $searchText = $request->search_text;

        if($searchText !== NULL){
            $userData = User::where([
                [function($query) use ($searchOption, $searchText){
                    $query->orWhere($searchOption, 'LIKE', '%'.$searchText.'%')->get();
                }]
            ])->paginate(10);
            $userData->appends(['search_option' => $searchOption, 'search_text'=>$searchText]);
        }

        if($state || $state === "0"){
            $userData = User::where('state', $state)->latest()->paginate(10);
            $userData->appends(['state' => $state]);
        }
        
        if(!$searchText && !$state && $state !== "0"){
            $userData = User::latest()->paginate(10);
        }

        return view('admin.users.user_list', compact('userData'))->with('i', (request()->input('page', 1) - 1) * 5);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($udx)
    {
        $userData = User::where('udx', $udx)->first();
        $userAddresses = $userData->userAddresses;
        $userBaskets = $userData->orderBaskets;
        
        return view('admin.users.user_show', compact(['userData', 'userAddresses', 'userBaskets']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($udx)
    {
        $userData = User::where('udx', $udx)->first();

        return view('admin.users.user_edit', compact('userData'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $udx)
    {
        $request->validate([
            'password' => 'confirmed',      
            'name' => 'string',
        ],
        [
            'password.confirmed' => '비밀번호가 일치하지 않습니다.',
            'name.string' => '특수문자, 공백은 입력할 수 없습니다.',
        ]);

        $data = [
            'name' => $request->name,
            'email_auth' => $request->email_auth,
            'cell' => $request->cell,
            'cell_auth' => $request->cell_auth,
            'tel' => $request->tel,
            'super' => $request->super,
            'state' => $request->state,
        ];

        if($request->filled('password')){
            $data['password'] = Hash::make($request->password);
        }

        User::where('udx', $udx)->update($data);

        flash('사용자가 수정되었습니다.')->success();
        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($udx)
    {
        User::where('udx' ,$udx)->delete();
        
        flash('사용자가 삭제되었습니다.')->success();
        return redirect()->route('admin.users.index');
    }
}
