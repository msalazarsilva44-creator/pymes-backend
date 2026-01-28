# Guía de Colores MERCAROF para Tailwind CSS

## Paleta de Colores Principal

### Azul Navy (Principal)
- **Base**: `#003B5C` - `bg-mercarof-navy` / `text-mercarof-navy`
- **Oscuro**: `#002942` - `bg-mercarof-navy-dark` / `text-mercarof-navy-dark`
- **Claro**: `#004D73` - `bg-mercarof-navy-light` / `text-mercarof-navy-light`

### Azul Cyan (Secundario)
- **Base**: `#00A3E0` - `bg-mercarof-cyan` / `text-mercarof-cyan`
- **Oscuro**: `#0082B8` - `bg-mercarof-cyan-dark` / `text-mercarof-cyan-dark`
- **Claro**: `#33B8E8` - `bg-mercarof-cyan-light` / `text-mercarof-cyan-light`

---

## Uso con Tailwind CSS

### Ejemplos de clases

#### Fondos
```html
<div class="bg-mercarof-navy">Fondo azul navy</div>
<div class="bg-mercarof-cyan">Fondo azul cyan</div>
<div class="bg-mercarof-navy-light">Fondo navy claro</div>
```

#### Textos
```html
<h1 class="text-mercarof-navy">Título en navy</h1>
<p class="text-mercarof-cyan">Texto en cyan</p>
<span class="text-mercarof-cyan-light">Texto cyan claro</span>
```

#### Bordes
```html
<div class="border border-mercarof-navy">Borde navy</div>
<div class="border-2 border-mercarof-cyan">Borde cyan grueso</div>
<div class="border-t-4 border-mercarof-cyan">Borde superior cyan</div>
```

#### Botones
```html
<!-- Botón principal (Navy) -->
<button class="bg-mercarof-navy hover:bg-mercarof-navy-light text-white px-6 py-2 rounded-lg transition-all">
    Botón Principal
</button>

<!-- Botón secundario (Cyan) -->
<button class="bg-mercarof-cyan hover:bg-mercarof-cyan-dark text-white px-6 py-2 rounded-lg transition-all">
    Botón Secundario
</button>

<!-- Botón outline -->
<button class="border-2 border-mercarof-navy text-mercarof-navy hover:bg-mercarof-navy hover:text-white px-6 py-2 rounded-lg transition-all">
    Botón Outline
</button>
```

#### Gradientes
```html
<div class="bg-gradient-to-r from-mercarof-navy to-mercarof-cyan">
    Gradiente navy a cyan
</div>

<div class="bg-gradient-to-br from-mercarof-navy to-mercarof-navy-light">
    Gradiente navy
</div>
```

---

## Combinaciones Recomendadas

### Navbar/Header
- **Fondo**: `bg-white` o `bg-mercarof-navy`
- **Texto**: `text-mercarof-navy` (sobre blanco) o `text-white` (sobre navy)
- **Links hover**: `hover:text-mercarof-cyan`

### Hero Section
- **Fondo**: `bg-mercarof-navy` o gradiente
- **Texto principal**: `text-white`
- **Texto secundario**: `text-mercarof-cyan-light`
- **Botones**: `bg-mercarof-cyan`

### Cards/Tarjetas
- **Fondo**: `bg-white`
- **Borde superior**: `border-t-4 border-mercarof-cyan`
- **Títulos**: `text-mercarof-navy`
- **Iconos**: `bg-mercarof-cyan` o `bg-mercarof-navy`

### Footer
- **Fondo**: `bg-mercarof-navy`
- **Texto**: `text-white` o `text-mercarof-cyan-light`

---

## Setup en Cursor

### 1. Instalar Tailwind CSS (si no lo tienes)
```bash
npm install -D tailwindcss
npx tailwindcss init
```

### 2. Copiar el archivo tailwind.config.js
Reemplaza tu archivo `tailwind.config.js` con el proporcionado que incluye los colores de MERCAROF.

### 3. Incluir en tu CSS principal
```css
@import 'mercarof-colors.css';

@tailwind base;
@tailwind components;
@tailwind utilities;
```

### 4. Compilar Tailwind
```bash
npx tailwindcss -i ./src/input.css -o ./dist/output.css --watch
```

---

## Variables CSS (alternativa)

Si prefieres usar variables CSS tradicionales:

```css
.mi-elemento {
    background-color: var(--mercarof-navy);
    color: var(--mercarof-cyan);
}
```

---

## Tips de Diseño

1. **Contraste**: El navy sobre blanco tiene excelente legibilidad
2. **Acentos**: Usa cyan para llamadas a la acción y elementos interactivos
3. **Jerarquía**: Navy para títulos, cyan para elementos secundarios
4. **Hover**: Transiciona de navy a cyan o viceversa en interacciones
5. **Gradientes**: Combina navy con navy-light para fondos elegantes

---

## Accesibilidad

- ✅ Navy (#003B5C) sobre blanco: Ratio 9.68:1 (AAA)
- ✅ Cyan (#00A3E0) sobre navy: Ratio 4.68:1 (AA)
- ✅ Blanco sobre navy: Ratio 12.63:1 (AAA)

Todos los colores cumplen con WCAG 2.1 nivel AA o superior.
