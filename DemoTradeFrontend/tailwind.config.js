/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./src/**/*.{html,ts}",
  ],
  theme: {
    extend: {
      strokeWidth: {
      '4': '4px'},
      colors: {
        'primary': '#14213D',
        'secondary': '#FCA311',
        'back': '#E5E5E5',
      },
    },
  },
  plugins: [],
}

