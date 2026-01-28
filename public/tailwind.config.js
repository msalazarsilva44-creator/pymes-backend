/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./*.html",
    "./src/**/*.{html,js}",
    "./pages/**/*.{html,js}",
  ],
  theme: {
    extend: {
      colors: {
        // Paleta de colores MERCAROF
        'mercarof': {
          'navy': '#003B5C',      // Azul oscuro principal
          'navy-dark': '#002942',  // Variante más oscura
          'navy-light': '#004D73', // Variante más clara
          'cyan': '#00A3E0',       // Azul claro/cyan
          'cyan-dark': '#0082B8',  // Variante más oscura
          'cyan-light': '#33B8E8', // Variante más clara
        },
        // Aliases para uso rápido
        'primary': '#003B5C',     // Navy
        'secondary': '#00A3E0',   // Cyan
        'accent': '#00A3E0',      // Cyan para acentos
      },
    },
  },
  plugins: [],
}
