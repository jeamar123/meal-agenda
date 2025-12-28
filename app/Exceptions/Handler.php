<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use \Illuminate\Validation\ValidationException;
use \Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Foundation\Application;
use Inertia\Inertia;

class Handler extends ExceptionHandler
{
    protected const array INERTIA_HANDLED_ERRORS = [
        Response::HTTP_INTERNAL_SERVER_ERROR,
        Response::HTTP_SERVICE_UNAVAILABLE,
        Response::HTTP_NOT_FOUND,
        Response::HTTP_FORBIDDEN,
    ];

    protected Application $app;

    /** @var array<int, string> */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function __construct(Container $container)
    {
        parent::__construct($container);

        $this->app = $this->container->make('app');
    }

    public function register()
    {
        // $this->reportable(function (ValidationException $e) {
        //     return response()->json([
        //         'errors' => $e->errors(),
        //         'status' => false,
        //     ], 500);
        // });

        // $this->renderable(function(ValidationException $e, $request) {
        //     return response()->json([
        //         'errors' => $e->errors(),
        //         'status' => false,
        //     ], 500);
        // });
    }

    /**
     * @param Request $request
     *
     * @throws Throwable
     */
    #[Override]
    public function render(mixed $request, Throwable $e): RedirectResponse|Response
    {
        if ($e instanceof ValidationException) {
            if ($request->header('X-Inertia')) {
                // Let Inertia handle it automatically
                throw $e; // or return parent::render($request, $e);
            }

            return parent::render($request, $e);
        }
        
        $response = parent::render($request, $e);

        if ($this->app->isLocal() && $response->getStatusCode() === Response::HTTP_INTERNAL_SERVER_ERROR) {
            return $response;
        }

        if ($response->getStatusCode() === 419) { // XSRF token expired error
            return back()->with(['message' => 'The page expired, please try again.']);
        }

        if (in_array($response->getStatusCode(), self::INERTIA_HANDLED_ERRORS, true)) {
            return Inertia::render('Error', ['status' => $response->getStatusCode()])
                ->toResponse($request)
                ->setStatusCode($response->getStatusCode());
        }

        return $response;
    }
}
