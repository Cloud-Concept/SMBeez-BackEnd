<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\User;
use App\Point;
use App\Setting;

class AddMonthlyPoints extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'addmonthlypoints';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add Monthly Points to All Users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //calculate the points used by user
        $users = User::where('logins_no', '>', 0)->get();
        $reduction_actions = Setting::where('category', 'points')->where('value', '<', 0)->get()->pluck('setting_slug')->toArray();
        $monthly_points = Setting::where('category', 'points')->where('setting_slug', 'monthly-points')->get()->pluck('value');
        $count = 0;
        foreach($users as $user) {
            if($user->company) { //if the user has company
                $day = new Carbon('first day of last month', 'Africa/Cairo');
                //how many points the user consumed during the month
                $user_points = Point::where('company_id', $user->company->id)->whereIn('action', $reduction_actions)
                ->where('created_at', '>=', $day)->sum('points');
                //if the user consumed less than the monthly points
                if($user_points < (int)$monthly_points[0]) {
                    //calculate the difference
                    $difference = (int)$monthly_points[0] - $user_points;
                    //calculate the amount of points to be added
                    $pointsToAdd = $difference;
                    //add points to the user
                    $user->company->increment('points', $pointsToAdd);
                    //log it
                    $point = new Point;
                    $point->points = $pointsToAdd;
                    $point->company_id = $user->company->id;
                    $point->action = 'monthly-points';
                    $point->limit_type = 'monthly';
                    $point->expiry_date = new Carbon('first day of next month', 'Africa/Cairo');
                    $point->save();

                }else{ //if the user consumed the last month points
                    //add all the monthly points
                    $user->company->increment('points', (int)$monthly_points[0]);
                    //log it
                    $point = new Point;
                    $point->points = $pointsToAdd;
                    $point->company_id = $user->company->id;
                    $point->action = 'monthly-points';
                    $point->limit_type = 'monthly';
                    $point->expiry_date = new Carbon('first day of next month', 'Africa/Cairo');
                    $point->save();
                }
            }
            $count++;
        }

        $this->info('Added Points to ' . $count . ' companies.');
    }
}
