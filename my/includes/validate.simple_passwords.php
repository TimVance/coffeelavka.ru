<?php
/**
 * Простые пароли
 *
 * @package    DIAFAN.CMS
 * @author     diafan.ru
 * @version    6.0
 * @license    http://www.diafan.ru/license.html
 * @copyright  Copyright (c) 2003-2016 OOO «Диафан» (http://www.diafan.ru/)
 */

if (! defined('DIAFAN'))
{
	$path = __FILE__; $i = 0;
	while(! file_exists($path.'/includes/404.php'))
	{
		if($i == 10) exit; $i++;
		$path = dirname($path);
	}
	include $path.'/includes/404.php';
}

$passwords = array(
'123456',
'admin',
'password',
'test',
'123',
'123456789',
'12345678',
'1234',
'qwerty',
'devry',
'111111',
'1234567',
'KRAZY',
'123123',
'windows',
'abc123',
'helpme',
'admin123',
'000000',
'123qwe',
'1234567890',
'administrator',
'azerty',
'hello',
'cisco12',
'123321',
'666666',
'654321',
'05524680',
'pass',
'root',
'1111',
'111',
'12345',
'1q2w3e4r',
'iloveyou',
'159753',
'M0tH3ro0',
'chocolat',
'Networkp4ss',
'112233',
'elfalg',
'asdfgh',
'7777777',
'1q2w3e',
'PASS123',
'11111111',
'Forward',
'ubqe2kg7',
'lol123',
'Test123',
'Password1',
'zxcvbnm',
'F00tb@11',
'abcd1234',
'asdasd',
'secret',
'demo',
'555555',
'PASSWORD',
'999999',
'9288763',
'master',
'backward',
'U91fa92',
'samsung',
'killer',
'password1',
'qazwsx',
'pokemon',
'TEST',
'Demo_mec',
'0000',
'andrew',
'shadow',
'n1skj0sp',
'gino',
'dragon',
'123654',
'vinicius',
'kunal123456',
'hurrr',
'tokos',
'monkey',
'matrix',
'sunshine',
'ADMIN',
'aubergine',
'football',
'W1NDOWS',
'q1w2e3',
'aaaaaa',
'welcome',
'emachines',
'BMWM5POWER',
'switzerland',
'PC#ADMIN',
'PE#5GZ29PTZMSE',
'tudelft',
'666',
'fuckyou',
'asdfghjkl',
'DIOSESFIEL',
'123123123',
'Salam',
'eminem',
'dpbk1234',
'guest',
'zhouba',
'12qwaszx',
'user',
'parola',
'egoiste',
'222222',
'guildwars',
'NETWORKP4SS',
'121212',
'testing',
'qwert',
'hamide',
'computer',
'12413',
'hunter',
'!root!',
'qwertyuiop',
'forensics',
'1342',
'290966',
'789456123',
'cjmasterinf',
'asdf',
'U38fa39',
'BLUEAIRWOLF',
'abc',
'11111',
'golfer',
'wall.e',
'apple',
'aaa',
'GO2WORK',
'VQsaBLPzLa',
'1qaz2wsx',
'0690',
'qwerty123',
'superman',
'987654321',
'784512',
'pass123',
'008400',
'ANTI444',
'changeme',
'nicolas',
'P@ssw0rd',
'elephant',
'31337',
'robert',
'P@SSW0RD',
'emmanuel20',
'C@ll2p1nk',
'martin',
'N3V3RGETM3',
'lol',
'scorpion',
'04lz!',
'67023',
'backdoor',
'Sistema',
'Passw0rd',
'platter',
'protocol',
'4SweetCandy1',
'pakistan',
'88888888',
'starwars',
'111222',
'hallo',
'daniel',
'valentin',
'zebra',
'liverpool',
'chicken',
'bonjour',
'281874',
'counter',
'XTM4S',
'00000000',
'warcraft',
'ciao',
'1piu4pui',
'777777',
'frederic',
'lepassadmin',
'love',
'samson',
'147258369',
'alex',
'patate',
'serwis',
'thomas',
'tigger',
'rahasiaa',
'asd123',
'131313',
'autocont',
'1234321',
'SAEEDI110',
'juventus',
'anastasia',
'1986',
'1984',
'05)4HeblzZ*3Q5',
'test123',
'bismillah',
'jordan',
'google',
'zxcvbn',
'arsenal',
'azertyuiop789',
'rodrigo',
'alin@a',
'marlboro',
'passwd',
'123yagooar',
'mirage',
'ciscokid',
'charlie',
'983583',
'system',
'777',
'testtest',
'freedom',
'spider',
'letmein',
'1212123',
'5555',
'huanaco',
'USER',
'naruto',
'8860960',
'newn1234',
'cheval',
'8260808',
'podzamok',
'phoenix',
'15324',
'1111111',
'84944030',
'chocolate',
'windows vista',
'hejsan',
'Beeblebrox',
'Insert21',
'cat',
'xakep',
'orange',
'a123456',
'159357',
'holysh!t',
'mai001',
'mankato',
'maradona10',
'cyber',
'princess',
'12341234',
'44264426',
'mathieu',
'jagiellonia',
'piripicchio',
'333333',
'monkey12',
'grassass',
'itsatrap',
'212121',
'p@ssw0rd',
'jordan23',
'qazxsw',
'cgnimh85',
'xiatian',
'thienthien',
'1005',
'sandra',
'mamma1',
'tastrouve',
'Prince27',
'vesper',
'607721',
'huhu',
'admin1',
'888888',
'qwerty12',
'linda',
'bermuda',
'world2010',
'nicholas',
'jake',
'nirvana',
'djep',
'april',
'100684',
'P@ssw0rd1',
'motdepasse',
'00750',
'1987',
'arista1985',
'Password01',
'swordfish',
'scarface',
'buster',
'manager',
'qwer',
'789456',
'asd',
'102030',
'jennifer',
'access',
'peter',
'55555',
'diablo',
'jackie',
'hallo123',
'japan',
'michelle',
'madison',
'63743',
'BALISTO',
'x-dream1583',
'brian',
'bob',
'jessica',
'vg40f',
'mickeymouse',
'dexter',
'krishnan',
'bass02',
'Christmas',
'cellardoor',
'marzipan',
'cynthia21',
'Wir',
'vegeta',
'camille',
'coucou',
'rats',
'1234abcd',
'skateboard',
'felix',
'qwe',
'sonich',
'grewal1',
'mykids',
'abacus1!',
'mariner1',
'190319',
'busted',
'jamesbond007',
'rebecca',
'bitchassness',
'shiv1',
'rehpot',
'PEOPLESOFT',
'Schwier',
'seifert',
'whatever',
'peoplesoft',
'jackson',
'admin@123',
'2234',
'harun',
'0123456789',
'jessica!',
'xxxx',
'boney',
'PA$$W0RD',
'11319062',
'bunny',
'tybinc25',
'591171111',
'oktober17',
'loulou',
'Germany',
'messy',
'nigger',
'martin2009',
'karam',
'vishal',
'irene',
'shopping',
'hulya',
'fnork',
'sefyu',
'lollol',
'Elise2007',
'Kenya',
'ofelia2011',
'qweasdzxc',
'sabrina',
'room',
'jesuschrist',
'NTy7',
'Mexico69',
'02191',
'Wurst',
'scrap1',
'1pepperbiff',
'bemen3',
'eandrade',
'amanda',
'98REM/SCHU89',
'system5',
'logitech',
'abcdefg',
'endaira',
'loveyou',
'Milchreis',
'iwumnx7',
'telefon',
'dfdbkjy',
'net',
'nicole',
'george',
'doster123',
'panos',
'superhighway',
'sarita67',
'sorinel1234',
'alexsucks',
'101010',
'tammyjo1',
'yellow',
'admin2',
'banana',
'676676',
'23822497',
'23091985',
'321987258',
'uti123',
'vikinka',
'zied007',
'qweasd',
'MFmF',
'790806',
'forreal',
'gfhjkm',
'songokou',
'anthony',
'640521',
'cradle3345',
'Donostia',
'Hacker123',
'potter',
'nathan',
'snoopy',
'securom1',
'$82wx4',
'1985',
'qwer1234',
'metallica',
'nick456',
'88198856',
'abrete',
'fgh',
'blackberry',
'log619',
'arthur',
'JKnmUI89',
'zzzz',
'ahoj',
'gnsgns',
'mustang',
'3015',
'vincent',
'Brianna1',
'teste',
'TOMAS',
'lothus',
'cookie',
'scooter',
'hotstuff1',
'mondearabe',
'hash',
'db2002',
'NHY^7ujm',
'mother',
'ik4C4',
'hacked',
'justin',
'canchaser',
'phoenix25',
'ENGL',
'oliver',
'limited',
'Insider1999',
'assassin',
'purple',
'SEGUNDO-ASI',
'hejhej',
'HAMSEM',
'1981',
'hat',
'spiderman',
);