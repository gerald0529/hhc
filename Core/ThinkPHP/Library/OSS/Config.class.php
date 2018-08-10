<?php

/**
 * Class Config
 *
 * 执行Sample示例所需要的配置，用户在这里配置好Endpoint，AccessId， AccessKey和Sample示例操作的
 * bucket后，便可以直接运行RunAll.php, 运行所有的samples
 */

namespace OSS;

final class Config
{


    const OSS_ACCESS_ID = '';       //access_id
    const OSS_ACCESS_KEY = '';		//access_key
    const OSS_ENDPOINT = '';		//内网域名或者绑定域名
    const OSS_TEST_BUCKET = ''; 	//bucket

}
