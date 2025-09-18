<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use App\Models\User;
use App\Models\inbox;
use App\Models\Complain;
use App\Models\Tickets;
use App\Models\Projectform;
use App\Models\Catagory;
use App\Models\File;
use App\Models\Modification;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Review;
use App\Models\Storedesign;
use App\Models\Productdesign;
use GuzzleHttp\Promise;
use Illuminate\Pagination\LengthAwarePaginator;




class UserHomeController extends Controller
{
    // public function testWebSockets(){
    //     return view('websocketstest');
    // }
    
    // public function ITServiceLoadingPage(){
    //     return view('it_service_loading_page');
    // }


    
    public function projectView(Request $request)
    {
        $request->validate([
            'project_id'=>'required',
        ]);
        $apiUrl = "https://webexcels.pk/api/complete_project_links/{$request->input(['project_id'])}";
        $response = Http::get($apiUrl);
        $data = $response->json()['data']; 
        
        return view('user.project-view', compact('data'));    
    }
    
    public function verifyItem(Request $request)
    {
        // dd($request->all());
        try {
            $request->validate([
                'id' => 'required',
                'project_id'=> 'required',
                'task_id'=> 'required',
                'details'=> 'nullable',
                'action' => 'required|in:approve,decline'
            ]);
            
            // dd($request->all());
            
            $action = $request->input('action');
            
            if ($action === 'approve') {
                // Update the item to approved status
                // Replace this with your actual database update logic
                $updateData = [
                    "id" => $request->input('id'),
                    "pro_id" => $request->input('project_id'),
                    "task_id" => $request->input('task_id'),
                    "detail" => $request->input('details'),
                    "verify" => "Yes",
                    "verify_date" => now()->format('Y-m-d H:i:s')
                ];
                $apiUrl = "https://webexcels.pk/api/complete_project_task_status";
                $response = Http::post($apiUrl,$updateData);
                $data = $response->json(); 
                // dd($data);
                if($data['status']){
                    return response()->json([
                        'success' => true,
                        'message' => $data['message'],
                        'verify_date' => $updateData['verify_date'],
                        'action' => 'approve',
                        'id'  => $updateData['id'],
                        'pro_id' => $updateData['pro_id'],
                        'task_id' => $updateData['task_id'],
                    ]);  
                }else{
                    return response()->json([
                        'success' => false,
                        'message' => 'An error occurred: ' . $data['message']
                    ], 500);
                }
                
                
            } else { 
                
                $updateData = [
                    "id" => $request->input('id'),
                    "pro_id" => $request->input('project_id'),
                    "task_id" => $request->input('task_id'),
                    "detail" => $request->input('details'),
                    "verify" => "No",
                    "verify_date" => now()->format('Y-m-d H:i:s')
                ];
                
                $apiUrl = "https://webexcels.pk/api/complete_project_task_status";
                $response = Http::post($apiUrl,$updateData);
                $data = $response->json(); 
                // dd($data);
                if($data['status']){
                    return response()->json([
                        'success' => true,
                        'message' => $data['message'],
                        'verify_date' => $updateData['verify_date'],
                        'action' => 'decline',
                        'id'  => $updateData['id'],
                        'pro_id' => $updateData['pro_id'],
                        'task_id' => $updateData['task_id'],
                    ]);  
                }else{
                    return response()->json([
                        'success' => false,
                        'message' => 'An error occurred: ' . $data['message']
                    ], 500);
                }
            }
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }
    
    
    public function uploadProductImage(Request $request)
    {
        $request->validate([
            'product_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id'=>'required',
        ]);
        $category_id = $request->input('category_id');
        $mainCategory_id = $request->input('main_category_id');
    
        if ($request->hasFile('product_image')) {
            $image = $request->file('product_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/products'), $imageName);
            
            $productDesign = new Productdesign();
                
            $productDesign->user_id = Auth::user()->id;
            $productDesign->com_id = Auth::user()->com_id;
            $productDesign->cname = Auth::user()->cname;
            $productDesign->images = 'https://xlserp.com/customersupport/public/uploads/products/' . $imageName;
            $productDesign->design_id = 0;
            $productDesign->category = $category_id;
            $productDesign->main_img = 'uploads/products/' . $imageName;
            $productDesign->img_url = 'https://xlserp.com/customersupport/public/uploads/products/' . $imageName;
            if($mainCategory_id){
                $productDesign->main_category_id = $mainCategory_id;
            }
            $productDesign->is_uploaded=true;
            $productDesign->save();
        
            return back()->with('success', 'Image uploaded successfully!');
        }
    
        return back()->with('error', 'No file selected!');
    }
    
    public function deleteDesign(Request $request)
    {
        $designId = $request->input('designId');

        if (!$designId) {
            return response()->json([
                'success' => false,
                'message' => 'Design ID is required'
            ], 400);
        }
        
        $design = Productdesign::find($designId);
        
        if ($design) {
            $design->delete();

            return response()->json([
                'success' => true,
                'message' => 'Design removed successfully'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Design not found'
            ], 404);
        }
    }
    
    public function updateMainCategoryName(Request $request)
    {
        $request->validate([
            'main_category_id'=>'required|exists:catagories,id',
            'catagory' => 'required',
        ]);
        
        // dd($request->all());
        
        DB::table('catagories')
            ->where('user_id', Auth::user()->id)
            ->where('id',$request->main_category_id)
            ->update(['name' => $request->catagory]);
            
        return redirect()->back()->with('success', 'Catagory  updated successfully!');
    }
    
