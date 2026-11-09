/*
-- PostGreSql
-- Insercción de datos
-- Author: Rafael Morones Burgos.
-- Version: 1.0.0
-- Since: 17/10/2026
*/

-- 1. TABLA ROL (Datos maestros)
INSERT INTO rol (nombre, descripcion) VALUES
('cliente', 'Usuario que consulta disponibilidad y realiza reservas de amarres'),
('empleado', 'Personal de puerto que gestiona amarres, reservas y tarifas'),
('administrador', 'Acceso total al sistema, gestión de usuarios y configuración global');

-- 2. TABLA MUELLE (Puertos reales del litoral malagueño)
-- Coordenadas en formato decimal (latitud, longitud) para el mapa interactivo
INSERT INTO muelle (nombre, descripcion, direccion, localidad, provincia, codigo_postal, latitud, longitud, telefono, email, horario) VALUES
('Puerto Deportivo de Benalmádena', 'Puerto deportivo con más de 1000 amarres', 'Edificio de Capitanía, 29630 Benalmádena Costa', 'Benalmádena', 'Málaga', '29630', 36.6075, -4.5167, '952577022', 'info@puertobenalmadena.es', 'L-D 08:00-20:00'),
('Puerto Deportivo de Fuengirola', 'Puerto con 226 atraques y servicios de marinería', 'Paseo Marítimo, s/n', 'Fuengirola', 'Málaga', '29640', 36.5417, -4.6167, '952468000', 'puertofuengirola@hotmail.com', 'L-D 08:00-21:00'),
('Puerto de Cabopino', 'Puerto deportivo con 169 puestos de amarre', 'Puerto de Cabopino, s/n', 'Marbella', 'Málaga', '29604', 36.4833, -4.7403, '952831975', 'info@eppa.es', 'L-D 09:00-19:00'),
('Puerto Deportivo de Marbella', 'Puerto deportivo con servicios de agua y electricidad', 'Puerto Deportivo, s/n', 'Marbella', 'Málaga', '29602', 36.5047, -4.8915, '952000000', 'puertodeportivo@marbella.es', 'L-D 08:00-20:00'),
('Puerto Banús', 'Puerto de lujo con zona comercial y de ocio', 'José Banús, s/n', 'Marbella', 'Málaga', '29660', 36.4861, -4.9539, '952000000', 'info@puertobanus.es', 'L-D 10:00-22:00'),
('Puerto Deportivo de Estepona', 'Puerto con 443 amarres y servicios de combustible', 'Puerto Deportivo, s/n', 'Estepona', 'Málaga', '29680', 36.4117, -5.1499, '952801800', 'info@puertodeportivoestepona.com', 'L-D 08:00-20:00'),
('Puerto de La Duquesa', 'Puerto deportivo con 325 amarres', 'Puerto de La Duquesa, s/n', 'Manilva', 'Málaga', '29692', 36.3583, -5.2333, '982890100', 'info@puertodeladuquesa.com', 'L-D 09:00-19:00'),
('Real Club El Candado', 'Puerto náutico con 280 amarres', 'Playa de Almellones, 29720 El Palo', 'Málaga', 'Málaga', '29720', 36.7167, -4.3358, '952296097', 'administracion@clubelcandado.com', 'L-D 08:00-20:00');

-- 3. TABLA SERVICIO (Catálogo de servicios)
INSERT INTO servicio (nombre, descripcion, categoria, precio_base, unidad_cobro) VALUES
('Agua potable', 'Suministro de agua potable en el amarre', 'suministro', 5.00, 'por consumo'),
('Electricidad 220V', 'Suministro eléctrico en el amarre', 'suministro', 8.00, 'por consumo'),
('Limpieza de embarcación', 'Limpieza exterior e interior', 'limpieza', 40.00, 'por servicio'),
('Mantenimiento básico', 'Revisión y pequeñas reparaciones', 'mantenimiento', 60.00, 'por hora'),
('Gasolina', 'Suministro de combustible en pantalán', 'combustible', 1.80, 'por consumo'),
('Alquiler de aparejos', 'Alquiler de equipamiento de pesca o navegación', 'alquiler', 25.00, 'por día'),
('Marinería', 'Servicio de marinería para atraque y desatraque', 'personal', 30.00, 'por servicio');

-- 4. TABLA USUARIO (Clientes, empleados y administrador)
-- Los IDs de rol: 1=cliente, 2=empleado, 3=administrador
-- id_muelle: solo para empleados (2) asignados a un puerto concreto
INSERT INTO usuario (nombre, apellidos, email, password, telefono, documento_tipo, numero_documento, direccion, id_rol, id_muelle) VALUES
('Carlos', 'Ruiz Gómez', 'carlos.ruiz@email.com', '$2y$10$hash_de_prueba_1', '600111222', 'DNI', '12345678A', 'Calle Larios, 1, Málaga', 1, NULL),
('María', 'López Fernández', 'maria.lopez@email.com', '$2y$10$hash_de_prueba_2', '600333444', 'DNI', '87654321B', 'Av. Andalucía, 2, Málaga', 1, NULL),
('Javier', 'Moreno Díaz', 'javier.moreno@email.com', '$2y$10$hash_de_prueba_3', '600555666', 'NIE', 'X1234567L', 'Calle Nueva, 3, Marbella', 1, NULL),
('Ana', 'García Soler', 'ana.garcia@puertobenalmadena.es', '$2y$10$hash_de_prueba_4', '952577000', 'DNI', '11223344C', 'Puerto de Benalmádena', 2, 1), -- Empleada en Benalmádena
('Pedro', 'Sánchez Vega', 'pedro.sanchez@puertofuengirola.es', '$2y$10$hash_de_prueba_5', '952468001', 'DNI', '55667788D', 'Puerto de Fuengirola', 2, 2), -- Empleado en Fuengirola
('Admin', 'PortMálaga', 'admin@portmalaga.com', '$2y$10$hash_de_prueba_6', '951000000', 'DNI', '00000000T', 'Oficina Central, Málaga', 3, NULL); -- Administrador

