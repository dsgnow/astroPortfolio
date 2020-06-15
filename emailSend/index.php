<?php
 ob_start(); session_start(); 
  
    if(!((isset($_SESSION['admin'])) || (isset($_SESSION['prezes'])) || (isset($_SESSION['bok'])) || (isset($_SESSION['ksiegowy']))  )){
        header('LOCATION:/1_BOK_INTERFACE/login.php'); die();
    }

    if($_SESSION['ip'] != $_SERVER['REMOTE_ADDR'])
        {
          session_regenerate_id();
          header('LOCATION:/1_BOK_INTERFACE/login.php'); die();  // Proba przejecia sesji udaremniona! 
        }



use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../../1_BOK_INTERFACE/COMPOSER/vendor/autoload.php';

$email = new PHPMailer(TRUE);

require_once('tcpdf.php');
echo' <style type="text/css">
        body{background-color: aliceblue;font-family: sans-serif;text-align: center; zoom: 80%;}
        button{background-color: cadetblue;color: whitesmoke;-webkit-box-shadow: none;box-shadow: none; font-size: 18px;font-weight: 500;border-radius: 7px;padding: 15px 35px;cursor: pointer;white-space: nowrap;margin: 10px;}
        img {width: 200px;}
        input[type="text"] {padding: 12px 20px;display: inline-block;border: 1px solid #ccc;border-radius: 10px; box-sizing: border-box;}
        h1{border-bottom: solid 2px grey;}
        #success {background: green;}
        #error {background: red;}
        #warning {background: coral;}
        #info {background: cornflowerblue;}
        #question {background: grey;}
       </style>';

echo '<script type="text/javascript" src="https://code.jquery.com/jquery-latest.js"></script>
<link rel="stylesheet" href="css/sweetalert2.min.css">
<script src="js/sweetalert2.min.js"></script>';




include '../../../connectionTYMCZAS.php';

	try {
	    $dbh = new PDO($dsn, $user, $password); $dbh->exec("set names utf8");
	} catch (PDOException $e) {
	    echo 'Connection failed: ' . $e->getMessage();
	}

if (isset($_COOKIE['kartaPotwierdzenia'])) {
$kartaPotwierdzenia = $_COOKIE['kartaPotwierdzenia'];
$akcja = $_COOKIE['akcja'];
$tekst = $_COOKIE['tekst'];

echo $tekst;

$emailA5 = $_COOKIE['emailA5'];
$emailKlient = $_COOKIE['emailKlient'];
$numerZleceniaNew = $kartaPotwierdzenia;
} else {
    error_reporting(0);
    echo "SESJA WYGASŁA";
}





$stmt = $dbh->prepare("SELECT dataZalozenia FROM crm WHERE numerZleceniaNew=:numerZleceniaNew LIMIT 1");
$stmt->bindParam(':numerZleceniaNew', $numerZleceniaNew, PDO::PARAM_INT);
$stmt->execute(); 
$dataZalozenia = $stmt->fetchColumn();
$rok = substr_replace($dataZalozenia, "", -15);
$mies = substr_replace($dataZalozenia, "", -12);
$miesiac = substr($mies, 5);


$stmt = $dbh->prepare("SELECT kodKreskowyNew FROM crm WHERE numerZleceniaNew=:numerZleceniaNew LIMIT 1");
$stmt->bindParam(':numerZleceniaNew', $numerZleceniaNew, PDO::PARAM_INT);
$stmt->execute(); 
$kodKreskowy = $stmt->fetchColumn();


$stmt = $dbh->prepare("SELECT klient FROM crm WHERE numerZleceniaNew=:numerZleceniaNew LIMIT 1");
$stmt->bindParam(':numerZleceniaNew', $numerZleceniaNew, PDO::PARAM_INT);
$stmt->execute(); 
$klient = $stmt->fetchColumn();

$stmt = $dbh->prepare("SELECT cenaGlobalna FROM crm WHERE numerZleceniaNew=:numerZleceniaNew LIMIT 1");
$stmt->bindParam(':numerZleceniaNew', $numerZleceniaNew, PDO::PARAM_INT);
$stmt->execute(); 
$cenaGlobalna = $stmt->fetchColumn();

$stmt = $dbh->prepare("SELECT material FROM crm WHERE numerZleceniaNew=:numerZleceniaNew LIMIT 1");
$stmt->bindParam(':numerZleceniaNew', $numerZleceniaNew, PDO::PARAM_INT);
$stmt->execute(); 
$material = $stmt->fetchColumn();

$stmt = $dbh->prepare("SELECT maszyna FROM crm WHERE numerZleceniaNew=:numerZleceniaNew LIMIT 1");
$stmt->bindParam(':numerZleceniaNew', $numerZleceniaNew, PDO::PARAM_INT);
$stmt->execute(); 
$maszyna = $stmt->fetchColumn();

$stmt = $dbh->prepare("SELECT jakosc FROM crm WHERE numerZleceniaNew=:numerZleceniaNew LIMIT 1");
$stmt->bindParam(':numerZleceniaNew', $numerZleceniaNew, PDO::PARAM_INT);
$stmt->execute(); 
$jakosc = $stmt->fetchColumn();

$stmt = $dbh->prepare("SELECT pakowanie FROM crm WHERE numerZleceniaNew=:numerZleceniaNew LIMIT 1");
$stmt->bindParam(':numerZleceniaNew', $numerZleceniaNew, PDO::PARAM_INT);
$stmt->execute(); 
$pakowanie = $stmt->fetchColumn();

$stmt = $dbh->prepare("SELECT zaklada FROM crm WHERE numerZleceniaNew=:numerZleceniaNew LIMIT 1");
$stmt->bindParam(':numerZleceniaNew', $numerZleceniaNew, PDO::PARAM_INT);
$stmt->execute(); 
$zaklada = $stmt->fetchColumn();

$stmt = $dbh->prepare("SELECT osobaPotwierdzenie FROM crm WHERE numerZleceniaNew=:numerZleceniaNew LIMIT 1");
$stmt->bindParam(':numerZleceniaNew', $numerZleceniaNew, PDO::PARAM_INT);
$stmt->execute(); 
$osobaPotwierdzenie = $stmt->fetchColumn();

$stmt = $dbh->prepare("SELECT wysylka FROM crm WHERE numerZleceniaNew=:numerZleceniaNew LIMIT 1");
$stmt->bindParam(':numerZleceniaNew', $numerZleceniaNew, PDO::PARAM_INT);
$stmt->execute(); 
$wysylka = $stmt->fetchColumn();
if ($wysylka == 'Osobisty') {
    $wysylka = 'odbiór osobisty';
}

$stmt = $dbh->prepare("SELECT data FROM crm WHERE numerZleceniaNew=:numerZleceniaNew LIMIT 1");
$stmt->bindParam(':numerZleceniaNew', $numerZleceniaNew, PDO::PARAM_INT);
$stmt->execute(); 
$data = $stmt->fetchColumn();

$stmt = $dbh->prepare("SELECT platnosc FROM crm WHERE numerZleceniaNew=:numerZleceniaNew LIMIT 1");
$stmt->bindParam(':numerZleceniaNew', $numerZleceniaNew, PDO::PARAM_INT);
$stmt->execute(); 
$platnosc = $stmt->fetchColumn();

$stmt = $dbh->prepare("SELECT kosztyTransportu FROM crm WHERE numerZleceniaNew=:numerZleceniaNew LIMIT 1");
$stmt->bindParam(':numerZleceniaNew', $numerZleceniaNew, PDO::PARAM_INT);
$stmt->execute(); 
$kosztyTransportu = $stmt->fetchColumn();

$stmt = $dbh->prepare("SELECT nazwyPlikow FROM crm WHERE numerZleceniaNew=:numerZleceniaNew LIMIT 1");
$stmt->bindParam(':numerZleceniaNew', $numerZleceniaNew, PDO::PARAM_INT);
$stmt->execute(); 
$nazwy = $stmt->fetchColumn();
$nazwyPlikow = explode(",", $nazwy);
$iloscPlikow = count($nazwyPlikow);


$stmt = $dbh->prepare("SELECT ilosc FROM crm WHERE numerZleceniaNew=:numerZleceniaNew LIMIT 1");
$stmt->bindParam(':numerZleceniaNew', $numerZleceniaNew, PDO::PARAM_INT);
$stmt->execute(); 
$ilosc = $stmt->fetchColumn();
$iloscUzytkow = explode(",", $ilosc);

$stmt = $dbh->prepare("SELECT wymiarX FROM crm WHERE numerZleceniaNew=:numerZleceniaNew LIMIT 1");
$stmt->bindParam(':numerZleceniaNew', $numerZleceniaNew, PDO::PARAM_INT);
$stmt->execute(); 
$wymiarX = $stmt->fetchColumn();
$wymiaryX = explode(",", $wymiarX);

$stmt = $dbh->prepare("SELECT wymiarY FROM crm WHERE numerZleceniaNew=:numerZleceniaNew LIMIT 1");
$stmt->bindParam(':numerZleceniaNew', $numerZleceniaNew, PDO::PARAM_INT);
$stmt->execute(); 
$wymiarY = $stmt->fetchColumn();
$wymiaryY = explode(",", $wymiarY);

$stmt = $dbh->prepare("SELECT calkowityWymiarX FROM crm WHERE numerZleceniaNew=:numerZleceniaNew LIMIT 1");
$stmt->bindParam(':numerZleceniaNew', $numerZleceniaNew, PDO::PARAM_INT);
$stmt->execute(); 
$calkowityWymiarX = $stmt->fetchColumn();
$calkowityWymiaryX = explode(",", $calkowityWymiarX);

$stmt = $dbh->prepare("SELECT calkowityWymiarY FROM crm WHERE numerZleceniaNew=:numerZleceniaNew LIMIT 1");
$stmt->bindParam(':numerZleceniaNew', $numerZleceniaNew, PDO::PARAM_INT);
$stmt->execute(); 
$calkowityWymiarY = $stmt->fetchColumn();
$calkowityWymiaryY = explode(",", $calkowityWymiarY);

$stmt = $dbh->prepare("SELECT m2 FROM crm WHERE numerZleceniaNew=:numerZleceniaNew LIMIT 1");
$stmt->bindParam(':numerZleceniaNew', $numerZleceniaNew, PDO::PARAM_INT);
$stmt->execute(); 
$m2 = $stmt->fetchColumn();
$m2Uzytkow = explode(",", $m2);

$stmt = $dbh->prepare("SELECT calosciCena FROM crm WHERE numerZleceniaNew=:numerZleceniaNew LIMIT 1");
$stmt->bindParam(':numerZleceniaNew', $numerZleceniaNew, PDO::PARAM_INT);
$stmt->execute(); 
$calosciCena = $stmt->fetchColumn();

$stmt = $dbh->prepare("SELECT waluta FROM crm WHERE numerZleceniaNew=:numerZleceniaNew LIMIT 1");
$stmt->bindParam(':numerZleceniaNew', $numerZleceniaNew, PDO::PARAM_INT);
$stmt->execute(); 
$waluta = $stmt->fetchColumn();

$stmt = $dbh->prepare("SELECT calosciM2 FROM crm WHERE numerZleceniaNew=:numerZleceniaNew LIMIT 1");
$stmt->bindParam(':numerZleceniaNew', $numerZleceniaNew, PDO::PARAM_INT);
$stmt->execute(); 
$calosciM2 = $stmt->fetchColumn();

$stmt = $dbh->prepare("SELECT jednostkaGlobalna FROM crm WHERE numerZleceniaNew=:numerZleceniaNew LIMIT 1");
$stmt->bindParam(':numerZleceniaNew', $numerZleceniaNew, PDO::PARAM_INT);
$stmt->execute(); 
$jednostkaGlobalna = $stmt->fetchColumn();

$stmt = $dbh->prepare("SELECT sciezka FROM crm WHERE numerZleceniaNew=:numerZleceniaNew LIMIT 1");
$stmt->bindParam(':numerZleceniaNew', $numerZleceniaNew, PDO::PARAM_INT);
$stmt->execute(); 
$sciezka = $stmt->fetchColumn();

$stmt = $dbh->prepare("SELECT infoGrafik FROM crm WHERE numerZleceniaNew=:numerZleceniaNew LIMIT 1");
$stmt->bindParam(':numerZleceniaNew', $numerZleceniaNew, PDO::PARAM_INT);
$stmt->execute(); 
$infoGrafik = $stmt->fetchColumn();

$stmt = $dbh->prepare("SELECT infoDrukarz FROM crm WHERE numerZleceniaNew=:numerZleceniaNew LIMIT 1");
$stmt->bindParam(':numerZleceniaNew', $numerZleceniaNew, PDO::PARAM_INT);
$stmt->execute(); 
$infoDrukarz = $stmt->fetchColumn();

$stmt = $dbh->prepare("SELECT infoHala FROM crm WHERE numerZleceniaNew=:numerZleceniaNew LIMIT 1");
$stmt->bindParam(':numerZleceniaNew', $numerZleceniaNew, PDO::PARAM_INT);
$stmt->execute(); 
$infoHala = $stmt->fetchColumn();

$stmt = $dbh->prepare("SELECT komentarz FROM crm WHERE numerZleceniaNew=:numerZleceniaNew LIMIT 1");
$stmt->bindParam(':numerZleceniaNew', $numerZleceniaNew, PDO::PARAM_INT);
$stmt->execute(); 
$komentarz = $stmt->fetchColumn();


// obrobka top //

$stmt = $dbh->prepare("SELECT obrobkaTop FROM crm WHERE numerZleceniaNew=:numerZleceniaNew LIMIT 1");
$stmt->bindParam(':numerZleceniaNew', $numerZleceniaNew, PDO::PARAM_INT);
$stmt->execute(); 
$obrobkaTop = $stmt->fetchColumn();
$obrobkaTopUzytkow = explode(",", $obrobkaTop);

$stmt = $dbh->prepare("SELECT oczkaTop FROM crm WHERE numerZleceniaNew=:numerZleceniaNew LIMIT 1");
$stmt->bindParam(':numerZleceniaNew', $numerZleceniaNew, PDO::PARAM_INT);
$stmt->execute(); 
$oczkaTop = $stmt->fetchColumn();
$oczkaTopUzytkow = explode(",", $oczkaTop);

$stmt = $dbh->prepare("SELECT topValueTunel FROM crm WHERE numerZleceniaNew=:numerZleceniaNew LIMIT 1");
$stmt->bindParam(':numerZleceniaNew', $numerZleceniaNew, PDO::PARAM_INT);
$stmt->execute(); 
$topValueTunel = $stmt->fetchColumn();
$topValueTunelUzytkow = explode(",", $topValueTunel);

// obrobka bot //

$stmt = $dbh->prepare("SELECT obrobkaBot FROM crm WHERE numerZleceniaNew=:numerZleceniaNew LIMIT 1");
$stmt->bindParam(':numerZleceniaNew', $numerZleceniaNew, PDO::PARAM_INT);
$stmt->execute(); 
$obrobkaBot = $stmt->fetchColumn();
$obrobkaBotUzytkow = explode(",", $obrobkaBot);

$stmt = $dbh->prepare("SELECT oczkaBot FROM crm WHERE numerZleceniaNew=:numerZleceniaNew LIMIT 1");
$stmt->bindParam(':numerZleceniaNew', $numerZleceniaNew, PDO::PARAM_INT);
$stmt->execute(); 
$oczkaBot = $stmt->fetchColumn();
$oczkaBotUzytkow = explode(",", $oczkaBot);

$stmt = $dbh->prepare("SELECT botValueTunel FROM crm WHERE numerZleceniaNew=:numerZleceniaNew LIMIT 1");
$stmt->bindParam(':numerZleceniaNew', $numerZleceniaNew, PDO::PARAM_INT);
$stmt->execute(); 
$botValueTunel = $stmt->fetchColumn();
$botValueTunelUzytkow = explode(",", $botValueTunel);

// obrobka left //

$stmt = $dbh->prepare("SELECT obrobkaLeft FROM crm WHERE numerZleceniaNew=:numerZleceniaNew LIMIT 1");
$stmt->bindParam(':numerZleceniaNew', $numerZleceniaNew, PDO::PARAM_INT);
$stmt->execute(); 
$obrobkaLeft = $stmt->fetchColumn();
$obrobkaLeftUzytkow = explode(",", $obrobkaLeft);

$stmt = $dbh->prepare("SELECT oczkaLeft FROM crm WHERE numerZleceniaNew=:numerZleceniaNew LIMIT 1");
$stmt->bindParam(':numerZleceniaNew', $numerZleceniaNew, PDO::PARAM_INT);
$stmt->execute(); 
$oczkaLeft = $stmt->fetchColumn();
$oczkaLeftUzytkow = explode(",", $oczkaLeft);

$stmt = $dbh->prepare("SELECT leftValueTunel FROM crm WHERE numerZleceniaNew=:numerZleceniaNew LIMIT 1");
$stmt->bindParam(':numerZleceniaNew', $numerZleceniaNew, PDO::PARAM_INT);
$stmt->execute(); 
$leftValueTunel = $stmt->fetchColumn();
$leftValueTunelUzytkow = explode(",", $leftValueTunel);

// obrobka right //

$stmt = $dbh->prepare("SELECT obrobkaRight FROM crm WHERE numerZleceniaNew=:numerZleceniaNew LIMIT 1");
$stmt->bindParam(':numerZleceniaNew', $numerZleceniaNew, PDO::PARAM_INT);
$stmt->execute(); 
$obrobkaRight = $stmt->fetchColumn();
$obrobkaRightUzytkow = explode(",", $obrobkaRight);

$stmt = $dbh->prepare("SELECT oczkaRight FROM crm WHERE numerZleceniaNew=:numerZleceniaNew LIMIT 1");
$stmt->bindParam(':numerZleceniaNew', $numerZleceniaNew, PDO::PARAM_INT);
$stmt->execute(); 
$oczkaRight = $stmt->fetchColumn();
$oczkaRightUzytkow = explode(",", $oczkaRight);

$stmt = $dbh->prepare("SELECT rightValueTunel FROM crm WHERE numerZleceniaNew=:numerZleceniaNew LIMIT 1");
$stmt->bindParam(':numerZleceniaNew', $numerZleceniaNew, PDO::PARAM_INT);
$stmt->execute(); 
$rightValueTunel = $stmt->fetchColumn();
$rightValueTunelUzytkow = explode(",", $rightValueTunel);

// dodatkowe //

$stmt = $dbh->prepare("SELECT informacjeDodatkowe FROM crm WHERE numerZleceniaNew=:numerZleceniaNew LIMIT 1");
$stmt->bindParam(':numerZleceniaNew', $numerZleceniaNew, PDO::PARAM_INT);
$stmt->execute(); 
$informacjeDodatkowe = $stmt->fetchColumn();
$informacjeDodatkoweUzytkow = explode(",", $informacjeDodatkowe);



$stmt = $dbh->prepare("SELECT drukInformacjeDodatkowe FROM crm WHERE numerZleceniaNew=:numerZleceniaNew LIMIT 1");
$stmt->bindParam(':numerZleceniaNew', $numerZleceniaNew, PDO::PARAM_INT);
$stmt->execute(); 
$drukInformacjeDodatkowe = $stmt->fetchColumn();
$drukInformacjeDodatkoweUzytkow = explode(",", $drukInformacjeDodatkowe);


$stmt = $dbh->prepare("SELECT halaInformacjeDodatkowe FROM crm WHERE numerZleceniaNew=:numerZleceniaNew LIMIT 1");
$stmt->bindParam(':numerZleceniaNew', $numerZleceniaNew, PDO::PARAM_INT);
$stmt->execute(); 
$halaInformacjeDodatkowe = $stmt->fetchColumn();
$halaInformacjeDodatkoweUzytkow = explode(",", $halaInformacjeDodatkowe);


// akcesoria dodatki //

$stmt = $dbh->prepare("SELECT akcesoria FROM crm WHERE numerZleceniaNew=:numerZleceniaNew LIMIT 1");
$stmt->bindParam(':numerZleceniaNew', $numerZleceniaNew, PDO::PARAM_INT);
$stmt->execute(); 
$akcesoria = $stmt->fetchColumn();
$nazwyAkcesoria = explode(",", $akcesoria);
if ($akcesoria){
$iloscAkcesoria = count($nazwyAkcesoria);
} else {
   $iloscAkcesoria = 0; 
}


$stmt = $dbh->prepare("SELECT dodatkoweIlosc FROM crm WHERE numerZleceniaNew=:numerZleceniaNew LIMIT 1");
$stmt->bindParam(':numerZleceniaNew', $numerZleceniaNew, PDO::PARAM_INT);
$stmt->execute(); 
$dodatkoweIlosc = $stmt->fetchColumn();
$dodatkoweIloscUzytkow = explode(",", $dodatkoweIlosc);

$stmt = $dbh->prepare("SELECT dodatkoweJednostka FROM crm WHERE numerZleceniaNew=:numerZleceniaNew LIMIT 1");
$stmt->bindParam(':numerZleceniaNew', $numerZleceniaNew, PDO::PARAM_INT);
$stmt->execute(); 
$dodatkoweJednostka = $stmt->fetchColumn();
$dodatkoweJednostkaUzytkow = explode(",", $dodatkoweJednostka);

$stmt = $dbh->prepare("SELECT dodatkoweCenaJednostkowa FROM crm WHERE numerZleceniaNew=:numerZleceniaNew LIMIT 1");
$stmt->bindParam(':numerZleceniaNew', $numerZleceniaNew, PDO::PARAM_INT);
$stmt->execute(); 
$dodatkoweCenaJednostkowa = $stmt->fetchColumn();
$dodatkoweCenaJednostkowaUzytkow = explode(",", $dodatkoweCenaJednostkowa);


// DANE ZAMAWIAJĄCEGO //

$stmt = $dbh->prepare("SELECT * FROM crm WHERE numerZleceniaNew=:numerZleceniaNew");
$stmt->bindParam(':numerZleceniaNew', $numerZleceniaNew, PDO::PARAM_INT);
$stmt->execute(); 
while ($row = $stmt->fetch(PDO::FETCH_ASSOC))  
        { 
            $pelnaNazwaKlienta = $row["nazwaZamawiajacego"]; 
            $daneKlienta = $row["adresZamawiajacego"];
            $nipKlienta = $row["nipZamawiajacego"];
           
            
        }

$stmt = $dbh->prepare("SELECT * FROM crm WHERE numerZleceniaNew=:numerZleceniaNew");
$stmt->bindParam(':numerZleceniaNew', $numerZleceniaNew, PDO::PARAM_INT);
$stmt->execute(); 
while ($row = $stmt->fetch(PDO::FETCH_ASSOC))  
        { 
            $osobaPotwierdzenie = $row["osobaPotwierdzenie"]; 
            $emailKlienta = $row["emailKlient"]; 
            $telefonKlienta = $row["telefonKlient"]; 
        }

// DANE WYKONAWCY //

$stmt = $dbh->prepare("SELECT spolka FROM crm WHERE numerZleceniaNew=:numerZleceniaNew LIMIT 1");
$stmt->bindParam(':numerZleceniaNew', $numerZleceniaNew, PDO::PARAM_INT);
$stmt->execute(); 
$spolka = $stmt->fetchColumn();


if ($spolka == 'A5') {
    $nipWykonawca = '9691609322';
} else if ($spolka == 'A5 PRINT') {
    $nipWykonawca = '9691620335';
}  else {
    $nipWykonawca = '';
}

if ($zaklada == 'Michał Biskupek') {
    $telWykonawca = '+48 534 111 053';
} else if ($zaklada == 'Łukasz Piontek') {
    $telWykonawca = '+48 797 723 753';
} else if ($zaklada == 'Joanna Bereżnicka') {
    $telWykonawca = '+48 797 723 743';
} else if ($zaklada == 'Damian Kuder') {
    $telWykonawca = '+48 517 238 288';
} else {
    $telWykonawca = '';
}


$stmt = $dbh->prepare("SELECT * FROM klienciCRM WHERE nip=:nipWykonawca");
$stmt->bindParam(':nipWykonawca', $nipWykonawca, PDO::PARAM_INT);
$stmt->execute(); 
while ($row = $stmt->fetch(PDO::FETCH_ASSOC))  
        { 
            $pelnaNazwaWykonawca = $row["nazwa"]; 
            $miastoWykonawca = $row["miasto"]; 
            $ulicaWykonawca = $row["ulica"];
            $kodWykonawca = $row["kod"];  
          
            
            
        }




function generateRandomString($length = 25) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString.".pdf";
}

