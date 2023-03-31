<?php
    include "viaje.php";
    $miViajePasajeros = array ();
    $miViajeCantMaxPasajeros = 0;
    $miViajeId=0;
    $miViajeDestino = "";
    $miViajeArreglado = array ();
    $miViaje = new ViajeFeliz($miViajeId,$miViajeDestino,$miViajeCantMaxPasajeros,$miViajePasajeros,$miViajeArreglado);
    do {
        echo "Que desea realizar ?: 1: Cargar informacion del viaje | 2: Modificar datos del viaje | 3: Ver datos del viaje | Cualquier otro valor para salir.\n";
        $cortar = false;
        $opcionMenu = trim(fgets(STDIN));
        if ($opcionMenu == 1 || $opcionMenu == 2 || $opcionMenu == 3){
            $cortar = true;
        }

        switch ($opcionMenu) {
            case '1':
                $miViajePasajeros = [];
                $dniPasajeros = [];

                do {
                    echo "Ingrese el id del viaje: ";
                    $miViajeId = trim(fgets(STDIN));
                    $viajesArreglados = $miViaje->getViajeArreglado();
            
                    // Verificar si el id de viaje ya existe
                    $idExiste = false;
                    foreach ($viajesArreglados as $viaje) {
                        if ($viaje['idViaje'] == $miViajeId) {
                             $idExiste = true;
                             break;
                        }
                    }
                    if ($idExiste) {
                         echo "El id de viaje ya existe. Por favor, ingrese otro.\n";
                    }
                } while ($idExiste);
                echo "Cual es el destino de su viaje? ";
                $miViajeDestino = trim(fgets(STDIN));
                echo "Cual es la cantidad maxima de pasajeros ? ";
                $miViajeCantMaxPasajeros = trim(fgets(STDIN));
                for ($i=0; $i < $miViajeCantMaxPasajeros; $i++) {
                    $dniRepetido = false;
                    echo "Ingrese el nombre del pasajero N°".($i+1) . " del viaje :\n";
                    $miViajePasajeros[$i]['nombre'] = trim(fgets(STDIN));
                    echo "Ingrese el apellido del pasajero:\n";
                    $miViajePasajeros[$i]['apellido'] = trim(fgets(STDIN));
                    echo "Ingrese el dni del pasajero:\n";
                    $miViajePasajeros[$i]['dni'] = trim(fgets(STDIN));

                    foreach($dniPasajeros as $dniAnterior){
                        if($miViajePasajeros[$i]['dni'] == $dniAnterior){
                             $dniRepetido = true;
                            break;
                        }
                    }
                    if($dniRepetido){
                        do {
                            echo "El pasajero con dni: " . $miViajePasajeros[$i]['dni'] . " ya ha sido ingresado, por favor ingrese otro.\n";
                            echo "Ingrese el nombre del pasajero N°" . ($i+1)  . " del viaje. " . ":\n";
                            $miViajePasajeros[$i]['nombre'] = trim(fgets(STDIN));
                            echo "Ingrese el apellido del pasajero:\n ";
                            $miViajePasajeros[$i]['apellido'] = trim(fgets(STDIN));
                            echo "Ingrese el dni del pasajero:\n";
                            $miViajePasajeros[$i]['dni'] = trim(fgets(STDIN));
                            $dniRepetido = false;
                            foreach($dniPasajeros as $dniAnterior){
                                if($miViajePasajeros[$i]['dni'] == $dniAnterior){
                                    $dniRepetido = true;
                                break;
                                }
                            }
                        } while ($dniRepetido);
                    }
                    $dniPasajeros[] = $miViajePasajeros[$i]['dni'];
                }
                $viajeCargado = $miViaje->cargarViaje($miViajeId,$miViajeDestino,$miViajeCantMaxPasajeros,$miViajePasajeros);
                break;
            case '2':
                echo "Que viaje con que id quiere modificar?\n";
                $viajeIdMenu = trim(fgets(STDIN));
                $miViaje->modificarViaje($miViajeId);
                break;
            case '3':
                echo $miViaje;
            break;
        }
    } while ($cortar);
?>