/*
-- PostGreSql
-- Creación de la BD
-- Author: Rafael Morones Burgos.
-- Version: 1.0.0
-- Since: 05/10/2026
*/

-- -----------------------------------------------------
-- Tabla "Rol": Tabla sencilla para describir los 
-- 3 roles que tiene la aplicación
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS rol (
    id_rol       SERIAL PRIMARY KEY,
    nombre       VARCHAR(50) NOT NULL UNIQUE,
    descripcion  VARCHAR(255)
);

-- -----------------------------------------------------
-- Tabla "Muelle": Define los atributos de los muelles
-- o zonas de atraque disponibles en la aplicación.
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS muelle (
    id_muelle       SERIAL PRIMARY KEY, -- Identificador unico y autoincremental
    --Datos del muelle
    nombre          VARCHAR(100) NOT NULL, 
    descripcion     TEXT,
    direccion       VARCHAR(255),
    localidad       VARCHAR(100),
    provincia       VARCHAR(100) DEFAULT 'Málaga',
    codigo_postal   VARCHAR(10),
    --Localización exacta
    latitud         DECIMAL(10,7),
    longitud        DECIMAL(10,7),
    telefono        VARCHAR(20),
    email           VARCHAR(255),
    horario         VARCHAR(100),
    activo          BOOLEAN DEFAULT TRUE, -- Activo si o no
    fecha_alta      TIMESTAMP DEFAULT CURRENT_TIMESTAMP --Fecha alta Plataforma
);


-- -----------------------------------------------------
-- Tabla "Usuario": Define los atributos que tienen los
-- usuarios dados de alta en la plataforma. Almacena tanto
-- clientes como empleados y administradores.
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS usuario (
    id_usuario        SERIAL PRIMARY KEY, -- Identificador unico y autoincremental
    -- Datos del usuario
    nombre            VARCHAR(100) NOT NULL,
    apellidos         VARCHAR(150) NOT NULL,
    email             VARCHAR(255) NOT NULL UNIQUE, -- El correo es unico para cada usuario
    -- almacenamos la contraseña con hash bcryp; nunca  en texto plano
    password          VARCHAR(255) NOT NULL, 
    telefono          VARCHAR(20), -- Puede tener o no telefono
    -- Documento de identificación del cliente
    documento_tipo    VARCHAR(20) NOT NULL,
    numero_documento  VARCHAR(30) NOT NULL UNIQUE, -- La identifación debe ser única
    direccion         VARCHAR(255), -- Opcional
    fecha_registro    TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
    activo            BOOLEAN DEFAULT TRUE, --permite desactivar al usuario
    -- Claves foráneas
    id_rol            INT NOT NULL, -- Asignación de rol al usuario
    id_muelle         INT, -- Solo se rellena para empleados asignados a un muelle concreto
    -- FK al rol del usuario
    CONSTRAINT fk_usuario_rol FOREIGN KEY (id_rol)
        REFERENCES rol(id_rol)
        ON DELETE RESTRICT -- No se puede borrar un rol que tenga usuarios asociados
        ON UPDATE CASCADE,
    -- FK opcional al muelle donde trabaja el empleado
    CONSTRAINT fk_usuario_muelle FOREIGN KEY (id_muelle)
        REFERENCES muelle(id_muelle)
        ON DELETE SET NULL -- Si se borra el muelle, el usuario sigue existiendo sin muelle asignado
        ON UPDATE CASCADE,
    -- Tipos de documentos identificativos que se permiten
    CONSTRAINT chk_documento_tipo CHECK (documento_tipo IN ('DNI', 'NIE', 'Pasaporte'))
);


-- -----------------------------------------------------
-- Tabla "Embarcacion": Define los atributos de las
-- embarcaciones registradas por los usuarios.
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS embarcacion (
    id_embarcacion   SERIAL PRIMARY KEY, -- Identificador unico y autoincremental
    -- Datos de la embarcación
    nombre           VARCHAR(100) NOT NULL, 
    matricula        VARCHAR(50) NOT NULL UNIQUE, -- la matrícula es única
    tipo             VARCHAR(50), -- tipo de embarcación; opcional
    -- Dimensiones de cada embarcación en decimales
    eslora           DECIMAL(5,2) NOT NULL, -- longitud 
    manga            DECIMAL(5,2) NOT NULL, -- anchura 
    calado           DECIMAL(5,2) NOT NULL, -- profundidad 
    -- Datos legales y de seguridad
    bandera          VARCHAR(50), -- BAndera bajo la que navega la embarcación
    numero_poliza_seguro VARCHAR(50), -- poliza seguro obligatorio
    vencimiento_seguro DATE, -- Caducidad del seguro
    mmsi             VARCHAR(20), -- Código internacional de identificación por radio; opcional
    capacidad        INT, -- Capacidad máxima del barco; opcional
    fecha_alta       TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- fecha de alta 
);


