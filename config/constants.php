<?php

return [
    'CLIENTS' => [
        "client_name" => [ # Client name
            "url" => "http://url", # Client uri
            "services" => [ # List of Webhook services available for this client
                "service_name" => [ # Service Name 
                    # Service parameters
                    "email" => "",
                    "seller_id" => "",
                    "..."
                ]
            ]
        ]
        #...
    ]
];