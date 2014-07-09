<?php

	$ip_adress=$_SERVER['REMOTE_ADDR'];
	
	$dbhost = 'localhost';
	$dbuser = 'greentec_diploma';
	$dbpass = 'gr33nt3ch';

	
	$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to mysql');
	
	$dbname = 'greentec_diploma';
	mysql_select_db($dbname);
	mysql_set_charset('UTF-8');
	
	// CLIENT INFORMATION
        $num_shares = htmlspecialchars(trim($_POST['numshares']));

	//facebook application configuration -mahmud
	$fbconfig["appid"] = "1380859678822234";
	$fbconfig["secret"] = "5a8953f7785a24e7a6121f91af9fa400";
	
	//$fbconfig['fileUpload'] = false; // optional

    
    //
    if (isset($_GET['request_ids'])){
        //user comes from invitation
        //track them if you need
    }
   
    $uid            =   null; //facebook user uid
   
    
    $facebook = new Facebook(Config::get('facebook'));
    $uid = $facebook->getUser();
 
    $votetime=time();
	
	

       //DODAJANJE ODGOVORA V BAZO
      $addUserVote = "UPDATE users_votes SET num_shares = num_shares + $num_shares WHERE id_user =$uid";
      mysql_query($addUserVote) or die(mysql_error());
      

?>