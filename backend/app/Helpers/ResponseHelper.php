<?php

namespace App\Helpers;

use \Illuminate\Http\JsonResponse;

/**
 * Класс ResponseHelper позволяет унифицировать ответы Api в единый формат
 *
 * @package App\Helpers
 */
class ResponseHelper
{
    /**
     * Метод формирует массив с успешным ответом
     *
     * @param string|null $message
     * @param mixed $data
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    public static function sendSuccess($data = null, string $message = null, int $status = 200)
    {
        $result = [
            'status' => true,
            'data' => $data,
            'message' => $message ?: 'Запрос успешно выполнен',
        ];

        return response()->json($result, $status);
    }

    /**
     * Метод формирует массив с неудачным ответом
     *
     * @param array|string $errors
     * @param string|null $message
     * @param int $errorcode
     * @return \Illuminate\Http\JsonResponse
     */
    public static function sendError($errors = 'Неизвестная ошибка', $message = null, int $errorcode = 400)
    {
        $errors = !is_array($errors) ? [$errors ?: 'Неизвестная ошибка'] : $errors;
        $errorcode = $errorcode ?: 400;

        return response()->json([
            'status' => false,
            'message' => $message,
            'errors' => $errors,
        ], $errorcode);
    }

    /**
     * Метод формирует массив с неудачным ответом из объекта ошибки/исключения
     *
     * @param Exception|Throwable $errors
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public static function sendException($exception)
    {
        return self::sendError(
            (string) $exception->getMessage(),
            false,
            ((int) $exception->getCode() > 500) ? 400 : (int) $exception->getCode()
        );
    }
}
