<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Task_appController extends Controller
{
    public function index_task_app(Request $request){
        $title = 'To Doリスト';
        // Messageモデルを利用してmessageの一覧を取得

        if($request->sort === "asc") {
            $task_apps = \App\task_app::all()->where('users_id',Auth::user()->id)->sortBy('date');
        } else {
            $task_apps = \App\task_app::all()->where('users_id',Auth::user()->id)->sortByDesc('date');
        }

        // views/messages/index.blade.phpを指定
        return view('task_app.index_task_app',[
            'title' => $title,
            'task_apps' => $task_apps,
        ]);
    }

    public function create(Request $request){

        // requestオブジェクトのvalidateメソッドを利用。
        $request->validate([
            'body' => 'required|max:100', 
            'date' => 'required'// nameは必須、20文字以内
        ]);

        // Messageモデルを利用して空のMessageオブジェクトを作成
        $task_app = new \App\task_app;

        // フォームから送られた値を設定
        $task_app->id = $request->id;
        $task_app->body = $request->body;
        $task_app->date = $request->date;
        $task_app->status = $request->status;
        $task_app->users_id = Auth::user()->id;

        // messagesテーブルにINSERT
        $task_app->save();

        // メッセージ一覧ページにリダイレクト
        return redirect('/task_apps')->with('status', 'リストに入れました！ファイト！');
    }

    public function update(Request $request){

        $task_app = \App\task_app::find($request->id);

        if($request->sql_kind === "update_text") {

            $task_app->body = $request->body;
            $task_app->save();

            return redirect('/task_apps')->with('status', 'やること変更完了！');

        } else if($request->sql_kind === "update_date"){

            $task_app->date = $request->date;
            $task_app->save();

            return redirect('/task_apps')->with('status', '締め切り日変更完了！');

        } else {
            
            if($task_app->status === 0) {
                $task_app->status = 1;
            } else {
                $task_app->status = 0;
            }
            // messagesテーブルにINSERT
            $task_app->save();
            // メッセージ一覧ページにリダイレクト
            return redirect('/task_apps')->with('status', 'ステータス変更完了！');
        }
    }

    public function destroy(Request $request) {

        $task_app = \App\task_app::find($request->id);

        $task_app->delete();

        // メッセージ一覧ページにリダイレクト
        return redirect('/task_apps')->with('status', '削除しました！お疲れさまでした！');
    }

    public function __construct() {
        // authというミドルウェアを設定
        $this->middleware('auth');
    }
}
