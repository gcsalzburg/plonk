<?php


// Suffix information
// _t = 100
// _n = 320
// _c = 800
// _h = 1600
// _k = 2048
// _o = original
            
class imgs{

    protected $img_array = array();

    private $valid_suffix = array('t','n','c','h','k');

    public function add_file($fileinfo){

        $fn = basename($fileinfo->getFilename(),'.'.$fileinfo->getExtension());

        if(substr($fn,-2,1) == "_"){

            $suffix = substr($fn,-1);

            if(in_array($suffix,$this->valid_suffix)){
                $base = substr($fn,0,strlen($fn)-2);
                $this->img_array[$base][$suffix] = $fileinfo->getFilename();
                return true;
            }
        }
        return false;
    }

    public function get_thumbs_array(){
        return $this->img_array;
    }

    public function debug_array(){
        echo '<pre>';
        var_dump($this->img_array);
        echo '</pre>';
    }

}