<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bookmark;

class BookmarksController extends Controller
{
    
    public function listBookmarks()
    { 
    	$user = auth()->user();

    	$bookmarked_companies = $user->bookmarks->where('bookmark_type', 'App\Company');
    	
    	$bookmarked_projects = $user->bookmarks->where('bookmark_type', 'App\Project');



        return view('front.users.bookmarks', compact('bookmarked_companies', 'bookmarked_projects'));
    }

    public function addBookmark(Bookmark $bookmark, Request $request)
    { 

    	$bookmark->firstOrCreate(['user_id' => auth()->id()], ['bookmarked_id' => $request['bookmarked_id']], ['bookmark_type' => $request['bookmark_type']]);

    	$bookmark->user_id = auth()->id();
    	$bookmark->bookmarked_id = $request['bookmarked_id'];
    	$bookmark->bookmark_type = $request['bookmark_type'];

    	$bookmark->save();

    	return back();

    }

}
