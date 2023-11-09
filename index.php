<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" 
    integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="./style.css">
</head>
<body>

    
    <div class="container">

        <div class="calendar-title"><h3>萬年曆</h3></div>
            
        <div class="form-box">
            <form action="?" method="get">
                <label for="year">西元年:</label>
                <input type="number" id="year" name="year" min="0" max="10000" require>
                &nbsp;&nbsp;
                <label for="month">月份:</label>
                <input type="number" id="month" name="month" min="1" max="12" require>
                &nbsp;&nbsp;
                <!-- <input type="submit"> -->
                <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
        </div>

        <div class="nav-box">
            <?php
                // 取得當前url,並使用explode()分離url"?"前後的部分 
                $url = explode('?', $_SERVER['REQUEST_URI']); 

                // 如果$_GET為空或是日期輸入為空，將網頁重新導向當前日期的日曆
                if(empty($_GET) || empty($_GET['year']) || empty($_GET['month'])){
                    $year = date('Y');
                    $month = date('m');
                    header('location:'.$url[0].'?year='.$year.'&month='.$month);
                }
                else{
                    $prevYear = $_GET['year'];
                    $nextYear = $_GET['year'];
                    $prevMonth = $_GET['month'] - 1;
                    $nextMonth = $_GET['month'] + 1;

                    if($prevMonth <= 0){
                        $prevMonth = 12;
                        $prevYear--;
                    }
                    else if($nextMonth > 12){
                        $nextMonth = 1;
                        $nextYear++;
                    }
                    
                    $prev = '?year='.$prevYear.'&month='.$prevMonth;
                    $next = '?year='.$nextYear.'&month='.$nextMonth;
                    echo '<button><a href="'.$url[0].$prev.'"><i class="fa-solid fa-arrow-left"></i></a></button>';
                    echo '<div class="nav-date">西元'.$_GET['year'].'年 '.$_GET['month'].'月</div>';
                    echo '<button><a href="'.$url[0].$next.'"><i class="fa-solid fa-arrow-right"></i></a></button>';
                }
            ?>

        </div>

        <div class="calendar-box">

            <!-- <div class="calendar-img"></div> -->

            <?php
            use function PHPSTORM_META\elementType;
            
            // 於月曆左側印出背景圖片，圖片依月份不同而改變
            $imgIds = ['29', '27', '13', '25', '18', '19', '17', '11', '10', '12', '15', '256'];
            $index = $_GET['month'] - 1;
            echo '<div class="calendar-img" style="background-image: url(https://picsum.photos/id/'.$imgIds[$index].'/600/600)"></div>';

            // 該函式用於印出月曆
            function calendar($year, $month){
                $date = $year.'-'.$month;
                // 使用陣列$arr來存放之後要印出的月曆內容
                $arr = ['<tr class="table-head"><td>日</td><td>一</td><td>二</td><td>三</td><td>四</td><td>五</td><td>六</td></tr>'];
                // $n用於追蹤該月的開頭到結尾(這裡的減去 date('w', strtotime($date.'-1')) 是計算當月的開頭是第一周的星期幾)
                $n = 1 - date('w', strtotime($date.'-1'));
                // $len為當前月份的長度
                $len = date('t', strtotime($date));
                // $prevLen預留用來存放前一個月的長度
                $prevLen = null;
                // $currentMonth存放當前月份，之後用於印出月曆每日的月份(m/d)
                $currentMonth = $month;

                for($i=0; $i<6; $i++){
                    array_push($arr, '<tr>');

                    for($j=0; $j<7; $j++){

                        // 若$n小於0代表目前還是上一個月的日期
                        if($n <= 0){
                            $currentMonth = $month - 1;
                            if($currentMonth <= 0) $currentMonth = 12;

                            $prevLen = date('t', strtotime($year.'-'.$currentMonth.'-1'));
                            $d = $prevLen + $n;
                            if($currentMonth <= 0) $currentMonth = 12;

                            array_push($arr, '<td class="table-gray">'.$currentMonth.'/'.$d.'</td>');
                        }
                        // 若$n大於當前月份長度代表已經到了下一個月
                        else if($n > $len){
                            $d = $n - $len;
                            $currentMonth = $month + 1;
                            if($currentMonth > 12) $currentMonth = 1;

                            array_push($arr, '<td class="table-gray">'.$currentMonth.'/'.$d.'</td>');
                        }
                        else{
                            $w = date('w', strtotime($date.'-'.$n));
                            // 若日期為周六或周日，改變背景顏色
                            if($w == 0 || $w == 6) array_push($arr, '<td class="table-red">'.$month.'/'.$n.'</td>');
                            else array_push($arr, '<td>'.$month.'/'.$n.'</td>');
                        }

                        $n++;
                    }
                    array_push($arr, '</tr>');
                }

                return '<div class="calendar-table"><table>'.join($arr).'</table></div>';
            }

            
            echo calendar($_GET['year'], $_GET['month']);
            
            ?>
        </div>

        <div class="back-img back-img-01"></div>

    </div>

    <script src="./index.js"></script>
</body>
</html>
