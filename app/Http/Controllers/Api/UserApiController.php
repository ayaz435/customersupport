<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Models\Projectform;
use App\Models\Storedesign;
use App\Models\File;
use App\Models\inbox;
use App\Models\Review;
use App\Models\Catagory;
use App\Models\Productdesign;
use App\Models\Tickets;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Exception;


class UserApiController extends Controller
{
    // public function missingDataCheck()
    // {
    //     try {
            
    //         $loggedInUser = auth()->user();
    //         $loggedInUserEmail = $loggedInUser->email;
    //         $comId = $loggedInUser->com_id;
    
    //         $hasVBDetails = File::where('user_id', $loggedInUser->id)->exists();
    //         $hasCategoriesByEmail = Catagory::where('email', $loggedInUserEmail)->orWhere('com_id', $comId)->exists();
    //         $hasProjectFormByEmail = Projectform::where('email', $loggedInUserEmail)->orWhere('com_id', $comId)->exists();
    //         $hasFileByEmail = File::where('email', $loggedInUserEmail)->orWhere('com_id', $comId)->get();
    //         $hasStoredesignByEmail = Storedesign::where('email', $loggedInUserEmail)->orWhere('com_id', $comId)->exists();
    
    //         $fields = ['logo', 'quality_cert', 'membership_cert', 'factory_pics', 'expo_pics', 'banners'];
    
    //         $BVfields = ['com_ntn', 'form_181', 'bank_statement', 'bill', 'id_card_front', 'id_card_back'];
    
    //         $fieldLabels = [
    //             'logo' => 'Company Logo',
    //             'quality_cert' => 'Quality Certificates',
    //             'membership_cert' => 'Membership Certificates',
    //             'factory_pics' => 'Factory Production Pictures',
    //             'expo_pics' => 'Expo (Trade Show)',
    //             'banners' => 'Banners Product Picture',
    //         ];
    
    //         $BVfieldLabels = [
    //             'com_ntn' => 'Company NTN',
    //             'form_181' => 'Latest 181 Form',
    //             'bank_statement' => 'Bank Statement',
    //             'bill' => 'Phone Bill/Notery',
    //             'id_card_front' => 'ID Card Front Side',
    //             'id_card_back' => 'ID Card Back Side',
    //         ];
    
    //         $BVfieldLabels1 = [
    //             'NTN' => 'Company NTN',
    //             'Latest 181 Form' => 'Latest 181 Form',
    //             'Phone bill' => 'Phone Bill/Notery',
    //             'ID card' => 'ID Card',
    //             'Bank Statement' => 'Bank Statement',
    //         ];
    
    //         $missingData = [];
    //         $missing_status=[];
            
    //         if (!$hasVBDetails) {
    //             $missingData[] = "Business Verification files required.";
    //             $missing_status['BV_details']="Business Verification files Missing";
    //         }
            
    //         $existingFileTypes = $hasFileByEmail->pluck('filetype')->toArray();
    
    //         $missingBV = array_diff($BVfields, $existingFileTypes);
    //         $missingGeneral = array_diff($fields, $existingFileTypes);
            
    //         if ($missingBV) {
    //             $missingDescriptionsBV = array_map(function ($field) use ($BVfieldLabels) {
    //                 return $BVfieldLabels[$field] ?? $field;
    //             }, $missingBV);
    //         }
    //         // Perform API call to verify documents
    //         if ($missingBV) {
    //             $userId = $loggedInUser->drm_user_id;
    //             $response = Http::get('https://webexcels.pk/api/verify-gm-doctument?user_id=' . $userId);
    //             $body = $response->json();
    
    //             if ($body['status'] && !empty($body['data'])) {
                    
    //                 $uploaded = $body['data'][0]['uploaded_doc']; 
                    
    //                 $unverified = [];
    
    //                 foreach ($BVfieldLabels1 as $key => $label) {
    //                     if (empty($uploaded[$label]) || $uploaded[$label] !== 'yes') {
    //                         $unverified[] = $label;
    //                     }
    //                 }
                    
