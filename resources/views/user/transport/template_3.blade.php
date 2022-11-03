<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>pdf-html</title>
<meta name="generator" content="BCL easyConverter SDK 5.0.252">
<STYLE type="text/css">

@page { margin-left: 0px; margin-top:0px; margin-bottom:0px; margin-right: 0px; }

body { margin: 0px; font-size:14px; }

body {margin-top: 0px;margin-left: 0px;}

table, th, td {
  border: 0px solid black;
  border-collapse: collapse;
}

@page { margin-top: 0px; margin-bottom: 0px; }

</STYLE>
</head>

<body>

<div style="border:0px solid black; border-bottom:0px; ">
    <table>
        <tr>
            <td>
                <div style="height: 80px; border-bottom:0px solid black; text-align:center; ">
                    <br>TRANSPORT KOMBINOWANY SAMOCHÓD - KOLEJ <br>  <br>
                    COMBINED TRANSPORT TRUCK - RAIL
                </div>
                <div style="border-bottom:0px solid black;  ">
                    <label style="font-size:12px;"><br></label>
                    <div style="text-align: center;  ">
                        <br>{{ isset($cmr->sender) ? $cmr->sender : '' }}
                    </div>
                </div>
                <div style=" border-bottom:0px solid black;   ">
                    <label style="font-size:12px;"><br></label>
                    <div style="text-align: center;  ">
                        <br>{{ isset($order->pickup_partner->company_name) ? $order->pickup_partner->company_name : '' }}
                    </div>                    
                </div>
                <div style=" border-bottom:0px solid black;  height: 150px;   ">
                    
                    <div style="width: 70%; float: left; height: 150px; border-right:0px solid black;"> 
                        <label style="font-size:12px;"><br></label>
                        <div style="text-align: center;  ">
                            <br>{{ isset($cmr->place_of_delivery_goods) ? $cmr->place_of_delivery_goods : '' }}
                        </div>                    
                    </div>
                    <div style="margin-left: 70%; height: 150px; "> 
                        <label style="font-size:12px;"><br></label>
                        <div style="text-align: center; border-bottom:0px solid black;  ">
                        </div>
                        <label style="font-size:12px;"><br></label>
                        <div style="text-align: center;  ">
                        </div>                        
                    </div>

                </div>
                <div style=" border-bottom:0px solid black;   ">
                    <label style="font-size:12px;"><br></label>
                </div>

                <div style=" border-bottom:0px solid black;  height: 150px;   ">
                    
                    <div style="width: 70%; float: left; height: 150px;  border-right:0px solid black;"> 
                        <label style="font-size:12px;"><br></label>
                        <div style="text-align: center;  ">
                            <br>Terminal Wrocław/Oleśnica <br>
                            Rail Polska sp z o.o. <br>
                            ul. Willowa 8/10  <br>
                            00-790 Warszawa
                        </div>                    
                    </div>
                    <div style="margin-left: 70%; height: 150px; "> 
                        <label style="font-size:12px;"><br></label>
                        <div style="text-align: center;  ">
                        </div>                      
                    </div>

                </div>

                <div style=" border-bottom:0px solid black;   ">
                    <label style="font-size:12px;"><br></label>
                </div>

                <div style=" border-bottom:0px solid black;  height: 150px;   ">
                    
                    <div style="width: 70%; float: left; height: 150px;  border-right:0px solid black;"> 
                        <label style="font-size:12px;">a) netto / NETT</label>
                        <div style="text-align: center;  ">
                            <br>Terminal Wrocław/Oleśnica <br>
                            Rail Polska sp z o.o. <br>
                            ul. Willowa 8/10  <br>
                            00-790 Warszawa
                        </div>                    
                    </div>
                    <div style="margin-left: 70%; height: 150px; "> 
                        <label style="font-size:12px;">b) brutto / GROSS</label>
                        <div style="text-align: center;  ">
                        </div>                      
                    </div>

                </div>

                <div style=" border-bottom:0px solid black;   ">
                    <label style="font-size:12px;"><br></label>
                </div>
                <div style=" border-bottom:0px solid black;   ">
                    <label style="font-size:12px;"><br></label>
                </div>
            </td>
            <td style="vertical-align: top;">
                <div style="height: 130px; border-bottom:0px solid black; text-align:center; "> <br>
                    Kontenerowy Dokument Przewozowy<br>
                    <img src="/partners/<?=$order->pickup_partner->logo?>" height="80"> <br>
                    CONTAINER CARRIER DOCUMENT
                </div>
                <div style="border-bottom:0px solid black;  ">
                    <label style="font-size:12px;"><br></label>
                    <div style="text-align: center;  ">
                        <br>BALTIC
                    </div>
                </div>
                <div style="border-bottom:0px solid black;  ">
                    <label style="font-size:12px;"><br></label>
                    <div style="text-align: center;  ">
                        <br>BALTIC
                    </div>
                </div>

                <div style=" border-bottom:0px solid black;  height: 150px;   ">
                    
                    <div style="width: 70%; float: left; height: 150px;  border-right:0px solid black;"> 
                        <label style="font-size:12px;"><br></label>
                        <div style="text-align: center;  ">
                            <br>{{ isset($order->carrier_partner->company_name) ? $order->carrier_partner->company_name : '' }}
                        </div>                    
                    </div>
                    <div style="margin-left: 70%; height: 150px; "> 
                        <label style="font-size:12px;">Podpis kierowcy / SIGNATURE</label>
                        <div style="text-align: center;  ">
                        </div>                      
                    </div>

                </div>

                <div style="border-bottom:0px solid black;  ">
                    <label style="font-size:12px;"><br></label>
                    <div style="text-align: center;  ">
                        <br>BALTIC
                    </div>
                </div>

                <div style=" border-bottom:0px solid black;  height: 150px;   ">
                    
                    <div style="width: 70%; float: left; height: 150px;  border-right:0px solid black;"> 
                        <label style="font-size:12px;"><br></label>
                        <div style="text-align: center;  ">
                            <br>Terminal Wrocław/Oleśnica <br>
                            Rail Polska sp z o.o. <br>
                            ul. Willowa 8/10  <br>
                            00-790 Warszawa
                        </div>                    
                    </div>
                    <div style="margin-left: 70%; height: 150px; "> 
                        <label style="font-size:12px;">Podpis kierowcy / SIGNATURE</label>
                        <div style="text-align: center;  ">
                        </div>                      
                    </div>

                </div>

                <div style="border-bottom:0px solid black;  ">
                    <div style="text-align: center;  ">
                        <table style="border: 0px solid black; border-collapse: collapse;font-size:12px; width:100%">
                            <tr>
                                <td><br></td>
                                <td>przyjazdu / START</td>
                                <td>Podpis / SIGNATURE</td>
                            </tr>
                            <tr>
                                <td rowspan="4">a) załadunek/ wyładunek <br>LOADING/ UNLOADING</td>
                                <td>przyjazdu / START</td>
                                <td>przyjazdu / START</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr> 
                            <tr>
                                <td>przyjazdu / START</td>
                                <td>przyjazdu / START</td>
                            </tr>   
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>                            
                            <tr>
                                <td rowspan="4">b) cło / CUSTOMS</td>
                                <td>przyjazdu / START</td>
                                <td>przyjazdu / START</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr> 
                            <tr>
                                <td>przyjazdu / START</td>
                                <td>przyjazdu / START</td>
                            </tr>   
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>                             
                        </table>
                    </div>
                </div>

                <div style="border-bottom:0px solid black;  ">
                    <label style="font-size:12px;"><br></label>
                    <div style="text-align: center;  ">
                        <br>BALTIC
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="border-bottom: 0px solid black;">
                <table style="width:100%; font-size:12px; border:0px;">
                    <tr>
                        <td style="height: 150px; vertical-align:top;">
                            <br><br>
                            STAMP AND SIGNATURE TERMINAL OUT
                        </td>
                        <td style="height: 150px; vertical-align:top;"><br>STAMP AND SIGNATURE SHIPPER / CONSIGNEEa</td>
                        <td style="height: 150px; vertical-align:top;"><br>STAMP AND SIGNATURE TERMINAL IN</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="font-size: 12px; padding:3px; border-bottom: 0px solid black;">
                Prosimy o przypilnowanie dokładnego zamknięcia rygli drzwi kontenera po załadunku / Close the door and lock properly after loading Otwieranie, czyszczenie i zamykanie kontenera należy do obowiązków załadowcy / odbiorcy/ Opening, cleaning and closing the container is the Shipper's / Consignee duty Wyczekiwanie przed lub po rozładunku / załadunku wymaga potwierdzenia przez odbiorce / załadowce towaru / Waiting time must be signed by the Sihipper's / Consignee representive W przypadku wypadku, włamania, próby włamania, napadu, usiłowania napadu itp. Bezzwłocznie poinformuj Rail Polska Sp z o.o. /All problems should be reported to Rail Polska Sp z o.o.<br>
                Mod: 2.2022
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <table style="width:100%; font-size:12px; border:0px;">
                    <tr>
                        <td style="vertical-align:top;">
                            Rail Polska sp z o.o.
                        </td>
                        <td style="vertical-align:top;"></td>
                        <td style="vertical-align:top;">NIP: 521-30-39-201</td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top;">
                            ul. Willowa 8/10 lok.11
                        </td>
                        <td style="vertical-align:top;">00-790 Warszawa</td>
                        <td style="vertical-align:top;">www.railpolska.pl</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>