function generateRandomString2($length = 500) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString.".pdf";
}




$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetTitle('Karta potwierdzenie '.$numerZleceniaNew);

$pdf->setFooterData(array(0,0,0), array(0,0,0));
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
// set some language-dependent strings (optional)


$pdf->setFontSubsetting(true);
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->setHeaderFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

$pdf->AddFont('dejavusans','','dejavusans.php');
$pdf->AddFont('dejavusansb','','dejavusans.php');
$pdf->SetFont('dejavusans', '', 8, '', false);

date_default_timezone_set('Europe/Warsaw');
$dataTeraz = date('m/d/Y h:i:s a', time());
$dataSamaGodzina = date('h:i:s a', time());
$time = explode(' ', $dataSamaGodzina);
$temp = date_parse($time[0]);
$temp['minute'] = str_pad($temp['minute'], 2, '0', STR_PAD_LEFT);
$dataTeraz = date('m/d/Y ').date('H:i a', strtotime($temp['hour'] . ':' . $temp['minute'] . ' ' . $time[1]));
$pdf->SetHeaderData('', 138, '', $dataTeraz, array(0, 0, 0), array(0, 0, 0));

// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);

// BARCODE STYLE //



$style = array(
    'position' => '',
    'align' => 'C',
    'stretch' => false,
    'fitwidth' => true,
    'cellfitalign' => '',
    'border' => false,
    'hpadding' => 'auto',
    'vpadding' => 'auto',
    'fgcolor' => array(0,0,0),
    'bgcolor' => false, //array(255,255,255),
    'text' => true,
    'font' => '',
    'fontsize' => 8,
    'stretchtext' => 4
);




