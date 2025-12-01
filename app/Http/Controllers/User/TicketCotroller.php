<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketCotroller extends Controller
{
    public function tickets()
    {
        $tickets = Ticket::orderBy("created_at", "desc")->paginate(10);
        return view("Pages.user.tickets.list", compact("tickets"));
    }
    public function create($parent_id=0)
        {
            if($parent_id!=0){
                $parent=Ticket::findOrFail($parent_id);
                $answers = Ticket::where("parent_id",$parent->id)->get();
                return view("Pages.user.tickets.create",compact("parent","answers"));
            }else{
                return view("Pages.user.tickets.create");
            }
        }
    public function store(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->back()->withErrors('ابتدا وارد اکانت خود شوید.');
        }
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'string',
            'parent' => 'required|integer|min:0',
        ]);
        Ticket::create([
                'user_id' => auth()->user()->id,
                'subject' => $request->title,
                "content" => $request->description,
                "parent_id" => ($request->parent==0) ? null :  $request->parent ,
                "creator"=>"user"
            ]);
        try {
            return redirect()->back()->with('success', 'تیکت شما با موفقیت ثبت شد.');
        } catch (\Exception $th) {
            return redirect()->back()->with('warning', 'تیکت شما درج نشد!');
        }
    }

}
