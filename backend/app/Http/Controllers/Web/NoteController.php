<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Variety;
use App\Models\Note;

class NoteController extends Controller
{
  public function index(Request $request) 
  {
    //-------------------------------------------------------------------------
    // 検索フォームの値
    $search = [
      'category_id' => $request->category_id,
      'variety_id'  => $request->variety_id,
    ];

    $notes = Note::all();

    return view('note.index', [
      'notes'      => $notes,
      'search'    => $search,
      'categories' => Category::orderBy('order_no')->pluck('name', 'id'),
      'varieties'  => Variety::orderBy('order_no')->pluck('name', 'id'),
    ]);
  }

  public function create(Request $request) 
  {
    return view('note.create', [
      'categories' => Category::orderBy('order_no')->pluck('name', 'id'),
      'varieties'  => Variety::orderBy('order_no')->pluck('name', 'id'),
    ]);
  }

  public function edit($id) 
  {
    $note = Note::findOrFail($id);
    return view('note.edit', [
      'note'       => $note,
      'categories' => Category::orderBy('order_no')->pluck('name', 'id'),
      'varieties'  => Variety::orderBy('order_no')->pluck('name', 'id'),
    ]);
  }

  public function show($id) {
    $note = Note::findOrFail($id);

    return view('note.show', [
      'note'       => $note,
      'categories' => Category::orderBy('order_no')->pluck('name', 'id'),
      'varieties'  => Variety::orderBy('order_no')->pluck('name', 'id'),
    ]);
  }
}