-- 5. TABLA EMBARCACION (Barcos de prueba)
INSERT INTO embarcacion (nombre, matricula, tipo, eslora, manga, calado, bandera, numero_poliza_seguro, vencimiento_seguro, mmsi, capacidad) VALUES
('El Corsario', 'MAT-1234', 'Velero', 12.50, 4.20, 1.80, 'Española', 'POL-987654', '2027-06-30', '123456789', 8),
('La Sirena', 'MAT-5678', 'Motora', 8.00, 3.00, 1.20, 'Española', 'POL-123456', '2026-12-31', '987654321', 6),
('Poseidón', 'MAT-9012', 'Catamarán', 15.00, 6.50, 2.10, 'Española', 'POL-555555', '2028-03-15', '456789123', 12),
('Estrella del Sur', 'MAT-3456', 'Yate', 20.00, 5.50, 2.50, 'Española', 'POL-777777', '2027-09-20', '789123456', 10);

-- 6. TABLA AMARRE (Amarres en los muelles)
-- id_muelle: 1=Benalmádena, 2=Fuengirola, 3=Cabopino, etc.
INSERT INTO amarre (id_muelle, numero, eslora_max, manga_max, calado_max, estado, tarifa_base) VALUES
(1, 'A-01', 12.00, 4.00, 1.80, 'disponible', 35.00),
(1, 'A-02', 10.00, 3.50, 1.50, 'ocupado', 30.00),
(1, 'B-01', 15.00, 5.00, 2.00, 'disponible', 50.00),
(2, 'F-01', 8.00, 3.00, 1.20, 'disponible', 25.00),
(2, 'F-02', 10.00, 3.50, 1.50, 'mantenimiento', 28.00),
(3, 'C-01', 12.00, 4.00, 1.80, 'disponible', 32.00),
(4, 'M-01', 20.00, 5.50, 2.50, 'disponible', 65.00);

-- 7. TABLA USUARIO_EMBARCACION (Copropiedad)
-- El usuario 1 (Carlos) es dueño de "El Corsario" y "La Sirena"
-- El usuario 2 (María) es copropietaria de "El Corsario"
-- El usuario 3 (Javier) es dueño de "Poseidón" y "Estrella del Sur"
INSERT INTO usuario_embarcacion (id_usuario, id_embarcacion, rol) VALUES
(1, 1, 'propietario'),
(1, 2, 'propietario'),
(2, 1, 'copropietario'),
(3, 3, 'propietario'),
(3, 4, 'propietario');

-- 8. TABLA MUELLE_SERVICIO (Servicios disponibles en cada muelle)
INSERT INTO muelle_servicio (id_muelle, id_servicio, precio, disponible) VALUES
(1, 1, 5.00, TRUE), -- Benalmádena: Agua
(1, 2, 8.00, TRUE), -- Benalmádena: Luz
(1, 4, 65.00, TRUE), -- Benalmádena: Mantenimiento
(2, 1, 6.00, TRUE), -- Fuengirola: Agua
(2, 3, 45.00, TRUE), -- Fuengirola: Limpieza
(3, 1, 5.50, TRUE), -- Cabopino: Agua
(3, 6, 30.00, FALSE); -- Cabopino: Alquiler de aparejos (no disponible)

-- 9. TABLA RESERVA (Reservas de prueba)
INSERT INTO reserva (codigo_reserva, id_usuario, id_embarcacion, id_amarre, fecha_entrada, fecha_salida, estado, precio_total) VALUES
('RES-2026-001', 1, 1, 1, '2026-07-01', '2026-07-05', 'confirmada', 140.00),
('RES-2026-002', 3, 3, 3, '2026-08-10', '2026-08-15', 'pendiente', 250.00),
('RES-2026-003', 2, 1, 4, '2026-09-01', '2026-09-03', 'confirmada', 50.00);

-- 10. TABLA RESERVA_SERVICIO (Servicios contratados en cada reserva)
INSERT INTO reserva_servicio (id_reserva, id_servicio, cantidad, precio_unitario, subtotal) VALUES
(1, 1, 4, 5.00, 20.00), -- Reserva 1: Agua (4 días)
(1, 2, 4, 8.00, 32.00), -- Reserva 1: Luz (4 días)
(2, 4, 2, 60.00, 120.00), -- Reserva 2: Mantenimiento (2 horas)
(3, 3, 1, 40.00, 40.00); -- Reserva 3: Limpieza (1 servicio)