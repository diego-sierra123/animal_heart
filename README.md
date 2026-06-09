# 🐾 Sistema Veterinaria

Aplicación web desarrollada en **PHP**, **MySQL** y **Docker** para la gestión de una veterinaria.

## 📋 Requisitos

Antes de ejecutar el proyecto, asegúrate de tener instalado:

* Docker
* Docker Compose

## 🚀 Instalación y ejecución

Clona el repositorio:

```bash
git clone URL_DEL_REPOSITORIO
```

Ingresa a la carpeta del proyecto (Dentro de la carpeta llamada "veterinaria"):

```bash
cd nombre-del-proyecto
```

Construye y levanta los contenedores (Recordar que para levantar los contenedores se debe estar en dentro de la carpeta "veterinaria" ya que dentro de esta carpeta esta todos los archivos y carpetas del proyecto):

```bash
docker compose up -d --build
```

<spam style = 'color:#FF746C'> <b> Nota: </b> </spam> Aparte de la instalación y ejecución importar la base de datos la cual se encuentra en el mismo github tener en cuenta que si la base de datos ya esta creada con el nombre de veterinaria pero al importar genera error o problemas se debe borrar esa base de datos y volverla a crear con el nombre de veterinaria y indicar que es "utf8mb4_spanish2_ci" posteriormente volver a importar la base de datos que se encuentra en el github y si todo salio bien si probar luego si probar la aplicación web. Un ejemplo de como crear la base de datos antes de importarla se puede ver de la siguiente manera:

![Descripción de la imagen](img_mensaje/imagen.png)

## 🌐 Acceso al sistema

### Aplicación web

```text
http://localhost:8080
```

### phpMyAdmin

```text
http://localhost:8081
```

## 🗄️ Configuración de la base de datos

| Parámetro     | Valor       |
| ------------- | ----------- |
| Host          | mysql       |
| Usuario       | root        |
| Contraseña    | root        |
| Base de datos | veterinaria |
| Puerto        | 3306        |

## 🐳 Contenedores Docker

El proyecto utiliza los siguientes servicios:

* **web**: Servidor Apache con PHP 8.2.
* **mysql**: Base de datos MySQL 8.0.
* **phpmyadmin**: Interfaz gráfica para administrar la base de datos.

## 📁 Estructura del proyecto

```text
├── Dockerfile
├── docker-compose.yml
├── README.md
├── .gitignore
├── conexion.php
├── index.php
└── ...
```

## 👨‍💻 Autor

Diego Alejandro Sierra Hernández
