<?php

namespace App\Http\Controllers;

use App\Memo;
use App\Http\Requests\CreateMemo;
use App\Http\Requests\UpdateMemo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;

class MemoController extends Controller
{
    public function index()
    {
        $memos = Auth::user()->memos()->get();

        return view('memos.index', [
            'memos' => $memos,
        ]);
    }

    public function file()
    {
        $s3 = App::make('aws')->createClient('s3');
        $cmd = $s3->getCommand('GetObject', [
            'Bucket' => 'laramemo',
            'Key'    => 'tests/mac_us_keyboard.png',
        ]);
        $request = $s3->createPresignedRequest($cmd, '+20 minutes');

        $presignedUrl = (string) $request->getUri();
        
        return response()->streamDownload(function() use ($presignedUrl) {
            echo file_get_contents($presignedUrl);
        }, 'mac_us_keyboard.png');
    }

    public function show(Memo $memo)
    {
        return view('memos.show', [
            'memo' => $memo,
        ]);
    }

    public function new()
    {
        return view('memos.new');
    }

    public function create(CreateMemo $request)
    {
        $memo = new Memo();
        $memo->fill($request->except('_token'));
        
        Auth::user()->memos()->save($memo);

        return redirect()->route('memos.index');
    }

    public function edit(Memo $memo)
    {
        return view('memos.edit', [
            'memo' => $memo,
        ]);
    }

    public function update(UpdateMemo $request, Memo $memo)
    {
        $memo->fill($request->except('_token', '_method'));
        $memo->save();

        return redirect()->route('memos.show', [
            'memo' => $memo,
        ]);
    }

    public function fileUploaded(Request $request, Memo $memo)
    {
        return 'OK';
    }
}
