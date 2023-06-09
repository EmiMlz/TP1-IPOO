<?php
    class ViajeFeliz {
    //Asignacion de nombre a las propiedades de la clase
    private $viajeId;
    private $destino;
    private $cantMaxPasajeros;
    private $pasajeros;
    private $viajeArreglado;
    /** Metodo constructor de propiedades internas de la clase */
    public function __construct ($viajeId,$destino,$cantMaxPasajeros,$pasajeros,$viajeArreglado) {
        $this->viajeId = $viajeId;
        $this->destino = $destino;
        $this->cantMaxPasajeros = $cantMaxPasajeros;
        $this->pasajeros = $pasajeros;
        $this->viajeArreglado = array();
    }
    /** Metodo de acceso a las propiedades de la clase */
    public function getViajeId(){
       return $this->viajeId;
    }
    public function getDestino(){
       return $this->destino;
    }
    public function getCantMaxPasajeros(){
       return $this->cantMaxPasajeros;
    }
    public function getPasajeros(){
        return $this->pasajeros;
    }
    public function getViajeArreglado(){
        return $this->viajeArreglado;
    }
    /** Metodo de setteo a las propiedades de la clase */
    public function setViajeId($viajeId){
        return $this->viajeId = $viajeId;
    }
    public function setDestino($destino){
        return $this->destino = $destino;
    }
    public function setCantMaxPasajeros($cantMaxPasajeros){
        return $this->cantMaxPasajeros = $cantMaxPasajeros;
    }
    public function setPasajeros($pasajeros){
        return $this->pasajeros = $pasajeros;
    }
    public function setViajeArreglado($viajeArreglado){
        return $this->viajeArreglado = $viajeArreglado;
    }
    /**
     * Esta funcion carga del archivo TestViaje.php los datos de la clase, con los siguiente parametros de entrada y los settea como un arreglo en $viajeArreglado
     * @param INT $viajeId
     * @param STRING $destino
     * @param INT $cantMaxPasajeros
     * @param ARRAY $parajeros
     */
    public function cargarViaje($viajeId, $destino, $cantMaxPasajeros, $pasajeros){
        $viaje = array ('idViaje'=>$viajeId, 'destino'=>$destino, 'cantMaxPasajeros'=>$cantMaxPasajeros, 'pasajeros'=>array());
        for ($i = 0; $i < count($pasajeros); $i++){
            $viaje['pasajeros'][] = array ('nombre'=>$pasajeros[$i]['nombre'], 'apellido'=>$pasajeros[$i]['apellido'], 'dni'=>$pasajeros[$i]['dni']);
        }
        $viajeArreglado = $this->getViajeArreglado();
        $viajeArreglado[] = $viaje;
        $this->setViajeArreglado($viajeArreglado);
    }
    /** Este Metodo toma un id de algun viaje ingresado por el usuario y lo compara con los que estan guardadas en el arreglo en la clase y le muestra un menu de opciones donde el usuario ingresa que dato del viaje modificar, como el destino y los pasajeros
     * @param INT $unViajeId
     */
    function modificarViaje($unViajeId) {
        foreach ($this->viajeArreglado as $key=>$viaje) {
            if ($viaje['idViaje'] == $unViajeId) {
                echo "Que dato quiere modificar? 1: Para destino | 2: Para agregar,quitar un pasajero o modificar un pasajero\n";
                $opcionMenuMod = trim(fgets(STDIN));
                switch ($opcionMenuMod) {
                    case '1':
                        echo "Ingrese el nuevo destino \n";
                        $modDestino = trim(fgets(STDIN));
                        $this->viajeArreglado[$key]['destino'] =  $modDestino;
                        break;
                    case '2':
                        echo "1: Agregar pasajero\n";
                        echo "2: Quitar pasajero\n";
                        echo "3: Modificar datos de pasajero\n";
                        $opcionPasajero = trim(fgets(STDIN));
                        switch ($opcionPasajero) {
                            case '1':
                                // Este case agrega un pasajero al viaje
                                echo "Ingrese el nombre del pasajero: \n";
                                $nombrePasajero = trim(fgets(STDIN));
                                echo "Ingrese el apellido del pasajero: \n";
                                $apellidoPasajero = trim(fgets(STDIN));
                                echo "Ingrese el DNI del pasajero: \n";
                                $dniPasajero = trim(fgets(STDIN));
                                $this->viajeArreglado[$key]['pasajeros'][] = ['nombre'=>$nombrePasajero, 'apellido'=> $apellidoPasajero,'dni'=>$dniPasajero];
                                break;
                            case '2':
                                // Este case borra un pasajero del viaje mediante su DNI
                                echo "Ingrese el DNI del pasajero que desea quitar: \n";
                                $dniPasajeroQuitar = trim(fgets(STDIN));
                                $indicesEliminar = array();
                                foreach ($this->viajeArreglado[$key]['pasajeros'] as $indice => $pasajero) {
                                    if ($pasajero['dni'] == $dniPasajeroQuitar) {
                                            $indicesEliminar[] = $indice;
                                    }  
                                }
                                foreach ($indicesEliminar as $indice) {
                                    // Se borra el indice donde se encontro el dni del pasajero
                                    unset($this->viajeArreglado[$key]['pasajeros'][$indice]);
                                }
                                $this->viajeArreglado[$key]['pasajeros'] = array_values($this->viajeArreglado[$key]['pasajeros']);
                                break;
                                case '3':
                                    // Este case modifica los datos de un pasajero con el DNI ingresado
                                    echo "Ingrese el DNI del pasajero que desea modificar: \n";
                                    $dniPasajeroMod = trim(fgets(STDIN));
                                    foreach ($this->viajeArreglado[$key]['pasajeros'] as $indice => $pasajero) {
                                        if ($pasajero['dni'] == $dniPasajeroMod) {
                                            echo "Ingrese el nuevo nombre del pasajero: \n";
                                            $nombrePasajeroMod = trim(fgets(STDIN));
                                            echo "Ingrese el nuevo apellido del pasajero: \n";
                                            $apellidoPasajeroMod = trim(fgets(STDIN));
                                            echo "Ingrese el nuevo DNI del pasajero: \n";
                                            $dniPasajeroMod = trim(fgets(STDIN));
                                            $viajeArreglado[$key]['pasajeros'][$indice] = ['nombre'=>$nombrePasajeroMod, 'apellido'=>$apellidoPasajeroMod, 'dni'=>$dniPasajeroMod];
                                        }
                                    }
                                    $this->viajeArreglado[$key]['pasajeros']= $viajeArreglado[$key]['pasajeros'];
                                    break;
                        }
                }
            }
        }
    } 
    /** Metodo __toString de la clase que convierte el arreglo en un mensaje con los datos del viaje a mostrar guardado en la variable $mensaje que luego retorna
     * 
     */
    public function __toString(){
        $mensaje = '';
        foreach ($this->viajeArreglado as $viajeArreglado) {
            $mensaje .= 'Id: ' . $viajeArreglado['idViaje'] . ' Destino: ' . $viajeArreglado['destino'] . "\n";
            if (count($viajeArreglado['pasajeros']) > 0) {
                $mensaje .= 'Pasajeros: ' . "\n";
                foreach ($viajeArreglado['pasajeros'] as $pasajero) {
                    $mensaje .= '- Nombre: ' . $pasajero['nombre'] . "\n" ."  Apellido: " . $pasajero['apellido'] . "\n" . "  Dni: " . $pasajero['dni'] . "\n";
                }
            } else {
                $mensaje .= 'No hay pasajeros en este viaje.' . "\n";
            }
        }
        return $mensaje;
    }
}
?>