// set font
$pdf->SetFont('freeserif', '', 12);





$pdf->AddPage();
$pdf->AddFont('dejavusans','','dejavusans.php');
$pdf->AddFont('dejavusansb','','dejavusans.php');



// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// dejavusans or times to reduce file size.
$pdf->SetFont('dejavusans', '', 7, '', false);


// tytul //

$pdf->SetFont('dejavusansb','',12);															
$pdf->MultiCell(180, 5, 'ZAMÓWIENIE NR: '.$rok."/".$miesiac."/".$numerZleceniaNew, 0, 'C', 0, 0, '', '', true);


if ($komentarz !== "") {
$pdf->Ln(6);    
$pdf->SetFont('dejavusansb','',6);															
$pdf->MultiCell(180, 5, 'KOMENTARZ: '.$komentarz, 0, 'C', 0, 0, '', '', true);
}

$pdf->Ln(10);

$pdf->SetFillColor(220, 255, 220);															

// dane klienta i firmy //

$pdf->SetFont('dejavusansb', '', 7);
$pdf->Ln(10);
$pdf->Cell(20,10,'');
$pdf->Cell(1,10,'ZAMAWIAJĄCY:',0,'L',false);
$pdf->Cell(88,10,'');
$pdf->Cell(1,10,'WYKONAWCA:',0,'L',false);
$pdf->Ln(6);


