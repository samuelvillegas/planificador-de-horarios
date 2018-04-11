DROP DATABASE IF EXISTS constructor_horarios;

CREATE DATABASE constructor_horarios;

USE constructor_horarios;

CREATE TABLE escuela (
	id_escuela INT PRIMARY KEY AUTO_INCREMENT,
	nombre VARCHAR(45) NOT NULL,
	direccion LONGTEXT NOT NULL,
	imagen LONGTEXT,
	rif VARCHAR(45) NOT NULL,
	telefono VARCHAR(25) NOT NULL, 
	correo VARCHAR(45)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE departamento(
	id_departamento INT PRIMARY KEY AUTO_INCREMENT,
	descripcion VARCHAR(45) NOT NULL,
	id_escuela INT,
	FOREIGN KEY (id_escuela) REFERENCES escuela(id_escuela)
	ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE acceso(
	id_acceso INT PRIMARY KEY AUTO_INCREMENT,
	nivel INT NOT NULL UNIQUE,
	descripcion VARCHAR(45)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE persona (
	id_persona INT PRIMARY KEY AUTO_INCREMENT,
	nombre VARCHAR(45) NOT NULL,
	apellido VARCHAR(45) NOT NULL,
	telefono VARCHAR(15) NOT NULL,
	direccion VARCHAR(145) NOT NULL,
	dni VARCHAR(45) NOT NULL UNIQUE,
	usuario VARCHAR(45) UNIQUE,
	clave VARCHAR(145),
	imagen LONGTEXT	
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE perfil(
	id_perfil INT PRIMARY KEY AUTO_INCREMENT,
	nombre VARCHAR(45) NOT NULL UNIQUE,
	descripcion VARCHAR(145) NOT NULL,
	nivel_acceso INT,
	FOREIGN KEY (nivel_acceso) REFERENCES acceso(id_acceso)
	ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE persona_perfil(
	id_persona INT,
	FOREIGN KEY (id_persona) REFERENCES persona(id_persona)
	ON DELETE CASCADE ON UPDATE CASCADE,
	id_perfil INT,
	FOREIGN KEY (id_perfil) REFERENCES perfil(id_perfil)
	ON DELETE CASCADE ON UPDATE CASCADE,
	PRIMARY KEY (id_persona, id_perfil)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE perfil_departamento(
	id_perfil INT,
	FOREIGN KEY (id_perfil) REFERENCES perfil(id_perfil)
	ON DELETE CASCADE ON UPDATE CASCADE,
	id_departamento INT,
	FOREIGN KEY (id_departamento) REFERENCES departamento(id_departamento)
	ON DELETE CASCADE ON UPDATE CASCADE,
	PRIMARY KEY (id_perfil, id_departamento)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE aula(
	id_aula INT PRIMARY KEY	AUTO_INCREMENT,
	numero_nombre VARCHAR(25) NOT NULL,
	capacidad INT NOT NULL,
	tipo ENUM('1','2','3') 
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE grado(
	id_grado INT PRIMARY KEY AUTO_INCREMENT,
	numero VARCHAR(45) NOT NULL,
	estado ENUM('activo','inactivo') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE materia(
	id_materia INT PRIMARY KEY AUTO_INCREMENT,
	nombre VARCHAR(45) NOT NULL,
	descripcion VARCHAR(145)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE grado_materia_horas(
	id_grado INT,
	id_materia INT,
	hora INT(3)  NOT NULL,
	FOREIGN KEY (id_grado) REFERENCES grado(id_grado)
	ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (id_materia) REFERENCES materia(id_materia)
	ON DELETE CASCADE ON UPDATE CASCADE,
	PRIMARY KEY(id_grado, id_materia)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE persona_materia(
	id_persona INT,
	id_materia INT,
	FOREIGN KEY (id_persona) REFERENCES persona(id_persona)
	ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (id_materia) REFERENCES materia(id_materia)
	ON DELETE CASCADE ON UPDATE CASCADE,
	PRIMARY KEY(id_persona, id_materia)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE seccion(
	id_seccion INT PRIMARY KEY AUTO_INCREMENT,
	numero_nombre VARCHAR(25) NOT NULL,
	id_grado INT,
	FOREIGN KEY (id_grado) REFERENCES grado(id_grado)
	ON DELETE CASCADE ON UPDATE CASCADE,
	id_departamento INT,
	FOREIGN KEY (id_departamento) REFERENCES departamento(id_departamento)
	ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE horario(
	id_horario INT PRIMARY KEY AUTO_INCREMENT,
	id_seccion INT,
	FOREIGN KEY (id_seccion) REFERENCES seccion(id_seccion)
	ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE hora(
	id_hora INT PRIMARY KEY AUTO_INCREMENT,
	hora TIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE rutina(
	id_rutina INT PRIMARY KEY AUTO_INCREMENT,
	id_materia INT,
	FOREIGN KEY (id_materia) REFERENCES materia(id_materia)
	ON DELETE CASCADE ON UPDATE CASCADE,
	id_persona INT,
	FOREIGN KEY (id_persona) REFERENCES persona(id_persona)
	ON DELETE CASCADE ON UPDATE CASCADE,	
	id_aula INT,
	FOREIGN KEY (id_aula) REFERENCES aula(id_aula)
	ON DELETE CASCADE ON UPDATE CASCADE,
	id_hora_inicio INT,
	FOREIGN KEY (id_hora_inicio) REFERENCES hora(id_hora)
	ON DELETE CASCADE ON UPDATE CASCADE,
	id_fin_inicio INT,
	FOREIGN KEY (id_fin_inicio) REFERENCES hora(id_hora)
	ON DELETE CASCADE ON UPDATE CASCADE,
	dia VARCHAR(10) NOT NULL,
	id_horario INT,
	FOREIGN KEY (id_horario) REFERENCES horario(id_horario)
	ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
