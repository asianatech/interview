<?php
/**
 * User: faiz
 * Date: 4/26/16
 * Time: 3:53 PM
 */

namespace Asianatech\Http\Controllers;

use Asianatech\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @var User
     */
    protected $userModel;

    /**
     * UserController constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->userModel = $user;
    }

    /**
     * Update User
     * 
     * @param Request $request
     */
    public function update(Request $request, $userID)
    {
        $inputs = $request->all();

        $validator = \Validator::make($inputs, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|min:6',
        ]);

        $inputs['password'] = bcrypt($inputs['password']);

        if ($validator->fails()) {
            return response()->json($validator->messages()->getMessages());
        }

        $update = $this->userModel->where('id', $userID)->update($inputs);

        if ($update) {
            return response()->json([
                'status' => true,
                'user_id' => $userID,
                'message' => 'Successfully Update User',
            ]);
        }

        return response()->json([
            'status' => false,
            'user_id' => $userID,
            'message' => 'Failed To Update User',
        ]);
    }

    /**
     * Delete User
     *
     * @param $userID
     * @return
     */
    public function destroy($userID)
    {
        $delete = $this->userModel->destroy($userID);

        if ($delete) {
            return response()->json([
                'status' => true,
                'user_id' => $userID,
                'message' => 'Successfully Delete User',
            ]);
        }

        return response()->json([
            'status' => false,
            'user_id' => $userID,
            'message' => 'Failed To Delete User',
        ]);
    }
    
}