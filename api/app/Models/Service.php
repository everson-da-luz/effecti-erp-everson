<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    protected $fillable = [
        'name',
        'base_monthly_value'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'base_monthly_value' => 'decimal:2',
    ];

    public function contractItems(): HasMany
    {
        return $this->hasMany(ContractItem::class);
    }

    public static function rules(string $context = 'insert', $id = null): array
    {
        $rules = [
            'insert' => [
                'name' => 'required|string|max:255',
                'base_monthly_value' => 'required|numeric'
            ],
            'update' => [
                'id' => 'integer|exists:services,id',
                'name' => 'sometimes|required|string|max:255',
                'base_monthly_value' => 'sometimes|required|numeric'
            ],
            'delete' => [
                'id' => 'required|integer|exists:services,id',
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
                'base_monthly_value' => [
                    'required' => 'Valor base mensal obrigatório.',
                    'numeric' => 'Valor base mensal deve ser um número.',
                ]
            ],
            'update' => [
                'id' => [
                    'required' => 'ID obrigatório.',
                    'integer' => 'ID deve ser um número.',
                    'exists' => 'Serviço não encontrado.'
                ],
                'name' => [
                    'required' => 'Nome obrigatório.',
                    'string' => 'O nome deve conter apenas letras.'
                ],
                'base_monthly_value' => [
                    'required' => 'Valor base mensal obrigatório.',
                    'numeric' => 'Valor base mensal deve ser um número.',
                ]
            ],
            'delete' => [
                'id' => [
                    'required' => 'ID obrigatório.',
                    'integer' => 'ID deve ser um número.',
                    'exists' => 'Serviço não encontrado.'
                ]
            ]
        ];

        if (!array_key_exists($context, $errorMessages)) {
            return [];
        }

        return $errorMessages[$context];
    }
}