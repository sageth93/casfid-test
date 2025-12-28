# CASFID – Reto Técnico Backend (DailyTrends)
¡Muy buenas! Soy Sergio Pérez y esta es mi prueba técnica para el puesto de Backend Developer para CASFID, os dejo este Readme con la configuración del proyecto y diferentes consideraciones respecto a la prueba.

## Setup
Para mayor comodidad durante el desarrollo y el setup del proyecto, he configurado un archivo **Makefile** para simplificar todos los comandos necesarios, de todas maneras, su uso es opcional y también se indicarán los comandos a ejecutar sin usar **make** y se puede instalar en Linux con el siguiente comando.

	sudo apt-get -y install make

Ahora si, empezamos con el setup clonando el repositorio.

    git clone https://github.com/sageth93/casfid-test.git

Para levantar el contenedor de docker se necesita rellenar las variables UID y UNAME que son el id y nombre de usuario de linux que lo esta ejecutando, podemos rellenarlas en el archivo **.env**

    UID=  
    UNAME=

Levantamos los contenedores de **Docker**

	make up
o

	docker-compose up -d

Instalamos las dependencias de composer y las migraciones de la base de datos:

	make setup
o

	docker container exec -it server_casfid_technical_test composer install
	docker container exec -it server_casfid_technical_test php bin/console doctrine:migrations:migrate --no-interaction

Con esto el setup del proyecto estaría completo.

## API
La api para el feed de noticias no requiere de autenticación y se puede acceder a ella mediante la interfaz de swagger en la siguiente URL con su debida documentación.

	http://localhost:8890/api/doc

Y mediante cualquier otro cliente se pueden realizar llamadas a esta URL:

	http://localhost:8890/api
Tambien hay unas **fixtures**  creadas para rellenar la base de datos de noticias si se requiere usando el siguiente comando

	make populate-bbdd
o

    docker container exec -it server_casfid_technical_test php bin/console doctrine:fixtures:load

## Scraper
El scraper de noticias se usa mediante un comando de consola de symfony, aunque la información que se quiere recopilar es pequeña, el proceso se ha dividido en dos partes para favorecer la escalabilidad a nivel de infraestructura y la velocidad de ejecución, esas dos partes son las siguientes.

- **SourceScraper** - Se encarga de recuperar la url de las noticias principales de los periódicos, una vez recuperadas y guardadas, se lanza un evento por cada **Source** para que se consuma de forma **asíncrona**.
- **NewsScraper** - Es el encargado de ejecutar el evento lanzado por **SourceScraper** y guardar la noticia en cuestión, para que el evento sea recuperado y consumido es necesario ejecutar el comando **messenger:consume** de symfony.

### Ejecutar el Scrap de noticias
El comando inicia el proceso de Scrap es el siguiente:

	make scrap-news
o

    docker container exec -it server_casfid_technical_test php bin/console casfid:scrap-news -v

Consumimos la cola de mensajes, se puede ejecutar en otra consola o configurar un gestor de procesos como **Supervisor**

	make messenger-consume
o

    docker container exec -it server_casfid_technical_test php bin/console messenger:consume async -vv

### Escalabilidad del código
De cara a añadir nuevas paginas de noticias de las que recuperar noticias, se ha simplificado al máximo el funcionamiento mediante **factories** con ayuda de la inyección de dependencias de Symfony.

Para añadir nuevas paginas de noticias son necesarios únicamente tres pasos:

1. Modificar el enum **SourceOrigin** y añadir un identificador de 3 caracteres
2. Implementar el **NewsScraper**  extendiendo de **BaseNewsScraper** o implementando la interfaz **NewsScraperInterface**, el namespace que en la que tiene que ubicarse es la siguiente:

   
    App\Casfid\Scraper\Infrastructure\Scraper\NewsScraper
3. Implementar el **SourceScraper** implementando la interfaz **SourceScraperInterface**, el namespace que en la que tiene que ubicarse es la siguiente:


    App\Casfid\Scraper\Infrastructure\Scraper\SourceScraper

## Tests

De cara a los tests del proyecto, he puesto especial enfasis en el testeo de la parte del Scrap, los handlers, los propios scrapers y en el proceso general.

De cara al CRUD de la API no he considerado necesario implementar tests unitarios ya que la lógica de negocio es muy simple y los validadores del controlador se encargan de que los datos que llegan a los casos de uso ya estén validados. Con la lógica que tienen los casos de uso considero irrelevante ahora mismo realizar esos tests ya que al final de todo son validaciones básicas en un CRUD como comprobar que la entidad que se quiere modificar existe etc. Si esos casos de uso crecieran en un futuro en cuanto a lógica de negocio si seria necesario realizarlos.

