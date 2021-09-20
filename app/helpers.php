<?php

    function getClientByServiceValue($service, $value) {
        
        $client = false;

        $clients = config("constants.CLIENTS");
        foreach($clients as $client_name => $info) {
            $client_service = array_column($info, $service);
            if($client_service) {
                if(array_search($value, current($client_service)) !== false){
                    $client = array_merge([
                        'name' => $client_name
                    ], config("constants.CLIENTS.$client_name"));
                    break;
                }
            }
        }

        return $client;
    }

?>