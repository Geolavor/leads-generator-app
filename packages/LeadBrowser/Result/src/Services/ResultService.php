<?php

declare(strict_types=1);

namespace LeadBrowser\Result\Services;

use LeadBrowser\Result\Models\Result;
use Illuminate\Support\Facades\Log;

class ResultService
{
    /**
     * @param string $query
     * @param string $column
     * @param int $user_id
     */
    public function searchResultBy(string $query = '', string $column = '', int $user_id): Result|null
    {
        if (!$user_id) return null;

        return Result::where('user_id', $user_id)
            ->where($column, $query)
            ->first();
    }

    /**
     * @param string $searchable
     * @param int $search_id
     * @param int $user_id
     * @param string $title
     * @param int $organization_id
     * @param $place_content
     * @param bool $is_payable
     * 
     * @return int
     */
    public static function createResult(
        string $searchable = 'LeadBrowser\Search\Models\SearchLocations',
        int $search_id = null,
        int $user_id,
        string $title = null,
        int $organization_id,
        $place_content = '',
        bool $is_payable = true
    ): int
    {
        if (!isset($user_id) || !isset($organization_id)) return 0;

        $risk_value = $place_content && $title ? (new self)->calculateRiskValue($title, $place_content) : 0;

        $result = new Result();
        $result->user_id = $user_id;

        if ($search_id) {
            $result->searchable_id = $search_id;
            $result->searchable_type = $searchable;
        }

        $result->organization_id = $organization_id;
        $result->is_payable = $is_payable;
        $result->risk_value = $risk_value;
        $result->stage_id = 1;
        $result->save();

        return $result->id;
    }

    /**
     * Function for calculate risk value of this data
     * 
     * @param string $title
     * @param string $content
     */
    protected function calculateRiskValue(string $title, $content)
    {
        $value = 0;
        $words = explode(" ", $title);

        foreach ($words as $key => $word) {
            if (str_contains($content, $word)) { 
                $value += substr_count($content, $word);
            }
        }

        return $value;
    }
}