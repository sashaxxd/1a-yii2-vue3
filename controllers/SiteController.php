<?php

namespace app\controllers;

use Spatie\Ssr\Engines\V8;
use Spatie\Ssr\Renderer;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
//        $ssr = $this->renderSsr2();
        return $this->render('index',[
//            'ssr' => $ssr
        ]);
    }

    /**
     * рендерим на стороне сервера ssr c помощью класса PHP V8Js
     */
    private function renderSsr()
    {

        $renderer_source = file_get_contents(Yii::getAlias('@app/yii-vue/node_modules/vue-server-renderer/basic.js'));
        $app_source = file_get_contents(Yii::getAlias('@app/web/vue/js/main.js'));

        $v8 = new \V8Js();
        ob_start();


        $v8->executeString('var process = { env: { VUE_ENV: "server", NODE_ENV: "production" }}; this.global = { process: process };');

        $v8->executeString($renderer_source);

        $v8->executeString($app_source);


        $ssr = ob_get_clean();


        return $ssr;
    }
    /**
     * рендерим на стороне сервера ssr c помощью https://github.com/spatie/server-side-rendering
     */
    private function renderSsr2()
    {
        $engine = new V8(new \V8Js());
        $renderer = new Renderer($engine);


        return $renderer
            ->entry(Yii::getAlias('@app/web/vue/js/main.js'))
            ->render();
    }
}
