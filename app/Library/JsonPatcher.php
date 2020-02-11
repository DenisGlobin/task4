<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 11.02.2020
 * Time: 00:12
 */

namespace App\Library;


class JsonPatcher
{
    /**
     * Apply patch on target document.
     *
     * @param  mixed $targetDocument
     * @param  mixed $patchDocument
     * @return mixed
     */
    public function patch($targetDocument, $patchDocument)
    {
        if ($targetDocument === null || !is_object($targetDocument) || is_array($targetDocument)) {
            $targetDocument = new \stdClass();
        }

        if ($patchDocument === null || !is_object($patchDocument) || is_array($patchDocument)) {
            return $patchDocument;
        }

        foreach ($patchDocument as $key => $value) {
            if ($value === null) {
                unset($targetDocument->$key);
            } else {
                if (!isset($targetDocument->$key)) {
                    $targetDocument->$key = null;
                }
                $targetDocument->$key = $this->patch(
                    $targetDocument->$key,
                    $value
                );
            }
        }

        return $targetDocument;
    }
}