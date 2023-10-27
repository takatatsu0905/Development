<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = \Auth::user();

        $tasks = Task::where('status','false')->where('user_id', $user['id'])->get();

        return view('tasks.index', compact('tasks'));
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

        $user = [
            'user_id'=> $request->user()->id,
        ];

        $rules = [
            'task_name' => 'required|max:100',
        ];

        $messages = ['required' => '必須項目です', 'max' => '100文字以内にしてください。'];

        Validator::make($request->all(), $rules, $messages)->validate();

        

    
        // Taskモデルをインスタンス化
        $task = new Task;

        // モデル->カラム名 = 値 で、データを割り当てる
        $task->user_id = $user['user_id'];
        $task->name = $request->input('task_name');

        // データベースに保存
        $task->save();

        // リダイレクト
        return redirect('/tasks');

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
        $task = Task::find($id);
        return view('tasks.edit', compact('task'));
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

        // 「編集する」ボタンを押したとき
        if ($request->status === null) {
            
            $rules = [
                'task_name' => 'required|max:100',
            ];

            $messages = ['required' => '必須項目です', 'max' => '100文字以内にしてください。'];

            Validator::make($request->all(), $rules, $messages)->Validate();


            // 該当のタスクを検索
            $task = Task::find($id);

            // モデル->カラム名 = 値 で、データを割り当てる
            $task->name = $request->input('task_name');

            // データベースに保存
            $task->save();

        } else {
            // 「完了」ボタンを押したとき

            // 該当のタスクを検索
            $task =Task::find($id);

            // モデル->カラム名 = 値 で、データを割り当てる
            $task->status = true; //false=未完 true=完了

            // データベースに保存
            $task->save();
        }

        // リダイレクト
        return redirect('/tasks');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Task::find($id)->delete() ←DB上から完全に削除される。

        // 今回は削除を選択するとstatusがfalseになり疑似削除という形にする
        $task = Task::find($id);

        // モデル->カラム名 = 値 で、データを割り当てる
        $task->status = true; //false=未完 true=完了

        // データベースに保存
        $task->save();

        return redirect('/tasks');
    }
}
