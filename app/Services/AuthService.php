<?php

namespace App\Services;

use App\Constants\Constants;
use App\Constants\ConstMailValidationToken;
use App\Constants\ConstResetPassword;
use App\Enums\ResponseMessage;
use App\Exceptions\CustomException;
use App\Exceptions\TokenExceptions\TokenInvalidException;
use App\Exceptions\ValidationMailException;
use App\Http\Requests\ForgetPasswordRequest;
use App\Notifications\APIPasswordResetNotification;
use App\Notifications\MailValidationNotification;
use App\Repositories\Interfaces\MailValidationRepositoryInterface;
use App\Repositories\Interfaces\PasswordResetRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Exception;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\CssSelector\Exception\InternalErrorException;

class AuthService
{
    public function __construct(
        private readonly PasswordResetRepositoryInterface  $passwordResetRepository,
        private readonly UserRepositoryInterface           $userRepository,
        private readonly MailValidationRepositoryInterface $mailValidationRepository
    )
    {
    }

    private function createNewToken($email): int
    {
        // Generate Token
        $token = rand(ConstResetPassword::min, ConstResetPassword::max);
        $oldToken = $this->passwordResetRepository->getResetPassword($email);
        if ($oldToken) {
            $this->passwordResetRepository->deleteResetPassword($email);
        }

        // Saving Data to Password Reset Table
        $this->passwordResetRepository->createResetPassword($email, $token);
        return $token;
    }

    private function deleteOldToken($email): void
    {
        // Generate Token
        $oldToken = $this->passwordResetRepository->getResetPassword($email);
        if ($oldToken) {
            $this->passwordResetRepository->deleteResetPassword($email);
        }
    }


    /**
     * @param ForgetPasswordRequest $request
     * @return string
     * @throws CustomException
     */
    public function sendPasswordResetToken(ForgetPasswordRequest $request): string
    {
        try {
            $email = $request->email;
            $user = $this->userRepository->getUserByEmail($email);
            $this->deleteOldToken($email);
            $token = $this->createNewToken($email);

            // Sending Email with Password Reset
            Notification::sendNow($user, new APIPasswordResetNotification($token, $user->name));
            return ResponseMessage::RESET_PASSWORD_SEND->value;

        } catch (Exception $e) {
            throw new CustomException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param $request
     * @return string
     * @throws InternalErrorException
     */
    public function checkResetPasswordToken($request): string
    {
        // Delete All Token before one hour
        $formatted = Carbon::now()->subMinutes(Constants::TOKEN_VALIDATE_DURATION)
            ->toDateTimeString();
        $this->passwordResetRepository
            ->deleteResetPasswordBeforeTime($formatted);
        $check = $this->passwordResetRepository
            ->getResetPasswordByToken($request->token);
        if ($check) {
            $this->deleteOldToken($check->email);
            return $this->createNewToken($check->email);
        } else {
            throw new InternalErrorException();
        }
    }


    /**
     * @param $request
     * @return string
     * @throws TokenInvalidException
     */
    public function changePassword($request): string
    {
        $passwordReset = $this->passwordResetRepository->getResetPasswordByToken($request->token);

        if (!$passwordReset) {
            throw new TokenInvalidException();
        }

        $user = $this->userRepository->getUserByEmail($request->email);
        $this->userRepository->changePassword($user, $request->password);

        // Delete the token after resetting password
        $this->passwordResetRepository->deleteResetPassword($request->email);

        return ResponseMessage::PASSWORD_RESET_SUCCESS->value;
    }

    public function sendValidationMailToken($request): string
    {
        try {
            $email = $request->email;
            $user = $this->userRepository->getUserByEmail($email);
            $this->deleteOldMailValidationToken($email);
            $token = $this->createNewMailValidationToken($email);

            // Sending Email with Password Reset
            Notification::sendNow($user, new MailValidationNotification($token, $user->name));

            return ResponseMessage::MAIL_VALIDATION_SEND->value;
        } catch (Exception $e) {
            throw new CustomException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param $request
     * @return string
     * @throws ValidationMailException
     */
    public function checkValidationMailToken($request): string
    {
        // Delete All Token before one hour
        $formatted = Carbon::now()->subMinutes(Constants::TOKEN_VALIDATE_DURATION)
            ->toDateTimeString();
        $this->mailValidationRepository
            ->deleteBeforeTime($formatted);
        $check = $this->mailValidationRepository
            ->getByToken($request->token);

        if ($check) {
            $user = $this->userRepository->getUserByEmail($check->email);
            if ($user) {
                $this->userRepository->ValidateMail($user);
                $this->mailValidationRepository->delete($user->email);
                return ResponseMessage::MAIL_VERIFIED->value;
            }
        }
        throw new ValidationMailException();

    }

    private function createNewMailValidationToken($email): int
    {
        // Generate Token
        $token = rand(ConstMailValidationToken::min, ConstMailValidationToken::max);
        $oldToken = $this->mailValidationRepository->getMailValidation($email);
        if ($oldToken) {
            $this->mailValidationRepository->delete($email);
        }

        // Saving Data to Password Reset Table
        $this->mailValidationRepository->create($email, $token);
        return $token;
    }

    private function deleteOldMailValidationToken($email): void
    {
        // Generate Token
        $oldToken = $this->mailValidationRepository->getMailValidation($email);
        if ($oldToken) {
            $this->mailValidationRepository->delete($email);
        }
    }

    public function getCurrentUser()
    {
        return $this->userRepository->getCurrentUser();
    }

    public function me(): Authenticatable|null
    {
        return auth()->user();
    }

    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return array
     */
    public function respondWithToken(string $token): array
    {
        return [
            'user' => auth('api')->user(),
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL()
        ];
    }
}
