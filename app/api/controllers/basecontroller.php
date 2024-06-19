<?php

namespace App\Controllers;

class BaseController
{
    protected function setHeaders()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Content-Type");
        header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
        header("Content-Type: application/json");
    }

    protected function sanitizeData($data, $fields)
    {
        $sanitizedData = [];
        foreach ($fields as $field => $filter) {
            if (isset($data[$field]) && !empty($data[$field])) {
                $sanitizedData[$field] = filter_var($data[$field], $filter);
            } else if ($filter === FILTER_SANITIZE_SPECIAL_CHARS) {
                $sanitizedData[$field] = '';
            } else {
                $sanitizedData[$field] = null;
            }
        }
        return $sanitizedData;
    }


}