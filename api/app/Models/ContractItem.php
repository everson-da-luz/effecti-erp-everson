<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContractItem extends Model
{
    protected $table = 'contract_items';

    protected $fillable = [
        'contract_id',
        'service_id',
        'quantity',
        'unit_value'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'unit_value' => 'decimal:2',
    ];

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public static function rules(string $context = 'insert'): array
    {
        $rules = [
            'insert' => [
                'contract_id' => 'required|integer|exists:contracts,id',
                'service_id' => 'required|integer|exists:services,id',
                'quantity' => 'required|numeric|min:1',
                'unit_value' => 'nullable|numeric'
            ],
            'update' => [
                'id' => 'required|integer|exists:contract_items,id',
                'contract_id' => 'required|exists:contracts,id',
                'service_id' => 'required|exists:services,id',
                'quantity' => 'required|numeric|min:1',
                'unit_value' => 'nullable|numeric'
            ],
            'delete' => [
                'id' => 'required|integer|exists:contract_items,id',
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
                'contract_id' => [
                    'required' => 'O contrato é obrigatório.',
                    'integer' => 'O contrato ID deve ser um número.',
                    'exists' => 'O contrato selecionado não existe.'
                ],
                'service_id' => [
                    'required' => 'O serviço é obrigatório.',
                    'integer' => 'O serviço ID deve ser um número.',
                    'exists' => 'O serviço selecionado não existe.'
                ],
                'quantity' => [
                    'required' => 'A quantidade é obrigatória.',
                    'numeric' => 'A quantidade deve ser um número.'
                ],
                'unit_value' => [
                    'numeric' => 'O valor unitário deve ser um número.'
                ]
            ],
            'update' => [
                'id' => [
                    'required' => 'ID obrigatório.',
                    'integer' => 'ID deve ser um número.',
                    'exists' => 'Item não encontrado.'
                ],
                'contract_id' => [
                    'required' => 'O contrato é obrigatório.',
                    'integer' => 'O contrato ID deve ser um número.',
                    'exists' => 'O contrato selecionado não existe.'
                ],
                'service_id' => [
                    'required' => 'O serviço é obrigatório.',
                    'integer' => 'O serviço ID deve ser um número.',
                    'exists' => 'O serviço selecionado não existe.'
                ],
                'quantity' => [
                    'required' => 'A quantidade é obrigatória.',
                    'numeric' => 'A quantidade deve ser um número.'
                ],
                'unit_value' => [
                    'numeric' => 'O valor unitário deve ser um número.'
                ]
            ],
            'delete' => [
                'id' => [
                    'required' => 'ID obrigatório.',
                    'integer' => 'ID deve ser um número.',
                    'exists' => 'Item não encontrado.'
                ]
            ]
        ];

        if (!array_key_exists($context, $errorMessages)) {
            return [];
        }

        return $errorMessages[$context];
    }

    public static function applyQuantityDiscount($quantity, $currentValue, $discountPercent)
    {
        if ($quantity >= 5 && $discountPercent > 0) {
            $discountValue = $currentValue / 100 * $discountPercent;

            return $currentValue - $discountValue;
        }

        return $currentValue;
    }
}