    //                 if ($unverified) {
    //                     $missingData[] = "Following documents are missing or not approved: " . implode(", ", $unverified);
    //                 }
    //             } else {
    //                 $missingData[] = 'Missing Required Files: ' . implode(',', $missingDescriptionsBV);
    //             }
    //         }
    
    //         if ($missingGeneral) {
    //             $missingDescriptions = array_map(function ($field) use ($fieldLabels) {
    //                 return $fieldLabels[$field] ?? $field;
    //             }, $missingGeneral);
    //             $missingData[] = 'Missing required files: ' . implode(',', $missingDescriptions);
    //         }
            
    //         if (!$hasProjectFormByEmail) {
    //             $missingData[] = "Business project form is missing.";
    //         }
            
    //         if ($hasFileByEmail->isEmpty()) {
    //             $missingData[] = "All files are missing.";
    //         }
    //         if (!$hasCategoriesByEmail) {
    //             $missingData[] = "Category details are missing.";
    //         }
    //         if (!$hasStoredesignByEmail) {
    //             $missingData[] = "Minisite design is missing.";
    //         }
            
            
            
    //         if (empty($missingData)) {
    //             return response()->json([
    //                 'success' => true,
    //                 'message' => 'All documents and details are present',
    //             ], 200);
    //         } else {
    //             return response()->json([
    //                 'success' => true,
    //                 'message' => implode(' ', $missingData),
    //             ], 200);
    //         }
    //     } catch(\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'An error occurred while checking documents',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }
    
    public function missingDataCheck()
    {
        try {
            $loggedInUser = auth()->user();
            $loggedInUserEmail = $loggedInUser->email;
            $comId = $loggedInUser->com_id;
    
            $hasVBDetails = File::where('user_id', $loggedInUser->id)->exists();
            $hasCategoriesByEmail = Catagory::where('email', $loggedInUserEmail)->orWhere('com_id', $comId)->exists();
            $hasProjectFormByEmail = Projectform::where('email', $loggedInUserEmail)->orWhere('com_id', $comId)->exists();
            $hasFileByEmail = File::where('email', $loggedInUserEmail)->orWhere('com_id', $comId)->get();
            $hasStoredesignByEmail = Storedesign::where('email', $loggedInUserEmail)->orWhere('com_id', $comId)->exists();
    
            $fields = ['logo', 'quality_cert', 'membership_cert', 'factory_pics', 'expo_pics', 'banners'];
            $BVfields = ['com_ntn', 'form_181', 'bank_statement', 'bill', 'id_card_front', 'id_card_back'];
    
            $fieldLabels = [
                'logo' => 'Company Logo',
                'quality_cert' => 'Quality Certificates',
                'membership_cert' => 'Membership Certificates',
                'factory_pics' => 'Factory Production Pictures',
                'expo_pics' => 'Expo (Trade Show)',
                'banners' => 'Banners Product Picture',
            ];
    
            $BVfieldLabels = [
                'com_ntn' => 'Company NTN',
                'form_181' => 'Latest 181 Form',
                'bank_statement' => 'Bank Statement',
                'bill' => 'Phone Bill/Notery',
                'id_card_front' => 'ID Card Front Side',
                'id_card_back' => 'ID Card Back Side',
            ];
    
            $BVfieldLabels1 = [
                'NTN' => 'Company NTN',
                'Latest 181 Form' => 'Latest 181 Form',
                'Phone bill' => 'Phone Bill/Notery',
                'ID card' => 'ID Card',
                'Bank Statement' => 'Bank Statement',
            ];
    
            $dataStatus = [];
    
            // General files status
            $existingFileTypes = $hasFileByEmail->pluck('filetype')->toArray();
            foreach ($fields as $field) {
                $dataStatus[$fieldLabels[$field]] = in_array($field, $existingFileTypes) ? 'Present' : 'Missing';
            }
    
            // BV files status (local DB check)
            foreach ($BVfields as $field) {
                $dataStatus[$BVfieldLabels[$field]] = in_array($field, $existingFileTypes) ? 'Present' : 'Missing';
            }
    
            // API verification for BV docs
            $userId = $loggedInUser->drm_user_id;
            $apiVerifiedFields = [];
    
            $response = Http::get('https://webexcels.pk/api/verify-gm-doctument?user_id=' . $userId);
            $body = $response->json();
    
            if ($response->ok() && $body['status'] && !empty($body['data'])) {
                $uploaded = $body['data'][0]['uploaded_doc'];
                foreach ($BVfieldLabels1 as $label => $labelText) {
                    $dataStatus[$labelText] = (!empty($uploaded[$labelText]) && $uploaded[$labelText] === 'yes') ? 'Present' : 'Missing';
                }
            } else {
                // fallback if API fails
                foreach ($BVfieldLabels1 as $label => $labelText) {
                    if (!isset($dataStatus[$labelText])) {
                        $dataStatus[$labelText] = 'Missing (API Error)';
                    }
                }
            }
    
            // Additional checks
            $dataStatus['Business Verification Section'] = $hasVBDetails ? 'Present' : 'Missing';
            $dataStatus['Business Project Form'] = $hasProjectFormByEmail ? 'Present' : 'Missing';
            $dataStatus['Category Details'] = $hasCategoriesByEmail ? 'Present' : 'Missing';
            $dataStatus['Minisite Design'] = $hasStoredesignByEmail ? 'Present' : 'Missing';
            $dataStatus['Any File Uploaded'] = !$hasFileByEmail->isEmpty() ? 'Present' : 'Missing';
    
            $missingItems = array_filter($dataStatus, fn($status) => str_contains($status, 'Missing'));
    
            return response()->json([
                'success' => true,
                'message' => empty($missingItems)
                    ? 'All documents and details are present'
                    : 'Some required data is missing or unverified.',
                'data_status' => $dataStatus
            ], 200);
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while checking documents.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    
    public function annaouncement()
    {
        try {
            $annaouncements = inbox::where('role', auth()->user()->role)->get();
            
            return response()->json([
                'success' => true,
                'message' => 'Announcements retrieved successfully',
                'data' => $annaouncements,
            ], 200);
        } catch(\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving announcements',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function allTeamMembers()
    {
        try {
            $team=User::where('role','team')->get();
            
            return response()->json([
                'success' => true,
                'message' => 'Team members retrieved successfully',
                'data' => $team,
            ], 200);
        } catch(\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving team ',
                'error' => $e->getMessage()
            ], 500);
        }
    }        
    
    public function tickets()
    {
        try {
            $tickets=Tickets::with('reviews')->where('user_id',Auth::user()->id)->get(); 
            
            return response()->json([
                'success' => true,
                'message' => 'Tickets retrieved successfully',
                'data' => $tickets,
            ], 200);
        } catch(\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving Tickets ',
                'error' => $e->getMessage()
            ], 500);
        }
    } 
    
