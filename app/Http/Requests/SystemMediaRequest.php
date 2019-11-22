<?php

namespace App\Http\Requests;

use App\Models\SystemMedia;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class MaxFilenameLength implements Rule
{
    public function passes($attribute, $value)
    {
        if (!$value instanceof UploadedFile) {
            return true;
        }

        return Str::length($value->getClientOriginalName()) <= SystemMedia::MAX_FILENAME_LENGTH;
    }

    public function message()
    {
        return ':attribute 名称不能大于 '.SystemMedia::MAX_FILENAME_LENGTH.' 个字符。';
    }
}

class SystemMediaRequest extends FormRequest
{
    public function rules()
    {
        if ($this->isMethod('post')) { // 添加时，验证文件
            // 最大 10M，大文件之后再看
            $maxSize = 10 * 1024;
            return [
                'file' => [
                    'required',
                    'file',
                    'max:'.$maxSize,
                    new MaxFilenameLength(),
                ]
            ];
        } elseif ($this->isMethod('put')) { // 更新时，验证分类
            return [
                'category_id' => 'exists:system_media_categories,id',
            ];
        } else {
            return [];
        }
    }

    public function attributes()
    {
        return [
            'file' => '文件',
            'category_id' => '分类',
        ];
    }
}
