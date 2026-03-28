<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Validation\Rule;

class Client extends Model
{
    protected $fillable = [
        'name',
        'document',
        'email',
        'status'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class);
    }

    protected function setDocumentAttribute($value)
    {
        $this->attributes['document'] = preg_replace('/[^0-9]/', '', $value);
    }

    public static function rules(string $context = 'insert', $id = null): array
    {
        $rules = [
            'insert' => [
                'name' => 'required|string|max:255',
                'document' => [
                    'required',
                    'string',
                    'unique:clients,document',
                    function ($attribute, $value, $fail) {
                        $pattern = '/^([0-9]{2}[\.]?[0-9]{3}[\.]?[0-9]{3}[\/]?[0-9]{4}[-]?[0-9]{2})|([0-9]{3}[\.]?[0-9]{3}[\.]?[0-9]{3}[-]?[0-9]{2})$/';

                        if (! preg_match($pattern, $value)) {
                            $fail('Documento inválido.');
                        }
                    }
                ],
                'email' => 'required|email|unique:clients,email',
                'status' => 'required|in:Ativo,Inativo'
            ],
            'update' => [
                'id' => 'integer|exists:clients,id',
                'name' => 'sometimes|required|string|max:255',
                'document' => [
                    'sometimes',
                    'required',
                    'string',
                    Rule::unique('clients', 'document')->ignore($id)
                ],
                'email' => [
                    'sometimes',
                    'required',
                    'email',
                    Rule::unique('clients', 'email')->ignore($id)
                ],
                'status' => 'sometimes|required|in:Ativo,Inativo'
            ],
            'delete' => [
                'id' => 'required|integer|exists:clients,id',
            ]
        ];

        if (!array_key_exists($context, $rules)) {
            return [];
        }

        return $rules[$context];
    }

    public static function errorMessage(string $context = 'insert'): array
    {
        $errorMessages = [
            'insert' => [
                'name' => [
                    'required' => 'Nome obrigatório.',
                    'string' => 'O nome deve conter apenas letras.'
                ],
                'document' => [
                    'required' => 'Documento obrigatório.',
                    'string' => 'Documento deve ser uma string.',
                    'unique' => 'Documento já cadastrado.'
                ],
                'email' => [
                    'required' => 'E-mail obrigatório.',
                    'email' => 'O e-mail está no formato errado.',
                    'unique' => 'E-mail já cadastrado.'
                ],
                'status' => [
                    'required' => 'Status obrigatório.',
                    'in' => 'Status deve ser Ativo ou Inativo.'
                ]
            ],
            'update' => [
                'id' => [
                    'required' => 'ID obrigatório.',
                    'integer' => 'ID deve ser um número.',
                    'exists' => 'Cliente não encontrado.'
                ],
                'name' => [
                    'required' => 'Nome obrigatório.',
                    'string' => 'O nome deve conter apenas letras.'
                ],
                'document' => [
                    'required' => 'Documento obrigatório.',
                    'string' => 'Documento deve ser uma string.',
                    'unique' => 'Documento já cadastrado.'
                ],
                'email' => [
                    'required' => 'E-mail obrigatório.',
                    'email' => 'O e-mail está no formato errado.',
                    'unique' => 'E-mail já cadastrado.'
                ],
                'status' => [
                    'required' => 'Status obrigatório.',
                    'in' => 'Status deve ser Ativo ou Inativo.'
                ]
            ],
            'delete' => [
                'id' => [
                    'required' => 'ID obrigatório.',
                    'integer' => 'ID deve ser um número.',
                    'exists' => 'Cliente não encontrado.'
                ]
            ]
        ];

        if (!array_key_exists($context, $errorMessages)) {
            return [];
        }

        return $errorMessages[$context];
    }
}