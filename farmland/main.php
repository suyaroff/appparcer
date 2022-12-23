<?php
//$str = $prefix . $url . $timestamp;
//$hash = md5($str);

class Farmland
{

    public $host = 'https://api.farmlend.ru';
    public $saveTofile = false;

    public function request($url)
    {
        $url = $this->host . $url;
        $timestamp = time();
        settype($timestamp, 'string');
        $prefix = '7e8480b9523030d0a7d9679d90e50d2e';
        // Вычесляем хеш, долго я его искал 
        $hash = md5($prefix . $url . $timestamp);
        $headers = [
            'hash: ' . $hash,
            'timestamp: ' . $timestamp,
            'app-version: 198',
            'User-Agent: Dalvik/2.1.0 (Linux; U; Android 12; V2036 Build/SP1A.210812.003)',
        ];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_URL, $url);

        $result = curl_exec($curl);
        curl_close($curl);
        if ($this->saveTofile) {
            $this->saveJson($url, $result);
        }
        $result = json_decode($result);
        return $result;
    }

    public function saveJson($url ,$data) {
        $info = parse_url($url);
        $fileName = $info['host'] . $info['path'] . '.json';
        $dir = pathinfo($fileName);
        if(!is_dir($dir['dirname'])){
            mkdir($dir['dirname'], 777, true);
        }
        file_put_contents($fileName, $data);
    }

    public function sectionList()
    {
        $result = $this->request('/v2/section?showRare=1&location=218&token=');
        return $result;
    }

    public function section($id)
    {
        $url = '/v2/section/' . $id . '?location=218&token=';
        $result = $this->request($url);
        return $result;
    }

    public function category($id)
    {
        $url = '/v2/category/' . $id . '?location=218&token=';
        $result = $this->request($url);
        return $result;
    }

    public function subcategory($id)
    {
        $url = '/v2/subcategory-level-2/' . $id . '?location=218&page=1';
        $result = $this->request($url);
        return $result;
    }

    public function productFullInfo($id)
    {
        $url = '/v2/product-full-info/' . $id . '?location=218';
        $result = $this->request($url);
        return $result;
    }




}
$farmland = new Farmland();
// если хотим сохранить в фаил
$farmland->saveTofile = true;

$sections = $farmland->sectionList();
$section = $farmland->section(9);
$category = $farmland->category(70);
$subcategory = $farmland->subcategory(42);
$product = $farmland->productFullInfo(1409);
