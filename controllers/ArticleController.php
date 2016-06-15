<?php

namespace app\controllers;

use Yii;

use yii\base\ErrorException;
use yii\filters\AccessControl;
use app\models\Article;
use app\models\Comment;
use app\models\Paragraph;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use yii\web\Session;
use yii\bootstrap\Alert;
use yii\bootstrap\ActiveForm;
use yii\web\Response;
use yii\helpers\Html;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends Controller
{	/**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create', 'update', 'delete', 'view'],
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
					[
					// смотреть черновики draft может только владелец
                        'actions' => ['view'],
                        'allow' => true,
                        //'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $article = $this->findModel(Yii::$app->request->get('id'));
							if (Article::STATUS_DRAFT !== $article->status) {
								return true;
							} else {
								if ( (!Yii::$app->user->isGuest) && ($article->user_id == Yii::$app->user->identity->id) )
								{
									return true;
								}
								return false;
							}
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
            'query' => Article::find()->where('status=:published', [':published'=>Article::STATUS_PUBLISHED]),
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
        $this->layout = 'article';
        $model = $this->findModel($id);
        $this->view->params['article'] = $model;

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
            'pagination' => [
                'defaultPageSize' => 10,
                'pageSize' => 10,
            ],
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
                if (Yii::$app->request->post('ajax') == 'addComment') // выполнить только валидацию и вернуть результат валидации
                {
                    return ActiveForm::validate($comment);
                }

                if($comment->validate() && $comment->save()) { // выполнить валидацию и сохранить модель
                    $added = true;
                    $comment->comment = ''; // сбросить текст комментария, чтобы можно было вводить новый комментарий
                } else {
                    return ActiveForm::validate($comment);   // в случае ошибки вернуть результат валидации или сохранения
                }

                return $this->renderAjax('_AddingCommentForm', [
                    'comment' => $comment,
                    'added' => $added,
                    'article' => $model
                ]);
            }
        }
    }

    public function actionDeleteComment($id)
    {
//        $model=$this->findModel($id_article);
        $deleted = false;
        $comment=Comment::findOne($id);

        if (Yii::$app->request->isAjax)  // Вот тут мы проверяем если у нас это аякс запрос или нет
        {
            if($comment!=null)
            {
                $comment->delete();
//                Yii::error('comment is deleted');
            }
//            else
//            {
//                throw new NotFoundHttpException('The requested page does not exist.');
//            }
        }
        else
        {
//            Yii::error('comment is not deleted');
        }
//        return $this->renderAjax('_comment', [
//            'comment' => $comment,
//        ]);
    }

    /**
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Article();
        $this->view->params['article'] = $model;

        $model->user_id = Yii::$app->user->identity->id;
        $model->own_original = 0;
        $model->own_translate = 0;

        $paragraphs = $model->paragraphs;
        $this->view->params['article'] = $model;

        if (!is_null(Yii::$app->request->post('store')))
            $model->status = Article::STATUS_DRAFT;
        if (!is_null(Yii::$app->request->post('publish')))
            $model->status = Article::STATUS_PUBLISHED;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $paragraphs = $model->updateParagraphs($_POST['Article']['paragraphs']);

            if ($model->status == 'draft')
                Yii::$app->session->addFlash('info', 'Article is saved to ' . Html::a('drafts', ['/author-private/drafts']));
            else
                Yii::$app->session->addFlash('info', 'Article is ' . Html::a('published', ['/article/view', 'id' => $model->id]));

            return $this->redirect(['update', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
            'paragraphs' => $paragraphs,
        ]);
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
        $paragraphs = $model->paragraphs;
        $this->view->params['article'] = $model;

        if (!is_null(Yii::$app->request->post('store')))
            $model->status = Article::STATUS_DRAFT;
        if (!is_null(Yii::$app->request->post('publish')))
            $model->status = Article::STATUS_PUBLISHED;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $paragraphs = $model->updateParagraphs($_POST['Article']['paragraphs']);

            if ($model->status == 'draft')
                Yii::$app->session->addFlash('info', 'Article is saved to ' . Html::a('drafts', ['/author-private/drafts']));
            else
                Yii::$app->session->addFlash('info', 'Article is ' . Html::a('published', ['/article/view', 'id' => $model->id]));

            #return $this->redirect(['view', 'id' => $model->id]);
            #exit;
        }
        return $this->render('update', [
            'model' => $model,
            'paragraphs' => $paragraphs,
        ]);
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
     * Поиск статей через ElasticSearch
     */
    public function actionSearch()
    {
        $articlesFound = [];
        $searchResult = null;
        if (Yii::$app->request->get('query')) {
            try
            {
                $query = \app\elastic\models\Article::find()->query([
                        "multi_match" => [
                        "fields" => ['title_original', 'title_translate', 'paragraphs_original', 'paragraphs_translate'],
                        "query" => Yii::$app->request->get('query'),
                        "fuzziness" => "AUTO",
                       ]
                ]);
                $articlesFound = $query->column('id'); // gives id need the documents
            } catch(\yii\elasticsearch\Exception $e)
            {
                Yii::error('Error searching articles with ElasticSearch: '.$e, 'accessElastic');
                $articlesFound = []; // Nothing found due to ElasticSearch problems
            }

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
