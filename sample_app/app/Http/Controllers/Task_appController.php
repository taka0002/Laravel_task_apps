<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Task_appController extends Controller
{
    public function index_task_app(Request $request){
        $title = 'To Doリスト';
        // Messageモデルを利用してmessageの一覧を取得

        if($request->sort === "desc") {
            $task_apps = \App\task_app::all()->where('users_id',Auth::user()->id)->sortByDesc('date');
        } else {
            $task_apps = \App\task_app::all()->where('users_id',Auth::user()->id)->sortBy('date');
        }

        if($request->status === "in") {
            $task_apps = \App\task_app::all()->where('users_id',Auth::user()->id)->sortByDesc('status');
        } else if($request->status === "out") {
            $task_apps = \App\task_app::all()->where('users_id',Auth::user()->id)->sortBy('status');
        }

        if($request->category === "up") {
            $task_apps = \App\task_app::all()->where('users_id',Auth::user()->id)->sortByDesc('category');
        }

        if($request->sql_kind === "category_name") {
            if($request->category_view === "all") {
                $task_apps = \App\task_app::all()->where('users_id',Auth::user()->id)->sortBy('date');
            } else {
                $task_apps = \App\task_app::all()->where('users_id',Auth::user()->id)->where('category', $request->category_view);
            }
        }
        $category_name = $request->category_view;

        $task_apps_archive = \App\taks_apps_archive::where('users_id',Auth::user()->id)->paginate(10);

        $categories = \App\category::all()->where('users_id',Auth::user()->id);

        // views/messages/index.blade.phpを指定
        return view('task_app.index_task_app',[
            'title' => $title,
            'task_apps' => $task_apps,
            'task_apps_archive' => $task_apps_archive,
            'categories' => $categories,
            'category_name' => $category_name
        ]);
        
    }

    public function create(Request $request){

        if($request->body === null) {
            
            if($request->status !== null) {

                $request->validate([
                    'body' => 'required|max:20', 
                ]);

            }

            $request->validate([
                'category_name' => 'required|unique:categories,category_name|max:20'
            ]);

            $category = new \App\category;
    
            $category->id = $request->id;
            $category->category_name = $request->category_name;
            $category->users_id = Auth::user()->id;
    
            $category->save();
    
            return redirect('/task_apps')->with('status', 'カテゴリを登録しました！');

        } else {

            // requestオブジェクトのvalidateメソッドを利用。
            $request->validate([
                'body' => 'required|max:20', 
                'description' => 'max:300'
            ]);

            // Messageモデルを利用して空のMessageオブジェクトを作成
            $task_app = new \App\task_app;
            $category = \App\category::find($request->category_id);

            // フォームから送られた値を設定
            $task_app->id = $request->id;
            $task_app->body = $request->body;
            $task_app->date = $request->date;
            $task_app->status = $request->status;
            if($request->date === null) {
                $task_app->status = 3;
            }
            $task_app->description = $request->description;
            $task_app->category_id = $request->category_id;
            if($request->category_id !== "0"){
                $task_app->category = $category->category_name;
            }
            $task_app->users_id = Auth::user()->id;

            // messagesテーブルにINSERT
            $task_app->save();

            // メッセージ一覧ページにリダイレクト
            return redirect('/task_apps')->with('status', 'リストに入れました！ファイト！');

        }       
    }

    public function index_task_app_category(Request $request) {

        $title = 'To Doリスト';
        $categories = \App\category::all()->where('users_id',Auth::user()->id);

        // views/messages/index.blade.phpを指定
        return view('task_app.index_task_app_category',[
            'title' => $title,
            'categories' => $categories
        ]);
    }

    public function update(Request $request){

        $task_app = \App\task_app::find($request->id);
        $category = \App\category::find($request->id);

        if($request->sql_kind === "update_text") {

            // requestオブジェクトのvalidateメソッドを利用。
            $request->validate([
                'body' => 'required|max:20'
            ]);

            $task_app->body = $request->body;
            $task_app->save();

            return redirect('/task_apps')->with('status', 'やること変更完了！');

        } else if($request->sql_kind === "update_date"){

            $task_app->date = $request->date;
            $task_app->status = 0;
            $task_app->save();

            return redirect('/task_apps')->with('status', '締め切り日変更完了！');

        } else if($request->sql_kind === "update_text_description"){

            $request->validate([
                'description' => 'required|max:300'
            ]);

            $task_app->description = $request->description;
            $task_app->save();

            return redirect('/task_apps')->with('status', '詳細の変更完了！');

        } else if($request->sql_kind === "update_category"){
            $category = \App\category::find($request->category_id);
            $task_app->category_id = $request->category_id;
            if($request->category_id !== "0"){
                $task_app->category = $category->category_name;
            } else {
                $task_app->category = "未設定";
            }
            $task_app->save();

            return redirect('/task_apps')->with('status', 'カテゴリーの変更完了！');
        
        } else if($request->sql_kind === "change_category"){

            $request->validate([
                'category_name' => 'required|unique:categories,category_name|max:20'
            ]);

            $category->category_name = $request->category_name;

            $task_apps_of_category = \App\task_app::get()->where('category_id',$request->id);

            if(count($task_apps_of_category) !== 0){
                $category_of_task_apps = \App\category::find($request->id)->task_app::get()->where('category_id',$request->id);
                foreach($category_of_task_apps as $category_of_task_app) {
                    $category_of_task_app->category = $request->category_name;
                    $category_of_task_app->save();
                }
            }
            $category->save();

            return redirect('/task_apps_category')->with('status', 'カテゴリーの変更完了！');
        
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

        $task_app = \App\task_app::find($request->body);
        $task_app = \App\task_app::find($request->description);
        $task_app = \App\task_app::find($request->category);
        $task_app = \App\task_app::find($request->id);
        $category = \App\category::find($request->category_name);
        $category = \App\category::find($request->id);

        if($request->body !== NULL) {

            $task_app_archive = new \App\taks_apps_archive;
            // フォームから送られた値を設定
            $task_app_archive->task_apps_id = $request->id;
            $task_app_archive->body = $request->body;
            $task_app_archive->description = $request->description;
            $task_app_archive->category = $request->category;
            $task_app_archive->users_id = Auth::user()->id;
            $task_app_archive->save();

            $task_app->delete();

            // メッセージ一覧ページにリダイレクト
            return redirect('/task_apps')->with('status', 'リストから削除しました！お疲れさまでした！');

        }
        //カテゴリーの削除
        if($request->category_name !== NULL) {

            $category->delete();

            return redirect('/task_apps');
        }

        //取り消しボタン
        $task_app->delete();

        return redirect('/task_apps')->with('status', '取り消しました！');;
    }

    public function __construct() {
        // authというミドルウェアを設定
        $this->middleware('auth');
    }
}
