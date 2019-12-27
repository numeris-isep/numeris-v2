<?php

namespace App\Http\Requests;

use App\Models\Role;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

abstract class AbstractFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    abstract public function rules();

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    abstract public function authorize();

    /**
     * {@inheritdoc}
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(response()
            ->json(['errors' => $errors], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }

    /**
     * {@inheritdoc}
     */
    protected function failedAuthorization()
    {
        return auth()->user()->role()->isInferiorTo(Role::STAFF);
    }
}
