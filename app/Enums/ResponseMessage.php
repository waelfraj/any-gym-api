<?php
namespace  App\Enums;

enum ResponseMessage: string
{
    case USER_CREATED = 'User Created';
    case USER_UPDATED = 'User Updated';
    case INVALID_CREDENTIALS = 'Invalid Credentials';
    case USER_NOT_FOUND = 'User not found!';
    case LOGGED_OUT = 'logged out';
    case RESET_PASSWORD_SEND = 'Please check your mail to reset your password.';
    case MAIL_VALIDATION_SEND = 'Please check your mail to confirm your address mail.';

    case TOKEN_INVALID = 'Token is Invalid or Expired';
    case PASSWORD_RESET_SUCCESS = 'Password Reset Success';
    case MAIL_VERIFIED = 'Mail verified with successfully';

    case FORBIDDEN = "FORBIDDEN";
    case BAD_REQUEST = "BAD REQUEST";
    case CREATED_SUCCESS = "Created Successfully";
    case UPDATED_SUCCESS = "Updated Successfully";
    case DELETED_SUCCESS = "Deleted Successfully";
    case INTERNAL_SERVER = 'Something went really wrong!';

    case NO_API_KEY_FOUND = 'No API keys found in database';
}
