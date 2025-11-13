# Proyecto FONDECYT — Hábitos y Consumos

Repositorio creado para gestionar y documentar el proyecto "Hábitos y Consumos", que forma parte de las investigaciones desarrolladas en el marco del FONDECYT de Iniciación.

📋 Descripción general

El proyecto busca comprender la relación entre estímulos condicionados (EC) y respuestas conductuales vinculadas a distintos tipos de consumo, utilizando un paradigma pavloviano-instrumental (PIT) adaptado para ejecución en entorno web.

Se utilizan estímulos visuales (colores, imágenes de productos) asociados con recompensas (por ejemplo, alimentos o drogas legales), midiendo el aprendizaje asociativo y la influencia de estos estímulos sobre la ejecución instrumental.

🎯 Objetivos
Objetivo general

Evaluar el impacto del aprendizaje pavloviano en la conducta instrumental relacionada con estímulos de consumo (comida, alcohol, tabaco, etc.), bajo diferentes condiciones experimentales.

Objetivos específicos

Implementar un experimento pavloviano–instrumental web completamente funcional.

Analizar los efectos diferenciales de los estímulos asociados (EC) en la conducta de elección.

Evaluar la persistencia del aprendizaje tras fases de devaluación.

Comparar condiciones experimentales entre grupos de consumidores (p. ej., fumadores vs no fumadores).

⚙️ Arquitectura técnica
Estructura general del experimento

| Fase                      | Descripción                                           | Archivo / Código             |
| ------------------------- | ----------------------------------------------------- | ---------------------------- |
| Instrucciones Pavlovianas | Presentación de EC (colores) y reforzadores asociados | `instruccionesPavloviana()`  |
| Fase Pavloviana           | Asociación color–recompensa                           | `fasePavloviana()`           |
| Rating de colores         | Evaluación subjetiva de los EC                        | `faseRatingColores()`        |
| Fase Instrumental         | Aprendizaje acción–recompensa (R1–R3)                 | `faseInstrumental()`         |
| PIT                       | Evaluación del efecto del EC sobre la acción          | `fasePIT()`                  |
| Devaluación               | Manipulación de la motivación / deseo                 | `faseDevaluacion()`          |
| PIT post                  | Reevaluación posterior a la devaluación               | `fasePIT()` (segunda pasada) |


💻 Implementación

El experimento fue desarrollado en HTML + JavaScript puro, sin dependencias externas, para facilitar su uso en laboratorio o campo (tablets o navegadores modernos).

Archivos principales

index.html: interfaz principal del experimento.

img/: carpeta con imágenes de reforzadores.

participantes.csv: archivo con datos base (RUT, condición, comida).

save_data.php: script servidor para almacenar resultados.

Spec sheet experimentos - Objetivo 1.docx: especificaciones metodológicas.

Pantallas de Fases del experimento.pdf: diseño visual de cada fase.

🧩 Parámetros ajustables

Dentro de index.html, las fases se controlan mediante variables que definen número de ensayos y tiempos de exposición:

const N_TRIALS_PAVLOVIANA = 36;
const N_TRIALS_INSTRUMENTAL = 36;
const PIT_WINDOW_MS = 4000;
const PIT_NO_RESP_MS = 60000; // Tiempo máximo sin respuesta

Para test rápidos se pueden reducir:

const N_TRIALS_PAVLOVIANA = 4;
const N_TRIALS_INSTRUMENTAL = 6;
const PIT_WINDOW_MS = 2000;

🧪 Recolección de datos

Cada fase genera un archivo .csv con la siguiente estructura:

| Archivo                          | Contenido                       |
| -------------------------------- | ------------------------------- |
| `pavloviana_RUT_timestamp.csv`   | Datos de exposición EC–refuerzo |
| `ratings_RUT_timestamp.csv`      | Calificaciones subjetivas       |
| `instrumental_RUT_timestamp.csv` | Ensayos de respuesta y eficacia |
| `pit_RUT_timestamp.csv`          | Prueba PIT pre-devaluación      |
| `devaluacion_RUT_timestamp.csv`  | Deseo post-devaluación          |
| `pit_post_RUT_timestamp.csv`     | PIT posterior a la manipulación |

Los archivos se empaquetan automáticamente en un .zip y se descargan localmente, además de ser enviados al servidor.

🔒 Control de participantes

Los datos de los sujetos se controlan mediante el campo RUT ingresado al inicio del experimento.
El sistema busca coincidencias en participantes.csv para determinar Condición Experimental y Tipo de Recompensa.

Ejemplo de registro en participantes.csv:
RUT,Condicion,Comida
12345678-9,Cigarro,KUKY
98765432-1,Cerveza,Ramitas

🧰 Requisitos de ejecución

Navegador moderno (Chrome, Firefox, Edge, Safari).

Permisos para pantalla completa y ejecución de JavaScript.

Acceso a carpeta img/ con los estímulos.

Conexión al servidor con save_data.php activo (opcional).

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
└── README.md (este archivo)

🧠 Créditos y autoría

Autor: Edgar Alejandro Santana
Proyecto FONDECYT: Investigación en hábitos y conductas de consumo.
Colaboradores: [agrega aquí equipo o institución]
Versión: v1.0 – 2025
