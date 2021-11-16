<?php

namespace App\Http\Requests;

use App\Models\PushNotification;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdatePushNotificationRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('push_notification_edit');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'required',
            ],
            'content' => [
                'string',
                'required',
            ],
        ];
    }
}
