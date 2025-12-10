# agenda-citas
Aplicacion para gestionar la reservacion de citas en salones de belleza.

## Requisitos
- PHP = 8.4
- Base de datos:
-- PostgreSQL = 17.5
- Composer (para gestión de dependencias)

## Caracteristicas

El sistema incluye las siguientes funcionalidades:

- Registro para creacion de cuenta de administrador. Esto crea una nueva cuenta (Empresa) a la cual se asociaran los nuevos usuarios.

- Registro de usuarios (clientes) con contraseña encriptada, inicio de sesion y validacion de usuarios. Los usuarios se registran a traves de la URL personalizada que aparece en el panel del administrador de la cuenta.

- Panel para administrador de la cuenta, en el cual se puede ver la agenda de citas diarias, crear servicios, categorias y esteticistas.

- URL personalizada de registro de usuarios (clientes) para la cuenta.

- Panel de usuarios (clientes) con listado de citas pendientes y opcion de reservar nuevas citas.

- Funcion para calcular y mostrar la disponibilidad de agenda por esteticista.

Tambien cuenta con validaciones de seguridad como:

- Validacion de duplicidad de cita antes de registrar una cita nueva.
- Validacion de rol de usuarios.
- Creacion de contraseñas encriptadas.

## Configuracion

Para configurar el entorno se debe tener php + composer instalado al igual que el motor de bases de datos y se debe crear la base de datos con la estructura relacionada en el archivo bd-psql.sql. Modificar el archivo conexionpg.php con las variables de entorno de la base de datos creada. 

Aun no esta finalizada, esta en fase de desarrollo pero es funcional para la parte del cliente, para el agendamiento de citas y funcion de creacion para el panel de administracion.
