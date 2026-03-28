<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contract extends Model
{
    protected $fillable = [
        'client_id',
        'start_date',
        'end_date',
        'status'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'start_date' => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d'
    ];

    protected $appends = [
        'total_value'
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(ContractItem::class);
    }

    public function getTotalValueAttribute()
    {
        return $this->items->sum(function ($item) {
            return $item->quantity * $item->unit_value;
        });
    }

    public static function rules(string $context = 'insert', $id = null): array
    {
        $rules = [
            'insert' => [
                'client_id' => 'required|integer|exists:clients,id',
                'start_date' => 'required|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'status' => 'required|in:Ativo,Cancelado'
            ],
            'update' => [
                'id' => 'required|integer|exists:contracts,id',
                'client_id' => 'sometimes|required|integer|exists:clients,id',
                'start_date' => 'sometimes|required|date',
                'end_date' => 'sometimes|nullable|date|after_or_equal:start_date',
                'status' => 'sometimes|required|in:Ativo,Cancelado'
            ],
            'delete' => [
                'id' => 'required|integer|exists:contracts,id',
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
                'client_id' => [
                    'required' => 'O cliente é obrigatório.',
                    'integer' => 'O cliente ID deve ser um número.',
                    'exists' => 'O cliente selecionado não existe.'
                ],
                'start_date' => [
                    'required' => 'A data de início é obrigatória.',
                    'date' => 'A data de início deve ser uma data válida.'
                ],
                'end_date' => [
                    'date' => 'A data de término deve ser uma data válida.',
                    'after_or_equal' => 'A data de término não pode ser anterior à data de início.'
                ],
                'status' => [
                    'required' => 'O status é obrigatório.',
                    'in' => 'O status deve ser Ativo ou Cancelado.'
                ]
            ],
            'update' => [
                'id' => [
                    'required' => 'ID obrigatório.',
                    'integer' => 'ID deve ser um número.',
                    'exists' => 'Contrato não encontrado.'
                ],
                'client_id' => [
                    'required' => 'O cliente é obrigatório.',
                    'integer' => 'O cliente ID deve ser um número.',
                    'exists' => 'O cliente selecionado não existe.'
                ],
                'start_date' => [
                    'required' => 'A data de início é obrigatória.',
                    'date' => 'A data de início deve ser uma data válida.'
                ],
                'end_date' => [
                    'date' => 'A data de término deve ser uma data válida.',
                    'after_or_equal' => 'A data de término não pode ser anterior à data de início.'
                ],
                'status' => [
                    'required' => 'O status é obrigatório.',
                    'in' => 'O status deve ser Ativo ou Cancelado.'
                ]
            ],
            'delete' => [
                'id' => [
                    'required' => 'ID obrigatório.',
                    'integer' => 'ID deve ser um número.',
                    'exists' => 'Contrato não encontrado.'
                ]
            ]
        ];

        if (!array_key_exists($context, $errorMessages)) {
            return [];
        }

        return $errorMessages[$context];
    }
}