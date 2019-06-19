<?php

class Application extends Config {

    private $routingRules = [
        'Application' => [
            'index' => 'Application/actionIndex'
        ],
        'robots.txt' => [
            'index' => 'Application/actionRobots'
        ],
        'debug' => [
            'index' => 'Application/actionDebug'
        ]
    ];

    /**
     * @var $view View
     */
    private $view;

    function __construct() {
        parent::__construct();
        $this->view = new View($this);
        if ($this->requestMethod == 'POST') {
            header('Content-Type: application/json');
            die(json_encode($this->ajaxHandler($_POST)));
        } else {
            //Normal GET request. Nothing to do yet
        }
    }

    public function run() {
        if (array_key_exists($this->routing->controller, $this->routingRules)) {
            if (array_key_exists($this->routing->action, $this->routingRules[$this->routing->controller])) {
                list($controller, $action) = explode(DIRECTORY_SEPARATOR, $this->routingRules[$this->routing->controller][$this->routing->action]);
                call_user_func([$controller, $action]);
            } else { http_response_code(404); die('action not found'); }
        } else { http_response_code(404); die('controller not found'); }
    }

    public function actionIndex() {
        return $this->view->render('index');
    }

    public function actionDebug() {
        return $this->view->render('debug');
    }

    public function actionRobots() {
        return implode(PHP_EOL, ['User-Agent: *', 'Disallow: /']);
    }


    public function actionFormSubmit($data) {
      $out = [];
      $errors = [];

      foreach($data as $value) {
        $out[$value['name']] = $value['value'];  
      }

      $name = trim($out['name']);
      $phone = trim(filter_var($out['phone']), FILTER_SANITIZE_NUMBER_INT);
      $email = trim(filter_var($out['email'], FILTER_SANITIZE_EMAIL));
      $comment = trim($out['comment']);
      
      switch ($name) {
        case (strlen($name) < 1): $errors['name'] = 'Ім"я задовге';
          break;
        case (strlen($name) > 64): $errors['name'] = 'Ім"я закоротке';
          break;
        case (!strip_tags($name)): $errors['name'] =  'Теги не допустимі' ;
          break;
        case (!preg_match("/^[a-zA-Z ]*$/",$name)): $errors['name'] = 'Символи та цифри не допустимі';
          break;
      }

      switch ($phone) {
        case (strlen($phone) > 16): $errors['phone'] =  'Номер закороткий';
          break;
      }

      switch ($email) {
        case ( preg_match("~^([a-z0-9_\-\.])+@([a-z0-9_\-\.])+\.([a-z0-9])+$~i", $email) ): $errors['email'] =  'E-mail вказано невірно' ;
          break;
      }

      switch ($comment) {
        case (strlen($comment) < 2): $errors['comment'] =  'Коментар має бути меншим за 25 символів' ;
          break;
        case (strlen($comment) > 25): $errors['comment'] =  'Коментар має бути меншим за 25 символів' ;
          break;
        case (!strip_tags($comment)): $errors['comment'] =  'Теги не допустимі' ;
          break;
      }



      if(!empty($errors['1'])) {
        return ['result' => count($errors) === 1 , 'error' => $errors];
      } else{
          return ['result' => count($errors) === 0, 'error' => $errors];
      }

    }   

    /**
     * Функция обработки AJAX запросов
     * @param $post
     * @return array
     */
    private function ajaxHandler($post) {
        if (count($post)) {
            if (isset($post['method'])) {
                switch($post['method']) {
                    case 'formSubmit': $result = $this->actionFormSubmit($post['data']);
                        break;
                    default: $result = ['error' => 'Unknown method']; break;
                }
            } else { $result = ['error' => 'Unspecified method!']; }
        } else { $result = ['error' => 'Empty request!']; }
        return $result;
    }
}
