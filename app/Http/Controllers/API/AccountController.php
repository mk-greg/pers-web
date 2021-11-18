<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use App\Models\Account;
use App\Http\Resources\Account as AccountResource;
   
class AccountController extends BaseController
{

    /**
     * Get all users
     */
    public function index()
    {
        $accounts = Account::all();
        return $this->sendResponse(AccountResource::collection($accounts), 'Posts fetched.');
    }

    /**
     * Store user
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'first_name' => 'required',
            'last_name' => 'required',
            'birthdate' => 'required',
            'gender' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role' => 'required',
            'unit_name' => 'nullable',
            'city' => 'nullable',
            'zip_code' => 'nullable',
            'province' => 'nullable',
        
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }
        $account = Account::create($input);
        return $this->sendResponse(new AccountResource($account), 'Post created.');
    }

   /**
    * Get user id
    * And view its details
    */
    public function show($id)
    {
        $account = Account::find($id);
        if (is_null($account)) {
            return $this->sendError('Post does not exist.');
        }
        return $this->sendResponse(new AccountResource($account), 'Post fetched.');
    }
    

    public function update(Request $request, Account $account)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'first_name' => 'required',
            'last_name' => 'required',
            'birthdate' => 'required',
            'gender' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role' => 'required',
            'unit_name' => 'nullable',
            'city' => 'nullable',
            'zip_code' => 'nullable',
            'province' => 'nullable',
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }

        $account->first_name = $input['first_name'];
        $account->last_name = $input['last_name'];
        $account->email = $input['email'];
        $account->password = $input['password'];
        $account->birthdate = $input['birthdate'];
        $account->phone = $input['phone'];
        $account->role = $input['role'];
        $account->unit_name = $input['unit_name'];
        $account->city = $input['city'];
        $account->zip_code = $input['zip_code'];
        $account->province = $input['province'];
        $account->save();
        
        return $this->sendResponse(new AccountResource($account), 'Post updated.');
    }
   
    public function destroy(Account $account)
    {
        $account->delete();
        return $this->sendResponse([], 'Post deleted.');
    }
}