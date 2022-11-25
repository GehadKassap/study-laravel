<?php

use Illuminate\Support\Facades\Route;
use App\Models\Post;
use App\Models\User;
use App\Models\Address;

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
