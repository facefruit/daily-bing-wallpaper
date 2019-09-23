<?php
require_once('./lib/function.php');

$json_root_dir = './json';
$api_root_dir = './api';
$files = scandir($json_root_dir);
//var_dump($files);

$total = 0;
$count = 0;

foreach ($files as $file_name) {
    $total++;

    $file_path = $json_root_dir.'/'.$file_name;
    $file_content = file_get_contents($file_path);
    //echo $file_content;
    $file_json = json_decode($file_content, false);
    //var_dump($file_json);
    $copyright = $file_json->copyright;
    $date = $file_json->date;
    $link = $file_json->link;

    $year = substr($date, 0, 4);
    $month = substr($date, 4, 2);
    $day = substr($date, -2);
    $folder = 'cn/'.$year.'/'.$month;
    if (!file_exists($folder)) {
        mkdir($folder, 777, true);
    }
    $name_start_pos = strpos($link, '/th?id=');
    if ($name_start_pos === false) {
        $name_start_pos = strrpos($link, '/') + 1;
    } else {
       $name_start_pos += 7;
    }
    $name_end_pos = strpos($link, '_1920x1080.jpg');
    $downloan_image_name = substr($link, $name_start_pos, $name_end_pos - $name_start_pos);
    $image_path = $folder.'/'.$downloan_image_name.'.jpg';
 
    $tmp_url = 'https://www.bing.com/th?id=${name}_tmb.jpg';
    $prefix = 'OHR.';
    $prefix_pos = strpos($downloan_image_name, $prefix);
    if ($prefix_pos === false) {
        $downloan_image_name = $prefix.$downloan_image_name;
    }
    $tmp_downloan_url = str_replace('${name}', $downloan_image_name, $tmp_url);
    echo $tmp_downloan_url.'
';
    $dl_path = 'tmb/'.$downloan_image_name.'_tmb.jpg';
    echo $dl_path.'
';
    $response = request($tmp_downloan_url);
    $image_result = check_image_and_save($dl_path,);

    if ($image_result !== false) {
        $count++;
    }


/*   
    $api_obj = new stdClass();
    $cr = $copyright;
    $copyright_divider_pos = strpos($cr, '<br/>');
    if ($copyright_divider_pos === false) {
        $copyright = $cr;
        unset($desc);
    } else {
        $copyright = substr($cr, 0, $copyright_divider_pos);
        $desc = substr($cr, $copyright_divider_pos + 5);
    }

    $s_pos = strpos($copyright, '(');
    $title = substr($copyright, 0, $s_pos);
    $copyrightonly = substr($copyright, $s_pos + 1, -1);
    
    $api_obj->title = $title;
    $api_obj->caption = $title;
    $api_obj->desc = $desc;
    $api_obj->copyright = $copyright;
    $api_obj->copyrightonly = $copyrightonly;
    $api_obj->date = $date;
    
    $image = new stdClass();
    $image->hd = '/cn/'.$year.'/'.$month.'/'.$downloan_image_name.'.jpg';
    $api_obj->image = $image;

    echo 'title = '.$api_obj->title.'
';
    echo 'caption = '.$api_obj->caption.'
';
    echo 'desc = '.$api_obj->desc.'
';
    echo 'copyright = '.$api_obj->copyright.'
';
    echo 'copyrightonly = '.$api_obj->copyrightonly.'
';
    echo 'date = '.$api_obj->date.'
';
    echo 'image->hd = '.$api_obj->image->hd.'
';
    echo '-------------------
';
    $json = json_encode($api_obj, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    $api_folder = './api/'.$year.'/'.$month;
    if (!file_exists($api_folder)) {
        mkdir($api_folder, 777, true);
    }
    $api_path = $api_folder.'/'.$year.'-'.$month.'-'.$day.'json';
    file_put_contents($api_path, $json);
*/    

//    if (!file_exists($image_path)) {
//        $download_cmd = 'wget -O '.$image_path.' "'.$link.'"';
//        exec($download_cmd);
//    }
//    echo $image_path.'
//';
//    echo $link.'
//';
//    echo $download_cmd.'
//';
//    echo '-------------------
//';
}

echo 'total:'.$total.' count:'.$count.'
';
