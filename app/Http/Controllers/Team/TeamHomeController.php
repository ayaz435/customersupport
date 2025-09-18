<?php

namespace App\Http\Controllers\Team;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Models\Tickets;
use Illuminate\Support\Facades\Validator;
use App\Models\Followup3;
use App\Models\Followup6;
use App\Models\Followup9;
use App\Models\Remark;
use Illuminate\Support\Facades\DB;

class TeamHomeController extends Controller
{
    
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('login');
    }
    
    public function submitNestedForm(Request $request)
    {
        $remark= new Remark;
        $remark->fid= $request->tid;
        return response()->json(['message' => 'Nested form submitted successfully!']);
    }
    public function updateCommunicationType(Request $request)
    {
        
        $id = $request->id;
        $followup_type = $request->followup_type;
    
       
        // Determine the model based on $a
        $model = null;
        switch ($followup_type) {
            case 3:
                $model = Followup3::class;
                break;
            case 6:
                $model = Followup6::class;
                break;
            case 9:
                $model = Followup9::class;
                break;
            default:
                return redirect()->back()->with('error', 'Invalid parameter.');
        }
    
        // Update the record
        $record = $model::find($id);
        
        if ($record) {
            $record->teamstatus = 'Complete';
            // $record->adminstatus = "";
            $record->save();
    
            return redirect()->back()->with('success', 'Communication type updated successfully.');
        }
    
        return redirect()->back()->with('error', 'Record not found.');
    }
    
    public function followup()
    {
        $authName = Auth::user()->name;
        
        $count1 = Followup3::where('team_id', Auth::user()->id)->count();
        $count2 =  Followup6::where('team_id', Auth::user()->id)->count();
        $count3 = Followup9::where('team_id', Auth::user()->id)->count();
        return view('team.followup', compact('count1', 'count2', 'count3'));
    }
    
    public function followup3()
    {
        $authName = Auth::user()->name;
        $data = Followup3::where('team_id', Auth::user()->id)->get();
        return view('team.followup6', ['data' => $data,'month'=>3]);
    }
    
    public function followup6()
    {
        $authName = Auth::user()->name;
        $data = Followup6::where('team_id', Auth::user()->id)->get();
        return view('team.followup6', ['data' => $data,'month'=>6]);
    }
    
    public function followup9()
    {
        $data = Followup9::where('team_id', Auth::user()->id)->get();
        return view('team.followup6', ['data' => $data,'month'=>9]);
    }
    
    public function completedtask()
    {
        return view('team.completedtask');
    }



    public function tickets()
    {
        $count1 = Tickets::where('handle_by',Auth::id())->whereIn('status', ['Closed', 'Resolved'])->where('category','About Services')->count();
        $count2 = Tickets::where('handle_by',Auth::id())->whereNotIn('status', ['Closed', 'Resolved'])->where('category','About Services')->count();
        $count3  = Tickets::where('handle_by',Auth::id())->orWhere('handle_by', null)->where('category','About Services')->count();
        return view('team.tickets', compact('count1', 'count2', 'count3'));
    }
    

    public function completedtickets(){
        $tickets = Tickets::whereIn('status', ['Closed', 'Resolved'])->where('category','About Services')->where('handle_by',Auth::user()->id)->get();
        return view('team.ticket', [
            'tickets' => $tickets,
        ]);
    }
    
    public function pendingtickets(){
        $tickets = Tickets::where('handle_by',Auth::id())->whereNotIn('status', ['Closed', 'Resolved'])->where('category','About Services')->get();
        return view('team.ticket', [
            'tickets' => $tickets,
        ]);
    }
    public function receivedticktets(){
        $tickets=Tickets::where('handle_by',Auth::id())->orWhere('handle_by', null)->where('category','About Services')->get();
        return view('team.ticket', [
            'tickets' => $tickets,
        ]);
    }
    
    public function complainfetchdel($id)

    {
        $chat = Complain::find($id);
        $chat->delete();
        return redirect()->back()->with('success', 'Complain deleted successfully');
    }
    
    public function updateStatus(Request $request, $id)
    {
        $data = $request->json()->all();
        $ticket = Tickets::with('user')->where('id', $data['id'])->first();
        $ticket->status = $data['status'];
        $ticket->handle_by = Auth::user()->id;
        $ticket->save();
    
        return response()->json(['success' => true]);
    }
}
