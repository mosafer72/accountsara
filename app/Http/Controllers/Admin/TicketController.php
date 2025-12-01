<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::main()->with('user','children')->latest()->get();
        return view('Admin.tickets.index',compact('tickets'));
    }

    public function show(Ticket $ticket)
    {
        $ticket->load('user','children');
        return view('Admin.tickets.show',compact('ticket'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string',
            'content' => 'required|string',
            'parent_id' => 'nullable|exists:tickets,id'
        ]);

        Ticket::create([
            'user_id' => auth()->id(),
            'parent_id' => $request->parent_id,
            'subject' => $request->subject,
            'content' => $request->content,
            'status' => $request->parent_id ? 'open' : 'open'
        ]);

        return back()->with('success','ثبت شد.');
    }

    public function toggleStatus(Ticket $ticket)
    {
        $ticket->status = $ticket->status === 'open' ? 'closed' : 'open';
        $ticket->save();
        return back()->with('success','وضعیت تغییر کرد.');
    }
}
