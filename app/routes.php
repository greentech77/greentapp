<?php

Route::group(["before" => "guest"], function()
{
    Route::any("/user/register", [
        "as"   => "user/register",
        "uses" => "UserController@userRegister"
    ]);
    
    Route::any("/user/register/submit", [
        "as"   => "user/register/submit",
        "uses" => "UserController@registerAction"
    ]);
    
    Route::any("/", [
        "as"   => "user/login",
        "uses" => "UserController@loginAction"
    ]);
    
});

Route::group(array('filter' => 'auth'), function()
{
    Route::any("/profile", [
        "as"   => "user/profile",
        "uses" => "UserController@profileAction"
    ]);

    Route::any("/logout", [
        "as"   => "user/logout",
        "uses" => "UserController@logoutAction"
    ]);
    
    Route::any("admin/promotions", [
        "as"   => "admin/promotions",
        "uses" => "PromotionController@getPromotions"
    ]);
    
    Route::any("admin/promotions/new", [
        "as"   => "admin/promotions/new",
        "uses" => "PromotionController@newPromotion"
    ]);
    
    Route::any("admin/promotions/add", [
        "as"   => "admin/promotions/add",
        "uses" => "PromotionController@addPromotion"
    ]);
    
    Route::any("admin/promotions/edit/{id}", [
        "as"   => "admin/promotions/edit/{id}",
        "uses" => "PromotionController@showPromotion"
    ]);
    
    Route::post("admin/promotions/update/{id}", [
        "as"   => "admin/promotions/update/{id}",
        "uses" => "PromotionController@updatePromotion"
    ]);
    
    Route::delete("admin/promotions/delete/{id}", [
        "as"   => "admin/promotions/delete/{id}",
        "uses" => "PromotionController@deletePromotion"
    ]);
    
    Route::post("admin/promotions/duplicate/{id}", [
        "as"   => "admin/promotions/duplicate/{id}",
        "uses" => "PromotionController@duplicatePromotion"
    ]);
    
    Route::any("admin/promotions/preview/{id}", [
        "as"   => "admin/promotions/preview/{id}",
        "uses" => "PromotionController@previewPromotion"
    ]);
    
    Route::any("admin/promotions/stats/{id}", [
        "as"   => "admin/promotions/stats/{id}",
        "uses" => "PromotionController@promotionStats"
    ]);
    
    Route::any("admin/promotions/drop/{id}", [
        "as"   => "admin/promotions/drop/{id}",
        "uses" => "PromotionController@deletePromotionData"
    ]);
    
    Route::any("facebook", [
        "as"   => "facebook",
        "uses" => "FacebookController@showPromotion"
    ]);
    
    Route::post("facebook/anwsers", [
        "as"   => "facebook/anwsers",
        "uses" => "FacebookController@checkAnwsers"
    ]);
    
    Route::get('admin/promotions/upload', 'ImageController@getUploadForm');
    Route::post('admin/promotions/upload/image','ImageController@postUpload');
  
});

Route::any('/login/fb',[

       "as"   => "login/fb",
       "uses" => "FacebookController@FacebookLogin"
   ]);
    
Route::any('/login/facebook/callback',[

    "as"   => "login/facebook/callback",
    "uses" => "FacebookController@FacebookLoginCallback"
]);

Route::any('/login/fb/callback/{pageId}',[

    "as"   => "login/fb/callback",
    "uses" => "FacebookController@FbLoginCallback"
]);

/*Route::get('facebook/login', function() {
        $facebook = new Facebook(Config::get('facebook'));
        $params = array(
            'redirect_uri' => url('facebook/login/feedback'),
            'scope' => 'email',
        );
        return Redirect::to($facebook->getLoginUrl($params));
        });
    
     Route::get('facebook/login/feedback', function() {
            $code = Input::get('code');
            if (strlen($code) == 0) return Redirect::to('/')->with('message', 'There was an error communicating with Facebook');
         
            $facebook = new Facebook(Config::get('facebook'));
            $uid = $facebook->getUser();
            
            if ($uid == 0){
                $params = array(
                    'redirect_uri' => url('facebook/login/feedback'),
                    'scope' => 'email',
                );
                $loginUrl = $facebook->getLoginUrl($params); 
                return View::make('facebook.index') ->with('facebook_login', $loginUrl);
                //return Redirect::to('/')->with('message', 'There was an error');
            }
            else{
                
                $me = $facebook->api('/me');
                //echo $uid;
                return Redirect::to('facebook/');
                //return View::make('facebook.index') ->with('userid', $uid);
            }
        });
    
    Route::any("facebook", [
        "as"   => "facebook",
        "uses" => "FacebookController@showPromotion"
    ]);
    
    
    Route::get('user/register/submit', function() {
        $facebook = new Facebook(Config::get('facebook'));
        $params = array(
            'redirect_uri' => url('user/register/submit/callback'),
            'scope' => 'email',
        );
        return Redirect::to($facebook->getLoginUrl($params));
    });
    
    Route::get('facebook/login/feedback', function() {
            $code = Input::get('code');
            if (strlen($code) == 0) return Redirect::to('/')->with('message', 'There was an error communicating with Facebook');
         
            $facebook = new Facebook(Config::get('facebook'));
            $uid = $facebook->getUser();
            
            if ($uid == 0){
                $params = array(
                    'redirect_uri' => url('user/register/submit/callback'),
                    'scope' => 'email',
                );
                $loginUrl = $facebook->getLoginUrl($params); 
                return View::make('facebook.index') ->with('facebook_login', $loginUrl);
                //return Redirect::to('/')->with('message', 'There was an error');
            }
            else{
                
                $me = $facebook->api('/me');
                //echo $uid;
                return Redirect::to('facebook/');
                //return View::make('facebook.index') ->with('userid', $uid);
            }
        });*/
    
    /*Route::get('facebook/login', function() {
        $facebook = new Facebook(Config::get('facebook'));
        $params = array(
            'redirect_uri' => url('facebook'),
            'scope' => 'email',
        );
         $uid = $facebook->getUser();

        if($uid)
        {
            $user_profile = $facebook->api('/me');
            var_dump($user_profile);
        }else{
            //print_r($facebook->getLoginUrl($params));
            //return Redirect::to($facebook->getLoginUrl($params));
            $loginUrl = $facebook->getLoginUrl($params);
            return View::make('facebook.index') ->with('facebook_login', $loginUrl);
        } 
        
    });*/
    