-- -----------------------------------------------------
-- Tabla "usuario_embarcacion": Tabla intermedia; Relación muchos a muchos N:M.
-- 1 embarcación puede tener varios propietarios
--1 usuario puede tener varias embarcaciones
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS usuario_embarcacion (
    id_usuario       INT NOT NULL, -- FK al usuario
    id_embarcacion   INT NOT NULL, -- FK a la embarcación
    rol              VARCHAR(30) NOT NULL DEFAULT 'propietario', -- propietario, copropietario o gestor
    fecha_asociacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Fecha en que se asoció el usuario a la embarcación
    PRIMARY KEY (id_usuario, id_embarcacion), 
    CONSTRAINT fk_ue_usuario FOREIGN KEY (id_usuario)
        REFERENCES usuario(id_usuario)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT fk_ue_embarcacion FOREIGN KEY (id_embarcacion)
        REFERENCES embarcacion(id_embarcacion)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT chk_ue_rol CHECK (rol IN ('propietario', 'copropietario', 'gestor'))
);
-- -----------------------------------------------------
-- Tabla "Amarre": Define los atributos que tienen los
-- amarres existentes en cada muelle
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS amarre (
    id_amarre       SERIAL PRIMARY KEY, -- Identificador unico y autoincremental
    id_muelle       INT NOT NULL,       --FK para referenciar al muelle a donde pertenece 
    numero          VARCHAR(20) NOT NULL, -- Codigo de identificación A-12
    eslora_max      DECIMAL(5,2) NOT NULL,  --Eslora, manga y calado máximo que permite cada amarre
    manga_max       DECIMAL(5,2) NOT NULL,  --Las dimensiones en decimales 
    calado_max      DECIMAL(5,2) NOT NULL,
    estado          VARCHAR(20) NOT NULL DEFAULT 'disponible', --Estado actual; 
    tarifa_base     DECIMAL(8,2) NOT NULL, --Precio alquiler amarre
    observaciones   TEXT,                  --Comentarios opcionales
    activo          BOOLEAN DEFAULT TRUE,  -- Activo si o no
    fecha_alta      TIMESTAMP DEFAULT CURRENT_TIMESTAMP, --Fecha alta Plataforma
    CONSTRAINT fk_amarre_muelle FOREIGN KEY (id_muelle) --Referencia cada amarre con su muelle.
        REFERENCES muelle(id_muelle)
        ON DELETE CASCADE -- Si se borra el muelle se borran todos los amarres
        ON UPDATE CASCADE,
        --La BD impide que haya 2 amarres con el mismo numero dentro del mismo muelle
    CONSTRAINT uq_amarre_muelle_numero UNIQUE (id_muelle, numero),
    --Solo se permiten 4 estados
    CONSTRAINT chk_amarre_estado CHECK (estado IN ('disponible', 'ocupado', 'mantenimiento', 'reservado')),
    --No permite introducir medidas negativas o que sean 0
    CONSTRAINT chk_amarre_dimensiones CHECK (eslora_max > 0 AND manga_max > 0 AND calado_max > 0),
    --No permite introducir tarifas iguales o inferiores a 0
    CONSTRAINT chk_amarre_tarifa CHECK (tarifa_base >= 0)
);

-- -----------------------------------------------------
-- Tabla "Servicio": Define los atributos que tienen los
-- servicios existentes dentro de cada muelle 
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS servicio (
    id_servicio     SERIAL PRIMARY KEY, -- Identificador unico y autoincremental
    nombre          VARCHAR(100) NOT NULL UNIQUE, --No puede haber 2 servicios con el mismo nombre
    descripcion     TEXT, -- Describir el serivico más amplicado; opcional
    categoria       VARCHAR(50) NOT NULL,-- Dividir los servicios por categoria; opcional
    --El precio generico está en servicio, pero el precio concreto estará en muelle_servicio
    --El precio del servicio en cada muelle será distinto
    precio_base     DECIMAL(8,2) NOT NULL DEFAULT 0,
    unidad_cobro    VARCHAR(30) NOT NULL DEFAULT 'por servicio', -- Como se va a cobrar cada servicio
    activo          BOOLEAN DEFAULT TRUE, --Disponible/No disponible
    fecha_alta      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    --Restringimos las unicas categorias posibles
    CONSTRAINT chk_servicio_categoria CHECK (categoria IN (
        'suministro', 'limpieza', 'mantenimiento', 'combustible', 'alquiler', 'personal', 'otro'
    )),
    --Restringimos la forma en que se va a cobrar cada servicio
    CONSTRAINT chk_servicio_unidad CHECK (unidad_cobro IN (
        'por servicio', 'por día', 'por hora', 'por consumo', 'por metro'
    )),
    --Impedimos que la tarifa sea igual o inferior a 0
    CONSTRAINT chk_servicio_precio CHECK (precio_base >= 0)
);

