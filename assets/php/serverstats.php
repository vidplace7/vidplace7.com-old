<?
if (strpos(strtolower(PHP_OS), "win") === false)
	$loads = sys_getloadavg();
else
	$loads = Array(0.55,0.7,1);
	
function getSystemMemInfo()
{       
    $data = explode("\n", file_get_contents("/proc/meminfo"));
    $meminfo = array();
    foreach ($data as $line) {
    	@list($key, $val) = explode(":", $line);
    	$meminfo[$key] = trim($val);
    }
    return $meminfo;
}

function makeDiskBars()
{
	printBar(getDiskspace("/"), "Root");
	printBar(getDiskspace("/data"), "Data");
}

function makeRAMBars()
{
	printBar(getFreeRam());
}

function makeLoadBars()
{
	printBar(getLoad(0), "1 min");
	printBar(getLoad(1), "5 min");
	printBar(getLoad(2), "15 min");
}

function getFreeRam()
{
	$sysInfo = getSystemMemInfo();
	$free = intval(str_replace(" kb", "", $sysInfo['MemFree']));
	$total = intval(str_replace(" kb", "", $sysInfo['MemTotal']));
	$ramUsed =  $total - $free;
	return sprintf('%.0f',($ramUsed / $total) * 100);
}

function getDiskspace($dir)
{
	$df = disk_free_space("/");
	$dt = disk_total_space("/");
	$du = $dt - $df;
	return sprintf('%.0f',($du / $dt) * 100);
}

function getLoad($id)
{
	return 100 * $GLOBALS['loads'][$id];
}

function printBar($value, $name = "")
{
	if ($name != "") echo '<!-- ' . $name . ' -->';
	echo '<div>';
		if ($name != "")
			echo $name . ": ";
			echo $value . "%";
		echo '<div class="progress progress-warning progress-striped active">';
			echo '<div class="bar" style="width: ' . $value . '%"></div>';
		echo '</div>';
	echo '</div>';
}
?>