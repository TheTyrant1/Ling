<?php

 namespace App\Http\Controllers\Personal\Search;

 use App\Http\Controllers\Controller;
 use Illuminate\Http\Request;

 class IndexController extends Controller
 {
     public function __invoke(Request $request)
     {
         $query = $request->input('query');
         $user = auth()->user();

         if (!$query) {
             return response()->json([
                 'following' => [],
                 'views' => [],
                 'likes' => [],
                 'saves' => [],
                 'comments' => [],
                 'posts' => [],
             ]);
         }

         $following = auth()->user()->followings()
             ->where('name', 'like', "%{$query}%")
             ->limit(5)
             ->get()
             ->map(fn($following) => [
                 'type' => 'user',
                 'title' => str($following->name)->limit(15),
                 'url' => route('user.show', $following->id),
                 'icon' => 'fa-solid fa-users',
                 'image' => $following->profile_image ? asset('storage/' . $following->profile_image) : asset('images/profile_images/user_9307950.png'),
             ]);

         $views = $user->viewedPosts()
             ->where('title', 'like', "%{$query}%")
             ->limit(5)
             ->get()
             ->map(fn($post) => [
                 'type' => 'post',
                 'title' => str($post->title)->limit(35),
                 'url' => route('personal.history.view.show', $post->id),
                 'icon' => 'fa-solid fa-eye',
                 'image' => $post->preview_image ? asset('storage/' . $post->preview_image) : null,
             ]);

         $likes = $user->likedPosts()
             ->where('title', 'like', "%{$query}%")
             ->limit(5)
             ->get()
             ->map(fn($post) => [
                 'type' => 'post',
                 'title' => str($post->title)->limit(35),
                 'url' => route('personal.history.like.show', $post->id),
                 'icon' => 'fa-solid fa-heart',
                 'image' => $post->preview_image ? asset('storage/' . $post->preview_image) : null,
             ]);

         $saves = $user->savedPosts()
             ->where('title', 'like', "%{$query}%")
             ->limit(5)
             ->get()
             ->map(fn($post) => [
                 'type' => 'post',
                 'title' => str($post->title)->limit(35),
                 'url' => route('personal.history.save.show', $post->id),
                 'icon' => 'fa-solid fa-bookmark',
                 'image' => $post->preview_image ? asset('storage/' . $post->preview_image) : null,
             ]);

         $comments = $user->comments()
             ->where('message', 'like', "%{$query}%")
             ->with('post')
             ->limit(5)
             ->get()
             ->map(fn($comment) => [
                 'type' => 'comment',
                 'title' => str($comment->message)->limit(25),
                 'subtitle' => 'In: ' . str($comment->post->title ?? 'Post')->limit(35),
                 'url' => route('personal.history.comment.show', $comment->id),
                 'icon' => 'fa-solid fa-comment',
             ]);

         $posts = $user->posts()
             ->where('title', 'like', "%{$query}%")
             ->limit(5)
             ->get()
             ->map(fn($post) => [
                 'type' => 'post',
                 'title' => str($post->title)->limit(35),
                 'url' => route('personal.history.post.show', $post->id),
                 'icon' => 'fa-solid fa-newspaper',
                 'image' => $post->preview_image ? asset('storage/' . $post->preview_image) : null,
             ]);

         $appeals = $user->appeals()
             ->where('user_message', 'like', "%{$query}%")
             ->limit(5)
             ->get()
             ->map(fn($appeal) => [
                 'type' => 'appeal',
                 'title' => str($appeal->user_message)->limit(25),
                 'url' => route('personal.history.appeal.show', $appeal->id),
                 'icon' => 'fa-solid fa-gavel',
             ]);



         return response()->json([
             'following' => $following,
             'views' => $views,
             'likes' => $likes,
             'saves' => $saves,
             'comments' => $comments,
             'posts' => $posts,
             'appeals' => $appeals
         ]);
     }
 }

