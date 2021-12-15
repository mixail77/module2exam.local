<?php

namespace App\Controller;

use App\Classes\QueryBuilder;
use App\Classes\Redirect;
use App\Classes\Request;
use App\Exception\QueryBuilderException;
use Delight\Auth\Auth;
use Delight\Auth\AuthError;
use Delight\Auth\InvalidEmailException;
use Delight\Auth\InvalidPasswordException;
use Delight\Auth\Role;
use Delight\Auth\TooManyRequestsException;
use Delight\Auth\UserAlreadyExistsException;
use Intervention\Image\ImageManager;
use League\Plates\Engine;
use League\Plates\Extension\Asset;
use SimpleMail;
use Tamtamchik\SimpleFlash\Flash;
use RuntimeException;

class BaseController
{

    const STATUS_DEFAULT = 4;
    const PHOTO_TYPE = ['jpg', 'jpeg', 'png', 'gif'];

    public QueryBuilder $query;
    public Auth $auth;
    public Engine $engine;
    public Flash $flash;
    public SimpleMail $mail;
    public Redirect $redirect;
    public Request $request;

    public function __construct(
        QueryBuilder $query,
        Auth         $auth,
        Engine       $engine,
        Asset        $asset,
        Flash        $flash,
        SimpleMail   $mail,
        Redirect     $redirect,
        Request      $request
    )
    {

        $this->query = $query;
        $this->mail = $mail;
        $this->auth = $auth;
        $this->engine = $engine;
        $this->flash = $flash;
        $this->redirect = $redirect;
        $this->request = $request;

        $this->engine->loadExtension($asset);

    }

    /**
     * Проверяет авторизацию пользователя
     * @return bool
     */
    public function isAuth()
    {

        if ($this->auth->isLoggedIn()) {

            return true;

        }

        return false;

    }

    /**
     * Проверяет роль пользователя (администратор)
     * @return bool
     */
    public function isAdmin()
    {

        if ($this->auth->hasRole(Role::ADMIN)) {

            return true;

        }

        return false;

    }

    /**
     * Проверяет владельца профиля
     * @param $id
     * @return bool
     */
    public function isMyProfile($id)
    {

        if ($this->auth->getUserId() == $id) {

            return true;

        }

        return false;

    }

    /**
     * Проверяет доступ к профилю пользователя
     * @param $id
     * @return bool
     */
    public function checkAccessProfile($id)
    {

        if ($this->isAdmin() || $this->isMyProfile($id)) {

            return true;

        }

        return false;

    }

    /**
     * Проверяет доступ к ресурсам
     * @param $type
     * @return void
     */
    public function checkAccess($type = 'member')
    {

        //Если тип пользователя гость и авторизован
        if ($type == 'guest' && $this->isAuth()) {

            $this->redirect->redirectTo('/users/');

        }

        //Если тип пользователя участник и не авторизован
        if ($type == 'member' && !$this->isAuth()) {

            $this->redirect->redirectTo();

        }

    }

    /* Регистрация */

    /**
     * Регистрирует нового пользователя
     * @return array
     * @throws AuthError
     */
    protected function createUser($email, $password)
    {

        try {

            $userId = $this->auth->register($email, $password, '', function ($selector, $token) use ($email) {

                //Отправляем ссылку на подтверждение
                $this->sendConfirm($selector, $token, $email);
            });

            //Добавляем профиль пользователя
            $profileId = $this->createProfile($userId);

            return [
                'user' => $userId,
                'profile' => $profileId,
            ];

        } catch (InvalidEmailException $exception) {

            $this->flash->error('Ошибка. Неверный E-mail');

        } catch (InvalidPasswordException $exception) {

            $this->flash->error('Ошибка. Неверный пароль');

        } catch (UserAlreadyExistsException $exception) {

            $this->flash->error('Ошибка. Пользователь уже существует');

        } catch (TooManyRequestsException $exception) {

            $this->flash->error('Ошибка. Слишком много запросов');

        }

        return false;

    }

    /**
     * Отправляет ссылку для подтверждения регистрации пользователя
     * @return bool
     */
    private function sendConfirm($selector, $token, $email)
    {

        try {

            $confirmUrl = 'http://' . $this->request->getServer('SERVER_NAME') . '/confirm/?selector=' . $selector . '&token=' . $token;
            $message = 'Подтверждение регистрации: ' . $confirmUrl;

            $this->mail->setTo($email, $email);
            $this->mail->setFrom('confirm@yandex.ru', 'confirm@yandex.ru');
            $this->mail->setSubject('Подтверждение регистрации');
            $this->mail->setMessage($message);
            $this->mail->send();

            return true;

        } catch (RuntimeException $exception) {

            $this->flash->error('Ошибка. Не отправлено письмо для активации учетной записи');

        }

        return false;

    }

    /**
     * Создает профиль пользователя
     * @return bool
     */
    private function createProfile($userId)
    {

        try {

            return $this->query->create('profile', [
                'user_id' => $userId,
                'status_id' => self::STATUS_DEFAULT,
            ]);

        } catch (QueryBuilderException $exception) {

            $this->flash->error('Ошибка. Не создан профиль пользователя');

        }

        return false;

    }

    /* Фотография */

    /**
     * Проверяет загруженную фотографию
     * @param $arPhoto
     * @return bool
     */
    public function mediaValidator($arPhoto)
    {

        if (empty($arPhoto) || $arPhoto['error'] !== 0) {

            return false;

        } else {

            //Тип файла
            $arExtension = pathinfo($arPhoto['name'], PATHINFO_EXTENSION);

            if (!in_array($arExtension, self::PHOTO_TYPE)) {

                return false;

            }

        }

        return true;

    }

    /**
     * Загружает и сохраняет новую фотографию
     * @param $arPhoto
     * @return string
     */
    public function addPhoto($arPhoto)
    {

        $manager = new ImageManager(['driver' => 'imagick']);
        $image = $manager->make($arPhoto['tmp_name']);

        $photoPath = '/upload/photo/' . mb_strtolower(mt_rand(0, 10000) . $arPhoto['name']);

        $image->save($_SERVER['DOCUMENT_ROOT'] . '/public/' . $photoPath);

        return $photoPath;

    }

}