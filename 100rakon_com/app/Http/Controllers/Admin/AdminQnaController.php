<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Qna;

class AdminQnaController extends Controller
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
            $qnaData = Qna::where([
                [function($query) use ($searchOption, $searchText){
                    $query->orWhere($searchOption, 'LIKE', '%'.$searchText.'%')->get();
                }]
            ])->paginate(10);
            $qnaData->appends(['search_option' => $searchOption, 'search_text'=>$searchText]);
        }

        if($state || $state === "0"){
            $qnaData = Qna::where('state', $state)->latest()->paginate(10);
            $qnaData->appends(['state' => $state]);
        }
        
        if(!$searchText && !$state && $state !== "0"){
            $qnaData = Qna::latest()->paginate(10);
        }

        return view('admin.qnas.qna_list', compact('qnaData'))->with('i', (request()->input('page', 1) - 1) * 5);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($idx)
    {
        $qnaData = Qna::where('idx', $idx)->first();
        
        return view('admin.qnas.qna_show', compact('qnaData'));
    }

    public function edit($idx)
    {
        $qnaData = Qna::where('idx', $idx)->first();

        return view('admin.qnas.qna_edit', compact('qnaData'));
    }

    public function update(Request $request, $idx)
    {
        $request->validate([    
            'name' => 'string',
        ],
        [
            'name.string' => '특수문자, 공백은 입력할 수 없습니다.',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'tel' => $request->tel,
            'content' => $request->content,
            'tel' => $request->tel,
            'hit' => $request->hit,
            'state' => $request->state,
        ];

        Qna::where('idx', $idx)->update($data);

        flash('고객문의가 수정되었습니다.')->success();
        return redirect()->route('admin.qnas.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($idx)
    {
        Qna::where('idx' ,$idx)->delete();
        
        flash('고객문의가 삭제되었습니다.')->success();
        return redirect()->route('admin.qnas.index');
    }
}
