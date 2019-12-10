<?php

namespace App\Http\Controllers;

use App\Memo;
use App\Http\Requests\CreateMemo;
use App\Http\Requests\UpdateMemo;
use Illuminate\Http\Request;

class MemoController extends Controller
{
    public function index()
    {
        $memos = Memo::all();

        return view('memos.index', [
            'memos' => $memos,
        ]);
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
        $memo->save();

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
}
