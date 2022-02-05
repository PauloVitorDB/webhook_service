# Tratamento de requisições webhook por serviços single instance

Projeto feito com o intuito de tratar requisições webhook de serviços que demandam uma única instância de URL para mais de um domínio (Single Instance).

# Execute o projeto
Para executar o projeto instale o Docker e o Docker Compose e utilize os comandos abaixo no diretório raiz do projeto:
```
docker-compose build
docker-compose up -d
```

## Configurar serviços
Utilize a estrutura declarada no arquivo do caminho relativo abaixo para definir os serviços por cliente e os parâmetros de cada serviço 
```
webhook_service/config/constants.php
```

# Logs
Utilize o middleware 'LogRequest' juntamente com uma _role_ para definir a gravação de logs das requisições nos _endpoints_ que queira monitorar. Os logs estão disponíveis no diretório /webhook_service/storage/logs/<br/>

**Observação:** _os logs só serão gravados caso retorne uma resposta com o header '**X-Client-Name**' nas requisições do endpoint e terão o nome igual ao 'nome do cliente' + 'nome do serviço'._

<br/>**Exemplo:**
```
Route::group(['middleware' => ['LogRequest:nome_do_servico']], function($id) {
    Route::post('/endpoint', [NomeController::class, 'nome_fun']);
});
```

## .env
* **LOG_MAX_DAYS**: Defina a quantidade de dias em que o log de requisições ficará disponível para consulta.
