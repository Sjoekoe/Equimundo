<?php namespace EQM\Models\Horses\Requests;

use Carbon\Carbon;
use EQM\Http\Requests\Request;

class UpdateHorse extends Request {
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
        $horse = $this->route('horse_slug');
        $today = Carbon::now()->addDay()->startOfDay()->format('d/m/Y');

        return [
            'name' => 'required',
            'date_of_birth' => 'date_format:d/m/Y|before:' . $today,
            'life_number' => 'unique:horses,id,' . $horse->id(),
        ];
    }

}
