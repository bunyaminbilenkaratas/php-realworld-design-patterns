<?php

interface MiddlewareInterface {
    public function handle($request, Closure $next);
}

class BannedUserMiddleware implements MiddlewareInterface {
    public function handle($request, Closure $next) {
        if ($request['is_banned']) {
            return 'User is banned';
        }
        return $next($request);
    }
}

class VerifiedUserMiddleware implements MiddlewareInterface {
    public function handle($request, Closure $next) {
        if (!$request['is_verified']) {
            return 'User is not verified';
        }
        return $next($request);
    }
}

class UserPointsMiddleware implements MiddlewareInterface {
    public function handle($request, Closure $next) {
        if ($request['points'] < 10) {
            return 'User has low points';
        }
        return $next($request);
    }
}

class MiddlewareDispatcher {
    protected $middlewares = [];

    public function add(MiddlewareInterface $middleware) {
        $this->middlewares[] = $middleware;
        return $this;
    }

    public function handle($request, Closure $finalHandler) {
        $middlewareChain = array_reduce(
            array_reverse($this->middlewares),
            function ($next, $middleware) {
                return function ($request) use ($middleware, $next) {
                    return $middleware->handle($request, $next);
                };
            },
            $finalHandler
        );

        return $middlewareChain($request);
    }
}

// Usage

$request = [
    'is_banned' => false,
    'is_verified' => true,
    'points' => 15,
];

$dispatcher = new MiddlewareDispatcher();

$dispatcher->add(new BannedUserMiddleware())
          ->add(new VerifiedUserMiddleware())
          ->add(new UserPointsMiddleware());

$response = $dispatcher->handle($request, function ($request) {
    return 'Request passed all middlewares';
});

echo $response;
