<?php

$_IMAGE_COUNTER = 0;
$_DETAIL_COUNTER = 0;
class DetailedImage
{
    private $image,$imageW,$imageH,$wScale,$hScale,$id;
    public $displayW,$displayH;
    private $details;

    function  __construct($image,$displayW,$displayH,$title="Untitled",$desc='')
    {
        global $_IMAGE_COUNTER;
        $this->image = $image;
        $this->desc = $desc;
        $this->title = $title;
        $imgSize = getimagesize($image);
        $this->imageW = $imgSize[0];
        $this->imageH = $imgSize[1];
        $this->displayW = $displayW;
        $this->displayH = $displayH;
        $this->wScale = $this->imageW/$this->displayW;
        $this->hScale = $this->imageH/$this->displayH;
        $this->details = array();
        $this->id = $_IMAGE_COUNTER++;

    }

    function addDetail($x,$y,$w,$h,$desc)
    {
        $this->details[] = new Detail($x,$y,$w,$h,$desc);
    }

    function __toString(){

        $ret =  "<li style=\"background: url('{$this->image}') 0 0 no-repeat; background-size: contain;\" class='imgCont' id='imgCont_{$this->id}'><div class=\"effImage\" style=\"background: url('{$this->image}') 0 0 no-repeat; background-size: contain;\"></div>";
        foreach ($this->details as $detail) {
            $bgPosX = $detail->x*$this->wScale;
            $bgPosY = $detail->y*$this->hScale;
            $detW = $detail->w * $this->wScale;
            $detH = $detail->h * $this->hScale;
            $scale = 1/$this->wScale;
            $contL = ( $detail->w - $detW)/2;
            $contT =  ($detail->h - $detH )/2 ;
        $ret .= <<<HTML
            <div class="imgDetailWrap" style="width:{$detail->w}px;height:{$detail->h}px; left: {$detail->x}px;top: {$detail->y}px; ">
            <div class="imgDetail"
            style="background:  url('{$this->image}') 0 0 no-repeat;
            background-size: auto;
            background-position: -{$bgPosX}px -{$bgPosY}px;
            width:{$detW}px;
            height:{$detH}px;
            left:{$contL}px;
            top:{$contT}px;
            -webkit-transform: scale({$scale});
            -moz-transform: scale({$scale});
            -ms-transform: scale({$scale});
            -o-transform: scale({$scale});
            transform: scale({$scale});
            "
            >
                <div id="detailDesc_{$detail->id}" class="detailDesc">{$detail->showDesc()}</div>
            </div></div>
HTML;

        }
        $ret.= '<div class="detailBg"></div><div class="imgDescWrap"><div class="imgDescBg"></div><div id="imgDesc'.$this->id.'" class="imgDesc"><p>'.$this->desc.'</p></div></div></li>';
        return $ret;
    }

    public function  radio($extra){
        ?>
        <input type="radio" id="imgRadio_<?=$this->id;?>" name="imagesRadio" <?=$extra;?>>
        <?
    }

    public function  label($extra=''){
        ?>
    <label for="imgRadio_<?=$this->id;?>"  <?=$extra;?>><?=$this->title;?><div class="labelBg"><?=$this->title;?></div></label>
        <?
    }

    public function infoLabel(){
        if($this->desc !=''){
            ?>
        <label for="descCheck<?=$this->id;?>" class="descCheckLabel"></label>
            <?
        }

    }

    public function infoCheck(){
        if($this->desc !=''){
            ?>
        <input type="checkbox" id="descCheck<?=$this->id;?>" class="descCheck">
        <?
        }

    }

    public function style()
    {
        ?>
        #imgRadio_<?=$this->id;?>:checked ~ #bigImages #imgCont_<?=$this->id;?> { visibility:visible; opacity:1; -moz-transition-duration:700ms; -moz-transition-delay:300ms;-webkit-transition-duration:700ms; -webkit-transition-delay:300ms;}
        #imgRadio_<?=$this->id;?>:checked ~ #imgLabels [for='imgRadio_<?=$this->id;?>'] .labelBg { left:0; width:100%; opacity:1; visibility:visible; text-indent:0;}
        #imgRadio_<?=$this->id;?>:checked ~ #infoButs [for='descCheck<?=$this->id;?>'] {display:inline-block;}
        #descCheck<?=$this->id;?>:checked ~ #bigImages #imgCont_<?=$this->id;?> { -moz-transform: rotateY(180deg);-webkit-transform: rotateY(180deg); }
        #descCheck<?=$this->id;?>:checked ~ #infoButs [for='descCheck<?=$this->id;?>'] { background-color: #fafafa;}
    <?
    }

}
class Detail
{
    public  $x,$y,$desc,$w,$h,$id;

