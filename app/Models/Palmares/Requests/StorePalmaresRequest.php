<?php
namespace EQM\Models\Palmares\Requests;

use Carbon\Carbon;
use EQM\Http\Requests\Request;

class StorePalmaresRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $date = Carbon::now()->addDay()->startOfDay()->format('d/m/Y');

        return [
            'event_name' => 'required',
            'ranking' => 'integer|min:0',
            'date' => 'date_format:d/m/Y|before:' . $date,
        ];
    }
}
