<?php namespace EQM\Models\Horses\Requests;

use Carbon\Carbon;
use EQM\Http\Requests\Request;
use EQM\Models\Horses\HorseRepository;

class CreateHorse extends Request {
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
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules()
    {
        $today = Carbon::now()->addDay()->startOfDay()->format('d/m/Y');
        $rules = [
            'name' => 'required',
            'date_of_birth' => 'date_format:d/m/Y|before:' . $today,
            'profile_pic' => 'image',
        ];

        if ($this->has('life_number') && $horse = $this->horses->findByLifeNumber($this->get('life_number'))) {
            if (count($horse->users()) > 0) {
                $rules['life_number'] = 'unique:horses,life_number';
            }
        }

        return $rules;
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'life_number.unique' => 'This horse already exists. If you are the rightful owner, or part of its team please contact the current owner or us.'
        ];
    }
}
