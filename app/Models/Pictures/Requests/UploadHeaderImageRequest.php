<?php
namespace EQM\Models\Pictures\Requests;

use EQM\Http\Requests\Request;

class UploadHeaderImageRequest extends Request
{
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
        return [
            'header_picture' => 'required|image',
        ];
    }
}
