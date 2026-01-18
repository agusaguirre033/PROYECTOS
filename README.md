![Logo](https://i.imgur.com/Yp9HcPp.png)

### Grupo 3 - Aguirre Agustina, Graff Francisco, Lucas Natacha, Martinez Mariano.

> ⚠ WIP, iremos actualizando la información a medida que avancemos en el código y podamos redactarla.


# Descripción

En este proyecto estamos desarrollando una aplicación web para la gestión de recursos humanos de una empresa utilizando PHP. Para lograr una organización clara y mantener el código limpio, estructuramos el proyecto en distintas carpetas, cada una de las cuales contiene archivos que gestionan diferentes aspectos del sistema.

# Estructura del proyecto

# config/ config.php

En este archivo se incluyen las credenciales necesarias para el funcionamiento del sistema, con el objetivo de no hardcodearlas y tenerlas en un lugar más apropiado para encontrarlas más rápido.

### Cómo se define un valor

define('<NOMBRE>_<PROPIEDAD>', '<VALOR>');

Ejemplo con el host SMTP

define('EMAIL_HOST', 'smtp.gmail.com');

### Integrando la configuración en otro archivo

* Se incluye el directorio al principio del código PHP:

require_once __DIR__ . '/../config/config.php';

* Ahora directamente se escribe el nombre cuando configuramos un parámetro:

$host = BD_HOST;

Ejemplo con DatabaseService

# controllers/

Los controladores son componentes que actúan como punto de entrada para las peticiones HTTP (y cuando se envían datos) en una aplicación, funcionando como intermediarios entre las vistas y los servicios.

### El controlador también incluye la vista

Las vistas se muestran al usuario gracias a que el archivo index.php llama al controlador.  Entonces cuando sea necesario, se incluye la vista al final de este:

`require BASE_PATH . 'views/auth/forgot_password.php';
`

Ejemplo con el método de recuperarClave

------------
## AdminController.php
Este controlador se encarga de controlar el acceso al panel de administración de la aplicación.
| Método              | Descripción                                                                                                                                                                                                 |
|---------------------|-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `__construct`       | Constructor de la clase `AdminController`. Crea un objeto de la clase `UserModel` y lo asigna a la propiedad privada `$userModel`, permitiendo el acceso a las funciones relacionadas con los usuarios.      |
| `verificaAcceso`    | Verifica la sesión del usuario y sus permisos:                                                                                                                        |
|                     | - Comprueba si hay una sesión activa; si no, redirige a `../login` y termina el script.                                                                                          |
|                     | - Si el usuario es normal (`puesto_id` 0), redirige al dashboard de usuario (`../user/dashboard`) y finaliza el script.                                                                  |
|                     | - Si el usuario no es administrador (`puesto_id` diferente de 1), redirige a `../login` y termina el script.                                                                                  |
| `dashboard`         | Carga el panel de administración:                                                                                                                 |
|                     | - Llama a `verificaAcceso()` para asegurar que el usuario tiene los permisos adecuados.                                                                                                      |
|                     | - Si la verificación es exitosa, incluye la vista del dashboard administrativo (`views/admin/dashboard.php`).                                                                                       |

## AreaController.php

Este archivo contiene la clase AreaController, encargada de gestionar las operaciones relacionadas con las áreas dentro de la organización, incluyendo la administración, modificación, adición y eliminación de registros de áreas. Además, se asegura de que los usuarios tengan el acceso adecuado a las funcionalidades correspondientes.

### Dependencias

Se incluyen los modelos necesarios para la funcionalidad del controlador:

- **AreaModel.php:** Modelo que gestiona las operaciones relacionadas con las áreas.

| Método | Explicación               |
| :-------- | :------------------------- |
| Constructor |  |Se inicializa el modelo de área creando una instancia de AreaModel, permitiendo el acceso a las funciones de gestión de áreas.
| VerificarAcceso | Este método privado verifica si hay una sesión activa y si el usuario tiene los permisos correspondientes. Si no hay sesión activa, redirige al usuario a la página de login. Si el puesto_id del usuario es 0, es redirigido al dashboard. Si el puesto_id no es 1, el usuario es redirigido nuevamente a la página de login. |
| AdministrarArea |  Este método verifica si el usuario tiene acceso y, si es así, obtiene la lista de áreas utilizando el modelo AreaModel. Luego, carga la vista para administrar áreas, pasando la lista de áreas obtenida.|
| ObtenerAreaJSON | Al igual que administrarAreas, este método verifica el acceso del usuario. Devuelve la lista de áreas en formato JSON, útil para llamadas AJAX. Se establece el tipo de contenido a JSON antes de enviar la respuesta al cliente.|
| ActualizarArea |Este método permite actualizar el nombre de una área. Después de verificar el acceso, comprueba si la solicitud es de tipo POST. Si es así, recoge el ID y el nuevo nombre del área desde el formulario. Luego, llama al modelo para realizar la actualización y devuelve un JSON indicando si la operación fue exitosa o si ocurrió un error.  |
| EliminarArea |Verifica primero si el usuario tiene acceso. Luego, comprueba si se ha proporcionado un ID de área a eliminar. Si el ID existe, llama al método correspondiente en el modelo para dar de baja el área. Si la operación es exitosa, no devuelve nada. Si el ID no se proporciona, redirige a la página de administración de áreas.  |
| AltaArea | Este método permite registrar una nueva área. Verifica el acceso y se asegura de que la solicitud sea de tipo POST. Si es así, recoge el nombre de la nueva área y la fecha de alta. Llama al modelo para crear la nueva área, devolviendo un JSON que indica si la operación fue exitosa o si hubo un error. |

# Controlador Beneficio.php

Este archivo contiene la clase BeneficioController, que es responsable de gestionar las operaciones relacionadas con los beneficios de los empleados, incluyendo obtener, crear, actualizar, y eliminar registros de beneficios.

## Dependencias

Se incluyen los modelos necesarios para este controlador:

- **BeneficioModel.php**: Modelo que gestiona las operaciones relacionadas con los beneficios.
- **BeneficioCategoriaModel.php**: Modelo que gestiona las categorías de beneficios.

| Método | Explicación               |
| :-------- | :------------------------- |
| Constructor |Se inicializan las dependencias creando instancias de BeneficioModel y BeneficioCategoriaModel, lo que permite acceder a las funciones que permiten gestionar los beneficios y sus categorías |
| ObtenerBeneficiosJSON | Este método establece el tipo de contenido a JSON y trata de recuperar todos los beneficios desde el modelo BeneficioModel. Si tiene éxito, devuelve un JSON con el estado de éxito y los datos de los beneficios. Si hay un error, devuelve un mensaje de error en formato JSON. |
| ObtenerBeneficioPorId | Establece el tipo de contenido a JSON y verifica si se ha proporcionado un ID. Si no se proporciona, devuelve un mensaje de error. Intenta obtener un beneficio específico usando ese ID. Si se encuentra, devuelve un JSON con el estado de éxito y los datos del beneficio; si no, devuelve un mensaje indicando que no se encontró el beneficio. Maneja errores generando un mensaje en caso de excepción |
| AltaBeneficio | Establece el tipo de contenido a JSON e inspecciona el método de la solicitud, asegurándose de que este sea un POST. Obtiene los datos del beneficio (nombre, descripción, descuento, ID de categoría) desde el formulario y valida que estos sean correctos. Si los datos son válidos, llama al modelo para crear el beneficio y devuelve un JSON indicando si la operación fue exitosa o si hubo un error. |
| ActualizarBeneficio |Este método tiene un funcionamiento similar a altaBeneficio, pero se utiliza para actualizar un beneficio existente. Verifica que la solicitud sea POST y recoge el ID del beneficio junto a sus nuevos datos. Valida los datos y, si son correctos, llama al modelo para realizar la actualización. Devuelve un JSON con el resultado de la operación. |
| EliminarBeneficio |Establece el tipo de contenido a JSON. Verifica que la solicitud sea de tipo POST y que se haya proporcionado un ID. Utiliza este ID para intentar eliminar el beneficio a través del modelo. Devuelve un JSON indicando si la eliminación fue exitosa o si se produjo un error. |
| AdministrarBeneficios | Este método carga la vista manageBenefits.php que permite al administrador gestionar los beneficios disponibles en la aplicación. |
| Beneficios | Carga la vista benefits.php que probablemente se utiliza para mostrar la lista de beneficios a los usuarios, permitiendo interactuar con los beneficios disponibles. |

# CategoriaController.php

Esta clase gestiona las operaciones relacionadas con las categorías de beneficios. Sus métodos permiten obtener, crear, actualizar y eliminar categorías, todo en formato JSON, lo que es útil para aplicaciones que consumen una API.

## Dependencias

- **BeneficioCategoriaModel.php:** Maneja las operaciones en la base de datos relacionadas con las categorías de beneficios.

| Método | Explicación               |
| :-------- | :------------------------- |
|Constructor  |En el constructor se inicializa el modelo BeneficioCategoriaModel, permitiendo al controlador acceder a sus métodos para interactuar con la base de datos.  |
|ObtenerCategoriasJSON  | Establece el tipo de contenido a JSON y trata de recuperar todas las categorías disponibles mediante un método en el modelo BeneficioCategoriaModel. Si tiene éxito, devuelve un JSON indicando el estado de éxito junto con los datos de las categorías. En caso de error, devuelve un mensaje de error en formato JSON.|
| ObtenerCategoriaPorId | Este método establece el tipo de contenido a JSON y verifica si el ID de la categoría se ha proporcionado. Si no hay un ID, devuelve un mensaje de error. Intenta obtener la categoría correspondiente al ID proporcionado. Si la categoría se encuentra, devuelve un JSON con la categoría. Si no se encuentra, devuelve un mensaje indicando que la categoría no existe, además de manejar excepciones posibles.|
| AltaCategoria |Establece el tipo de contenido a JSON y asegura que la solicitud sea de tipo POST. Recoge los datos del formulario (nombre y descripción de la categoría), valida que sean correctos (nombre mínimo 3 caracteres y descripción mínima 10). Si los datos son válidos, invoca el método crear del modelo para registrar la nueva categoría y devuelve un JSON con el resultado de la operación. |
|ActualizarCategoria |Este método tiene un funcionamiento similar a altaCategoria, pero se utiliza para actualizar una categoría existente. Verifica que la solicitud sea POST, recoge el ID y los nuevos datos (nombre y descripción) y valida su formato. Si los datos son válidos, llama al modelo para realizar la actualización y devuelve un JSON con el resultado.  |
|eliminarCategoria  | Establece el tipo de contenido a JSON y verifica que la solicitud sea de tipo POST. Comprueba que se ha proporcionado un ID para eliminar la categoría. Utiliza este ID para llamar al método eliminar del modelo. Devuelve un JSON indicando si la eliminación fue exitosa o si ocurrió algún error, manejando excepciones adecuadamente. |



## AuthController.php
Este archivo contiene la clase AuthController, que es responsable de gestionar la autenticación de usuarios, incluyendo el registro, inicio de sesión y recuperación de contraseñas. 

### Dependencias

Se incluyen los modelos y servicios necesarios para la funcionalidad del controlador:
- User.php: Modelo que gestiona las operaciones relacionadas con los usuarios.
- EmailService.php: Servicio que se encarga de enviar correos electrónicos.

| Método | Explicación               |
| :-------- | :------------------------- |
| Constructor | Se inicializan las dependencias creando instancias de User y EmailService. |
| registro | Gestiona el registro de nuevos usuarios. Verifica si la solicitud es de tipo POST para recibir datos del formulario. Valida la contraseña utilizando el método validarClave y comprueba que las contraseñas coincidan. Hashea la contraseña antes de guardarla en la base de datos. Llama al modelo User para crear el nuevo usuario y, si el registro es exitoso, inicia una sesión y redirige al usuario al dashboard. |
| validarClave | Utiliza una expresión regular para validar que la contraseña cumpla con ciertos requisitos (mínimo de 8 caracteres, al menos una mayúscula, un número y un carácter especial). |
| iniciarSesion | Gestiona el inicio de sesión de usuarios. Verifica las credenciales del usuario utilizando el DNI y la contraseña. Si las credenciales son correctas, crea una sesión y redirige al usuario al dashboard que le corresponda (empleado o admin). |
| recuperarClave | Permite a los usuarios recuperar su contraseña. Busca al usuario por su correo electrónico y, si existe, genera un token de restablecimiento de contraseña que se envía por correo. Si el proceso es exitoso, redirige al usuario a una página de confirmación (se utiliza la misma pero agregando ?success al link para mostrarlo) |
| restablecerClave | Permite a los usuarios restablecer su contraseña utilizando un token que se envió por correo (no explicitamente, si no que lo tiene el link que se envia, en el formato reset_password?token=<EL TOKEN>). Verifica la validez del token y, si es válido, permite al usuario establecer una nueva contraseña. Si la nueva contraseña cumple con los requisitos, se actualiza en la base de datos y se elimina el token. |
| cerrarSesion | Permite a los usuarios cerrar sesión, destruyendo la sesión actual y redirigiendo al usuario a la página de inicio de sesión. |

# EmpleadoController.php

Este archivo contiene la clase EmpleadoController, que es responsable de gestionar las operaciones relacionadas con los empleados, como administrar, modificar, añadir y eliminar registros de empleados. También verifica el acceso de los usuarios a las funcionalidades correspondientes.

## Dependencias

Se incluyen los modelos y controladores necesarios para la funcionalidad del controlador:

- *EmpleadoModel.php*: Modelo que gestiona las  operaciones relacionadas con los empleados.
- *AreaModel.php*: Modelo que gestiona las áreas dentro de la empresa.
- *AdminController.php:* Controlador que gestiona las funciones administrativas relacionadas con la administración.

| Método | Explicación               |
| :-------- | :------------------------- |
| Constructor |Se inicializan las dependencias creando instancias de empleadoModel, AreaModel y AdminController. |
|  VerificarAcceso | Este método verifica si hay una sesión activa y si el usuario tiene acceso a las funciones del controlador. Redirige a la página de login si no hay sesión o si el usuario no tiene los permisos necesarios.. |
| AdministrarEmpleado |Verifica el acceso del usuario y obtiene la lista de empleados mediante el modelo empleadoModel, luego carga la vista para administrar empleados pasándole la lista. |
| ObtenerEmpleadoJSON |Similar al método anterior, pero este devuelve el listado de empleados en formato JSON, útil para llamadas Ajax. Establece el tipo de contenido a JSON antes de devolver la respuesta. |
| ModificarEmpleado |Verifica el acceso y busca un empleado por su DNI pasado como parámetro en la URL. Si encuentra al empleado, carga la vista correspondiente para modificar sus datos; si no, redirige a la página de administración. |
| ActualizarEmplado |Este método se encarga de actualizar la información de un empleado. Verifica que la solicitud sea de tipo POST, recoge los datos del formulario y llama al modelo para realizar la actualización. Si es exitoso, redirige a la página de administración con un mensaje de éxito. |
| EliminarEmpleado |Verifica el acceso y busca al empleado por DNI. Si se encuentra, llama al modelo para dar de baja al empleado. Redirige con un mensaje de confirmación si es exitoso. Si no se proporciona el DNI, redirige a la página de administrar empleados. |
| AltaEmpleado |Permite registrar un nuevo empleado. Este método también comprueba que la solicitud sea POST, recoge los datos del formulario y llama al modelo para añadir al nuevo empleado. Devuelve un JSON indicando el resultado de la operación, ya sea de error o éxito. |
| Obtener AreasJSON |Recupera la lista de áreas disponibles mediante AreaModel, establece el tipo de contenido a JSON y devuelve la lista en formato JSON. Utilizado para alimentar combinaciones o listas en frontend. |

## IndexController.php

| Método | Explicación               |
| :-------- | :------------------------- |
| landing | Envía la vista de la página principal. |

# Controlador PerfilController.php

Esta clase se encarga de gestionar el perfil del usuario en la aplicación, permitiendo tanto la obtención de datos como la actualización de la información del perfil.

##Dependencias

- **UserModel.php**: Este modelo se utiliza para interactuar con la base de datos y realizar operaciones relacionadas con los usuarios, como buscar o actualizar información.

| Método            | Explicación                                                                                                                                                                                                 |
|-------------------|-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| Constructor        | El constructor inicializa el modelo `UserModel`, lo que permite al controlador acceder a sus métodos para realizar operaciones en la base de datos relacionadas con los usuarios.                          |
| ObtenerPerfil      | - Verifica si el usuario está autenticado comprobando la existencia de un DNI (Documento Nacional de Identidad) almacenado en la sesión. <br> - Si no hay DNI, devuelve un JSON indicando que el usuario no está autenticado y termina la ejecución. <br> - Si el usuario está autenticado, intenta buscar la información del usuario en la base de datos usando el método `buscarPorDNI` del modelo. <br> - Si se encuentra al usuario, se prepara un JSON con los datos del perfil, asegurándose de sanitizar cada campo para prevenir problemas de seguridad como XSS (Cross-Site Scripting). <br> - Si no se encuentra al usuario o hay un error en la búsqueda, se lanza una excepción que gestiona un mensaje de error apropiado. <br> - Finalmente, devuelve un JSON con la información del perfil o un mensaje de error en caso de fallo. |
| ActualizarPerfil   | - Al igual que `ObtenerPerfil`, este método comienza verificando si el usuario está autenticado mediante la comprobación del DNI en la sesión. <br> - Si el usuario no está autenticado, devuelve un JSON correspondiente y finaliza la ejecución. <br> - Se recogen y sanitizan los datos de entrada desde el formulario (nombre, apellido, email, fecha de nacimiento) usando `filter_input`. <br> - Si faltan campos obligatorios, se lanza una excepción con un mensaje de error correspondiente. <br> - Luego, valida que el email tenga un formato correcto y verifica si el email ya está registrado por otro usuario, lo que también lanza una excepción en caso afirmativo. <br> - Si todas las validaciones son aprobadas, se prepara un arreglo con los nuevos datos y se llama al método `actualizarPerfil` del modelo, que realiza la actualización en la base de datos. <br> - Si la actualización tiene éxito, se actualizan también los datos en la sesión y se genera un JSON confirmando la actualización. Si ocurre un error durante el proceso de actualización, se lanza una excepción y se devuelve un mensaje de error. |

 ## UserController.php

Este controlador se encarga del control de acceso al dashboard de la aplicación.

| Método | Explicación               |
| :-------- | :------------------------- |
| dashboard | Este método verifica si existe una sesión activa para el usuario a través de la variable de sesión user_id. Si la variable de sesión no está establecida, redirige al usuario a la página de inicio de sesión (/login) y termina el script con exit(). Si la sesión es válida, se incluye la vista del dashboard (views/user/dashboard.php), proporcionando así acceso al panel. (TODO: Nos falta por hacer la diferenciación entre Usuario y Admin) |

# Controlador VacationController.php

Este controlador se encarga de manejar las operaciones relacionadas con las solicitudes de vacaciones, incluyendo la gestión de solicitudes por parte de administradores y usuarios.

## Dependencias

- **VacationModel.php:** Modelo utilizado para interactuar con la base de datos y realizar operaciones relacionadas con las vacaciones.
- **EmailService.php:** Servicio utilizado para enviar correos electrónicos, probablemente para notificar a los usuarios sobre el estado de sus solicitudes.

| Método               | Explicación                                                                                                                                                                                                 |
|----------------------|-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| Constructor          | El constructor inicializa las dependencias necesarias: `VacationModel` y `EmailService`, lo que permite al controlador realizar operaciones sobre las vacaciones y enviar correos electrónicos.          |
| RedirigirDashboard    | - Redirige al usuario a su dashboard correspondiente según su puesto.  <br> - Comprueba si hay un `user_id` en la sesión para determinar si el usuario está autenticado.  <br> - Si el usuario es un administrador (`puesto_id == 1`), se redirige a `admin/dashboard`; de lo contrario, se redirige a `user/dashboard`.  <br> - Se llama a `exit()` para finalizar la ejecución después de la redirección. |
| ManageVacations      | - Carga la vista para que los administradores gestionen las solicitudes de vacaciones.  <br> - Simplemente incluye el archivo de vista correspondiente.                                                  |
| MisVacaciones        | - Gestiona la visualización de las vacaciones del usuario.  <br> - Comprueba si el `user_id` está presente en la sesión; si no, redirige al usuario a la página de inicio de sesión.  <br> - Si el usuario está autenticado, carga la vista donde se muestran sus vacaciones. |
| SolicitarVacacion   | - Maneja las solicitudes de vacaciones enviadas mediante un formulario POST.  <br> - Inicializa un arreglo de respuesta con un estado de error.  <br> - Intenta validar los campos obligatorios (`usuario_id`, `fecha_inicio`, `fecha_fin`). Si alguno está vacío, lanza una excepción.  <br> - Convierte las fechas de inicio y fin en objetos `DateTime` para facilitar la manipulación y comparación.  <br> - Realiza varias validaciones:  <br>   - **Anticipación**: Verifica que la solicitud se realice al menos 30 días antes de la fecha de inicio.  <br>   - **Fechas**: Asegura que la fecha de fin sea posterior a la de inicio.  <br>   - **Superposición**: Verifica que no haya más de dos empleados con vacaciones aprobadas en el mismo período utilizando el método `contarVacacionesEnPeriodo` del modelo.  <br> - Si todas las validaciones son correctas, intenta crear la solicitud de vacaciones mediante el método `crearVacacion`. Si se crea correctamente, se actualiza la respuesta a éxito y se programan tareas para verificar el estado de la solicitud y enviar un correo si la solicitud sigue pendiente después de 30 días.  <br> - Si ocurre un error en cualquier parte del proceso, se captura la excepción y se actualiza el mensaje de error en la respuesta.  <br> - Finalmente, se envía la respuesta en formato JSON. |


# libs/

En este directorio incluimos los archivos de las librerias que necesitamos.

------------

## Mailer

Se incluye el repositorio completo de Mailer, obtenido desde el proyecto del profesor.

# models/

Los modelos gestionan operaciones relacionadas con su nombre. Se usan querys (consultas) a la base de datos para realizar las operaciones.

### Cómo se realiza una operación

        $sql = "<QUERY>";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($data);

* $sql : Se incluye la consulta SQL en formato string.
* $stmt = $this->db->prepare($sql) : 
$this->db es la conexión a la base de datos.
prepare($sql) prepara la consulta SQL para su ejecución.
$stmt (que significa statement/declaración) almacena la consulta preparada.
* $stmt->execute($data) : $data es un array asociativo que contiene los valores reales.

Por último, según el método se agrega un valor a devolver según sea necesario.
Por ejemplo en CrearUsuario se devuelve el ID del usuario (el que se generó automáticamente para la nueva fila):

return $this->db->lastInsertId()

------------


# AreaModel.php

La clase AreaModel facilita la interacción entre la aplicación y la base de datos para gestionar las áreas. Encapsula la lógica de acceso a la tabla areas, simplificando las operaciones de consulta y manipulación de datos.

| Método | Explicación               |
| :-------- | :------------------------- |
| Construct | Inicializa la conexión a la base de datos al instante de crear un objeto AreaModel, utilizando el singleton Database. |
| ObtenerAreas |Recupera todas las áreas que no están dadas de baja (donde fecha_baja es NULL). Ordena los resultados por el nombre del área y retorna un array asociativo.  |
| ObtenerAreaJson |Similar a obtenerAreas(), pero este método recupera solo el ID y el nombre de las áreas, retornando el resultado en formato JSON, útil para solicitudes AJAX. |
| BuscarPorId | Busca un área específica en la base de datos utilizando el ID proporcionado. Si encuentra el área, retorna los detalles como un array asociativo. |
| AltaArea | Permite agregar un nuevo área a la base de datos. Recibe un array $data con el nombre del área y registra la fecha de alta. Retorna true en caso de éxito, o un mensaje de error en caso de fallo. |
| ActualizarArea | Actualiza el nombre de un área existente. Recibe un array $data que incluye el ID y el nuevo nombre del área. Retorna true si la actualización es exitosa. |
| EfectuarBaja | Marca un área como dada de baja al establecer fecha_baja a la fecha y hora actuales y elimina la fecha_alta. Retorna true si la operación fue exitosa.  |

## Detalles Adicionales

- **Manejo de Excepciones:** Los métodos altaArea() y obtenerAreas() cuentan con manejo de excepciones para capturar errores durante la ejecución de las consultas SQL, lo que mejora la robustez del modelo.
**
- Uso de PDO:** Se utiliza PDO (PHP Data Objects) para ejecutar las consultas, lo que proporciona una forma segura y flexible de interactuar con la base de datos, preparándolas para prevenir inyecciones SQL.

-** Formato de Fecha:** En varios métodos, se utiliza date('Y-m-d H:i:s') para registrar la fecha y hora actuales, asegurando que se guarda información temporal precisa en la base de datos.

# # BeneficioCategoriaModel.php

La clase BeneficioCategoriaModel actúa como intermediario entre la aplicación y la base de datos para gestionar las categorías de beneficios. Facilita las operaciones CRUD (crear, leer, actualizar y eliminar) sobre la tabla categorias.

| Método | Explicación               |
| :-------- | :------------------------- |
| Constructor | Inicializa la conexión a la base de datos mediante el singleton Database.  |
| ObtenerTodas | Recupera todas las categorías que no están dadas de baja (fecha_baja es NULL) y retorna un array asociativo con el resultado. |
| ObtenerPorId | Busca una categoría específica según su ID, retornando los detalles si la categoría existe y no está dada de baja.  |
| Crear |  Agrega una nueva categoría a la base de datos con el nombre y la descripción proporcionados. Registra la fecha de alta en el proceso. Retorna true en caso de éxito. |
| Actualizar | Actualiza los campos nombre y descripcion de una categoría existente, identificada por su ID. Retorna true si la operación se realiza exitosamente. |
| Eliminar | Marca una categoría como dada de baja al actualizar su fecha_baja con la fecha y hora actuales. Retorna true si la operación se realiza exitosamente.  |

## BeneficioModel.php

La clase BeneficioModel gestiona las operaciones relacionadas con los beneficios en la base de datos. Permite realizar acciones CRUD sobre la tabla beneficios, incluyendo la relación con las categorías.

| Método | Explicación               |
| :-------- | :------------------------- |
| Constructor | Inicializa la conexión a la base de datos utilizando el singleton Database. |
| Obtener Todos | Recupera todos los beneficios que no están dados de baja (fecha_baja es NULL) y también incluye el nombre de la categoría asociada, retornando un array asociativo. |
| ObtenerPorId | Busca un beneficio específico según su ID, retornando sus detalles si existe y no está dado de baja. |
| Crear | Agrega un nuevo beneficio a la base de datos con los parámetros proporcionados (nombre, descripción, descuento y categoría). Registra la fecha de alta. Retorna true si se crea con éxito. |
| Actualizar | Actualiza los campos de un beneficio existente, identificándolo por su ID. Retorna true si la actualización es exitosa. |
| Eliminar | Marca un beneficio como dado de baja al actualizar su fecha_baja con la fecha y hora actuales. Retorna true si la operación se realiza correctamente. |

## BeneficioUsuarioModel.php

La clase BeneficioUsuarioModel maneja la relación entre usuarios y beneficios en la base de datos, permitiendo gestionar las solicitudes de beneficios por parte de los usuarios.

| Método | Explicación               |
| :-------- | :------------------------- |
| Constructor | Inicializa la conexión a la base de datos utilizando el singleton Database. |
| Obtener PorUsuario | Recupera todos los beneficios solicitados por un usuario específico, obteniendo también el nombre del beneficio. Retorna un array asociativo con los resultados. |
| SolicitarBeneficio |Inserta una nueva solicitud de beneficio por parte de un usuario, registrando la fecha en que se solicitó. Retorna true si la operación es exitosa.  |

## EmpleadoModel.php

Este archivo contiene la clase EmpleadoModel, que es responsable de gestionar las operaciones relacionadas con los empleados en la base de datos. Estas operaciones incluyen la búsqueda, listado, actualización, eliminación (baja) y alta de empleados.

**Dependencias **

Se incluye la clase que gestiona la conexión a la base de datos, que generalmente se encuentra en un archivo Database.php.

| Método | Explicación               |
| :-------- | :------------------------- |
| Constructor | Inicializa la conexión a la base de datos mediante la llamada a Database::getInstance()->getConnection(), asegurándose de que la clase tenga acceso a la conexión necesaria para realizar consultas. |
| BuscarPorDNI | Este método busca un empleado en la base de datos utilizando su DNI. Realiza una consulta SQL que selecciona todos los campos de la tabla usuarios donde el dni coincide y donde el puesto_id es igual a 0 (indicando que es un empleado, no un administrador). Devuelve un solo registro asociado con el DNI dado. |
| ListarEmpleados |Recupera una lista de empleados desde la base de datos. Realiza una consulta SQL que une las tablas usuarios y areas, seleccionando información del empleado (DNI, nombre, apellido, email, fecha de nacimiento) junto con el área a la que pertenece. Solo selecciona aquellos empleados que no tienen un puesto_id distinto de 0 y que no tienen fecha de baja (no están inactivos). Devuelve todos los registros en forma de array asociativo.  |
| ActualizarEmpleados |  Este método se encarga de actualizar la información de un empleado en la base de datos. Utiliza una consulta SQL para modificar los campos de un empleado basándose en el DNI proporcionado en el array de datos. Retorna true en caso de éxito o false en caso contrario. |
| EjecutarBaja |  Permite dar de baja a un empleado especificando su DNI. Actualiza la fecha de baja en la base de datos estableciéndola al momento actual (usando NOW()). Retorna true si la operación se ha completado correctamente o false si hay un error. |
| AltaEmpleado |Este método agrega un nuevo empleado a la base de datos. Utiliza una instrucción SQL INSERT para añadir un nuevo registro en la tabla usuarios. Si se produce una excepción, verifica el código de error para determinar si el DNI ya existe y devuelve un mensaje de error correspondiente. Caso contrario, si la inserción es exitosa, retorna true.  |


## UserModel.php

La clase UserModel actúa como un intermediario entre la aplicación y la base de datos para todo lo relacionado con los usuarios. 
Encapsula la lógica de acceso a la tabla usuarios de la base de datos, ocultando la complejidad de las consultas SQL.

| Método | Explicación               |
| :-------- | :------------------------- |
| crearUsuario($data) | Este método crea un nuevo usuario en la base de datos. Recibe un array $data con la información del nuevo usuario (DNI, clave, nombre, apellido, etc) y ejecuta una consulta INSERT para agregar el usuario a la tabla usuarios.  |
| buscarPorDNI($dni) |  Busca un usuario en la base de datos por su DNI. Recibe el DNI como parámetro y ejecuta una consulta SELECT para obtener la información del usuario. |
| buscarPorEmail($email) |  Busca un usuario en la base de datos por su correo electrónico. Recibe el correo electrónico como parámetro y ejecuta una consulta SELECT para obtener la información del usuario. |
| actualizarToken($userId, $token, $expiry) | Actualiza el token de restablecimiento de contraseña de un usuario. Recibe el ID del usuario, el token y la fecha de expiración del token como parámetros y ejecuta una consulta UPDATE para modificar el registro del usuario. |
| buscarPorToken($token) |  Busca un usuario en la base de datos por su token de restablecimiento de contraseña. Recibe el token como parámetro y ejecuta una consulta SELECT para obtener la información del usuario. |
| actualizarClave($userId, $hashedPassword): |  Actualiza la contraseña de un usuario. Recibe el ID del usuario y la contraseña encriptada como parámetros y ejecuta una consulta UPDATE para modificar el registro del usuario. |
| limpiarToken($userId) |  Limpia el token de restablecimiento de contraseña y su fecha de expiración de un usuario. Recibe el ID del usuario como parámetro y ejecuta una consulta UPDATE para modificar el registro del usuario. |

## VacationModel.php

La clase VacationModel maneja todas las interacciones con la tabla vacaciones en la base de datos, permitiendo gestionar las solicitudes de vacaciones de los usuarios.

| Método | Explicación               |
| :-------- | :------------------------- |
| Constructor | Inicializa la conexión a la base de datos utilizando el singleton Database. |
| CrearVacaciones | Inserta una nueva solicitud de vacaciones, registrando la fecha de solicitud y estableciendo el estado inicial como "Pendiente". Retorna el ID de la nueva solicitud. |
| ObtenerVacaciones | Recupera todas las vacaciones disponibles, unidas a su estado, ordenadas por fecha de solicitud en orden descendente. Retorna un array asociativo. |
| ObtenerVacacionesJSON |  Similar a obtenerVacaciones(), pero también incluye el nombre y apellido del usuario, así como el motivo de rechazo. Retorna un array en formato asociativo. |
| ObtenerPorUsuarioId |  Obtiene todas las vacaciones solicitadas por un usuario específico, incluyendo estado y datos de usuario. Retorna un array asociativo de los resultados. |
| ObtenerPorId | Recupera los detalles de una solicitud de vacaciones específica utilizando su ID. Retorna la información asociativa correspondiente. |
| ActualizarEstado | Actualiza el estado de una solicitud de vacaciones según su ID. Retorna true si la actualización es exitosa. |
| EliminarVacaciones |Elimina una solicitud de vacaciones de la base de datos mediante su ID. Retorna true si la eliminación tiene éxito. |
| ActualizarEstadoConMotivo | Actualiza el estado de la solicitud de vacaciones y, opcionalmente, agrega un motivo de rechazo. Retorna true si la operación es exitosa. |
| ContarVacacionesEnPeriodo | Cuenta la cantidad de vacaciones que caen dentro de un periodo específico, excluyendo un usuario si se proporciona su ID. Retorna el conteo total. |



# public/

En esta carpeta incluimos todos los archivos que requieren las vistas:

## js/

Acá escribimos todo el código JavaScript. En todas las páginas lo usamos para mostrar la precarga y en el momento que el navegador cargue todos los recursos, mostrar la página al usuario.

### auth-script.js

Se usa en todas las páginas de autenticación. Tiene tres funciones más:

* Para comprobar y actualizar los estados de los requisitos de la contraseña.
* Para actualizar el texto del botón cuando se clicea según la opción. Por ejemplo, al clicear 'Solicitar correo' muestre 'Solicitando correo' para indicarle al usuario que se está ejecutando la acción y no tenga que clicear de nuevo.
* Para cambiar el atributo 'text' a 'password' y viceversa (ojito en los campos de contraseña)

### index-script.js

Por ahora se utiliza en la página principal. Tiene una función más:

* Para la animación del header cuando hay scroll. Se cambia la clase del header 'header' a 'header .scrolled'

## css/

Incluimos todos los estilos de las páginas. Muchas páginas comparten un solo CSS para simplificar la estructura y para que compartan la misma apariencia. Por ejemplo, 'auth-style.css' en todas las páginas de autenticación.

## media/ 

Dónde se guardan todos los archivos multimedia (imagenes, videos, audios) que utilizan las páginas.

## index.php

Este archivo es el punto de entrada principal de la app. Se encarga de gestionar la lógica de enrutamiento y de llamar a los controladores adecuados para cada acción del usuario (Como comentamos anteriormente, los controladores incluyen la vista)
1. Inicio de sesión y definición de rutas:
session_start() : Inicia la sesión del usuario, permitiendo almacenar información del usuario durante la navegación.
define ('BASE_PATH', dirname(__DIR__) . DIRECTORY_SEPARATOR); : Define una constante BASE_PATH para la ruta base del proyecto. Esto facilita la inclusión de archivos desde diferentes directorios. 

2. Obtención de la acción del usuario:
$action = $_GET['action'] ?? 'login'; : Obtiene la acción del usuario desde la URL mediante la variable $_GET['action']. Si la acción no está definida, se establece por defecto como login.

3. Enrutamiento según la acción:
switch ($action) : El código usa un switch para ejecutar el controlador adecuado según la acción del usuario.
case 'register', case 'login', ... : Cada caso del switch corresponde a una acción específica y llama al método correspondiente del controlador AuthController o UserController.
default: : Si la acción no coincide con ninguna de las opciones del switch, se ejecuta el método iniciarSesion() del controlador AuthController por defecto.

## .htaccess

Es el archivo que se encarga de establecer la ruta de la aplicación.

	RewriteEngine On
	RewriteBase /appweb_cs_2c_2024/GRUPO3/proyecto_rrhh/public/
	RewriteCond %{REQUEST_FILENAME} !-f
	RewriteCond %{REQUEST_FILENAME} !-d
	RewriteRule ^(.*)$ index.php?action=$1 [L,QSA]

* RewriteEngine On: Activa el módulo de reescritura de URLs de Apache, que permite que las reglas de reescritura sean aplicadas.

* RewriteBase /appweb_cs_2c_2024/GRUPO3/proyecto_rrhh/public/: Establece la URL base de la aplicación.

* RewriteCond %{REQUEST_FILENAME} !-f:  Condición que verifica si la solicitud NO es un archivo existente. Si el archivo solicitado no existe (!-f), entonces se ejecuta la regla que sigue. Esto ayuda a evitar que se reescriban solicitudes para archivos que ya están disponibles en el servidor.

* RewriteCond %{REQUEST_FILENAME} !-d: Esta condición comprueba si la solicitud NO es un directorio existente. Si la solicitud no apunta a un directorio válido (!-d), entonces se aplicará la regla de reescritura. Esto previene la reescritura de rutas que ya corresponden a directorios en el servidor.


* RewriteRule ^(.*)$ index.php?action=$1 [L,QSA]: Esta línea define la regla de reescritura, que se activa si se cumplen las condiciones anteriores.

	^(.*)$ significa "captura cualquier cadena de caracteres de la URL" y la almacena en $1.
	index.php?action=$1 indica que cualquier URL que no sea un archivo o directorio existente será redirigida a index.php, pasando 	la parte capturada de la URL como un parámetro action. Por ejemplo, si la URL es /login, se reescribirá a index.php?action=login.
	`[L,QSA] `son flags:
	L indica que esta es la última regla a procesar, por lo que no se aplicarán más reglas si esta coincide.
	`QSA (Query String Append) `significa que cualquier cadena de consulta existente (lo que va después de ? en la URL) se añadirá a la nueva URL reescrita.

# services/

Los servicios brindan una función especifica a la aplicación cuando sea necesario. 

## Cómo implementarlo en otro archivo
Primero se incluye la ruta al principio del código PHP. Por ejemplo con EmailService:
require_once BASE_PATH . 'services/EmailService.php';

Luego se crea una instancia para iniciar el servicio dentro del método constructor:
$this->emailService = new EmailService();

Listo, el servicio ya estaría disponible para su uso.

------------

## DatabaseService.php

Servicio que gestiona la conexión a la base de datos para la aplicación.

### Singleton
Esta clase usa el patrón Singleton para asegurar que solo exista una instancia de la conexión a la base de datos. Esto es útil para evitar múltiples conexiones innecesarias y optimizar el uso de recursos.


| Propiedad | Explicación               |
| :-------- | :------------------------- |
| private static $instance | Almacena la única instancia de la clase. |
| private $conn | Almacena la conexión a la BD. |
| Método constructor (__construct) | Configura los parámetros necesarios para la conexión a la base de datos, incluyendo el host, nombre de la base de datos, usuario y contraseña. Intenta establecer una conexión utilizando PDO (PHP Data Objects), que es una interfaz de acceso a datos segura y flexible. Si ocurre un error durante la conexión, se lanza una excepción que se maneja mostrando un mensaje de error. |
| Método getInstance | Comprueba si ya existe una instancia de la DB. Si no, crea una nueva. Esto permite controlar el acceso y no abrir más de una conexión. |
| Método getConnection | Devuelve la conexión a la base de datos, permitiendo que otros componentes de la app interactúen con esta para realizar consultas. |

## EmailService.php

Servicio que se encarga de enviar correos electrónicos usando la libreria Mailer para PHP.

### Implementar Mailer en el servicio

Primero se incluyen las rutas al principio del archivo:

include(BASE_PATH."/libs/Mailer/src/PHPMailer.php");

include(BASE_PATH."/libs/Mailer/src/SMTP.php");

include(BASE_PATH."/libs/Mailer/src/Exception.php");

Luego importamos la clase principal y la de excepción en caso de errores:

use PHPMailer\PHPMailer\PHPMailer;

use PHPMailer\PHPMailer\Exception;

### Método constructor

En este método se inicializa Mailer y se configura, obteniendo las credenciales del archivo config.php:

        $this->mailer = new PHPMailer(true);
        $this->mailer->isSMTP();
        $this->mailer->SMTPAuth = true;
        $this->mailer->Host = EMAIL_HOST;
        $this->mailer->Port = EMAIL_PUERTO;
        $this->mailer->Username = EMAIL_MAIL;
        $this->mailer->Password = EMAIL_CLAVE;
        $this->mailer->SMTPSecure = EMAIL_CERTIFICADO;
        $this->mailer->CharSet = 'UTF-8'; 

CharSet se establece a UTF-8 para poder enviar mensajes con tildes y Ñ.

## Método para enviar un correo
El método siempre tiene que tener al menos como atributo el correo electrónico destinatario para poder obtenerlo. 
Se usa la estructura try y catch, para exceptuar el error en caso de que ocurra (por ejemplo si las credenciales no funcionan)

#### try

* Primero se configura el remitente, el destinatario, el formato HTML para poder usar sus etiquetas y el título del correo.

            $this->mailer->setFrom('recursoshumanos.noresponder@gmail.com', 'Recursos Humanos');
            $this->mailer->addAddress($email);
            $this->mailer->isHTML(true);
            $this->mailer->Subject = 'Recuperá tu contraseña';
			

* Establecemos el cuerpo usando etiquetas HTML:

            $this->mailer->Body = "
                <h2>Mensaje de ejemplo</h2>
                <p>Hola, este es un mensaje de ejemplo para el README.</p>
            ";

* Enviamos el correo:

            $this->mailer->send();
            return true; // Devolvemos true para hacerle saber al sistema que se envió el correo

#### catch

* Si ocurrió algún error lo registramos y devolvemos false.

            error_log("Ocurrió un error al enviar el correo: " . $this->mailer->ErrorInfo);
            return false;

# views/

En esta carpeta se incluyen las páginas HTML.

### Librerias utilizadas

Se importan en el header.
* FontAwesome: <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
* Canvas-Confetti: <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>
* DataTables:      <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    `<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
`
* SweetAlert2:     
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
### Página de ejemplo

1. Estructura HTML
El código comienza con <!DOCTYPE html>, que define que es un documento HTML.
La etiqueta <html> incluye atributos para el idioma (lang="es") y la dirección del texto` (dir="ltr") `para texto de izquierda a derecha).
2. Encabezado  <head>
Define la codificación de caracteres como` UTF-8` y establece una vista adaptable con <meta name="viewport">.
Incluye las librerias y el archivo .css de los estilos.
3.  Cuerpo de la página <body>
Contiene un div de precarga (#precarga), que muestra un ícono animado (lo animamos con una propiedad de FontAwesome) que indica que se carga la página. El <div class="container"> es el contenedor principal que agrupa todo el contenido. El JS se encarga de ocultar la precarga y mostrar el container (contenido principal) cuando el navegador cargue los recursos de la página.
4. Encabezado
Se utiliza una referencia condicional con PHP para determinar algunos puntos (por ejemplo en la página de register si el link termina con ?success, se muestra la confirmación de registro en vez del formulario)
6. Scripts
En <script></script,> se incluye la ruta al archivo JS que contiene funciones JavaScript para manejar la interacción del usuario con la página (verificaciones, pantalla de carga, otras animaciones...)

## Notas adicionales

1. Para encriptar las contraseñas usamos la función propia de PHP password_hash en vez de crear una para eso. 
2. En el sistema de recuperar contraseña en vez de crear una contraseña temporal nueva y enviarsela por mail, lo cambiamos por un token.
Al pedir un cambio de contraseña, se genera un token nuevo con la función `bin2ex ` (para obtener una cadena de carácteres aleatoria y segura, no predecible) y la guardamos en la columna reset_token en la tabla usuarios. A su vez, también guardamos la fecha de expiración en la tabla reset_token_expiry, que se establece a 6 horas después de su creación. 
Al usuario se le envía un correo con un link para restablecer su contraseña, con el link de la página y concatenado por su token. No se escribe el token en el correo, ya viene establecido en el link (/resetPassword?token=<EL TOKEN>), así cuando el usuario entra no tiene que escribir nada extra o autenticarse de otra manera. El sistema busca al usuario por token y si coincide le permite cambiar su contraseña. También con este sistema evitamos que al enviar el correo se cambie inmediatamente la contraseña e interrumpir el acceso por si el que pide el correo no es el dueño de la cuenta, tema comentado en la clase del 19/10.
3. Al crear/modificar la contraseña, implementamos requisitos de validación con expresiones regulares (el regex está comentado en el código). Los requerimientos para crear la contraseña son:
	* Al menos 8 carácteres
	* Al menos una letra minúscula
	* Al menos una letra mayúscula
	* Al menos un número
	* Al menos un carácter especial (@$!%*?&, etc)

# Fuentes

#### Frontend
* Plantilla para el login: https://www.codingnepalweb.com/free-login-registration-form-html-css/
* https://www.youtube.com/watch?v=okbByPWS1Xc&list=PLImJ3umGjxdDqTlZhQxXBeGij9Oa9Xjnj
* Diseño de un proyecto API/WEB que realizamos para otra materia.
* https://www.bonda.com/es-ar/plataforma
* https://somosrecursoshumanos.com.ar/
* https://freefrontend.com/

Para la creación del logo:
* https://www.canva.com/ 
* https://www.photopea.com/
* https://imagecolorpicker.com/

Fuente de letra: https://fonts.google.com/specimen/Poppins

#### Código
* https://stackoverflow.com/questions/3319434/singleton-pattern
* https://github.com/juanPabloCesarini/appweb_cs_2c_2024/tree/main/00-Profe/proyecto_tareas
* https://github.com/juanPabloCesarini/appweb_cs_2c_2024/tree/main/00-Profe/proyecto_tareas/app/external/Mailer
* https://newwavenewthinking.wordpress.com/miscellaneous/mvc-simple-mvc-base-login-form-in-php/
* https://www.php.net/manual/en/function.password-hash.php
* https://stackoverflow.com/questions/30279321/how-to-use-phps-password-hash-to-hash-and-verify-passwords
* https://stackoverflow.com
* https://phptherightway.com/
* https://dev.to/themodernweb/here-is-how-i-made-a-strong-password-checker-using-javascript-3m9o
* https://stackoverflow.com/questions/46304334/form-security-token-csrf-why-use-bin2hex-in-bin2hexrandom-bytes32
* https://stackoverflow.com/questions/19605150/regex-for-password-must-contain-at-least-eight-characters-at-least-one-number-a
* https://cheatsheetseries.owasp.org/cheatsheets/Forgot_Password_Cheat_Sheet.html#url-tokens
https://sweetalert2.github.io/#examples
https://es.stackoverflow.com/questions/389517/cargar-datatable-con-ajax
* Código JS de una API/WEB que realizamos para otra materia.
* El concepto Token lo vimos en Programación.
* El concepto Singleton lo vimos en Java.

#### Librerias JavaScript

* https://fontawesome.com/
* https://sweetalert2.github.io/
* https://datatables.net/

Para la realización del readme:
* https://pandao.github.io/editor.md 
* Letra del título: https://www.dafont.com/es/gelato.font
