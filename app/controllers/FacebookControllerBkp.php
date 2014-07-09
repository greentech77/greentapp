<?php

use Illuminate\Support\MessageBag;
// import the Intervention Image Class
use Intervention\Image\Image;

class FacebookController
extends Controller
{
    
    public function showPromotion()
    {

	$facebook = new Facebook(Config::get('facebook'));
        $uid = $facebook->getUser();
	
	$signed_request = $facebook->getSignedRequest();
	$pageId=$signed_request['page']['id'];
	
	$response = $facebook->api("/".$pageId);
		
	$link=$response['link'];
	$link = $link.'/app_1380859678822234';
	
	if ($uid == 0){
	     $params = array(
		 'redirect_uri' => url('/login/fb/callback'),
		 'scope' => 'email',
	     );
	     $loginUrl = $facebook->getLoginUrl($params);
	     ?>
	     
	    <script>
		//top.location.href="<?php echo $loginUrl; ?>";
	    </script>
	    <?php
	    /*ob_start();  
	    //return Redirect::to($facebook->getLoginUrl($params));
	    //header('Location: '.$facebook->getLoginUrl($params));
	    ob_end_flush();*/
	     /*$loginUrl = $facebook->getLoginUrl($params);
	     print_r($loginUrl);
	     die;*/
	     
	     return View::make('facebook.index') ->with('facebook_login', $loginUrl);
	     
	 }
	 else{
	     
	     //$me = $facebook->api('/me');
	     
	    $signed_request = $facebook->getSignedRequest();
	    
	    $pageId=$signed_request['page']['id'];

	    $liked=$signed_request['page']['liked'];
	        
	    $currentDate = date('Y-m-d H:m:s');
	     
	    $promotion = DB::table('promotions')
		    ->select('promotions.id as pid', 'questions.id', 'question', 'color', 'background', 'button', 'correct_anwsers.id_anwser')
                    ->leftJoin('questions', 'promotions.id', '=', 'questions.id_promotion')
		    ->leftJoin('images', 'promotions.id', '=', 'images.id_promotion')
		    ->leftJoin('correct_anwsers', 'correct_anwsers.id_question', '=', 'questions.id')
                    //->where('promotions.uid_user', '=', $uid)
		    ->where('start_date', '<=', $currentDate)
		    ->where('end_date', '<>', $currentDate)
		    ->get();
		    
	    /*$queries = DB::getQueryLog();
	    $last_query = end($queries);*/
	    
	    $question_id=$promotion[0]->id;
	    $promotionId=$promotion[0]->pid;
	    $anwserid=$promotion[0]->id_anwser;
	    
	    Cookie::make('correct_anwser_id_cookie', $anwserid);
	    Cookie::make('promotion_id_cookie', $promotionId);
	    
	    $anwsers = DB::table('anwsers')
		    -> select ('id', 'anwser')
		    -> where ('id_question','=', $question_id)
		    -> get();
	
	    if (!$liked){
	    
		return View::make('facebook.index', array('promotion' => $promotion[0], 'anwsers' => $anwsers, 'notliked' => 1));
	    }
	    else{
		/* make the API call */
		$response = $facebook->api("/".$pageId);
		
		$link=$response['link'];
		$link = $link.'/app_1380859678822234';
		return View::make('facebook.index', array('promotion' => $promotion[0], 'anwsers' => $anwsers, 'link' => $link));
	    } 
	}
    }
    
    public function checkAnwsers()
    {
	$link=$_REQUEST['link'];

	$correctId= Input::get('anwser'); //id of selected correct anwser
	$correct_anwser_id_cookie = Cookie::get('correct_anwser_id_cookie'); //get correct anwser id from cookie
	$promotion_id_cookie = Cookie::get('promotion_id_cookie'); //get correct anwser id from cookie

	$currentTime = date('Y-m-d H:m:s');
	$promotion = DB::table('promotions')
		    ->select('promotions.id','color', 'background', 'button','correct_anwsers.id_anwser')
                    ->leftJoin('questions', 'promotions.id', '=', 'questions.id_promotion')
		    ->leftJoin('images', 'promotions.id', '=', 'images.id_promotion')
		    ->leftJoin('correct_anwsers', 'correct_anwsers.id_question', '=', 'questions.id')
                    //->where('promotions.uid_user', '=', $uid)
		    ->where('start_date', '<=', $currentTime)
		    ->where('end_date', '<>', $currentTime)
		    ->get();
		    
	$promotionId=$promotion[0]->id;
	$anwserid=$promotion[0]->id_anwser;
	
    
	//èe je odgovor pravilen
	if ($correctId==$anwserid){
	    
	    $facebook = new Facebook(Config::get('facebook'));
	    $uid = $facebook->getUser();
	    
	    $ip=$_SERVER['REMOTE_ADDR'];
	    
	    //Facebook Authentication part
	    $user       = $facebook->getUser();
	    $userInfo   = $facebook->api("/$user");
	    
	  
	    $firstName  =$userInfo['first_name'];
	    $lastName = $userInfo['last_name'];
	    $email = $userInfo['email'];
	    $gender = $userInfo['gender'];
	    
	    //shrani podatke o uporabniku v bazo podatkov
	    $users_votes = new UsersVotes;
	    
	    $users_votes->id_user=$uid;
	    $users_votes->id_promotion=$promotionId;
	    $users_votes->email=$email;
	    $users_votes->name=$firstName.' '.$lastName;
	    $users_votes->firstname=$firstName;
	    $users_votes->lastname=$lastName;
	    $users_votes->gender=$gender;
	    $users_votes->ip=$ip;
	    $users_votes->votetime=$currentTime;

	    $users_votes->save();
	    
	    
	}
	
	return View::make('facebook.anwser', array('promotion' => $promotion[0], 'correctId' => $correctId, 'link' => $link));
    }
    
    public function FacebookLogin()
    {
	$facebook = new Facebook(Config::get('facebook'));
        $params = array(
            'redirect_uri' => url('/login/facebook/callback'),
            'scope' => 'email',
        );
        return Redirect::to($facebook->getLoginUrl($params));
    }
    
    public function FbLoginCallback()
    {
	    $code = Input::get('code');
	    
	    if (strlen($code) == 0) return Redirect::to('/')->with('message', 'There was an error communicating with Facebook');
	 
	    $facebook = new Facebook(Config::get('facebook'));
	    $uid = $facebook->getUser();
	    
	    print_r ($link);
	    die;
	    
	    $signed_request = $facebook->getSignedRequest();
	    
	    if ($uid == 0) return Redirect::to('/')->with('message', 'There was an error');
	 
	    $me = $facebook->api('/me');

	    $user = User::where('uid', '=', $uid)->first();
    
	    if (empty($user)) {
	 
		$user = new User;
		$user->username = Input::get('username');
		$user->uid = $uid;
		$user->name = $me['first_name'].' '.$me['last_name'];
		$user->email = $me['email'];
		$user->photo = 'https://graph.facebook.com/'.$me['username'].'/picture?type=large';
	 
		$user->save();
		
	    }

	    Auth::login($user);
	 
	    //return Redirect::to('/admin/promotions')->with('message', 'Logged in with Facebook');
	    return Redirect::to('https://www.facebook.com/interactive.test.page/app_1380859678822234');
    }
    
    public function FacebookLoginCallback()
    {
	    $name = Input::get('name');
	    $username = Input::get('username');
	    $password = Input::get('password');
	
	    $code = Input::get('code');
	    
	    if (strlen($code) == 0) return Redirect::to('/')->with('message', 'There was an error communicating with Facebook');
	 
	    $facebook = new Facebook(Config::get('facebook'));
	    $uid = $facebook->getUser();
	    
	    if ($uid == 0) return Redirect::to('/')->with('message', 'There was an error');
	 
	    $me = $facebook->api('/me');

	    $user = User::where('uid', '=', $uid)->first();
    
	    if (empty($user)) {
	 
		$user = new User;
		$user->username = Input::get('username');
		$user->uid = $uid;
		$user->name = $me['first_name'].' '.$me['last_name'];
		$user->email = $me['email'];
		$user->photo = 'https://graph.facebook.com/'.$me['username'].'/picture?type=large';
	 
		$user->save();
		
	    }

	    Auth::login($user);
	 
	    return Redirect::to('/admin/promotions')->with('message', 'Logged in with Facebook');
    }
}