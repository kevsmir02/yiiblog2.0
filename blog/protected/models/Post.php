<?php

/**
 * This is the model class for table "{{post}}".
 *
 * The followings are the available columns in table '{{post}}':
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property string $tags
 * @property integer $status
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $author_id
 *
 * The followings are the available model relations:
 * @property Comment[] $comments
 * @property User $author
 */
class Post extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{post}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, content, status, author_id', 'required'),
			array('status, create_time, update_time, author_id', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>128),
			array('tags', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, content, tags, status, create_time, update_time, author_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'comments' => array(self::HAS_MANY, 'Comment', 'post_id'),
			'author' => array(self::BELONGS_TO, 'User', 'author_id'),
			'latestComment' => array(self::HAS_ONE, 'Comment', 'post_id', 'order' => 'latestComment.create_time DESC'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'content' => 'Content',
			'tags' => 'Tags',
			'status' => 'Status',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'author_id' => 'Author',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
{
    // @todo Please modify the following code to remove attributes that should not be searched.
    $criteria = new CDbCriteria;

    $criteria->compare('id', $this->id);
    $criteria->compare('title', $this->title, true);
    $criteria->compare('content', $this->content, true);
    $criteria->compare('tags', $this->tags, true);
    
    // Include all posts regardless of their status (published, unpublished, archived)
    $criteria->compare('status', $this->status);
    
    // If you want archived posts to be displayed in the "Manage Posts" view,
    // make sure to remove any condition that explicitly excludes archived posts (status = 2).

    return new CActiveDataProvider($this, array(
        'criteria' => $criteria,
    ));
}


public function searchByTag($tag)
{
    $criteria = new CDbCriteria();
    $criteria->addSearchCondition('tags', $tag); // Assuming tags are stored as a comma-separated string
    $criteria->addCondition('status = 1'); // Only fetch published posts

    return new CActiveDataProvider('Post', array(
        'criteria' => $criteria,
        'pagination' => array(
            'pageSize' => 10, // Optional: number of posts per page
        ),
    ));
}


public static function getTagCloud()
{
    $tags = array(); // Initialize an array to store tag counts
    $posts = Post::model()->findAll(array('select'=>'tags')); // Fetch all posts with their tags

    foreach ($posts as $post) {
        $postTags = explode(',', $post->tags); // Split the tags by comma for each post
        foreach ($postTags as $tag) {
            $tag = trim($tag); // Remove extra spaces
            if (!isset($tags[$tag])) {
                $tags[$tag] = 1; // If tag is not in the array, add it with a count of 1
            } else {
                $tags[$tag]++; // If tag is already in the array, increment its count
            }
        }
    }
    
    return $tags; // Return the array with tag counts
}



	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Post the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
