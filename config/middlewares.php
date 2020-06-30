<?php
use Slim\App;
use App\Middleware\ResponseHeaders;
use Psr\Http\Message\ServerRequestInterface;

return function (App $app) {

    $app->addBodyParsingMiddleware();

    //$app->add(BeforeMiddleware::class);

    //$app->add(AfterMiddleware::class);

    $app->add(ResponseHeaders::class);

    $customErrorHandler = function (

        ServerRequestInterface $request,
        Throwable $exception,
        bool $displayErrorDetails,
        bool $logErrors,
        bool $logErrorDetails
    
    ) use ($app) {
        // $logger->error($exception->getMessage());
    
        $payload = ['error' => $exception->getMessage()];
    
        $response = $app->getResponseFactory()->createResponse();
    
        $response->getBody()->write(
    
            json_encode($payload, JSON_UNESCAPED_UNICODE)
    
        );
    
        return $response;
    };

    $errorMiddleware = $app->addErrorMiddleware(true, true, true);
    $errorMiddleware->setDefaultErrorHandler($customErrorHandler);
};