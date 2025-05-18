<?php

interface HandlerInterface
{
    public function setNext(HandlerInterface $handler): HandlerInterface;
    public function handle(string $request);
}

class BaseHandler implements HandlerInterface
{
    protected ?HandlerInterface $nextHandler = null;

    public function setNext(HandlerInterface $handler): HandlerInterface
    {
        $this->nextHandler = $handler;
        return $handler;
    }

    public function handle($request)
    {
        if ($this->nextHandler) {
            return $this->nextHandler->handle($request);
        }
        return true;
    }
}

class CheckBannedUser extends BaseHandler
{
    public function handle($request)
    {
        if ($request === 'banned') {
            return 'User is banned';
        }
        return parent::handle($request);
    }
}

class CheckVerifiedUser extends BaseHandler
{
    public function handle($request)
    {
        if ($request === 'not_verified') {
            return 'User is not verified';
        }
        return parent::handle($request);
    }
}

class CheckUserPoints extends BaseHandler
{
    public function handle($request)
    {
        if ($request === 'low_points') {
            return 'User has low points';
        }
        return parent::handle($request);
    }
}

// Usage
$bannedCheck = new CheckBannedUser();
$verifiedCheck = new CheckVerifiedUser();
$pointsCheck = new CheckUserPoints();

$bannedCheck->setNext($verifiedCheck)->setNext($pointsCheck);

$result = $bannedCheck->handle('not_verified');

if ($result) {
    echo $result;
} else {
    echo 'User is valid';
}
