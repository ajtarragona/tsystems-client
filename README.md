# Tsystems Laravel Client
Client per serveis de l'ERP de Tsystems (Tercers, Padró, Vialer).

*Credits*: Ajuntament de Tarragona.


## Instalació

```bash
composer require ajtarragona/tsystems-client:"@dev"
```

## Configuració

Pots configurar el paquet a través de l'arxiu `.env` de l'aplicació. Aquests son els parámetres disponibles :
```bash
TSYSTEMS_DEBUG 
TSYSTEMS_WS_URL 
TSYSTEMSAPI_WS_USER 
TSYSTEMS_WS_PASSWORD
```
Alternativament, pots publicar l'arxiu de configuració del paquet amb la comanda:

```bash
php artisan vendor:publish --tag=ajtarragona-tsystems-config
```

Això copiarà l'arxiu a `config/tsystems.php`.


## Ús

Un cop configurat, el paquet està a punt per fer-se servir. 

Ho pots fer de les següents maneres:


### Vía Injecció de dependències:

Als teus controlladors, helpers, model:

```php
use Ajtarragona\Tsystems\Services\TsystemsTercersService;

...
public function test(TsystemsTercersService $tercers){
	$tercer=$tercers->getPersonByIdNumber(123456);
	...
}
```

> Disposem de tres serveis: `TsystemsTercers`, `TsystemsPadro`, `TsystemsVialer` 


### A través d'una `Facade`:

```php
use TsystemsTercers;
...
public function test(){
	$tercer=TsystemsTercers::getPersonByIdNumber(123456);
	...
}
```
> Disposem d'una Facade per cada servei: `TsystemsTercersService`, `TsystemsPadroService`, `TsystemsVialerService` , tots al namespace `Ajtarragona\Tsystems\Services`



### Vía funció `helper`:
```php
...
public function test(){
	$tercer=ts_tercers()->getPersonByIdNumber(123456);
	...
}
```
> Disposem 'un helper per cada servei: `ts_tercers()`, `ts_padro()`, `ts_vialer()` 


## Funcions

### AccedeTercers
Funció | Paràmetres | Retorn 
--- | --- | --- 
**getPersonByIdNumber** | `id`: identificador (DNI) del tercer | Un objecte `Tercer` 