<?php

function currencyConverter($currency_from,$currency_to,$currency_input){
    //Use Yahoo Finance 
    $yql_base_url = "http://query.yahooapis.com/v1/public/yql";
    $yql_query = 'select * from yahoo.finance.xchange where pair in ("'.$currency_from.$currency_to.'")';
    $yql_query_url = $yql_base_url . "?q=" . urlencode($yql_query);
    $yql_query_url .= "&format=json&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys";
    $yql_session = file_get_contents($yql_query_url);
    $yql_json =  json_decode($yql_session,true);
    $currency_output = (float) $currency_input*$yql_json['query']['results']['rate']['Rate'];
    
    //Check for errors 
    //One potential error: input is not zero, but output is either 0 or null
    $a = ($currency_input != 0);
    $b = ($currency_output == 0);
    //Second potential error: currency output is not numeric
    $c = !(is_numeric($currency_output));
    if (($a && $b)||($c))
    {
    $amount = urlencode($currency_input);
    $from_Currency = urlencode($currency_from);
    $to_Currency = urlencode($currency_to);
    $get = file_get_contents("https://www.google.com/finance/converter?a=$amount&from=$from_Currency&to=$to_Currency");
    $get = explode("<span class=bld>",$get);
    $get = explode("</span>",$get[1]);  
    $currency_output = preg_replace("/[^0-9\.]/", null, $get[0]);
    
    return $currency_output;
    }

    return $currency_output;
}

//Base cases
$currency_from = "";
$currency_to = "";
$currency_input = "";
$xx = "what is the latest currency exchange as today?";

if (((isset($_POST['currency_input']))&&(isset($_POST['currency_to']))&&(isset($_POST['currency_from']))))
    {
    $xx = " is equal to ";
    $currency_from = $_POST['currency_from'];
    $currency_to = $_POST['currency_to'];
    $currency_input = $_POST['currency_input'];
    //Ensure the content typed actually a number to be converted (to prevent errors)
    if (is_numeric($currency_input)){
        $currency = currencyConverter($currency_from,$currency_to,$currency_input);
    }
    else if ($currency_input == "")
    {
        $currency_from = "Your input";
        $currency = "nothing, you need to type in";
        $currency_to = "";
    }
    else
    {
        $currency = "$currency_input is not a number";
        $currency_to = "";
    }
    }
 //currency codes : http://en.wikipedia.org/wiki/ISO_4217

