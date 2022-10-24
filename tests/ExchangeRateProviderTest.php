<?php

namespace tests;

use ExchangeRateProvider;
use HttpRequestAbstract;
use PHPUnit\Framework\TestCase;
use RatesProvider;

class ExchangeRateProviderTest extends TestCase
{
    public RatesProvider $ratesProvider;

    protected function setUp(): void
    {
        $this->httpRequest = $this->createMock(HttpRequestAbstract::class);
        $this->httpRequest->url = 'https://api.exchangerate.host/latest';
        $this->ratesProvider = new ExchangeRateProvider($this->httpRequest);
    }

    /**
     * @return float|int|null
     */
    public function testRatesValueSuccess(): float|int|null
    {
        $currency = "EUR";
        $binData = '{"motd":{"msg":"If you or your company use this project or like what we doing, please consider backing us so we can continue maintaining and evolving this project.","url":"https://exchangerate.host/#/donate"},"success":true,"base":"EUR","date":"2022-10-24","rates":{"AED":3.614239,"AFN":84.996657,"ALL":117.098779,"AMD":393.077612,"ANG":1.756661,"AOA":445.388399,"ARS":149.588864,"AUD":1.552689,"AWG":1.771879,"AZN":1.672852,"BAM":1.954371,"BBD":1.969052,"BDT":98.748941,"BGN":1.95139,"BHD":0.368802,"BIF":2014.430479,"BMD":0.983857,"BND":1.392862,"BOB":6.732269,"BRL":5.082116,"BSD":0.984006,"BTC":0.000051,"BTN":80.582545,"BWP":13.168184,"BYN":2.472208,"BZD":1.964464,"CAD":1.348417,"CDF":2000.946042,"CHF":0.983401,"CLF":0.035756,"CLP":957.06174,"CNH":7.15219,"CNY":7.13531,"COP":4779.501591,"CRC":604.628144,"CUC":0.984102,"CUP":25.334955,"CVE":110.636725,"CZK":24.48023,"DJF":173.467791,"DKK":7.43635,"DOP":52.54413,"DZD":138.279937,"EGP":19.117439,"ERN":14.757939,"ETB":51.590669,"EUR":1,"FJD":2.286361,"FKP":0.868462,"GBP":0.868207,"GEL":2.716402,"GGP":0.868271,"GHS":13.275191,"GIP":0.867872,"GMD":56.425895,"GNF":8405.807974,"GTQ":7.637902,"GYD":203.801369,"HKD":7.723613,"HNL":24.085581,"HRK":7.53017,"HTG":124.234395,"HUF":409.48851,"IDR":15315.504317,"ILS":3.474076,"IMP":0.868163,"INR":81.347337,"IQD":1422.135152,"IRR":41666.972706,"ISK":142.062285,"JEP":0.867806,"JMD":149.091426,"JOD":0.698214,"JPY":146.543681,"KES":118.082949,"KGS":81.282071,"KHR":4032.010975,"KMF":492.379536,"KPW":885.485022,"KRW":1415.236233,"KWD":0.305264,"KYD":0.812611,"KZT":461.138813,"LAK":16864.097139,"LBP":1473.32812,"LKR":353.698163,"LRD":151.172049,"LSL":17.929626,"LYD":4.903886,"MAD":10.743929,"MDL":18.903676,"MGA":4159.305755,"MKD":61.571038,"MMK":2046.348578,"MNT":3314.647913,"MOP":7.877962,"MRU":36.998766,"MUR":43.606245,"MVR":15.126829,"MWK":1000.79848,"MXN":19.651438,"MYR":4.662676,"MZN":62.820706,"NAD":17.937185,"NGN":424.823385,"NIO":35.048718,"NOK":10.380949,"NPR":128.95786,"NZD":1.714775,"OMR":0.379717,"PAB":0.984359,"PEN":3.885285,"PGK":3.43425,"PHP":57.792689,"PKR":215.205924,"PLN":4.772691,"PYG":7040.720244,"QAR":3.548374,"RON":4.911233,"RSD":117.037062,"RUB":60.655753,"RWF":1039.063849,"SAR":3.699291,"SBD":8.042158,"SCR":13.346962,"SDG":560.807078,"SEK":11.064581,"SGD":1.395851,"SHP":0.868506,"SLL":16686.466459,"SOS":553.949751,"SRD":28.063821,"SSP":128.159923,"STD":22531.246436,"STN":24.89691,"SVC":8.52557,"SYP":2472.007754,"SZL":17.93096,"THB":37.39621,"TJS":9.912772,"TMT":3.453784,"TND":3.190968,"TOP":2.387205,"TRY":18.29202,"TTD":6.606564,"TWD":31.69882,"TZS":2272.272994,"UAH":35.986656,"UGX":3716.856719,"USD":0.984122,"UYU":40.55322,"UZS":10850.556338,"VES":8.262207,"VND":24456.197888,"VUV":122.466436,"WST":2.770569,"XAF":655.679059,"XAG":0.051112,"XAU":0.001874,"XCD":2.659126,"XDR":0.732068,"XOF":655.678815,"XPD":0.000841,"XPF":119.28177,"XPT":0.001405,"YER":246.214464,"ZAR":17.887365,"ZMW":15.577153,"ZWL":316.807142}}';
        $this->httpRequest
            ->expects($this->atLeast(2))
            ->method('setOption');
        $this->httpRequest
            ->expects($this->once())
            ->method('execute')
            ->willReturn($binData);
        $this->httpRequest
            ->expects($this->once())
            ->method('close');
        $result = $this->ratesProvider->getRatesValue($currency);
        $this->assertNotNull($result);
        $this->assertNotEmpty($result);
        return $result;
    }

    /**
     * @return void
     */
    public function testGetDataFails(): void
    {
        $currency = "EUR";
        $this->httpRequest
            ->expects($this->atLeast(2))
            ->method('setOption');
        $this->httpRequest
            ->expects($this->once())
            ->method('execute')
            ->willReturn(false);
        $this->httpRequest
            ->expects($this->once())
            ->method('close');
        $result = $this->ratesProvider->getRatesValue($currency);
        $this->assertNull($result);
    }
}
