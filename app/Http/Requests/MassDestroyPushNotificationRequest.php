<?php

namespace App\Http\Requests;

use App\Models\PushNotification;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyPushNotificationRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('push_notification_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:push_notifications,id',
        ];
    }
}
