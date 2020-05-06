<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Folder;
use Illuminate\Http\Request;
use App\Http\Requests\CreateFolder;

class FolderController extends Controller
{
    public function showCreateForm()
    {
        return view('folders/create');
    }
    public function create(CreateFolder $request)
    {
        // フォルダモデルのインスタンスを作成する
        $folder = new Folder();
        // タイトルに入力値を代入する
        $folder->title = $request->title;
        // インスタンスの状態をデータベースに書き込む
        Auth::user()->folders()->save($folder);
        
        $cookie = \Cookie::make("TEST_COOKIE", $folder->id, 60);
        //$request->cookie('TEST_COOKIE');

        return redirect()->route('tasks.index', [
            'id' => $folder->id,
        ])->withCookie($cookie);
    }
}
