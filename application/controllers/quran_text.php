<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Quran_text extends CI_Controller {
    
    private $SuraAya_Delimiter  = '-';
    private $SuraAya_SID        = 5; //$SuraAya_SegmentID;
    private $Sura_SID           = 5; //$SuraAya_SegmentID;
    private $Quran_SID          = 4; //$Trans_SegmentID;
    private $ViewType_SID       = 3; //$ViewType_SegmentID;
    private $ViewType           = 'html';
    
    function __construct(){
        parent::__construct();
        $this->load->model('Model_quran_text','data') ;
        $this->data->set_Basmalah(FALSE);
        
        if($this->uri->segment($this->ViewType_SID) !== FALSE)
            if (in_array($this->uri->segment($this->ViewType_SID), array('html','json','serialize','xml','text')))
                $this->ViewType = $this->uri->segment($this->ViewType_SID);
        else return;
    }
    
    public function index()
    {
        //$this->load->view('welcome_message');
    }
    
    function Ayas(){
        
        if($this->uri->segment($this->SuraAya_SID+1) !== FALSE){ // Range of ayas
            return $this->_get_Ayas();
        }elseif($this->uri->segment($this->SuraAya_SID) !== FALSE){ // Just one aya
            return $this->_get_Aya();
        }else return;
    }
    
    function Suras(){
        
        if($this->uri->segment($this->Sura_SID+1) !== FALSE){ // Range of ayas
            return $this->_get_Suras();
        }elseif($this->uri->segment($this->Sura_SID) !== FALSE){ // Just one aya
            return $this->_get_Sura();
        }else return;
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
    
    private function _get_Aya(){
        
        if($this->uri->segment($this->Quran_SID) !== FALSE)
            $this->data->set_QuranType($this->uri->segment($this->Quran_SID));
        else return;
        
        if($this->uri->segment($this->SuraAya_SID) !== FALSE)
            $Index = $this->_Segment2AyaIndex($this->SuraAya_SID);
        else return;
        
        if($this->data->Is_AyaByIndex($Index))
            $Aya = $this->data->get_AyaByIndex($Index);
        else return;
        
        $Ayas[] = $Aya;
        
        $data['Ayas'] = $Ayas;
        $this->load->view('quran_text/'.$this->ViewType.'/ayas',$data);
    }
    
    private function _get_Ayas(){
        
        if($this->uri->segment($this->Quran_SID) !== FALSE)
            $this->data->set_QuranType($this->uri->segment($this->Quran_SID));
        else return;
                
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
        
        $this->load->view('quran_text/'.$this->ViewType.'/ayas',$data);
        
    }
    
    private function _get_Sura(){
        
        if($this->uri->segment($this->Quran_SID) !== FALSE)
            $this->data->set_QuranType($this->uri->segment($this->Quran_SID));
        else return;
        
        if($this->uri->segment($this->Sura_SID) !== FALSE)
            $Index = $this->uri->segment($this->Sura_SID);
        else return;
        
        if($this->data->Is_Sura($Index))
            $Sura = $this->data->get_Sura($Index);
        else return;
        
        $Suras[] = $Sura;
        $SurasInfo[] = $this->data->get_SuraInfo($Index);
        
        $data['Suras']     = $Suras;
        $data['SurasInfo'] = $SurasInfo;
        
        $this->load->view('quran_text/'.$this->ViewType.'/suras',$data);
    }
    
    private function _get_Suras(){
        
        if($this->uri->segment($this->Quran_SID) !== FALSE)
            $this->data->set_QuranType($this->uri->segment($this->Quran_SID));
        else return;
        
        if($this->uri->segment($this->Sura_SID) !== FALSE || $this->uri->segment($this->Sura_SID+1) !== FALSE){
            $From_Sura = $this->uri->segment($this->Sura_SID);
            $To_Sura   = $this->uri->segment($this->Sura_SID+1);
        }else return;
        
        if($this->data->Is_Sura($From_Sura) && $this->data->Is_Sura($To_Sura))
            $Suras = $this->data->get_Suras($From_Sura,$To_Sura);
        else return;
        
        $data['Suras']     = $Suras;
        $data['SurasInfo'] = $this->data->get_SurasInfo($From_Sura,$To_Sura);
        
        $this->load->view('quran_text/'.$this->ViewType.'/suras',$data);
    }
    
}
/* End of file quran_text.php */
/* Location: ./application/controllers/quran_text.php */