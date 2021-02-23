<?php

namespace App\Http\Controllers;

use App\User;
use App\Tag;
use App\Category;
use App\Role;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function test(Request $request)
    {
        //return response()->json([
        //    'msg' => 'hello, test is ok....'
        //]);

        return 'it is ok!';
    }

    public function index(Request $request)
    {

        // first check if you are loggedin and admin user ...
        //return Auth::check();

        if (!Auth::check() && $request->path() != 'login') {
            return redirect('/login');
        }

        if (!Auth::check() && $request->path() == 'login') {

            return view('welcome');
        }
        // you are already logged in... so check for if you are an admin user..
        $user = Auth::user();
        if ($user->userType == 'User') {
            return redirect('/login');
        }
        if ($request->path() == 'login') {
            return redirect('/');
        }

        return $this->checkForPermission($user, $request);
    }

    public function checkForPermission($user, $request)
    {
        $permission = json_decode($user->role->permission);
        $hasPermission = false;
        if (!$permission) {
            return view('welcome');
        }

        foreach ($permission as $p) {
            if ($p->name == $request->path()) {
                if ($p->read) {
                    $hasPermission = true;
                }
            }
        }
        if ($hasPermission) {
            return view('welcome');
        }

        return view('welcome');
        //return view('notfound');
    }

    public function addTag(Request $request)
    {
        // validate request
        $this->validate($request, [
            'tagName' => 'required',
        ]);
        return Tag::create([
            'tagName' => $request->tagName,
        ]);
    }

    public function editTag(Request $request)
    {
        // validate request
        $this->validate($request, [
            'tagName' => 'required',
            'id' => 'required',
        ]);
        return Tag::where('id', $request->id)->update([
            'tagName' => $request->tagName,
        ]);
    }

    public function deleteTag(Request $request)
    {
        // validate request
        $this->validate($request, [
            'id' => 'required',
        ]);
        return Tag::where('id', $request->id)->delete();
    }

    public function getTag()
    {
        return Tag::orderBy('id', 'desc')->get();
    }


    public function imgurOKupload(Request $request)
    {
        $validatedData = $request->validate([
            //'title' => 'required',
            'file' => 'required'
        ]);

        //$title = $request->get('title');
        $file = $request->file('file');
        //$file = $request->file;

        $path = public_path();
        $file_path = $path . '/upload/' . $file->getClientOriginalName();

        $file->move($path . '/upload', $file->getClientOriginalName());

        $client_id = 'e6088d4d7383c59';
        $client = new \GuzzleHttp\Client();

        $gResponse = $client->request('POST', 'https://api.imgur.com/3/image', [
            'headers' => [
                'authorization' => 'Client-ID ' . $client_id,
                'content-type' => 'application/x-www-form-urlencoded',
            ],
            'form_params' => [
                'title' => '== welcome ==',
                'description' => 'laravel application upload image into imgur',
                'image' => base64_encode(file_get_contents($file_path))
            ],
        ]);

        $data = json_decode($gResponse->getBody()->getContents());
        //$imgur_Link = $data;
        //dd($data->data->link);

        // Then we send our data to the view
        //return view('welcome')
        //    ->with('imgur_link', $imgur_Link);

        return view('welcome')->with('data', $data->data->link);
        //    ->with('imgur_link', $imgur_Link);

        //return response()->json([
        //    //'success' => 'You have successfully uploaded "' . $file_name . '"',
        //    //'success' => 'You have successfully uploaded "' . $fileNameToStore . '"',
        //   'imgurLink' => $imgurLink,
        //]);

        //return back();
    }

    public function upload(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:jpeg,jpg,png',
        ]);

        //$file = $request->file('file');
        $file = $request->file;

        $path = public_path();

        $file->move($path . '/upload', $file->getClientOriginalName());

        $file_path = $path . '/upload/' . $file->getClientOriginalName();
        $client_id = 'e6088d4d7383c59';
        $client = new \GuzzleHttp\Client();
        $gResponse = $client->request('POST', 'https://api.imgur.com/3/image', [
            'headers' => [
                'authorization' => 'Client-ID ' . $client_id,
                'content-type' => 'application/x-www-form-urlencoded',
            ],
            'form_params' => [
                'title' => '== welcome ==',
                'description' => 'laravel application upload image into imgur',
                'image' => base64_encode(file_get_contents($file_path))
            ],
        ]);
        $data = json_decode($gResponse->getBody()->getContents());

        $request->session()->put('imageFile', $file->getClientOriginalName());
        //$request->session()->put('imgurURL', $data->data->link);
        //dd($data->data->link);
        return $data->data->link;

        //return response()->json([
        //    'imageFile' => $file->getClientOriginalName(),
        //    'imgurURL' => $data->data->link,
        //]);        
    }

    // upload image from editor.js
    public function uploadEditorImage(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|mimes:jpeg,jpg,png',
        ]);
        $picName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('upload'), $picName);
        return response()->json([
            'success' => 1,
            'file' => [
                'url' => "http://fullstack.localhost/upload/$picName",
            ],
        ]);
        return $picName;
    }

    public function deleteImage(Request $request)
    {
        //$fileName = $request->imageName;
        $fileName = $request->session()->get('imageFile');
        $this->deleteFileFromServer($fileName, false);
        $returnString = '"' . $fileName . '" is delete... ';
        return $returnString;
        //return 'done';
    }

    public function addCategory(Request $request)
    {
        // validate request
        $this->validate($request, [
            'categoryName' => 'required',
            'iconImage' => 'required',
        ]);
        return Category::create([
            'categoryName' => $request->categoryName,
            'iconImage' => $request->iconImage,
        ]);
    }

    public function getCategory()
    {
        return Category::orderBy('id', 'desc')->get();
    }

    public function editCategory(Request $request)
    {
        // validate request
        $this->validate($request, [
            'categoryName' => 'required',
            'iconImage' => 'required',
        ]);
        return Category::where('id', $request->id)->update([
            'categoryName' => $request->categoryName,
            'iconImage' => $request->iconImage,
        ]);
    }

    public function deleteCategory(Request $request)
    {
        // first delete the original file from the server
        ////$this->deleteFileFromServer($request->iconImage);
        // validate request
        $this->validate($request, [
            'id' => 'required',
        ]);
        return Category::where('id', $request->id)->delete();
    }

    //public function deleteFileFromServer($fileName, $hasFullPath = false)
    //{
    //    if (!$hasFullPath) {
    //        $filePath = public_path() . '/upload/' . $fileName;
    //    }
    //    if (file_exists($filePath)) {
    //        @unlink($filePath);
    //    }
    //
    //    return;
    //}

    public function getRoles()
    {
        return Role::all();
    }

    public function assignRole(Request $request)
    {
        $this->validate($request, [
            'permission' => 'required',
            'id' => 'required',
        ]);
        return Role::where('id', $request->id)->update([
            'permission' => $request->permission,
        ]);
    }

    public function createUser(Request $request)
    {
        // validate request
        $this->validate($request, [
            'fullName' => 'required',
            'email' => 'bail|required|email|unique:users',  //email必須在users table是唯一的
            'password' => 'bail|required|min:8|max:30',     //assign the bail rule => if the min rule , the max rule will not be checked. 
            'role_id' => 'required',
        ]);

        $password = bcrypt($request->password);

        //$currentRole = Role::where('id', $request->role_id)->first();

        $user = User::create([
            'name' => $request->fullName,
            'email' => $request->email,
            'password' => $password,
            //'userType' => $currentRole->name,
        ]);

        //$currentRole = Role::where('id', $request->role_id)->first();
        $user->roles()->sync([$request->role_id]);

        return $user;
    }

    public function editUser(Request $request)
    {
        // validate request
        $this->validate($request, [
            'fullName' => 'required',
            'email' => "bail|required|email|unique:users,email,$request->id", //email may changed, but nedd unique
            'password' => 'bail|required|min:8|max:30',
            'role_id' => 'required',
        ]);

        $data = [
            'name' => $request->fullName,
            'email' => $request->email,
            //'userType' => $request->userType,
        ];

        if ($request->password) {
            $password = bcrypt($request->password);
            $data['password'] = $password;
        }

        $user = User::where('id', $request->id)->update($data);

        $userUpdate = User::where('id', $request->id)->first();

        $userUpdate->roles()->detach();

        $userUpdate->roles()->sync([$request->role_id]);

        return $userUpdate;
    }

    public function getUsers()
    {
        //return User::get();
        //return User::where('userType', '==', 'Administrator')->get();
        return User::with('roles')->get();
    }
}
