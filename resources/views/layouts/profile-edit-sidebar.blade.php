<div class="sidebar-updates">
    <h5 class="title-blue">Settings</h5>
    <ul class="list-group">
        <li class="list-group-item"><a href="{{route('front.user.editprofile', $user->username)}}" class="{{ Request::is('user/profile/'.$user->username.'/edit') ? 'active' : 'no' }}">Basic Infomation</a></li>
        <li class="list-group-item"><a href="{{route('front.user.editlocation', $user->username)}}" class="{{ Request::is('user/profile/'.$user->username.'/edit_location') ? 'active' : 'no' }}">Location</a></li>
        <li class="list-group-item"><a href="{{route('front.user.reviews', $user->username)}}" class="{{ Request::is('user/profile/'.$user->username.'/reviews') ? 'active' : 'no' }}">Reviews</a></li>
        <!-- <li class="list-group-item"><a href="">Subscription</a></li>
        <li class="list-group-item"><a href="">Email Notifications</a></li>
        <li class="list-group-item"><a href="">Payment Method</a></li> -->
    </ul>
</div>