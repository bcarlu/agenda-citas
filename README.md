# agenda-citas

## Requisitos
- PHP = 8.4
- Base de datos:
-- PostgreSQL = 17.5

## Caracteristicas

Esta es una aplicación web para agendamiento de citas en salones de belleza. Entre sus caracteristicas estan:

- Se ha configurado la creacion de cuentas de usuario con contraseña encriptada, inicio de sesion y validacion de usuarios.

- Se implementa la navegacion por paginas segun categoria y servicios, se presenta dinamicamente los servicios, tambien las fechas y horas disponibles para cada empleado.

- Se implementa validacion de citas antes de registrarla en la base de datos para evitar duplicidad y se emite alerta en caso de que la cita haya sido tomada por alguien mas en el mismo momento, para que el usuario quede informado y pueda tomar otra hora diferente.

## Configuracion

Para configurar el entorno se debe tener php instalado al igual que el motor de bases de datos y se debe crear la base de datos con la estructura relacionada en el archivo bd-psql.sql. Modificar el archivo conexionpg.php con las variables de entorno de la base de datos creada. 

Aun no esta finalizada, esta en fase de desarrollo pero el funcional para la parte del cliente. Esta pendiente desarrollar el modulo de administracion, por el momento se debe crear manualmente en la base de datos los servicios, categorias y esteticistas.
