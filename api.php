<?php
//允许跨域请求
//header("Access-Control-Allow-Origin: *");
//读取文本
$str = explode("\n", file_get_contents('sinetxt.txt'));
$k = rand(0,count($str));
$sina_img = str_re($str[$k]);
$size_arr = array('large', 'mw1024', 'mw690', 'bmiddle', 'small', 'thumb180', 'thumbnail', 'square');
$size = !empty($_GET['size']) ? $_GET['size'] : 'large' ;
$server = rand(1,4);
if(!in_array($size, $size_arr)){
    $size = 'large';
}
//$url = 'https://i0.wp.com/tvax'.$server.'.sinaimg.cn/'.$size.'/'.$sina_img.'.jpg';
$url = 'https://cdn.ipfsscan.io/weibo/'.$size.'/'.$sina_img.'.jpg';
//$url = 'https://gzw.sinaimg.cn/'.$size.'/'.$sina_img.'.jpg';
$dir = realpath('./log');
del_file_by_ctime($dir, 24*60);//保留一天24*60分钟(一整天大概)
//获取链接存档日志
$file  = './log/log'.date("Y-m-d").'.txt';//要写入文件的文件名（可以是任意文件名），如果文件不存在，将会创建一个
#$content = "第一次写入的内容\n";
file_put_contents($file, '[时间]：'.date("Y-m-d H:i:s")."\r\n[链接]：".$url."\r\n",FILE_APPEND);

//解析结果
$result=array("code"=>"200","imgurl"=>"$url");
//Type Choose参数代码
@$type=$_GET['return'];//@表示这行有错误或是警告不要输出
switch ($type)
{   
    
//Json格式解析
case 'json':
$imageInfo = getimagesize($url);  
$result['width']="$imageInfo[0]";  
$result['height']="$imageInfo[1]";  
header('Content-type:text/json');
echo json_encode($result);  
break;
//JSON只有链接
case 'url':
header('Content-type:text/json');
echo json_encode($result);
break;
//直接显示
case 'img':
$useragent = $_SERVER['HTTP_USER_AGENT'];
if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',
substr($useragent, 0, 4))) {
// 手机
echo "<img style='object-fit:contain' src=".$result['imgurl']." width='100%' />";
//return 1;
} else {
// 电脑
echo "<img style='object-fit:contain;display:block;margin:auto' src=".$result['imgurl']." height='100%' />";
//return 0;
}
//echo "<h3>第".($k+1)."张，共计".(count($str)+1)."张</h3>";
//echo "<img stytle='object-fit:contain' src=".$result['imgurl']." width='100%' />";
$datetime = new DateTime();
$datetime = $datetime->format('Y-m-d H:i:s');
echo "<h3 style=\"text-align:center\">".$datetime."</h3><style>*{margin:0 auto}</style>";
break;
//IMG
default:
header("Location:".$result['imgurl']);
//echo '<script type="text/javascript">window.open(    \''.$result['imgurl'].'\');</script>';
//echo "<img stytle='object-fit:contain' src=".$result['imgurl']." width='100%' />";
break;
}
function str_re($str){
  $str = str_replace(' ', "", $str);
  $str = str_replace("\n", "", $str);
  $str = str_replace("\t", "", $str);
  $str = str_replace("\r", "", $str);
  return $str;
}

/*
 * 删除文件夹下$n分钟前创建的文件
 * @param $dir 要处理的目录，物理路径，结尾不加\
 * @param $n 过期时间，单位为分钟
 * @return void
 */
function del_file_by_ctime($dir,$n){
    if(is_dir($dir)){
        if($dh=opendir($dir)){
            while (false !== ($file = readdir($dh))){
                if($file!="." && $file!=".."){
                    $fullpath=$dir."/".$file;
                    if(!is_dir($fullpath)){ 
                        $filedate=filemtime($fullpath);
                        $minutes=round((time()-$filedate)/60);
                        if($minutes>$n) unlink($fullpath); //删除文件
                    }
                }
            }
        }
        closedir($dh);
    }
}
 
//下面是调用的代码
//删除1天前的文件
//$dir = realpath('./Upload/export');
//del_file_by_ctime($dir, 24*60);

?>

