<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserQuery;
use App\Mail\QueryReply;
use Illuminate\Support\Facades\Mail;

class QueryController extends Controller
{
    public function index()
    {
        $queries = UserQuery::orderBy('created_at','desc')->paginate(20);
        return view('admin.queries.index', compact('queries'));
    }

    public function show(UserQuery $query)
    {
        return view('admin.queries.show', compact('query'));
    }

    public function reply(Request $request, UserQuery $query)
    {
        $data = $request->validate([
            'reply' => 'required|string|max:5000'
        ]);

        $query->reply = $data['reply'];
        $query->status = 'answered';
        $query->save();

        Mail::to($query->email)->send(new QueryReply($query, $data['reply']));

        return back()->with('success','Reply sent to user.');
    }
}
