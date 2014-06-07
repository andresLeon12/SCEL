<?php

/**
 * Description of C_profesor
 *
 * @author Lucho
 */
class C_profesor {
    //put your code here
    var $clvProfNov;//clave del profesor
    var $nomProNov;//nombre del profesor
    var $apePatPro;//apellido paterno del profesor
    var $apeMatPro;//apellido materno del profesor
    var $grdProNov;//grado academico del profesor
    var $logProNov;//login del profesor
    var $pasProNov;//contraseña del profesor
    var $materias;
    
    /*Metodos SET y GET de cada una de las variables*/
    
    function C_profesor(){
        //$this->crearConexion();
    }
    
    public function getClvProfNov() {
        return $this->clvProfNov;
    }

    public function setClvProfNov($clvProfNov) {
        $this->clvProfNov = $clvProfNov;
    }

    public function getNomProNov() {
        return $this->nomProNov;
    }

    public function setNomProNov($nomProNov) {
        $this->nomProNov = $nomProNov;
    }

    public function getApePatPro() {
        return $this->apePatPro;
    }

    public function setApePatPro($apePatPro) {
        $this->apePatPro = $apePatPro;
    }

    public function getApeMatPro() {
        return $this->apeMatPro;
    }

    public function setApeMatPro($apeMatPro) {
        $this->apeMatPro = $apeMatPro;
    }

    public function getGrdProNov() {
        return $this->grdProNov;
    }

    public function setGrdProNov($grdProNov) {
        $this->grdProNov = $grdProNov;
    }

    public function getLogProNov() {
        return $this->logProNov;
    }

    public function setLogProNov($logProNov) {
        $this->logProNov = $logProNov;
    }

    public function getPasProNov() {
        return $this->pasProNov;
    }

    public function setPasProNov($pasProNov) {
        $this->pasProNov = $pasProNov;
    }

    public function getMaterias() {
        return $this->materias;
    }

    public function setMaterias($materias) {
        $cont = 0;
        $mat = NULL;
        foreach ($mat as $materias){
            $this->materias[$cont] = $mat;
        }
    }
/****************************************************************/    
}
