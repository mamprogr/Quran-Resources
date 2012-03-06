<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Quran_text extends CI_Controller {
    
    private $SuraAya_Delimiter = '-';
    private $SuraAya_SID = 3; //$SuraAya_SegmentID;
    private $Sura_SID = 3; //$SuraAya_SegmentID;
    
    function __construct(){
        parent::__construct();
        $this->load->model('Model_quran_text','data')  ;
        $this->data->set_QuranType('quran_simple_min');
        $this->data->set_Basmalah(FALSE);
    }
    
    public function index()
    {
        //$this->load->view('welcome_message');
    }

    private function _Segment2AyaIndex($SegmentID){
        $Index = NULL;
        $SuraAya = explode($this->SuraAya_Delimiter, $this->uri->segment($SegmentID));            
        switch (count($SuraAya)) {
            case 1 : $Index = $this->uri->segment($SegmentID); break;
            case 2 : $Index = $this->data->SuraAya2Index($SuraAya[0],$SuraAya[1]); break;
        }
        return $Index;
    }
    
    function Aya(){
        
        if($this->uri->segment($this->SuraAya_SID) !== FALSE)
            $Index = $this->_Segment2AyaIndex($this->SuraAya_SID);
        else return;
        
        if($this->data->Is_AyaByIndex($Index))
            $Aya = $this->data->get_AyaByIndex($Index);
        else return;
        
        $data['Aya'] = $Aya;
        
        $this->load->view('aya',$data);
    }
    
    function Ayas(){
        
        if($this->uri->segment($this->SuraAya_SID) !== FALSE || $this->uri->segment($this->SuraAya_SID+1) !== FALSE){
            $From_Index = $this->_Segment2AyaIndex($this->SuraAya_SID);
            $To_Index   = $this->_Segment2AyaIndex($this->SuraAya_SID+1);
        }else return;
        
//        $From > $To ? $From ^= $To ^= $From ^= $To:1; //By MAMProgr (:^_^:);
        $From_Index > $To_Index ? list($From_Index, $To_Index) = array($To_Index, $From_Index):1; // Swap ^_^;
        
        if($this->data->Is_AyaByIndex($From_Index) && $this->data->Is_AyaByIndex($To_Index))
            $Ayas = $this->data->get_AyasByIndex($From_Index,$To_Index);
        else return;
        
        $data['Ayas'] = $Ayas;
        
        $this->load->view('ayas',$data);
        
    }
    
    function Sura(){
        
        if($this->uri->segment($this->Sura_SID) !== FALSE)
            $Index = $this->uri->segment($this->Sura_SID);
        else return;
        
        if($this->data->Is_Sura($Index))
            $Sura = $this->data->get_Sura($Index);
        else return;
        
        $data['Sura']     = $Sura;
        $data['SuraInfo'] = $this->data->get_SuraInfo($Index);
        
        $this->load->view('sura',$data);
    }
    
    function Suras(){
        
        if($this->uri->segment($this->Sura_SID) !== FALSE || $this->uri->segment($this->Sura_SID+1) !== FALSE){
            $From_Sura = $this->uri->segment($this->Sura_SID);
            $To_Sura   = $this->uri->segment($this->Sura_SID+1);
        }else return;
        
        if($this->data->Is_Sura($From_Sura) && $this->data->Is_Sura($To_Sura))
            $Suras = $this->data->get_Suras($From_Sura,$To_Sura);
        else return;
        
        $data['Suras']     = $Suras;
        $data['SurasInfo'] = $this->data->get_SurasInfo($From_Sura,$To_Sura);
        
        $this->load->view('suras',$data);
    }

/* End of file quran_text.php */
/* Location: ./application/controllers/quran_text.php */