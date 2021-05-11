<?php

namespace App\Controllers;

use App\Core\MainController;
use App\Models\Admin as UserModel;

class User extends MainController
{
    public function login()
    {
        if ($this->session->getUserId()) {
            $this->redirect('/user/profile');
        }

        $email = filter_var($_REQUEST['email'] ?? null, FILTER_VALIDATE_EMAIL);
        $password1 = $_REQUEST['password1'] ?? null;

        $checkInputData = true;
        if ($_POST) {
            if (!$email) {
                $this->view->addData('errorMessage', 'Введен не корректный email');
                $checkInputData = false;
            }

            if (empty($password1)) {
                $this->view->addData('errorMessage', 'Введите пароль');
                $checkInputData = false;
            }
        }

        if ($checkInputData) {
            $user = new UserModel();
            $user = $user->getByEmail($email);
            if ($user) {
                if ($user->getEmail() == $email && $user->getPassword() == User::hashPassword($password1)) {
                    $this->session->setUserId($user->getId());
                    $this->redirect('/user/profile');
                }
                $this->view->addData('errorMessage', 'Неверно введен email или пароль');
            }
        }

        return $this->view->render('userLogin');
    }

    public function logout()
    {
        $this->session->unsetUserId();
        $this->redirect('/user/login');
    }

    public function register()
    {
        if ($this->session->getUserId()) {
            $this->redirect('/user/profile');
        }
        $email = filter_var($_REQUEST['email'] ?? null, FILTER_VALIDATE_EMAIL);
        $name = $_REQUEST['name'] ?? null;
        $password1 = $_REQUEST['password1'] ?? null;
        $password2 = $_REQUEST['password2'] ?? null;
        $checkInputData = true;

        if ($_POST) {
            if (!$email) {
                $this->view->addData('errorMessage', 'Введен не корректный email');
                $checkInputData = false;
            }

            if (!empty($password1) && mb_strlen($password1) < 4) {
                $this->view->addData('errorMessage', 'Длина пароля должна быть более 4-х символов');
                $checkInputData = false;
            }

            if (!empty($password1) && !empty($password2) && $password1 !== $password2) {
                $this->view->addData('errorMessage', 'Пароли не совпадают');
                $checkInputData = false;
            }
            if (!$name) {
                $this->view->addData('errorMessage', 'Введите имя');
                $checkInputData = false;
            }
        } else {
            $checkInputData = false;
        }

        if ($checkInputData) {
            $user = (new UserModel())
                ->setName($name)
                ->setDateRegistration(date("Y-m-d H:i:s"))
                ->setPassword(User::hashPassword($password1))
                ->setEmail($email);

            $user->save();
            $this->setUser($user);
            $this->session->setUserId($user->getId());

            $this->redirect('/user/profile');
        }


        return $this->view->render('userRegister');
    }

    public function profile()
    {
        if (!$this->session->getUserId()) {
            $this->redirect('/user/login');
        }
        $user = (new UserModel())->getById($this->session->getUserId() ?? 0);
        $data = [];
        if ($user) {
            $data = [
                'id' => $user->getId(),
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'date_register' => $user->getDateRegistration()
            ];
        }
        return $this->view->render(
            'userProfile',
            ['user' => $data]
        );
    }

    public static function hashPassword(string $password): string
    {
        return sha1('&^$ga' . $password . '8Ld!');
    }
}
