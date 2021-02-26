<?

$ip = $_SERVER['REMOTE_ADDR'];


//$mysqli = new mysqli("instance17863.db.xeround.com", "test", "4namak$", "folio", 11858);

$db = sqlite_open('db/folio.db', 0666, $error);


function tableCols($table)
{
    global $db;
    $q = sqlite_query($db, "PRAGMA table_info(" . $table . ")");
    $columns = array();
    while ($a = sqlite_fetch_array($q)) {
        $columns[] = $a['name'];
    }
    return $columns;
}

function isColNumeric($col, $table)
{
    global $db;
    $q = sqlite_query($db, "PRAGMA table_info($table)");
    $columns = array();
    while ($a = sqlite_fetch_array($q)) {
        if ($a['name'] == $col) {
            return preg_match("/INT/", $a['type']) ? true : false;
        }
    }
    return false;
}

function prepValue($value, $col, $table)
{
    global $db;
    if (isColNumeric($col, $table)) {
        return $value;
    } else {
        return "'" . sqlite_escape_string($value) . "'";
    }
}
function mIns($data, $table)
{
    global $db;
    $cols = tableCols($table);
    $Q = '';
    $C = '';
    foreach ($data as $key => $value) {
        if (in_array($key, $cols)) {
            $C .= ($C == '' ? '' : ',') . $key;
            $Q .= ($Q == '' ? '' : ',') . prepValue($value, $key, $table);
        }
    }
    $q = "INSERT INTO " . $table . " (" . $C . ") VALUES (" . $Q . ")";
    sqlite_query($db, $q);
}
function insertVisitor($data = array())
{
    global $db;
    mIns($data, 'visitor');
}

function checkVisitor($ip)
{
    global $db;
    $delay = 60 * 15;
    $validTime = time() - $delay;
    $q = sqlite_query($db, "SELECT * FROM visitor WHERE ip='{$ip}' AND date_sent>{$validTime}");
    return sqlite_num_rows($q) < 1;
}

