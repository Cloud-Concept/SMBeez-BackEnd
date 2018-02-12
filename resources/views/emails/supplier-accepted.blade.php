<p>
Hello!

Congratulations - you have been accepted for opportunity “{{$interest->project->project_title}}”. This doesn’t yet mean you have been awarded the contract; it means you have been approved to contact the client for further discussions. 

What next?

Don’t wait! Reach out directly to <a href="{{route('front.company.show', $interest->project->user->company->slug)}}">{{$interest->project->user->company->company_name}}</a>! Click <a href="{{route('front.company.show', $interest->project->user->company->slug)}}">here</a> to get access to their profile and contact details. 

Hurry! They are waiting for you!

Your friends at SMBeez 

</p>