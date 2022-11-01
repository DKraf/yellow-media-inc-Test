<?php

/**
 * Resource for GET company endpoint
 *
 * @author RedHead_DEV = [Kravchenko Dmitriy => dkraf9006@gmail.com]
 */

namespace App\Http\Resource\Company;


class ListResource
{
    /**
     * Transform the resource into an array.
     *
     * @param $inData
     * @return array
     */
    static function toArray($inData): array
    {
        $outData = [];

        foreach ($inData as $item) {
            $outData[] = [
                'title' => (string)$item['title'],
                'phone' => (string)$item['phone'],
                'description' => (string)$item['description'],
            ];
        }
        return $outData;
    }
}
