<?php

namespace app\controllers;

use Yii;

use app\models\Article;
use app\models\Comment;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;

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
            'query' => Article::find(),
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

        $comment->user_id = Yii::$app->user->identity->id;
        $comment->article_id = $id;
        $comment->status = 'published';
//        $comment->date_created=Yii::$app->formatter->asTimestamp(date('Y-d-m h:i:s'));aa
        $comment->date_created=$comment->behaviors();

 //       var_dump($comment->load($_POST));//true
 //       var_dump($comment->save());//false

//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        if ($comment->load($_POST) && $comment->save()){
//          return $this->redirect([$entity.'-'.$mode, 'id' => $model->id]); // TODO goto to the article
            //return $this->render($entity.'-'.$mode, $data);
        }

        $comments_selected = new ActiveDataProvider([
            'query' => Comment::find()->limit(4)->where('article_id=:article_id and status=:published', [':article_id' => $id,':published'=>'published']),
            'pagination' => ['pageSize' => 4],
            'sort' => [
				'defaultOrder' => [
					'date_created' => SORT_DESC,
				]
			],
        ]);

        $comments = new ActiveDataProvider([
            'query' => Comment::find()->where('article_id=:article_id and status=:published', [':article_id' => $id,':published'=>'published']),
            'pagination' => ['pageSize' => 8],
            'sort' => [
                'defaultOrder' => [
                    'date_created' => SORT_DESC,
                ]
            ],
        ]);
        
        ///////////////////////////////////////////////////////////////////////
//        $query =  Comment::find()->where('article_id=:article_id and status=:published', [':article_id' => $id,':published'=>'published']);
//        $countQuery = clone $query;
//        $pages = new Pagination(['totalCount' => $countQuery->count()]);
//        $models = $query->offset($pages->offset)
//            ->limit($pages->limit)
//            ->all();
        /////////////////////////////////////////////////////////////////////////

        ////////////////////////////////////////////////////////////// trying to use listview
//        $dataProvider = new CActiveDataProvider('Comment', array(
//            //Критерий для запроса. В этом примере, выбираются все опублкованные комментарии
//            'criteria'=>array('article_id'=> 'published'),
//            //Настройки для постраничной навигации
//            'pagination'=>array(
//                //Количество отзывов на страницу
//                'pageSize'=>5,
//                'pageVar'=>'view',
//            ),
//            //Настройки для сортировки
//            'sort'=>array(
//                //атрибуты по которым происходит сортировка
//                'attributes'=>array(
//                    'date_created'=>array(
//                        'asc'=>'created_at ASC',
//                        'desc'=>'created_at DESC',
//                        'default'=>'desc',
//                    )
//                ),
//                /** После того, как будет загружена страница с виджетом,
//                 * сортировка будет происходить по этому параметру.
//                 * Если указан defaultOrder, то задается стиль для атрибута, по которому происходит сортировка.
//                 * В данном случае у created_at будет class="desc".
//                 */
//                'defaultOrder'=>array(
//                    'date_created'=>CSort::SORT_DESC,
//                )
//            ),
//        ));
        ///////////////////////////////////////////////////////////////

        return $this->render('view', [
            'model' => $model,
            'comments' => $comments,
            'comments_selected'=>$comments_selected,
            'comment' => $comment,
//            'dataProvider'=>$dataProvider,
//        'models'=>$models,
//            'pages'=>$pages,
        ]);
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
}
