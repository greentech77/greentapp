<?php

	$ip_adress=$_SERVER['REMOTE_ADDR'];
	

	$dbhost = 'localhost';
	$dbuser = 'greentec_diploma';
	$dbpass = 'gr33nt3ch';

	
	$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to mysql');
	
	$dbname = 'greentec_diploma';
	mysql_select_db($dbname);
	mysql_set_charset('UTF-8');
	
	//CLIENT INFORMATION
        $req_ids = htmlspecialchars(trim($_POST['req_ids']));
	
	$req_ids_array= explode(',',$req_ids);

	$num_invites=count($req_ids_array);
	
	//facebook application configuration -mahmud
	$fbconfig["appid"] = "1380859678822234";
	$fbconfig["secret"] = "5a8953f7785a24e7a6121f91af9fa400";

	//$fbconfig['fileUpload'] = false; // optional

   
    $uid            =   null; //facebook user uid
   
    
    $facebook = new Facebook(Config::get('facebook'));
    $uid = $facebook->getUser();
 
    $votetime=time();
 

     /*echo $user;
     die;*/
	
       //DODAJANJE ODGOVORA V BAZO
      $updateUserVote = "UPDATE users_votes SET num_invites = num_invites + $num_invites WHERE id_user =$uid";
      mysql_query($updateUserVote) or die(mysql_error());
      

?>