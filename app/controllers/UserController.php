<?php

use Illuminate\Support\MessageBag;

class UserController
extends Controller
{
    public function userRegister()
    {
	return View::make('user.register');
	     
    }
    
    public function registerAction()
    {
	//LOGIKA ZA REGISTRACIJO NOVEGA UPORABNIKA IN POVEZAVA Z FACEBOOK-OM
	
	
	$name = Input::get('name');
	$username = Input::get('username');
	$password = Input::get('password');
	$email= Input::get('email');
	
	$password=Hash::make($password);
	
	$data = array(
		'name' => $name,
		'username' => $username,
		'password' => $password,
		'email' => $email,
	);
	
	$rules = array(
		'name' => 'required',
		'username' => 'required',
		'password' => 'required',
		'email' => 'required|email',
	);
	
	//validator
	$validator = Validator::make($data, $rules);

	if( $validator->passes()) {
	
	    $user = new User;
	    $user->username = $username;
	    $user->name = $name;
	    $user->email = $email;
	    $user->password = $password;
	    
	    $user->save();
	    
	    return Redirect::route("user/login");
	}
	else{
	    $messages = $validator->messages();
	    return Redirect::route("user/register")->withErrors($messages);
	}
	
	/*$facebook = new Facebook(Config::get('facebook'));
        $params = array(
            'redirect_uri' => url('/register/fb/callback'),
            'scope' => 'email',
        );
        return Redirect::to($facebook->getLoginUrl($params));*/
	
	
     
    }
    
    public function loginAction()
    {
        $errors = new MessageBag();

        if ($old = Input::old("errors"))
        {
            $errors = $old;
        }

        $data = [
            "errors" => $errors
        ];

        if (Input::server("REQUEST_METHOD") == "POST")
        {
            $validator = Validator::make(Input::all(), [
                "username" => "required",
                "password" => "required"
            ]);

            if ($validator->passes())
            {
                $credentials = [
                    "username" => Input::get("username"),
                    "password" => Input::get("password")
                ];

                if (Auth::attempt($credentials))
                {
		    return Redirect::route("admin/promotions");
                }
            }
            
            $data["errors"] = new MessageBag([
                "password" => [
                    "Napačno uporabniško ime ali geslo."
                ]
            ]);

            $data["username"] = Input::get("username");

            return Redirect::route("user/login")
                ->withInput($data);
        }

        return View::make("user/login", $data);
    }

    public function requestAction()
    {
        $data = [
            "requested" => Input::old("requested")
        ];

        if (Input::server("REQUEST_METHOD") == "POST")
        {
            $validator = Validator::make(Input::all(), [
                "email" => "required"
            ]);

            if ($validator->passes())
            {
                $credentials = [
                    "email" => Input::get("email")
                ];

                Password::remind($credentials,
                    function($message, $user)
                    {
                        $message->from("chris@example.com");
                    }
                );

                $data["requested"] = true;

                return Redirect::route("user/request")
                    ->withInput($data);
            }
        }

        return View::make("user/request", $data);
    }

    public function resetAction()
    {
        $token = "?token=" . Input::get("token");

        $errors = new MessageBag();

        if ($old = Input::old("errors"))
        {
            $errors = $old;
        }

        $data = [
            "token"  => $token,
            "errors" => $errors
        ];

        if (Input::server("REQUEST_METHOD") == "POST")
        {
            $validator = Validator::make(Input::all(), [
                "email"                 => "required|email",
                "password"              => "required|min:6",
                "password_confirmation" => "required|same:password",
                "token"                 => "required|exists:token,token"
            ]);

            if ($validator->passes())
            {
                $credentials = [
                    "email" => Input::get("email")
                ];

                Password::reset($credentials,
                    function($user, $password)
                    {
                        $user->password = Hash::make($password);
                        $user->save();

                        Auth::login($user);        

                        return Redirect::route("user/profile");
                    }
                );
            }

            $data["email"]  = Input::get("email");
            $data["errors"] = $validator->errors();

            return Redirect::to(URL::route("user/reset") . $token)
                ->withInput($data);
        }

        return View::make("user/reset", $data);
    }

    public function profileAction()
    {
        return View::make("user/profile");
    }

    public function logoutAction()
    {
        Auth::logout();
        return Redirect::route("user/login");
    }
}