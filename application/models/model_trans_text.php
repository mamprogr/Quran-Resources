<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_trans_text extends CI_Model {
    
    /** Const **/
    private $TransType      = 'trans_ar_muyassar';
    private $TransTypes     = array(
                                'trans_ar_jalalayn',
                                'trans_ar_muyassar'
                                    );
    /** /Const **/
    
    function __construct(){
        parent::__construct();
        $this->load->model('Model_quran_text','quran') ;
    }
    
    function set_TransType($Type){
        
        switch ($Type) {
            case 'ar.jalalayn'  : $Type = 'trans_ar_jalalayn'; break;
            case 'ar.muyassar'  : $Type = 'trans_ar_muyassar'; break;
            default             : $Type = 'trans_ar_muyassar'; break;
        }
        
        if(in_array($Type, $this->TransTypes)){
            $this->TransType = $Type;
            return 1;
        }
        return 0;
    }
    
    function get_AyaByIndex($Index){
        
        $this->db->where('index',$Index);
        $q = $this->db->get($this->TransType);
        $row = $q->row();
        if($q->num_rows() > 0){
            
            $Aya['index'] = $row->index;
            $Aya['sura']  = $row->sura ;
            $Aya['aya']   = $row->aya  ;
            $Aya['text']  = $row->text ;
            
            return $Aya;
        }
        return;
    }
    
    function get_AyaBySuraAya($Sura,$Aya){
        
        $Index = $this->quran->SuraAya2Index($Sura, $Aya);
        
        return $this->get_AyaByIndex($Index);
        
    }
    
    function get_AyasByIndex($From_Index,$To_Index){
        
        for ($Index=$From_Index; $Index <= $To_Index; $Index++) { 
            if ($Aya = $this->get_AyaByIndex($Index)) {
                $Ayas[] = $Aya;
            }else return;
        }
        
        return $Ayas;
    }
    
    function get_AyasBySuraAya($From_Sura,$From_Aya,$To_Sura,$To_Aya){
        
        $From_Index = $this->quran->SuraAya2Index($From_Sura, $From_Aya);
        $To_Index   = $this->quran->SuraAya2Index($To_Sura, $To_Aya)    ;
        
        return $this->get_AyasByIndex($From_Index, $To_Index);
    }
    
    function get_Sura($SuraIndex){
        
        $SuraInfo = $this->quran->get_SuraInfo($SuraIndex);
        $From_Aya = 1;
        $To_Aya   = $SuraInfo['ayas'];
        for ($Index=$From_Aya; $Index <= $To_Aya; $Index++) { 
            if ($Aya = $this->get_AyaBySuraAya($SuraIndex,$Index)) {
                $Sura[] = $Aya;
            }else return;
        }
        
        return $Sura;
    }
    
    function get_Suras($From_Sura,$To_Sura){
        
        for ($Sura=$From_Sura; $Sura <= $To_Sura; $Sura++) { 
            $Suras[] = $this->get_Sura($Sura);
        }
        
        return $Suras;
    }
    
}
/* End of file model_trans_text.php */
/* Location: ./application/models/model_trans_text.php */