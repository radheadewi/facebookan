<?php


Route::get('/', function()
    { 
        return redirect('/image');
    });

Route::resource('/image', 'ImageController'); 

Route::resource('/image/create', 'ImageController@create');

Route::resource('/image/store', 'ImageController@store');

Route::get('login/fb', function()
{
    //$facebook = new Facebook(Config::get('facebook'));
    $facebook = new Facebook(array(
  	'appId'  => '996232937088379',
  	'secret' => '4957afd99b5109533bf03beedfa772ee',
    ));
    
    $params = array(
        'redirect_uri' => url('/login/fb/callback'),
        'scope' => 'email',
    );
    //echo $facebook->getAppId();
    //echo $facebook->getLoginUrl($params);

    return Redirect::to($facebook->getLoginUrl($params));
});

Route::get('login/fb/callback', function()
{
    $code = Input::get('code');
    if (strlen($code) == 0) return Redirect::to('/')->with('message', 'There was an error communicating with Facebook');

    $facebook = new Facebook(Config::get('facebook'));
    $uid = $facebook->getUser();
    var_dump($uid);

    if ($uid == 0) return Redirect::to('/')->with('message', 'There was an error');

    $me = $facebook->api('/me');
    //dd($me);
    $profile = profile::whereUid($uid)->first();
    if (empty($profile)){
        $user = new User;
        $user->name = $me['first_name'].''.$me['last_name'];
        $user->email = $me['email'];
        $user->photo = 'https://graph.facebook.com/'.$me['username'].'/picture?type=large';
        $user->save();

        $profile = new Profile();
        $profile->uid= $uid;
        $profile->username = $me['username'];
        $profile = $user->profiles()->save($profile);
    }

    $profile->access_token = $facebook->getAccessToken();
    $profile->save();

    $user = $profile->user;
    Auth::login($user);

    return Redirect::to('/')->with('message', 'Logged in with Facebook');
});

Route::get('logout', function()
{
    Auth::logout();
    return Redirect::to('/');
});


/*Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);*/