    public function createTicket(Request $request)
    {
        $request->validate([
            'form_identifier' => 'required',
            'priority' => 'required',
            'ticketpurpose' => 'required',
            'com_id' => 'nullable|integer',
            'detail' => 'required'
        ]);
        
        try {
            $ticket = new Tickets();
    
            $ticket->user_id = Auth::user()->id;
            $ticket->com_id = $request->input('com_id');
            $ticket->team_id = $request->input('team_id'); // optional
            $ticket->service_id = $request->input('service_id'); // optional
            $ticket->dep_id = $request->input('dep_id'); // optional
            $ticket->category = $request->input('ticketpurpose');
            $ticket->priority = $request->input('priority');
            $ticket->description = $request->input('detail');
            $ticket->status = "pending";
            $ticket->dep_status = "pending";
            $ticket->user_feedback = "pending";
    
            $ticket->save();
    
            return response()->json([
                'success' => true,
                'message' => 'Ticket created successfully',
                'data' => $ticket,
            ], 201);
        } catch(\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the ticket',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function projectFormStore(Request $request)
    {
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
            'web' => 'required|url',
            'phone' => 'required',
            'mobile' => 'required',
            'address' => 'required',
            'catagory' => 'required',
            'cpabout' => 'required',
            'color' => 'required',
        ]);
            
        try {
            $formdata = Projectform::where('user_id', Auth::id()) 
                ->orWhere('eemail', auth()->user()->email) 
                ->first();
    
            $projectForm = $formdata ?? new Projectform;
    
            // $projectForm->form_identifier = $request->form_identifier;
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
            $projectForm->eemail = auth()->user()->email;
            $projectForm->user_id = Auth::user()->id;
    
            $projectForm->save();
    
            $postData = [
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
            ];
    
            $response = Http::post('https://webexcels.pk/api/insert_api_data.php', $postData);
    
            // if ($response->failed()) {
            //     return response()->json([
            //         'success' => false,
            //         'message' => 'Failed to send data to DRM API',
            //         'error'=>$response->json(),
            //     ], 500);
            // }
            
            return response()->json([
                'success' => true,
                'message' => 'Project form successfully saved and synced',
                'data' => $projectForm
            ], 200);
        } catch(\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while saving project form',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function compnayDetailsFormData()
    {
        try {
            $formdata= Projectform::where('user_id', Auth::id())
             ->orWhere('eemail', auth()->user()->email)
             ->first();
            
            return response()->json([
                'success' => true,
                'message' => 'Form data retrieved successfully',
                'data' => $formdata,
            ], 200);
        } catch(\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving data ',
                'error' => $e->getMessage()
            ], 500);
        }
    } 
    
