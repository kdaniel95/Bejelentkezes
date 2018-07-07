<?php

class BejelentkeztetesController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    function index() {
        if ($_POST) {
            $this->loadModel('user');
            
            $this->model->userFeltolt($_POST['fnev']);
            echo $this ->model->sikertelen;

            if ($this->kellECaptcha()) {
                $this->setCaptcha(true);
                $this->bejelentkezesCaptchaval();
            } else {
                if ($this->model->fid == -1) {
                    $this->sikertelenBejelentkezes();
                } else {
                    $this->setCaptcha(false);
                    $this->bejelentkezes();
                }
            }
        } else {
            $this->view->render("index/index");
        }
    }

    private function bejelentkezes() {
        $pw_plaintext = $_POST['jelszo'];
        $pw_hash = $this->model->jelszo_hash;

        if (password_verify($pw_plaintext, $pw_hash)) {
            $this->model->mentLog($_POST['fnev'], $_SERVER['REMOTE_ADDR'], 1);
            $this->model->setUtBejelDatum($_POST['fnev']);

            $userinfo = $this->model -> user_infok();
            $_SESSION['loggedin'] = true;
            $_SESSION['userinfo'] = $userinfo;
            Helper::redirect('felulet/');
            exit;
        } else {
            $this->sikertelenBejelentkezes();
        }
    }

    private function bejelentkezesCaptchaval() {
        $recaptcha = new ReCaptcha('6LezWCgUAAAAAIp9p3_oqG124u0ej6q8JEFI_me8');

        $response = null;

        $post_response = isset($_POST['g-recaptcha-response']) ? $_POST['g-recaptcha-response'] : null;

        $response = $recaptcha->verifyResponse($_SERVER['REMOTE_ADDR'], $post_response);

        if ($response != null && $response->success) {
            $this->bejelentkezes();
        } else {
            $this->view->render("index/index");
        }
    }

    private function kellECaptcha() {
        $this->model->setSikertelen($_POST['fnev'], $_SERVER['REMOTE_ADDR']);
        return $this->model->sikertelen>=3;
    }

    private function setCaptcha($b) {
        $this->view->data(['withCaptcha' => $b]);
    }

    private function sikertelenBejelentkezes() {
        $this->model->mentLog($_POST['fnev'], $_SERVER['REMOTE_ADDR'], 0);
        Helper::redirect("./");
    }

}
