<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Quran_text extends CI_Controller {
    
    private $SuraAya_Delimiter = '-';
    
    function __construct(){
        parent::__construct();
        $this->load->model('model_quran_text','data');
        $this->data->set_QuranType('quran_simple_min');
        //$this->data->Aya_Style = '<div class=aya>$1</div>';
        $this->data->Aya_Style = ' $1 ';
        $this->data->Ayas_Glue = '';
        $this->data->Sura_Style = '<div class=aya>$1</div>';
        $this->data->Suras_Glue = '<br />';
        $this->data->AyaNum_Style = '<span class=ayaNum> ﴿$1﴾ </span>';
        $this->data->WaqfMark_Style = '<span class="sign">&nbsp;$1</span>';
    }
    
    public function index()
    {
        $this->Aya(1);
        //echo $this->quran_data->get_Aya(2);
        //echo $this->data->get_Aya(1,1);
        //echo $this->quran_data->get_Aya(2,1,1);

        //echo $this->quran_data->get_SuraInfo(2,'rukus');
                
        //$SuraAya = $this->quran_data->get_JuzInfo(70,5);
        //$SuraAya = $this->quran_data->get_HizbInfo(70,5);
        /*
            $SuraAya = $this->quran_data->get_PageInfo(70,5);
            var_dump($SuraAya);
        */
        //var_dump($this->quran_data->Is_Sajda(17,109));
        //$this->data->set_QuranType('quran_simple_min');
        //$this->data->ShowBasmalah = FALSE;
        //echo $this->data->get_Sura(2);
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
    
    function Aya($Index){
        $text = NULL;
        
        $this->data->Aya_Style = '<div class=aya>$1</div>';
        
        if($this->uri->segment(3) !== FALSE)
            $Index = $this->_Segment2AyaIndex(3);
        elseif(!isset($Index))return;
        
        
        if($this->data->Is_AyaIndex($Index))
            $text = $this->data->get_Aya($Index);
        
        /** Old Way ..
        $Aya = $Sura = $text = NULL;
        if($this->uri->segment(3) !== FALSE){
            if($this->data->Is_AyaIndex($this->uri->segment(3)))
                $SuraAya = $this->data->Index2SuraAya($this->uri->segment(3));
            else
                $SuraAya = explode($this->SuraAya_Delimiter, $this->uri->segment(3));

            if(count($SuraAya) == 2){
                $Sura = $SuraAya[0];
                $Aya  = $SuraAya[1];
            } // else = NULL; ^_^
        }
        if ($this->data->Is_Sura($Sura) && $this->data->Is_Aya($Sura,$Aya))
            $text = $this->data->get_Aya($Sura,$Aya);
        **/
        
        // else = NULL; ^_^
        $data['data'] = $text;
        $this->load->view('output',$data);
    }
    
    function Ayas(){
        $text = NULL;
        
        $this->data->Aya_Style = '<div class=aya>$1</div>';
        
        if($this->uri->segment(3) === FALSE || $this->uri->segment(4) === FALSE) return;
        
        $From = $this->_Segment2AyaIndex(3);
        $To   = $this->_Segment2AyaIndex(4);
        
        //$From > $To ? $From ^= $To ^= $From ^= $To:1; //By MAMProgr (:^_^:);
        $From > $To ? list($From, $To) = array($To, $From):1; // Swap ^_^;
        
        if($this->data->Is_AyaIndex($To) && $this->data->Is_AyaIndex($To))
            $text = $this->data->get_Ayas($From,$To);
        // else = NULL; ^_^
        
        $data['data'] = $text;
        $this->load->view('output',$data);
    }
    
    function Sura(){
        $Sura = $text = NULL;
        
        if($this->uri->segment(3) !== FALSE){
            $Sura = $this->uri->segment(3);
            if ($this->data->Is_Sura($Sura))
                $text = $this->data->get_Sura($Sura);
        }
        // else = NULL; ^_^
        
        $data['data'] = $text;
        $this->load->view('output',$data);
    }
    
    function Suras(){
        $Sura = $text = NULL;
        
        if($this->uri->segment(3) !== FALSE && $this->uri->segment(4) !== FALSE){
            $From = $this->uri->segment(3);
            $To = $this->uri->segment(4);
            
            if ($this->data->Is_Sura($From) && $this->data->Is_Sura($To))
                $text = $this->data->get_Suras($From,$To);
        }
        // else = NULL; ^_^
        
        $data['data'] = $text;
        $this->load->view('output',$data);
    }
}

/* End of file quran_text.php */
/* Location: ./application/controllers/quran_text.php */