<?php
namespace App\Http\Controllers;

abstract class Controller
{
    # MESSAGES
    public const SUCCESS_MESSAGE     = 'Request processed successfully!';
    public const FAILED_MESSAGE      = 'Unable to process the request. Please try again!';
    public const EXCEPTION_MESSAGE   = 'Exception occured. Please try again!';
    public const INVALID_CREDENTIALS = 'Unable to process the Login Request due to invalid credentials';
    public const USER_NOT_FOUND      = 'User request not found!';
    public const USER_LOGGED_OUT     = 'User logged out successfully!';
    public const DELETED_SUCCESS     = 'Deleted successfully!';
    public const DELETED_FAILED      = 'Unable to delete. Please try again!';

    # STATUS KEYWORD
    public const SUCCESS_STATUS = 'success';
    public const ERROR_STATUS   = 'error';

    # STATUS CODE
    public const SUCCESS          = 200;
    public const CREATED          = 201;
    public const ERROR            = 500;
    public const VALIDATION_ERROR = 422;
}
