<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (isset($_REQUEST['submit'])) {
        $chois_region=$_REQUEST['region'];
}else{  
        $chois_region="ALL";
}   
$xml_file = "azure_ip_ranges.xml";
$xml = simplexml_load_file($xml_file);

$region=$xml->Region;
$region_array=array();
$region_name=array();
$region_ip_cnt=array();

for ($i=0;$i<count($region);$i++) {
        $cnt=0;
        for ($j=0;$j<count($region[$i]->IpRange)+1;$j++) {
                if ($j==0) {
                        $region_array[$i][$j]=$region[$i]->attributes()->Name;
                }else{
                        $region_array[$i][$j]=$region[$i]->IpRange[$j-1]->attributes()->Subnet;
                }
                $cnt++;
#               echo $region_array[$i][0]." : ".$region_array[$i][$j]."<br>";
        }
        $region_ip_cnt[$i]=$cnt;
        $region_name[$i]=$region_array[$i][0];
#       echo $region_name[$i]."<br>";
}

#echo $region[1]->attributes()->Name."<br>";
#echo $region[1]->IpRange->attributes()->Subnet."<br>";
#print_r($xml);
?>
<!DOCTYPE html>
<html lang=en>
<head>
        <META charset="UTF-8" />
        <META http-equiv=X-UA-Compatible content="IE=Edge" />
        <META http-equiv="Expires" content="-1">
        <META http-equiv="Pragma" content="no-cache">
        <META http-equiv="Cache-Control" content="No-Cache">
        <META name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no" />
        <style type="text/css">

        ::selection { background-color: #E13300; color: white; }
        ::-moz-selection { background-color: #E13300; color: white; }

tr
        {mso-height-source:auto;
        mso-ruby-visibility:none;}
col
        {mso-width-source:auto;
        mso-ruby-visibility:none;}
br
        {mso-data-placement:same-cell;}
ruby
        {ruby-align:left;}
.style0
        {mso-number-format:General;
        text-align:general;
        vertical-align:middle;
        white-space:nowrap;
        mso-rotate:0;
        mso-background-source:auto;
        mso-pattern:auto;
        color:black;
        font-size:11.0pt;
        font-weight:400;
        font-style:normal;
        text-decoration:none;
        font-family:Arial, monospace;
        mso-font-charset:129;
        border:none;
        mso-protection:locked visible;
        mso-style-name:Table Normal;
        mso-style-id:0;}
td
        {mso-style-parent:style0;
        padding-top:3px;
        padding-right:10px;
        padding-left:10px;
        padding-bottom:3px;
        mso-ignore:padding;
        color:black;
        font-size:11.0pt;
        font-weight:400;
        font-style:normal;
        text-decoration:none;
        font-family:Arial, monospace;
        mso-font-charset:129;
        mso-number-format:General;
        text-align:general;
        vertical-align:middle;
        border:none;
        mso-background-source:auto;
        mso-pattern:auto;
        mso-protection:locked visible;
        white-space:nowrap;
        mso-rotate:0;}
.xl1
        {mso-style-parent:style0;
        color:white;
        font-weight:700;
        font-family:Arial, sans-serif;
        mso-font-charset:0;
        text-align:center;
        border:.5pt solid white;
        background:#282828;
        mso-pattern:black none;
        vertical-align:middle;
        white-space:normal;}
.xl2
        {mso-style-parent:style0;
        color:white;
        font-weight:200;
        font-family:Arial, sans-serif;
        mso-font-charset:0;
        text-align:center;
        border:.5pt solid white;
        background:#595959;
        mso-pattern:black none;
        vertical-align:middle;
        white-space:normal;}
.xl3
        {mso-style-parent:style0;
        font-family:Arial, sans-serif;
        color:black;
        mso-font-charset:0;
        text-align:center;
        border:.5pt solid windowtext;
        background:white;
        mso-pattern:black none;
        white-space:normal;}

        </style>
</head>
<title>Azure Public IP Ranges</title>
<body>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<table style='border-style:solid;border-collapse:collapse'>
<tr>
<th class=xl1>Region</th>
<th class=xl1>IP-Prefix</th>
</tr>
<?php
echo "<tr>";
echo "<td class=xl2>";
echo "<select name='region'>";
echo "<option value='ALL'>ALL</option>";
for($i=0;$i<sizeof($region_name);$i++) {
        echo "<option value=".$region_name[$i].">".$region_name[$i]."</option>";
}
echo "</select>";
echo  "</td>";
echo "<td class=xl2><input type='submit'  name='submit' value='submit'></td>";
echo "</tr>";
if ($chois_region=="ALL") {
        for ($l=0; $l<count($region_name);$l++) {
                for ($k=0; $k<$region_ip_cnt[$l];$k++) {
                        if ($k==0) { }
                        else {
                                echo "<tr>";
                                echo "<td class=xl3>".$region_array[$l][0]."</td>";
                                echo "<td class=xl3>".$region_array[$l][$k]."</td>";
                                echo "</tr>";
                        }
                }
        }
}else{
        for ($l=0; $l<count($region_name);$l++) {
                if ($region_name[$l]==$chois_region) {
                        for ($k=0; $k<$region_ip_cnt[$l];$k++) {
                                if ($k==0) { }
                                else {
                                        echo "<tr>";
                                        echo "<td class=xl3>".$region_array[$l][0]."</td>";
                                        echo "<td class=xl3>".$region_array[$l][$k]."</td>";
                                        echo "</tr>";
                                }
                        }
                }
        }
}
?>
</table>
</form>
</body>
</html>