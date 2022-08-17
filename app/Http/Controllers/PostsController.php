<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PostsController extends Controller
{

    public function index($limit = 10, $status = null)
    {

        $status != 'null' || !$status ? $posts = Posts::where('status',$status)->orderBy('id','desc')->paginate($limit) : $posts = Posts::orderBy('id','desc')->paginate($limit);

        return response()->json([
            'posts' => $posts
        ]);
    }

    public function page($limit = 10, $offset = 0)
    {

        $posts = Posts::offset($offset)
                        ->limit($limit)
                        ->get();

        return response()->json([
            'posts' => $posts
        ]);
    }

    public function view($id)
    {

        $post = Posts::find($id);

        return response()->json($post);
    }

    public function store(Request $request)
    {

        if ($request->id) {
            $validator = Validator::make($request->all(), [
                'title' => 'required|min:20',
                'content' => 'required|min:200',
                'category' => 'required|min:3',
                'status' => ['required',Rule::in(['Publish','Draft','Trash'])],
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'title' => 'required|unique:posts|min:20',
                'content' => 'required|min:200',
                'category' => 'required|min:3',
                'status' => ['required',Rule::in(['Publish','Draft','Trash'])],
            ]);
        }
 
        if ($validator->fails()) {
            
            return response()->json([
                'message' => 'invalid',
                'data' => [],
                'errors' => $validator->errors()
            ], 400);

        }

        try {
            DB::beginTransaction();

            $post = array(
                'title' => $request->title,
                'content' => $request->content,
                'category' => $request->category,
                'status' => $request->status,
            );

            if ($request->id) {

                $query = Posts::find($request->id);

                $query->update($post);

            } else {

                Posts::create($post);

            }
            

            DB::commit();
        } catch (e) {
            DB::rollBack();
        }

        return response()->json([
            'message' => 'Input successfully.'
        ], 200);
        
    }

    public function count()
    {
        $getCount = Posts::select(DB::raw('status , count(id) as count_status'))->groupBy('status')->get();

        $count = [];

        foreach ($getCount as $key => $value ){
            
            array_push($count, [$value->status => $value->count_status]);
        }

        return response()->json($count);
    }

    public function destroy($posts)
    {
        
        try {
            
            DB::beginTransaction();

            $query = Posts::find($posts);
            
            $post = array(
                'status' => 'Trash'
            );

            $query->update($post);

            DB::commit(); 

            return response()->json([
                'message' => 'Delete Successfully',
                'post' => $post
            ]);

        } catch(e) {

            return response()->json([
                'message' => 'Delete Failed'
            ]);

            DB::rollBack();
        }


    }

    public function delete($posts)
    {
        
        try {
            
            DB::beginTransaction();

            $query = Posts::find($posts);
            
            $query->delete();

            DB::commit(); 

            return response()->json([
                'message' => 'Delete Successfully'
            ]);

        } catch(e) {

            return response()->json([
                'message' => 'Delete Failed'
            ]);

            DB::rollBack();
        }


    }
}
