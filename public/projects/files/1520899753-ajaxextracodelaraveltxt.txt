<meta name="csrf-token" content="{{ csrf_token() }}" />
------------------------------------------------------------------------------------
<input type="hidden" name="_token" value="{{ csrf_token() }}">
------------------------------------------------------------------------------------
$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        }
});

------------------------------------------------------------------------------------

     /**
     * Determine if the session and input CSRF tokens match.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    protected function tokensMatch($request)
    {
        // If request is an ajax request, then check to see if token matches token provider in
        // the header. This way, we can use CSRF protection in ajax requests also.
        $token = $request->ajax() ? $request->header('X-CSRF-Token') : $request->input('_token');

        return $request->session()->token() == $token;
    }
------------------------------------------------------------------------------------