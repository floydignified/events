<?php

namespace App\Data\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

/**
 * Additional layer of class for custom model methods
 */
abstract class BaseModel extends Model
{
    use SoftDeletes; //use softdeletes trait

    private $errors;
    protected $rules = [];

    /**
     * Define model constructor
     * @param array $attributes
     */
    public function __construct($attributes = [])
    {
        parent::__construct($attributes);
    }

    /**
     * Returns array of error messages from model validation
     *
     * @return array
     */
    public function errors()
    {
        return $this->errors;
    }

    /**
     * Overrides the built-in save and returns a boolean flag
     * indicating validation rules are passed, fields are properly filled,
     * and successfully executed
     *
     * @param array $options
     * @return boolean
     */
    public function save($options = [])
    {
        if (!$this->validate($options)) {
            return false;
        }

        try {
            parent::fill($options);
            parent::save();

            return true;
        } catch (\Exception $e) {
            $this->errors = $e->getMessage();

            return false;
        }
    }

    /**
     * Returns a boolean flag that indicates whether
     * the validation succeeds or fails
     *
     *  @param array $data
     *  @return boolean
     */
    public function validate($data = [])
    {
        $validate = Validator::make($data, $this->rules);

        if ($validate->fails()) {
            $this->errors = $validate->errors()->first();
            return false;
        }

        return true;
    }
}
