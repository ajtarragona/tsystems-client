# Tsystems Laravel Client
Client per serveis de l'ERP de Tsystems (Tercers, Padró, Vialer).

*Credits*: Ajuntament de Tarragona.


## Instalació

```bash
composer require ajtarragona/tsystems-client
```

## Configuració

Pots configurar el paquet a través de l'arxiu `.env` de l'aplicació. Aquests son els parámetres disponibles :
```bash
TSYSTEMS_DEBUG 
TSYSTEMS_WS_URL 
TSYSTEMSAPI_WS_USER 
TSYSTEMS_WS_PASSWORD
TSYSTEMS_ID_INSTITUCION
```
* **Nota**: En els Serveis de Padró, si la nostra aplicació no defineix `TSYSTEMS_ID_INSTITUCION` per cada crida es farà una crida prèvia per recuperar-lo


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

### Tercers
Funció | Paràmetres | Retorn 
--- | --- | --- 
**getPersonByIdNumber** | `id`: identificador (DNI) del tercer | Un objecte `TSPerson` 
**getPersonByDboid** | `id`: identificador intern | Un objecte `Tercer` 
**searchPersons** | `name`: nom a buscar<br/>`search_type`: 1-conté, 2-comença per, 3: acaba en, 4: és igual a| Un array d'objectes `TSPerson` 
**createPerson** | `persondata[]`: array amb els valors de l'objecte `TSPerson`| Un array d'objectes `TSPerson` 
**updatePerson** | `dboid`: Id intern del tercer a modificar<br/> `persondata[]`: array amb els valors de l'objecte `TSPerson` a modificar

### Vialer
Funció | Paràmetres | Retorn 
--- | --- | --- 
**getCountriesByName** | `name`: nom a buscar | Un array d'objectes `TSCountry` 
**getCountryByCode** | `code`: codi a buscar  | un objecte `TSCountry` 
**getAllCountries** |  | Un array d'objectes `TSCountry` 
**getProvinciesByName** | `name`: nom a buscar| Un array d'objectes `TSProvince` 
**getAllProvincies** | `countrycode*`: code de pais (per defecte Espanya) | Un array d'objectes `TSProvince` 
**getProvinciesByName** | `name`: nom a buscar<br/>`countrycode*`: code de pais | Un array d'objectes `TSProvince` 
**getProvinciaByCode** | `code`: codi a buscar<br/>`countrycode*`: code de pais | Un objecte `TSProvince`  
**getAllMunicipis** | `provcode*`: codi de provincia (per defecte Tarragona) | Un array d'objectes `TSMunicipality`  
**getMunicipisByName** | `name`: nom a buscar<br/>`provcode*`: codi de provincia (per defecte Tarragona) | Un array d'objectes `TSMunicipality`   
**getMunicipiByCode** | `code`: codi a buscar<br/>`provcode*`: codi de provincia (per defecte Tarragona) | Un objecte `TSMunicipality`    
**getAcronymList** | | Un array d'objectes `TSAcronym`
**getCarrersByName** | `name`: nom a buscar<br/>`provcode*`: codi de provincia (per defecte Tarragona) | Un array d'objectes `TSStreet` 
**getCarrerByCode** | `code`: codi a buscar<br/>`provcode*`: codi de provincia (per defecte Tarragona) | Un objecte `TSStreet`  

### Padró
Funció | Paràmetres | Retorn 
--- | --- | --- 
**getCurrentInstitucion** | | Un objecte `TSInstitucion` de la institució de l'ajuntament
**getInstitucion** | `codigoProvincia*`: codi de provincia<br/>`codigoMunicipio*` codi de municipi | Un objecte `TSInstitucion`  
**getHabitanteByDNI** | `dni`: dni a buscar | Un objecte `TSHabitante` 
**getPDFHabitanteByDNI** | `dni`: dni a buscar | document binari en base64 
**getHabitantesByDNI** |  `dni`: dni a buscar | Un array d'objectes `TSHabitante` 
**getHabitantesByPasaporte** | `pasaporte`: pasaporte a buscar | Un array d'objectes `TSHabitante` 
**getHabitantesByTarjetaResidencia** | `id`: codi de la tarjeta de residencia a buscar |  Un array d'objectes `TSHabitante` 
**getHabitantesByNombre** | `nombre`: nom a buscar<br/>`apellido1`: primer cognom<br/>`apellido`: segon cognom | Un array d'objectes `TSHabitante`
**getNumHabitantesByDNI** | `dni`: dni a buscar | Un numero enter
**getNumHabitantesByPasaporte** | `pasaporte`: pasaporte a buscar | Un numero enter 
**getNumHabitantesByTarjetaResidencia** | `id`: codi de la tarjeta de residencia a buscar | Un numero enter 
**getNumHabitantesByNombre** | `nombre`: nom a buscar<br/>`apellido1`: primer cognom<br/>`apellido`: segon cognom | Un numero enter

