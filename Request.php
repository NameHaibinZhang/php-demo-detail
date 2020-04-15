<?php

/**
 * 数据操作类
 */
class Request
{
   
    public static function getRequest()
    {
        //请求方式
        $method = strtolower($_SERVER['REQUEST_METHOD']);
        $data_name = $method . 'Detail';
        return self::$data_name($_REQUEST);
    }

    //GET 获取item detail
    private static function getDetail($request_data)
    {
        $item_id = (int)$request_data['itemId'];
        if ($item_id < 0) {
            return false;
        }

        $item_service = getenv("itemcenter-service");
        if (empty($item_service)) {
            $item_service = "itemcenter";
        }
        echo "Itemcenter service:$item_service";
        $url = sprintf("http://%s:8080/item/%u", $item_service, $item_id);
        $res = _httpGet($url);
        return array("describe"=>"Get from itemcenter", "result"=>$res);
    }


}

function _httpGet($url=""){
        
    $curl = curl_init();

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
    curl_setopt($curl, CURLOPT_URL, $url);

    $res = curl_exec($curl);
    curl_close($curl);

    return $res;
}