$pdf->SetFont('dejavusansb', '', 7);
$pdf->Ln(4);

// nazwa //

$pdf->MultiCell(20, 12, 'Nazwa :', 0, 'J', 0, 0, '', '', true, 0, true, true, 20, 'T');
$pdf->SetFont('dejavusans', '', 7);															
															
$pdf->MultiCell(90, 12, $pelnaNazwaKlienta, 1, 'J', 0, 0, '', '', true, 0, true, true, 20, 'T');
$pdf->MultiCell(80, 12, $pelnaNazwaWykonawca, 1, 'J', 0, 0, '', '', true, 0, true, true, 20, 'T');
$pdf->Ln(12);

// adres //
$pdf->SetFont('dejavusansb', '', 7);
$pdf->MultiCell(20, 9, 'Adres :', 0, 'J', 0, 0, '', '', true, 0, true, true, 20, 'T');
$pdf->SetFont('dejavusans', '', 7);															
															
$pdf->MultiCell(90, 9, $daneKlienta, 1, 'J', 0, 0, '', '', true, 0, true, true, 20, 'T');
$pdf->MultiCell(80, 9, $ulicaWykonawca.", ".$kodWykonawca." ".$miastoWykonawca, 1, 'J', 0, 0, '', '', true, 0, true, true, 20, 'T');


