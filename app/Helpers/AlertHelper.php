<?php

namespace App\Helpers;

class AlertHelper
{
    /**
     * Redirigir con un mensaje de éxito usando el sistema unificado
     */
    public static function success($route, $message = 'Operación exitosa', $params = [])
    {
        return redirect()->route($route, $params)->with('success', $message);
    }

    /**
     * Redirigir con un mensaje de error usando el sistema unificado
     */
    public static function error($route, $message = 'Ocurrió un error', $params = [])
    {
        return redirect()->route($route, $params)->with('error', $message);
    }

    /**
     * Redirigir con un mensaje de advertencia usando el sistema unificado
     */
    public static function warning($route, $message = 'Advertencia', $params = [])
    {
        return redirect()->route($route, $params)->with('warning', $message);
    }

    /**
     * Redirigir con un mensaje informativo usando el sistema unificado
     */
    public static function info($route, $message = 'Información', $params = [])
    {
        return redirect()->route($route, $params)->with('info', $message);
    }

    /**
     * Redirigir hacia atrás con un mensaje de éxito
     */
    public static function backSuccess($message = 'Operación exitosa')
    {
        return redirect()->back()->with('success', $message);
    }

    /**
     * Redirigir hacia atrás con un mensaje de error
     */
    public static function backError($message = 'Ocurrió un error')
    {
        return redirect()->back()->with('error', $message);
    }

    /**
     * Redirigir hacia atrás con un mensaje de advertencia
     */
    public static function backWarning($message = 'Advertencia')
    {
        return redirect()->back()->with('warning', $message);
    }

    /**
     * Redirigir hacia atrás con un mensaje informativo
     */
    public static function backInfo($message = 'Información')
    {
        return redirect()->back()->with('info', $message);
    }

    /**
     * Redirigir hacia atrás con input y mensaje de error
     */
    public static function backWithError($message = 'Ocurrió un error')
    {
        return redirect()->back()->withInput()->with('error', $message);
    }
}
