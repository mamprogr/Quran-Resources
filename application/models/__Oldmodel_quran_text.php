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
    public $ShowBasmalah    = TRUE;
    public $Is_AyaNum       = TRUE;
    public $AyaNum_Style    = ' { $1 } '; // Like : <span class=ayaNum>$1</span>
    public $Aya_Style       = ' $1 '; // Like : <div class=aya>$1<div>
    public $Ayas_Glue       = '|';
    public $Sura_Style      = ' $1 ';
    public $Suras_Glue      = '<hr />';
    public $WaqfMark_Style  =  ' $1'; // Like : <span class="sign">&nbsp;$1</span>
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
    
    /** quran_text **/
   
    function get_Aya(){
        
        $args = func_get_args();
        
        switch (count($args)) {
            case 1 : $this->db->where('index',$args[0]);  break;
            case 2 : $this->db->where(array('sura' => $args[0],'aya' => $args[1])); break;
            default: return;
        }
        
        $q = $this->db->get($this->QuranType);
        $row = $q->row();
        if($q->num_rows() > 0){
            
            switch (count($args)) {
                case 1 : $Sura = $row->sura; $Aya = $row->aya;  break;
                case 2 : $Sura = $args[0];   $Aya = $args[1];   break;
                default: return;
            }
            
            if (!$this->ShowBasmalah && $Aya == 1 && $Sura != 1 && $Sura != 9)
                $text = preg_replace('/^(([^ ]+ ){4})/u', '', $row->text);                
            else
                $text = $row->text;
            
            $text = preg_replace('/ ([ۖ-۩])/u', $this->WaqfMark_Style, $text);
                        
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
    
    /** /quran_text **/
    
    
    /** suras **/
   
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

    function Is_Sura($Sura){ // Check if this sura number good or not !
        
        return ($Sura >= 1 && $Sura <= 114);
    }
    
    function Is_Aya($Sura,$Aya){ // Check if aya numer good for this sura or not !
        
        return ($this->Is_Sura($Sura) && $Aya >= 1 && $Aya <= $this->get_SuraInfo($Sura, 'ayas'));
    }
    
    function Is_AyaIndex($Index){ // Check if aya numer good for this sura or not !
        
        return (is_numeric($Index) && $Index >= 1 && $Index <= 6236);
    }
    
    /** /suras **/
   
    /** juzs **/
   
    function get_JuzInfo(){
        
        $args = func_get_args();
        
        switch (count($args)) {
            case 1 : $this->db->where('index',$args[0]);  break;
            //array('sura' => $args[0],'aya' => $args[1])
            case 2 : $this->db->where("(sura = '$args[0]' AND aya <= '$args[1]') OR (sura < '$args[0]')"); break;
            default: return;
        }
        
        $this->db->order_by("index", "desc"); 
        $q = $this->db->get('juzs',1,0);
        
        if($q->num_rows() > 0){
            $row = $q->row();
            
            switch (count($args)) {
                case 1 : return array($row->sura,$row->aya);  break;
                case 2 : return $row->index; break;
                default: return;
            }
        }else return;
    }
    
    /** /juzs **/
   
    /** hizbs **/
   
    function get_HizbInfo(){
        
        $args = func_get_args();
        
        switch (count($args)) {
            case 1 : $this->db->where('index',$args[0]);  break;
            //array('sura' => $args[0],'aya' => $args[1])
            case 2 : $this->db->where("(sura = '$args[0]' AND aya <= '$args[1]') OR (sura < '$args[0]')"); break;
            default: return;
        }
        
        $this->db->order_by("index", "desc"); 
        $q = $this->db->get('hizbs',1,0);
        
        if($q->num_rows() > 0){
            $row = $q->row();
            
            switch (count($args)) {
                case 1 : return array('Sura' => $row->sura,'Aya' => $row->aya);  break;
                case 2 : return $row->index; break;
                default: return;
            }
        }else return;
    }
    
    /** /hizbs **/
   
    /** pages **/
   
    function get_PageInfo(){
        
        $args = func_get_args();
        
        switch (count($args)) {
            case 1 : $this->db->where('index',$args[0]);  break;
            //array('sura' => $args[0],'aya' => $args[1])
            case 2 : $this->db->where("(sura = '$args[0]' AND aya <= '$args[1]') OR (sura < '$args[0]')"); break;
            default: return;
        }
        
        $this->db->order_by("index", "desc"); 
        $q = $this->db->get('pages',1,0);
        
        if($q->num_rows() > 0){
            $row = $q->row();
            
            switch (count($args)) {
                case 1 : return array($row->sura,$row->aya);  break;
                case 2 : return $row->index; break;
                default: return;
            }
        }else return;
    }
    
    /** /pages **/
   
    /** sajdas **/
   
    function Is_Sajda($Sura,$Aya){
        $this->db->where(array('sura' => $Sura,'aya' => $Aya));
        $q = $this->db->get('sajdas');
        if($q->num_rows() > 0){
            $row = $q->row();
            return $row->type;
        }else
            return 0;
    }
    
    /** /sajdas **/
   
}

/* End of file model_quran_text.php */
/* Location: ./application/models/model_quran_text.php */