<?php

class PostController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
{
    return array(
        array('allow',  // Allow all users to perform 'index' and 'view' actions
            'actions'=>array('index', 'view', 'tag'),
            'users'=>array('*'),
        ),
        array('allow', // Allow authenticated users to perform create and update actions
            'actions'=>array('create','update'),
            'users'=>array('admin'),
        ),
        array('allow', // Allow admin user to perform 'admin' and 'delete' actions
            'actions'=>array('admin','delete'),
            'users'=>array('admin'),
        ),
        array('deny',  // Deny all users by default
            'users'=>array('*'),
        ),
    );
}





	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
{
    $model = $this->loadModel($id);
    
    // Initialize a new comment
    $comment = new Comment;

    // Check if a comment is being submitted
    if (isset($_POST['Comment'])) {
        $comment->attributes = $_POST['Comment'];
        $comment->post_id = $model->id;
        $comment->author = Yii::app()->user->name; // Fetch the logged-in username

        // Fetch the logged-in user's email from the User model
        $user = User::model()->findByPk(Yii::app()->user->id); // Assuming user ID is stored in Yii::app()->user->id
        if ($user) {
            $comment->email = $user->email; // Get email from the user model
        }

        // For regular users, comments are unapproved by default (status = 0), while admin comments are auto-approved
        if (Yii::app()->user->isAdmin()) {
            $comment->status = 1; // Automatically approve comments from admin
        } else {
            $comment->status = 0; // Set comment status to pending (e.g., unapproved)
        }

        $comment->create_time = time();

        if ($comment->save()) {
            Yii::app()->user->setFlash('commentSubmitted', 'Your comment has been submitted and is awaiting approval.');
            $this->refresh(); // Prevent form resubmission
        }
    }

    // Render the view with the post and comment form
    $this->render('view', array(
        'model' => $model,
        'comment' => $comment, // Pass the comment model to the view
    ));
}






	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Post;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Post']))
		{
			$model->attributes=$_POST['Post'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Post']))
		{
			$model->attributes=$_POST['Post'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
{
    $criteria = new CDbCriteria;
    $criteria->addCondition('status = 1'); // Only fetch published posts (status = 1)

    $dataProvider = new CActiveDataProvider('Post', array(
        'criteria' => $criteria,
    ));

    $this->render('index', array(
        'dataProvider' => $dataProvider,
		
    ));
}


	/**
	 * Manages all models.
	 */
	public function actionAdmin()
{
    $model = new Post('search');
    $model->unsetAttributes();  // clear any default values

    if (isset($_GET['Post'])) {
        $model->attributes = $_GET['Post'];
    }

    $criteria = new CDbCriteria;

    // Only allow admin to filter by status
    if (Yii::app()->user->isAdmin()) {
        if (isset($_GET['status'])) {
            $criteria->addCondition('status = :status');
            $criteria->params[':status'] = $_GET['status'];
        } else {
            // Show all statuses (draft, published, archived) for admin by default
            $criteria->addInCondition('status', array(0, 1, 2));
        }
    } else {
        // Non-admin users can only see published posts
        $criteria->addCondition('status = 1');
    }

    $model->setDbCriteria($criteria);

    $this->render('admin', array(
        'model' => $model,
    ));
}

public static function getRecentComments($limit = 5)
{
    return Comment::model()->findAll(array(
        'order' => 'create_time DESC',
        'limit' => $limit,
    ));
}



	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Post the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Post::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Post $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='post-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionPublish($id)
{
    $post = $this->loadModel($id);
    $post->status = 1; // Assuming 1 is for Published
    if ($post->save()) {
        Yii::app()->user->setFlash('success', 'Post published successfully.');
    }
    $this->redirect(array('admin'));
}

public function actionUnpublish($id)
{
    $post = $this->loadModel($id);
    $post->status = 0; // Assuming 0 is for Unpublished
    if ($post->save()) {
        Yii::app()->user->setFlash('success', 'Post unpublished successfully.');
    }
    $this->redirect(array('admin'));
}

public function actionArchive($id)
{
    $post = $this->loadModel($id);
    $post->status = 2; // Assuming 2 is for Archived
    if ($post->save()) {
        Yii::app()->user->setFlash('success', 'Post archived successfully.');
    }
    $this->redirect(array('admin'));
}

public function actionTag($tag)
{
    // Create a criteria to filter posts by the given tag
    $criteria = new CDbCriteria;
    $criteria->addSearchCondition('tags', $tag);

    // Fetch posts that match the tag
    $dataProvider = new CActiveDataProvider('Post', array(
        'criteria' => $criteria,
    ));

    // Render the index view with filtered posts
    $this->render('index', array(
        'dataProvider' => $dataProvider,
    ));
}





}
