<?php

use Illuminate\Support\MessageBag;
// import the Intervention Image Class
use Intervention\Image\Image;

class PromotionController
extends Controller
{
    
    public function getPromotions()
    {
        $userId=Auth::user()->id;
	    
	$promotions = DB::table('promotions')
                    ->leftJoin('users_votes', 'promotions.id', '=', 'users_votes.id_promotion')
                    ->select('promotions.id', 'promotions.name', 'promotions.start_date', DB::raw('count(users_votes.id) as user_count'))
                    ->where('promotions.id_user', '=', $userId)
		    ->orderBy('promotions.id', 'asc')
		    ->groupBy('promotions.id')
                    ->get();


        return View::make("promotions.index")->with('promotions', $promotions);
    }
    
    public function promotionStats($id)
    {
	$stats = UsersVotes::where('id_promotion', '=', $id)->get();
        return View::make("stats.index")->with('stats', $stats);
    }
    
    public function newPromotion()
    {
	
	$anwsersID = DB::table('information_schema.tables')
                     ->select(DB::raw('min(Auto_increment) AS id '))
                     ->where('table_name','=','anwsers')
                     ->get();
	
	$maxId=$anwsersID[0]->id;
	
	$id1=$maxId+1;
	$id2=$maxId+2;
	$id3=$maxId+3;

	$anwsers = Anwsers::orderBy('created_at', 'desc')->limit(3)->get();

	return View::make('promotions.new',array('anwsers' => $anwsers, 'k' => 1, 'i' => 1, 'j' => 1, 'id1' => $id1, 'id2' => $id2, 'id3' => $id3));
    }
    
    public function showPromotion($id)
    {
	$promotion = DB::table('promotions')
		    ->select('promotions.id', 'name', 'description', 'start_date', 'end_date', 'question', 'color','correct_anwsers.id_anwser')
                    ->leftJoin('questions', 'promotions.id', '=', 'questions.id_promotion')
		    ->leftJoin('correct_anwsers', 'correct_anwsers.id_question', '=', 'questions.id')
                    ->where('promotions.id', '=', $id)
		    ->get();
		    
	$question = Questions::where('id_promotion', '=', $id)->firstOrFail();
	
	$questionId = $question->id;
	
	$anwsers = Anwsers::where('id_question', '=', $questionId)->get();

	$images = Images::where('id_promotion', '=', $id)->firstOrFail();
	
	$anwser1=$anwsers[0]['anwser'];
	$anwser2=$anwsers[1]['anwser'];
	$anwser3=$anwsers[2]['anwser'];
	
	$anwser1Id=$anwsers[0]['id'];
	$anwser2Id=$anwsers[1]['id'];
	$anwser3Id=$anwsers[2]['id'];

	
	return View::make('promotions.detail', array('promotion' => $promotion[0], 'anwsers' => $anwsers, 'anwser1' => $anwser1, 'anwser2' => $anwser2, 'anwser3' => $anwser3, 'id1' => $anwser1Id, 'id2' => $anwser2Id, 'id3' => $anwser3Id, 'images' => $images));
    }
    
    public function addPromotion()
    {
	$promotion = new Promotions;
	$question = new Questions;
	$images = new Images;
	
	$userId=Auth::user()->id;

	$facebook = new Facebook(Config::get('facebook'));
        $uid = $facebook->getUser();
	
	//get data from form
	$name = Input::get('name');
	$description = Input::get('description');
	$question_text = Input::get('question');
	$startDate = Input::get('start_date');
	$startDate=date("Y-m-d H:i:s",strtotime($startDate));
	$endDate = Input::get('end_date');
	$endDate=date("Y-m-d H:i:s",strtotime($endDate));
	$anwser1 = Input::get('anwser1');
	$anwser2= Input::get('anwser2');
	$anwser3 = Input::get('anwser3');
	$color = Input::get('color');
	$image=Input::file('image');
	$button=Input::file('button');
	
	$correctId= Input::get('anwser'); //id of selected correct anwser
	
	if ($name!=''){
	    $image_name=trim(strtolower($name).'.jpg');
	    $button_name= 'btn_'.trim(strtolower($name).'.jpg');
	}
	else{
	    $image_name='slika.jpg';
	    $button_name='btn_slika.jpg';
	}
	
	
	
	if ($startDate=='1970-01-01 00:00:00'){
	    $startDate='';
	}
	if ($endDate=='1970-01-01 00:00:00'){
	    $endDate='';
	}
	
    	$dataNew = array(
		'name' => $name,
		'description' => $description,
		'start_date' => $startDate,
		'end_date' => $endDate,
		'question' => $question_text,
		'anwser1' => $anwser1,
		'anwser2' => $anwser2,
		'anwser3' => $anwser3,
		'image' => $image,
		'button' => $button
	);
	
	$rules = array(
		'name' => 'required',
		'description' => 'required|min:20',
		'start_date' => 'required',
		'end_date' => 'required|after:'.$startDate,
		'question' => 'required|min:10',
		'anwser1' => 'required',
		'anwser2' => 'required',
		'anwser3' => 'required',
		/*'image' => 'required|image',
		'button' => 'required|image'*/
	    );

	$validation_messages = array(
	    'required'             => 'Polje ne sme biti prazno',
	    'before'               => 'Datum začetka je večji od datuma konca',
	    'after'                => 'Datum konca je manjši od datuma začetka',
	    'min'                  => 'Vnesite vsaj :min znakov',
	);
	
	$file=Input::file('image');
	$button=Input::file('button');
	
	$image_input = array('image' => $file);
	
	$rules_image = array(
	    'image' => 'image'
	);
	
	//validator
	$validator = Validator::make($dataNew, $rules, $validation_messages);
	$image_validator = Validator::make($image_input, $rules_image);
	
	//upload file
	if (Input::hasFile('image'))
	{
	    $destinationPath = base_path().'/public/images/promotions/';
	    $databasePath = '/images/promotions/';
	    
	    Input::file('image')->move($destinationPath, $image_name);
	    $filename = $file->getClientOriginalName();
	    $uploaded_filename=$databasePath.$image_name;
	    $filepath =$destinationPath.$image_name;

	    
	}
	
	//upload button
	if (Input::hasFile('button'))
	{

	    $destinationPath = base_path().'/public/images/promotions/';
	    $databasePath = '/images/promotions/';
	    $buttonpath=$destinationPath.$button_name;
	    
	    File::delete($buttonpath);
    
	    Image::make(Input::file('button')->getRealPath())->save($buttonpath);
	    
	    $uploaded_buttonname=$databasePath.$button_name;
	   
	    $buttonpath=$destinationPath.$button_name;
	    
	}
	

	if( $validator->passes() && Input::hasFile('image') && Input::hasFile('button') ) {
	    
	    //save promotion
	    $promotion->id_user = $userId;
	    $promotion->uid_user = $uid;
	    $promotion->name = $name;
	    $promotion->description = $description;
	    $promotion->start_date = $startDate;
	    $promotion->end_date = $endDate;
	    $promotion->color = $color;
	    $promotion->save();
	    
	    //save question
	    $promotionId = $promotion->id;
	    $question->id_promotion = $promotionId;
	    $question->question = $question_text;
	    $question->save();
	    
	    //save anwsers - do in array!!!
	    $questionId = $question->id;
	    
	    $anwser = new Anwsers;
	    //$anwser->id_promotion = $promotionId;
	    $anwser->id_question=$questionId;
	    $anwser->anwser=$anwser1;
	    $anwser->save();

	    $anwser = new Anwsers;
	    //$anwser->id_promotion = $promotionId;
	    $anwser->id_question=$questionId;
	    $anwser->anwser=$anwser2;
	    $anwser->save();
	    
	    $anwser = new Anwsers;
	    //$anwser->id_promotion = $promotionId;
	    $anwser->id_question=$questionId;
	    $anwser->anwser=$anwser3;
	    $anwser->save();
	    
	    $correctanwser = new CorrectAnwsers;
	    $correctanwser->id_question = $questionId;
	    $correctanwser->id_anwser=$correctId;
	    $correctanwser->save();
	    
	    //save image
	    $images = new Images;
	    $promotionId = $promotion->id;
	    $images->id_promotion = $promotionId;
	    $images->background=$uploaded_filename;
	    $images->save();
	    
	    //save button
	    $promotionId = $promotion->id;
	    $images->id_promotion = $promotionId;
	    $images->button=$uploaded_buttonname;
	    $images->save();
	    
	    return Redirect::to('admin/promotions/');
	
	}
	else {
		
		if (isset($filepath) && file_exists($filepath)) {
		    $imagepath='/images/promotions/'.$image_name;
		}
		if (isset($buttonpath) && file_exists($buttonpath)) {
		    $btnpath='/images/promotions/'.$button_name;
		}
		# code for validation failure
		$messages = $validator->messages();
		Input::flash();
		if (isset($imagepath) && isset($btnpath)){
	    
		$anwsersID = DB::table('information_schema.tables')
                     ->select(DB::raw('min(Auto_increment) AS id '))
                     ->where('table_name','=','anwsers')
                     ->get();
	
		$maxId=$anwsersID[0]->id;
		
		$id1=$maxId+1;
		$id2=$maxId+2;
		$id3=$maxId+3;
		
		$anwsers = Anwsers::orderBy('created_at', 'desc')->limit(3)->get();
		
		return View::make('promotions.new',array('anwsers' => $anwsers, 'k' => 1, 'i' => 1, 'j' => 1, 'id1' => $id1, 'id2' => $id2, 'id3' => $id3,'uploaded_filename' => $uploaded_filename,'uploaded_buttonname' => $uploaded_buttonname))->withErrors($messages);
		//return Redirect::to('admin/promotions/new/')->with($uploaded_filename)->withErrors($messages);	
		}
		else if (isset($imagepath)){
		    
		    $anwsersID = DB::table('information_schema.tables')
                     ->select(DB::raw('min(Auto_increment) AS id '))
                     ->where('table_name','=','anwsers')
                     ->get();
	
		    $maxId=$anwsersID[0]->id;
		    
		    $id1=$maxId+1;
		    $id2=$maxId+2;
		    $id3=$maxId+3;
		    
		    $anwsers = Anwsers::orderBy('created_at', 'desc')->limit(3)->get();
		    
		    return View::make('promotions.new',array('anwsers' => $anwsers, 'k' => 1, 'i' => 1, 'j' => 1, 'id1' => $id1, 'id2' => $id2, 'id3' => $id3,'uploaded_filename' => $imagepath))->withErrors($messages);
		    //return Redirect::to('admin/promotions/new/')->with($uploaded_filename)->withErrors($messages);
		   
		}
		else if (isset($btnpath)){

		$anwsersID = DB::table('information_schema.tables')
                     ->select(DB::raw('min(Auto_increment) AS id '))
                     ->where('table_name','=','anwsers')
                     ->get();
	
		$maxId=$anwsersID[0]->id;
		
		$id1=$maxId+1;
		$id2=$maxId+2;
		$id3=$maxId+3;

		
		$anwsers = Anwsers::orderBy('created_at', 'desc')->limit(3)->get();
		
		return View::make('promotions.new',array('anwsers' => $anwsers, 'k' => 1, 'i' => 1, 'j' => 1, 'id1' => $id1, 'id2' => $id2, 'id3' => $id3,'uploaded_buttonname' => $btnpath))->withErrors($messages);
		//return Redirect::to('admin/promotions/new/')->with($uploaded_filename)->withErrors($messages);	
		}
		else{
		   return Redirect::to('admin/promotions/new/')->withErrors($messages);	 
		}	
	}
    }
    
    public function updatePromotion($id)
    {
    
	$facebook = new Facebook(Config::get('facebook'));
        $uid = $facebook->getUser();
    
        $promotion = Promotions::findOrFail($id);
	$question = Questions::where('id_promotion', '=', $id)->firstOrFail();

	$questionId = $question->id;
	$anwsers = Anwsers::where('id_question', '=', $questionId)->get();
	$images = Images::where('id_promotion', '=', $id)->firstOrFail();
	
	$corectAnwser = DB::table('correct_anwsers')
		      ->select('correct_anwsers.id_anwser')
                      ->leftJoin('anwsers', 'anwsers.id', '=', 'correct_anwsers.id_anwser')
		      ->where('anwsers.id_question', '=', $questionId)
		      ->get();
    
	      
	$anwserIdOld=$corectAnwser[0]->id_anwser;

        $name = Input::get('name');
	$description = Input::get('description');
	$startDate = Input::get('start_date');
	$startDate=date("Y-m-d H:i:s",strtotime($startDate));
	$endDate = Input::get('end_date');
	$endDate=date("Y-m-d H:i:s",strtotime($endDate));
	$question_text = Input::get('question');
	$anwser1 = Input::get('anwser1');
	$anwser2= Input::get('anwser2');
	$anwser3 = Input::get('anwser3');
	$color = Input::get('color');
	$image=Input::file('image');
	
	$correctId= Input::get('anwser'); //id of selected correct anwser

	$image_name=trim(strtolower($name).'.jpg');
	$button_name='btn_'.trim(strtolower($name).'.jpg');
	
	if ($startDate=='1970-01-01 00:00:00'){
	    $startDate='';
	}
	if ($endDate=='1970-01-01 00:00:00'){
	    $endDate='';
	}

	//define data and rules arrays for validation
	$data = array(
		'name' => $name,
		'description' => $description,
		'start_date' => $startDate,
		'end_date' => $endDate,
		'question' => $question_text,
		'anwser1' => $anwser1,
		'anwser2' => $anwser2,
		'anwser3' => $anwser3,
	);
	
	$rules = array(
		'name' => 'required',
		'description' => 'required|min:20',
		'start_date' => 'required',
		'end_date' => 'required|after:'.$startDate,
		'question' => 'required|min:10',
		'anwser1' => 'required',
		'anwser2' => 'required',
		'anwser3' => 'required'
	    );
	
	$file=Input::file('image');
	$button=Input::file('button');
	
	$validation_messages = array(
	    'required'             => 'Polje ne sme biti prazno',
	    'before'               => 'Datum začetka je večji od datuma konca',
	    'after'                => 'Datum konca je manjši od datuma začetka',
	    'min'                  => 'Vnesite vsaj :min znak',
	);
	
	//validator
	$validator = Validator::make($data, $rules, $validation_messages);
	
	if( $validator->passes() ) {
		
		//update promotion
		$promotion->name = $name;
		$promotion->uid_user = $uid;
		$promotion->description = $description;
		$promotion->start_date = $startDate;
		$promotion->end_date = $endDate;
		$promotion->color = $color;
		$promotion->save();
		
		//update question
		$promotionId = $promotion->id;
		$question->id_promotion = $promotionId;
		$question->question = $question_text;
		$question->save();
		
		//update anwsers
		$questionId = $question->id;
		
		$i=0;
		foreach ($anwsers as $anwser) {
		    $i++;
		    $affectedRows = Anwsers::where('id', '=', $anwser->id)->update(array('anwser' => Input::get('anwser'.$i)));   
		}

		$affectedAnwsers = CorrectAnwsers::where('id_anwser', '=', $anwserIdOld)->update(array('id_anwser' => $correctId,'id_question' => $questionId));
		
		//upload image
		if (Input::hasFile('image'))
		{

		    $destinationPath = base_path().'/public/images/promotions/';
		    $databasePath = '/images/promotions/';
		    $filepath=$destinationPath.$image_name;
		    
		    File::delete($filepath);
	
		    Image::make(Input::file('image')->getRealPath())->save($filepath);
		    
		    $filename = $file->getClientOriginalName();
		    $uploaded_filename=$databasePath.$image_name;
		    
		    //save image
		    $promotionId = $promotion->id;
		    $images->id_promotion = $promotionId;
		    $images->background=$uploaded_filename;
		    $images->save();
 
		}
		
		//upload button
		if (Input::hasFile('button'))
		{

		    $destinationPath = base_path().'/public/images/promotions/';
		    $databasePath = '/images/promotions/';
		    $buttonpath=$destinationPath.$button_name;
		    
		    File::delete($buttonpath);
	    
		    Image::make(Input::file('button')->getRealPath())->save($buttonpath);
		    
		    
		    $uploaded_buttonname=$databasePath.$button_name;
		    
		    //save button
		    $promotionId = $promotion->id;
		    $images->id_promotion = $promotionId;
		    $images->button=$uploaded_buttonname;
		    $images->save();
 
		}
		
		return Redirect::to('admin/promotions/');
	} else { 
		# code for validation failure
		$messages = $validator->messages();
		return Redirect::to('admin/promotions/edit/'.$id)->withErrors($messages);		
	}
    }
    
    public function deletePromotion($id)
    {
	
	$promotion = Promotions::findOrFail($id);
	$question = Questions::where('id_promotion', '=', $id)->firstOrFail();
	$questionId=$question->id;
	$fbusers = UsersVotes::where('id_promotion', '=', $id)->delete(); // Delete all facebook users for promotion
	$questions = Questions::where('id_promotion', '=', $id)->delete(); // Delete all questions for promotion
	$anwsers = Anwsers::where('id_question', '=', $questionId)->delete(); // Delete all anwsers for promotion
	$correctanwsers = CorrectAnwsers::where('id_question', '=', $questionId)->delete(); // Delete all correct anwsers for promotion
	$images = Images::where('id_promotion', '=', $id)->delete(); // Delete all images for promotion
	$promotion->delete();
	
	return Redirect::to('admin/promotions/');
    }
    
    public function duplicatePromotion($id)
    {	
	$promotion = Promotions::findOrFail($id);
	$question = Questions::where('id_promotion', '=', $id)->firstOrFail();
	$questionId=$question->id;
	$images = Images::where('id_promotion', '=', $id)->firstOrFail();
	
	$anwsers = DB::table('anwsers')
		    -> select ('id', 'anwser', 'correct')
		    -> where ('id_question','=', $questionId)
		    -> get();
		    
	$correctAnwser = DB::table('correct_anwsers')
			-> select ('correct_anwsers.id_question', 'correct_anwsers.id_anwser')
			-> leftJoin('anwsers', 'anwsers.id', '=', 'correct_anwsers.id_anwser')
			-> where ('correct_anwsers.id_question','=', $questionId)
			-> get();
			

	$promotionNew = new Promotions;
	$questionNew = new Questions;
	$imagesNew = new Images;
	$correctAnwsersNew = new CorrectAnwsers;
    
	//save promotion
	$promotionNew->id_user = $promotion->id_user;
        $promotionNew->name = $promotion->name;
	$promotionNew->description = $promotion->description;
	$promotionNew->start_date = $promotion->start_date;
	$promotionNew->end_date = $promotion->end_date;
        $promotionNew->save();
	
	//save question
	$questionNew->id_promotion = $promotionNew->id;
	$questionNew->question = $question->question;
	$questionNew->save();
    
	foreach ($anwsers as $anwser){
	    $anwserNew = new Anwsers;
	    $anwserNew->id_question=$questionNew->id;
	    $anwserNew->anwser=$anwser->anwser;
	    $anwserNew->correct=$anwser->correct;
	    $anwserNew->save();
	}
			
	 //save image
	$imagesNew->id_promotion = $promotionNew->id;
	$imagesNew->background=$images->background;
	$imagesNew->button=$images->button;
	$imagesNew->save();
	
	//save corect anwsers
	$correctAnwsersNew = new CorrectAnwsers;
	$correctAnwsersNew->id_question = $questionNew->id;
	$correctAnwsersNew->id_anwser = $correctAnwser[0]->id_anwser;
	$correctAnwsersNew->save();

	return Redirect::to('admin/promotions/');
    }
    
    public function previewPromotion($id)
    {	
	$promotion = DB::table('promotions')
		    ->select('promotions.id', 'name', 'description', 'start_date', 'end_date', 'question', 'color', 'background','button','correct_anwsers.id_anwser')
                    ->leftJoin('questions', 'promotions.id', '=', 'questions.id_promotion')
		    ->leftJoin('images', 'promotions.id', '=', 'images.id_promotion')
		    ->leftJoin('correct_anwsers', 'correct_anwsers.id_question', '=', 'questions.id')
                    ->where('promotions.id', '=', $id)
		    ->get();
		    
	$promotion_id=$promotion[0]->id;
	    
	$question = Questions::where('id_promotion', '=', $id)->firstOrFail();
	
	$questionId = $question->id;
	
	    
	$anwsers = DB::table('anwsers')
		-> select ('id', 'anwser')
		-> where ('id_question','=', $questionId)
		-> get();
	
	
	return View::make('promotions.preview', array('promotion' => $promotion[0], 'anwsers' => $anwsers));
    }
    
    public function deletePromotionData($id)
    {
	
	$promotion = Promotions::findOrFail($id);
	$users_votes = UsersVotes::where('id_promotion', '=', $id)->delete(); // Delete all facebook users for promotion
	
	return Redirect::to('admin/promotions/');
    }
}