// nip //
$pdf->Ln(9);
$pdf->SetFont('dejavusansb', '', 7);
$pdf->MultiCell(20, 9, 'Nip :', 0, 'J', 0, 0, '', '', true, 0, true, true, 20, 'T');
$pdf->SetFont('dejavusans', '', 7);															
															
$pdf->MultiCell(90, 9, $nipKlienta, 1, 'J', 0, 0, '', '', true, 0, true, true, 20, 'T');
$pdf->MultiCell(80, 9, $nipWykonawca, 1, 'J', 0, 0, '', '', true, 0, true, true, 20, 'T');

// nip //
$pdf->Ln(9);
$pdf->SetFont('dejavusansb', '', 7);
$pdf->MultiCell(20, 9, 'Tel. :', 0, 'J', 0, 0, '', '', true, 0, true, true, 20, 'T');
$pdf->SetFont('dejavusans', '', 7);															
															
$pdf->MultiCell(90, 9, $telefonKlienta, 1, 'J', 0, 0, '', '', true, 0, true, true, 20, 'T');
$pdf->MultiCell(80, 9, $telWykonawca, 1, 'J', 0, 0, '', '', true, 0, true, true, 20, 'T');

// osoba //
$pdf->Ln(9);
$pdf->SetFont('dejavusansb', '', 7);
$pdf->MultiCell(20, 9, 'Osoba', 0, 'J', 0, 0, '', '', true, 0, true, true, 20, 'T');
$pdf->SetFont('dejavusans', '', 7);															
															
$pdf->MultiCell(90, 9, $osobaPotwierdzenie, 1, 'J', 0, 0, '', '', true, 0, true, true, 20, 'T');
$pdf->MultiCell(80, 9, $zaklada, 1, 'J', 0, 0, '', '', true, 0, true, true, 20, 'T');

// lista zamowien //

$pdf->Ln(15);
$pdf->SetFont('dejavusansb', '', 7);
$pdf->MultiCell(180, 9, '1. Zamawiający zleca wykonawcy następujące prace: ', 0, 'J', 0, 0, '', '', true, 0, true, true, 20, 'T');



$pdf->Ln(5);
$pdf->MultiCell(10, 9, 'Lp.', 1, 'J', 0, 0, '', '', true, 0, false, true, 9, 'M');
$pdf->MultiCell(120, 9, 'Nazwa produktu', 1, 'L', 0, 0, '', '', true, 0, false, true, 9, 'M');
$pdf->MultiCell(15, 9, 'Jm', 1, 'C', 0, 0, '', '', true, 0, false, true, 9, 'M');
$pdf->MultiCell(15, 9, 'Ilość', 1, 'C', 0, 0, '', '', true, 0, false, true, 9, 'M');
$pdf->MultiCell(15, 9, 'Cena', 1, 'C', 0, 0, '', '', true, 0, false, true, 9, 'M');
$pdf->MultiCell(15, 9, 'Wartość', 1, 'C', 0, 0, '', '', true, 0, false, true, 9, 'M');


// material //
$pdf->SetFont('dejavusans', '', 7);
if ($nazwy && $material !== "Bez materiału") {
$iloscRazem = 1+$iloscAkcesoria;
} else {
$iloscRazem = $iloscAkcesoria;    
}
// cenaMaterialu = wartosc //
$cenaMaterialu = $calosciM2 * $cenaGlobalna;





