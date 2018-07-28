<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bookmark;
use App\User;
use Session;

class BookmarksController extends Controller
{
    
    public function listBookmarks()
    {   
        $locale = Session::get('locale');
        if($locale) {
            app()->setLocale($locale);
        }

    	$user = auth()->user();

    	$bookmarked_companies = $user->bookmarks->where('bookmark_type', 'App\Company')->take(4);
    	
    	$bookmarked_projects = $user->bookmarks->where('bookmark_type', 'App\Project')->take(4);



        return view('front.users.bookmarks', compact('bookmarked_companies', 'bookmarked_projects'));
    }

    public function companiesBookmarks()
    {   
        $locale = Session::get('locale');
        if($locale) {
            app()->setLocale($locale);
        }

        $user = auth()->user();

        $bookmarked_companies = $user->bookmarks->where('bookmark_type', 'App\Company');
        
        $bookmarked_projects = $user->bookmarks->where('bookmark_type', 'App\Project');



        return view('front.users.companies-bookmarks', compact('bookmarked_companies', 'bookmarked_projects'));
    }

    public function opportunitiesBookmarks()
    {   
        $locale = Session::get('locale');
        if($locale) {
            app()->setLocale($locale);
        }
        
        $user = auth()->user();

        $bookmarked_companies = $user->bookmarks->where('bookmark_type', 'App\Company');
        
        $bookmarked_projects = $user->bookmarks->where('bookmark_type', 'App\Project');



        return view('front.users.opportunities-bookmarks', compact('bookmarked_companies', 'bookmarked_projects'));
    }

    public function addBookmark(Bookmark $bookmark, Request $request)
    { 
        if (!$bookmark->exist($request['bookmarked_id'], $request['bookmark_type'])) {
            $bookmark->user_id = auth()->id();
            $bookmark->bookmarked_id = $request['bookmarked_id'];
            $bookmark->bookmark_type = $request['bookmark_type'];
            $bookmark->save();
            return json_encode($bookmark);
        }else {
            return response()->json(['success' => 'Already Bookmarked.']);
        }

    }

    public function removeBookmark(Bookmark $bookmark, Request $request)
    {   
        if ($bookmark->exist($request['bookmarked_id'], $request['bookmark_type'])) {
            $bookmark->user_id = auth()->id();
            $bookmark->bookmarked_id = $request['bookmarked_id'];
            $bookmark->bookmark_type = $request['bookmark_type'];
        }
        $check_bookmark = $bookmark->where('user_id', $bookmark->user_id)->where('bookmarked_id', $bookmark->bookmarked_id)->where('bookmark_type', $bookmark->bookmark_type)->first();

        if($check_bookmark) {
            $check_bookmark->delete();
        }
        
        return response()->json(['success' => 'Bookmark Deleted.']);
    }

}
