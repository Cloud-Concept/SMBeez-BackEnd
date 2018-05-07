<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Interest;

class Project extends Model
{
    protected $dates = ['close_date'];
    protected $fillable = ['relevance_score'];

    use Sluggable;
    /**
    * Return the sluggable configuration array for this model.
    *
    * @return array
    */
    public function sluggable() {
        return [
            'slug' => [
                'source' => 'project_title'
            ]
        ];
    }

    public function industries() {
        return $this->belongsToMany(Industry::class);
    }

    public function specialities() {
        return $this->belongsToMany(Speciality::class);
    }
    //user relationship
    public function user() {
    	return $this->belongsTo(User::class);
    }
    //files relationship
    public function files() {
        return $this->hasMany(MyFile::class);
    }
    //interests relationship
    public function interests() {
        return $this->hasMany(Interest::class);
    }
    //check if user has interest to this project
    public function has_interest()
    {
        $hasInterest = Interest::where('user_id', auth()->id())->where('project_id', $this->id)->first();

        if($hasInterest) {
            return true;
        }else {
            return false;
        }

    }

    //get the id of interest to withdraw for that user
    public function withdraw_interest()
    {
        $withdraw = Interest::where('user_id', auth()->id())->where('project_id', $this->id)->first();

        return $withdraw->id;

    }

    //check if interest of user accepted
    public function interest_status()
    {
        $interest = Interest::where('user_id', auth()->id())->where('project_id', $this->id)->first();

        return $interest->is_accepted;

    }

    //check if the user is the owner of this project
    public function is_owner($user) {
        return $this->user_id === auth()->id();
    }

    public function bookmarked($project_id) {
        $bookmarked = Bookmark::exist($project_id, 'App\Project');

        if($bookmarked) {
            return true;
        }else {
            return false;
        }
    }

    public function bookmark($bookmarked_id)
    {
        return Bookmark::where('user_id', auth()->id())
        ->where('bookmarked_id', $bookmarked_id)
        ->where('bookmark_type', 'App\Project')
        ->pluck('id')
        ->first();
    }

    public static function addRelevanceScore($score, $project_id) {
        $project = Project::where('id', $project_id);
        $current = $project->pluck('relevance_score')->first();
        return $project->update(array('relevance_score' => $current + $score));
    }

    //use slug to get project
    public function getRouteKeyName() {
        return 'slug';
    }
}
