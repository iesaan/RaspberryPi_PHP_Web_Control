<?php
//#4, #7, #8, #9, #10, #11, #18, #21, #22, #23, #24, #25, #27  <-- ใช้ได้แค่นี้เองนะจ๊ะ
$array_pin = array(
	"ห้องครัว หลอดไฟ หน้าตู้เย็น" => 18,
	//"xx" => 21,
	//"xx" => 22,
	"ห้องน้ำ หลอดไฟ" => 23,
	"ห้องรับแขก หลอดไฟทั้ง 2 หลอด" => 24,
	"ห้องนอนใหญ่ หลอดไฟทั้ง 2 หลอด" => 25
   // "seventeen" => 27
   // อันสุดท้ายไม่มี คอมม่า
);

//วนลูป กำหนดค่า พิน output
foreach ($array_pin as $value => $key){	
	exec("/usr/local/bin/gpio -g mode $key out");	
} //end foreach

//รับค่าจาก url
if(isset($_GET['pin']) and isset($_GET['set'])){	//เช็คว่า มีการส่งค่ามาหรือไม่
$pin =$_GET['pin'];
	if($_GET['set']=='on'){	//เช็ค on/off
		exec("/usr/local/bin/gpio -g write $pin 1 "); //สั่ง ติด
	}else{
		exec("/usr/local/bin/gpio -g write $pin 0 "); //สั่ง ดับ
	}
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
  <title>Home Automation</title>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="table.css">
  </head>
  <body>
  <table id="customers">
      <h3 align="left">ระบบบริหารจัดการควบคุมไฟฟ้าภายในบ้านผ่านเว็บไซต์</h3>
      <thead>
        <tr>
          <th width="50">ลำดับ</th>
          <th>ชื่ออุปกรณ์</th>
          <th width="100">พินที่</th>
          <th width="60">ทำงาน</th>
        </tr>
      </thead>
      <tbody>
<?php
 //เริ่มเช็คสถานะ แต่ละ pin ใน array
 $i=1;
foreach ($array_pin as $value => $key){
?>
        <tr>
          <td><?php echo $i;?></td>
          <td><?php echo $value;?></td>
          <td><?php echo $key;?></td>
          <td>
          <?php 
		  if((exec("/usr/local/bin/gpio -g read $key")==1)){
			  	echo '<input name="on" type="button" value="เปิด" onClick="window.open(\'index.php?pin='.$key.'&set=off\',\'_self\')">';
          }else { 
			  	echo '<input name="on" type="button" value="ปิด"  onClick="window.open(\'index.php?pin='.$key.'&set=on\',\'_self\')">';
          }?>
          </td>
        </tr>
        <tr>
<?php	
$i++;
}//foreach
 ?>       
      </tbody>
    </table>
  </body>
</html>

