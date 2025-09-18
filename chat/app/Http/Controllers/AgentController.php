<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AgentController extends Controller
{
    /**
     * Get all available support agents
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAvailableAgents()
    {
        
        // dd("present");
        // You might want to adjust the query based on your user roles system
        // This example assumes you have a 'role' column or a related role model
        $agents = User::where('role', 'team')
            ->where('id', '!=', Auth::user()->id) // Exclude the current user
            ->where('active_status', 1) // Only include active agents
            ->select('id', 'name', 'avatar') // Only get necessary fields
            ->get();
            
            
        return response()->json([
            'status' => true,
            'agents' => $agents
        ]);
    }
}