-- -----------------------------------------------------
-- Tabla "muelle_srvicio": Tabla Intermedia N:M; relacion muchos a muchos
-- Un muelle puede tener muchos servicios
-- Un mismo servicio puede estar disponbile en muchos muelles
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS muelle_servicio (
  --FK que apuntan a la fila correspondiente tanto de muelle como de servicio
    id_muelle       INT NOT NULL,
    id_servicio     INT NOT NULL,
    --El precio del servicio puede variar según el muelle
    precio          DECIMAL(8,2),      
    --Un mismo servicio puede estar disponible o no en el muelle    
    disponible      BOOLEAN DEFAULT TRUE,   
    observaciones   TEXT, --Descripción ampliada del serivicio
    PRIMARY KEY (id_muelle, id_servicio), --Indentificación Pk compuesta
    CONSTRAINT fk_ms_muelle FOREIGN KEY (id_muelle)
    --Actualizamos o borramos fila cuando alguna fila de las tablas referenciadas sufren cambios
        REFERENCES muelle(id_muelle)
        ON DELETE CASCADE 
        ON UPDATE CASCADE,
    CONSTRAINT fk_ms_servicio FOREIGN KEY (id_servicio)
        REFERENCES servicio(id_servicio)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    --Impedimos que la tarifa sea igual o inferior a 0     
    CONSTRAINT chk_ms_precio CHECK (precio IS NULL OR precio >= 0)
);

-- -----------------------------------------------------
-- Tabla "reserva": Define los atributos que tienen las
-- reservas realizadas sobre cada amarre de cada muelle
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS reserva (
    id_reserva      SERIAL PRIMARY KEY, -- Identificador unico y autoincremental
    codigo_reserva  VARCHAR(20) NOT NULL UNIQUE, -- El codigo de reserva que recibe el cliente
    --Claves foráneas: referencia a la tabla usuario, embarcación dada de alta y el amarre
    id_usuario      INT NOT NULL,
    id_embarcacion  INT NOT NULL,
    id_amarre       INT NOT NULL,
    --Datos de la reserva
    fecha_entrada   DATE NOT NULL,
    fecha_salida    DATE NOT NULL,
    estado          VARCHAR(20) NOT NULL DEFAULT 'pendiente',  --El estado solo admite unos estados concretos
    --El precio se calcula por el precio del amarre y los servicios
    precio_total    DECIMAL(10,2) NOT NULL DEFAULT 0,
    observaciones   TEXT, --Comentarios opcionales
    fecha_creacion  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    --Claves FK
    CONSTRAINT fk_reserva_usuario FOREIGN KEY (id_usuario) 
    --No se puede borrar un usuario con reserva
      REFERENCES usuario(id_usuario) 
      ON DELETE RESTRICT 
      ON UPDATE CASCADE,

    --No se puede borrar una embarcacion con reserva
    CONSTRAINT fk_reserva_embarcacion FOREIGN KEY (id_embarcacion)
      REFERENCES embarcacion(id_embarcacion) 
      ON DELETE RESTRICT
      ON UPDATE CASCADE,
       --No se puede borrar un amarre con reserva
    CONSTRAINT fk_reserva_amarre FOREIGN KEY (id_amarre)
     REFERENCES amarre(id_amarre)
      ON DELETE RESTRICT 
      ON UPDATE CASCADE,
    --Resctricciones sobre el periodo de reserva y el estado de la reserva
    CONSTRAINT chk_reserva_fechas CHECK (fecha_salida > fecha_entrada),
    CONSTRAINT chk_reserva_estado CHECK (estado IN ('pendiente', 'confirmada', 'cancelada', 'finalizada')),
    --El precio de la reserva no puede ser inferior a 0
    CONSTRAINT chk_reserva_precio CHECK (precio_total >= 0)
);

-- -----------------------------------------------------
-- Tabla "reserva_servicio": Tabla Intermedia N:M; relacion muchos a muchos
-- Una reserva puede tener muchos servicios
-- Un mismo servicio puede ser reservado muchas veces
--Ayuda a saber que servicios ha contratado un cliente en una reserva
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS reserva_servicio (
  --  Referencias foráneas hacia las tablas servicio, y reserva
    id_reserva       INT NOT NULL,
    id_servicio      INT NOT NULL,
    cantidad         INT NOT NULL DEFAULT 1,
    --El precio del servicio en el momento exacto en que fue contratado
    --El historico de reserva guarda el precio del servicio en el momento de contratación
    --Evita que el precio cambie si la tarifa varía con el tiempo
    precio_unitario  DECIMAL(8,2) NOT NULL,
    --Resultado de multiplicar la cantidad de cada servicio que ha sido contratado por el precio 
    subtotal         DECIMAL(10,2) NOT NULL,
    fecha_contratacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    --Conseguimos evitar que un mismo servicio sea añadido 2 veces o mas en una misma reserva
    PRIMARY KEY (id_reserva, id_servicio),
    CONSTRAINT fk_rs_reserva FOREIGN KEY (id_reserva)
        REFERENCES reserva(id_reserva)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT fk_rs_servicio FOREIGN KEY (id_servicio)
        REFERENCES servicio(id_servicio)
        ON DELETE RESTRICT
        ON UPDATE CASCADE,
        --Resctriciones; impedir que sean menor que cero
    CONSTRAINT chk_rs_cantidad CHECK (cantidad > 0),
    CONSTRAINT chk_rs_precio CHECK (precio_unitario >= 0),
    CONSTRAINT chk_rs_subtotal CHECK (subtotal >= 0)
);