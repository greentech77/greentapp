<?php

class ImageController extends BaseController {

	public function getUploadForm() {
		return View::make('promotions/upload-form');
	}

	public function postUpload() {
		//$file = $_POST['file'];
		$file = Input::file('image');
		$name = Input::get('name');
		//print_r($file);
		
		/*$destinationPath = '/public/images/promotions/';
		$upload_success = Input::upload('photo', $destinationPath, $name);*/
		
		$input = array('image' => $file);
		$rules = array(
			'image' => 'image'
		);
		$validator = Validator::make($input, $rules);
		if ( $validator->fails() )
		{
			return Response::json(['success' => false, 'errors' => $validator->getMessageBag()->toArray()]);

		}
		else {
			$destinationPath = '/public/images/promotions/';
			$file=Input::file('image');
			//print_r($file);
			//$filename = $file->getClientOriginalName();
			//Input::file('image')->move($destinationPath, $filename);
			return Response::json(['success' => true, 'file' => asset($destinationPath.'testna promocija1.jpg')]);
		}

	}
}