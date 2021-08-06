module.exports = {
  purge: [
    './storage/framework/views/*.php',
    './resources/views/haribote/*.blade.php',
    //'./resources/**/*.js',
  ],
  darkMode: false, // or 'media' or 'class'

  theme: {
    container: {
      center: true,
    },
  },
  variants: {
    extend: {},
  },
  plugins: [],
}
