<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
include_once APPPATH.'third_party/amcharts-php-master/lib/AmSerialChart.php';
 
class Amchart_master {
 
     
    public $chart;
//mPDF($mode='',$format='A4',$default_font_size=0,$default_font='',$mgl=15,$mgr=15,$mgt=16,$mgb=16,$mgh=9,$mgf=9, $orientation='P') {
    public function __construct()
    {
       
        $this->chart = new AmSerialChart("myLineChart");
		$this->chart->setLibraryPath(base_url()."assets/site/js/amcharts");
		// Use a chart cursor (optional)
		$this->chart->setConfig("chartCursor", array("cursorPointer" => "mouse"));
    }
}
 
