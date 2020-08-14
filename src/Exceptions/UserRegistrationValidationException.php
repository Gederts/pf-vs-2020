<?php


namespace Project\Exceptions;


class UserRegistrationValidationException extends \Exception
{
    public array $errorMessages = [];
}