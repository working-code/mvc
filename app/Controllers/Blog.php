<?php

namespace App\Controllers;

use App\Core\MainController;
use App\Models\Admin;
use App\Models\Message;
use SplFileInfo;
use Imagick;

class Blog extends MainController
{
    public function index()
    {
        if (!$this->session->getUserId()) {
            $this->redirect('/user/login');
        }

        $message = new Message();
        $messages = $message->getMessages();

        $user = (new Admin())->getById($this->session->getUserId());
        $pathTemplate = 'blogIndex';
        if ($user->isAdmin()) {
            $pathTemplate = 'blogAdminIndex';
        }

        return $this->view->render($pathTemplate, ['messages' => $messages]);
    }

    public function messageAdd()
    {
        $messageText = $_POST['message'] ?? '';

        if ($messageText) {
            $message = (new Message())
                ->setMessage($messageText)
                ->setImgSrc($this->checkImgFromPost($_FILES['file']) ?? '')
                ->setUserId($this->session->getUserId())
                ->setDate(date("Y-m-d H:i:s"));
            $message->save();
        }
        $this->redirect('/user/blog');
    }

    private function checkImgFromPost(array $fileFromForm)
    {
        $nameFile = '';
        if ($fileFromForm['error'] === UPLOAD_ERR_OK) {
            $fileExtension = (new SplFileInfo($fileFromForm['name']))->getExtension();
            if ($fileExtension) {
                $nameFile = $this->session->getUserId() . '_' . md5(time()) . '.' . $fileExtension;
            }
        }

        $pathImg = IMG_DIR . DIRECTORY_SEPARATOR . $nameFile;
        if ($nameFile && move_uploaded_file($fileFromForm['tmp_name'], $pathImg)) {
            $image = new Imagick($pathImg);
            if ($image->adaptiveResizeImage(700, 700, true)) {
                if (file_put_contents($pathImg, $image)) {
                    return $nameFile;
                }
            }
        }
        return null;
    }

    public function getimg()
    {
        $nameFile = $_GET['img'];
        if ($nameFile) {
            $pathImg = IMG_DIR . DIRECTORY_SEPARATOR . $nameFile;
            header("Content-Type: {mime_content_type($pathImg)}");
            echo file_get_contents($pathImg);
        }
    }

    public function getMessage()
    {
        $id = $_GET['id'];
        $message = new Message();
        $data = $message->getMessagesForUserId($id);
        echo json_encode($data);
    }

    public function deleteMessage()
    {
        $id = $_GET['id'];
        $message = new Message();
        $message->deleteMessageForId($id);
        $this->redirect('/blog/index');
    }
}
