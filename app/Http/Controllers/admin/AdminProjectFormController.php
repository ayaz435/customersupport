<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Projectform;
use App\Models\File;
use App\Models\User;
use App\Models\Storedesign;
use App\Models\Catagory;
use Illuminate\Support\Facades\Storage;

class AdminProjectFormController extends Controller
{
    public function projectform(Request $request)
    {
        $eemails=User::where('role', "user")->get();
        return view('admin.test', ['eemails' => $eemails,
            'projectforms' => [],
            'files' => [],
            'catagories' => []
        ]);
    }

    public function projectformsubmit(Request $request)
    {
        $selectedEmail = $request->input('email');
        $selected_user=User::where('email', $selectedEmail)->first();
        $eemails=User::where('role', "user")->get();
        
        $projectforms = Projectform::where('eemail', $selectedEmail)
            ->orderBy('created_at', 'desc')
            ->get();
        $files = File::where('email', $selectedEmail)
            ->orderBy('created_at', 'desc')
            ->get();
        $categories = Catagory::where('user_id', $selected_user->id)
        ->with(['subCategories.productDesigns'])
        ->get();
        $mini_site_design = Storedesign::where('user_id', $selected_user->id)
            ->orderBy('created_at', 'desc')
            ->get();
            
        foreach ($categories as $category) {
            foreach ($category->subCategories as $sub) {
                // Filter product designs where main_category_id matches
                $sub->setRelation('productDesigns', $sub->productDesigns->filter(function ($design) use ($sub) {
                    return $design->main_category_id == $sub->main_category_id;
                })->values());
            }
        }    
   
    
        return view('admin.test', [
            'eemails' => $eemails,
            'projectforms' => $projectforms,
            'files' => $files,
            'categories' => $categories,
            'mini_site_design'=>$mini_site_design,
        ]);
    }

public function allprojectdata(Request $request)
    {
    // dd($request);
  $allProjectForms = Projectform::orderBy('created_at', 'desc')->get();
        $allFiles = File::orderBy('created_at', 'desc')->get();
     $allcategories = Catagory::orderBy('created_at', 'desc')->get();
   
    if ($request->expectsJson()) {
        // Return JSON response
        return response()->json([
            'allProjectForms' => $allProjectForms,
            'allFiles' => $allFiles,
           'allcategories' => $allcategories
        ]);
    }
    
     
    }

    public function download($filename)
    {
        $file = File::where('file', $filename)->firstOrFail();
        $filePath = public_path('files/' . $filename);
        return response()->download($filePath);
    }
}
