<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_quran_text extends CI_Model {
    
    /** Const **/
    private $QuranType      = 'quran_uthmani_min';
    private $QuranTypes     = array(
                                'quran_simple',
                                'quran_simple_clean',
                                'quran_simple_enhanced',
                                'quran_simple_min',
                                'quran_uthmani',
                                'quran_uthmani_min'
                                    );
    public $ShowBasmalah    = FALSE;
    /** /Const **/
    
    function __construct(){
        parent::__construct();        
    }
    
    function set_QuranType($Type){
        
        if(in_array($Type, $this->QuranTypes)){
            $this->QuranType = $Type;
            return 1;
        }
        return 0;
    }
    
    function set_Basmalah($ShowBasmalah){
        
        if($ShowBasmalah)
            $this->ShowBasmalah = TRUE;
        else
            $this->ShowBasmalah = FALSE;
        
    }
    
    function get_AyaByIndex($Index){
        
        $this->db->where('index',$Index);
        $q = $this->db->get($this->QuranType);
        $row = $q->row();
        if($q->num_rows() > 0){
            
            $Aya['index'] = $row->index;
            $Aya['sura']  = $row->sura ;
            $Aya['aya']   = $row->aya  ;
            
            if (!$this->ShowBasmalah && $Aya['aya'] == 1 && $Aya['sura'] != 1 && $Aya['sura'] != 9)
                $text = preg_replace('/^(([^ ]+ ){4})/u', '', $row->text);
            else
                $text = $row->text;
            
            $Aya['text']  = $text      ;
            
            return $Aya;
        }
        return;
    }
    
    function get_AyaBySuraAya($Sura,$Aya){
        
        $Index = $this->SuraAya2Index($Sura, $Aya);
        
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
        
        $From_Index = $this->SuraAya2Index($From_Sura, $From_Aya);
        $To_Index   = $this->SuraAya2Index($To_Sura, $To_Aya)    ;
        
        return $this->get_AyasByIndex($From_Index, $To_Index);
    }
    
    function SuraAya2Index($Sura,$aya){
        
        $this->db->where(array('sura' => $Sura,'aya' => $aya));
        $q = $this->db->get($this->QuranType);
        $row = $q->row();
        if($q->num_rows() > 0){
            return $row->index;
        }else return;
    }
    
    function Index2SuraAya($Index){
        
        $this->db->where('index',$Index);
        $q = $this->db->get($this->QuranType);
        $row = $q->row();
        if($q->num_rows() > 0){
            return array($row->sura,$row->aya);
        }else return;
    }
    
    function Is_AyaByIndex($Index){ // Check if aya numer good for this sura or not !
        
        return (is_numeric($Index) && $Index >= 1 && $Index <= 6236);
    }
    
    function Is_AyaBySuraAya($Sura,$Aya){ // Check if aya numer good for this sura or not !
        
        return $this->Is_AyaIndex($this->SuraAya2Index($Sura, $aya));
    }
    
    function get_SuraInfo($Sura){
        
        $this->db->where('index',$Sura);
        $q = $this->db->get('suras');
        
        if($q->num_rows() > 0){
            foreach ($q->row() as $key => $value) {
                $SuraInfo[$key] = $value;
            }
            return $SuraInfo;
        }else return;
    }
    
    function get_SurasInfo($From_Sura,$To_Sura){
        
        for ($Sura=$From_Sura; $Sura <= $To_Sura; $Sura++) { 
            $SurasInfo[] = $this->get_SuraInfo($Sura);
        }
        
        return $SurasInfo;
        
    }
    
    function get_Sura($SuraIndex){
        
        $SuraInfo = $this->get_SuraInfo($SuraIndex);
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
    
    function Is_Sura($Sura){ // Check if this sura number good or not !
        
        return ($Sura >= 1 && $Sura <= 114);
    }
}

/* End of file model_aya.php */
/* Location: ./application/models/model_aya.php */