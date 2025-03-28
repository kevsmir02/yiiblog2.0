<?php

class CommentController extends Controller
{
    public $layout = '//layouts/column2';

    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',  // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated users to create comments
                'actions' => array('create'),
                'users' => array('@'),
            ),
            array('allow', // allow admin users to approve, reject, and delete comments
                'actions' => array('admin', 'delete', 'approve', 'reject'),
                'users' => array('admin'),
            ),
            array('deny',  // deny all other users
                'users' => array('*'),
            ),
        );
    }

    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionCreate()
    {
        $model = new Comment;

        if (isset($_POST['Comment'])) {
            $model->attributes = $_POST['Comment'];
            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if (isset($_POST['Comment'])) {
            $model->attributes = $_POST['Comment'];
            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id)
{
    $comment = $this->loadModel($id);
    $postId = $comment->post_id; // Save the post ID before deleting

    // Delete the comment
    $comment->delete();

    // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
    if(!isset($_GET['ajax'])) {
        // Redirect to the post's view page after deleting
        $this->redirect(array('post/view', 'id' => $postId));
    }
}


    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('Comment');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionAdmin()
    {
        $model = new Comment('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Comment'])) {
            $model->attributes = $_GET['Comment'];
        }

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionApprove($id)
    {
        $comment = $this->loadModel($id);
        $comment->status = 1; // Set comment to approved
        $comment->save();
        $this->redirect(array('post/view', 'id' => $comment->post_id));
    }

    public function actionReject($id)
    {
        $comment = $this->loadModel($id);
        $comment->delete(); // Alternatively, set a rejected status if desired
        $this->redirect(array('post/view', 'id' => $comment->post_id));
    }

    public function loadModel($id)
    {
        $model = Comment::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'comment-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
