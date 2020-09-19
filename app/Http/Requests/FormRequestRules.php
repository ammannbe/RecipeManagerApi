<?php

namespace App\Http\Requests;

/**
 * Generic Form Request Rules
 */
trait FormRequestRules
{
    /**
     * Get the limit rule
     *
     * @param  int  $limit
     * @return array
     */
    protected function getLimitRule(int $limit = 1000): array
    {
        return ['integer', "max:{$limit}"];
    }

    /**
     * Get the page rule
     *
     * @return array
     */
    protected function getPageRule()
    {
        return ['integer'];
    }

    /**
     * Get the trashed rule
     *
     * @return array
     */
    public function getTrashedRule(): array
    {
        return ['boolean'];
    }
}
