<?php namespace EQM\Models\Horses\Requests;

use EQM\Http\Requests\Request;
use EQM\Models\Horses\HorseRepository;

class UpdateHorse extends Request {
    /**
     * @var \EQM\Models\Horses\HorseRepository
     */
    private $horses;

    /**
     * @param \EQM\Models\Horses\HorseRepository $horses
     */
    public function __construct(HorseRepository $horses)
    {
        $this->horses = $horses;
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
        $horse = $this->horses->findBySlug($this->route('slug'));

        return [
            'name' => 'required',
            'date_of_birth' => 'date_format:d/m/Y',
            'life_number' => 'unique:horses,id,' . $horse->id(),
        ];
    }

}
