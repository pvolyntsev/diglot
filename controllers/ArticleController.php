<?php

namespace app\controllers;

use Yii;

use yii\base\ErrorException;
use yii\filters\AccessControl;
use app\models\Article;
use app\models\Comment;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use app\forms\SearchForm;
use yii\web\Session;
use yii\bootstrap\Alert;
use yii\bootstrap\ActiveForm;
use yii\web\Response;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends Controller
{
    /**
     * @inheritdoc
     */

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create', 'update', 'delete'],
                'rules' => [
                    [
                        // создавать может только авторизованный пользователь
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        // изменять, удалять статьи может только её владелец
                        'actions' => ['update', 'delete'],
                        'allow' => true,
                        //'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $article = $this->findModel(Yii::$app->request->get('id'));
                            if ($article->user_id == Yii::$app->user->id)
                            {
                                return true;
                            }
                            return false;
                        },
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Article models.
     * @return mixed
     */


	public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Article::find()->where('status=:published', [':published'=>'published']),
			//sort
			'sort' => [
				'defaultOrder' => [
					'date_published' => SORT_DESC,
				]
			],
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
	}
	
    /**
     * Displays a single Article model.
     * @param integer $id
     * @return mixed
     */


	public function actionView($id)
    {

        $model = $this->findModel($id);
        $comment = new Comment();

        $comments_selected = new ActiveDataProvider([
            'query' => Comment::find()->limit(4)->where('article_id=:article_id and status=:published', [':article_id' => $id, ':published' => 'published']),
            'pagination' => ['pageSize' => 4],
            'sort' => [
                'defaultOrder' => [
                    'date_created' => SORT_DESC,
                ]
            ],
        ]);

        $comments = new ActiveDataProvider([
            'query' => Comment::find()->where('article_id=:article_id and status=:published', [':article_id' => $id, ':published' => 'published']),
            'pagination' => ['pageSize' => 8],
            'sort' => [
                'defaultOrder' => [
                    'date_created' => SORT_DESC,
                ]
            ],
        ]);

        return $this->render('view', [
            'model' => $model,
            'comments' => $comments,
            'comments_selected' => $comments_selected,
            'comment' => $comment,
        ]);
    }

        public function actionAddComment($id)
    {
        $model = $this->findModel($id);

        $comment = NULL;
        $added = false;
        if (!Yii::$app->user->isGuest)
        {
            $comment = new Comment();

            $comment->user_id = Yii::$app->user->identity->id;
            $comment->article_id = $id;
            $comment->status = 'published';
            $comment->date_created = $comment->behaviors();

            if(Yii::$app->request->isAjax)  // Вот тут мы проверяем если у нас это аякс запрос или нет
            {
                Yii::$app->response->format = Response::FORMAT_JSON;
                $comment->load(Yii::$app->request->post());
                if (Yii::$app->request->post('ajax') == 'addComment') // perform only validate
                {
                    Yii::error('validate');
                    return ActiveForm::validate($comment);
                }

                Yii::error('save');
                if($comment->validate() && $comment->save()) {   // если все хорошо, и валидация прошла успешно сохраняем модель
                    Yii::error('saved');
                    $added = true;
                    $comment->comment = ''; // сбросить текст комментария, чтобы можно было вводить новый комментарий
                } else {
                    Yii::error('not saved');
                    return ActiveForm::validate($comment);   // В случае ошибки валидации выводим ее
                }

                return $this->renderAjax('_AddingCommentForm', ['comment' => $comment, 'added' => $added, 'model' => $model]);
            }
        }

	}

    /**
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Article();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->addFlash('info', 'Статья создана и сохранена');
			return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Article model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     *Поиск в ElasticSearch по полям title_original и title_translate
     * @return searchResult the model ActiveDataProvider with result search
     */
    public function actionSearch()
    {
        $articlesFound = [];
        $searchResult = null;
        if (Yii::$app->request->get('query')) {
            $query = \app\elastic\models\Article::find()->query([
                        "multi_match" => [
                        "fields" => ['title_original', 'title_translate', 'paragraphs_original', 'paragraphs_translate'],
                        "query" => Yii::$app->request->get('query'),
                        "fuzziness" => "AUTO",
                       ]
            ]);
            $articlesFound = $query->column('id'); // gives id need the documents
            $searchResult = new ActiveDataProvider([
                'query' => Article::find()->where(array('id'=>$articlesFound)),
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);
        }
        return $this->render('search', [
            'query' => Yii::$app->request->get('query'),
            'searchResult' => $searchResult,
            'articlesFound' => $articlesFound,
        ]);
    }

}
