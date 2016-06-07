<div class="container">
    <div class="row">
        <div class="col-md-12 col-md-offset-1">
        <h1><b>{{ trans('pagination.nom') }}</b></h1>
        <hr />
        <br/>
        </div>
        <div class="col-md-12 col-md-offset-1">
        	{{ trans('auth.reset_password') }}
        	<br />
        	<a href="{{ $link = url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}">{{ trans('auth.reset_text') }}</a>
        </div>
        <br />
        <br />
        <a href="{{ $link = url('/about')}}">©LPS - 2016</a>
    </div>
</div>