Para ejecutar los tests usaremos el siguiente comando:

	make phpunit
o

    docker container exec -it server_casfid_technical_test php bin/phpunit
## Consideraciones
### DDD y Separacion por Contextos
Creo que DDD como arquitectura es el tipo de arquitectura limpia que se busca de cara a un proyecto fácil de mantener y de escalar.
Al estar estructurado en capas bien definidas permite separar perfectamente responsabilidades y aislar la lógica de negocio de los casos de uso y de  la infraestructura requerida, como el propio framwork o la base de datos haciendo que sea mas fácil de migrar en un futuro (esto es algo de lo que siempre se habla pero casi nunca se lleva a cabo, no nos vamos a engañar).
Por ultimo permite separar en Bounded Context la aplicación separando responsabilidades, en este caso la funcionalidad del **Scraper** por un lado y la **API** por otra y haciendo que, en caso de ser necesario, se separen los proyectos en servicios diferentes si fuera necesario.

Referente a esto ultimo, habréis observado que el modelo **News esta duplicado**, uno para cada bounded context, conceptualmente representan lo mismo e incluso se guardan en la misma tabla de la base de datos, pero su implementacion en cada bounded context es diferente, por ejemplo en el contexto de **Scraper**, **News** tiene un **Source** asociado que es el que ha sido usado para encontrar la noticia, sin embargo en el contexto de **API**, este campo es irrelevante, pues las noticias creadas por la API no tienen un **Source** ni la api necesita devolver el **Source**.
Al final la separación por contextos es un tema conceptual para separar ideas y responsabilidades de cara al desarrollo y el funcionamiento de la aplicación, aunque a primera vista parece que se duplica codigo, aporta solidez al sistema y lo vuelve mas resiliente
### MySQL vs MongoDb
He preferido usar MySQL por diferentes factores, por un lado por familiaridad ya que es el motor de base de datos con el que tengo más experiencia.
Se verifica la estructura al completo de los Objetos de dominio, no son modelos flexibles que es una característica a tener en cuenta cuando se elige un motor como MongoDb.
Por otro lado MySql al ser relacional de forma nativa ayuda a establecer y creo que es mejor para implementar el flujo de ejecución ya definido.
Por ultimo, la escala del proyecto hace que MySql se comporte bien en cuanto a rendimiento ya que no va a tener una escala masiva. Aunque creo que de escalar antes sopesaría otros motores mas interesantes y con mas utilidades como PostgreSql

### Eventos y Mensajes asíncronos
Creo que este proyecto, teniendo en cuenta que se busca velocidad de ejecución y escalabilidad es un buen ejemplo de por qué usar eventos y asincronía, aunque no sea del todo necesario pues la cantidad de llamadas HTTP que se realizan no es excesiva, en este caso son solo 12 peticiones HTTP, pero aumentando la cantidad de noticias por origen y la cantidad de orígenes el numero se puede descontrolar.
Convirtiendo el Servicio de Scrap de Noticias en asíncrono nos aseguramos de no bloquear la aplicación durante la ejecución y de no tener picos de  recursos excesivos.

Por otro lado, hay un sistema de Eventos Síncronos configurado que no he usado tanto como me gustaría, pero creo que es útil de cara a separar aun mas las responsabilidades de los casos de uso, como por ejemplo para enviar un mail al cliente cuando se añada una nueva noticia, llamar a un microservicio que haga uso de la api implementada o cualquier otra cosa que no sea una responsabilidad directa del caso de uso.

### Command Bus y  Middlewares
He implementado Tactician como command bus, creo que es una herramienta muy flexible que ayuda a automatizar ciertos procesos tediosos y ayuda al desacoplamiento, escalabilidad y en esencia a la productividad durante el desarrollo.
También he incluido dos middlewares que ayudan a gestionar las transacciones hechas en base de datos aportándole resiliencia al sistema:
- **tactician-doctrine**: Permite que todas las inserciones o updates que se ejecutan en el Command Bus lo hagan en una misma transacción de manera de que haya un rollback automatico si el proceso completo falla.
- **DoctrineFlushMiddleware**: Este implementado por mi, hace que solo se ejecute un único **flush** al terminar la ejecucion del Command Bus, para que, en el caso de que hayan muchos inserts en un mismo proceso no sobrecargar de mas la base de datos.

