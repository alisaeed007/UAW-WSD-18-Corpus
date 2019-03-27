<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>All Words Task</title>
</head>
<body>
<?php
function mbStringToArray ($string) { 
    $strlen = mb_strlen($string); 
    while ($strlen) { 
        $array[] = mb_substr($string,0,1,"UTF-8"); 
        $string = mb_substr($string,1,$strlen,"UTF-8"); 
        $strlen = mb_strlen($string); 
    } 
    return $array; 
} 
function getSenses($word)
{
	$con=mysqli_connect("localhost","root","","all_words");
	$sql = "SELECT sense1,sense2,sense3,sense4,sense5,sense6,sense7,sense8,sense9,sense10,sense11 FROM gloss where word= '".$word."'";
	
	$result = mysqli_query($con, $sql);
	$row = mysqli_fetch_assoc($result);
	return $row;
}
function get_No_of_Senses($d)
{
$fr=count(array_filter($d))-1;
return $fr;
}
function getData($SenNo)
{
	$con=mysqli_connect("localhost","root","","all_words");
	$sql = "SELECT word, sentence FROM corpus2 where no= '".$SenNo."'";
	
	$result = mysqli_query($con, $sql);
	$row = mysqli_fetch_assoc($result);
	return $row;
	
}
$con=mysqli_connect("localhost","root","","all_words");
for($g=1;$g<=856;$g++){

$data=getData($g);// SenNo ranges from 1- 856

//$data["word"] contains the word
//$data["sentence"] contains the sentence
$main_sentence=$data["sentence"];


$word=$data["word"];

echo "<br><h4>For Sentence ".$g."</h4><br>";
echo "Word=".$word."Sentence=".$main_sentence;

if($g==1){$word="آج";}

if($g==86){$word="ابنِ";}

else if($g==790){
	$gloss_senses=array("sense1"=>"ڈنڈ، جرمانہ، بدلا، قصاص، کفارہ۔", 
"sense2"=>"ہ رقم جو مفتوح یا شکست خوردہ سلطنت فاتح کو بطور جرمانہ یا خرچہ دیا کرتی ہے۔",
);
}
else if($g==108){
	$gloss_senses=array("sense1"=>"وہ چیز جس میں برکت ہونے کا اعتقاد ہو، خیر و برکت کی چیز", 
"sense2"=>"تحفہ، بزرگوں کا عطیہ",
"sense3"=>"- کسی بزرگ یا پیشوائے دین کی فاتحہ کی چیز، پرشاد",
"sense4"=>" [ مجازا ]  'ایسی نایاب و مبارک چیز جو عنقریب فنا ہو جانے والی ہو",
);

}
else if($g==842){
	$gloss_senses=array("sense1"=>"حفظ کرنا، یاد کرنا", 
"sense2"=>"حفاظت، محفوظ کرنا",
);

	
}
else if($g==21 || $g==32 || $g==44 || $g==54 || $g==65|| $g==117 || $g==139 || $g==143 || $g==145 || $g==151 || $g==186 || $g==188 || $g==502 || $g==517 || $g==524 || $g==548|| $g==619|| $g==644|| $g==766|| $g==771|| $g==780|| $g==837)
{
$gloss_senses=array("sense1"=>"آپ کے جانے کے بعد سے گھر بھائیں بھائیں کر رہا ہے اللہ اس دم کو رکھے۔", 
"sense2"=>"کیوں گر پڑی یہ، خیر تو ہے کیا ہوا اسے اللہ! میرے ہونٹ بھی زہریلے ہو گئے",
"sense3"=>"اللہ اختر تم اتنے کٹھور بھی ہو سکتے ہو آخر کسی لی",
"sense4"=>"تسکین مرگ بھول گیا اضطراب میں اللہ پڑ گیا مرا دل کس عذاب میں",
"sense5"=>"جنون عشق نے سوداے شوق نے کھویا دماغ سے کہیں اللہ یہ خلل جاتے",
);

}
else
{	
$gloss_senses=getSenses($word);// it will return all the senses of a given word
}
////////////////////////////////////////////////////////////////////////////////////////////
 
if(is_null($gloss_senses))
{
echo "<br>For word ".$word." it has Error==================<br><br>";	
}
else
{
	echo "<br>For word ".$word." it has following senses:<br>";
	
	$no=get_No_of_Senses($gloss_senses);
	if($g==21 || $g==32 || $g==44 || $g==54 || $g==65|| $g==117 || $g==139 || $g==143 || $g==145 || $g==151 || $g==186 || $g==188 || $g==502 || $g==517 || $g==524 || $g==548|| $g==619|| $g==644|| $g==766|| $g==771|| $g==780|| $g==837)
	{
		$no=5;
	}
	if($g==842){$no=2;}
	if($g==108){$no=4;}
	if($g==790){$no=2;}
	
	$ov_sim=0;$ov_sen=1;
	$jac_sim=0;$jac_sen=1;
	$dice_sim=0;$dice_sen=1;
	$euc_sim=0;$euc_sen=1;
	$cos_sim=0;$cos_sen=1;
	
	for($f=1;$f<=$no;$f++)
	{
		echo "<br><b style='color:red'>".$main_sentence."</b>";
		$ff="sense".$f;
		echo $ff."=<b style='color:green'>".$gloss_senses[$ff]."</b><br>";
		
	//	$m1=explode(" ", $main_sentence);
		//$s1=explode(" ", $gloss_senses[$ff]);
		
		$m1=mbStringToArray($main_sentence);
		$s1=mbStringToArray($gloss_senses[$ff]);
		print_r($m1);
		echo "<br>";
		print_r($s1);

		echo "<br>Number of Sentences in main sentence:".sizeof($m1)."<br>";
		echo "Number of Sentences in:".$ff."=".sizeof($s1)."<br>";
		
		$result1=array_intersect($m1,$s1);
		$inter=sizeof($result1);
		echo "Intersection=".$inter;
		
		$mv=min(sizeof($m1),sizeof($s1));
		
		$ov=$inter/$mv;

		if($f==1)
		{
		$ov_sim=$ov;
		$ov_sen=1;
		}
		
		if($ov>$ov_sim)
		{
			$ov_sim=$ov;
			$ov_sen=$f;
		}
		echo "<br> Overlap Similarity=".$ov;
		
		
		$ms=array_merge($m1,$s1);
		
		$union=sizeof($ms)-$inter;
	
		$js=$inter/$union;
		
		
		if($f==1)
		{
		$jac_sim=$js;
		$jac_sen=1;
		}
		
		if($js>$jac_sim)
		{
			$jac_sim=$js;
			$jac_sen=$f;
		}
		
		
		
		echo "<br> Jaccard Similarity=".$js;
		
		$d_inter=$inter*2;
		$p1=sizeof($m1)*sizeof($m1);
		$p2=sizeof($s1)*sizeof($s1);
		$tot=$p1+$p2;
		$dice=$d_inter/$tot;
		
		
		if($f==1)
		{
		$dice_sim=$dice;
		$dice_sen=1;
		}
		
		if($dice>$dice_sim)
		{
			$dice_sim=$ov;
			$dice_sen=$f;
		}
		
		
		echo "<br> Dice Similarity=".$dice."<br>";
		
		echo "Euclidean Distance=";
		$min=min(sizeof($m1),sizeof($s1));
		$max=max(sizeof($m1),sizeof($s1));
		$diff=$max-$min;
		$same=0;
		for($kk=0;$kk<$min;$kk++)
		{
			if($m1[$kk]!=$s1[$kk])
			{
				$same++;
			}
		}
		$final_val=$same+$diff;
		$eu= sqrt($final_val);
		echo $eu."<br>";
		
		
		if($f==1)
		{
		$eu_sim=$eu;
		$eu_sen=1;
		}
		
		if($eu<$eu_sim)
		{
			$eu_sim=$eu;
			$eu_sen=$f;
		}
	
		
		
		
		echo "Cosine Similarity=";
		$result3 = array_unique($ms);
			
		//print_r($result3);
		//echo sizeof($result3);
		
		$w3=0;$w6=0;$w7=0;
		for($i=0;$i<sizeof($result3)+2;$i++)
		{
			if(isset($result3[$i]))
			{
				$w1=0;$w2=0;
				$tm1=array_count_values($m1);
				$ts1=array_count_values($s1);
				
				if (isset($ts1[$result3[$i]])){$w1=$ts1[$result3[$i]];}
				if (isset($tm1[$result3[$i]])){$w2=$tm1[$result3[$i]];}
				
				
				if(!isset($result3[$w1])){$w1=0;}
				if(!isset($result3[$w2])){$w2=0;}
				$w3=$w3+$w1*$w2;
				
				$w4=$w1*$w1;
				$w5=$w2*$w2;
				
				$w6=$w6+$w4;
				$w7=$w7+$w5;
				//echo "<br>".$result3[$i]."".$w1." ".$w2;
			}
		}
	//w3 w6 w7
	$c1=sqrt($w6);
	$c2=sqrt($w7);
		
	$ans=$w3/($c1*$c2);
	echo $ans;
	
	if($f==1)
		{
		$cos_sim=$ans;
		$cos_sen=1;
		}
		
		if($ans>$cos_sim)
		{
			$cos_sim=$ov;
			$cos_sen=$f;
		}	
		
	}
echo "OVERLAP SENSE=".$ov_sen;

echo "Jacard SENSE=".$jac_sen;

echo "Dice SENSE=".$dice_sen;

echo "EU SENSE=".$eu_sen;

echo "COS SENSE=".$cos_sen;

//mysqli_query($con,"INSERT INTO chargram1 (jacard, overlap, dice, euc, cos) VALUES (".$jac_sen.",".$ov_sen.",".$dice_sen.",".$euc_sen.",".$cos_sen.")");

//echo "FFFFFFFFFFFFFF".$g;

//$qry="UPDATE corpus1 SET jacard_w1=".$jac_sen.", overlap_w1=".$ov_sen.", dice_w1=".$dice_sen.", euc_w1=".$eu_sen.", cos_w1=".$cos_sen." WHERE no=".$g.""; 

//mysqli_query($con,"INSERT INTO corpus1 (jacard_w1, overlap_w1, dice_w1, euc_w1, cos_w1) VALUES (".$jac_sen.",".$ov_sen.","..","..","..")");

//mysqli_query($con, $qry);

}

}


?>





</body>
</html>