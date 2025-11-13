# 🧠 Proyecto FONDECYT --- Hábitos y Consumos

Repositorio creado para gestionar y documentar el proyecto **"Hábitos y
Consumos"**, que forma parte de las investigaciones desarrolladas en el
marco del **FONDECYT de Iniciación**.

------------------------------------------------------------------------

## 📋 Descripción general

El proyecto busca comprender la relación entre **estímulos condicionados
(EC)** y **respuestas conductuales** vinculadas a distintos tipos de
consumo, utilizando un **paradigma pavloviano-instrumental (PIT)**
adaptado para ejecución en entorno web.

Se utilizan estímulos visuales (colores, imágenes de productos)
asociados con recompensas (por ejemplo, alimentos o drogas legales),
midiendo el aprendizaje asociativo y la influencia de estos estímulos
sobre la ejecución instrumental.

------------------------------------------------------------------------

## 🎯 Objetivos

### Objetivo general

Evaluar el impacto del aprendizaje pavloviano en la conducta
instrumental relacionada con estímulos de consumo (comida, alcohol,
tabaco, etc.), bajo diferentes condiciones experimentales.

### Objetivos específicos

1.  Implementar un experimento pavloviano--instrumental web
    completamente funcional.
2.  Analizar los efectos diferenciales de los estímulos asociados (EC)
    en la conducta de elección.
3.  Evaluar la persistencia del aprendizaje tras fases de devaluación.
4.  Comparar condiciones experimentales entre grupos de consumidores
    (p. ej., fumadores vs no fumadores).

------------------------------------------------------------------------

## ⚙️ Arquitectura técnica

### Estructura general del experimento

  -----------------------------------------------------------------------
  Fase                  Descripción
  --------------------- -------------------------------------------------
  Instrucciones         Presentación de EC (colores) y reforzadores
  Pavlovianas           asociados

  Fase Pavloviana       Asociación color--recompensa

  Rating de colores     Evaluación subjetiva de los EC

  Fase Instrumental     Aprendizaje acción--recompensa (R1--R3)

  PIT                   Evaluación del efecto del EC sobre la acción

  Devaluación           Manipulación de la motivación / deseo

  PIT post              Reevaluación posterior a la devaluación
  -----------------------------------------------------------------------

------------------------------------------------------------------------

## 💻 Implementación

El experimento está desarrollado en **HTML + JavaScript puro**, sin
dependencias externas, para facilitar su ejecución tanto en laboratorio
como en campo.

### Archivos principales

-   `index.html`: interfaz principal del experimento.\
-   `img/`: carpeta con imágenes de reforzadores.\
-   `participantes.csv`: archivo con datos base (RUT, condición,
    comida).\
-   `save_data.php`: script para guardar resultados en el servidor.\
-   `Spec sheet experimentos - Objetivo 1.docx`: especificaciones
    metodológicas.\
-   `Pantallas de Fases del experimento.pdf`: diseño visual de las
    fases.

------------------------------------------------------------------------

## 🧩 Parámetros ajustables

Dentro del código (`index.html`), se definen los parámetros clave:

``` js
const N_TRIALS_PAVLOVIANA = 36;
const N_TRIALS_INSTRUMENTAL = 36;
const PIT_WINDOW_MS = 4000;
const PIT_NO_RESP_MS = 60000;
```

Para realizar pruebas rápidas se pueden reducir temporalmente:

``` js
const N_TRIALS_PAVLOVIANA = 4;
const N_TRIALS_INSTRUMENTAL = 6;
const PIT_WINDOW_MS = 2000;
```

------------------------------------------------------------------------

## 🧪 Recolección de datos

El experimento genera múltiples CSV:

  Archivo                Contenido
  ---------------------- ---------------------------
  `pavloviana_*.csv`     Exposición EC--refuerzo
  `ratings_*.csv`        Calificaciones subjetivas
  `instrumental_*.csv`   Respuestas y eficacia
  `pit_*.csv`            PIT pre--devaluación
  `devaluacion_*.csv`    Deseo post-devaluación
  `pit_post_*.csv`       PIT post--devaluación

Todos se empaquetan automáticamente en un `.zip` y se descargan
localmente, además de enviarse al servidor.

------------------------------------------------------------------------

## 🔒 Control de participantes

Se utiliza `RUT` como identificador.\
El sistema lee `participantes.csv` para determinar:

-   Condición experimental (ej. Cigarro / Cerveza)
-   Recompensa alimentaria asignada

Ejemplo:

    RUT,Condicion,Comida
    12345678-9,Cigarro,KUKY
    98765432-1,Cerveza,Ramitas

------------------------------------------------------------------------

## 🧰 Requisitos

-   Navegador moderno\
-   Permiso de pantalla completa\
-   Carpeta `/img` con estímulos disponible\
-   Servidor con `save_data.php` activo (opcional)

------------------------------------------------------------------------

## 📁 Estructura del repositorio

    fondecyt/
    │
    ├── index.html
    ├── save_data.php
    ├── participantes.csv
    ├── img/
    │   ├── cigarro.png
    │   ├── cerveza.png
    │   └── ...
    │
    ├── documentos/
    │   ├── Spec sheet experimentos - Objetivo 1.docx
    │   └── Pantallas de Fases del experimento.pdf
    │
    └── README.md

------------------------------------------------------------------------

## 🧠 Créditos

**Autor:** Edgar Alejandro Santana\
**Proyecto:** FONDECYT --- Hábitos y Consumos\
**Versión:** v1.0 (2025)

------------------------------------------------------------------------