    public function submitProductDesign(Request $request)
    {
        $requestData = json_decode($request->getContent(), true);

        $user = Auth::user();
    
        $validatedData = validator($requestData, [
            'detail' => 'required|string',
            'images' => 'required|array',
        ])->validate();
        
        try {
            
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
    
            return response()->json([
                'status' => 'success',
                'message' => 'Design successfully stored',
                'data' => $storedesign
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while saving the design',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function uploadProductImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors()
            ], 422);
        }
    
        try {
            $category_id = $request->input('category_id');
            $mainCategory_id = $request->input('main_category_id');
    
            if ($request->hasFile('product_image')) {
                $image = $request->file('product_image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('uploads/products'), $imageName);
    
                $imageUrl = url('public/uploads/products/' . $imageName);
    
                $productDesign = new Productdesign();
                $user = Auth::user();
    
                $productDesign->user_id = $user->id;
                $productDesign->com_id = $user->com_id;
                $productDesign->cname = $user->cname;
                $productDesign->images = $imageUrl;
                $productDesign->design_id = 0;
                $productDesign->category = $category_id;
                $productDesign->main_img = 'public/uploads/products/' . $imageName;
                $productDesign->img_url = $imageUrl;
                
                if ($mainCategory_id) {
                    $productDesign->main_category_id = $mainCategory_id;
                }
                $productDesign->is_uploaded=true;
                
                $productDesign->save();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Image uploaded successfully!',
                    'data' => $productDesign
                ], 201);
            }
    
            return response()->json([
                'success' => false,
                'message' => 'No file was selected.'
            ], 400);
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while uploading the image.',
                'error' => $e->getMessage()
            ], 500);
        }
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
        $validator = Validator::make($request->all(), [
            'main_category_id' => 'required|exists:catagories,id',
            'catagory' => 'required|string|max:255',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }
    
        try {
            $affected = DB::table('catagories')
                ->where('user_id', Auth::id())
                ->where('id', $request->main_category_id)
                ->update(['name' => $request->catagory]);
    
            if ($affected === 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'No matching category found or no change needed.'
                ], 404);
            }
    
            return response()->json([
                'success' => true,
                'message' => 'Category updated successfully.'
            ], 200);
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while updating the category.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function editSubCategoryToggle(Request $request)
    {
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
    
    public function catagory()
    {
        try {
            // Fetch unassigned subcategories
            $selected_subCategories = DB::table('sub_categories')
                ->where('user_id', Auth::id())
                ->whereNull('main_category_id')
                ->get();
    
            // Fetch unassigned product designs
            $allSavedImages = Productdesign::where('user_id', Auth::id())
                ->whereNull('main_category_id')
                ->latest()
                ->get();
    
            // Fetch categories with subcategories and their product designs
            $categories = Catagory::where('user_id', Auth::id())
                ->with(['subCategories.productDesigns'])
                ->get();
    
            // Filter product designs for each subcategory to match main_category_id
            foreach ($categories as $category) {
                foreach ($category->subCategories as $sub) {
                    $sub->setRelation(
                        'productDesigns',
                        $sub->productDesigns->filter(function ($design) use ($sub) {
                            return $design->main_category_id == $sub->main_category_id;
                        })->values()
                    );
                }
            }
            $sub_category_count = DB::table('sub_categories')
                ->where('user_id', Auth::id())->count();

            return response()->json([
                'success' => true,
                'message' => 'Data fetched successfully.',
                'data' => [
                    'selectedDesigns' => $allSavedImages,
                    'submitted_categories' => $categories,
                    'selected_subCategories' => $selected_subCategories,
                    'sub_category_count'=>$sub_category_count
                ]
            ], 200);
    
        } catch (\Exception $e) {
            // Error response
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while fetching data.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function catagoryStore(Request $request)
    {
        $request->validate([
            'catagory' => 'required|string|max:255',
        ]);
    
        try {
            $model = new Catagory;
            $model->name = $request->catagory;
            $model->user_id = Auth::id();
            $model->com_id = Auth::user()->com_id;
            $model->email = Auth::user()->email;
            $model->save();
    
            DB::table('sub_categories')
                ->where('user_id', Auth::id())
                ->whereNull('main_category_id')
                ->update(['main_category_id' => $model->id]);
    
            DB::table('productdesigns')
                ->where('user_id', Auth::id())
                ->whereNull('main_category_id')
                ->update(['main_category_id' => $model->id]);
    
            return response()->json([
                'success' => true,
                'message' => 'Category submitted successfully.',
                'data' => $model
            ], 201); // 201 Created
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while submitting the category.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function Storeproductdesign(Request $request)
    {
    
        $designIds = $request->input('designs');
        $designData = $request->input('selectedDesignData');
        $mainCategory_id = $request->input('mainCategory_id');
        $user = Auth::user();

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
            
            // dd($allSavedImagesData);
        return response()->json([
            'success' => true, 
            'message' => count($newlyAdded) . ' design(s) added to your collection',
            'newly_added' => $newlyAdded,
            'recent_designs' => $allSavedImagesData,
            'count' => Productdesign::where('user_id', Auth::user()->id)->count()
        ]);
    }
    
    public function submitModificationApi(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:pdf,jpg,png,doc,docx,xlsx,xls|max:20480', // adjust MIME types as needed
            'detail' => 'required|string',
            'com_id' => 'required',
            'pro_id' => 'required',
            'assign_user' => 'required',
            'client_status' => 'required|string',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }
    
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $file = $request->file('file');
            $fileContent = file_get_contents($file->getRealPath());
            $fileName = $file->getClientOriginalName();
    
            $modification = [
                'file' => [$fileName],
                'detail' => [$request->detail],
            ];
    
            // Send to external API
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
                return response()->json([
                    'status' => true,
                    'message' => 'Submitted successfully',
                    'response' => $response->json(),
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Failed to submit to external API',
                    'error' => $response->body(),
                ], $response->status());
            }
        }
    
        return response()->json([
            'status' => false,
            'message' => 'Invalid file uploaded.',
        ], 422);
    }

    public function bvDetails()
    {
        $user = auth()->user();
        $filedata = File::where('user_id', $user->id)->get()->keyBy('filetype');

        return response()->json([
            'status' => true,
            'message' => 'Files fetched successfully',
            'filedata' => $filedata,
        ]);
    }

    public function bvDetailsUpload(Request $request)
    {
        try {
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

            $user = auth()->user();
            $loggedInUserEmail = $user->email;

            // ✅ Fetch customer data
            $response = Http::get('https://webexcels.pk/api/customers');
            if (!$response->successful()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Failed to fetch customer data from external API.',
                ], 502);
            }

            $customerData = $response->json();
            $matchedRow = collect($customerData['data'])->firstWhere('email', $loggedInUserEmail);
            $com_id = $matchedRow['id'] ?? null;

            $uploadedFiles = [];

            foreach ($fields as $field) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);

                    $filename = time() . '_' . $field . '_' . $file->getClientOriginalName();
                    $file->move(public_path('files'), $filename);

                    $filedata = File::where('email', $loggedInUserEmail)
                        ->where('filetype', $field)
                        ->first();

                    $fileModel = $filedata ?? new File;
                    $fileModel->user_id = $user->id;
                    $fileModel->file = $filename;
                    $fileModel->email = $loggedInUserEmail;
                    $fileModel->filetype = $field;
                    $fileModel->com_id = $com_id;
                    $fileModel->save();

                    $uploadedFiles[] = [
                        'filetype' => $field,
                        'filename' => $filename,
                    ];
                }
            }

            if (empty($uploadedFiles)) {
                return response()->json([
                    'status' => false,
                    'message' => 'No files were uploaded.',
                ], 400);
            }

            return response()->json([
                'status' => true,
                'message' => 'Files uploaded successfully.',
                'uploaded_files' => $uploadedFiles,
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            Log::error('File upload failed: '.$e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong during file upload.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function fileApi()
    {
        try {
            $user = auth()->user();

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not authenticated',
                ], 401);
            }

            $filedata = File::where('email', $user->email)->get()->keyBy('filetype');

            if ($filedata->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'No files found for this user',
                    'error' => 'No files found',
                ]);
            }

            return response()->json([
                'status' => true,
                'message' => 'Files fetched successfully',
                'filedata' => $filedata,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong while fetching files',
                'error'   => $e->getMessage(), // optional: remove in production
            ], 500);
        }
    }


    public function fileUploadApi(Request $request)
    {
        try {
            // ✅ Validate file inputs
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

            $user = auth()->user();
            $loggedInUserEmail = $user->email;

            // ✅ Fetch company/customer data
            $response = Http::get('https://webexcels.pk/api/customers');

            if (!$response->successful()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Failed to fetch customer data from external API.',
                ], 502);
            }

            $customerData = $response->json();
            $matchedRow = collect($customerData['data'])->firstWhere('email', $loggedInUserEmail);
            $com_id = $matchedRow['id'] ?? null;

            $uploadedFiles = [];

            foreach ($fields as $field) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);

                    $filename = time() . '_' . $field . '_' . $file->getClientOriginalName();
                    $file->move(public_path('files'), $filename);

                    $filedata = File::where('email', $loggedInUserEmail)
                        ->where('filetype', $field)
                        ->first();

                    $fileModel = $filedata ?? new File;
                    $fileModel->email = $loggedInUserEmail;
                    $fileModel->file = $filename;
                    $fileModel->filetype = $field;
                    $fileModel->com_id = $com_id;
                    $fileModel->save();

                    $uploadedFiles[] = [
                        'filetype' => $field,
                        'filename' => $filename,
                    ];
                }
            }

            if (empty($uploadedFiles)) {
                return response()->json([
                    'status' => false,
                    'message' => 'No files were uploaded.',
                ], 400);
            }

            return response()->json([
                'status' => true,
                'message' => 'Files uploaded successfully.',
                'uploaded_files' => $uploadedFiles,
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            Log::error('File upload API failed: '.$e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong during file upload.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function reviewsStore(Request $request)
    {
        $validatedData = $request->validate([
            'complain_id'      => 'required|exists:tickets,id',
            'manager_rating'  => 'required|integer|min:1|max:5',
            'team_rating'     => 'required|integer|min:1|max:5',
            'overall_rating'  => 'required|integer|min:1|max:5',
            'suggestion'      => 'nullable|string|max:1000',
            'managerdetail'   => 'nullable|string',
            'projectdetail'   => 'nullable|string',
        ]);

        $review = Review::updateOrCreate(
            [
                'complainid' => $request->complain_id,
                'user_id'    => auth()->id(), 
            ],
            [
                'manager_rating' => $request->manager_rating,
                'team_rating'    => $request->team_rating,
                'overall_rating' => $request->overall_rating,
                'suggestion'     => $request->suggestion,
                'managerdetail'  => $request->managerdetail,
                'projectdetail'  => $request->projectdetail,
            ]
        );

        return response()->json([
            'status'  => true,
            'message' => 'Review submitted successfully',
            'data'    => $review
        ], 200);
    }

}
