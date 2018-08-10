<?php 

namespace OSS;
use OSS\Common;

class Client
{

	public $bucket; //bucket 名称
	public $ossClient; //OssClient对象
	public $object;	//对象
	public $error;	//错误
	public $localfile;	//替换文件

	function __construct(){ //定义构造函数

		$this->bucket = Common::getBucketName();
		$this->ossClient = Common::getOssClient();
		if (is_null($this->ossClient)) exit('配置错误');

	}


	/**
	 * 创建虚拟目录
	 *
	 * @param string $bucket 存储空间名称
	 * @return null
	 */
	function createObjectDir($bucket)
	{

		$this->bucket = $bucket;

	    try {
	        $this->ossClient->createObjectDir($this->bucket, "dir");
	    } catch (OssException $e) {
	        // printf(__FUNCTION__ . ": FAILED\n");
	        // printf($e->getMessage() . "\n");
	        $this->error = $e->getMessage();
	        return false;
	    }
	   		return true;
	}

	/**
	 * 把本地变量的内容到文件
	 *
	 * 简单上传,上传指定变量的内存值作为object的内容
	 *
	 * @param OssClient $ossClient OssClient实例
	 * @param string $bucket 存储空间名称
	 * @return null
	 */
	function putObject($object)
	{
		$this->object = $object;

	    $content = file_get_contents($this->object);
	    $options = array();

	    try {
	        $this->ossClient->putObject($this->bucket, $object, $content, $this->options);
	    } catch (OssException $e) {
	        // printf(__FUNCTION__ . ": FAILED\n");
	        // printf($e->getMessage() . "\n");
	        $this->error($e->getMessage());
	        return false;
	    }
	    
	    	return true;
	}


	/**
	 * 上传指定的本地文件内容
	 *
	 * @param OssClient $ossClient OssClient实例
	 * @param string $bucket 存储空间名称
	 * @return null
	 */
	function uploadFile($object)
	{
	    $this->object = $object;
	    $filePath = $object;
	    $options = array();

	    try {
	        $this->ossClient->uploadFile($this->bucket, $object, $filePath, $options);
	    } catch (OssException $e) {
	        // printf(__FUNCTION__ . ": FAILED\n");
	        // printf($e->getMessage() . "\n");
	        $this->error = $e->getMessage;
	        return false;
	    }
	    	return true;
	}


	//作废函数

	/**
	 * 列出Bucket内所有目录和文件, 注意如果符合条件的文件数目超过设置的max-keys， 用户需要使用返回的nextMarker作为入参，通过
	 * 循环调用ListObjects得到所有的文件，具体操作见下面的 listAllObjects 示例
	 *
	 * @param OssClient $ossClient OssClient实例
	 * @param string $bucket 存储空间名称
	 * @return null
	 */
	function listObjects($prefix)
	{
	    $prefix = '/';
	    $delimiter = '/';
	    $nextMarker = '';
	    $maxkeys = 1000;
	    $options = array(
	        'delimiter' => $delimiter,
	        'prefix' => $prefix,
	        'max-keys' => $maxkeys,
	        'marker' => $nextMarker,
	    );
	    try {
	        $listObjectInfo = $ossClient->listObjects($bucket, $options);
	    } catch (OssException $e) {
	        // printf(__FUNCTION__ . ": FAILED\n");
	        // printf($e->getMessage() . "\n");
	        $this->error = $e->getMessage();
	        return;
	    }
	    // print(__FUNCTION__ . ": OK" . "\n");

	    $objectList = $listObjectInfo->getObjectList(); // 文件列表
	    $prefixList = $listObjectInfo->getPrefixList(); // 目录列表
	    if (!empty($objectList)) {
	        // print("objectList:\n");
	        foreach ($objectList as $key => $objectInfo) {
	            $objectList[$key]['key'] = $objectInfo->getKey();
	        }
	    }
	    if (!empty($prefixList)) {
	        // print("prefixList: \n");
	        foreach ($prefixList as $key => $prefixInfo) {
	            $prefixList[$key] = $objectInfo->getPrefix();
	        }
	    }

	    $data['object'] = $objectList;
	    $data['prefix'] = $prefixList;

	    return $data;
	}



	//作废函数

	/**
	 * 列出Bucket内所有目录和文件， 根据返回的nextMarker循环得到所有Objects
	 *
	 * @param OssClient $ossClient OssClient实例
	 * @param string $bucket 存储空间名称
	 * @return null
	 */
	function listAllObjects($ossClient, $bucket)
	{
	    //构造dir下的文件和虚拟目录
	    for ($i = 0; $i < 100; $i += 1) {
	        $ossClient->putObject($bucket, "dir/obj" . strval($i), "hi");
	        $ossClient->createObjectDir($bucket, "dir/obj" . strval($i));
	    }

	    $prefix = 'dir/';
	    $delimiter = '/';
	    $nextMarker = '';
	    $maxkeys = 30;

	    while (true) {
	        $options = array(
	            'delimiter' => $delimiter,
	            'prefix' => $prefix,
	            'max-keys' => $maxkeys,
	            'marker' => $nextMarker,
	        );
	        // P($options);
	        try {
	            $listObjectInfo = $ossClient->listObjects($bucket, $options);
	        } catch (OssException $e) {
	            printf(__FUNCTION__ . ": FAILED\n");
	            printf($e->getMessage() . "\n");
	            return;
	        }
	        // 得到nextMarker，从上一次listObjects读到的最后一个文件的下一个文件开始继续获取文件列表
	        $nextMarker = $listObjectInfo->getNextMarker();
	        $listObject = $listObjectInfo->getObjectList();
	        $listPrefix = $listObjectInfo->getPrefixList();
	        // P(count($listObject));
	        // P(count($listPrefix));
	        if ($nextMarker === '') {
	            break;
	        }
	    }
	}

