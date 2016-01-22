<center>
 <?php

if(!isset($_POST['Submit']))
{
	echo "Please enter the name you want to check, Please Dont include <strong>www.</strong><br/>Please add multiple in different line only";
    echo '<form method="POST" action="' . $_SERVER['PHP_SELF'] . '">'
            . '<textarea cols="30" rows="10" name="domains" ></textarea><br />'
            . '<input type="submit" name="Submit" value="Submit">'
            . '</form>';
}
else
{
    $domains = explode("\n", str_replace(array("\r\n", "\r"), "\n", $_POST['domains']));
    
    foreach($domains as $domain)
    {
        if(is_avail($domain))
        {
            $pieces = explode(".", $domain, 1);
            echo $domain . "<strong> is available. </strong><br/>";
        }
		else
		{
			echo $domain . "<strong> is not available. </strong><br/>";
		}
    }
}

function is_avail($domain)
{    
    $pieces = explode(".", $domain);
    $server = (count($pieces) == 2) ? $pieces[1] : $pieces[1] . "." . $pieces[2];
    $server .= ".whois-servers.net";
    $fp = fsockopen($server, 43, $errno, $errstr, 10);
    $result = "";
    if($fp === FALSE){ return FALSE; }
    fputs($fp, $domain . "\r\n");    
    while(!feof($fp)){ $result .= fgets($fp, 128); }
    fclose($fp);
    
    return ((stristr($result, 'no match for') !== FALSE) || (strtolower($result) == "notfound\n")) ? TRUE : FALSE;
}

?> 
<div style="position:fixed; top:90%; width:100%">
	Proudly Powered by <strong>Cybee World</strong> || You Imagine, We Create
</div>
</center>