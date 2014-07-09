<?php

class Promotions extends Eloquent {
    
        /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'promotions';

    /**
     * The attributes that cannot be mass assigned.
     *
     * @var array
     */
    protected $guarded = array('id', 'created_at', 'updated_at');

    /**
     * Contains our per model validation rules. Set by
     * our models.
     *
     * @var array
     */


                
    protected $validation_rules = array(
        'name' => 'required',
        'description' => 'required',
        'start_date' => 'required',
        'end_date' => 'required|after:start_date',
        'question' => 'required',
        'anwser1' => 'required',
        'anwser2' => 'required',
        'anwser3' => 'required',
        'link' => 'required',
        'image' => 'required|image',
        'button' => 'required|image'
        
        
    );

    /**
     * Contains our per model validation message overrides.
     *
     * @var array
     */
    protected $validation_messages = array(
        'required'             => 'Polje ne sme biti prazno.',
        'url'                  => 'Vnesti morate povezavo v pravilni obliki.',
    );

    /**
     * Get the unique identifier for the event.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->getKey();
    }
}