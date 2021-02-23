<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
include_once APPPATH.'/third_party/MPDF60/mpdf.php';
 
class M_pdf {
 
    public $param;
    public $pdf;
//mPDF($mode='',$format='A4',$default_font_size=0,$default_font='',$mgl=15,$mgr=15,$mgt=16,$mgb=16,$mgh=9,$mgf=9, $orientation='P') {
    public function __construct($param = '"en-GB-x","A3","","",1,1,1,1,6,3,L')
    {
        $this->param =$param;
        $this->pdf = new mPDF($this->param);
    }
}
 