    function __construct($x,$y,$w,$h,$desc)
    {
        global $_DETAIL_COUNTER;
        $this->x = $x;
        $this->y = $y;
        $this->w = $w;
        $this->h = $h;
        $this->desc = $desc;
        $this->id = $_DETAIL_COUNTER++;
    }

    public function showDesc()
    {
        $expDesc =  str_split($this->desc);
        $ret = '';
        foreach ($expDesc as $l) {
            $dur = rand(100,500);
            $delay = rand(100,500);
            $ret .= '<span style="text-shadow:0 0 0 #333;
            -moz-transition:text-shadow '.$dur.'ms ease-in-out '.$delay.'ms;
            -webkit-transition:text-shadow '.$dur.'ms ease-in-out '.$delay.'ms;
            transition:text-shadow '.$dur.'ms ease-in-out '.$delay.'ms;"
            >'.$l.'</span>';
        }
        return $ret;
    }
}
$img = array();
$i = 0;
$img[$i] = new  DetailedImage('files/gallery/1/dancing-face.jpg',300,300,"The Dancer",
    "The Dancer is a Spiritual Creature bound between the gates of Heaven and the Deepest pit of Hell, Cursed to dance the eternal dance of sorrow and despair.");
$img[$i]->addDetail(70,30,160,160,"The Dancer");
$i++;
$img[$i] = new  DetailedImage('files/gallery/1/pisw_apo.jpg',300,300,"Behind The Cafe",
    "The Loneliest Road of them all, is the small stone road behind the <q>Cafe Terrace</q>.Strangely, it's always night on that road. Only cats enjoy themselves in that bitter cursed place");
$img[$i]->addDetail(160,50,140,70,"The Milky Way");
$img[$i]->addDetail(165,155,85,45,"The Cat");
$img[$i]->addDetail(75,95,69,100,"The Lamp");
$img[$i]->addDetail(5,160,75,70,"The Moon");
$i++;
$img[$i] = new  DetailedImage('files/gallery/1/TheUnconventionalQeen2.jpg',300,300,"The Unconventional",
    "The Unconventional Queen Is always Smiling. Unconventional as she is, she is constantly looking at the opposite directions the others do, <q>It's a Gift!</q> She says <q>I have seen things no other man nor woman have ever, ever seen</q>");
$img[$i]->addDetail(120,90,170,120,"The Glass");
$img[$i]->addDetail(225,250,50,50,"The Queen");
$img[$i]->addDetail(10,100,50,50,"The Knot");
$i++;
$img[$i] = new  DetailedImage('files/gallery/1/shaman.jpg',300,300,"The Shaman",
    "The Shaman, is the last man that have seen the last Unicorn alive. Unfortunately, he is also the man that saw him die. Now, he seeks to kill the man that saw the Unicorn before him");
$img[$i]->addDetail(255,70,50,50,"The Fish Bone");
$img[$i]->addDetail(45,75,50,50,"The Topaz");
$img[$i]->addDetail(150,25,150,50,"The Vulture Feather");
$i++;
$img[$i] = new  DetailedImage('files/gallery/1/insomnia.jpg',300,300,"Insomnia",
    "All the nightmares that wake beings up from their sleep and they are immediately forgotten, gather together and come back to the material world to torture the sleepless minds of men");
$img[$i]->addDetail(185,115,100,80,"The Death Hound");
$img[$i]->addDetail(40,50,60,100,"The Horn Of Nightmares");
$img[$i]->addDetail(145,55,80,55,"The Eternal Tree");
$i++;
$img[$i] = new  DetailedImage('files/gallery/1/screamers.jpg',300,300,"The Screamers",
    "When the Judgement Comes, those who made no choice in fear of making a bad choice, will be left to the void between heaven and hell. Those that make no choice, have no place to belong, they will scream until the end of ages");
$img[$i]->addDetail(240,100,50,90,"The DED");
$img[$i]->addDetail(180,110,50,70,"The Screamer");

?>

<div id="gallery" class="page page2">
    <style type="text/css">
        <?
        foreach ($img as $image) {
            $image->style();
        }
        ?>

    </style>    <h1>Notes From The Lethargy</h1>
    <div class="constrict">

    <?
    $k = 0;
    foreach ($img as $image) {
        echo  $image->radio(($k++==0)?"checked":'');
        echo  $image->infoCheck();
    }
    ?>

        <ul id="bigImages">
        <?
        foreach ($img as $image) {
            echo    $image;
        }
        ?>
    </ul>

    <ul id="imgLabels">
        <?
        foreach ($img as $image) {
            echo    ' <li>';
                $image->label();
            echo '</li>';
        }
        ?>
    </ul>

        <ul id="infoButs">
            <?
            foreach ($img as $image) {
                echo    ' <li>';
                $image->infoLabel();
                echo '</li>';
            }
            ?>

        </ul>
    </div>
</div>