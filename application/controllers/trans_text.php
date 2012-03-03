<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Trans_text extends CI_Controller {
    
    private $SuraAya_Delimiter = '-';
    
    function __construct(){
        parent::__construct();
        $this->load->model('model_quran_text','quran');
        $this->load->model('model_trans_text','trans');
        $this->trans->Ayas_Glue = '<br />';
        $this->trans->Sura_Style = '<div class=aya>$1</div>';
        $this->trans->Suras_Glue = '<br />';
        $this->trans->AyaNum_Style = '<span class=ayaNum> ( $1 ) </span>';
    }
    
    public function index(){
        
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

    private function _set_TransType($Type){
        switch ($Type) {
            case 'ar.jalalayn'  : $Type = 'trans_ar_jalalayn'; break;
            case 'ar.muyassar'  : $Type = 'trans_ar_muyassar'; break;
            default             : $Type = 'trans_ar_muyassar'; break;
        }
        
        $this->trans->set_TransType($Type);
    }
    
    function Aya(){
        $text = NULL;
        
        if($this->uri->segment(3) === FALSE) return;
        $this->_set_TransType($this->uri->segment(3));
        
        if($this->uri->segment(4) === FALSE) return;
        
        $Index = $this->_Segment2AyaIndex(4);
        
        if($this->quran->Is_AyaIndex($Index))
            $text = $this->trans->get_Aya($Index);
        
        // else = NULL; ^_^
        $data['data'] = $text;
        $this->load->view('output',$data);
    }
    
    function Ayas(){
        $text = NULL;
        
        if($this->uri->segment(3) === FALSE) return;
        $this->_set_TransType($this->uri->segment(3));
        
        if($this->uri->segment(4) === FALSE || $this->uri->segment(5) === FALSE) return;
        
        $From = $this->_Segment2AyaIndex(4);
        $To   = $this->_Segment2AyaIndex(5);
        
        $From > $To ? list($From, $To) = array($To, $From):1; // Swap ^_^;
        
        if($this->quran->Is_AyaIndex($To) && $this->quran->Is_AyaIndex($To))
            $text = $this->trans->get_Ayas($From,$To);
        // else = NULL; ^_^
        
        $data['data'] = $text;
        $this->load->view('output',$data);
    }
    
    function Sura(){
        $Sura = $text = NULL;
        
        if($this->uri->segment(3) === FALSE) return;
        $this->_set_TransType($this->uri->segment(3));
        
        if($this->uri->segment(4) !== FALSE){
            $Sura = $this->uri->segment(4);
            if ($this->quran->Is_Sura($Sura))
                $text = $this->trans->get_Sura($Sura);
        }
        // else = NULL; ^_^
        
        $data['data'] = $text;
        $this->load->view('output',$data);
    }
    
    function Suras(){
        $Sura = $text = NULL;
        
        if($this->uri->segment(3) === FALSE) return;
        $this->_set_TransType($this->uri->segment(3));
        
        if($this->uri->segment(4) !== FALSE && $this->uri->segment(5) !== FALSE){
            $From = $this->uri->segment(4);
            $To = $this->uri->segment(5);
            
            if ($this->quran->Is_Sura($From) && $this->quran->Is_Sura($To))
                $text = $this->trans->get_Suras($From,$To);
        }
        // else = NULL; ^_^
        
        $data['data'] = $text;
        $this->load->view('output',$data);
    }
}

/* End of file trans_text.php */
/* Location: ./application/controllers/trans_text.php */