echo <<<_END
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>PHP Currency Conversion</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
    body {
        padding-top: 70px;
        /* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
    }
    </style>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Currency Conversion</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container">
      <div>
    <section id="intro" class="intro-section">
                <div class="col-lg-12">
                    <section id="newConversion">
                            <hr>
                        <form method="post" action="index.php">
                        <div class="form-group">
                        <label class="control-label" for="inputSmall">ENTER AMOUNT:</label>
                        <input class="form-control input-sm" id="inputSmall" type="text" name="currency_input" />
                    <br>
            <div class="form-actions">
                <input type="submit" class="btn btn-primary" value="Convert" />
            </div>
                    
        <label>Select currency (from):</label>
            <select class="form-control" id="select" name="currency_from">
        <option  value="AED">United Arab Emirates Dirham (AED)</option>
        <option  value="AFN">Afghan Afghani (AFN)</option>
        <option  value="ALL">Albanian Lek (ALL)</option>
        <option  value="AMD">Armenian Dram (AMD)</option>
        <option  value="ANG">Netherlands Antillean Guilder (ANG)</option>
        <option  value="AOA">Angolan Kwanza (AOA)</option>
        <option  value="ARS">Argentine Peso (ARS)</option>
        <option  value="AUD">Australian Dollar (A$)</option>
        <option  value="AWG">Aruban Florin (AWG)</option>
        <option  value="AZN">Azerbaijani Manat (AZN)</option>
        <option  value="BAM">Bosnia-Herzegovina Convertible Mark (BAM)</option>
        <option  value="BBD">Barbadian Dollar (BBD)</option>
        <option  value="BDT">Bangladeshi Taka (BDT)</option>
        <option  value="BGN">Bulgarian Lev (BGN)</option>
        <option  value="BHD">Bahraini Dinar (BHD)</option>
        <option  value="BIF">Burundian Franc (BIF)</option>
        <option  value="BMD">Bermudan Dollar (BMD)</option>
        <option  value="BND">Brunei Dollar (BND)</option>
        <option  value="BOB">Bolivian Boliviano (BOB)</option>
        <option  value="BRL">Brazilian Real (R$)</option>
        <option  value="BSD">Bahamian Dollar (BSD)</option>
        <option  value="BTC">Bitcoin (฿)</option>
        <option  value="BTN">Bhutanese Ngultrum (BTN)</option>
        <option  value="BWP">Botswanan Pula (BWP)</option>
        <option  value="BYR">Belarusian Ruble (BYR)</option>
        <option  value="BZD">Belize Dollar (BZD)</option>
        <option  value="CAD">Canadian Dollar (CA$)</option>
        <option  value="CDF">Congolese Franc (CDF)</option>
        <option  value="CHF">Swiss Franc (CHF)</option>
        <option  value="CLF">Chilean Unit of Account (UF) (CLF)</option>
        <option  value="CLP">Chilean Peso (CLP)</option>
        <option  value="CNH">CNH (CNH)</option>
        <option  value="CNY">Chinese Yuan (CN¥)</option>
        <option  value="COP">Colombian Peso (COP)</option>
        <option  value="CRC">Costa Rican Colón (CRC)</option>
        <option  value="CUP">Cuban Peso (CUP)</option>
        <option  value="CVE">Cape Verdean Escudo (CVE)</option>
        <option  value="CZK">Czech Republic Koruna (CZK)</option>
        <option  value="DEM">German Mark (DEM)</option>
        <option  value="DJF">Djiboutian Franc (DJF)</option>
        <option  value="DKK">Danish Krone (DKK)</option>
        <option  value="DOP">Dominican Peso (DOP)</option>
        <option  value="DZD">Algerian Dinar (DZD)</option>
        <option  value="EGP">Egyptian Pound (EGP)</option>
        <option  value="ERN">Eritrean Nakfa (ERN)</option>
        <option  value="ETB">Ethiopian Birr (ETB)</option>
        <option  value="EUR">Euro (€)</option>
        <option  value="FIM">Finnish Markka (FIM)</option>
        <option  value="FJD">Fijian Dollar (FJD)</option>
        <option  value="FKP">Falkland Islands Pound (FKP)</option>
        <option  value="FRF">French Franc (FRF)</option>
        <option  value="GBP">British Pound (£)</option>
        <option  value="GEL">Georgian Lari (GEL)</option>
        <option  value="GHS">Ghanaian Cedi (GHS)</option>
        <option  value="GIP">Gibraltar Pound (GIP)</option>
        <option  value="GMD">Gambian Dalasi (GMD)</option>
        <option  value="GNF">Guinean Franc (GNF)</option>
        <option  value="GTQ">Guatemalan Quetzal (GTQ)</option>
        <option  value="GYD">Guyanaese Dollar (GYD)</option>
        <option  value="HKD">Hong Kong Dollar (HK$)</option>
        <option  value="HNL">Honduran Lempira (HNL)</option>
        <option  value="HRK">Croatian Kuna (HRK)</option>
        <option  value="HTG">Haitian Gourde (HTG)</option>
        <option  value="HUF">Hungarian Forint (HUF)</option>
        <option  value="IDR">Indonesian Rupiah (IDR)</option>
        <option  value="IEP">Irish Pound (IEP)</option>
        <option  value="ILS">Israeli New Sheqel (₪)</option>
        <option  value="INR">Indian Rupee (Rs.)</option>
        <option  value="IQD">Iraqi Dinar (IQD)</option>
        <option  value="IRR">Iranian Rial (IRR)</option>
        <option  value="ISK">Icelandic Króna (ISK)</option>
        <option  value="ITL">Italian Lira (ITL)</option>
        <option  value="JMD">Jamaican Dollar (JMD)</option>
        <option  value="JOD">Jordanian Dinar (JOD)</option>
        <option  value="JPY">Japanese Yen (¥)</option>
        <option  value="KES">Kenyan Shilling (KES)</option>
        <option  value="KGS">Kyrgystani Som (KGS)</option>
        <option  value="KHR">Cambodian Riel (KHR)</option>
        <option  value="KMF">Comorian Franc (KMF)</option>
        <option  value="KPW">North Korean Won (KPW)</option>
        <option  value="KRW">South Korean Won (₩)</option>
        <option  value="KWD">Kuwaiti Dinar (KWD)</option>
        <option  value="KYD">Cayman Islands Dollar (KYD)</option>
        <option  value="KZT">Kazakhstani Tenge (KZT)</option>
        <option  value="LAK">Laotian Kip (LAK)</option>
        <option  value="LBP">Lebanese Pound (LBP)</option>
        <option  value="LKR">Sri Lankan Rupee (LKR)</option>
        <option  value="LRD">Liberian Dollar (LRD)</option>
        <option  value="LSL">Lesotho Loti (LSL)</option>
        <option  value="LTL">Lithuanian Litas (LTL)</option>
        <option  value="LVL">Latvian Lats (LVL)</option>
        <option  value="LYD">Libyan Dinar (LYD)</option>
        <option  value="MAD">Moroccan Dirham (MAD)</option>
        <option  value="MDL">Moldovan Leu (MDL)</option>
        <option  value="MGA">Malagasy Ariary (MGA)</option>
        <option  value="MKD">Macedonian Denar (MKD)</option>
        <option  value="MMK">Myanmar Kyat (MMK)</option>
        <option  value="MNT">Mongolian Tugrik (MNT)</option>
        <option  value="MOP">Macanese Pataca (MOP)</option>
        <option  value="MRO">Mauritanian Ouguiya (MRO)</option>
        <option  value="MUR">Mauritian Rupee (MUR)</option>
        <option  value="MVR">Maldivian Rufiyaa (MVR)</option>
        <option  value="MWK">Malawian Kwacha (MWK)</option>
        <option  value="MXN">Mexican Peso (MX$)</option>
        <option  value="MYR">Malaysian Ringgit (MYR)</option>
        <option  value="MZN">Mozambican Metical (MZN)</option>
        <option  value="NAD">Namibian Dollar (NAD)</option>
        <option  value="NGN">Nigerian Naira (NGN)</option>
        <option  value="NIO">Nicaraguan Córdoba (NIO)</option>
        <option  value="NOK">Norwegian Krone (NOK)</option>
        <option  value="NPR">Nepalese Rupee (NPR)</option>
        <option  value="NZD">New Zealand Dollar (NZ$)</option>
        <option  value="OMR">Omani Rial (OMR)</option>
        <option  value="PAB">Panamanian Balboa (PAB)</option>
        <option  value="PEN">Peruvian Nuevo Sol (PEN)</option>
        <option  value="PGK">Papua New Guinean Kina (PGK)</option>
        <option  value="PHP">Philippine Peso (Php)</option>
        <option  value="PKG">PKG (PKG)</option>
        <option  value="PKR">Pakistani Rupee (PKR)</option>
        <option  value="PLN">Polish Zloty (PLN)</option>
        <option  value="PYG">Paraguayan Guarani (PYG)</option>
        <option  value="QAR">Qatari Rial (QAR)</option>
        <option  value="RON">Romanian Leu (RON)</option>
        <option  value="RSD">Serbian Dinar (RSD)</option>
        <option  value="RUB">Russian Ruble (RUB)</option>
        <option  value="RWF">Rwandan Franc (RWF)</option>
        <option  value="SAR">Saudi Riyal (SAR)</option>
        <option  value="SBD">Solomon Islands Dollar (SBD)</option>
        <option  value="SCR">Seychellois Rupee (SCR)</option>
        <option  value="SDG">Sudanese Pound (SDG)</option>
        <option  value="SEK">Swedish Krona (SEK)</option>
        <option  value="SGD">Singapore Dollar (SGD)</option>
        <option  value="SHP">St. Helena Pound (SHP)</option>
        <option  value="SKK">Slovak Koruna (SKK)</option>
        <option  value="SLL">Sierra Leonean Leone (SLL)</option>
        <option  value="SOS">Somali Shilling (SOS)</option>
        <option  value="SRD">Surinamese Dollar (SRD)</option>
        <option  value="STD">São Tomé &amp; Príncipe Dobra (STD)</option>
        <option  value="SVC">Salvadoran Colón (SVC)</option>
        <option  value="SYP">Syrian Pound (SYP)</option>
        <option  value="SZL">Swazi Lilangeni (SZL)</option>
        <option  value="THB">Thai Baht (THB)</option>
        <option  value="TJS">Tajikistani Somoni (TJS)</option>
        <option  value="TMT">Turkmenistani Manat (TMT)</option>
        <option  value="TND">Tunisian Dinar (TND)</option>
        <option  value="TOP">Tongan Paʻanga (TOP)</option>
        <option  value="TRY">Turkish Lira (TRY)</option>
        <option  value="TTD">Trinidad &amp; Tobago Dollar (TTD)</option>
        <option  value="TWD">New Taiwan Dollar (NT$)</option>
        <option  value="TZS">Tanzanian Shilling (TZS)</option>
        <option  value="UAH">Ukrainian Hryvnia (UAH)</option>
        <option  value="UGX">Ugandan Shilling (UGX)</option>
        <option  value="USD">US Dollar ($)</option>
        <option  value="UYU">Uruguayan Peso (UYU)</option>
        <option  value="UZS">Uzbekistani Som (UZS)</option>
        <option  value="VEF">Venezuelan Bolívar (VEF)</option>
        <option  value="VND">Vietnamese Dong (₫)</option>
        <option  value="VUV">Vanuatu Vatu (VUV)</option>
        <option  value="WST">Samoan Tala (WST)</option>
        <option  value="XAF">Central African CFA Franc (FCFA)</option>
        <option  value="XCD">East Caribbean Dollar (EC$)</option>
        <option  value="XDR">Special Drawing Rights (XDR)</option>
        <option  value="XOF">West African CFA Franc (CFA)</option>
        <option  value="XPF">CFP Franc (CFPF)</option>
        <option  value="YER">Yemeni Rial (YER)</option>
        <option  value="ZAR">South African Rand (ZAR)</option>
        <option  value="ZMK">Zambian Kwacha (1968–2012) (ZMK)</option>
        <option  value="ZMW">Zambian Kwacha (ZMW)</option>
        <option  value="ZWL">Zimbabwean Dollar (2009) (ZWL)</option>
            </select>

            <br>

            <label>Select currency (to):</label>
            <select class="form-control" id="select" name="currency_to">
        <option  value="AED">United Arab Emirates Dirham (AED)</option>
        <option  value="AFN">Afghan Afghani (AFN)</option>
        <option  value="ALL">Albanian Lek (ALL)</option>
        <option  value="AMD">Armenian Dram (AMD)</option>
        <option  value="ANG">Netherlands Antillean Guilder (ANG)</option>
        <option  value="AOA">Angolan Kwanza (AOA)</option>
        <option  value="ARS">Argentine Peso (ARS)</option>
        <option  value="AUD">Australian Dollar (A$)</option>
        <option  value="AWG">Aruban Florin (AWG)</option>
        <option  value="AZN">Azerbaijani Manat (AZN)</option>
        <option  value="BAM">Bosnia-Herzegovina Convertible Mark (BAM)</option>
        <option  value="BBD">Barbadian Dollar (BBD)</option>
        <option  value="BDT">Bangladeshi Taka (BDT)</option>
        <option  value="BGN">Bulgarian Lev (BGN)</option>
        <option  value="BHD">Bahraini Dinar (BHD)</option>
        <option  value="BIF">Burundian Franc (BIF)</option>
        <option  value="BMD">Bermudan Dollar (BMD)</option>
        <option  value="BND">Brunei Dollar (BND)</option>
        <option  value="BOB">Bolivian Boliviano (BOB)</option>
        <option  value="BRL">Brazilian Real (R$)</option>
        <option  value="BSD">Bahamian Dollar (BSD)</option>
        <option  value="BTC">Bitcoin (฿)</option>
        <option  value="BTN">Bhutanese Ngultrum (BTN)</option>
        <option  value="BWP">Botswanan Pula (BWP)</option>
        <option  value="BYR">Belarusian Ruble (BYR)</option>
        <option  value="BZD">Belize Dollar (BZD)</option>
        <option  value="CAD">Canadian Dollar (CA$)</option>
        <option  value="CDF">Congolese Franc (CDF)</option>
        <option  value="CHF">Swiss Franc (CHF)</option>
        <option  value="CLF">Chilean Unit of Account (UF) (CLF)</option>
        <option  value="CLP">Chilean Peso (CLP)</option>
        <option  value="CNH">CNH (CNH)</option>
        <option  value="CNY">Chinese Yuan (CN¥)</option>
        <option  value="COP">Colombian Peso (COP)</option>
        <option  value="CRC">Costa Rican Colón (CRC)</option>
        <option  value="CUP">Cuban Peso (CUP)</option>
        <option  value="CVE">Cape Verdean Escudo (CVE)</option>
        <option  value="CZK">Czech Republic Koruna (CZK)</option>
        <option  value="DEM">German Mark (DEM)</option>
        <option  value="DJF">Djiboutian Franc (DJF)</option>
        <option  value="DKK">Danish Krone (DKK)</option>
        <option  value="DOP">Dominican Peso (DOP)</option>
        <option  value="DZD">Algerian Dinar (DZD)</option>
        <option  value="EGP">Egyptian Pound (EGP)</option>
        <option  value="ERN">Eritrean Nakfa (ERN)</option>
        <option  value="ETB">Ethiopian Birr (ETB)</option>
        <option  value="EUR">Euro (€)</option>
        <option  value="FIM">Finnish Markka (FIM)</option>
        <option  value="FJD">Fijian Dollar (FJD)</option>
        <option  value="FKP">Falkland Islands Pound (FKP)</option>
        <option  value="FRF">French Franc (FRF)</option>
        <option  value="GBP">British Pound (£)</option>
        <option  value="GEL">Georgian Lari (GEL)</option>
        <option  value="GHS">Ghanaian Cedi (GHS)</option>
        <option  value="GIP">Gibraltar Pound (GIP)</option>
        <option  value="GMD">Gambian Dalasi (GMD)</option>
        <option  value="GNF">Guinean Franc (GNF)</option>
        <option  value="GTQ">Guatemalan Quetzal (GTQ)</option>
        <option  value="GYD">Guyanaese Dollar (GYD)</option>
        <option  value="HKD">Hong Kong Dollar (HK$)</option>
        <option  value="HNL">Honduran Lempira (HNL)</option>
        <option  value="HRK">Croatian Kuna (HRK)</option>
        <option  value="HTG">Haitian Gourde (HTG)</option>
        <option  value="HUF">Hungarian Forint (HUF)</option>
        <option  value="IDR">Indonesian Rupiah (IDR)</option>
        <option  value="IEP">Irish Pound (IEP)</option>
        <option  value="ILS">Israeli New Sheqel (₪)</option>
        <option  value="INR">Indian Rupee (Rs.)</option>
        <option  value="IQD">Iraqi Dinar (IQD)</option>
        <option  value="IRR">Iranian Rial (IRR)</option>
        <option  value="ISK">Icelandic Króna (ISK)</option>
        <option  value="ITL">Italian Lira (ITL)</option>
        <option  value="JMD">Jamaican Dollar (JMD)</option>
        <option  value="JOD">Jordanian Dinar (JOD)</option>
        <option  value="JPY">Japanese Yen (¥)</option>
        <option  value="KES">Kenyan Shilling (KES)</option>
        <option  value="KGS">Kyrgystani Som (KGS)</option>
        <option  value="KHR">Cambodian Riel (KHR)</option>
        <option  value="KMF">Comorian Franc (KMF)</option>
        <option  value="KPW">North Korean Won (KPW)</option>
        <option  value="KRW">South Korean Won (₩)</option>
        <option  value="KWD">Kuwaiti Dinar (KWD)</option>
        <option  value="KYD">Cayman Islands Dollar (KYD)</option>
        <option  value="KZT">Kazakhstani Tenge (KZT)</option>
        <option  value="LAK">Laotian Kip (LAK)</option>
        <option  value="LBP">Lebanese Pound (LBP)</option>
        <option  value="LKR">Sri Lankan Rupee (LKR)</option>
        <option  value="LRD">Liberian Dollar (LRD)</option>
        <option  value="LSL">Lesotho Loti (LSL)</option>
        <option  value="LTL">Lithuanian Litas (LTL)</option>
        <option  value="LVL">Latvian Lats (LVL)</option>
        <option  value="LYD">Libyan Dinar (LYD)</option>
        <option  value="MAD">Moroccan Dirham (MAD)</option>
        <option  value="MDL">Moldovan Leu (MDL)</option>
        <option  value="MGA">Malagasy Ariary (MGA)</option>
        <option  value="MKD">Macedonian Denar (MKD)</option>
        <option  value="MMK">Myanmar Kyat (MMK)</option>
        <option  value="MNT">Mongolian Tugrik (MNT)</option>
        <option  value="MOP">Macanese Pataca (MOP)</option>
        <option  value="MRO">Mauritanian Ouguiya (MRO)</option>
        <option  value="MUR">Mauritian Rupee (MUR)</option>
        <option  value="MVR">Maldivian Rufiyaa (MVR)</option>
        <option  value="MWK">Malawian Kwacha (MWK)</option>
        <option  value="MXN">Mexican Peso (MX$)</option>
        <option  value="MYR">Malaysian Ringgit (MYR)</option>
        <option  value="MZN">Mozambican Metical (MZN)</option>
        <option  value="NAD">Namibian Dollar (NAD)</option>
        <option  value="NGN">Nigerian Naira (NGN)</option>
        <option  value="NIO">Nicaraguan Córdoba (NIO)</option>
        <option  value="NOK">Norwegian Krone (NOK)</option>
        <option  value="NPR">Nepalese Rupee (NPR)</option>
        <option  value="NZD">New Zealand Dollar (NZ$)</option>
        <option  value="OMR">Omani Rial (OMR)</option>
        <option  value="PAB">Panamanian Balboa (PAB)</option>
        <option  value="PEN">Peruvian Nuevo Sol (PEN)</option>
        <option  value="PGK">Papua New Guinean Kina (PGK)</option>
        <option  value="PHP">Philippine Peso (Php)</option>
        <option  value="PKG">PKG (PKG)</option>
        <option  value="PKR">Pakistani Rupee (PKR)</option>
        <option  value="PLN">Polish Zloty (PLN)</option>
        <option  value="PYG">Paraguayan Guarani (PYG)</option>
        <option  value="QAR">Qatari Rial (QAR)</option>
        <option  value="RON">Romanian Leu (RON)</option>
        <option  value="RSD">Serbian Dinar (RSD)</option>
        <option  value="RUB">Russian Ruble (RUB)</option>
        <option  value="RWF">Rwandan Franc (RWF)</option>
        <option  value="SAR">Saudi Riyal (SAR)</option>
        <option  value="SBD">Solomon Islands Dollar (SBD)</option>
        <option  value="SCR">Seychellois Rupee (SCR)</option>
        <option  value="SDG">Sudanese Pound (SDG)</option>
        <option  value="SEK">Swedish Krona (SEK)</option>
        <option  value="SGD">Singapore Dollar (SGD)</option>
        <option  value="SHP">St. Helena Pound (SHP)</option>
        <option  value="SKK">Slovak Koruna (SKK)</option>
        <option  value="SLL">Sierra Leonean Leone (SLL)</option>
        <option  value="SOS">Somali Shilling (SOS)</option>
        <option  value="SRD">Surinamese Dollar (SRD)</option>
        <option  value="STD">São Tomé &amp; Príncipe Dobra (STD)</option>
        <option  value="SVC">Salvadoran Colón (SVC)</option>
        <option  value="SYP">Syrian Pound (SYP)</option>
        <option  value="SZL">Swazi Lilangeni (SZL)</option>
        <option  value="THB">Thai Baht (THB)</option>
        <option  value="TJS">Tajikistani Somoni (TJS)</option>
        <option  value="TMT">Turkmenistani Manat (TMT)</option>
        <option  value="TND">Tunisian Dinar (TND)</option>
        <option  value="TOP">Tongan Paʻanga (TOP)</option>
        <option  value="TRY">Turkish Lira (TRY)</option>
        <option  value="TTD">Trinidad &amp; Tobago Dollar (TTD)</option>
        <option  value="TWD">New Taiwan Dollar (NT$)</option>
        <option  value="TZS">Tanzanian Shilling (TZS)</option>
        <option  value="UAH">Ukrainian Hryvnia (UAH)</option>
        <option  value="UGX">Ugandan Shilling (UGX)</option>
        <option  value="USD">US Dollar ($)</option>
        <option  value="UYU">Uruguayan Peso (UYU)</option>
        <option  value="UZS">Uzbekistani Som (UZS)</option>
        <option  value="VEF">Venezuelan Bolívar (VEF)</option>
        <option  value="VND">Vietnamese Dong (₫)</option>
        <option  value="VUV">Vanuatu Vatu (VUV)</option>
        <option  value="WST">Samoan Tala (WST)</option>
        <option  value="XAF">Central African CFA Franc (FCFA)</option>
        <option  value="XCD">East Caribbean Dollar (EC$)</option>
        <option  value="XDR">Special Drawing Rights (XDR)</option>
        <option  value="XOF">West African CFA Franc (CFA)</option>
        <option  value="XPF">CFP Franc (CFPF)</option>
        <option  value="YER">Yemeni Rial (YER)</option>
        <option  value="ZAR">South African Rand (ZAR)</option>
        <option  value="ZMK">Zambian Kwacha (1968–2012) (ZMK)</option>
        <option  value="ZMW">Zambian Kwacha (ZMW)</option>
        <option  value="ZWL">Zimbabwean Dollar (2009) (ZWL)</option>
            </select>
              <hr>
            <h3>Converted Amount: $currency</h3>
        </form>
        </div>
            </div>
        </div>
    </section>
        </div>
      
        <!-- /.row -->
    <!-- /.container -->

    <!-- jQuery Version 1.11.1 -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
_END;
?>