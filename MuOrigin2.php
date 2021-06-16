<?php
#Agusanz - MuOrigin2
#eMail: Dev@Agusanz.com
#Twitter: https://twitter.com/Agusanz_92
#Github: https://github.com/Agusanz
#Discord: Agusanz#5669
#Crontab: */1 * * * * php /home/agusanz/MuOrigin2/MuOrigin2.php >> /home/agusanz/MuOrigin2/MuOrigin2.log

$Debug = 0;
$event_Abyss = 1;
$event_Archangel = 0;
$configs = include('config.php');
//date_default_timezone_set('US/Eastern');
date_default_timezone_set($configs['Timezone']);

//Funciones
function getTimeYellow()
{
	//$unixTime = time();
	//$realTimeW = date('[Y-m-d] [H:i:s]',$unixTime);
	//$realTime = fg_color('yellow', $realTimeW);

	$microtime = microtime(true);
	$micro = sprintf("%06d",($microtime - floor($microtime)) * 1000000);
	$datetime = new DateTime( date('Y-m-d H:i:s.'.$micro, $microtime) );
	$realTime = fg_color('yellow', $datetime->format("[Y-m-d] [H:i:s.u]"));

	return $realTime;
}

function fg_color($color, $string)
{
	$foreground = array(
		'default' => '0;39',
		'white' => '0;97',
		'light_gray' => '0;37',
		'dark_gray' => '0;90',
		'black' => '0;30',
		'red' => '0;31',
		'light_red' => '1;31',
		'green' => '0;32',
		'light_green' => '1;32',
		'yellow' => '0;33',
		'light_yellow' => '1;33',
		'blue' => '0;34',
		'light_blue' => '1;34',
		'magenta' => '0;35',
		'light_magenta' => '1;35',
		'cyan' => '0;36',
		'light_cyan' => '1;36',
	);

	if (!isset($foreground[$color]))
	{
		throw new \Exception('Foreground color is not defined');
	}

	return "\033[" . $foreground[$color] . "m" . $string . "\033[0m";
}

function bg_color($color, $string)
{
	$background = array(
		'black' => '40',
		'red' => '41',
		'magenta' => '45',
		'yellow' => '43',
		'green' => '42',
		'blue' => '44',
		'cyan' => '46',
		'light_gray' => '47',
	);

	if (!isset($background[$color]))
	{
		throw new \Exception('Background color is not defined');
	}

	return "\033[" . $background[$color] . 'm' . $string . "\033[0m";
}

function telegram($type,$notification,$msg)
{
	try
	{
		global $configs;
		$TelegramToken = $configs['TelegramToken'];
		$TelegramIDChat = $configs['TelegramIDChat'];
		$TelegramIDGroup = $configs['TelegramIDGroup'];

		if($type == "private")
		{
			$TelegramID = $TelegramIDChat;
		}
		elseif($type == "group")
		{
			$TelegramID = $TelegramIDGroup;
		}
		else
		{
			$TelegramID = $TelegramIDChat;
		}
		if($notification == "true")
		{
			$url='https://api.telegram.org/bot'.$TelegramToken.'/sendMessage';$data=array('chat_id'=>$TelegramID,'text'=>$msg);
		}
		elseif($notification == "false")
		{
			$url='https://api.telegram.org/bot'.$TelegramToken.'/sendMessage';$data=array('chat_id'=>$TelegramID,'text'=>$msg,'disable_notification'=>true);
		}
		$options=array('http'=>array('method'=>'POST','header'=>"Content-Type:application/x-www-form-urlencoded\r\n",'content'=>http_build_query($data),),);
		$context=stream_context_create($options);
		$result=file_get_contents($url,false,$context);
		$x = fg_color('green', "[Telegram]");
		$realTime = getTimeYellow();
		echo $realTime."\t{$x} {$type} [MSG] - {$msg}\n";
		return $result;
	}
	catch(Exception $e)
	{
		$svError = $e->getMessage();
		$x = fg_color('red', "[ERROR catch TelegramFunction]");
		$realTime = getTimeYellow();
		echo $realTime."\t{$x} ".$svError."\n";
		telegram("private", "true", "[ERROR catch TelegramFunction] {$svError}");
		return;
	}
}
//Funciones

