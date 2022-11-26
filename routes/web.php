<?php

use Illuminate\Support\Facades\Route;
use App\Models\Post;
use App\Models\User;
use App\Models\Address;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get("/createpost" , function(){
   $post = new Post;
   $post->title = "2st post";
   $post->desc = "2st desc";
   $post->save();
   return "Saved";
});

Route::get("showpost" , function(){
//   $post = Post::orderBy("id" ,"desc")->get();
  $post = Post::where("id" ,1)->firstOrFail();
  return $post;
});


Route::get("update" , function(){
    $post = Post::where("id" , 1)->update([
        "title" => "updated title",
        "desc" => "updated desc"
    ]);
    return $post;
});


Route::get("createpsss" , function(){
    Post::create(["title" => "title created" , "desc" => "desc creaated"]);

});
Route::get("softdelete" , function(){
   Post::find(2)->delete();
});
Route::get("getall" , function(){
    $posts = Post::withTrashed()->get();
    return $posts;
 });

 Route::get("restore" , function(){
    Post::withTrashed()->where("id" , 2)->restore();
 });

 Route::get("user/{id}/post" , function($id){

    $post = User::findOrFail($id)->post;

     return $post;

 });

 Route::get("post/{id}/user" , function($id){
    $user = Post::findOrFail($id)->user;
    return $user;
 });

Route::get("manytomanypivot" ,function(){
  $user = User::findOrFail(1);
  foreach($user->roles as $role){
     echo $role->pivot->created_at;
  }
});
Route::get("user/{id}/posts" , function($id){
    $user = User::findOrFail($id);
    // dd($user->posts);
    foreach($user->posts as $post){
        echo $post->title . "<br>";
    }
    //    foreach($user->posts as $post){
    //       echo $post->title ."<br>";
    //     }
});
// crud for one to one relationship
Route::get("insert_one_to_one" , function(){
        $user = User::find(1);
        $address = new Address(["address"=>"giza , dokki 1"]);
        $user->address()->save($address);
        return true;
});

Route::get("update_one_to_one" , function(){
        $address = Address::whereUserId(1)->first(); //it will retrun an object
        $address->address = "updated location ";
        $address->save();
         return true;
});

Route::get("read_one_to_one" , function(){
        $user = User::find(1);
        return $user->address->address;//dokki
});

Route::get("delete_one_to_one" , function(){
        $user = User::find(1);
        $user->address()->delete();
        return true;
});

// one to many relationship crud operation
/*
this relation will refer to user has many posts
and the post will be belongs to specific user.

*/

Route::get("insert_one_to_many" , function(){
    $user = User::find(1);
     $post = new Post([
        "title" => "title relation2",
        "desc" =>"desc with many to many relation2"
     ]);
       $user->posts()->save($post);
     return true;
 });

 Route::get("read_one_to_many" , function(){
    $user = User::find(1);
    dd($user->posts);//return collection of objects
});


Route::get("update_one_to_many" , function(){
      $user = User::find(1);
      $user->posts()->whereId(1)->update([
        "title" => "updated laravel"
    ]);
      return "done";
 });

 Route::get("delete_one_to_many" , function(){
    $user = User::find(1);
    $user->posts()->whereUserId(1)->delete(); //it will be soft deleted cuz we enable soft delete in model
    return "deleted";
});

// Dealing with dates
Route::get("dates" , function(){
    $date = new \DateTime();
    echo $date->format('m-d-Y') .'<hr>';
    echo Carbon::now();

  });


//   accessors and muators
Route::get("getname" , function(){
    $user =   User::find(1);
    echo $user->name;
 });

 Route::get("queryscope" , function(){
    $roles = Role::GetAll();
    dd($roles);
 });



//Deal with sessions
 Route::get("session" , function(Request $request){
    //put value in session
    // $request->session()->put(["gehad" =>true , "hatem" => false]);
    //get value from session
    // return $request->session()->all();
    // flashing
    return $request->session()->flash();
 });