    public function editSubCategoryToggle(Request $request){
        $request->validate([
            'category_id' => 'required',
            'selected' => 'required|boolean',
            'name'=>'required|string',
            'root_id'=>'nullable',
            'main_category_id'=>'required'
        ]);
        
        // dd($request->all());
        
        $userId = Auth::id();
        $categoryId = $request->category_id;
        $isSelected = $request->selected;
        $main_category_id = $request->main_category_id;

        $table = 'sub_categories';

        if ($isSelected) {
            // Limit check
            $count = DB::table('sub_categories')->where('user_id', $userId)->count();
            if ($count >= 15) {
                return response()->json(['success'=>false, 'error' => 'Limit reached'], 403);
            }
            
            DB::table($table)->insert([
                'user_id' => $userId,
                'category_id' => $categoryId,
                'name' => $request->name,
                'root_id' => $request->root_id,
                'main_category_id'=>$main_category_id,
                'created_at' => now(), 
                'updated_at' => now(), 
            ]);
            
        } else {
            // Remove selection
            DB::table($table)->where('user_id', $userId)
                ->where('category_id', $categoryId)->where('main_category_id',$main_category_id)
                ->delete();
            DB::table('productdesigns')->where('user_id', $userId)
                ->where('category', $categoryId)->where('main_category_id',$main_category_id)
                ->delete();
        }

        return response()->json(['success' => true]);
    }
    
