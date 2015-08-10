<?php namespace EQM\Http\Requests;

use EQM\Http\Requests\Request;
use EQM\Models\Horses\Horse;

class UpdateHorse extends Request {
    /**
     * @var \EQM\Models\Horses\Horse
     */
    private $horse;

    /**
     * @param \EQM\Models\Horses\Horse $horse
     */
    public function __construct(Horse $horse)
    {
        $this->horse = $horse;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'date_of_birth' => 'date_format:d/m/Y',
            'life_number' => 'unique:horses,id,' . $this->horse->id,
        ];
    }

}
