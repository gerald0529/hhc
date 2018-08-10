<?php
/**图集表模型
 * @Author: 976123967@qq.com
 * @Date:   2015-07-20 14:51:58
 * @Last Modified by:   cl
 * @Last Modified time: 2015-08-06 22:26:18
 */
namespace Common\Model;
use Think\Model;
use Think\Image;
class ArticlePicModel extends Model{


	public $small;
	public $medium;

	public function _initialize()
	{

		// 图集尺寸
		$this->small['width']   = C('cfg_pic_small_width');
		$this->small['height']  = C('cfg_pic_small_height');
		$this->medium['width']  = C('cfg_pic_medium_width');
		$this->medium['height'] = C('cfg_pic_medium_height');
	}



	/**
	 * [add_pic 添加图片集合]
	 * @param [type] $article [description]
	 */
	public function add_pic($article)
	{
        // 获取比例
        $smallWidth = $this->small['width'];
        $smallHeight = $this->small['height'];
        $mediumWidth = $this->medium['width'];
        $mediumHeight = $this->medium['width'];

        $image = new Image(); 
        $pics = I('post.pics');
        $this->where(array('article_aid'=>$article['aid']))->delete();

        $ids  = I('post.ids');
        $psort = I('post.psort');

        $uploadModel = D('Upload');
        foreach($pics as $k=> $f)
        {
            if(!$f || !is_file($f)) continue; 
            // 定义路径

            $pic=pathinfo($f);
            // 缩略图
            $medium=$pic['dirname'] . '/' .$pic['filename']."_medium.".$pic['extension'];
            $small = $pic['dirname'] . '/' .$pic['filename']."_small.".$pic['extension'];

            $image->open($f);
            if(!is_file($medium))
                $image->thumb($mediumWidth, $mediumHeight,\Think\Image::IMAGE_THUMB_FILLED)->save($medium);
            if(!is_file($small))
             $image->thumb($smallWidth, $smallHeight,\Think\Image::IMAGE_THUMB_FILLED)->save($small);


            $data = array(
                    'article_aid'=> $article['aid'],
                    'big'=>$f,
                    'medium'=>$medium,
                    'small'=>$small,
                    
                    //'pic_title'=>$picTitle[$k]
                );
           if(isset($ids[$k]))
                $data['id']  = $ids[$k];
             if(isset($psort[$k]) && $psort[$k])
                $data['sort']  = $psort[$k];
               
            $this->add($data);



            // 附件更新
            $file = pathinfo($f);
            $uploadModel->where(array('name'=>$file['basename']))->save(array(
                'relation'=>$article['aid'],
                'type'=>'articlepic',
            ));
            
        }
      
	}

    /**
     * [get_all 读取]
     * @param  [type] $aid [description]
     * @return [type]      [description]
     */
    public function get_all($aid)
    {
        $data = $this->where(array('article_aid'=>$aid))->order(array('sort'=>'asc','id'=>'asc'))->select();
        return $data;
    }




}