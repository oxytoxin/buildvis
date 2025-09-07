<?php

namespace App\Casts;

class BudgetEstimateData
{
    public function __construct(
        public readonly int $lot_length,
        public readonly int $lot_width,
        public readonly int $floor_length,
        public readonly int $floor_width,
        public readonly int $total_area,
        public readonly int $number_of_rooms,
        public readonly int $number_of_stories,
        public readonly array $itemized_costs,
        public readonly float $budget,
        public readonly float $total_cost,
        public readonly float $total_material_cost,
        public readonly float $total_labor_cost,
    ) {}

    public static function fromArray(mixed $value) {}

    public static function getResponseFormat(): array
    {
        return [
            'type' => 'json_schema',
            'json_schema' => [
                'name' => 'quotation_response',
                'strict' => true,
                'schema' => [
                    'type' => 'object',
                    'properties' => [
                        'lot_length' => ['type' => 'integer'],
                        'lot_width' => ['type' => 'integer'],
                        'floor_length' => ['type' => 'integer'],
                        'floor_width' => ['type' => 'integer'],
                        'number_of_rooms' => ['type' => 'integer'],
                        'number_of_stories' => ['type' => 'integer'],
                        'itemized_costs' => [
                            'type' => 'array',
                            'items' => [
                                'type' => 'object',
                                'properties' => [
                                    'name' => ['type' => 'string'],
                                    'category_total' => ['type' => 'number'],
                                    'labor_cost' => ['type' => 'number'],
                                    'products' => [
                                        'type' => 'array',
                                        'items' => [
                                            'type' => 'object',
                                            'properties' => [
                                                'product_name' => ['type' => 'string'],
                                                'sku' => ['type' => 'string'],
                                                'unit' => ['type' => 'string'],
                                                'quantity' => ['type' => 'number'],
                                                'unit_price' => ['type' => 'number'],
                                                'total_price' => ['type' => 'number'],
                                            ],
                                            'required' => ['product_name', 'sku', 'unit', 'quantity', 'unit_price', 'total_price'],
                                            'additionalProperties' => false,
                                        ],
                                    ],
                                ],
                                'required' => ['name', 'category_total', 'labor_cost', 'products'],
                                'additionalProperties' => false,
                            ],
                        ],
                        'budget' => ['type' => 'number'],
                        'total_cost' => ['type' => 'number'],
                        'total_material_cost' => ['type' => 'number'],
                        'total_labor_cost' => ['type' => 'number'],
                    ],
                    'required' => ['lot_length', 'lot_width', 'floor_length', 'floor_width', 'number_of_rooms', 'number_of_stories', 'itemized_costs', 'budget', 'total_cost', 'total_material_cost', 'total_labor_cost'],
                    'additionalProperties' => false,
                ],
            ],
        ];
    }
}