?><!DOCTYPE HTML>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>Thank You For Your Feedback!</title>
    <?

    $validContent = array('name', 'mail', 'site', 'subject', 'text', 'stars_radio');
    $formTags = array('name' => 'Name', 'mail' => 'e-mail', 'site' => 'Personal Site', 'subject' => 'Subject', 'text' => 'Text', 'stars_radio' => 'Rating');

    $sanitize = array(
        'name' => FILTER_SANITIZE_STRING,
        'mail' => FILTER_SANITIZE_EMAIL,
        'site' => FILTER_SANITIZE_URL,
        'subject' => FILTER_SANITIZE_STRING,
        'text' => FILTER_SANITIZE_STRING,
        'stars_radio' => FILTER_SANITIZE_NUMBER_INT,
        'submit' => FILTER_SANITIZE_STRING
    );

    $validate = array(
        'mail' => FILTER_VALIDATE_EMAIL,
        'site' => FILTER_VALIDATE_URL
    );
    $postData = array();

    foreach ($_POST as $key => $p) {
        if (in_array($key, $validContent) && $p != '') {
            $postData [$key] = filter_var($p, $sanitize[$key]);
        }
    }

    $dbData = $postData;
    $dbData['ip'] = $ip;
    $dbData['date_sent'] = time();


    $visitorOk = false;

    $maxLetters = 400;
    $letters = 0;
    $period = 21;


    if ( $db && checkVisitor($ip)) {

        $visitorOk = true;

        $mailTo = 'pavloschris@gmail.com';
        $subject = "CSSFolio";
        $message = '';
        foreach ($postData as $key => $value) {
            $message .= $key . ': ' . $value . '<br><br>';
        }
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: ' . $postData['mail'] . "\r\n" .
            'Reply-To: ' . $postData['mail'] . "\r\n" .
            $message = wordwrap($message, 70);

        @mail($mailTo, $subject, $message, $headers);
    }
    if($db){
    insertVisitor($dbData);
    }

    function spanitize($string)
    {
        global $maxLetters, $letters, $period;
        $split = str_split($string);
        $retString = '';
        foreach ($split as $spl) {
            if ($letters < $maxLetters) {
                $retString .= '<span id="span-' . $letters . '" class="span-' . ($letters % $period) . '">' . $spl . '</span>';
                $letters++;
            } else {
                return $retString;
            }
        }
        return $retString;

    }

    $retString = '';
    foreach ($postData as $key => $value) {
        if ($letters < $maxLetters) {
            $retString .= spanitize($formTags[$key] . ': ');
            $retString .= spanitize($value) . ' ';
        } else {
            break;
        }
    }
    ?>

    <style type="text/css">
        html {
            height: 100%;
        }

        body {
            -moz-perspective: 400px;
            -webkit-perspective: 400px;
            overflow: hidden;
            height: 100%;
            font-family: "Lucida Sans Unicode", "Lucida Grande";
            color: #333;
        }

        #announce { position: absolute; width: 500px; height: 300px; margin: auto; top: 0; left: 0; right: 0; bottom: 0; text-align: center; font-size: 16px; }

        #span-wrapper {
            width: auto;
            height: 200px;
            padding-bottom: 50px;
            font-size: 30px;
            white-space: nowrap;
            -moz-transform: rotateY(35deg) translate3d(0, 300px, 0);
            -moz-transform-origin: 100% 0;
            -webkit-transform: rotateY(35deg) translate3d(0, 300px, 0);
            -webkit-transform-origin: 100% 0;
            -moz-animation: mf 39s;
            -webkit-animation: mf 39s;
            -moz-animation-timing-function: linear;
            -webkit-animation-timing-function: linear;
            -moz-animation-fill-mode: forwards;
            -webkit-animation-fill-mode: forwards;
            position: absolute; right: 0;
            overflow: visible;
        }

        span {
            width: auto; height: auto; position: relative;
            -moz-animation: ud 1s;
            -moz-animation-iteration-count: infinite;
            -moz-animation-timing-function: ease-in-out;
            -webkit-animation: ud 1s;
            -webkit-animation-iteration-count: infinite;
            -webkit-animation-timing-function: ease-in-out;
            overflow: visible;
        }


        <?
        for ($i = $period; $i > 0; $i--) {
            ?>
        .span-<?=$period - $i;?> { -moz-animation-delay: <?=$i * 50;?>ms !important; -webkit-animation-delay: <?=$i * 50;?>ms !important; }
            <?
        }
        ?>


        @-moz-keyframes ud {
  0% {top: 100%;   text-shadow: 0px 50px 0px rgba(0,0,0,0.2);  }
  50% {top:0;     text-shadow: 0px 400px 0px rgba(0,0,0,0);   }
  100% {top:100%;   text-shadow: 0px 50px 0px rgba(0,0,0,0.2);   }
}
        @-webkit-keyframes ud {
  0% {top: 100%;  }
  50% {top:0;    }
  100% {top:100%;    }
}
        @-moz-keyframes mf {
  0% {-moz-transform:rotateY(35deg) translate3d(-1500px,300px,-1000px);}
  80% {opacity:1; visibility:visible;}
  100% {-moz-transform:rotateY(35deg) translate3d(10000px,300px,-1000px); opacity:0;}
}
        @-webkit-keyframes mf {
  0% {-webkit-transform:rotateY(35deg) translate3d(-1500px,300px,-1000px);}
    80% {opacity:1;visibility:visible;}
    100% {-webkit-transform:rotateY(35deg) translate3d(10000px,300px,-1000px); opacity:0;visibility:collapse;}
}

    </style>
</head>
<body>


<div id="announce">
    <?
    if ($visitorOk) {
        ?>
        <h1>Your Message Has Been Sent</h1>

        <h1>Thank You For Your Feedback</h1>
        <? } else { ?>
        <h1>You have Already sent a message..</h1>

        <h1>Please Try Again Later</h1>

        <? }?>
</div>

<?
echo '<div id="span-wrapper">' . $retString . '</div>';
?>

</body>
</html>
