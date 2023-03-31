<?php
    // Se incluye el archivo "viaje.php" para utilizarlo en el testeo
    include "viaje.php";
    // Se inicializan las variables
    $miViajePasajeros = array ();
    $miViajeCantMaxPasajeros = 0;
    $miViajeId=0;
    $miViajeDestino = "";
    $miViajeArreglado = array ();
    $miViaje = new ViajeFeliz($miViajeId,$miViajeDestino,$miViajeCantMaxPasajeros,$miViajePasajeros,$miViajeArreglado);
    // Se utiliza un do while para que el usuario elija por lo menos una vez que desea hacer y se le fuerza a elegir una opcion correcta dentro de las 3 proporcionadas
    do {
        echo "Que desea realizar ?: 1: Cargar informacion del viaje | 2: Modificar datos del viaje | 3: Ver datos del viaje | Cualquier otro valor para salir.\n";
        $cortar = false;
        $opcionMenu = trim(fgets(STDIN));
        if ($opcionMenu == 1 || $opcionMenu == 2 || $opcionMenu == 3){
            $cortar = true;
        }
        // Menu de opciones via un switch case, que lleva a cada metodo creado
        switch ($opcionMenu) {
            // Si el usuario ingresa 1, es porque desea cargar informacion del viaje con el metodo cargarViaje definido en la clase
            case '1':
                $miViajePasajeros = [];
                $dniPasajeros = [];
                // Bucle do while que solicita una id que no se haya cargado previamente
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
                //Ya chequeado que el id ingresada no existe se piden que se ingrese el destino, la cantidad maximas de pasajeros y los pasajeros del viaje
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
                    // Se verifica que el DNI del pasajero no se haya ingresado previamente
                    foreach($dniPasajeros as $dniAnterior){
                        if($miViajePasajeros[$i]['dni'] == $dniAnterior){
                             $dniRepetido = true;
                            break;
                        }
                    }
                    // Si el DNI ya fue ingresado, se solicita al usuario un nuevo DNI
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
                //Si se entra al caso 2 el programa solicita la id del viaje a modificar y luego se llama al metodo modificarViaje que deriva mas opciones para elegir que dato modificar
                echo "Que viaje con que id quiere modificar?\n";
                $viajeIdMenu = trim(fgets(STDIN));
                $miViaje->modificarViaje($miViajeId);
                break;
            case '3':
                // Se puede mostrar los datos del viaje gracias al metodo __toString definido en viaje.php
                echo $miViaje;
            break;
        }
    } while ($cortar);
?>