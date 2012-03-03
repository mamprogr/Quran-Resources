<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_trans_text extends CI_Model {
    
    /** Const **/
    private $TransType      = 'trans_ar_muyassar';
    private $TransTypes     = array(
                                'trans_ar_jalalayn',
                                'trans_ar_muyassar'
                                    );
    public $Is_AyaNum       = TRUE;
    public $AyaNum_Style    = ' { $1 } '; // Like : <span class=ayaNum>$1</span>
    public $Aya_Style       = ' $1 '; // Like : <div class=aya>$1<div>
    public $Ayas_Glue       = '|';
    public $Sura_Style      = ' $1 ';
    public $Suras_Glue      = '<hr />';
    /** /Const **/
    
    function __construct(){
        parent::__construct();        
    }
    
    function set_TransType($Type){
        
        if(in_array($Type, $this->TransTypes)){
            $this->TransType = $Type;
            return 1;
        }
        return 0;
    }
    
    /** trans_text **/
   
    function get_Aya(){
        
        $args = func_get_args();
        
        switch (count($args)) {
            case 1 : $this->db->where('index',$args[0]);  break;
            case 2 : $this->db->where(array('sura' => $args[0],'aya' => $args[1])); break;
            default: return;
        }
        
        $q = $this->db->get($this->TransType);
        $row = $q->row();
        if($q->num_rows() > 0){
            
            switch (count($args)) {
                case 1 : $Sura = $row->sura; $Aya = $row->aya;  break;
                case 2 : $Sura = $args[0];   $Aya = $args[1];   break;
                default: return;
            }
            
            $text = $row->text;
            
            if ($this->Is_AyaNum)
                $text .= str_replace('$1', $row->aya, $this->AyaNum_Style);
            
            $text = str_replace('$1', $text, $this->Aya_Style);
            
            return $text;
            
        }else return;
    }
    
    function get_Sura($Sura){ // ($Sura) || ($Sura,$To) || ($Sura,$From,$To)
        
        $args = func_get_args();
        $From = 1;
        
        switch (count($args)) {
            case 2 : $To   = $args[1]; break;
            case 3 : $From = $args[1]; $To = $args[2]; break;
            default: $To   = $this->get_SuraInfo($Sura, 'ayas');
        }
        
        for($Aya=$From; $Aya <= $To; $Aya++){
            $Ayas[] = $this->get_Aya($Sura,$Aya);
        }
        
        $Ayas = implode($this->Ayas_Glue,$Ayas);
        
        $Ayas = str_replace('$1', $Ayas, $this->Sura_Style);
        
        return $Ayas;
    }
    
    function get_Suras($From,$To){
        
        for($Sura=$From; $Sura <= $To; $Sura++){
            $Suras[] = $this->get_Sura($Sura);
        }
        
        $Suras = implode($this->Suras_Glue,$Suras);
        return $Suras;
    }
    
    function get_Ayas(){ // ($FromIndex,$ToIndex) || ($FromSura,$FromAya,$ToSura,$ToAya)
        
        $args = func_get_args();
        
        switch (count($args)) {
            case 2 : $From   = $args[0];$To = $args[1]; break; // $From Index, $To Index
            case 4 : $From = $this->SuraAya2Index($args[0], $args[1]); $To = $this->SuraAya2Index($args[2], $args[3]);; break;
            default: return;
        }
        
        for($Aya=$From; $Aya <= $To; $Aya++){
            $Ayas[] = $this->get_Aya($Aya);
        }
        
        $Ayas = implode($this->Ayas_Glue,$Ayas);
        return $Ayas;
    }
    
    function get_SuraInfo($Sura,$Info){
        
        $this->db->where('index',$Sura);
        $q = $this->db->get('suras');
        
        if($q->num_rows() > 0){
            $row = $q->row();
            
            switch ($Info) {
                case 'ayas' : return $row->ayas;  break;
                case 'start': return $row->start; break;
                case 'name' : return $row->name;  break;
                case 'tname': return $row->tname; break;
                case 'ename': return $row->ename; break;
                case 'type' : return $row->type;  break;
                case 'order': return $row->order; break;
                case 'rukus': return $row->rukus; break;
                default: return $row->index; break;
            }
        }else return;
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
        $q = $this->db->get($this->TransType);
        $row = $q->row();
        if($q->num_rows() > 0){
            return array($row->sura,$row->aya);
        }else return;
    }
    
    /** /trans_text **/
}
/* End of file model_trans_text.php */
/* Location: ./application/models/model_trans_text.php */