## Conclusión
Después de la chapa de las consideraciones, decir que me ha parecido una prueba técnica muy interesante y diferente a otras que he visto, he tenido la oportunidad de implementar e investigar soluciones y ser creativo con el resultado, estoy muy contento con como ha quedado el proyecto y espero poder trabajar con el equipo Casfid.

Si tenéis alguna duda o cualquier problema no dudéis en contactarme, creo que no me he dejado nada.

Un saludo
## Estructura basica del Scraper
He hecho solo la estructura del Context Scraper, ya que creo que la API no tiene gran misterio en cuanto a estructura.

[![](https://mermaid.ink/img/pako:eNp9VF1vmzAU_StXfphWKURACBAeqjVJ203aqmlZNWmlD57tJKhgR8a0Y1H--2wMg0TJHpDA99xzzv3Ae0QEZShBjuOknAi-zjZJygFyXItKJcDyl5Q3wXUu3sgWSwXf5wYBcPP-KUULwUuRsxQ9X4HjwD1TK1FJwsqFKArMqT68hrkGrojEu-PYR_3kTOpcS7gwhKu6WAtew4rJ10xjW-Zr4J6O3mGihKzhK5YYJCPVjkksIRclWO5GhskSbDGVxFQYDngHPPo_wQN7Ky-lW4NzU-KRzieumFxjwqxFXys8lucN7Yzir6okOvz47XMJlAEXKiMZ7hW4d1ni6dk2s0X6VnKiJe8rLKmmtXnAOMzny2VbdaABt6-MK2EUWwiRTFfWywbgjOGmrDkBM9GqYBLGhn5qZvIDK7LVJ8MSHnrrVy3JtPFuXJtWzmurNVwEHnabcAZxug58YvjuMk5b05ahDUYmOBjZaZv-AcNLQAuLhyM7WoFhtTnuZtXbiy3BbDCApin4ZACea3p4y6ltVbtKH_ZQbrVQYrZQHbqS-2NS591pMACLilNGu0h4nmZ2TINGaCMzihIlKzZCergFNp9ob_ApUltW6F840a-6ipcUpdzk7DD_KUTRpWnpzRYla5yX-qvaUazYMsMbiXsI0-bkQntUKPHcacOBkj36jRJ_Eo-jOApmgReFgesF_gjVKHH8YDyJ4iD2vdAL_SicHkboTyPrjT3Xm4Z-7PmxO3NDPxghRjP9_36xt1ZzeR3-ArTeiOU?type=png)](https://mermaid.live/edit#pako:eNp9VF1vmzAU_StXfphWKURACBAeqjVJ203aqmlZNWmlD57tJKhgR8a0Y1H--2wMg0TJHpDA99xzzv3Ae0QEZShBjuOknAi-zjZJygFyXItKJcDyl5Q3wXUu3sgWSwXf5wYBcPP-KUULwUuRsxQ9X4HjwD1TK1FJwsqFKArMqT68hrkGrojEu-PYR_3kTOpcS7gwhKu6WAtew4rJ10xjW-Zr4J6O3mGihKzhK5YYJCPVjkksIRclWO5GhskSbDGVxFQYDngHPPo_wQN7Ky-lW4NzU-KRzieumFxjwqxFXys8lucN7Yzir6okOvz47XMJlAEXKiMZ7hW4d1ni6dk2s0X6VnKiJe8rLKmmtXnAOMzny2VbdaABt6-MK2EUWwiRTFfWywbgjOGmrDkBM9GqYBLGhn5qZvIDK7LVJ8MSHnrrVy3JtPFuXJtWzmurNVwEHnabcAZxug58YvjuMk5b05ahDUYmOBjZaZv-AcNLQAuLhyM7WoFhtTnuZtXbiy3BbDCApin4ZACea3p4y6ltVbtKH_ZQbrVQYrZQHbqS-2NS591pMACLilNGu0h4nmZ2TINGaCMzihIlKzZCergFNp9ob_ApUltW6F840a-6ipcUpdzk7DD_KUTRpWnpzRYla5yX-qvaUazYMsMbiXsI0-bkQntUKPHcacOBkj36jRJ_Eo-jOApmgReFgesF_gjVKHH8YDyJ4iD2vdAL_SicHkboTyPrjT3Xm4Z-7PmxO3NDPxghRjP9_36xt1ZzeR3-ArTeiOU)
