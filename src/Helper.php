<?php

namespace Albet\LearnApi;

class Helper
{
    /**
     * This is a helper function which simply returns the corresponding response json
     * based on parameters.
     * 
     * @param string $message
     * @param callback $callback
     * 
     * @return never
     */
    public static function handleError($message = null, $callback = null): never
    {
        http_response_code(401);
        header("Content-Type: application/json");
        if ($callback) {
            $callback();
        }
        if ($message) {
            echo json_encode(["status" => "error", "message" => $message]);
        } else {
            echo json_encode(["status" => "error", "message" => "Sorry, you're not allowed to access this resource."]);
        }
        exit;
    }
}
