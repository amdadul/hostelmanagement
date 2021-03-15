<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use App\Traits\FlashMessages;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Redirect;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, FlashMessages;

    protected function responseJson($error = ture, $responseCode = 200, $message = [], $data = null): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'error' => $error,
            'response_code' => $responseCode,
            'message' => $message,
            'data' => $data,
        ]);
    }

    protected function responseRedirect($route, $message, $type = 'info', $error = false, $withOldInputWhenError = false): RedirectResponse
    {
        $this->setFlashMessage($message, $type);
        $this->showFlashMessages();
        if ($error && $withOldInputWhenError) {
            return redirect()->back()->withInput();
        }
        return redirect()->route($route);
    }

    /**
     * @param $message
     * @param string $type
     * @param bool $error
     * @param bool $withOldInputWhenError
     * @return RedirectResponse
     */
    protected function responseRedirectBack($message, $type = 'info', $error = false, $withOldInputWhenError = false): RedirectResponse
    {
        $this->setFlashMessage($message, $type);
        $this->showFlashMessages();

        return redirect()->back();
    }

    /**
     * @param $redirectRouteName
     * @param array $parameter
     * @param $message
     * @param string $type
     * @param bool $error
     * @param bool $withOldInputWhenError
     * @return RedirectResponse
     */
    protected function responseRedirectToWithParameters($redirectRouteName, $parameter = [], $message, $type = 'info', $error = false, $withOldInputWhenError = false): RedirectResponse
    {
        $this->setFlashMessage($message, $type);
        $this->showFlashMessages();

        return Redirect::route($redirectRouteName, $parameter)->with('message', 'State saved correctly!!!');
    }

}