	/**
	 * 获取object的内容
	 *
	 * @param OssClient $ossClient OssClient实例
	 * @param string $bucket 存储空间名称
	 * @return null
	 */
	function getObject($object)
	{
	    $this->object = $object;
	    $options = array();
	    try {
	        $content = $this->ossClient->getObject($this->bucket, $this->object, $options);
	    } catch (OssException $e) {
	        // printf(__FUNCTION__ . ": FAILED\n");
	        // printf($e->getMessage() . "\n");
	        $this->error = $e->getMessage();
	        return false;
	    }
	   
	    return $content;
	}



//作废函数
	/**
	 * 拷贝object
	 * 当目的object和源object完全相同时，表示修改object的meta信息
	 *
	 * @param OssClient $ossClient OssClient实例
	 * @param string $bucket 存储空间名称
	 * @return null
	 */
	function copyObject($ossClient, $bucket)
	{
	    $fromBucket = $bucket;
	    $fromObject = "oss-php-sdk-test/upload-test-object-name.txt";
	    $toBucket = $bucket;
	    $toObject = $fromObject . '.copy';
	    $options = array();

	    try {
	        $ossClient->copyObject($fromBucket, $fromObject, $toBucket, $toObject, $options);
	    } catch (OssException $e) {
	        printf(__FUNCTION__ . ": FAILED\n");
	        printf($e->getMessage() . "\n");
	        return;
	    }
	    print(__FUNCTION__ . ": OK" . "\n");
	}


//作废函数
	/**
	 * 修改Object Meta
	 * 利用copyObject接口的特性：当目的object和源object完全相同时，表示修改object的meta信息
	 *
	 * @param OssClient $ossClient OssClient实例
	 * @param string $bucket 存储空间名称
	 * @return null
	 */
	function modifyMetaForObject($ossClient, $bucket)
	{
	    $fromBucket = $bucket;
	    $fromObject = "oss-php-sdk-test/upload-test-object-name.txt";
	    $toBucket = $bucket;
	    $toObject = $fromObject;
	    $copyOptions = array(
	        OssClient::OSS_HEADERS => array(
	            'Cache-Control' => 'max-age=60',
	            'Content-Disposition' => 'attachment; filename="xxxxxx"',
	        ),
	    );
	    try {
	        $ossClient->copyObject($fromBucket, $fromObject, $toBucket, $toObject, $copyOptions);
	    } catch (OssException $e) {
	        printf(__FUNCTION__ . ": FAILED\n");
	        printf($e->getMessage() . "\n");
	        return;
	    }
	    print(__FUNCTION__ . ": OK" . "\n");
	}


//作废函数
	/**
	 * 获取object meta, 也就是getObjectMeta接口
	 *
	 * @param OssClient $ossClient OssClient实例
	 * @param string $bucket 存储空间名称
	 * @return null
	 */
	function getObjectMeta($ossClient, $bucket)
	{
	    $object = "oss-php-sdk-test/upload-test-object-name.txt";
	    try {
	        $objectMeta = $ossClient->getObjectMeta($bucket, $object);
	    } catch (OssException $e) {
	        printf(__FUNCTION__ . ": FAILED\n");
	        printf($e->getMessage() . "\n");
	        return;
	    }
	    print(__FUNCTION__ . ": OK" . "\n");
	    if (isset($objectMeta[strtolower('Content-Disposition')]) &&
	        'attachment; filename="xxxxxx"' === $objectMeta[strtolower('Content-Disposition')]
	    ) {
	        print(__FUNCTION__ . ": ObjectMeta checked OK" . "\n");
	    } else {
	        print(__FUNCTION__ . ": ObjectMeta checked FAILED" . "\n");
	    }
	}

	/**
	 * 删除object
	 *
	 * @param OssClient $ossClient OssClient实例
	 * @param string $bucket 存储空间名称
	 * @return null
	 */
	function deleteObject($object)
	{
	    $this->object = $object;
	    try {
	        $this->ossClient->deleteObject($this->bucket, $this->object);
	    } catch (OssException $e) {
	        // printf(__FUNCTION__ . ": FAILED\n");
	        // printf($e->getMessage() . "\n");
	        $this->error = $e->getMessage();
	        return false;
	    }
	    // print(__FUNCTION__ . ": OK" . "\n");
	    	return true;
	}


	/**
	 * 批量删除object
	 *
	 * @param OssClient $ossClient OssClient实例
	 * @param string $bucket 存储空间名称
	 * @return null
	 */
	function deleteObjects($objects)
	{
	    $this->objects = $objects;
	 
	    try {
	        $this->ossClient->deleteObjects($this->bucket, $this->objects);
	    } catch (OssException $e) {
	        // printf(__FUNCTION__ . ": FAILED\n");
	        // printf($e->getMessage() . "\n");
	        $this->error = $e->getMessage();
	        return false;
	    }
	    	return true;
	}

	/**
	 * 判断object是否存在
	 *
	 * @param OssClient $ossClient OssClient实例
	 * @param string $bucket 存储空间名称
	 * @return null
	 */
	function doesObjectExist($object)
	{
	    $this->object = $object;
	    try {
	        $exist = $this->ossClient->doesObjectExist($this->bucket, $this->object);
	    } catch (OssException $e) {
	        // printf(__FUNCTION__ . ": FAILED\n");
	        // printf($e->getMessage() . "\n");
	        $this->error = $e->getMessage();
	        return;
	    }
	    // print(__FUNCTION__ . ": OK" . "\n");
	    var_dump($exist);
	}



}


?>