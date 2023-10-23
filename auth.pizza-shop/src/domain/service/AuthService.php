<?php

namespace pizzashop\auth\api\domain\service;

use DateTime;
use DomainException;
use Exception;
use pizzashop\auth\api\app\auth\managers\JwtManager;
use pizzashop\auth\api\app\auth\providers\AuthProvider;
use pizzashop\auth\api\domain\dto\CredentialsDTO;
use pizzashop\auth\api\domain\dto\TokenDTO;
use pizzashop\auth\api\domain\dto\UserDTO;
use pizzashop\auth\api\domain\entities\Users;
use pizzashop\auth\api\domain\exception\ActivationTokenExpiredException;
use pizzashop\auth\api\domain\exception\AuthServiceExpiredTokenException;
use pizzashop\auth\api\domain\exception\AuthServiceInvalideDonneeException;
use pizzashop\auth\api\domain\exception\AuthServiceInvalideTokenException;
use pizzashop\auth\api\domain\exception\InvalidActivationTokenException;
use pizzashop\auth\api\domain\exception\JwtExpiredException;
use pizzashop\auth\api\domain\exception\JwtInvalidException;
use pizzashop\auth\api\domain\exception\RefreshUtilisateurException;
use pizzashop\auth\api\domain\exception\SignInException;

class AuthService implements AuthServiceInterface {
    private JwtManager $jwtManager;
    private AuthProvider $authProvider;

    public function __construct(JwtManager $jwtManager, AuthProvider $authProvider) {
        $this->jwtManager = $jwtManager;
        $this->authProvider = $authProvider;
    }

    /**
     * @inheritDoc
     */
    public function signup(CredentialsDTO $credentialsDTO): UserDTO {
        try {
            $activationToken = bin2hex(random_bytes(32));
            $refreshToken = bin2hex(random_bytes(32));
            $resetPasswordToken = bin2hex(random_bytes(32));

            // Créer un nouvel utilisateur avec les informations de CredentialsDTO
            $user = new Users();
            $user->email = $credentialsDTO->email;
            $user->password = password_hash($credentialsDTO->password, PASSWORD_BCRYPT);
            $user->username = $credentialsDTO->username;
            $user->active = false;
            $user->activation_token = $activationToken;
            $user->activation_token_expiration_date = (new DateTime())->format('Y-m-d H:i:s');
            $user->refresh_token = $refreshToken;
            $user->refresh_token_expiration_date = (new DateTime())->format('Y-m-d H:i:s');
            $user->reset_password_token = $resetPasswordToken;
            $user->reset_password_token_expiration_date = (new DateTime())->format('Y-m-d H:i:s');
            $user->save();

            // Retourner un objet UserDTO avec les trois jetons générés
            return new UserDTO(
                $user->email,
                $user->username,
            );
        } catch (Exception $e) {
            // Gérer les exceptions, par exemple, en lançant une exception personnalisée
            throw new AuthServiceInvalideDonneeException();
        }
    }

    /**
     * @inheritDoc
     */
    public function signin(CredentialsDTO $credentialsDTO): TokenDTO {
        $this->authProvider->checkCredentials($credentialsDTO->email,$credentialsDTO->password);
        return $this->authProvider->genToken($this->authProvider->getUser($credentialsDTO->email,''), $this->jwtManager);
    }

    /**
     * @inheritDoc
     */
    public function validate(TokenDTO $tokenDTO): UserDTO {
        try {
        $payload = $this->jwtManager->validate($tokenDTO->jwt);
        }catch (JwtExpiredException $e){
            throw new AuthServiceExpiredTokenException;
        }catch (JwtInvalidException | DomainException $e) {
            throw new AuthServiceInvalideTokenException;
        }
        return new UserDTO($payload->upr->email, $payload->upr->username);
    }

    /**
     * @inheritDoc
     */
    public function refresh(TokenDTO $tokenDTO): TokenDTO {
        $this->authProvider->checkToken($tokenDTO->refreshToken);
        return $this->authProvider->genToken($this->authProvider->getUser('',$tokenDTO->refreshToken), $this->jwtManager);
    }

    /**
     * @inheritDoc
     */
    public function activate_signup(TokenDTO $tokenDTO): void {
        // Récupérez l'utilisateur associé au jeton d'activation
        $user = Users::where('activation_token', $tokenDTO->activationToken)->firstOrFail();

        if ($user && !$user->active) {
            $now = new DateTime();
            $tokenExpDate = new DateTime($user->activation_token_expiration_date);

            if ($tokenExpDate > $now) {
                // Le jeton d'activation est valide, activez le compte de l'utilisateur
                $user->active = true;
                $user->save();
            } else {
                throw new ActivationTokenExpiredException();
            }
        } else {
            throw new InvalidActivationTokenException();
        }
    }

    /**
     * @inheritDoc
     */
    public function reset_password(TokenDTO $tokenDTO, CredentialsDTO $credentialsDTO): void {
        // TODO: Implement reset_password() method.
    }
}