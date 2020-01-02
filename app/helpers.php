<?php
function khongdau($str) {
    if ($str != ""){
        $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
        $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
        $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
        $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
        $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
        $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
        $str = preg_replace("/(đ)/", 'd', $str);
        $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
        $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
        $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
        $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
        $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
        $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
        $str = preg_replace("/(,|\.|\+|\*|\/|;|_|=|`|~|!|@|#|\$|%|\^|&|\(|\)|\||\{|\}|\[|\]|<|>|\?|:)/", ' ', $str);
        $str = preg_replace("/(Đ|Ð)/", 'D', $str);
        $str = str_replace(".", " ",$str);
        $str = str_replace("\'", " ",$str);
        $str = str_replace('\"', ' ',$str);
        $str = str_replace("'", " ",$str);
        $str = str_replace('"', ' ',$str);
        $str = str_replace(',', ' ',$str);
        $str = str_replace('\\', ' ',$str);
        $str = preg_replace("/(-)+/", '', $str);
        $str = preg_replace("/( ){2,}/", ' ', $str);
    }
    return $str;
}
function khongdaurw($str) {

    if ($str != ""){

        $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);

        $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);

        $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);

        $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);

        $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);

        $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);

        $str = preg_replace("/(đ)/", 'd', $str);

        $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'a', $str);

        $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);

        $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);

        $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'o', $str);

        $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'u', $str);

        $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'y', $str);

        $str = preg_replace("/(,|\.|\+|-|\*|\/|;|_|=|`|~|!|@|#|\$|%|\^|&|\(|\)|\||\{|\}|\[|\]|<|>|\?|:)/", '-', $str);

        $str = preg_replace("/(Đ|Ð)/", 'd', $str);

        $str = str_replace(".", "-",$str);
        $str = str_replace(" ", "-", str_replace("&*#39;","",$str));
        $str = str_replace("\'", "-",$str);
        $str = str_replace('\"', '-',$str);
        $str = str_replace("'", "-",$str);
        $str = str_replace('’', '',$str);
        $str = str_replace('…', '',$str);
        $str = preg_replace("/(“|”|„|†|‡|‰|‹|›|♠|♣|♥|♦|‾|←|↑|→|↓|™)/", '', $str);
        $str = str_replace('‘', '',$str);
        $str = str_replace('"', '-',$str);

        $str = str_replace(',', '-',$str);

        $str = str_replace('–', '-',$str);

        $str = str_replace('\\', '-',$str);

        $str = preg_replace("/(-)+/", '-', $str);
        $str  = trim($str,'-');

    }
    return $str;

}
function thousandsep ($str) {
    return str_replace(' đ','',numbertomoney($str));
}
function numbertomoney($str , $suff = ' đ'){
    $newstr = '';
    $result = strlen($str);
    if($result<4 && $result >0){
        $str .= $suff;
        $newstr = $str;
    }
    if($result<=6 and $result>=4){
        $str .= $suff;
        $newstr = substr($str, 0, strlen($str)-6) . ',' . substr($str, strlen($str)-6);
    }
    if($result<=9 and $result>=7){
        $str .= $suff;
        $newstr = substr($str, 0, strlen($str)-6) . ',' . substr($str, strlen($str)-6);
        $newstr = substr($newstr, 0, strlen($newstr)-10) . ',' . substr($newstr, strlen($newstr)-10);
    }
    if($result<=12 and $result>=10){
        $str .= $suff;
        $newstr = substr($str, 0, strlen($str)-6) . ',' . substr($str, strlen($str)-6);
        $newstr = substr($newstr, 0, strlen($newstr)-10) . ',' . substr($newstr, strlen($newstr)-10);
        $newstr = substr($newstr, 0, strlen($newstr)-14) . ',' . substr($newstr, strlen($newstr)-14);
    }
    if($result>12){
        $newstr = "Số quá lớn";
    }
    return $newstr;
}
function checkImage($str , $isThumb = false , $thumb_width = 409 , $thumb_height = 276 , $thumb_quality = 90)
{
    // chu y '/image/' not \
    if(trim($str)!=''){
        if(str_contains($str, ['http://', 'https://'])){
            return $str;
        }
        $file = public_path().('/image/'.$str);
        $check_exist_image = file_exists($file);
        //dd($check_exist_image);
        if($isThumb){
            $file_thumb = public_path().('/image/thumb/'.$str);
            $check_exist_thumb = file_exists($file_thumb);
            if($check_exist_image&&$check_exist_thumb){
                return 'thumb/'.$str ;
            } else {
                if($check_exist_image){
                    $rs = generateThumbnail( ($file) , $thumb_width, $thumb_height, $thumb_quality , $str);
                    if($rs===true){
                        return 'thumb/'.$str ;
                    } else {
                        return $str ;
                    }
                } else {
                    return 'no-photo.jpg';
                }
            }
        } else {
            if(!$check_exist_image){
                return 'no-photo.jpg';
            } else {
                return $str ;
            }
        }
    } else {
        return 'no-photo.jpg';
    }


}
function imagecreatefromfile( $filename ) {
    if (!file_exists($filename)) {
        throw new InvalidArgumentException('File "'.$filename.'" not found.');
    }
    switch ( strtolower( pathinfo( $filename, PATHINFO_EXTENSION ))) {
        case 'jpeg':
        case 'jpg':
            return imagecreatefromjpeg($filename);
            break;

        case 'png':
            return imagecreatefrompng($filename);
            break;

        case 'gif':
            return imagecreatefromgif($filename);
            break;

        default:
            throw new InvalidArgumentException('File "'.$filename.'" is not valid jpg, png or gif image.');
            break;
    }
}
function reduceImage($path , $folder , $quality){
    $inPublic = $folder;
    $localPath = realpath(public_path($inPublic));
    if($path == ''){ $path = public_path(); }
    $publicPath = realpath($path);
    $relativePart = str_replace($publicPath, '', $localPath);
    $url = url("/" . trim($relativePart, "/\\"));
    dd($url);
    if (is_file($img)&&$img!='') {
        $imagick = new Imagick(realpath($img));
        $imagick->setImageFormat('jpeg');
        $imagick->setImageCompression(Imagick::COMPRESSION_JPEG);
        $imagick->setImageCompressionQuality($quality);
        $imagick->thumbnailImage($width, $height, false, false);
        $file_arr  = explode('.', $img);
        $filename_no_ext = $file_arr[0];
        if (file_put_contents(public_path().'/image/thumb/' . $str, $imagick) === false) {
            throw new Exception("Could not put contents.");
        }
        return true;
    }
    else {
        throw new Exception("No valid image provided with {$img}.");
    }
}
function imgageMobile($img , $width , $height){
    $file = public_path().('/image/'.$img);
    $check_exist_image = file_exists($file);
    if($check_exist_image){
        $file_mobile = public_path().('/image/mobile/'.$img);
        $check_exist_image = file_exists($file_mobile);
        if($check_exist_image){
            return 'mobile/'.$img;
        } else {
            if (class_exists('Imagick')) {
                if (is_file($file)&&$file!='') {
                    $imagick = new Imagick(realpath($file));
                    $imagick->setImageFormat('jpeg');
                    $imagick->setImageCompression(Imagick::COMPRESSION_JPEG);
                    $imagick->setImageCompressionQuality(30);
                    $imagick->thumbnailImage($width, $height, false, false);
                    $file_arr  = explode('.', $img);
                    if (file_put_contents(public_path().'/image/' . $img, $imagick) === false) {
                        throw new Exception("Could not put contents.");
                    }
                    return 'mobile/'.$img;
                } else {
                    return 'no-photo.jpg';
                }
            } else {
                return 'mobile/'.$img;
            }
        }
    } else {
        return 'no-photo.jpg';
    }
}
function generateThumbnail($img, $width, $height, $quality = 90 , $str = '')
{
    if (class_exists('Imagick')) {
        if (is_file($img)&&$img!='') {
                $imagick = new Imagick(realpath($img));
                $imagick->setImageFormat('jpeg');
                $imagick->setImageCompression(Imagick::COMPRESSION_JPEG);
                $imagick->setImageCompressionQuality($quality);
                $imagick->thumbnailImage($width, $height, false, false);
                $file_arr  = explode('.', $img);
                $filename_no_ext = $file_arr[0];
                if (file_put_contents(public_path().'/image/thumb/' . $str, $imagick) === false) {
                    throw new Exception("Could not put contents.");
                }
                return true;
        }
        else {
            throw new Exception("No valid image provided with {$img}.");
        }
    } else {
        return false;
    }

}
function catchu($value, $length)
{
    if($value!=''){
        if(is_array($value)) list($string, $match_to) = $value;
        else { $string = $value; $match_to = $value{0}; }

        $match_start = stristr($string, $match_to);
        $match_compute = strlen($string) - strlen($match_start);

        if (strlen($string) > $length)
        {
            if ($match_compute < ($length - strlen($match_to)))
            {
                $pre_string = substr($string, 0, $length);
                $pos_end = strrpos($pre_string, " ");
                if($pos_end === false) $string = $pre_string."...";
                else $string = substr($pre_string, 0, $pos_end)."...";
            }
            else if ($match_compute > (strlen($string) - ($length - strlen($match_to))))
            {
                $pre_string = substr($string, (strlen($string) - ($length - strlen($match_to))));
                $pos_start = strpos($pre_string, " ");
                $string = "...".substr($pre_string, $pos_start);
                if($pos_start === false) $string = "...".$pre_string;
                else $string = "...".substr($pre_string, $pos_start);
            }
            else
            {
                $pre_string = substr($string, ($match_compute - round(($length / 3))), $length);
                $pos_start = strpos($pre_string, " "); $pos_end = strrpos($pre_string, " ");
                $string = "...".substr($pre_string, $pos_start, $pos_end)."...";
                if($pos_start === false && $pos_end === false) $string = "...".$pre_string."...";
                else $string = "...".substr($pre_string, $pos_start, $pos_end)."...";
            }

            $match_start = stristr($string, $match_to);
            $match_compute = strlen($string) - strlen($match_start);
        }

        return $string;
    }else{
        return $string ='';
    }
}
function checkValidDate($str){
    $pattern = '/^\d{2}(\/)\d{2}(\/)\d{4}$/';
    $result = preg_match($pattern, $str);
    if($result != 1) {
        return false;
    } else {
        $arrstr = explode("/",$str);
        return checkdate($arrstr[1],$arrstr[0],$arrstr[2]);
    }
}
function convertBedTransport($number){
    $arr_convert_bed = [
        1 =>'C1',2 =>'C2',3 =>'B1',4 =>'B2',5 =>'A1',6 =>'A2',
        7 =>'C3',8 =>'C4',9 =>'B3',10 =>'B4',11 =>'A3',12 =>'A4',
        13 =>'C5',14 =>'C6',15 =>'B5',16 =>'B6',17 =>'A5',18 =>'A6',
        19 =>'C7',20 =>'C8',21 =>'B7',22 =>'B8',23 =>'A7',24 =>'A8',
        25 =>'C9',26 =>'C10',27 =>'B9',28 =>'B10',29 =>'A9',30 =>'A10',
        31 =>'D1',32 =>'D2',33 =>'D3',34 =>'D4',35 =>'D5',
        36 =>'D6',37 =>'D7',38 =>'D8',39 =>'D9',40 =>'D10'
    ];
    return $arr_convert_bed[$number];
}
function getStatusOrder($str){
    switch($str){
        case '0':
            return 'Hủy';
            break;
        case '1':
            return 'Chờ xác nhận';
            break;
        case '2':
            return 'Đặt cọc';
            break;
        case '3':
            return 'Hoàn tất';
            break;
        case '4':
            return 'Giữ chỗ';
            break;
    }
}
function waterMarkImage($link){
    $stamp = imagecreatefrompng('images/tour-result.png');
    $sx = imagesx($stamp);
    $sy = imagesy($stamp);
    $im = @imagecreatefromjpeg('image/'.$link);
    if($im) {
        $ix = imagesx($im);
        $iy = imagesy($im);
        if (($sx > $ix) || ($sy > $iy)) {

        } else {
            imagecopy($im, $stamp, (imagesx($im) - $sx) / 2, (imagesy($im) - $sy) / 2, 0, 0, imagesx($stamp), imagesy($stamp));
            imagejpeg($im, 'image/' . $link);
        }
        imagedestroy($im);
    }
}
function getStarText($star){
    if($star>0) {
        return $star . ' sao';
    } else {
        return 'Nhà nghỉ';
    }
}
function replaceBlogPlacer($str){
    preg_match("/\{\{HD\d{7}\}\}/", $str, $matches, PREG_OFFSET_CAPTURE);
    $pattern = '/(hd)|(HD)/';
    $pattern1 = '/{{/';
    $pattern2 = '/}}/';
    if(count($matches)>0 ) {
        foreach($matches as $code){
            $search_str  = preg_replace($pattern, '', $code[0]);
            $search_str  = preg_replace($pattern1, '',$search_str);
            $search_str  = preg_replace($pattern2, '', $search_str);
            $tour_id = intval(substr($search_str,0 , 5));
            $tour = App\Models\Tour::where('id',$tour_id)->get();
            if(count($tour)>0){
                $tour = $tour->first();
                $template  = getTemplatePlacer($tour);
                $str = str_replace($code[0],$template ,$str);
            } else {
                $str = str_replace($code[0],'' ,$str);
            }
        }
    }
    return $str;
}
function getTemplatePlacer($tour){
    $html = '<h4 style="text-align: center;"><div class="ltt-contentbox white"><span class="icon star"></span><strong>CLICK ĐẶT NGAY <a href="'.asset($tour->slug).'" target="_blank">'.catchu($tour->title,100).'</a>&nbsp;VỚI GIÁ ƯU ĐÃI CỰC TỐT TỪ HAIDANGTRAVEL.COM</strong></div></h4>';
    return $html;
}
function loadMenu(){
    $expiresAt = \Carbon\Carbon::now()->addMinutes(10);
    $danhmuc_tourdoan = \Illuminate\Support\Facades\Cache::remember('danhmuc_tourdoan',$expiresAt, function() {
        return \App\Models\SubjectBlog::where('parent_id',1)->get();
    });
    $danhmuc_baiviet = \Illuminate\Support\Facades\Cache::remember('danhmuc_baiviet',$expiresAt, function() {
        return \App\Models\SubjectBlog::where('parent_id','!=',1)->get();
    });
    $diemden_trongnuoc = \Illuminate\Support\Facades\Cache::remember('diemden_trongnuoc',$expiresAt, function() {
        return \App\Models\DestinationPoint::where('isOutbound','!=',1)->where('isHomepage',1)->limit(10)->get();
    });
    $diemden_nuocngoai = \Illuminate\Support\Facades\Cache::remember('diemden_nuocngoai',$expiresAt, function() {
        return \App\Models\DestinationPoint::where('isOutbound',1)->where('isHomepage',1)->limit(10)->get();
    });
    $compact = array('danhmuc_tourdoan', 'danhmuc_baiviet' , 'diemden_nuocngoai' , 'diemden_trongnuoc');
    View::share(compact($compact));
}
function loadTourStartDate($tour_ids) {
    return \App\Models\StartDate::whereIn('tour_id', $tour_ids )->where('isEnd', NULL)->where('startdate', '>', new \DateTime())->orderBy('startdate', 'ASC')->get();
}