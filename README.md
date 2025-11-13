
# Proyecto FONDECYT — Hábitos y Consumos

Repositorio creado para gestionar y documentar el proyecto **"Hábitos y Consumos"**, que forma parte de las investigaciones desarrolladas en el marco del **FONDECYT de Iniciación**.

---

## Descripción general

El proyecto busca comprender la relación entre **estímulos condicionados (EC)** y **respuestas conductuales** vinculadas a distintos tipos de consumo, utilizando un **paradigma pavloviano-instrumental (PIT)** adaptado para ejecución en entorno web.

Se utilizan estímulos visuales (colores, imágenes de productos) asociados con recompensas (por ejemplo, alimentos o drogas legales), midiendo el aprendizaje asociativo y la influencia de estos estímulos sobre la ejecución instrumental.

---

## Objetivos

### Objetivo general
Evaluar el impacto del aprendizaje pavloviano en la conducta instrumental relacionada con estímulos de consumo (comida, alcohol, tabaco, etc.), bajo diferentes condiciones experimentales.

### Objetivos específicos
1. Implementar un experimento pavloviano–instrumental web completamente funcional.
2. Analizar los efectos diferenciales de los estímulos asociados (EC) en la conducta de elección.
3. Evaluar la persistencia del aprendizaje tras fases de devaluación.
4. Comparar condiciones experimentales entre grupos de consumidores (p. ej., fumadores vs no fumadores).

---

## Implementación

El experimento está desarrollado en **HTML + JavaScript puro**, sin dependencias externas, para facilitar su ejecución tanto en laboratorio como en campo (tablets o navegadores modernos).

### Archivos principales

- `index.html`: interfaz principal del experimento.  
- `img/`: carpeta con imágenes de reforzadores (cigarro, cerveza, snacks, etc.).  
- `participantes.csv`: archivo con datos base (RUT, condición, comida).  
- `save_data.php`: script para guardar resultados en el servidor.  
- `Spec sheet experimentos - Objetivo 1.docx`: especificaciones metodológicas.  
- `Pantallas de Fases del experimento.pdf`: diseño visual de las fases.

---

## Parámetros actuales del experimento (versión TEST RÁPIDO)

Los parámetros no están centralizados en constantes, sino definidos dentro de cada fase. A continuación se documentan **tal como están en el código** que me compartiste.

### 1. Fase Pavloviana (`fasePavloviana()`)

```js
const trial_types = shuffle([
  ...Array(1).fill('droga'),
  ...Array(1).fill('comida'),
  ...Array(1).fill('clip'),
  ...Array(1).fill('neutro'),
]);
```

- Ensayos por tipo: **1** (total = 4 ensayos).  
- Duración EC (cuadrado de color): `await sleep(1000);` → **1 s**.  
- Duración refuerzo (imagen): `await sleep(300);` → **0,3 s**.  
- ITI (punto de fijación): `choice([1,2]) * 1000` → **1–2 s**.

### 2. Rating de colores (`faseRatingColores()`)

- Escala de 1 a 5.  
- Se evalúan 4 colores: azul, amarillo, rojo y verde.  
- Pausa después de cada respuesta: `await sleep(1000);` → **1 s**.

### 3. Fase Instrumental (`faseInstrumental()`)

```js
const n_trials = 6;   // TEST: 6 ensayos totales
const prob = 0.5;
```

- Ensayos totales: **6**.  
- Probabilidad de recompensa si se presiona la tecla “correcta”: **0,5 (50%)**.  
- Fijación previa (`+`): `await sleep(1000);` → **1 s**.  
- Duración del mensaje de feedback (ganaste / no ganaste): `await sleep(1000);` → **1 s**.  

Mapping de botones a tipo de recompensa:

```js
const map = {1:'droga', 2:'comida', 3:'clip'};
```

### 4. Fase PIT y PIT Post (`fasePIT(reps, collector)`)

En el `main()` se llama como:

```js
await fasePIT(1, pit_rows);      // PIT
...
await fasePIT(1, pitpost_rows);  // PIT post
```

Eso implica:

- `reps = 1` → **1 ensayo por estímulo S1, S2, S3** (total = 3 ensayos por fase).  

Dentro de la función:

```js
await sleep(choice([1,2])*1000);  // fijación
...
windowTimer = setTimeout(finish, 2000); // ventana de 2 s
...
maxTimer = setTimeout(()=>{ finish(); }, 60000);
```

Parámetros efectivos:

- Fijación (`+`): **1–2 s**.  
- Ventana de conteo: **2 s desde la primera pulsación de R1/R3**.  
- Corte máximo si no hay respuesta: **60 s** (después de eso el ensayo termina automáticamente).  
- Pantalla de “Recalibrando”: `0.5–1.5 s`.

Durante esta fase **solo están disponibles R1 y R3**; se cuenta el número de pulsaciones por estímulo y la primera respuesta (RT, botón).

### 5. Devaluación (`faseDevaluacion()`)

- Se calcula el total de puntos por tipo de recompensa a partir de `instr_rows`.  
- Se muestra un resumen al participante y luego se solicitan ratings de deseo (escala 1–10) para:
  - `CONDICION` (ej. Cigarro o Cerveza).  
  - `COMIDA` (ej. KUKY, Ramitas, etc.).  
- Pausa tras cada rating: `await sleep(1000);` → **1 s**.

---

## Salida de datos

El experimento genera múltiples CSV por participante, identificados por `RUT` y `timestamp`:

- `pavloviana_RUT_timestamp.csv`  
- `ratings_RUT_timestamp.csv`  
- `instrumental_RUT_timestamp.csv`  
- `pit_RUT_timestamp.csv`  
- `devaluacion_RUT_timestamp.csv`  
- `pit_post_RUT_timestamp.csv`  

Todos se empaquetan en un archivo `.zip` y:

1. Se descargan localmente en el dispositivo del participante.  
2. Se envían al servidor mediante `save_data.php`.

---

## Identificación de participantes

- El participante ingresa su **RUT sin puntos y con guión**.  
- El código lo normaliza y busca en `participantes.csv`:
  - Condición experimental (`Condicion`).
  - Tipo de comida asociada (`Comida`).

Si el RUT no está en el archivo, se utilizan valores por defecto:
- `CONDICION = "Cigarro"`
- `COMIDA = "KUKY"`

---

## Estructura sugerida del repositorio

```text
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
```

---

## Créditos

**Autor:** Edgar Alejandro Santana  
**Proyecto:** FONDECYT — Hábitos y Consumos  
**Versión:** v1.1 (modo TEST rápido documentado)