if ($nazwy && $material !== "Bez materiału") {
    $pdf->Ln(9);
    $pdf->MultiCell(10, 9, "1/".$iloscRazem, 1, 'J', 0, 0, '', '', true, 0, false, true, 9, 'M');
    $pdf->MultiCell(120, 9, 'Druk na '.$material.' ', 1, 'L', 0, 0, '', '', true, 0, false, true, 9, 'M');
    $pdf->MultiCell(15, 9, $jednostkaGlobalna, 1, 'C', 0, 0, '', '', true, 0, false, true, 9, 'M');
    $pdf->MultiCell(15, 9, $calosciM2, 1, 'C', 0, 0, '', '', true, 0, false, true, 9, 'M');
    $pdf->MultiCell(15, 9, number_format((float)$cenaGlobalna, 2, '.', ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 9, 'M');
    $pdf->MultiCell(15, 9, number_format((float)$cenaMaterialu, 2, '.', ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 9, 'M');
    $plus = 2;
} else {
    $plus = 1;
}




// dodatkowe akcesoria //



if ($akcesoria){

    for ($i = 0; $i < $iloscAkcesoria; $i++) {
    	
      
    	if ($pdf->GetY() > 260) {
    	$pdf->addPage();
    	}

    	$cenaAkcesoriow = $dodatkoweIloscUzytkow[$i] * $dodatkoweCenaJednostkowaUzytkow[$i];
    	$pdf->Ln(9);
    	$pdf->MultiCell(10, 9, ($i+$plus)."/".$iloscRazem, 1, 'J', 0, 0, '', '', true, 0, false, true, 9, 'M');
    	$pdf->MultiCell(120, 9, $nazwyAkcesoria[$i], 1, 'L', 0, 0, '', '', true, 0, false, true, 9, 'M');
    	$pdf->MultiCell(15, 9, $dodatkoweJednostkaUzytkow[$i], 1, 'C', 0, 0, '', '', true, 0, false, true, 9, 'M');
    	$pdf->MultiCell(15, 9, $dodatkoweIloscUzytkow[$i], 1, 'C', 0, 0, '', '', true, 0, false, true, 9, 'M');
    	$pdf->MultiCell(15, 9, number_format((float)$dodatkoweCenaJednostkowaUzytkow[$i], 2, '.', ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 9, 'M');
    	$pdf->MultiCell(15, 9, number_format((float)$cenaAkcesoriow, 2, '.', ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 9, 'M');

    }


    if ($waluta == "pln" OR $waluta == "zł") {
    	$waluta = "PLN";
    	$pdf->Ln(9);
    	$pdf->MultiCell(175, 9, 'RAZEM NETTO '.$waluta, 1, 'R', 0, 0, '', '', true, 0, false, true, 9, 'M');
    	$pdf->MultiCell(15, 9, number_format((float)$calosciCena, 2, '.', ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 9, 'M');
        $pdf->Ln(9);
        $pdf->SetFont('dejavusansB', '', 8);
    	$pdf->MultiCell(170, 9, 'DO ZAPŁATY BRUTTO '.$waluta, 0, 'R', 0, 0, '', '', true, 0, false, true, 9, 'M');
    	$pdf->MultiCell(25, 9, number_format((float)($calosciCena*0.23)+$calosciCena, 2, '.', ''), 0, 'C', 0, 0, '', '', true, 0, false, true, 9, 'M');
    	$pdf->SetFont('dejavusans', '', 7);
    }

    if ($waluta == "euro") {
    	$waluta = "EURO";
    	$pdf->Ln(9);
    	$pdf->SetFont('dejavusansB', '', 8);
        $pdf->MultiCell(170, 9, 'DO ZAPŁATY '.$waluta, 0, 'R', 0, 0, '', '', true, 0, false, true, 9, 'M');
        $pdf->MultiCell(25, 9, number_format((float)$calosciCena, 2, '.', ''), 0, 'C', 0, 0, '', '', true, 0, false, true, 9, 'M');
        $pdf->SetFont('dejavusans', '', 7);
    }


} else {


if ($waluta == "pln" OR $waluta == "zł") {
        $waluta = "PLN";
        $pdf->Ln(9);
        $pdf->MultiCell(175, 9, 'RAZEM NETTO '.$waluta, 1, 'R', 0, 0, '', '', true, 0, false, true, 9, 'M');
        $pdf->MultiCell(15, 9, number_format((float)$calosciCena, 2, '.', ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 9, 'M');
        $pdf->Ln(9);
        $pdf->SetFont('dejavusansB', '', 8);
        $pdf->MultiCell(170, 9, 'DO ZAPŁATY BRUTTO '.$waluta, 0, 'R', 0, 0, '', '', true, 0, false, true, 9, 'M');
        $pdf->MultiCell(25, 9, number_format((float)($calosciCena*0.23)+$calosciCena, 2, '.', ''), 0, 'C', 0, 0, '', '', true, 0, false, true, 9, 'M');
        $pdf->SetFont('dejavusans', '', 7);
    }

    if ($waluta == "euro") {
        $waluta = "EURO";
        $pdf->Ln(9);
        $pdf->SetFont('dejavusansB', '', 8);
        $pdf->MultiCell(170, 9, 'DO ZAPŁATY '.$waluta, 0, 'R', 0, 0, '', '', true, 0, false, true, 9, 'M');
        $pdf->MultiCell(25, 9, number_format((float)$calosciCena, 2, '.', ''), 0, 'C', 0, 0, '', '', true, 0, false, true, 9, 'M');
        $pdf->SetFont('dejavusans', '', 7);
    }






}

// informacje szczegolowe //

$pdf->Ln(8);
$pdf->SetFont('dejavusansb', '', 7);
$pdf->MultiCell(180, 9, '2. Informacje szczegółowe: ', 0, 'J', 0, 0, '', '', true, 0, true, true, 20, 'T');


$pdf->SetFont('dejavusans', '', 7);
$pdf->Ln(5);
$pdf->MultiCell(47.5, 0, 'Data wysyłki:', 1, 'L', 0, 0, '', '', true, 0, false, true, 9, 'M');
$pdf->MultiCell(47.5, 0, $data, 1, 'C', 0, 0, '', '', true, 0, false, true, 9, 'M');
$pdf->MultiCell(47.5, 0, 'Warunki dostawy:', 1, 'L', 0, 0, '', '', true, 0, false, true, 9, 'M');
$pdf->MultiCell(47.5, 0, $wysylka, 1, 'C', 0, 0, '', '', true, 0, false, true, 9, 'M');

$pdf->Ln(7);
$pdf->MultiCell(47.5, 0, 'Sposób płatności:', 1, 'L', 0, 0, '', '', true, 0, false, true, 9, 'M');
$pdf->MultiCell(47.5, 0, $platnosc, 1, 'C', 0, 0, '', '', true, 0, false, true, 9, 'M');
$pdf->MultiCell(47.5, 0, 'Koszty transportu:', 1, 'L', 0, 0, '', '', true, 0, false, true, 9, 'M');
$pdf->MultiCell(47.5, 0, $kosztyTransportu, 1, 'C', 0, 0, '', '', true, 0, false, true, 9, 'M');

$pdf->Ln(7);
$pdf->MultiCell(47.5, 0, 'Pakowanie:', 1, 'L', 0, 0, '', '', true, 0, false, true, 9, 'M');
$pdf->MultiCell(47.5, 0, $pakowanie, 1, 'C', 0, 0, '', '', true, 0, false, true, 9, 'M');
//$pdf->MultiCell(47.5, 0, 'Koszty transportu:', 1, 'L', 0, 0, '', '', true, 0, false, true, 9, 'M');
//$pdf->MultiCell(47.5, 0, $kosztyTransportu, 1, 'C', 0, 0, '', '', true, 0, false, true, 9, 'M');



// DODATKOWE INFORMACJE //
$pdf->Ln(15);
$pdf->SetFont('dejavusansb', '', 8);
$pdf->MultiCell(20, 9, 'Uwagi', 0, 'L', 0, 0, '', '', true, 0, false, true, 9, 'T');
$pdf->Ln(5);
$pdf->SetFont('dejavusans', '', 8);
$pdf->MultiCell(170, 20, 'Cena zawiera: weryfikację i przygotowanie plików graficznych oraz wydruk. W przypadku wydruku prac poniżej jednego metra kwadratowego ich cena zostanie zaokrąglona do równowartości pełnego metra. W przypadku złożenia zamówienia na niestandardową obróbkę oczkowania ( standard to oczka co 50 cm ) za każdy m2 doliczamy 0,5 zł netto.', 0, 'L', 0, 0, '', '', true, 0, true, true, 9, 'T');

$pdf->Ln(20);
$pdf->SetFont('dejavusansb', '', 8);
$pdf->MultiCell(50, 15, 'Warunki realizacji', 0, 'L', 0, 0, '', '', true, 0, false, true, 9, 'T');
$pdf->Ln(5);
$pdf->SetFont('dejavusans', '', 8);
$pdf->MultiCell(170, 20, 'Podane ceny są cenami netto, do których należy doliczyć podatek VAT w wysokości obowiązującej w dniu wystawienia faktury VAT. Zamawiający zgadza się na wystawienie faktury bez swojego podpisu. Ceny nie obejmują kosztów transportu. Wykonawca nie ponosi odpowiedzialności za niedotrzymanie terminu dostarczenia przesyłki, jeżeli jest to następstwem opóźnień przewoźnika. A5 Spółka z ograniczoną odpowiedzialnością sp.k. zobowiązuje się do rozpatrzenia reklamacji w ciągu 3 dni roboczych.',  0, 'L', 0, 0, '', '', true, 0, true, true, 9, 'T');

$pdf->Cell(0, 5, '', 0, 'L', 0, 0, '', '', true, 0, false, true, 9, 'T');

if ($pdf->GetY() + 50 > 260) {
	$pdf->addPage();
	}

$pdf->SetFont('dejavusansb', '', 10);
$pdf->Ln(30);

$pdf->MultiCell(95, 5, 'ZAMAWIAJĄCY', 0, 'C', 0, 0, '', '', true, 0, false, true, 9, 'M');
$pdf->MultiCell(95, 5, 'WYKONAWCA', 0, 'C', 0, 0, '', '', true, 0, false, true, 9, 'M');
$pdf->Ln(15);

$pdf->SetFont('dejavusans', '', 7);
$pdf->MultiCell(47.5, 5, '..........................................', 0, 'C', 0, 0, '', '', true, 0, false, true, 9, 'M');
$pdf->MultiCell(47.5, 5, '..........................................', 0, 'C', 0, 0, '', '', true, 0, false, true, 9, 'M');
$pdf->MultiCell(47.5, 5, '..........................................', 0, 'C', 0, 0, '', '', true, 0, false, true, 9, 'M');
$pdf->MultiCell(47.5, 5, '..........................................', 0, 'C', 0, 0, '', '', true, 0, false, true, 9, 'M');

$pdf->Ln(5);
$pdf->SetFont('dejavusans', '', 5);
$pdf->MultiCell(47.5, 5, 'Data', 0, 'C', 0, 0, '', '', true, 0, false, true, 9, 'M');
$pdf->MultiCell(47.5, 5, 'Podpis', 0, 'C', 0, 0, '', '', true, 0, false, true, 9, 'M');
$pdf->MultiCell(47.5, 5, 'Data', 0, 'C', 0, 0, '', '', true, 0, false, true, 9, 'M');
$pdf->MultiCell(47.5, 5, 'Podpis', 0, 'C', 0, 0, '', '', true, 0, false, true, 9, 'M');


if ($nazwy) {
    // druga strona //

    $quantity = $iloscPlikow;

    for ($i = 0; $i < $quantity; $i++) {
    	
    $pdf->addPage();



    $pdf->SetFont('dejavusans', '', 11);
    $pdf->Ln(4);
    $pdf->MultiCell(50, 10, 'Klient: ', 0, 'J', 0, 0, '', '', true, 0, true, true, 20, 'T');  

                                                                $pdf->SetFont('dejavusansb', '', 12);                                                           
                                                                $pdf->MultiCell(130,10,$klient ,0,'L',false);



                                                                $pdf->Ln(-5);


    $pdf->SetFont('dejavusans', '', 11);
    $pdf->Ln(6);
    $pdf->Cell(50,10,'Numer zlecenia:');                                                            
                                                                

                                                                $pdf->SetFont('dejavusansb', '', 12);                                                           
                                                                $pdf->Cell(130,10,$rok."/".$miesiac."/".$numerZleceniaNew ,0,'C',false); 




    $pdf->SetFont('dejavusans', '',10);
    $pdf->Ln(10);
                                                            
    $pdf->MultiCell(50, 0, 'Plik źródłowy: ', 0, 'J', 0, 0, '', '', true, 0, true, true, 20, 'T');                                                      

                                                                $pdf->SetFont('dejavusans', '', 11);                                                            
                                                                $pdf->MultiCell(130,0,':  '.$nazwyPlikow[$i] ,0,'L',FALSE); 
                                                                $pdf->Ln(-8);


                                                         



    $pdf->SetFont('dejavusans', '',10);
    $pdf->Ln(6);
    $pdf->Cell(50,10,'Nr pliku: ' ,0,'C',FALSE);															
    															

    															$pdf->SetFont('dejavusans', '', 11);															
    															$pdf->Cell(130,10,':  '.($i+1)."/".$quantity,0,'C',FALSE);	




    $pdf->SetFont('dejavusans', '', 10);
    $pdf->Ln(6);
    $pdf->Cell(50,10,'Wymiar: ' ,0,'C',FALSE);															
    															

    															$pdf->SetFont('dejavusans', '', 11);															
    															$pdf->Cell(130,10,':  '.$wymiaryX[$i]."cm X ".$wymiaryY[$i]."cm (A x B)" ,0,'C',FALSE);	



    $pdf->SetFont('dejavusans', '', 10);
    $pdf->Ln(6);
    $pdf->Cell(50,10,'Wymiar całkowity: ' ,0,'C',FALSE);															
    															

    															$pdf->SetFont('dejavusans', '', 11);															
    															$pdf->Cell(130,10,':  '.$calkowityWymiaryX[$i]."cm X ".$calkowityWymiaryY[$i]."cm (A x B)" ,0,'C',FALSE);																



    $pdf->SetFont('dejavusans', '', 10);
    $pdf->Ln(6);
    $pdf->Cell(50,10,'m2: ' ,0,'C',FALSE);															
    															

    															$pdf->SetFont('dejavusans', '', 11);															
    															$pdf->Cell(130,10,':  '.$m2Uzytkow[$i] ,0,'C',FALSE);	


    $pdf->SetFont('dejavusans', '',10);
    $pdf->Ln(8);


                                                            
    $pdf->MultiCell(50, 0, 'Materiał: ', 0, 'J', 0, 0, '', '', true, 0, true, true, 20, 'T');                                                      

                                                                $pdf->SetFont('dejavusans', '', 11);                                                            
                                                                $pdf->MultiCell(130,0,':  '.$material ,0,'L',FALSE); 
                                                                $pdf->Ln(-8);													


    $pdf->SetFont('dejavusans', '', 10);
    $pdf->Ln(6);
    $pdf->Cell(50,10,'ilość kopii: ' ,0,'C',FALSE);															
    															

    															$pdf->SetFont('dejavusans', '', 11);															
    															$pdf->Cell(130,10,':  '.$iloscUzytkow[$i] ,0,'C',FALSE);
    	






    $pdf->Ln(20);
                                                                $pdf->SetFont('dejavusansb', '', 10);															
    															$pdf->Cell(0,5,$obrobkaTopUzytkow[$i],0,0,'C');
                                                                $pdf->SetFont('dejavusans', '', 10);

    															if ($topValueTunelUzytkow[$i] > 0) {
    																$pdf->Ln(6);
    																$pdf->Cell(0,5,"Tunel na płasko: ".$topValueTunelUzytkow[$i]." cm",0,0,'C');
    															}

    															if ($oczkaTopUzytkow[$i] > 0) {
    																$pdf->Ln(6);
    																$pdf->Cell(0,5,"Oczkowanie co: ".$oczkaTopUzytkow[$i]." cm",0,0,'C');

    															}

    $pdf->Ln(6);




    $image1 = "image.jpg";
    $pdf->Image($image1, 70, $pdf->GetY() + 10, 70);

    $pdf->Ln();
    $pdf->SetX(130); //The next cell will be set 100 units to the right
    $pdf->Cell(130,0,'',0,0,'L');


    $pdf->Ln();


    $pdf->SetFont('dejavusans', '', 11);
    $pdf->Cell(0.1,0,'',0,0,'L');															
    $pdf->SetFont('dejavusans', '', 11);



    // lewe //

    $pdf->SetX(0);
    $pdf->SetFont('dejavusansb', '', 10);
    $pdf->Cell(70,25,$obrobkaLeftUzytkow[$i],0,0,'C');
    $pdf->SetFont('dejavusans', '', 10);
    $pdf->Ln(6);

    $pdf->SetX(0);
    if ($leftValueTunelUzytkow[$i] > 0) {
    $pdf->Cell(70,25,"Tunel na płasko: ".$leftValueTunelUzytkow[$i]." cm",0,0,'C');
    $pdf->Ln(6);
    }

    $pdf->SetX(0);
    if ($oczkaLeftUzytkow[$i] > 0) {
    $pdf->Cell(70,25,"Oczkowanie co: ".$oczkaLeftUzytkow[$i]." cm",0,0,'C');

    }
                                                                                                                        // prawe //

                                                                                                                        $pdf->SetX(0); //The next cell will be set 100 units to the right
                                                                                                                        $pdf->SetFont('dejavusansb', '', 10);
                                                                                                                        $pdf->Cell(350,13,$obrobkaRightUzytkow[$i],0,0,'C');
                                                                                                                        $pdf->SetFont('dejavusans', '', 10);
                                                                                                                        $pdf->Ln(6);
                                                                                                                   

                                                                                                                        $pdf->SetX(0);
                                                                                                                        if ($rightValueTunelUzytkow[$i] > 0) {
                                                                                                                        $pdf->Cell(350,13,"Tunel na płasko: ".$rightValueTunelUzytkow[$i]." cm",0,0,'C');
                                                                                                                        $pdf->Ln(6);
                                                                                                                        }

                                                                                                                        $pdf->SetX(0);
                                                                                                                        if ($oczkaRightUzytkow[$i] > 0) {
                                                                                                                        $pdf->Cell(350,13,"Oczkowanie co: ".$oczkaRightUzytkow[$i]." cm",0,0,'C');
                                                                                                                        $pdf->Ln(6);

                                                                                                                        }





                                                                // dół //

                                                                $pdf->Ln(35);
                                                                $pdf->SetFont('dejavusansb', '', 10);                                                           
                                                                $pdf->Cell(0,5,$obrobkaBotUzytkow[$i],0,0,'C');
                                                                $pdf->SetFont('dejavusans', '', 10);
                                                                $pdf->Ln(6);

                                                                if ($botValueTunelUzytkow[$i] > 0) {
                                                                    $pdf->Cell(0,5,"Tunel na płasko: ".$botValueTunelUzytkow[$i]." cm",0,0,'C');
                                                                    $pdf->Ln(6);
                                                                }

                                                                if ($oczkaBotUzytkow[$i] > 0) {
                                                                    $pdf->Cell(0,5,"Oczkowanie co: ".$oczkaBotUzytkow[$i]." cm",0,0,'C');

                                                                }








    $pdf->Ln(20);
    $pdf->SetFont('dejavusans', '', 10);
    

    if ($informacjeDodatkoweUzytkow[$i] !== '' OR $drukInformacjeDodatkoweUzytkow[$i] !== '' OR $halaInformacjeDodatkoweUzytkow[$i] !== '') {
    $pdf->Cell(0,5,'Informacje produkcyjne',0,0,'C');
    $pdf->Ln(10);
    }
    
    // info dla grafika //
    if ($informacjeDodatkoweUzytkow[$i] !== '') {

        $w = 20;
        $pdf->SetFont('dejavusansb','',7);
        $x=$pdf->GetX();
        $y=$pdf->GetY();

        $pdf->SetXY($x+$w,$y);
        $x=$pdf->GetX();
        $y=$pdf->GetY();
        $w = 170;

        $x=$pdf->GetX();
        $y=$pdf->GetY();
        $Y=$pdf->GetY();

        $pdf->SetFont('dejavusans','',7);
        $pdf->SetXY(30,$Y);
        $pdf->Multicell($w,10,$informacjeDodatkoweUzytkow[$i],'LTBR', 'L', 0, 1, '', '', true, 0, true, true, 0, false, true, 40, 'M');
        $H = $pdf->GetY();
        $height= $H-$Y;

        $pdf->Ln(20);
        $pdf->SetXY(10,$y);
        $x=$pdf->GetX();
        $y=$pdf->GetY();
        $w = 20;

        $pdf->SetFont('dejavusansb','',7);
        $pdf->Multicell($w,$height,'Grafik','LTBR', 'C', 0, 1, '', '', true, 0, true, true, 0, false, true, 40, 'C');

        if ($pdf->GetY() > 260) {
            $pdf->addPage();
        }

    }

    // info dla drukarza //
    if ($drukInformacjeDodatkoweUzytkow[$i] !== '') {


        $w = 20;
        $pdf->SetFont('dejavusansb','',7);
        $x=$pdf->GetX();
        $y=$pdf->GetY();

        $pdf->SetXY($x+$w,$y);
        $x=$pdf->GetX();
        $y=$pdf->GetY();
        $w = 170;

        $x=$pdf->GetX();
        $y=$pdf->GetY();
        $Y=$pdf->GetY();

        $pdf->SetFont('dejavusans','',7);
        $pdf->SetXY(30,$Y);
        $pdf->Multicell($w,10,$drukInformacjeDodatkoweUzytkow[$i],'LTBR', 'L', 0, 1, '', '', true, 0, true, true, 0, false, true, 40, 'M');
        $H = $pdf->GetY();
        $height= $H-$Y;

        $pdf->Ln(20);
        $pdf->SetXY(10,$y);
        $x=$pdf->GetX();
        $y=$pdf->GetY();
        $w = 20;

        $pdf->SetFont('dejavusansb','',7);
        $pdf->Multicell($w,$height,'Druk','LTBR', 'C', 0, 1, '', '', true, 0, true, true, 0, false, true, 40, 'C');

        if ($pdf->GetY() > 260) {
            $pdf->addPage();
        }

    }

    // info dla hali //
    if ($halaInformacjeDodatkoweUzytkow[$i] !== '') {


        $w = 20;
        $pdf->SetFont('dejavusansb','',7);
        $x=$pdf->GetX();
        $y=$pdf->GetY();

        $pdf->SetXY($x+$w,$y);
        $x=$pdf->GetX();
        $y=$pdf->GetY();
        $w = 170;

        $x=$pdf->GetX();
        $y=$pdf->GetY();
        $Y=$pdf->GetY();

        $pdf->SetFont('dejavusans','',7);
        $pdf->SetXY(30,$Y);
        $pdf->Multicell($w,10,$halaInformacjeDodatkoweUzytkow[$i],'LTBR', 'L', 0, 1, '', '', true, 0, true, true, 0, false, true, 40, 'M');
        $H = $pdf->GetY();
        $height= $H-$Y;

        $pdf->Ln(20);
        $pdf->SetXY(10,$y);
        $x=$pdf->GetX();
        $y=$pdf->GetY();
        $w = 20;

        $pdf->SetFont('dejavusansb','',7);
        $pdf->Multicell($w,$height,'Hala','LTBR', 'C', 0, 1, '', '', true, 0, true, true, 0, false, true, 40, 'C');

        if ($pdf->GetY() > 260) {
            $pdf->addPage();
        }
        
    }


    	
    }
}



if ($akcja == 'zobacz') {


ob_end_clean();
$pdf->Output();

}









?>