    public function saveSelectedCategory(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'category_id' => 'required',
            'selected' => 'required|boolean',
            'name'=>'required|string',
            'root_id'=>'nullable',
        ]);

        $userId = Auth::id();
        $categoryId = $request->category_id;
        $isSelected = $request->selected;

        $table = 'sub_categories';

        if ($isSelected) {
            // Limit check
            $count = DB::table('sub_categories')->where('user_id', $userId)->count();
            if ($count >= 15) {
                return response()->json(['success'=>false, 'error' => 'Limit reached'], 403);
            }
            
            $existing = DB::table($table)->where([
                ['user_id', '=', $userId],
                ['category_id', '=', $categoryId],
            ])->whereNull('main_category_id')->first();
            
            if ($existing) {
                DB::table($table)
                    ->where('id', $existing->id) // or match the same where conditions
                    ->update([
                        'updated_at' => now(), // example field
                    ]);
            } else {
                // Insert a new record
                DB::table($table)->insert([
                    'user_id' => $userId,
                    'category_id' => $categoryId,
                    'name' => $request->name,
                    'root_id' => $request->root_id,
                    'created_at' => now(), // optional
                    'updated_at' => now(), // optional
                ]);
            }

        } else {
            // Remove selection
            DB::table($table)->where('user_id', $userId)
                ->where('category_id', $categoryId)->whereNull('main_category_id')
                ->delete();
            DB::table('productdesigns')->where('user_id', $userId)
                ->where('category', $categoryId)->whereNull('main_category_id')
                ->delete();
        }

        return response()->json(['success' => true]);
    }
    
    
    public function updateUserComID(){
        $loggedInUserEmail =  auth()->user()->email;
        $response = Http::get('https://webexcels.pk/api/customers');
        $customerData = $response->json();
         $matchedRow = collect($customerData['data'])->firstWhere('email', $loggedInUserEmail);
        $com_id='';
        if($matchedRow){
           $com_id = $matchedRow['id'];
        }
        if($com_id){   
            $user=User::where('id', Auth::id())
            ->first();
            $user->com_id=$com_id;
            $user->save();
        }
    }
    
    public function missingDataCheck($document=''){
        
        $loggedInUserEmail =  auth()->user()->email;
        $com_id=auth()->user()->com_id;
        $hasVBDetails = File::where('user_id', auth()->user()->id)->exists();
        $hasCategoriesByEmail = Catagory::where('email', $loggedInUserEmail)->orwhere('com_id', $com_id)->exists();
        $hasProjectFormByEmail = Projectform::where('email', $loggedInUserEmail)->orwhere('com_id', $com_id)->exists();
        $hasFileByEmail = File::where('email', $loggedInUserEmail)->orwhere('com_id', $com_id)->get();
        $hasStoredesignByEmail = Storedesign::where('email', $loggedInUserEmail)->orwhere('com_id', $com_id)->exists();
        $fields = [
            'logo',
            'quality_cert',
            'membership_cert',
            'factory_pics',
            'expo_pics',
            'banners',
        ];
        $BVfields=[
            'com_ntn',
            'form_181',
            'bank_statement',
            'bill',
            'id_card_front',
            'id_card_back',
            ];
        
        $fieldLabels = [
            'logo' => 'Company Logo',
            'quality_cert' => 'Quality Certificates',
            'membership_cert' => 'Membership Certificates',
            'factory_pics' => 'Factory Production Pictures',
            'expo_pics' => 'Expo (Trade Show)',
            'banners' => 'Banners Product Picture',
        ];
        
        $BVfieldLabels1=[
            'NTN' => 'Company NTN',
            'Latest 181 Form' => 'Latest 181 Form',
            'Phone bill' => 'Phone Bill/Notery',
            'ID card' => 'ID Card',
            'Bank Statement' => 'ID Card Back Side',
            ];
            
        $BVfieldLabels=[
            'com_ntn' => 'Company NTN',
            'form_181' => 'Latest 181 Form',
            'bank_statement' => 'Bank Statement',
            'bill' => 'Phone Bill/Notery',
            'id_card_front' => 'ID Card Front Side',
            'id_card_back' => 'ID Card Back Side',
            ];

        $missingData='';
        
        if (!$hasVBDetails) {
            $missingData = " BV details files required, ";
        }
        if (!$hasProjectFormByEmail) {
            $missingData .= " BV data missing, ";
        }
        
        $existingFileTypes = $hasFileByEmail->pluck('filetype')->toArray();
        
        $missingBVFields = array_diff($BVfields, $existingFileTypes);
        $missingDescriptionsBV = array_map(function ($BVfield) use ($BVfieldLabels) {
            return $BVfieldLabels[$BVfield] ?? $BVfield;
        }, $missingBVFields);
        if($missingDescriptionsBV){
            
            $user_id=Auth::user()->drm_user_id;
            $response = Http::get('https://webexcels.pk/api/verify-gm-doctument?user_id=' . $user_id);
            $body = $response->json();
            // print_r($user_id);
            // dd($body);
            
            if ($body['status'] && !empty($body['data'])) {
                
                $uploaded = $body['data'][0]['uploaded_doc'];
            
                $missing = [];
            
                foreach ($BVfieldLabels1 as $key => $label) {
                    if (empty($uploaded[$label]) || $uploaded[$label] !== 'yes') {
                        $missing[] = $label;
                    }
                }
                
                if ($missing) {
                    $missingData .= " Following documents are missing or not approved: " . implode(", ", $missing);
                } 
            } else {
                $missingData .= ' Missing required files: '. implode(', ', $missingDescriptionsBV);
            }
        }
        
        $missingFields = array_diff($fields, $existingFileTypes);
        $missingDescriptions = array_map(function ($field) use ($fieldLabels) {
            return $fieldLabels[$field] ?? $field;
        }, $missingFields);
        if($missingDescriptions){
             $missingData .= 'Missing required files: '. implode(', ', $missingDescriptions);
        }
        
        
        
        if (!$hasFileByEmail) {
            $missingData .= " required files missing , Company logo PNG, Quality Certificates, Membership Certificates, Factory Production Pictures, Expo (Trade Show), Banners Product Picture. ";
        }
        if (!$hasCategoriesByEmail) {
            $missingData .= " Category Details missing. ";
        }
        if (!$hasStoredesignByEmail) {
            $missingData .= " Minisite design  missing. ";
        }
        return $missingData;
    }

    
     public function bvDetails()
    {
        // $user_id=Auth::user()->drm_user_id;
        
        // $response = Http::get('https://webexcels.pk/api/verify-gm-doctument?user_id=' . $user_id);
        // $body = $response->json();
        // // dd($body);
        // $fieldLabels = [
        //     'com_ntn'  => 'NTN',
        //     'form_181' => 'Latest 181 Form',
        //     'bill'     => 'Phone bill',
        //     'id_card'  => 'ID card',
        //     'deed'     => 'Deed'
        // ];
        // if ($body['status'] && !empty($body['data'])) {
        //     $uploaded = $body['data'][0]['uploaded_doc'];
        //     $missing = [];
        //     foreach ($fieldLabels as $key => $label) {
        //         if (empty($uploaded[$label]) || $uploaded[$label] !== 'yes') {
        //             $missing[] = $label;
        //         }
        //     }
            
        //     if ($missing) {
        //         $msg = "Following documents are missing or not approved: " . implode(", ", $missing);
        //     }
        // }
        
        $missingData=$this->missingDataCheck();

        $filedata = File::where('user_id', auth()->user()->id)->get()->keyBy('filetype');
        
        return view('user.bvdetails',['filedata'=>$filedata , 'missingData'=>$missingData]);
    }

    public function bvDetailsUpload(Request $request)
    {
        $validatedData = $request->validate([
            'com_ntn' => 'nullable|file|mimes:jpeg,png,jpg,pdf,doc,docx,xls,xlsx|max:2048',
            'form_181' => 'nullable|file|mimes:jpeg,png,jpg,pdf,doc,docx,xls,xlsx|max:2048',
            'bank_statement' => 'nullable|file|mimes:jpeg,png,jpg,pdf,doc,docx,xls,xlsx|max:2048',
            'bill' => 'nullable|file|mimes:jpeg,png,jpg,pdf,doc,docx,xls,xlsx|max:2048',
            'id_card_front' => 'nullable|file|mimes:jpeg,png,jpg,pdf,doc,docx,xls,xlsx|max:2048',
            'id_card_back' => 'nullable|file|mimes:jpeg,png,jpg,pdf,doc,docx,xls,xlsx|max:2048',
        ]);

        
        $fields = [
            'com_ntn',
            'form_181',
            'bank_statement',
            'bill',
            'id_card_front',
            'id_card_back',
        ];
        
        $loggedInUserEmail =  auth()->user()->email;

        $response = Http::get('https://webexcels.pk/api/customers');
        $customerData = $response->json();
        $matchedRow = collect($customerData['data'])->firstWhere('email', $loggedInUserEmail);
        $com_id='';         if($matchedRow){         $com_id = $matchedRow['id'];         }
    
        foreach ($fields as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $filename = time() . '_' . $field . '_' . $file->getClientOriginalName();
                $file->move(public_path('files'), $filename);
    
                $filedata = File::where('email', auth()->user()->email)
                            ->Where('filetype', $field)
                            ->first();

                $fileModel = $filedata ?? new File;
                $fileModel->user_id = auth()->user()->id;
                $fileModel->file = $filename;
                $fileModel->email =  auth()->user()->email;
                $fileModel->filetype = $field;
                $fileModel->com_id = $com_id;
                $fileModel->save();
            }
        }
        

        return redirect()->back()->with('success', 'Files uploaded successfully.');
    }

    public function projectform()
    {
     if (Auth::check()) {
        $formdata= Projectform::where('user_id', Auth::id())
             ->orWhere('eemail', auth()->user()->email)
             ->first();
        $loggedInUserEmail =  auth()->user()->email;
        $missingData=$this->missingDataCheck();
        $user=User::where('id', Auth::id())
            ->first();
            
        if(!$user->com_id){
            $this->updateUserComID();
        }
        
        $data = Http::get("https://webexcels.pk/api/project/{$user->com_id}");
                $projectData = $data->json();

        return view('user.projectform', ['projectData' => $projectData, 'formdata'=>$formdata, 'user'=>$user, 'missingData'=>$missingData]);
        }
     return response()->json(['error' => 'User not authenticated.'], 401);
    }


    public function projectformstore(Request $request)
    {
        // Validate the form data
        $request->validate([
            'form_identifier' => 'required',
            'cname' => 'required',
            'com_id' => 'required',
            'cpname' => 'required',
            'ppname' => 'required',
            'nic' => 'required',
            'ntn' => 'required',
            'project' => 'required',
            'email' => 'required|email',
            'web' => 'required',
            'phone' => 'required',
            'mobile' => 'required',
            'address' => 'required',
            'catagory' => 'required',
            'cpabout' => 'required',
            'color' => 'required',
        ]);

        $formdata = Projectform::where('user_id', Auth::id())
            ->orWhere('eemail', auth()->user()->email)
            ->first();

        // If it exists, update it; otherwise, create new
        $projectForm = $formdata ?? new Projectform;

        $projectForm->form_identifier = $request->form_identifier;
        $projectForm->cname = $request->cname;
        $projectForm->com_id = $request->com_id;
        $projectForm->cpname = $request->cpname;
        $projectForm->ppname = $request->ppname;
        $projectForm->nic = $request->nic;
        $projectForm->ntn = $request->ntn;
        $projectForm->project = $request->project;
        $projectForm->email = $request->email;
        $projectForm->web = $request->web;
        $projectForm->phone = $request->phone;
        $projectForm->mobile = $request->mobile;
        $projectForm->address = $request->address;
        $projectForm->catagory = $request->catagory;
        $projectForm->cpabout = $request->cpabout;
        $projectForm->rwebsite = $request->rwebsite;
        $projectForm->color = $request->color;
        $projectForm->ywebsite = $request->ywebsite;

        $userEmail = auth()->user()->email;
        // Assign user ID to the file record
        $projectForm->eemail = $userEmail;
        $projectForm->user_id = Auth::user()->id;
        // Save the Projectform instance
        $projectForm->save();

        // Prepare the data to send to the external API

        // Send the data to the API endpoint
        $response = Http::post('https://webexcels.pk/api/insert_api_data.php', [


            'form_identifier' => $request->form_identifier,
            'cname' => $request->cname,
            'cpname' => $request->cpname,
            'ppname' => $request->ppname,
            'nic' => $request->nic,
            'ntn' => $request->ntn,
            'project' => $request->project,
            'email' => $request->email,
            'web' => $request->web,
            'phone' => $request->phone,
            'mobile' => $request->mobile,
            'address' => $request->address,
            'catagory' => $request->catagory,
            'cpabout' => $request->cpabout,
            'color' => $request->color,

        ]);
        // dd($response->json());

        // Check if the request was successful
        if ($response->successful()) {
            // Redirect back to the form with a success message
            return redirect()->back()->with('success', 'Form submitted successfully!');
        } else {
            // Redirect back to the form with an error message
            return redirect()->back()->with('error', 'Failed to submit form. Please try again later.');
        }

    }

    public function catagory()
    {
        
        $missingData=$this->missingDataCheck();
        
        $categoriesResponse = Http::get('https://webexcels.pk/api/products-categories');
        $subCategories = $categoriesResponse->json();
        
        $selected_subCategories = DB::table('sub_categories')->where('user_id', Auth::user()->id)->whereNull('main_category_id')->get();

        $allSavedImages = Productdesign::where('user_id', Auth::user()->id)->whereNull('main_category_id')
            ->latest()
            ->get();
            
        // $categories = Catagory::where('user_id', auth()->id())
        //                     ->with([
        //                         'subCategories' => function ($query) {
        //                             $query->whereNotNull('main_category_id')
        //                                   ->with(['productDesigns' => function ($q) {
        //                                       $q->whereNotNull('main_category_id')
        //                                         ->where('main_category_id', $query->main_category_id);
        //                                   }]);
        //                         }
        //                     ])
        //                     ->get();
        $categories = Catagory::where('user_id', auth()->id())
            ->with(['subCategories.productDesigns'])
            ->get();
        
        foreach ($categories as $category) {
            foreach ($category->subCategories as $sub) {
                // Filter product designs where main_category_id matches
                $sub->setRelation('productDesigns', $sub->productDesigns->filter(function ($design) use ($sub) {
                    return $design->main_category_id == $sub->main_category_id;
                })->values());
            }
        }
        // dd(Auth::user()->id);
        // $categories = Catagory::where('user_id', auth()->id())
        //     ->with(['subCategories.productDesigns'])
        //     ->get();
        
        
        //  dd(['missingData' => $missingData, 'selectedDesigns' => $allSavedImages,'submitted_categories'=>$categories, 'subCategories' => $subCategories,'selected_subCategories'=>$selected_subCategories ]);   
        
        return view('user.catagory', ['missingData' => $missingData, 'selectedDesigns' => $allSavedImages, 'subCategories' => $subCategories,'submitted_categories'=>$categories,'selected_subCategories'=>$selected_subCategories ]);
    }

    public function catagorystore(Request $request)
    {
        $request->validate([
            'catagory' => 'required',
        ]);
        
        $model = new Catagory;
        $model->name = $request->catagory;
        $model->user_id = Auth::user()->id;
        $model->com_id = Auth::user()->com_id;
        $model->email = Auth::user()->email;
        $model->save();
        
        DB::table('sub_categories')
            ->where('user_id', Auth::user()->id)
            ->whereNull('main_category_id')
            ->update(['main_category_id' => $model->id]);
            
        
        DB::table('productdesigns')
            ->where('user_id', Auth::user()->id)
            ->whereNull('main_category_id')
            ->update(['main_category_id' => $model->id]);
         
    
        return redirect()->back()->with('success', 'Catagory  submitted successfully!');
    }

     public function file()
    {
        $missingData=$this->missingDataCheck();

        $filedata = File::where('email', auth()->user()->email)->get()->keyBy('filetype');
        
        return view('user.files',['filedata'=>$filedata , 'missingData'=>$missingData]);
    }


    public function fileupload(Request $request)
    {
        $validatedData = $request->validate([
            'logo' => 'nullable|file|mimes:png|max:2048',
            'quality_cert' => 'nullable|file|mimes:jpeg,png,jpg,pdf,doc,docx,xls,xlsx|max:2048',
            'membership_cert' => 'nullable|file|mimes:jpeg,png,jpg,pdf,doc,docx,xls,xlsx|max:2048',
            'factory_pics' => 'nullable|file|mimes:jpeg,png,jpg,pdf,doc,docx,xls,xlsx|max:2048',
            'expo_pics' => 'nullable|file|mimes:jpeg,png,jpg,pdf,doc,docx,xls,xlsx|max:2048',
            'banners' => 'nullable|file|mimes:jpeg,png,jpg,pdf,doc,docx,xls,xlsx|max:2048',
        ]);

        
        $fields = [
            'logo',
            'quality_cert',
            'membership_cert',
            'factory_pics',
            'expo_pics',
            'banners',
        ];
        
        $loggedInUserEmail =  auth()->user()->email;

        $response = Http::get('https://webexcels.pk/api/customers');
        $customerData = $response->json();
        $matchedRow = collect($customerData['data'])->firstWhere('email', $loggedInUserEmail);
        $com_id='';         if($matchedRow){         $com_id = $matchedRow['id'];         }
    
        foreach ($fields as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $filename = time() . '_' . $field . '_' . $file->getClientOriginalName();
                $file->move(public_path('files'), $filename);
    
                $filedata = File::where('email', auth()->user()->email)
                            ->Where('filetype', $field)
                            ->first();

                $fileModel = $filedata ?? new File;
                $fileModel->email = auth()->user()->email;
                $fileModel->file = $filename;
                $fileModel->filetype = $field;
                $fileModel->com_id = $com_id;
                $fileModel->save();
            }
        }
        

        return redirect()->back()->with('success', 'Files uploaded successfully.');
    }
    
    public function index(Request $request)
    {
        $user = $request->user();
    
        $messages = Inbox::where('role', $user->role)->get();
    
        $response = Http::get('https://webexcels.pk/api/promotion');
    
        $data = $response->json();
        
        $missingData=$this->missingDataCheck();
        
    
        if (isset($data['result']) && $data['result'] === 'found' && isset($data['data'][0]['img'])) {
            // Image is found, pass the image path to the dashboard view
            $imagePath = $data['folderPath'] . $data['data'][0]['img'];
            return view('user.dashboard', ['imagePath' => $imagePath, 'data' => $data['data'], 'messages' => $messages, 'missingData'=>$missingData]);
        } else  {
            // No image found, pass a message indicating so
            return view('user.dashboard', ['messages' => $messages, 'missingData'=>$missingData])->with(['message' => 'No image found.']);
        } 
    
    }


    public function Submitcomplain(Request $request)
    {
        $request->validate([
        'form_identifier' => 'required',
            'priority' => 'required',
            'dep' => 'required',
            'user_id' => 'required',
            'com_id' => 'required',
            'service' => 'required',
            'detail' => 'required'
        ]);
    
        // Post data to the API endpoint
        $response = Http::post('https://webexcels.pk/api/insert_api_data.php', [
        'form_identifier' => $request->form_identifier,
            'priority' => $request->priority,
            'dep' => $request->dep,
            'user_id' => $request->user_id,
            'com_id' => $request->com_id,
            'service' => $request->service,
            'detail' => $request->detail
        ]);
    
        // Check if the request was successful
        if ($response->successful()) {
            // Redirect back with success message
            return redirect()->back()->with('success', 'Request Sent Successfully');
        } else {
            // Handle the case when the request to the API fails
            return redirect()->back()->with('error', 'Failed to send request to API');
        }
    }
 
    public function chat()
    {
        return view('vendor.chatify.pages.app');
        //   $admin = Auth::guard('admin')->user();
        //   echo 'Welcome ' . $admin->name . ' <a href="' . route('admin.logout') . '">Logout</a>';
    }
    
    public function complain()
    {
        $user = Auth::user();
        // $userEmail = $user->email;
        
        // $response = Http::get('https://webexcels.pk/api/complaints');
            // $depapiData = json_decode(file_get_contents('https://webexcels.pk/api/department'), true);
    
        $complains=Tickets::with('reviews')->where('user_id',Auth::user()->id)->get();
    
        // $teamapiData = json_decode(file_get_contents('https://webexcels.pk/api/team'), true);
        
        $team=User::where('role','team')->get();
    
        $serviceapiData = json_decode(file_get_contents('https://webexcels.pk/api/service'), true);
    
        $missingData=$this->missingDataCheck();
        
        return view('user.complain', ['comId' => $user->com_id,  'teamNames' => $team, 'serviceNames' => $serviceapiData['data'], 'complains' => $complains, 'missingData'=>$missingData ]);
    }
    
    public function createTicket(Request $request){
       $request->validate([
            'form_identifier' => 'required',
            'priority' => 'required',
            'ticketpurpose' => 'required',
            'com_id' => 'nullable',
            'detail' => 'required'
        ]); 
        
        // dd($request);
        
        $Ticket= new Tickets();
        
        $Ticket->user_id=Auth::user()->id;
        $Ticket->com_id=$request->input('com_id');
        $Ticket->team_id=$request->input('team_id');
        $Ticket->service_id=$request->input('service_id');
        $Ticket->dep_id=$request->input('dep_id');
        $Ticket->category=$request->input('ticketpurpose');
        $Ticket->priority=$request->input('priority');
        $Ticket->description=$request->input('detail');
        $Ticket->status="pending";
        $Ticket->dep_status="pending";
        $Ticket->user_feedback="pending";
        
        $Ticket->save();
        
        return redirect()->route('user.complain')->with('success', 'Ticket created successfully!');
    
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('login');
    }

    public function downloadclient($filename)
    {
        $file = File::where('file', $filename)->firstOrFail();
        $filePath = public_path('files/' . $filename);
        return response()->download($filePath);
    }

    public function projectdetail(Request $request)
    {
        $missingData=$this->missingDataCheck();
    
        if (Auth::check()) {
            $loggedInUserEmail = Auth::user()->email;
            $projectforms = Projectform::where('eemail', $loggedInUserEmail)
                ->orderBy('created_at', 'desc')
                ->get();
            $files = File::where('email', $loggedInUserEmail)
                ->orderBy('created_at', 'desc')
                ->get();
            $categories = Catagory::where('user_id', auth()->id())
            ->with(['subCategories.productDesigns'])
            ->get();
            $mini_site_design = Storedesign::where('user_id', auth()->id())
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
            $customerId=Auth::user()->com_id;    
            $data = Http::get("https://webexcels.pk/api/project/{$customerId}");
            $projectData = $data->json();
            
            $firstItem = $projectData['data'][0] ?? null;
        
            $assignUserId = $firstItem['assign_user'] ?? null;
          
            if (isset($projectData['data']) && is_array($projectData['data'])) {
                $teamResponse = Http::get("https://webexcels.pk/api/team");
                $teamData = $teamResponse->json();
                
                foreach ($projectData['data'] as &$project) {
                    $userId = $project['assign_user'];
                    $project['assign_user_id'] = $userId; // Store the ID separately for route use
                    $user = collect($teamData['data'])->firstWhere('user_id', $userId);
                    $project['assign_user'] = $user ? $user['name'] : 'Unknown User'; // Replace with name for display
                }


               return view('user.projectdetails', [
                    'projectData' => $projectData,
                    'projectforms' => $projectforms,
                    'files' => $files, 
                    'assign_user' => $assignUserId, 
                    
                    'categories' => $categories,
                    'mini_site_design'=>$mini_site_design,
                    'missingData'=>$missingData,
                    'com_id' => $customerId 
                ]);
            }
        }
        
        return view('user.projectdetails',['missingData'=>$missingData])->with('message', 'No project data found.');
    }


    public function modification(Request $request, $id = null)
    {
       $missingData=$this->missingDataCheck();
       
        $assign_user_id = $request->assign_user; // This will now be 54169
        return view('user.modification', [
            'pro_id' => $id,
            'assign_user' => $assign_user_id, // This will pass the ID to the view
            'com_id' => $request->com_id,
            'missingData'=>$missingData
        ]);
    }

    public function submitmodification(Request $request)
    {
        // dd($request->all());
        
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $fileContent = file_get_contents($request->file('file')->getRealPath());
            $fileName = $request->file('file')->getClientOriginalName();
    
            $modification = [
                'file' => [
                    $fileName 
                ],
                'detail' => [
                    $request->detail 
                ]
            ];
    
            // Send the API request
           $response = Http::attach(
            'contents', $fileContent, $fileName 
                )->post('https://webexcels.pk/api/update_project', [
                    'com_id' => $request->com_id,
                    'pro_id' => $request->pro_id,
                    'assign_user' => $request->assign_user,
                    'modification' => json_encode($modification), 
                    'client_status' => $request->client_status,
                ]);

            if ($response->successful()) {
                return redirect('user/modification')->with('success', 'Submit Successfully');
            } else {
                return back()->with('error', 'Something went wrong');
            }
        } else {
            return back()->with('error', 'Invalid file uploaded.');
        }
    }

    public function payment(Request $request)
    {
        if (Auth::check()) {
            $missingData=$this->missingDataCheck();
            $comId=Auth::user()->com_id;
            // dd($comId);
            $paymentResponse = Http::get("https://webexcels.pk/api/project-payment/{$comId}");
            $paymentData = $paymentResponse->json();
    
            // $alibabapaymentResponse = Http::get("https://webexcels.pk/api/gm-list/");
            $alibabapaymentResponse = Http::get("https://webexcels.pk/api/gmupdatedata?com_id={$comId}");           
            $filteredAlibabaData = $alibabapaymentResponse->json();
            // $filteredAlibabaData=$alibabaData['data'];
    
            // $filteredAlibabaData = collect($alibabaData['data'])->filter(function ($item) use ($comId) {
            //     return $item['com_id'] == $comId;
            // })->toArray();
            // dd($filteredAlibabaData);
    
            return view('user.payment', compact('paymentData', 'filteredAlibabaData','missingData'));
        } else {
            return response()->json(['error' => 'User not authenticated.'], 401);
        }
    }


    public function training()
    {
      $response = Http::get('https://webexcels.pk/api/customer-training');
        $trainingData = $response->json();
        return view('user.training', ['trainingData' => $trainingData]);
    }


    public function storereview(Request $request)
    {
        $validatedData = $request->validate([
            'complainid'      => 'required|exists:tickets,id',
            'manager_rating'   => 'required|integer|min:1|max:5',
            'team_rating'      => 'required|integer|min:1|max:5',
            'overall_rating'   => 'required|integer|min:1|max:5',
            'suggestion'       => 'nullable|string|max:1000',
            'managerdetail' => 'nullable',
            'projectdetail' => 'nullable',
        ]);

        $review = Review::updateOrCreate(
            [
                'complainid' => $request->complainid,
                'user_id'     => auth()->id(),
            ],
            [
                'manager_rating' => $request->manager_rating,
                'team_rating'    => $request->team_rating,
                'overall_rating' => $request->overall_rating,
                'suggestion'     => $request->suggestion,
                'managerdetail' => $request->managerdetail,
                'projectdetail' => $request->projectdetail,
            ]
        );

        return response()->json(['message' => 'Review submitted successfully', 'review' => $review]);
    }
    
    public function design()
    {
    
        $mainCategoriesResponse = Http::get('https://webexcels.pk/api/portfolio-categories');
        $mainCategories = $mainCategoriesResponse->json()['data'];
    
        $missingData=$this->missingDataCheck();
    
        return view('user.design', [
            'mainCategories' => $mainCategories,
            'missingData'=>$missingData
        ]);
    }
    
    public function productDesign(Request $request)
    {
        $categoryId = $request->query('id');
        $response = Http::timeout(120)->get('https://webexcels.pk/api/product-wise-data/' . $categoryId);
        $responseData = $response->json();
    
        if (!$response->successful() || $responseData['status'] !== "true") {
            abort(500, 'Failed to fetch product data.');
        }
        
         $data = $responseData['data'];

        // Extract main_images
        $mainImages = $data['main_images'] ?? [];
    
        // Pagination logic
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 20;
        $mainImagesCollection = collect($mainImages);
        $paginatedImages = new LengthAwarePaginator(
            $mainImagesCollection->forPage($currentPage, $perPage),
            $mainImagesCollection->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );
        $categories['id']=$data['id'];
        $categories['root_id']=$data['root_id'];
        $categories['name']=$data['name'];
        
        
        $main_images = $paginatedImages; 
        // dd($main_images);

        return view('user.productdesign', compact('main_images','categories'));
    }

    public function storeDesign(Request $request)
    {
        $requestData = json_decode($request->getContent(), true);
        
        // dd($requestData);
        
        $user = Auth::user();
        
        $validatedData = validator($requestData, [
            'detail' => 'required|string',
            'images' => 'required|array',
        ])->validate();
    
        $images = $validatedData['images'];
    
        foreach ($images as $image) {
            // Check if design already exists for this user
            $storedesign = Storedesign::where('user_id', $user->id)
                ->where('design_id', $image['design_id'])
                ->first();
    
            if (!$storedesign) {
                $storedesign = new Storedesign();
                $storedesign->user_id = $user->id;
                $storedesign->design_id = $image['design_id'];
            }
    
            // Common fields to create or update
            $storedesign->detail = $validatedData['detail'];
            $storedesign->images = json_encode($image); // Or store individually below
            $storedesign->drm_user_id = $image['drm_user_id'] ?? null;
            $storedesign->category_id = $image['category_id'] ?? null;
            $storedesign->sub_category_id = $image['sub_category_id'] ?? null;
            $storedesign->design_name = $image['design_name'] ?? null;
            $storedesign->main_img = $image['imgPath'] ?? null;
            $storedesign->sliders = $image['sliders'] ?? null;
            $storedesign->main_sliders = $image['main_sliders'] ?? null;
            $storedesign->status = $image['status'] ?? null;
            $storedesign->com_id = $user->com_id;
            $storedesign->cname = $user->cname;
            $storedesign->email = $user->email;
            $storedesign->save();
        }
    
        return response()->json(['message' => 'Data saved successfully'], 200);
    }

    public function Storeproductdesign(Request $request)
    {
            // dd($request->all());

        $designIds = $request->input('designs');
        $designData = $request->input('selectedDesignData');
        $mainCategory_id = $request->input('mainCategory_id');
        $user = Auth::user();
        // dd($designData);
        if (empty($designIds)) {
            return response()->json(['success' => false, 'message' => 'No designs selected']);
        }
    
        $newlyAdded = [];
        
        foreach ($designIds as $index => $designId) {
            $currentDesignData = isset($designData[$index]) ? $designData[$index] : null;
            
            // Check if already exists
            $exists = Productdesign::where('user_id', $user->id)
                ->where('design_id', $designIds[$index])
                ->exists();
                
            if (!$exists && $currentDesignData) {
                $productDesign = new Productdesign();
                
                // Store all the design data
                $productDesign->user_id = $user->id;
                $productDesign->com_id = $user->com_id;
                $productDesign->cname = $user->cname;
                $productDesign->images = $currentDesignData['img_url'];
                $productDesign->design_id = $currentDesignData['id'];
                $productDesign->category = $currentDesignData['category'];
                $productDesign->main_img = $currentDesignData['main_img'];
                $productDesign->img_url = $currentDesignData['img_url'];
                if($mainCategory_id){
                    $productDesign->main_category_id = $mainCategory_id;
                }

                $productDesign->save();
                
                $newlyAdded[] = $productDesign;
            }
        }
        
        $allSavedImagesData = Productdesign::where('user_id', Auth::user()->id)->whereNull('main_category_id')
            ->latest()
            ->get();
            
            
        // return redirect()->route('user.catagory')->with('success', count($newlyAdded) . ' design(s) added to your collection');
    
            // dd($allSavedImagesData);
        return response()->json([
            'success' => true, 
            'message' => count($newlyAdded) . ' design(s) added to your collection',
            'newly_added' => $newlyAdded,
            'recent_designs' => $allSavedImagesData,
            'count' => Productdesign::where('user_id', Auth::user()->id)->count()
        ]);
    }
    
 
    public function homeprojectform()
    {
        if (Auth::check()) {
            $customerId=Auth::user()->com_id;
            $data = Http::get("https://webexcels.pk/api/project/{$customerId}");
                    
            if ($data->successful()) {
                $projectData = $data->json();
                
                // Ensure $projectData['data'] is an array
                if (isset($projectData['data']) && is_array($projectData['data'])) {
                    $teamResponse = Http::get("https://webexcels.pk/api/team");
                    
                    if ($teamResponse->successful()) {
                        $teamData = $teamResponse->json();
                        foreach ($projectData['data'] as &$project) {
                            $userId = $project['assign_user'];
                            $user = collect($teamData['data'])->firstWhere('user_id', $userId);
                            $project['assign_user'] = $user ? $user['name'] : 'Unknown User';
                        }
                    }
                }
            }
            
           $missingData=$this->missingDataCheck();
            // Pass $projectData to the view (will be empty array if no data found)
            return view('user.homeprojectform', ['projectData' => $projectData, 'missingData'=>$missingData]);
        }
        
        // Redirect if not authenticated
        return redirect()->route('login');
    }


    public function homeprojectformstore(Request $request)
    {
    
    
        // Validate the form data
        $request->validate([
            'form_identifier' => 'required',
            'cname' => 'required',
            'com_id' => 'required',
            'cpname' => 'required',
            'ppname' => 'required',
            'nic' => 'required',
            'ntn' => 'required',
            'project' => 'required',
            'email' => 'required',
            'web' => 'required',
            'phone' => 'required',
            'mobile' => 'required',
            'address' => 'required',
            'catagory' => 'required',
            'cpabout' => 'required',
            'color' => 'required',
        ]);
    
        // Create a new Projectform instance and fill it with the validated data
        $projectForm = new Projectform;
        $projectForm->form_identifier = $request->form_identifier;
        $projectForm->cname = $request->cname;
        $projectForm->com_id = $request->com_id;
        $projectForm->cpname = $request->cpname;
        $projectForm->ppname = $request->ppname;
        $projectForm->nic = $request->nic;
        $projectForm->ntn = $request->ntn;
        $projectForm->project = $request->project;
        $projectForm->email = $request->email;
        $projectForm->web = $request->web;
        $projectForm->phone = $request->phone;
        $projectForm->mobile = $request->mobile;
        $projectForm->address = $request->address;
        $projectForm->catagory = $request->catagory;
        $projectForm->cpabout = $request->cpabout;
        $projectForm->rwebsite = $request->rwebsite;
        $projectForm->color = $request->color;
        $projectForm->ywebsite = $request->ywebsite;
    
        // Assign user email to the record
        $userEmail = auth()->user()->email;
        $projectForm->eemail = $userEmail;
    
        // Save the Projectform instance
        $projectForm->save();
    
        // Send the data to the external API
        $response = Http::post('https://webexcels.pk/api/insert_api_data.php', [
            'form_identifier' => $request->form_identifier,
            'cname' => $request->cname,
            'cpname' => $request->cpname,
            'ppname' => $request->ppname,
            'nic' => $request->nic,
            'ntn' => $request->ntn,
            'project' => $request->project,
            'email' => $request->email,
            'web' => $request->web,
            'phone' => $request->phone,
            'mobile' => $request->mobile,
            'address' => $request->address,
            'catagory' => $request->catagory,
            'cpabout' => $request->cpabout,
            'color' => $request->color,
        ]);
    
            // Check if the API request was successful
         if ($projectForm->save()) {
            // Redirect to the desired route with the project name
            return redirect()->route('homeuser.file', ['project' => $projectForm->project])
                ->with('success', 'Form submitted successfully!');
        } else {
            // Redirect back with an error message
            return redirect()->back()->with('error', 'Failed to submit form. Please try again later.');
        }
        
    }


    public function homecatagory()
    {
        $missingData=$this->missingDataCheck();
        return view('user.homecatagory', ['missingData'=>$missingData]);
    }

    public function homecatagorystore(Request $request)
    {
        $request->validate([
            'catagory' => 'required',
            'subcatagory.*' => 'nullable|string', 
        ]);
    
        $model = new Catagory;
        $model->catagory = $request->catagory;
        $userEmail = auth()->user()->email;
            $model->email = $userEmail;
    
        if ($request->has('subcatagory')) {
            $subcategoriesString = implode(', ', $request->subcatagory); 
            $model->subcatagory = $subcategoriesString;
        }
    
        $model->save();
    
        return redirect()->back()->with('success', 'Catagory  submitted successfully!');
    }


    public function homefile($project)
    {
        $filetypesToCheck = [
            'Companylogo',
            'QualityCertificates',
            'MembershipCertificates',
            'FactoryProductionPictures',
            'ExpoTradeShow',
            'BannersProductPicture',
        ];
    
        $files = File::where('projectid', $project)
            ->whereIn('filetype', $filetypesToCheck)
            ->get();
    
        $matchedValues = [];
    
        foreach ($filetypesToCheck as $filetype) {
            $matchedValues[$filetype] = $files->firstWhere('filetype', $filetype);
        }
    
        $allFilesPresent = collect($filetypesToCheck)->every(fn($filetype) => isset($matchedValues[$filetype]));
    
        // Redirect to different views based on the presence of all file types
        if ($allFilesPresent) {
            return redirect()->route('user.dashboard');
        } else {
            $missingData=$this->missingDataCheck();
            return view('user.homefiles', compact('project', 'matchedValues','missingData'));
        }
    }



    public function homefileupload(Request $request)
    {
        // Validate the uploaded files
        $request->validate([
            'files.*' => 'required|mimes:jpeg,png,jpg,pdf,doc,docx,xls,xlsx|max:2048', 
        'filetype'=>'required'
        // Assuming maximum file size is 2MB and accepting only certain file types
        ]);

        // Check if files are present in the request
        if ($request->hasFile('files')) {
        
      
            // Upload and store each file
            foreach ($request->file('files') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('files'), $filename);

                // Save file record to the database
                $fileModel = new File;
                $fileModel->email = auth()->user()->email;
                $fileModel->file = $filename;
               $fileModel->filetype = $request->filetype;
            $fileModel->projectid = $request->projectid;
            
            
                $fileModel->save();
            }
        } else {
            // Handle case when no files are uploaded
            return redirect()->back()->with('error', 'No files were uploaded.');
        }

        return redirect()->back()->with('success', 'Files uploaded successfully.');
    }




}