try
{
    #Agusanz
    $Events = Array
    (
        //World/Abyss   Event                   Mu Time     Mon Tue Wed Thu Fri Sat Sun Notification
        array("World",  "Harmatium",            "09:00",    1,  1,  1,  1,  1,  1,  1,  "true" ),
        array("World",  "Boss",                 "10:00",    1,  1,  1,  1,  1,  1,  1,  "false"),
        array("World",  "Boss",                 "11:00",    1,  1,  1,  1,  1,  1,  1,  "false"),
        array("World",  "Harmatium",            "12:00",    1,  1,  1,  1,  1,  1,  1,  "true" ),
        array("World",  "Boss",                 "12:00",    1,  1,  1,  1,  1,  1,  1,  "false"),
        array("World",  "Angel's Trial",        "12:20",    1,  1,  1,  1,  1,  1,  1,  "true" ),
        array("World",  "Boss",                 "13:00",    1,  1,  1,  1,  1,  1,  1,  "false"),
        array("World",  "Boss",                 "14:00",    1,  1,  1,  1,  1,  1,  1,  "false"),
        array("World",  "Harmatium",            "15:00",    1,  1,  1,  1,  1,  1,  1,  "true" ),
        array("World",  "Boss",                 "15:00",    1,  1,  1,  1,  1,  1,  1,  "false"),
        array("World",  "Lost Castle",          "15:00",    1,  0,  0,  0,  0,  0,  0,  "true" ),
        array("World",  "Boss",                 "16:00",    1,  1,  1,  1,  1,  1,  1,  "false"),
        array("World",  "Boss",                 "17:00",    1,  1,  1,  1,  1,  1,  1,  "false"),
        array("World",  "Harmatium",            "18:00",    1,  1,  1,  1,  1,  1,  1,  "true" ),
        array("World",  "Boss",                 "18:00",    1,  1,  1,  1,  1,  1,  1,  "false"),
        array("World",  "Boss",                 "19:00",    1,  1,  1,  1,  1,  1,  1,  "false"),
        array("World",  "Loren Feast",          "20:00",    1,  1,  1,  1,  1,  1,  0,  "true" ),
        array("World",  "Guild Bonfire",        "20:00",    1,  1,  1,  1,  1,  1,  1,  "true" ),
        array("World",  "Boss",                 "20:00",    1,  1,  1,  1,  1,  1,  1,  "false"),
        array("World",  "Lost Castle",          "20:30",    1,  0,  0,  0,  0,  0,  0,  "true" ),
        array("World",  "Guild Battle",         "20:30",    0,  0,  0,  0,  1,  0,  0,  "true" ),
        array("World",  "Boss",                 "21:00",    1,  1,  1,  1,  1,  1,  1,  "false"),
        array("World",  "Harmatium",            "21:00",    1,  1,  1,  1,  1,  1,  1,  "true" ),
        array("World",  "Lost Tower",           "21:00",    0,  0,  1,  0,  0,  0,  0,  "true" ),
        array("World",  "Chaos Castle",         "21:00",    0,  0,  0,  0,  1,  0,  0,  "true" ),
        array("World",  "Loren Castle Siege",   "21:00",    0,  0,  0,  0,  0,  0,  1,  "true" ),
        array("World",  "Boss",                 "22:00",    1,  1,  1,  1,  1,  1,  1,  "false"),
        array("World",  "Boss",                 "23:00",    1,  1,  1,  1,  1,  1,  1,  "false"),
        array("World",  "Land of Ordeal",       "23:30",    1,  1,  1,  1,  1,  1,  1,  "false"),
        array("World",  "Boss",                 "00:00",    1,  1,  1,  1,  1,  1,  1,  "false"),
        array("World",  "Boss",                 "01:00",    1,  1,  1,  1,  1,  1,  1,  "false"),
        //World/Abyss   Event                   Mu Time     Mon Tue Wed Thu Fri Sat Sun Notification
        array("Abyss",  "Abyss Boss",           "10:00",    1,  1,  1,  1,  1,  1,  1,  "false"),
        array("Abyss",  "Abyss Boss",           "11:30",    1,  1,  1,  1,  1,  1,  1,  "false"),
        array("Abyss",  "Battle Core",          "12:30",    1,  1,  1,  1,  1,  1,  1,  "true"),
        array("Abyss",  "Abyss Boss",           "13:00",    1,  1,  1,  1,  1,  1,  1,  "false"),
        array("Abyss",  "Elemental Challenge",  "13:30",    1,  1,  1,  1,  1,  1,  1,  "true" ),
        array("Abyss",  "Abyss Boss",           "14:30",    1,  1,  1,  1,  1,  1,  1,  "false"),
        array("Abyss",  "Abyss Castle",         "15:00",    0,  0,  1,  0,  0,  0,  0,  "true" ),
        array("Abyss",  "Abyss Boss",           "16:00",    1,  1,  1,  1,  1,  1,  1,  "false"),
        array("Abyss",  "3vs3 Competition",     "16:00",    0,  0,  0,  0,  1,  0,  0,  "true"),
        array("Abyss",  "Abyss Boss",           "17:30",    1,  1,  1,  1,  1,  1,  1,  "false"),
        array("Abyss",  "Battle Core",          "18:30",    1,  1,  1,  1,  1,  1,  1,  "true"),
        array("Abyss",  "Elemental Challenge",  "19:00",    1,  1,  1,  1,  1,  1,  1,  "true" ),
        array("Abyss",  "Abyss Boss",           "19:00",    1,  1,  1,  1,  1,  1,  1,  "false"),
        array("Abyss",  "Abyss Loren Feast",    "19:50",    1,  1,  0,  1,  1,  1,  1,  "true" ),
        array("Abyss",  "Abyss Castle",         "20:30",    0,  0,  1,  0,  0,  0,  0,  "true" ),
        array("Abyss",  "Abyss Boss",           "20:30",    1,  1,  1,  1,  1,  1,  1,  "false"),
        array("Abyss",  "Abyss Tower",          "21:00",    0,  0,  0,  1,  0,  0,  0,  "true" ),
        array("Abyss",  "Abyss Guild battle",   "21:00",    0,  0,  0,  0,  0,  1,  0,  "true" ),
        array("Abyss",  "Abyss Castle Siege",   "21:30",    0,  0,  1,  0,  0,  0,  0,  "true" ),
        array("Abyss",  "Abyss War",            "21:30",    1,  0,  0,  0,  1,  0,  0,  "true" ),
        array("Abyss",  "Tower of Allegiance",  "21:30",    0,  1,  0,  1,  0,  0,  0,  "true" ),
        array("Abyss",  "Abyss Boss",           "22:00",    1,  1,  1,  1,  1,  1,  1,  "false"),
        array("Abyss",  "Elemental Dungeon",    "22:30",    1,  1,  1,  1,  1,  0,  0,  "true" ),
        array("Abyss",  "Abyss Boss",           "23:30",    1,  1,  1,  1,  1,  1,  1,  "false"),
        array("Abyss",  "Abyss Boss",           "01:00",    1,  1,  1,  1,  1,  1,  1,  "false"),
        //World/Abyss   Event                   Mu Time     Mon Tue Wed Thu Fri Sat Sun Notification
        array("World",  "Archangel Boss",       "00:00",    1,  1,  1,  1,  1,  1,  1,  "true"),
        array("World",  "Archangel Boss",       "06:00",    1,  1,  1,  1,  1,  1,  1,  "true"),
        array("World",  "Archangel Boss",       "12:00",    1,  1,  1,  1,  1,  1,  1,  "true"),
        array("World",  "Archangel Boss",       "18:00",    1,  1,  1,  1,  1,  1,  1,  "true")
    );
    $serverTime = date('H:i'); //Hora y Minutos
    $serverDay = date('D'); //Obtiene el dia en formato corto
    $serverTime5minutes = date('H:i',strtotime('+5 minutes',strtotime($serverTime))); //Suma 5 mins a la hora actual para avisar con tiempo
    $serverTime3minutes = date('H:i',strtotime('+3 minutes',strtotime($serverTime))); //Suma 3 mins a la hora actual para avisar con tiempo
    $serverTime1minutes = date('H:i',strtotime('+1 minutes',strtotime($serverTime))); //Suma 1 mins a la hora actual para avisar con tiempo
    foreach($Events as $currentEvent) //Revisa el array de eventos 1 por 1
    {
        if(($event_Abyss == 0) && ($currentEvent[0] == "Abyss")){continue;} //Si Abyss está desactivado, skipea el evento correspondiente
        if(($event_Archangel == 0) && ($currentEvent[1] == "Archangel Boss")){continue;} //Si Archangel está desactivado, skipea el evento correspondiente

        $todayEvents = 0;
        if(($serverDay == "Mon") && ($currentEvent[3] == 1)){$todayEvents = 1;} //Chequea si el evento corresponde al dia Lunes
        elseif(($serverDay == "Tue") && ($currentEvent[4] == 1)){$todayEvents = 1;} //Chequea si el evento corresponde al dia Martes
        elseif(($serverDay == "Wed") && ($currentEvent[5] == 1)){$todayEvents = 1;} //Chequea si el evento corresponde al dia Miercoles
        elseif(($serverDay == "Thu") && ($currentEvent[6] == 1)){$todayEvents = 1;} //Chequea si el evento corresponde al dia Jueves
        elseif(($serverDay == "Fri") && ($currentEvent[7] == 1)){$todayEvents = 1;} //Chequea si el evento corresponde al dia Viernes
        elseif(($serverDay == "Sat") && ($currentEvent[8] == 1)){$todayEvents = 1;} //Chequea si el evento corresponde al dia Sabado
        elseif(($serverDay == "Sun") && ($currentEvent[9] == 1)){$todayEvents = 1;} //Chequea si el evento corresponde al dia Domingo
        else{$todayEvents = 0;}

        if(($serverTime5minutes == $currentEvent[2]) && ($todayEvents == 1) && ($currentEvent[1] == "Archangel Boss")) //Notificación cuando faltan 5 minutos
        {
            telegram("group", "{$currentEvent[10]}", "[{$currentEvent[0]}] {$currentEvent[1]} en 5 minutos...");
            if($Debug == 1)
            {
                $x = fg_color('cyan', "[DEBUG]");
		        $realTime = getTimeYellow();
                echo $realTime."\t{$x} Dia: {$serverDay} Hora: {$serverTime} TodayEvents: {$todayEvents}\n";
                echo $realTime."\t{$x} [{$currentEvent[0]}] Evento: {$currentEvent[1]} en 5 minutos\n";
            }
        }

        if(($serverTime3minutes == $currentEvent[2]) && ($todayEvents == 1)) //Notificación cuando faltan 3 minutos
        {
            telegram("group", "{$currentEvent[10]}", "[{$currentEvent[0]}] {$currentEvent[1]} en 3 minutos...");
            if($Debug == 1)
            {
                $x = fg_color('cyan', "[DEBUG]");
		        $realTime = getTimeYellow();
		        echo $realTime."\t{$x} Dia: {$serverDay} Hora: {$serverTime} TodayEvents: {$todayEvents}\n";
                echo $realTime."\t{$x} [{$currentEvent[0]}] Evento: {$currentEvent[1]} en 3 minutos...\n";
            }
        }
        /*
        if(($serverTime1minutes == $currentEvent[2]) && ($todayEvents == 1)) //Notificación cuando falta 1 minuto
        {
            telegram("group", "{$currentEvent[10]}", "[{$currentEvent[0]}] Evento: {$currentEvent[1]} en 1 minuto...");
            if($Debug == 1)
            {
                $x = fg_color('cyan', "[DEBUG]");
		        $realTime = getTimeYellow();
                echo $realTime."\t{$x} Dia: {$serverDay} Hora: {$serverTime} TodayEvents: {$todayEvents}\n";
                echo $realTime."\t{$x} [{$currentEvent[0]}] Evento: {$currentEvent[1]} en 1 minuto...\n";
            }
        }
        */
    }
    if($Debug == 1)
    {
        $x = fg_color('cyan', "[DEBUG]");
	$realTime = getTimeYellow();
        echo $realTime."\t{$x} Dia: {$serverDay} Hora: {$serverTime}\n";
	 telegram("private", "true", "Dia: {$serverDay} Hora: {$serverTime}");
    }
}
catch(Exception $e)
{
	$realTime = getTimeYellow();
	echo "Failed\n";
	$x = fg_color('red', "[ERROR]");
	die($realTime."\t{$x} " . $e->getMessage() . "\n". $e->getTraceAsString() ."\n");
}
