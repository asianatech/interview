<?php
/**
 * User: faiz
 * Date: 4/26/16
 * Time: 4:20 PM
 */

namespace Asianatech\Http\Controllers;

use Asianatech\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * @var Blog
     */
    protected $blogModel;

    /**
     * BlogController constructor.
     *
     * @param Blog $blog
     */
    public function __construct(Blog $blog)
    {
        $this->blogModel = $blog;
    }

    public function create(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'author_id' => 'required|numeric',
            'title' => 'required',
            'content' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages()->getMessages());
        }

        $create = $this->blogModel->create($request->all());

        if ($create) {
            return response()->json([
                'status' => true,
                'user_id' => $create->id,
                'message' => 'Successfully Create New Blog',
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Failed To Create New Blog',
        ]);
    }

    /**
     * Update User
     *
     * @param Request $request
     */
    public function update(Request $request, $blogID)
    {
        $inputs = $request->all();

        $validator = \Validator::make($inputs, [
            'author_id' => 'required|numeric',
            'title' => 'required',
            'content' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages()->getMessages());
        }

        $update = $this->blogModel->where('id', $blogID)->update($inputs);

        if ($update) {
            return response()->json([
                'status' => true,
                'blog_id' => $blogID,
                'message' => 'Successfully Update Blog Post',
            ]);
        }

        return response()->json([
            'status' => false,
            'blog_id' => $blogID,
            'message' => 'Failed To Update Blog Post',
        ]);
    }

    /**
     * Delete User
     *
     * @param $blogID
     * @return
     */
    public function destroy($blogID)
    {
        $delete = $this->blogModel->destroy($blogID);

        if ($delete) {
            return response()->json([
                'status' => true,
                'blog_id' => $blogID,
                'message' => 'Successfully Delete Blog Post',
            ]);
        }

        return response()->json([
            'status' => false,
            'blog_id' => $blogID,
            'message' => 'Failed To Delete Blog Post',
        ]);
    }

}